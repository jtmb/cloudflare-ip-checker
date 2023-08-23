# Use the official Nginx base image
FROM nginx:alpine

# Set the working directory
WORKDIR /data/cloudflare-ip-checker

# Install necessary packages (curl, jq, php7-fpm, php7-json)
RUN apk update && apk --no-cache add curl jq bash openrc

# Add community repository for PHP packages
RUN echo "http://dl-cdn.alpinelinux.org/alpine/v3.13/community" >> /etc/apk/repositories

# Install PHP packages
RUN apk update && apk --no-cache add php8 php8-fpm php8-opcache

# Copy the scripts to the container
COPY back-end /data/cloudflare-ip-checker/
COPY front-end /var/www/html


# Make the script executable
RUN chmod +x /data/cloudflare-ip-checker/runner.sh /data/cloudflare-ip-checker/entrypoint.sh

# Create log file dir
RUN mkdir /data/logs

# Copy nginx configs into container
ADD back-end/default.conf /etc/nginx/conf.d
COPY back-end/nginx.conf /etc/nginx/nginx.conf
ADD back-end/php.conf /etc/php7/php-fpm.d.www.conf
RUN mkdir /var/run/php-fpm


# Set the script as the entry point
SHELL ["/bin/bash", "-c"]
ENTRYPOINT ["/data/cloudflare-ip-checker/entrypoint.sh"]


