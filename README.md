# Fix cURL errors in Local by Flywheel
WordPress MU Plugin to fix broken requests to REST API and cron jobs in Local by Flywheel.

## Background
When using SSL in a WordPress development environment provided by Local by Flywheel (previously Pressmatic), requests to `http` endpoints from within WordPress fail with cURL Error 7 because of how the site is proxied. This plugin fixes this by forcing `http` on secured sites.

See https://local.getflywheel.com/community/t/wp-cron-not-working-on-secured-sites/147/2 for discussion and original code for the `cron_request` filter.

## Installation
1. Clone the repo locally and copy or symlink the file into your site's `wp-content\mu-plugins` directory.
2. You can also pull the file in directly with `curl` or `wget`, or just copy and paste into your own plugin or theme file.
