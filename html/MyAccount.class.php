<?php
/**
 * MyAccount.php provides the MVC Model layer for
 * users managing their accounts on the area server
 *
 * PHP version 5
 *
 * @author    John M. Stokes <jstokes@heartofthefyre.us>
 * @copyright 2011 Verizon Wireless Inc.
 * @license   Verizon internal use only
 */

class MyAccount {

	private $PDO; //object. An instance of the PHP Data Objects class.

	/**
	 * __construct calls the parent constructor, which
	 * connects to the database
	 */
	public function __construct() {
		$this->PDO = getPDO('People');
	}//Close __construct


	/**
	 * getRegions returns available regions with their numeric IDs
	 *
	 * @return array $resultSet - the list of regions
	 */
	public function getRegions() {
		$SQL = 'SELECT id, XNG_ID, region FROM Locations.Regions';
		try {
			$SQL = $this->PDO->query($SQL);
			$resultSet = $SQL->fetchAll(PDO::FETCH_ASSOC);
		}
		catch (PDOException $e) {
			throw new Exception('Error on line '.$e->getLine().': '.$e->getMessage());
		}
		return $resultSet;
	}//End getRegions


	/**
	 * getUserAccount returns account info for the currently logged in user
	 *
	 * @return array $resultSet[0] - the user's data
	 */
	public function getUserAccount() {
		if (!isset($_SESSION['username']))
			throw new Exception('No user session found. Please log in.');

		$SQL = 'SELECT * FROM Users WHERE username=:username';

		try {
			$SQL = $this->PDO->prepare($SQL);
			if (!$SQL->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR)) //bindParam and execute don't throw exceptions, so do it for them
				throw new PDOException('Error binding parameters.');

			if (!$SQL->execute())
				throw new PDOException('Error executing SQL statement.');
	
			$row = $SQL->fetch(PDO::FETCH_ASSOC);
		}
		catch (PDOException $e) {
			throw new Exception('Error on line '.$e->getLine().': '.$e->getMessage());
		}

		return $row;
	}//End getUserAccount


	/**
	 * updateUserAccount saves changes to a user account in the database
	 *
	 * @param array $_POST - the form data submitted by the user
	 *
	 * @return void
	 */
	public function updateUserAccount() {
		if (!isset($_SESSION['username']))
			throw new Exception('No user session found. Please log in.');

		//Sanitize the data
		$FirstName = strip_tags($_POST['firstName']);
		$LastName = strip_tags($_POST['lastName']);
		$email = strip_tags($_POST['email']);
		$officePhone = strip_tags($_POST['officePhone']);
		$mobilePhone = strip_tags($_POST['mobilePhone']);

		//Save changes to the database
		$SQLtext = "UPDATE BasicData SET
		FirstName = :firstName,
		LastName = :lastName
		WHERE username = :username";

		$error = false;
		try {
			$SQL = $this->PDO->prepare($SQLtext);
			$error = $error || !$SQL->bindParam(':firstName', $FirstName, PDO::PARAM_STR);
			$error = $error || !$SQL->bindParam(':lastName', $LastName, PDO::PARAM_STR);
			$error = $error || !$SQL->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);

			if ($error) {//bindParam and execute don't throw exceptions, so do it for them
				$errorArray = $SQL->errorInfo();
				throw new Exception('Error binding parameters: '.$errorArray[2]);
			}
			if (!$SQL->execute()) {
				$errorArray = $SQL->errorInfo();
				throw new Exception('Error executing SQL statement: '.$errorArray[2]);
			}
		}//Close try
		catch (PDOException $e) {
			throw new Exception('Error on line '.$e->getLine().': '.$e->getMessage());
		}

		
		$SQLtext = 'UPDATE ContactInfo SET
		regionID=:regionID,
		Email=:email,
		OfficePhone=:officePhone,
		MobilePhone=:mobilePhone
		WHERE username=:username';
		try {
			$SQL = $this->PDO->prepare($SQLtext);
			$error = $error || !$SQL->bindParam(':regionID', $_POST['regionID'], PDO::PARAM_INT);
			$error = $error || !$SQL->bindParam(':email', $email, PDO::PARAM_STR);
			$error = $error || !$SQL->bindParam(':officePhone', $officePhone, PDO::PARAM_STR);
			$error = $error || !$SQL->bindParam(':mobilePhone', $mobilePhone, PDO::PARAM_STR);
			$error = $error || !$SQL->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);

			if ($error) {//bindParam and execute don't throw exceptions, so do it for them
				$errorArray = $SQL->errorInfo();
				throw new Exception('Error binding parameters: '.$errorArray[2]);
			}

			if (!$SQL->execute()) {
				$errorArray = $SQL->errorInfo();
				throw new Exception('Error executing SQL statement: '.$errorArray[2]);
			}
		}//Close try
		catch (PDOException $e) {
			throw new Exception('Error on line '.$e->getLine().': '.$e->getMessage());
		}
		
		//Reset the user's region in case they changed it
		$_SESSION['regionID'] = (int)$_POST['regionID'];

		return;
	}//End updateUserAccount

}//End MyAccount class
