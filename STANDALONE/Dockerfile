# Use the official Alpine base image
FROM alpine:latest

# Set the working directory
WORKDIR /data/cloudflare-ip-checker

# Install necessary packages (curl and jq)
RUN apk --no-cache add curl jq bash

# Copy the scripts to the container
COPY runner.sh /data/cloudflare-ip-checker/runner.sh
COPY entrypoint.sh /data/cloudflare-ip-checker/entrypoint.sh

# Make the script executable
RUN chmod +x /data/cloudflare-ip-checker/runner.sh /data/cloudflare-ip-checker/entrypoint.sh

# Create log file dir
RUN mkdir /data/logs

# Set the script as the entry point
SHELL ["/bin/bash", "-c"]
ENTRYPOINT ["/data/cloudflare-ip-checker/entrypoint.sh"]