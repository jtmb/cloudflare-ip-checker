#!/bin/bash

# Start nginx
/etc/init.d/php-fpm7 start
nginx -g 'daemon off;'

# Export Plublic IP from /data/cloudflare-ip-checker/runner.sh to esnure public IP is checked every time script re-loops
PUBLIC_IP="PUBLIC_IP"

# Set logs and Run application (sed -r) exits  the special characters in the stdout so you can get clean logs 
                        #  (tee) pushes the logs to specified log file while still maintaining output in terminal
/data/cloudflare-ip-checker/runner.sh > >(tee >(sed -r "s/\x1B\[[0-9;]*[JKmsu]//g" > /data/logs/cloudflare-ip-checker.log))
