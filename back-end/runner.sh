#!/bin/bash
# Read the docker environment variables and pass them as arguments
EMAIL="$EMAIL"               # Email for Cloudflare authentication
API_KEY="$API_KEY"           # Cloudflare API Key
ZONE_ID="$ZONE_ID"           # Cloudflare Zone ID
WEBHOOK_URL="$WEBHOOK_URL"   # Discord Webhook URL
PUBLIC_IP=$(curl -s https://api.ipify.org)  # Get the current public IP
DNS_RECORDS=($DNS_RECORDS)   # Array of DNS records to update
REQUEST_TIME="$REQUEST_TIME" # Request time interval in seconds
repo_url="https://github.com/jtmb/clouflare-ip-checker"
DASHBOARD_USER="$DASHBOARD_USER"
DASHBOARD_PASSWORD="$DASHBOARD_PASSWORD"

# Define colors and formatting codes
GREEN="\033[1;32m"
RED="\033[1;31m"
CYAN="\033[1;36m"
BOLD="\033[1m"
WHITE="\033[1;37m"
YELLOW="\033[38;5;220m"
RESET="\033[0m"

# Sleep 1 seconds on app to give services time to start
sleep 1

# Construct the DNS_RECORDS array in JSON format
DNS_RECORDS_JSON="["
for record in "${DNS_RECORDS[@]}"; do
  # Check if the record ends with /0
  if [[ "$record" == */0 ]]; then
    # Remove the trailing /0 and add to DNS_RECORDS_JSON
    modified_record="${record%/0}"
    DNS_RECORDS_JSON+="\"$modified_record\","
  else
    DNS_RECORDS_JSON+="\"$record\","
  fi
done
DNS_RECORDS_JSON=${DNS_RECORDS_JSON%,}  # Remove the trailing comma
DNS_RECORDS_JSON+="]"

# Output ZONE_ID, EMAIL, API_KEY, and REQUEST_TIME to a JSON file
echo '{
  "zone_id": "'"$ZONE_ID"'",
  "email": "'"$EMAIL"'",
  "api_key": "'"$API_KEY"'",
  "discord_webhook": "'"$WEBHOOK_URL"'",
  "DASHBOARD_USER": "'"$DASHBOARD_USER"'",
  "DASHBOARD_PASSWORD": "'"$DASHBOARD_PASSWORD"'",
  "request_time": "'"$REQUEST_TIME"'"
}' > /data/cloudflare-ip-checker/config.json


# Output the DNS_RECORDS_JSON to a file
echo "$DNS_RECORDS_JSON" > /data/cloudflare-ip-checker/dns_records.json

# Make Public IP Consumable by other processes by writting it to environment on run time.(not needed if running supervisor)
# echo "PUBLIC_IP=$PUBLIC_IP" >> /etc/environment

# Welcome message
echo -e "${BOLD}${GREEN}CLOUDFLARE IP CHECKER RUNNING!${RESET}"
echo -e "${WHITE}${BOLD}Repository: ${CYAN}${repo_url}${RESET}"

# Loop Starts
while true; do
  RECORD_UPDATED=false
  UPDATED_RECORDS=()    # Array to store updated or added records

  # Remove duplicate entries and keep only records with the current public IP
  unique_records=()
  for record in "${DNS_RECORDS[@]}"; do
    if ! echo "${unique_records[@]}" | grep -q "$record"; then
      unique_records+=("$record")
    fi
  done

# Check if the webhook URL is reachable
webhook_response=$(curl -s -o /dev/null -w "%{http_code}" "$WEBHOOK_URL")

# Write the result to a JSON file
if [ "$webhook_response" -eq 200 ]; then
  echo '{"webhook_exists": true}' > /data/cloudflare-ip-checker/webhook_status.json
else
  echo '{"webhook_exists": false}' > /data/cloudflare-ip-checker/webhook_status.json
