# Use the official Alpine base image
FROM alpine:latest

# Set the working directory
WORKDIR /data/cloudflare-ip-checker

# Install necessary packages (curl and jq)
RUN apk --no-cache add curl jq bash git

# Copy the script to the container
RUN git clone https://github.com/jtmb/clouflare-ip-checker.git /data/cloudflare-ip-checker

# Make the script executable
RUN chmod +x /data/cloudflare-ip-checker/runner.sh

# Cleanup 
RUN apk del git

# Set the script as the entry point
SHELL ["/bin/bash", "-c"]
ENTRYPOINT ["/data/cloudflare-ip-checker/runner.sh"]
