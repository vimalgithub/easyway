<?php
class Connection
{
	private $conn;
	private $host;
	private $username;
	private $password;
	private $database;
	private $port;
	private $debug;
	private $attributes;
    function Connection($params=array()) 
	{
		//error_reporting(0);
		$this->conn = false;
		$this->host ='localhost';
		$this->database ='easyway';		
		$this->username ='root'; 
		$this->password =''; 
		$this->port = '';
		$this->debug = true;
		$attributes=array(
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
		);
		$this->connect();
		session_start();
	}
	function __destruct() 
	{
		//$this->Close();
	}
	function connect() //connection
	{
		if (!$this->conn) {
			try {
				$this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->database.'', $this->username, $this->password, $this->attributes);  			
			}
			catch (Exception $e) {
				die('Error : ' . $e->getMessage());
				echo"Connect Error";
			}
 
			if (!$this->conn) {
				$this->status_fatal = true;
				echo 'Connection failed';
				die();
			} 
			else {
				$this->status_fatal = false;
			}
		}
		return $this->conn;
	}
	function Close() 
	{
		if ($this->conn) {
			$this->conn = null;
		}
	}
	function insert($tablename,$data,$other)
	{
		//$this->conn=parent::connect();		
		$fields = array_keys($data); 		            
		$sql = "INSERT INTO ".$tablename."
		(`".implode('`,`', $fields)."`)
		VALUES('".implode("','", $data)."');"; 		                            
		$prepared=$this->conn->prepare($sql);
		$prepared->execute($data);
		//print_r($prepared->errorInfo());
		//print_r($prepared->errorCode());
		Insertion::page_redirect($other);	
	}
	function deletion($table,$condition,$other)
	{
		$sql="DELETE FROM $table WHERE $condition";
		$result=self::execute($sql);		
		Insertion::page_redirect($other);
		return $result;			
	}
//================================================================================================================	
	function getOne($query) //used to get one from a column for editing purpose
	{
		$result = $this->conn->prepare($query);
		$ret = $result->execute();
		if (!$ret) {
		   /*echo 'PDO::errorInfo():';
		   echo '<br />';
		   echo 'error SQL: '.$query;
		   die();*/
		   return $ret;
		}
		$result->setFetchMode(PDO::FETCH_ASSOC);
		$reponse = $result->fetch();
		
		return $reponse;
	}
//================================================================================================================	
	function getAll($query) //Used to select all the data from one table
	{
		$result = $this->conn->prepare($query);
		$ret = $result->execute();
		if (!$ret)
			{
				/*echo 'PDO::errorInfo():';
		   echo '<br />';
		   echo 'error SQL: '.$query;
		   die();*/
		   return $ret;
		}
		$result->setFetchMode(PDO::FETCH_ASSOC);
		$reponse = $result->fetchAll();
		return $reponse;
	}
//================================================================================================================
	function execute($query) //this is function is used to execute query such as insert update etc.
	{
		if (!$response = $this->conn->exec($query)) {
			/*echo 'PDO::errorInfo():';
		   echo '<br />';
		   echo 'error SQL: '.$query;
		   die();*/
		    //return $ret;
		}
		return $response;
	}
//================================================================================================================
	function data($a)//My function for imploding array in a query manner
	{
	$fields=$a;
	$data="";
	$separator = '';
	foreach($fields as $key=>$value) 
	{
		$data .= $separator . $key . '=\'' . $value; 
		$separator = '\','; 
	}
	
	return $data;
	}

	function update($field,$table,$condition)//update function
	{
		$field=self::data($field);//calling function inside the function
		$field.="'WHERE ";
		$condition=self::data($condition);
		$condition.="'";
		$sql="UPDATE $table set $field $condition";
		$result=self::execute($sql);//calling execute function  
		return  $result;
	}
//================================================================================================================
	function __call($function_name,$arguments)
	{
			if($function_name == 'fetching') {			
				//$arg_num = func_num_args();
				$table=$arguments[0]['table'];
				$condition=$arguments[0]['condition'];							
				switch(count($arguments))
				{
					case 1:		
						$sql="SELECT * FROM $table WHERE $condition";
						$result=self::getAll($sql); 
					break;
					case 2:
						 $sql="SELECT * FROM $table WHERE $condition";
						 $result=self::getOne($sql);
						 print_r($result);
					break;
					case 3:
						$fields=$arguments[0]['fields'];
						//$sql="SELECT $this->fields FROM $this->table WHERE $this->condition";
						$result=self::getOne($sql); 
					break;								
				}
			}
		return $result;			
	}
	
	function file_upload($get_file)
	{
			//$currentDir = getcwd();
			$uploadDirectory = "uploads/";
			
			$errors = []; // Store all foreseen and unforseen errors here
			$fileExtensions = ['jpeg','jpg','png','pdf']; // Get all the file extensions
			$fileName = $_FILES['myfile']['name'];
			$fileSize = $_FILES['myfile']['size'];
			$fileTmpName  = $_FILES['myfile']['tmp_name'];
			$fileType = $_FILES['myfile']['type'];
			$fileExtension = strtolower(end(explode('.',$fileName)));
			//$uploadPath = $currentDir . $uploadDirectory . basename($fileName); 
			$uploadPath = $uploadDirectory . basename($fileName); 

			//if (isset($_POST['submit'])) {

				if (! in_array($fileExtension,$fileExtensions)) {
					$errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
				}

				if ($fileSize > 2000000) {
					$errors[] = "This file is more than 2MB. Sorry, it has to be less than or equal to 2MB";
				}

				if (empty($errors)) {
					$didUpload = move_uploaded_file($fileTmpName, $uploadPath);

					if ($didUpload) {
						echo "The file " . basename($fileName) . " has been uploaded";
					} else {
						echo "An error occurred somewhere. Try again or contact the admin";
					}
				} else {
					foreach ($errors as $error) {
						echo $error . "These are the errors" . "\n";
					}
				}
			//}
		return $uploadPath;
	}

	function page_redirect($other)
	{
		extract($other);
		header("location:$page.php?$message");
	}	
	
}//End Class Connection

class Insertion extends Connection
{
	private $conn;
	function Insertion($tablename,$data,$other)
	{
		//For Future Updation
	}
	function page_redirect($other)
	{
		extract($other);
		header("location:$page.php?$message");
	}	
}
?>
