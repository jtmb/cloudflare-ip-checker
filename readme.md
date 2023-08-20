<h1 align="center">
  <a href="https://github.com/dec0dOS/amazing-github-template">
    <img src="{{cookiecutter.repo_slug}}/docs/images/logo.svg" alt="Logo" width="125" height="125">
  </a>
</h1>

<div align="center">
  Amazing GitHub Template - Sane defaults for your next project!
  <br />
  <br />
  <a href="https://github.com/dec0dOS/amazing-github-template/issues/new?assignees=&labels=bug&template=01_BUG_REPORT.md&title=bug%3A+">Report a Bug</a>
  ·
  <a href="https://github.com/dec0dOS/amazing-github-template/issues/new?assignees=&labels=enhancement&template=02_FEATURE_REQUEST.md&title=feat%3A+">Request a Feature</a>
  .
  <a href="https://github.com/dec0dOS/amazing-github-template/discussions">Ask a Question</a>
</div>
<br>
<details open="open">
<summary>Table of Contents</summary>

- [About](#about)
  - [Prerequisites](#prerequisites)
- [Getting Started](#getting-started)
  - [Prerequisites](#prerequisites)
  - [Usage](#usage)
    - [Cookiecutter template](#cookiecutter-template)
    - [Manual setup](#manual-setup)
    - [Variables reference](#variables-reference)
- [Roadmap](#roadmap)
- [Contributing](#contributing)
- [Support](#support)
- [License](#license)
- [Acknowledgements](#acknowledgements)

</details>
<br>

---

### <h1>About</h1>

A docker alpine based microservice that automates updating of cloudflare records when it detects that your internet public forwards facing IP has changed.

Useful for self hosters on a dynamic IP adress that wish to keep their cloudflare DNS records from going down. 

-  Features the ability to add monitored A records if they have been removed
-  Automatic detection of forward facing IP Change that updates A records with new IP address
-  Simple and customizable through a few enviorment variables
-  Support for aleting through discord

## Prerequisites

- Docker installed on your system
- A Discord webhook url
- A Cloudflare API Key
- The ZONE ID for your Cloudflare instance

### <h2>Getting Started</h2>
### Running on docker
A simple docker run command gets your instance running. 

    docker run --name ip-checker-container \
    -e EMAIL="your-email@example.com" \
    -e API_KEY="your-cloudflare-api-key" \
    -e ZONE_ID="your-cloudflare-zone-id" \
    -e WEBHOOK_URL="your-discord-webhook-url" \
    -e PUBLIC_IP="your-public-ip" \
    -e DNS_RECORDS="my.site.com/A site.com/A" \
    -e REQUEST_TIME_SECONDS=120 \
    jtmb92/cloudflare-ip-checker
### Running on docker-compose
Run on docker compose (this is the reccomened way) by running the command "docker compose up -d"

    version: '3.8'

    services:
    ip-checker:
        image: jtmb92/cloudflare-ip-checker
        environment:
        - EMAIL=your-email@example.com
        - API_KEY=your-cloudflare-api-key
        - ZONE_ID=your-cloudflare-zone-id
        - WEBHOOK_URL=your-discord-webhook-url
        - PUBLIC_IP=your-public-ip
        - DNS_RECORDS=my.site.com/A site.com/A
        - REQUEST_TIME_SECONDS=120

### Running on docker-compose with custom dockerfile
Simmilar to the above example, the key difference here being we are running with the build: arg insteead of the image: arg. 
This "." essentually builds the docker image from a local dockerfile located in the root directory of where the docker compose up -d command was ran.

    version: '3.8'

    services:
    ip-checker:
        build: .
        environment:
        - EMAIL=your-email@example.com
        - API_KEY=your-cloudflare-api-key
        - ZONE_ID=your-cloudflare-zone-id
        - WEBHOOK_URL=your-discord-webhook-url
        - PUBLIC_IP=your-public-ip
        - DNS_RECORDS=my.site.com/A site.com/A
        - REQUEST_TIME_SECONDS=120

### Running on swarm
**Meant for advanced users**
example using the loki driver to ingress logging over a custom docker network, while securely passing in ENV vars.

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


## Environment Variables explained

The following environment variables are used to configure and run the Cloudflare IP Checker script:

    EMAIL: your-email@example.com
    
Your Cloudflare account email address. This is used to authenticate with the Cloudflare API.

    API_KEY: 
    
Your Cloudflare API key. This key is required for making authenticated requests to the Cloudflare API.

    ZONE_ID: 
    
The ID of the Cloudflare DNS zone where your records are managed. This identifies the specific zone to update.

    WEBHOOK_URL: 
    
The URL of your Discord webhook. This is where notifications will be sent when IP changes are detected.


    DNS_RECORDS:

 A space-separated list of Cloudflare DNS records in the format "name/type". These records will be checked and updated if necessary.

    REQUEST_TIME: 

The time in seconds to wait between IP checks. This determines the interval at which the script checks for IP changes.

- ** Make sure to provide the appropriate values for these variables when running the Docker container. This information is crucial for the script to function correctly.

