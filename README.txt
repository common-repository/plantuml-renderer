=== PlantUML Renderer ===
Contributors: toddhalfpenny
Donate link: https://datamad.co.uk/donate/
Tags: plantuml, shortcode, diagram
Requires at least: 3.0.1
Tested up to: 4.9
Stable tag: 0.0.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Insert [PlantUML](http://plantuml.com/) diagrams from their great syntax.

== Description ==

Use [PlantUML](http://plantuml.com/) syntax in shortcodes to have diagrams rendered automatically.

Wrap your PlantUML syntax in our shortcode tags like this, and the PlantUML SaaS will be used to render a lovely diagram.

	[plantuml]
	Alice -> Bob: Authentication Request
	Bob --> Alice: Authentication Response

	Alice -> Bob: Another authentication Request
	Alice <-- Bob: another authentication Response
	[/plantuml]

Easily add all sorts of UML diagrams (Sequence, State, Activity, etc) to your site using the powerful PlantUML syntax.

== Installation ==

1. Upload `plantuml-renderer` zip file to the `/wp-content/plugins/` directory and extract all contents
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Use the `[plantuml]` shortcode and syntax, as per the *Description* section.

== Frequently Asked Questions ==

= What is PlantUML =

PlantUML is a (superb) tool that generates all sorts of UML (and non-UML) diagrams through a descriptive syntax... but better than me trying to tell you about it I recommend you go and [check out their examples](http://plantuml.com/)


= Which Diagram Types are Supported =

All of them, as far as we are aware. But please let us know if you run into any issues

== Screenshots ==

1. Example shortcode use and outputted diagram

== Changelog ==

= 0.0.3 =

* Adding support for links

= 0.0.2 =

Issue seen with double quotes - caused the "alt text" to run into the main content.

= 0.0.1 =

Initial drop

== Upgrade Notice ==

= 0.0.1 =

None... we're super fresh, init.