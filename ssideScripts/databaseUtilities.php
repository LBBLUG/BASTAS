<?php

// this script holds database connection utility classes

// SECURITY CHECK
// We do this here becauase we do not want anyone accessing this file directly.
// It should only be accessed if done so through an include or require statement
if(count(get_included_files()) ==1)
{
	header('HTTP/1.0 403 Forbidden');
	exit("Direct access not permitted.");
}

// FUNCTIONALITY 

class DatabaseUtility
{
	private $conn;
	private $connected;

	function __construct()
	{
		$ini_array = parse_ini_file("php/src_files/config/config.php");
		$ServerAddress = $ini_array['ServerName'];
		$Username = $ini_array['Username'];
		$Password = $ini_array['Password'];
		$Database = $ini_array['Database'];

		if (empty($ServerAddress) || empty($Database) || empty($Username)|| empty($Password))
		{
			die("Database configuration file not set up.");
		}

		$this->conn = new mysqli($ServerAddress, $Username, $Password, $Database);

		if ($this->conn->connect_error)
		{
			die("Connection failed: " . $this->conn->connect_error);
		}
		$this->connected = true;
	}

	public function ExecuteStoredProcedure($storedProcedureNameString, $storedProcedureParametersArray)
	{
		$queryString = $this->BuildQueryString($storedProcedureNameString, $storedProcedureParametersArray);

		$statement = $this->conn->prepare($queryString);

		if ( !$statement ) {
		    printf('Error:</br>errno: %d,</br>error: %s', $this->conn->errno, $this->conn->error);
		    die;
		}

		if (isset($storedProcedureParametersArray) && is_array($storedProcedureParametersArray))
		{
			$refArrayParamValues = array();
			$refArrayParamOne = "";
			foreach ($storedProcedureParametersArray as $param) {
				$refArrayParamOne = $refArrayParamOne . $param->ParamType;
			}

			foreach ($storedProcedureParametersArray as $param) {
				array_push($refArrayParamValues, $param->ParamValue);
			}
			// This is kind of magic. We use reflection here so we can pass 
			// in a dynamic number of stored precedure parameters 
			// This trick is brought to you by http://php.net/manual/en/mysqli-stmt.bind-param.php
			$ref    = new ReflectionClass('mysqli_stmt'); 
			$refArr = array_merge(array($refArrayParamOne), $refArrayParamValues);
			$method = $ref->getMethod("bind_param"); 
			$method->invokeArgs($statement,$refArr);
		}

		// Execute the procedure like normal
		$statement->execute();

		// Convert statement into an array of arrays so we can use this 
		// outside of this method and close this statement object.
		$result = $this->FetchResults($statement);

		$statement->close();

		return $result;
	}

	private function BuildQueryString($storedProcedureNameString, $storedProcedureParametersArray)
	{
		$queryString = "CALL " . $storedProcedureNameString . "(";
		if (isset($storedProcedureParametersArray) && is_array($storedProcedureParametersArray))
		{
			for ($i; $i < count($storedProcedureParametersArray); $i++)
			{
				$queryString = $queryString . "?";
				if ($i !== count($storedProcedureParametersArray) - 1)
				{
					$queryString = $queryString . ", ";
				}
			}
		}
		$queryString = $queryString . ")";
		return $queryString;
	}

	private function FetchResults($result)
	{    
		// Returns an array of arrays. Looks like:
		// arrayTable(
		// 		$arrayRow
		// 			$key => $value
		// 			$key => $value
		// 			...
		// 		$arrayRow
		// 			$key => $value
		// 			$key => $value
		// 			...
		// 		...
		// 		)


		// Found in comment section of http://php.net/manual/en/mysqli-stmt.bind-result.php
	    $array = array();
	    
	    if($result instanceof mysqli_stmt)
	    {
	        $result->store_result();
	        
	        $variables = array();
	        $data = array();
	        $meta = $result->result_metadata();
	        
	        while($field = $meta->fetch_field())
	            $variables[] = &$data[$field->name]; // pass by reference
	        
	        call_user_func_array(array($result, 'bind_result'), $variables);
	        
	        $i=0;
	        while($result->fetch())
	        {
	            $array[$i] = array();
	            foreach($data as $k=>$v)
	                $array[$i][$k] = $v;
	            $i++;
	            
	            // don't know why, but when I tried $array[] = $data, I got the same one result in all rows
	        }
	    }
	    elseif($result instanceof mysqli_result)
	    {
	        while($row = $result->fetch_assoc())
	            $array[] = $row;
	    }
	    
	    return $array;
	}

	function __destruct() {
		if (isset($this->conn) && $this->conn instanceof mysqli)
		{
        	$this->conn->close();
        	if ($this->conn->connect_error)
			{
				die("Disconnect failed: " . $this->conn->connect_error);
			}
		}

		$this->connected = false; 
   	}
}

class StoredProcedureParameter
{
	public $ParamType;
	public $ParamValue;
	// $type is defined using the table under the "Parameters" heading at http://php.net/manual/en/mysqli-stmt.bind-param.php
	function __construct($type, $value)
	{
		$this->ParamType = $type;
		$this->ParamValue = $value;
	}
}
?>