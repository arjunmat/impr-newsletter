=== Plugin Name ===
Contributors: mathai
Donate link: http://improvi.in/donate
Tags: newsletter, signup, list
Requires at least: 3.0.1
Tested up to: 4.1
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A simple AJAX-based plugin to allow users to sign up for your newsletters.

== Description ==

This plugin shows your users a text box where they can enter their email addresses. The email addresses are validated and stored
into a CSV file which can be used for mailing lists later.

== Installation ==

1. Upload the directory `impr-newsletter` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `<?php echo do_shortcode('[impr_newsletter class="<your-class>" btn_text="<your-button-text>" text="<your-section-heading>" placeholder="<your-email-textbox-placeholder>"]'); ?>` in your templates after changing the appropriate variables

== Frequently Asked Questions ==

= Does the plugin validate the email address entered? =

Yes, it does.

= Does the plugin store the email addresses into a database? =

No, we currently do not. This is because the email addresses are mostly used for importing into mailing lists softwares, such as MailChimp, CampaignMonitor, etc
and having it as a CSV is easier than using a database.

= Can I customize the look and feel? =

Yes, you can set parameters such as a class, placeholder text, button text, and the heading section when invoking the shortcode and override the styling in your style.css.

= Where do I go to get the list of subscribed email addresses? =

Navigate to Settings > Improvi Newsletter Signups and click on the Download CSV link.

== Screenshots ==

1. Default View
2. Successful subscription
3. Email Validation

== Changelog ==

= 1.0 =
* Initial version

== Upgrade Notice ==

= 1.0 =
Initial Version