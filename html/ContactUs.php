<?php
/**
 * ContactUs.php provides contact information for the Area team
 *
 * PHP version 5
 *
 * @author    John M. Stokes <jstokes@heartofthefyre.us>
 * @copyright 2011 Verizon Wireless
 * @license   Verizon internal use only
 */
 
require_once ABSOLUTEPATH.'/classes/AppPage.class.php';

try {
	$page = new AppPage('Contact Us', 'CONTACT US');
}
catch (Exception $e) {
	echo '<p style="color: #FF0000; text-align: center; width: 100%">'.$e->getMessage().'</p>';
}

$CSS = '
	<style type="text/css">
		#ContactList {float: left; font-size: 14px; margin: 2em 0 2em 10px; width: 100%;}
		.pageTitle {color: #AA0000; text-align: center; width: 100%;}
		#names, #email {float: left; margin: 0 2%; width: 45%;}
		#names {height: 140px;}
		#names li {color: #0000AA; text-align: right;}
		#email {height: 82px; padding-top: 18px;}
		#email a {color: #AA0000;}
		#email a:hover {text-decoration: underline;}
	</style>
';

$body = '
<section id="ContactList">
	<h1 class="center">Contact the Team</h1>

	<div id="names">
		<ul>
			<li>Jack Sparrow</li>
			<li>Indiana Jones</li>
			<li>Amy Farrah Fowler</li>
		</ul>
	</div><!-- close names -->

	<div id="email">
		<a href="mailto:nowhere@VerizonWireless.com">
			nowhere@VerizonWireless.com
		</a>
	</div><!-- close email -->
</section><!-- close ContactList -->';

$page->setStyle($CSS);
$page->setBody($body);
$page->display();