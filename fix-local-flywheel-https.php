<?php
/*
Plugin Name: Fix Local SSL Requests
Plugin URI: https://local.getflywheel.com/community/t/wp-cron-not-working-on-secured-sites/147/2
Description: Makes WordPress URLs non-secure for certain SSL requests.
Version: 1.0.0
Author: Morgan Estes
Author URI: https://morganestes.com
License: GPLv2 or later
*/

namespace Morgan_Estes\Fix_Local_HTTPS;

/**
 * Forces non-SSL REST API URLs in development environments.
 *
 * Fix just for Local by Flywheel, which doesn't provide container-level SSL.
 *
 * @since    1.0.0
 * @link     https://local.getflywheel.com/community/t/wp-cron-not-working-on-secured-sites/147/2
 * @internal Fires on 'rest_url' filter.
 *
 * @param string $url     REST URL.
 * @param string $path    REST route.
 * @param int    $blog_id Blog ID.
 * @param string $scheme  Sanitization scheme.
 * @return string The (maybe) filtered REST URL with 'http' scheme.
 */
function make_rest_url_http( $url, $path, $blog_id, $scheme ) {
	if ( is_ssl() ) {
		$url = set_url_scheme( $url, 'http' );
	}

	return $url;
}

add_filter( 'rest_url', __NAMESPACE__ . '\\make_rest_url_http', 10, 4 );

/**
 * Forces non-SSL site URLs in development environments.
 *
 * Fix just for Local by Flywheel, which doesn't provide container-level SSL.
 *
 * @since    1.0.0
 * @link     https://local.getflywheel.com/community/t/wp-cron-not-working-on-secured-sites/147/2
 * @internal Fires on 'cron_request' filter.
 *
 * @param array  $cron_request_array {
 *      An array of cron request URL arguments.
 *
 *      @type string $url  The cron request URL.
 *      @type int    $key  The 22 digit GMT microtime.
 *      @type array  $args               {
 *          An array of cron request arguments.
 *
 *          @type int  $timeout   The request timeout in seconds. Default .01 seconds.
 *          @type bool $blocking  Whether to set blocking for the request. Default false.
 *          @type bool $sslverify Whether SSL should be verified for the request. Default false.
 *     }
 * }
 * @param string $doing_wp_cron The unix timestamp of the cron lock.
 * @return array The (maybe) filtered cron request with 'http' URL scheme.
 */
function make_cron_url_http( $cron_request_array, $doing_wp_cron ) {
	if ( is_ssl() ) {
		$cron_request_array['url'] = set_url_scheme( $cron_request_array['url'], 'http' );
	}

	return $cron_request_array;
}

add_filter( 'cron_request', __NAMESPACE__ . '\\make_cron_url_http', 10, 2 );
