=== Action Network Events ===
Author: Debt Collective
Author URI: https://debtcollective.org
Contributors: misfist
Tags: action network, events, synchronization
Requires at least: 5.8
Tested up to: 5.8
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: dc-events-manager

Synchronize Action Network events with your website.

== Description ==
Synchronize Action Network events with your website.

== Action Network Integration ==

= Action Network API Documentation =
https://actionnetwork.org/docs/v2/

= Action Network Event Fields Being Used =
action_network:id
title
browser_url
start_date 
end_date
status 	        One of ["confirmed" "tentative" "cancelled"]
created_date
modified_date
location
visibility 	    One of ["public" "private"]
action_network:hidden

= Action Network Webhooks =
We're not able to make use of the API's webhooks (as of v2) because they're only triggered for actions related to people / participation, but not actions directly.