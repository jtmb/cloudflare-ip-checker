# About:

This playbook aims modularizes updating an A record on cloudflare. This helps when you have a dynamic public IP that changes every couple of months.
    *this playbook also sends out a discord notification, notifying you of the IP change.


## REQUIRED VARS:

        cf_key:             # the cloudflare api key
        cf_zone_id:         # the cloudflare zone id
        discord_webhook:    # the discord webhook url
        a_name_record:      # the dns a record to target