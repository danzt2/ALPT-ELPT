<?php
/**
 * MyAccount.php provides both the Controller and View layers for
 * users managing their accounts
 *
 * PHP version 5
 *
 * @author    John M. Stokes <jstokes@heartofthefyre.us>
 * @copyright 2011 Verizon Wireless Inc.
 * @license   Verizon internal use only
 */
error_reporting(E_ALL);
 
require_once ABSOLUTEPATH.'/classes/AppPage.class.php';
require_once 'MyAccount.class.php';

//Instantiate the page and MyAccount objects
try {
	$MyAccountPage = new AppPage('My Account', 'MY ACCOUNT');
	$Acct = new MyAccount();
}
catch (Exception $e) {
	echo '<p class="errorMsg">'.$e->getMessage().'</p>';
}

$body = '';

//Remember where the user accessed this page from
$thisPage = (empty($_SERVER['HTTPS'])?'http':'https').'://'. $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
if (!empty($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != $thisPage ) {
	$_SESSION['MyAccount_Referrer'] = $_SERVER['HTTP_REFERER'];
}

//If the user has submitted changes on the form, process it
$action = '';
if (isset($_GET['do']))
	$action = strip_tags($_GET['do']);
	
//Respond to the user's request
switch ($action) {
	case 'updateAccount':
		try {
			$Acct->updateUserAccount();
			$body .= '<p class="successMsg">Your changes have been saved.</p>';
		}
		catch (Exception $e) {
			$body .= '<p class="errorMsg">'.$e->getMessage().'</p>';
		}

		if (!empty($_SESSION['MyAccount_Referrer']))
			header("Location: ".$_SESSION['MyAccount_Referrer']);
		else
			header("Location: ".basename(__FILE__));
		exit;
	case 'logout': 
		try {
			$MyAccountPage->logout();
		}
		catch (Exception $e) {
			$body .= '<p class="errorMsg">'.$e->getMessage().'</p>';
		}
		header("Location: ".basename(__FILE__));
		exit;
}//Close switch

//Get the user's latest data
try {
	$regions = $Acct->getRegions();
	$user = $Acct->getUserAccount();
}
catch (Exception $e) {
	$body .= '<p class="errorMsg">'.$e->getMessage().'</p>';
}

//Display the account editing form
$CSS = '
<style type="text/css">
	hgroup.pageTitle h1 {clear: none; width: 95%;}
	#myAccountForm {margin: 0 auto; width: 780px;}
	fieldset {float: left; margin: 0 0 0.5em 8px; width: 100%;}
	input[name=email] {width: 300px;}
	.successMsg, .errorMsg {clear: none; margin-top: 1em;}
	.myAccount {width: 700px;}
	.myAccount .first {width: 200px;}
	.myAccount .second, .myAccount .third {width: 245px;}
	#modified {font-size: 10px; text-align: right; width: 100%}
	#myAccountLogout { float: right; margin-bottom: 0.5em;}
</style>
<!--[if IE ]>
 <style type="text/css">
 	ul.pseudoTable li {margin-bottom: 0 !important;}
</style>
<![endif]-->

';


$body .= '
<form method="post" id="myAccountForm" name="myAccountForm" action="MyAccount.php?do=updateAccount">
<fieldset>
<legend>Contact Information</legend>
<ul class="myAccount pseudoTable">
<li><ul>
	<li class="first">Username:</li>
	<li class="second">'.$user['username'].'</li>
</ul></li>
<li><ul>
	<li class="first">Name:</li>
	<li class="second"><input type="text" name="firstName" value="'.$user['FirstName'].'" /><br /><em>First</em></li>
	<li class="third"><input type="text" name="lastName" value="'.$user['LastName'].'" /><br /><em>Last</em></li>
</ul></li>
<li><ul>
	<li class="first">Email:</li>
	<li class="second"><input type="email" id="email" name="email" value="'.$user['Email'].'" /></li>
</ul></li>
<li><ul>
	<li class="first">Office Phone:</li>
	<li class="second"><input type="text" name="officePhone" value="'.$user['OfficePhone'].'" /></li>
</ul></li>
<li><ul>
	<li class="first">Mobile Phone:</li>
	<li class="second"><input type="text" name="mobilePhone" value="'.$user['MobilePhone'].'" /></li>
</ul></li>
<li><ul>
	<li class="first">Region:</li>
	<li class="second">
		<select id="regionID" name="regionID">
			<option value="0">-- Region --</option>';
foreach ($regions as $region) {
	$selected = '';
	if ((int)$user['regionID'] === (int)$region['XNG_ID'])
		$selected = 'selected="selected"';
	$body .= "\n\t\t\t<option value=\"{$region['XNG_ID']}\" $selected>{$region['region']}</option>";
}
$body .= '
		</select>
	</li>
</ul></li>
</ul>
</fieldset>

<p class="center"><br /><input type="submit" value="Save Changes" class="VZbutton" /></p>

</form>

<form method="post" id="myAccountLogout" name="myAccountLogout" action="MyAccount.php?do=logout">
  <div><input type="submit" value="Logout" class="VZbutton" /></div>
</form>';

//Display the page object
$MyAccountPage->setStyle($CSS);
$MyAccountPage->setBody($body);
$MyAccountPage->display();