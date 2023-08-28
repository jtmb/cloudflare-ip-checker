<?php
// include 'dist/php/dashboard-auth.php';
?>

<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta19
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Dashboard - Cloudflare IP Checker - Keep your Cloudflare Proxy A records up to date with your current IP!</title>
    <!-- CSS files -->
    <link href="./dist/css/tabler.min.css?1684106062" rel="stylesheet"/>
    <!-- <link href="./dist/css/tabler-flags.min.css?1684106062" rel="stylesheet"/>
    <link href="./dist/css/tabler-payments.min.css?1684106062" rel="stylesheet"/>
    <link href="./dist/css/tabler-vendors.min.css?1684106062" rel="stylesheet"/>
    <link href="./dist/css/demo.min.css?1684106062" rel="stylesheet"/> -->
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
  </head>
  <body >
    <script src="./dist/js/demo-theme.min.js?1684106062"></script>
    <div class="page">
      <!-- Navbar -->
      <header class="navbar navbar-expand-md d-print-none" >
        <div class="container-xl">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href=".">
              <img src="./static/logo.svg" width="110" height="32" alt="Tabler" class="navbar-brand-image">
            </a>
          </h1>
          <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item d-none d-md-flex me-3">
              <div class="btn-list">
                <a href="https://github.com/jtmb/cloudflare-ip-checker" class="btn" target="_blank" rel="noreferrer">
                  <!-- Download SVG icon from http://tabler-icons.io/i/brand-github -->
                  <svg xmlns="https://github.com/jtmb/cloudflare-ip-checker" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 19c-4.3 1.4 -4.3 -2.5 -6 -3m12 5v-3.5c0 -1 .1 -1.4 -.5 -2c2.8 -.3 5.5 -1.4 5.5 -6a4.6 4.6 0 0 0 -1.3 -3.2a4.2 4.2 0 0 0 -.1 -3.2s-1.1 -.3 -3.5 1.3a12.3 12.3 0 0 0 -6.2 0c-2.4 -1.6 -3.5 -1.3 -3.5 -1.3a4.2 4.2 0 0 0 -.1 3.2a4.6 4.6 0 0 0 -1.3 3.2c0 4.6 2.7 5.7 5.5 6c-.6 .6 -.6 1.2 -.5 2v3.5" /></svg>
                  Source code
                </a>
                <a href="https://github.com/sponsors/codecalm" class="btn" target="_blank" rel="noreferrer">
                  <!-- Download SVG icon from http://tabler-icons.io/i/heart -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon text-pink" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" /></svg>
                  Sponsor
                </a>
              </div>
            </div>
            <div class="d-none d-md-flex">
              <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode" data-bs-toggle="tooltip"
		   data-bs-placement="bottom">
                <!-- Download SVG icon from http://tabler-icons.io/i/moon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" /></svg>
              </a>
              <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode" data-bs-toggle="tooltip"
		   data-bs-placement="bottom">
                <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" /></svg>
              </a>
              <div class="nav-item dropdown d-none d-md-flex me-3">
            </div>
            <div class="nav-item dropdown">
              <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                  <span class="avatar avatar-sm" style="background-image: url(./static/avatars/000m.jpg)"></span>
                  <div class="d-none d-xl-block ps-2">
                      <div><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?></div>
                      <div class="mt-1 small text-muted">Dashboard User</div>
                  </div>
              </a>
              <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <a href="#" class="dropdown-item">Feedback</a>
                  <div class="dropdown-divider"></div>
                  <a href="./settings.html" class="dropdown-item">Settings</a>
                  <a href="/index.php?logout=true" class="dropdown-item">Logout</a>
              </div>
          </div>
        </div>      </header>
      <header class="navbar-expand-md">
        <div class="collapse navbar-collapse" id="navbar-menu">
          <div class="navbar">
            <div class="container-xl">
              <ul class="navbar-nav">
                <li class="nav-item active">
                  <a class="nav-link" href="./" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l-2 0l9 -9l9 9l-2 0" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                    </span>
                    <span class="nav-link-title">
                      Home
                    </span>
                  </a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#navbar-help" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/lifebuoy -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M15 15l3.35 3.35" /><path d="M9 15l-3.35 3.35" /><path d="M5.65 5.65l3.35 3.35" /><path d="M18.35 5.65l-3.35 3.35" /></svg>
                    </span>
                    <span class="nav-link-title">
                      Help
                    </span>
                  </a>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="https://github.com/jtmb/cloudflare-ip-checker/blob/master/readme.md#getting-started" target="_blank" rel="noopener">
                      Documentation
                    </a>
                    <a class="dropdown-item" href="https://github.com/jtmb/cloudflare-ip-checker" target="_blank" rel="noopener">
                      Source code
                    </a>
                    <a class="dropdown-item text-pink" href="https://github.com/sponsors/jtmb" target="_blank" rel="noopener">
                      <!-- Download SVG icon from http://tabler-icons.io/i/heart -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-inline me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" /></svg>
                      Sponsor project!
                    </a>
                  </div>
                </li>
              </ul>
        <div class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 order-first order-md-last">
          <form action="./" method="get" autocomplete="off" novalidate>
            <div class="input-icon">
              <span class="input-icon-addon">
                <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                <!-- <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg> -->
                </span>
                <a href="#" id="toggleButton" class="btn">
                    Show Secrets
                </a>
                  </div>
        
    <!-- Page header -->
    </header>
    <div class="page-wrapper">
      <div class="page-header d-print-none">
        <div class="container-xl">
          <div class="row g-2 align-items-center">
            <div class="col">
              <h2 class="page-title">
                Dashboard
              </h2>
            </div>
          </div>
        </div>
      <div class="page-wrapper">
          <!-- Page header End -->

        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl d-flex flex-column justify-content-center">

            <!-- Data Grid -->
            <div class="datagrid">
            <div class="datagrid-item">
              <div class="datagrid-title">Cloudflare authentication</div>
              <?php
                // Read the content of the cloudfalre_api_status file
                $apiStatus = file_get_contents('/data/cloudflare-ip-checker/cloudflare_api_status.json');
                // echo "DEBUG: apiStatus content: $apiStatus<br>"; // Debug output
                
                // Parse the JSON
                $apiStatusJson = json_decode($apiStatus);
                // echo "DEBUG: apiStatusJson: " . print_r($apiStatusJson, true) . "<br>"; // Debug output
                
                // Check if the JSON result is false
                if ($apiStatusJson && isset($apiStatusJson->result) && $apiStatusJson->result === true) {
                  // Update the status color to green
                  echo '<span class="status status-green">Active</span>';
                } else {
                  // Keep the status color as red
                  echo '<span class="status status-red">AUTH ERROR</span>';
                }
              ?>
            </div>

            <div class="datagrid-item">
              <div class="datagrid-title">Discord Webhook</div>
              <?php
                // Read the content of the cloudfalre_api_status file
                $apiStatus = file_get_contents('/data/cloudflare-ip-checker/webhook_status.json');
                // echo "DEBUG: apiStatus content: $apiStatus<br>"; // Debug output
                
                // Parse the JSON
                $apiStatusJson = json_decode($apiStatus);
                // echo "DEBUG: apiStatusJson: " . print_r($apiStatusJson, true) . "<br>"; // Debug output
                
                // Check if the JSON result is false
                if ($apiStatusJson && isset($apiStatusJson->webhook_exists) && $apiStatusJson->webhook_exists === true) {
                  // Update the status color to green
                  echo '<span class="status status-green">Active</span>';
                } else {
                  // Keep the status color as red
                  echo '<span class="status status-red">AUTH ERROR</span>';
                }
              ?>
            </div>
            <div class="datagrid-item">
              <div class="datagrid-title">Public IP</div>
              <div class="datagrid-content hidden">
                <?php
                  $publicIP = file_get_contents('https://api.ipify.org');
                  echo $publicIP;
                ?>
              </div>
            </div>

            <div class="datagrid-item">
              <div class="datagrid-title">Request interval</div>
              <div class="datagrid-content hidden">
                <?php
                // Read and parse the JSON configuration file
                $configJson = file_get_contents('/data/cloudflare-ip-checker/config.json');
                $config = json_decode($configJson, true);

                // Check if zone_id exists in the configuration
                if (isset($config['request_time'])) {
                    $zoneId = $config['request_time'];
                    echo $zoneId;
                } else {
                    echo "Not found in configuration.";
                }
                ?>
            </div>
        </div>

        <div class="datagrid-item">
            <div class="datagrid-title">API KEY</div>
            <div class="datagrid-content hidden">
                <?php
                // Read and parse the JSON configuration file
                $configJson = file_get_contents('/data/cloudflare-ip-checker/config.json');
                $config = json_decode($configJson, true);

                // Check if zone_id exists in the configuration
                if (isset($config['api_key'])) {
                    $zoneId = $config['api_key'];
                    echo $zoneId;
                } else {
                    echo "Not found in configuration.";
                }
                ?>
            </div>
        </div>

      <div class="datagrid-item">
          <div class="datagrid-title">Webhook URL</div>
          <div class="datagrid-content hidden">
              <?php
              // Read and parse the JSON configuration file
              $configJson = file_get_contents('/data/cloudflare-ip-checker/config.json');
              $config = json_decode($configJson, true);

              // Check if discord_webhook exists in the configuration
              if (isset($config['discord_webhook'])) {
                  $webhookUrl = $config['discord_webhook'];
                  $truncatedWebhook = strlen($webhookUrl) > 30 ? substr($webhookUrl, 0, 30) . '...' : $webhookUrl;
                  echo '<span title="' . htmlspecialchars($webhookUrl) . '">' . htmlspecialchars($truncatedWebhook) . '</span>';
              } else {
                  echo "Not found in configuration.";
              }
              ?>
          </div>
      </div>


            <div class="datagrid-item">
            <div class="datagrid-title">Zone ID</div>
            <div class="datagrid-content hidden">
                <?php
                // Read and parse the JSON configuration file
                $configJson = file_get_contents('/data/cloudflare-ip-checker/config.json');
                $config = json_decode($configJson, true);

                // Check if zone_id exists in the configuration
                if (isset($config['zone_id'])) {
                    $zoneId = $config['zone_id'];
                    echo $zoneId;
                } else {
                    echo "Not found in configuration.";
                }
                ?>
            </div>
        </div>

        <div class="datagrid-item">
            <div class="datagrid-title">Email</div>
            <div class="datagrid-content hidden">
                <?php
                // Read and parse the JSON configuration file
                $configJson = file_get_contents('/data/cloudflare-ip-checker/config.json');
                $config = json_decode($configJson, true);

                // Check if zone_id exists in the configuration
                if (isset($config['email'])) {
                    $zoneId = $config['email'];
                    echo $zoneId;
                } else {
                    echo "Not found in configuration.";
                }
                ?>
            </div>
        </div>



            </div>
            <div class="datagrid-item">
            <div class="datagrid-content hidden">
                </span>
              </div>
            </div>
            <div class="datagrid-item">
            </div>
            <!-- Data End -->
            <br></br>

