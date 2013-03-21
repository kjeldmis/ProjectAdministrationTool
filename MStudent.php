<?php

require 'mysqlhandler.php';
class MStudent{
	/* ----- TODO ------
	 * function for error handling.    
	 */
	public $name;
	public $ID;
	public $email;
	public $skype;
	public $mobil;
	public $isLoaded;
	
	/*
	 * construct does nothing at the moment. use create() or load() instead. 
	 */
	function __construct()
	{
		$this->isLoaded = FALSE;
	}
	
	
	/*
	 * Creates new student and inserts it into mySQL database. 
	 * ---PARAMS
	 * name:	student name (string)
	 * mobil:	student cell (string)
	 * email:	student email (string)
	 * skype:	student skype contact info (string)
	 */
	function create($name, $mobil, $email, $skype){
		if(!$isLoaded){
			$db = new MySQLHandler('localhost', 'root', 'jyh69egz', 'ProjectAdministrationTool');
			$db->multiquery($db, 'INSERT INTO student (studentName, email, mobil, skype) 
							      VALUES ("'.$name.'", "'.$email.'", "'.$mobil.'", "'.$skype.'")');
			$db->close();
			$this->name = $name; $this->email = $email; $this->mobil = $mobil; $this->skype = $skype; $this->isLoaded = TRUE;}
	}
	
	/*
	 * loads a student from db. 
	 * ---PARAMS
	 * ID:	valid studentID. 
	 * ---RETURNS
	 * a student 
	 */
	function load($id){
		$db = new MySQLHandler('localhost', 'root', 'jyh69egz', 'ProjectAdministrationTool');
		$row = $db->multiquery($db, "SELECT studentName, email, mobil, skype FROM student WHERE studentID = $id");
		$db->close();
		//LOAD parameters into student object.
		if($row){
			$this->ID = $id; $this->name = $row[0]; $this->email = $row[1]; $this->mobil = $row[2]; $this->skype = $row[3];
			$this->isLoaded = TRUE;
			$this->printer($row[0], $row[1], $row[2], $row[3]);
			return "success";
		}
		print "error: invalid ID"; 
	}
	
	/*
	 * getID - returns studentID, if found.  
	 * ---PARAMS
	 * key:		search parameter (string)
	 * value:	search string (string)
	 * ---RETURNS
	 * resultset from db->store_result() - or "error" if the resultset is empty.
	 */
	function getID($key, $value){
		//key is search parameter.
		$db = new MySQLHandler('localhost', 'root', 'jyh69egz', 'ProjectAdministrationTool');
		if ($key == "name"){
			$row = $db->multiquery($db, 'SELECT studentID FROM student WHERE studentName = "'.$value.'"');}
			
		if ($key == "email"){
			$row = $db->multiquery($db, 'SELECT studentID FROM student WHERE email = "'.$value.'"');}
			
		if ($key == "mobil"){
			$row = $db->multiquery($db, 'SELECT studentID FROM student WHERE mobil = "'.$value.'"');}
			
		if ($key == "skype"){
			$row = $db->multiquery($db, 'SELECT studentID FROM student WHERE skype = "'.$value.'"');}
			
		$db->close();
		if ($row){
			return $row;
		}
		print("error:" . $db->error);
		
	}
	
   /*
	* updateSkype - updates Skype, if this->isLoaded is TRUE.
	* ---PARAMS
	* $id:		studentID from db - see getID to fetch ID from db.
	* $skype:	new skype value.
	*/
	function updateSkype($id, $skype){
		if(!$this->isLoaded){
			$this->load($id);}
		
		if($this->isLoaded){
			$db = new MySQLHandler('localhost', 'root', 'jyh69egz', 'ProjectAdministrationTool');
			$db->multiquery($db, "UPDATE student SET skype = '$skype' WHERE studentID = $id");
			$this->skype = $skype;}
	}
	
   /*
	* updateEmail - updates email address, if this->isLoaded is TRUE.
	* ---PARAMS
	* $id:		studentID from db - see getID to fetch ID from db.
	* $email:	new email value.
	*/
	function updateEmail($id, $email){
		if(!$this->isLoaded){
			$this->load($id);}
		
		if($this->isLoaded){
			$db = new MySQLHandler('localhost', 'root', 'jyh69egz', 'ProjectAdministrationTool');
			$db->multiquery($db, "UPDATE student SET email = '$email' WHERE studentID = $id");
			$this->email = $email;}
	}
	
	
   /*
	* updateMobil - updates mobil, if this->isLoaded is TRUE.
	* ---PARAMS
	* $id:		studentID from db - see getID to fetch ID from db.
	* $email:	new mobil value.
	*/
	function updateMobil($id, $mobil){
		if(!$this->isLoaded){
			$this->load($id);}
			
		if($this->isLoaded){
			$db = new MySQLHandler('localhost', 'root', 'jyh69egz', 'ProjectAdministrationTool');
			$db->multiquery($db, "UPDATE student SET mobil = '$mobil' WHERE studentID = $id");
			$this->mobil = $mobil;}
	}

   /*
	* updateName - updates name, if this->isLoaded is TRUE.
	* ---PARAMS
	* $id:		studentID from db - see getID to fetch ID from db.
	* $name:	new name value.
	*/
	function updateName($id,$name){
		if(!$this->isLoaded){
			$this->load($id);}
		
		if($this->isLoaded){
			$db = new MySQLHandler('localhost', 'root', 'jyh69egz', 'ProjectAdministrationTool');
			$db->multiquery($db, "UPDATE student SET studentName = '$name' WHERE studentID = $id");
			$this->name = $name;}
	}
	
	/*printer - prints out student --- DEBUGGING ONLY!
	 * 
	 */
	function printer($name,$email,$mobil,$skype){
		print "Student: $name, $email, $mobil, $skype";}
}

/* ---------TESTING AREA---------*/
/*------PUT unittests here!------*/

?>