#!/bin/bash
# Read the docker environment variables and pass them as arguments
EMAIL="$EMAIL"               # Email for Cloudflare authentication
API_KEY="$API_KEY"           # Cloudflare API Key
ZONE_ID="$ZONE_ID"           # Cloudflare Zone ID
WEBHOOK_URL="$WEBHOOK_URL"   # Discord Webhook URL
PUBLIC_IP=$(curl -s https://api.ipify.org)   # Get the current public IP
DNS_RECORDS=($DNS_RECORDS)   # Array of DNS records to update
REQUEST_TIME_SECONDS="$REQUEST_TIME_SECONDS" # Request time interval in seconds

while true; do
  PUBLIC_IP=$(curl -s https://api.ipify.org)   # Get the current public IP
  OLD_PUBLIC_IP="$PUBLIC_IP"
  IP_CHANGED=false
  RECORD_UPDATED=false

  # Remove duplicate entries and keep only records with current public IP
  unique_records=()
  for record in "${DNS_RECORDS[@]}"; do
    if ! echo "${unique_records[@]}" | grep -q "$record"; then
      unique_records+=("$record")
    fi
  done

  # Loop through the unique DNS records
  for record in "${unique_records[@]}"; do
    name=$(echo "$record" | cut -d'/' -f1)
    type=$(echo "$record" | cut -d'/' -f2)

    # Retrieve DNS record information from Cloudflare API
    response=$(curl -s -X GET "https://api.cloudflare.com/client/v4/zones/$ZONE_ID/dns_records?type=$type&name=$name" \
      -H "X-Auth-Email: $EMAIL" \
      -H "X-Auth-Key: $API_KEY" \
      -H "Content-Type: application/json")

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
            --data "{\"type\":\"$type\",\"name\":\"$name\",\"content\":\"$PUBLIC_IP\",\"proxied\":true}")
          
          echo "Updated DNS record $name ($type) with new IP: $PUBLIC_IP"
          RECORD_UPDATED=true
        else
          echo "DNS record $name ($type) already up to date with IP: $PUBLIC_IP"
        fi
      else
        # Record doesn't exist, add new record
        add_response=$(curl -s -X POST "https://api.cloudflare.com/client/v4/zones/$ZONE_ID/dns_records" \
          -H "X-Auth-Email: $EMAIL" \
          -H "X-Auth-Key: $API_KEY" \
          -H "Content-Type: application/json" \
          --data "{\"type\":\"$type\",\"name\":\"$name\",\"content\":\"$PUBLIC_IP\",\"ttl\":120,\"proxied\":true}")
        
        echo "Added new DNS record $name ($type) with IP: $PUBLIC_IP"
        RECORD_UPDATED=true
      fi
    else
      errors=$(echo "$response" | jq -r '.errors[].message')
      echo "Error checking DNS record $name ($type): $errors"
    fi
  done

  # Check if IP address has changed
  if [ "$PUBLIC_IP" != "$OLD_PUBLIC_IP" ]; then
    echo "IP address has changed to $PUBLIC_IP from $OLD_PUBLIC_IP | Services will be updated"
    OLD_PUBLIC_IP="$PUBLIC_IP"
    IP_CHANGED=true
  fi

  # Send Discord webhook notification if IP changed or record updated
  MESSAGE="beep boop - Your Public IP has changed to $PUBLIC_IP - Cloudflare DNS Records have been updated."
  if [ "$IP_CHANGED" == true ] || [ "$RECORD_UPDATED" == true ]; then
    curl -H "Content-Type: application/json" -X POST -d "{\"content\":\"$MESSAGE\"}" "$WEBHOOK_URL"
  fi

  sleep $REQUEST_TIME_SECONDS  # Sleep for the specified time interval before the next loop
done
