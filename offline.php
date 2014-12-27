<?php
/*
Plugin Name: Offline
Plugin URI: https://geek.hellyer.kiwi/products/offline/
Description: Offline
Author: Ryan Hellyer
Version: 1.0.2
Author URI: https://geek.hellyer.kiwi/

Copyright (c) 2014 Ryan Hellyer


This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License version 2 as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
license.txt file included with this plugin for more information.

*/


/**
 * Primary class
 * 
 * @copyright Copyright (c), Ryan Hellyer
 * @license http://www.gnu.org/licenses/gpl.html GPL
 * @author Ryan Hellyer <ryanhellyer@gmail.com>
 * @package Comic Glot
 * @since Comic Glot 1.0
 */
class Offline_Cache {


	/**
	 * Class constructor.
	 */
	public function __construct() {

		add_action( 'template_redirect',  array( $this, 'buffer_manifest' ) );
		add_action( 'init',               array( $this, 'display_manifest' ) );

	}

	/**
	 * Display the cache manifest file.
	 * Called via callback from output buffer.
	 * 
	 * @param string $content
	 * @return string
	 */
	public function display_manifest() {

		// If not manifest page or user is logged in, then bail out now
		if ( ! isset( $_GET['manifest'] ) || is_user_logged_in() ) {
			return;
		}

		// If cache is empty, then bail out now
		if ( '' == get_transient( 'mc_' . $_GET['manifest'] ) ) {
			return;
		}

		// Add the page header
		header( 'Content-Type: text/cache-manifest' );

		// Declare this is a cache manifest
		echo "CACHE MANIFEST\n";

		$urls = get_transient( 'mc_' . $_GET['manifest'] );

		// Output each URL
		foreach( $urls as $url ) {
			echo esc_url( $url ) . "\n";
		}
		echo "\n";

		// Add time stamp
		echo '# Post ID: ' . get_the_ID() . "\n";
		echo '# Time stamp: ' . date( 'l jS \of F Y h:i:s A' );
		exit;

	}

	/**
	 * Get the current page URL
	 * 
	 * @return  string   The current page URL
	 */
	public function get_current_url() {

		$url = 'http';
		if ( is_ssl() ) {
			$url .= 's';
		}
		$url .= '://';

		$url .= $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

		return $url;
	}

	/**
	 * Buffer the page so that we can obtain the URLs needed to build the manifest.
	 * We need to use output buffering to needing some way to work out what URLs are
	 * used on the page.
	 */
	public function buffer_manifest() {

		// Don't bother caching logged in users
		if ( is_user_logged_in() || isset( $_GET['manifest'] ) ) {
			return;
		}

		ob_start( array( $this, 'process_manifest' ) );
	}

	/**
	 * Callback for output buffer
	 * Filters URLs
	 * 
	 * @param   string   $content
	 * @return  string
	 */
	public function process_manifest( $content ) {

		// Make sure we cache the current page URL
		$urls_to_cache[] = $this->get_current_url();

		// Obtain all URLs which need cached
		$doc = new DOMDocument();
		@$doc->loadHTML( $content ); // This throws non-stop errors if you give it bad HTML. Due to this problem, I decided to suppress all of these errors. If you can guarantee that only good HTML is sent to the parser, then you could remove the "@" symbol, but most sites do have a sloppy HTML, so this is kinda necessary unfortunately.
		$xpath = new DOMXpath( $doc );

		$tags = array(
			'link'   => 'href',
			'script' => 'src',
			'img'    => 'src',
		);

		$ignore = array(
			'rel'  => 'pingback',
			'rel'  => 'profile',
			'type' => 'application/rss+xml',
		);

		// Loop through each type of HTML tag
		foreach( $tags as $tag => $attribute ) {

			$nodes = $xpath->query( '//' . $tag );

			foreach( $nodes as $node ) {

				// Some irrelevant things may as well be ignored
				if (
					'pingback' != $node->getAttribute( 'rel' )
					&&
					'profile' != $node->getAttribute( 'rel' )
					&&
					'application/rsd+xml' != $node->getAttribute( 'type' )
					&&
					'application/rss+xml' != $node->getAttribute( 'type' )
					&&
					'application/wlwmanifest+xml' != $node->getAttribute( 'type' )
					&&
					'wlwmanifest' != $node->getAttribute( 'rel' )
					&&
					'shortlink' != $node->getAttribute( 'rel' )
					&&
					'canonical' != $node->getAttribute( 'rel' )
				) {
					$url = $node->getAttribute( $attribute );
					$pos = strpos( $url, home_url() );
					if ( $pos === false ) {
						// string needle NOT found in haystack
					} else {
						// string needle found in haystack
						$urls_to_cache[] = $url;
					}
				}
			}
		}

		// Apply filter - can be used by plugins for adding extra features to filter
		$urls_to_cache = apply_filters( 'offline_cache', $urls_to_cache );

		set_transient( 'mc_' . md5( $this->get_current_url() ), $urls_to_cache, 10 ); // Stash the URLs in a temporary cache

		// Add Manifest attribute
		$url = home_url() . '?manifest=' . md5( $this->get_current_url() );
		$content = str_replace( '<html ', '<html manifest="' . esc_url( $url ) . '" ', $content );

		return $content;
	}

}
new Offline_Cache;
