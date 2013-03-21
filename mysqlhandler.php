<?php

/*Created by Christoffer Kjeldgaard, all rights reserved. 
 * 
 *------------------HOW TO USE MYSQLHANDLER.PHP---------------- 
 *__construct: opens connection to MySQL server. 
 *function multiquery: Performs multiquery on database.
 *function printer: prints out whatever is in row[pos]. 
 *function close: closes connection. 
 *
 *-------------------------Examples----------------------------
 *$db = new MySQLHandler('host', 'user', 'password', 'database');
 *$result = $db->multiquery($db, "SELECT * from student;");
 *$db->close();
 */
Class MySQLHandler extends mysqli {

	public function __construct($host,$user,$passw,$db) {
		parent::__construct($host,$user,$passw,$db);
		
		if (mysqli_connect_error()) {
			die('Connect error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
			echo "Error occured!";
		}
	
	}
	/*
	 *multiquery
	 *--PARAMS
	 *db:		valid mySQL connection.
	 *query:	one or more string queries separated by ;
	 *
	 *--RETURN
	 *resultset from db->store_result();	 
	 */
	
	public function multiquery($db, $query) {
		//remember to connect first!! or things will go bad. 
		//Perform multi query - remember that each query must be seperated by ';', otherwise things will go bad.   
		$db->multi_query($query);
		$result = $db->store_result();
		if($result){
			$row = $result->fetch_row();}	
	    return $row;
		
	}	
	
	/*
	 * printer
	 * --PARAMS
	 * db: 		active, and valid mySQL connection. 
	 * result:	resultset from db->store_result();
	 * pos:		coloumn position (int), that should be printed. 
	 * 
	 * --RETURNS
	 * nothing
	 */
	public function printer($db, $result, $pos){
		do {		
			//check that the result is valid. This could be done externally in controller. Should probably be moved out
			if($result) {
				//Result is valid. lets get the rows.
				while($row = $result->fetch_row()){
					//This while runs as long as there is still rows to get from the current query.
					//do something with the row here. eg print it with:
					printf("%s\n", $row[$pos]);
				}
				//Now there is no more rows to handle. lets free the result to make room for the next result:
				$result->free();
			}
			//now lets make sure to seperate the queries from eachother. We do this by checking more_results()
			if($result->more_results()){
				printf("---------\n");
			}
		} while($db->next_result());
	}
	
	/*
	 * closes connection. 
	 */
	public function close()
	{
		parent::close();
	}
}
?>