fi

  # Loop through the unique DNS records
  for record in "${unique_records[@]}"; do
    name=$(echo "$record" | cut -d'/' -f1)
    type=$(echo "$record" | cut -d'/' -f2)

    # Set the "proxied" value based on whether the record ends with /0
    if [[ "$record" == */0 ]]; then
        json_payload="{\"type\":\"$type\",\"name\":\"$name\",\"content\":\"$PUBLIC_IP\"}"
    else
        json_payload="{\"type\":\"$type\",\"name\":\"$name\",\"content\":\"$PUBLIC_IP\",\"proxied\":true}"
    fi

    # Retrieve DNS record information from Cloudflare API
    response=$(curl -s -X GET "https://api.cloudflare.com/client/v4/zones/$ZONE_ID/dns_records?type=$type&name=$name" \
      -H "X-Auth-Email: $EMAIL" \
      -H "X-Auth-Key: $API_KEY" \
      -H "Content-Type: application/json")
      # Check if the response indicates success or failure
      if echo "$response" | jq -e '.success' > /dev/null; then
        if [ "$(echo "$response" | jq -r '.success')" == "true" ]; then
          result_json='{"result": true}'
        else
          result_json='{"result": false}'
        fi
      else
        result_json='{"result": false}'
      fi

      # Output the result JSON to a file
      echo "$result_json" > /data/cloudflare-ip-checker/cloudflare_api_status.json

    success=$(echo "$response" | jq -r '.success')

    if [ "$success" == "true" ]; then
      record_id=$(echo "$response" | jq -r '.result[0].id')
      record_ip=$(echo "$response" | jq -r '.result[0].content')
      if [ "$record_id" != "null" ]; then
        if [ "$record_ip" != "$PUBLIC_IP" ]; then
          # Update existing record
          update_response=$(curl -s -X PUT "https://api.cloudflare.com/client/v4/zones/$ZONE_ID/dns_records/$record_id" \
            -H "X-Auth-Email: $EMAIL" \
            -H "X-Auth-Key: $API_KEY" \
            -H "Content-Type: application/json" \
            --data "$json_payload")



          echo -e "[$(date +"%Y-%m-%d %H:%M:%S")] ${RED}${BOLD}DNS Record ${GREEN}$name ($type)${RESET} has changed. ${YELLOW}${BOLD}Updating ...${RESET}"


          echo -e "[$(date +"%Y-%m-%d %H:%M:%S")] ${WHITE}${BOLD}Updated DNS record ${GREEN}$name ($type)${RESET} with new IP: ${WHITE}${BOLD} $PUBLIC_IP${RESET}"

          RECORD_UPDATED=true
          UPDATED_RECORDS+=("$name ($type)")  # Add to the list of updated records
          # Get the current date and time
          update_timestamp=$(date +"%Y-%m-%d %H:%M:%S")
          # Output the update timestamp to a JSON file
          echo "{\"record\": \"$name ($type)\", \"update_timestamp\": \"$update_timestamp\"}" > "/data/cloudflare-ip-checker/updated_records/$name.json"
        else

          echo -e "[$(date +"%Y-%m-%d %H:%M:%S")] ${WHITE}${BOLD}DNS record ${GREEN}$name ($type)${RESET} already up to date with IP: ${WHITE}${BOLD}$PUBLIC_IP${RESET}"

        fi
      else
        # Record doesn't exist, add a new record
        add_response=$(curl -s -o /dev/null -X POST "https://api.cloudflare.com/client/v4/zones/$ZONE_ID/dns_records" \
          -H "X-Auth-Email: $EMAIL" \
          -H "X-Auth-Key: $API_KEY" \
          -H "Content-Type: application/json" \
          --data "$json_payload")
 
        echo -e "[$(date +"%Y-%m-%d %H:%M:%S")] ${WHITE}${BOLD}New Record Detected ! ${GREEN}$name ($type)${RESET} has been ${YELLOW}${BOLD}added to Cloudflare ${RESET} with IP: ${WHITE}${BOLD}$PUBLIC_IP${RESET}"

        RECORD_UPDATED=true
        UPDATED_RECORDS+=("$name ($type)")  # Add to the list of added records
      fi
    else
      errors=$(echo "$response" | jq -r '.errors[].message')

      echo -e "[$(date +"%Y-%m-%d %H:%M:%S")] ${RED}${BOLD}Error ${RESET} checking DNS record ${BOLD}$name${RESET} (${BOLD}$type${RESET}): ${YELLOW}$errors${RESET}"

    fi
  done

  # Construct the list of updated or added records
  RECORD_LIST=""
  for updated_record in "${UPDATED_RECORDS[@]}"; do
    name=$(echo "$updated_record" | cut -d' ' -f1)  # Extract the name part
    RECORD_LIST+="\n- [$name](https://$name/)"  # Construct the URL
  done

# Construct the Discord embed message
EMBED_MESSAGE='{
  "embeds": [{
    "title": "CIC: Service Status Update",
    "description": "💯✅ Your Cloudflare records have been updated !",
    "color": 65280,
    "fields": [
      {
        "name": "New Public IP Adress",
        "value": "'$PUBLIC_IP'"
      },
      {
        "name": "Service URL",
        "value": "'$RECORD_LIST'"
      },
      {
        "name": "Time (America/Toronto)",
        "value": "'$(date +"%Y-%m-%d %H:%M:%S")'"
      }
    ],
    "footer": {
      "text": "'"$repo_url"'"
    }
  }]
}'


  if [ "$RECORD_UPDATED" == true ]; then
    curl -s -H "Content-Type: application/json" -X POST -d "$EMBED_MESSAGE" "$WEBHOOK_URL"


    echo -e "${WHITE}${BOLD}Discord Embed Message${RESET} Sent for:${WHITE}${GREEN} $name${RESET} "

  fi
  
  sleep "$REQUEST_TIME"  # Sleep for the specified time interval before the next loop
  # sed -i '/PUBLIC_IP=/d' /etc/environment #Cleanup Env before next loop in the event IP has changed.
done

