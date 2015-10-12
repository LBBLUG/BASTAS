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
	private $exceptionOccured;
	private $exceptionMessage;

	public function GetExceptionOccured()
	{
		return $this->exceptionOccured;
	}

	public function GetExceptionMessage()
	{
		return $this->exceptionMessage;
	}

	function __construct()
	{
		mysqli_report(MYSQLI_REPORT_STRICT);
		$this->connected = false;
		$this->exceptionOccured = false;

		$ini_array = parse_ini_file("php/src_files/config/config.php");
		$ServerAddress = $ini_array['ServerAddress'];
		$Username = $ini_array['Username'];
		$Password = $ini_array['Password'];
		$Database = $ini_array['Database'];

		if (empty($ServerAddress) || empty($Database) || empty($Username)|| empty($Password))
		{
			echo "Database configuration file not set up.";
			//die("Database configuration file not set up.");
		}

		$this->conn = new mysqli($ServerAddress, $Username, $Password, $Database);
		
		if ($this->conn->connect_error)
		{
			$this->exceptionMessage =  "Connection failed: " . $this->conn->connect_error;
			$this->exceptionOccured = true;
			return;
		}
		$this->connected = true;
	}

	public function ExecuteStoredProcedure($storedProcedureNameString)
	{
		$storedProcedureParametersArray = array_slice(func_get_args(), 1);

		// Validated parameters supplied.
		if (isset($storedProcedureParametersArray) && 
			is_array($storedProcedureParametersArray) && 
			count($storedProcedureParametersArray) > 0) 
		{
			foreach ($storedProcedureParametersArray as $value) {
				if (!$value instanceof StoredProcedureParameter) {
					$this->exceptionOccured = true;
					$this->exceptionMessage = "The stored procedure parameters passed into ExecuteStoredProcedure must be of type 'StoredProcedureParameter'.";
					return null;
				}
			}
		}

		if(!isset($storedProcedureNameString) || substr($storedProcedureNameString, -strlen("()")) === "()")
		{
			$this->exceptionOccured = true;
			$this->exceptionMessage = "The stored procedure name in ExecuteStoredProcedure is required and must not end with '()'.";
			return null;
		}

		$queryString = $this->BuildQueryString($storedProcedureNameString, $storedProcedureParametersArray);

		$statement = $this->conn->prepare($queryString);

		if ( !$statement ) {
		    $this->exceptionMessage = "Error:</br>errno: " . $this->conn->errno . ",</br>error: " . $this->conn->error;
			$this->exceptionOccured = true;
		    return null;
		}

		if (isset($storedProcedureParametersArray) &&
			is_array($storedProcedureParametersArray) && 
			count($storedProcedureParametersArray) > 0)
		{
			$refArrayParamValues = array();
			$refArrayParamOne = "";
			foreach ($storedProcedureParametersArray as $param) 
			{
				$refArrayParamOne = $refArrayParamOne . $param->ParamType;
			}

			// Set first param by ref
			$refArrayParamValues[0] = &$refArrayParamOne;

			$i = 1;
			foreach ($storedProcedureParametersArray as $param) 
			{
				$refArrayParamValues[$i] = &$param->ParamValue;
				$i++;
			}
			// This is kind of magic. We use reflection here so we can pass 
			// in a dynamic number of stored precedure parameters 
			// This trick is brought to you by http://php.net/manual/en/mysqli-stmt.bind-param.php
			$ref    = new ReflectionClass('mysqli_stmt'); 
			$method = $ref->getMethod("bind_param"); 
			$method->invokeArgs($statement, $refArrayParamValues);
			//call_user_func_array(array($statement, 'bind_param'), $this->refValues($refArr));
		}

		// Execute the procedure like normal
		$statement->execute();

		// See if the statement executed without error.
		if (isset($statement->error) && $statement->error !== "")
		{
			$this->exceptionMessage = "Error:</br>error: " . $statement->error;
			$this->exceptionOccured = true;
			return null;
		}

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
			$i = 0;
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
	    
	    if($result instanceof mysqli_stmt && $result->field_count > 0)
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
				$this->exceptionOccured = true;
				$this->exceptionMessage = "Disconnect failed: " . $this->conn->connect_error;
				return;
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
		// i	corresponding variable has type integer
		// d	corresponding variable has type double
		// s	corresponding variable has type string
		// b	corresponding variable is a blob and will be sent in packets
		if ($type !== "i" && 
			$type !== "d" && 
			$type !== "s" && 
			$type !== "b") 
		{
			throw new Exception("StoredProcedureParameter's constuctor's first parameter must be a 'i', 'd', 's', or 'b'.", 1);
		}
		$this->ParamType = $type;
		$this->ParamValue = $value;
	}
}
?>