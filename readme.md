<h1 align="center">
  <a href="https://github.com/jtmb">
    <img src="https://avatars.githubusercontent.com/u/86915618?v=4" alt="Logo" width="125" height="125">
  </a>
</h1>

<div align="center">
  <b>Cloudflare IP Checker</b> - Keep your cloudflare proxy records automatically updated!
  <br />
  <br />
  <a href="https://github.com/jtmb/ip_check/issues/new?assignees=&labels=bug&title=bug%3A+">Report a Bug</a>
  ·
  <a href="https://github.com/jtmb/ip_check/issues/new?assignees=&labels=enhancement&template=02_FEATURE_REQUEST.md&title=feat%3A+">Request a Feature</a>
  .
  <a href="https://hub.docker.com/repository/docker/jtmb92/cloudflare_ip_checker/general">Docker Hub</a>
</div>
<br>
<details open="open">
<summary>Table of Contents</summary>

- [About](#about)
  - [Prerequisites](#prerequisites)
- [Getting Started](#getting-started)
  - [Prerequisites](#prerequisites)
    - [Docker image](#docker-image)
    - [Running on docker](#running-on-docker)
    - [Running on docker-compose](#running-on-docker-compose)
    - [Running on docker swarm](#running-on-docker-swarm)
- [Environment Variables explained](#environment-variables-explained)
- [Contributing](#contributing)
- [License](#license)

</details>
<br>

---

### <h1>About</h1>

An Alpine-based microservice within Docker, designed to seamlessly manage and update Cloudflare records whenever a change is detected in your publicly-facing internet IP address.

This solution proves invaluable for those who self-host using a dynamic IP address, ensuring the uninterrupted integrity of their Cloudflare DNS records.

### Highlighted Features:

- <span style="color:#57AD98"><b>Streamlined addition of monitored A records</b></span> in cases of accidental removal.
- <span style="color:#FA8072"><b>Automatic identification of changes in forward-facing IP</b></span>, facilitating the prompt update of A records with the new IP address.
- <span style="color:#9E57DA"><b>User-friendly customization</b></span> achieved through a concise set of environment variables.
- <span style="color:#7289d9"><b>Integration with Discord</b></span> for simple alert notifications.
- <span style="color:#CD5C5C"><b>Fast</b></span> - API request total time on average is less than a second.
- <span style="color:#FFA500"><b>lightweight</b></span>- Alpine Container keeps the image size bellow 20 megabytes.
- <span style="color:green"><b>Scaleable</b></span> - Built with scale in mind, docker swarm compatiable.


## Prerequisites

- Docker installed on your system
- A Discord webhook url
- A Cloudflare API Key
- The ZONE ID for your Cloudflare instance

### <h2>Getting Started</h2>
### [Docker Image](https://hub.docker.com/r/jtmb92/cloudflare_ip_checker)
```docker
 docker pull jtmb92/cloudflare-ip-checker
```
### Running on docker
A simple docker run command gets your instance running. 
```docker
    docker run --name ip-checker-container \
    -e EMAIL="your-email@example.com" \
    -e API_KEY="your-cloudflare-api-key" \
    -e ZONE_ID="your-cloudflare-zone-id" \
    -e WEBHOOK_URL="your-discord-webhook-url" \
    -e DNS_RECORDS="my.site.com/A site.com/A" \
    -e REQUEST_TIME_SECONDS=120 \
    jtmb92/cloudflare-ip-checker
```
### Running on docker-compose
Run on docker compose (this is the reccomened way) by running the command "docker compose up -d"
```yaml
    version: '3.8'

    services:
    ip-checker:
        image: jtmb92/cloudflare-ip-checker
        environment:
          EMAIL: 'your-email@example.com'
          API_KEY: 'your-cloudflare-api-key'
          ZONE_ID: 'your-cloudflare-zone-id'
          WEBHOOK_URL: 'your-discord-webhook-url'
          DNS_RECORDS: 'my.site.com/A site.com/A'
          REQUEST_TIME_SECONDS: '120'
```

### Running on docker-compose with custom dockerfile
Simmilar to the above example, the key difference here being we are running with the build: arg insteead of the image: arg. 
This "." essentually builds the docker image from a local dockerfile located in the root directory of where the docker compose up -d command was ran.
```yaml
    version: '3.8'

    services:
    ip-checker:
        build: .
        environment:
          EMAIL: 'your-email@example.com'
          API_KEY: 'your-cloudflare-api-key'
          ZONE_ID: 'your-cloudflare-zone-id'
          WEBHOOK_URL: 'your-discord-webhook-url'
          DNS_RECORDS: 'my.site.com/A site.com/A'
          REQUEST_TIME_SECONDS: '120'
```
### Running on swarm
**Meant for advanced users**
example using the loki driver to ingress logging over a custom docker network, while securely passing in ENV vars.
```yaml
    version: "3.8"
    services:
    cloudflare-ip-checker:
        image: "jtmb92/cloudflare_ip_checker"
        restart: always
        networks:
            - container-swarm-network
        environment:
            API_KEY:  ${cf_key}
            ZONE_ID: ${cf_zone_id}
            WEBHOOK_URL: ${discord_webook}
            DNS_RECORDS: 'my.site.com/A site.com/A'
            REQUEST_TIME_SECONDS: "120"
            EMAIL: ${email}
        deploy:
        replicas: 1
        placement:
            max_replicas_per_node: 1
        logging:
        driver: loki
        options:
            loki-url: "http://localhost:3100/loki/api/v1/push"
            loki-retries: "5"
            loki-batch-size: "400"
    networks:
    container-swarm-network:
        external: true
```

## Environment Variables explained

The following environment variables are used to configure and run the Cloudflare IP Checker script:
```yaml
    EMAIL: 'your-email@example.com'
```  
Your Cloudflare account email address. This is used to authenticate with the Cloudflare API.
```yaml
    API_KEY: 'your-cloudflare-api-key'
```     
Your Cloudflare API key. This key is required for making authenticated requests to the Cloudflare API.
```yaml
    ZONE_ID: 'your-cloudflare-zome-id'
```      
The ID of the Cloudflare DNS zone where your records are managed. This identifies the specific zone to update.
```yaml
    WEBHOOK_URL: 'https://discord.com/api/webhooks/<redacted>/<redacted>'
```     
The URL of your Discord webhook. This is where notifications will be sent when IP changes are detected.
```yaml
    DNS_RECORDS: 'my.site.com/A site.com/A' #example of multiple list format entries
```      
 A space-separated list of Cloudflare DNS records in the format "name/type". These records will be checked and updated if necessary.
```yaml
    REQUEST_TIME_SECONDS: '120' #amount of time in seconds between next set of API requests. 
```    
The time in seconds to wait between IP checks. This determines the interval at which the script checks for IP changes.

- ** <b>Make sure to provide the appropriate values for these variables when running the Docker container. This information is crucial for the script to function correctly.</b>

## Contributing

First off, thanks for taking the time to contribute! Contributions are what makes the open-source community such an amazing place to learn, inspire, and create. Any contributions you make will benefit everybody else and are **greatly appreciated**.

Please try to create bug reports that are:

- _Reproducible._ Include steps to reproduce the problem.
- _Specific._ Include as much detail as possible: which version, what environment, etc.
- _Unique._ Do not duplicate existing opened issues.
- _Scoped to a Single Bug._ One bug per report.

You can use [markdownlint-cli](https://github.com/igorshubovych/markdownlint-cli) to check for common markdown style inconsistency.

## License

This project is licensed under the **GNU GENERAL PUBLIC LICENSE v3**. Feel free to edit and distribute this template as you like.

See [LICENSE](LICENSE) for more information.

