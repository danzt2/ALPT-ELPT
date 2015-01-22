<?php
/**
 * Example index page using the web page class
 *
 * PHP version 5
 *
 * @author    John M. Stokes <jstokes@heartofthefyre.us>
 * @copyright 2014 Verizon Wireless
 * @license   Verizon internal use only
 */

/** All web pages should extend BasePage.class.php. AppPage is an example of such a page class. **/
require_once ABSOLUTEPATH.'/classes/AppPage.class.php';

/** STEP 1: Instantiate the page object. This includes a security check. **/
try {
	$page = new AppPage('West Area', 'WELCOME');
}
catch (Exception $e) {
	echo '<p style="color: #FF0000; text-align: center; width: 100%">'.$e->getMessage().'</p>';
}

/** STEP 2 (Optional): Create any page-specific CSS and add it to the page **/
$css = '
	<style type="text/css">
		.contentcontainer .center {margin: 1em auto;}
	</style>
';
$page->setStyle($css);

/** STEP 3 (Optional): Create any page-specific Javascript and add it to the page **/
$page->setScript('');

/** STEP 4: Create the page content and add it to the page. This can often be handled by a Model and View in the MVC pattern **/
$body = '<h2 class="center">*** Start Page ***</h2>';
$body .= '
	<p class="center">
		We recommend you read the following documents to better understand this web site\'s code base.<br />
		<ul class="center">
			<li><a href="/documents/OOP%20Web%20Dev.pdf">Object-Oriented Web Development with PHP</a></li>
			<li><a href="/documents/ImplementationNotes.docx">Framework Implementation Details</a></li>
		</ul>
	</p>';
$page->setBody($body);

/** STEP 5: Output the completed page **/
$page->display();