<!-- Card Records Start -->
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Cloudflare Records Tracked 🚀</h3>
  </div>
  <div class="card-body">
    <?php
    $dns_records_json_file = '/data/cloudflare-ip-checker/dns_records.json'; // Update with the actual path to your JSON file
    $dns_records_json = file_get_contents($dns_records_json_file);
    $dns_records = json_decode($dns_records_json);

    // Get the search input
    $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

    // Loop through the DNS records
    foreach ($dns_records as $record) {
      $record_without_type = preg_replace('/\/[A-Za-z]+$/', '', $record);

      $url = "https://$record_without_type";
      $headers = get_headers($url);
      $status_code = intval(substr($headers[0], 9, 3));

      // Get the last update timestamp from the JSON file
      $update_info_file = "/data/cloudflare-ip-checker/updated_records/$record_without_type.json"; // Update with your path
      $update_info = file_get_contents($update_info_file);
      $update_info_json = json_decode($update_info, true);
      $last_update = $update_info_json['update_timestamp'] ?? 'Unknown';

      // Determine the color class based on status code
      $color_class = "";
      if ($status_code === 200) {
        $color_class = "bg-green"; // Green for success
      } elseif ($status_code === 400) {
        $color_class = "bg-red";   // Red for bad request
      } else {
        $color_class = "bg-yellow"; // Yellow for unknown
      }

      // Check if the current record matches the search term
      if (stripos($record_without_type, $searchTerm) !== false) {
        echo '<div class="card">';
        echo '<div class="card-status-start ' . $color_class . '"></div>'; // Apply color class
        echo '<div class="card-body">';
        echo "<h3 class='card-title'>A RECORD: $record_without_type ";

        if ($status_code === 200) {
          echo "<span class='badge bg-green-lt'>200 OK</span>";
        } elseif ($status_code === 400) {
          echo "<span class='badge bg-red-lt'>400 Bad Request</span>";
        } else {
          echo "<span class='badge bg-yellow-lt'>UNKNOWN</span>";
        }

        echo "</h3>";
        echo "<a href='$url'>$record_without_type</a>";
        echo "<p>Last Update: $last_update</p>"; // Display the last update timestamp
        echo '</div>';
        echo '</div>';
        echo '<br></br>';
      }
    }
    ?>
  </div>
