WARNING: THIS SOFTWARE WILL BE SOMEWHAT UNSTABLE FOR THE NEXT FEW WEEKS!

=== Offline cache ===
Contributors: ryanhellyer
Tags: offline, cache, manifest, caching, html5, appcache, manifest-cache
Donate link: https://geek.hellyer.kiwi/donate/
Requires at least: 4.7
Tested up to: 4.9
Stable tag: 2.0


Modern browsers include offline caching functionality. The Offline cache plugin for WordPress allows you to easily implement this.


== Description ==

Websites typically require an internet connection to work. Modern browsers do however include offline caching functionality via their cache manifest functionality. It is possible to set a website to cache itself inside the browser when loaded, so that if you need to revisit the page when it is offline, you may do so.

The Offline cache plugin for WordPress allows you to easily implement this functionality on your own website.

<strong><a href="http://offline-demo.hellyer.kiwi/">View demo</a></strong> | <strong><a href="https://github.com/ryanhellyer/offline/archive/master.zip">Download the Offline WordPress plugin</a></strong>


== Installation ==

After you've downloaded and extracted the files:

1. Upload the complete 'offline' folder to the '/wp-content/plugins/' directory OR install via the plugin installer
2. Activate the plugin through the 'Plugins' menu in WordPress
4. And yer done!

If you would like every publicly visible page or post (doesn't include archives) to be cached whenever someone visits any page on your site, please add the following to your <code>wp-config.php</code> file <code>define( 'OFFLINE_CACHE_EVERYTHING', true );</code>.

Support for Application Cache is deprecated on insecure origins, so you should use https.

Note that the plugin does not cache files which are referenced within other files. So for example, images referenced within CSS or JS files do not get cached. There is a filter <code>offline_cache</code> which can be used for adding additional files if necessary (requires some coding knowledge to use).

Server must be able to do http request to itself.

This plugin will only cache the first 100 pages it finds.

Logged in users are never cached. To cache a page, the user must log out of WordPress first.

Visit the <a href="https://geek.hellyer.kiwi/products/offline/">Offline Plugin page</a> for more information, or checkout <a href="http://offline-demo.hellyer.kiwi/">the offline demo</a>.


== Frequently Asked Questions ==

= But how can you view  a web page if you aren't online??? =
Well you can with this plugin ;) You just need to visit the page at least once.

= How do I make it download my whole site? =
That is not currently possible with the current iteration of the plugin, but it is theoretically possible. Implementing this into a generic plugin is quite tricky, hence I haven't added that functionality into this iteration. I have added a filter to the 

= Why are only some pages/files are caching? =
That's probably because you have hit the cache limit of your device. Different browser/device combinations have different limits on how much content you can store in the cache.


= Where's the plugin settings page? =

There isn't one.


= Does it work in older versions of WordPress? =

Probably, but I only actively support the latest version of WordPress. Support for older versions is purely by accident.


= I need custom functionality. Can we pay you to build it for us? =

No, I'm too busy. Having said that, if you are willing to pay me a small fortune then I could <a href="https://ryan.hellyer.kiwi/contact/">probably be persuaded</a>. I'm also open to suggestions for improvements, so feel free to send me ideas and if you are lucky, it may be added for free :)

== Changelog ==

Version 1.0: Initial release (25/12/2014)<br />
Version 1.0.1: Bug fixes (26/12/2014)<br />
Version 1.0.2: Bug fixes (27/12/2014)<br />
Version 1.1: Ignoring wp-json links and security hardening (25/01/2017)<br />
Version 2.0: Caching whole site instead of individual pages (01/02/2017)<br />


= Credits =

<a href="https://geek.hellyer.kiwi/">Just me</a> so far. But if anyone helps out, I'll happily add a link to them here :)
