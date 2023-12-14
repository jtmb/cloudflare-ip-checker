#!/bin/bash
# Read the docker environment variables and pass them as arguments
EMAIL="james.branco@gmail.com"                   # Email for Cloudflare authentication
API_KEY="1139f10df58af8f107c34b7a2e82effe12656"  # Cloudflare API Key
ZONE_ID="53092409b9e2a417c3af37656b48ce64"       # Cloudflare Zone ID
WEBHOOK_URL="https://discord.com/api/webhooks/1036677023084576768/zK2zbQr48qx8mn5OLQcTbUDtmRASoAH2XLVT1erlCW4unFr-2RGmt_4a2ps2-CyKY6jk"  # Discord Webhook URL
PUBLIC_IP=$(curl -s https://api.ipify.org)       # Get the current public IP
DNS_RECORDS=("jtmb.cc/A" "lucinda.jtmb.cc/A" "aplb.jtmb.cc/A" "santos.jtmb.cc/A" "mcweb.jtmb.cc/A" "test.jtmb.cc/A/0")  # Array of DNS records to update
REQUEST_TIME_SECONDS="10"                        # Request time interval in seconds
repo_url="https://github.com/jtmb/clouflare-ip-checker"
record_id=mcweb.jtmb.cc/A

curl -s -X PUT "https://api.cloudflare.com/client/v4/zones/$ZONE_ID/dns_records/$record_id" \
            -H "X-Auth-Email: $EMAIL" \
            -H "X-Auth-Key: $API_KEY" \
            -H "Content-Type: application/json" \
            --data "$json_payload"