</div>
<!-- Card Records End -->
          </div>
        </div>




       <!-- Page body end -->
        </div>
      </div>
        <footer class="footer footer-transparent d-print-none">
          <div class="container-xl">
            <div class="row text-center align-items-center flex-row-reverse">
              <div class="col-lg-auto ms-lg-auto">
                <ul class="list-inline list-inline-dots mb-0">
                  <li class="list-inline-item"><a href="https://github.com/jtmb/cloudflare-ip-checker/blob/master/readme.md#getting-started" target="_blank" class="link-secondary" rel="noopener">Documentation</a></li>
                  <li class="list-inline-item"><a href="https://github.com/jtmb/cloudflare-ip-checker/blob/master/LICENSE" class="link-secondary">License</a></li>
                  <li class="list-inline-item"><a href="https://github.com/jtmb/cloudflare-ip-checker" target="_blank" class="link-secondary" rel="noopener">Source code</a></li>
                  <li class="list-inline-item">
                    <a href="https://github.com/sponsors/jtmb" target="_blank" class="link-secondary" rel="noopener">
                      <!-- Download SVG icon from http://tabler-icons.io/i/heart -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon text-pink icon-filled icon-inline" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" /></svg>
                      Sponsor
                    </a>
                  </li>
                </ul>
              </div>
              <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                <ul class="list-inline list-inline-dots mb-0">
                  <li class="list-inline-item">
                    Copyright Cloudflare IP Checker; 2023
                    <a href="." class="link-secondary">jtmb</a>.
                    All rights reserved.
                  </li>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="./dist/js/get-records.js" defer></script>    
    <script src="./dist/js/tabler.min.js?1684106062" defer></script>
    <script src="./dist/js/demo.min.js?1684106062" defer></script>
    <script src="./dist/js/reveal-secrets.js" defer></script>
  </body>
</html>
