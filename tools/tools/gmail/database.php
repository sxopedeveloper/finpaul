<?php
$db = mysqli_connect("127.0.0.1", "root", "", "token_db");
// $db = mysqli_connect( "109.73.228.248", "mycarquo_master", "McQ@yoU0854", "mycarquo_master" );

if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	exit();
}

function insert_db( $data, $table )
{
	$conn = new mysqli( "127.0.0.1", "root", "", "token_db" );
	// $db = mysqli_connect( "109.73.228.248", "mycarquo_master", "McQ@yoU0854", "mycarquo_master" );
	
	if ($conn->connect_error)
	{
		die("Connection failed: " . $conn->connect_error);
	}

	$sql = "INSERT IGNORE INTO ".$table."(".implode(", ", array_keys($data)).") VALUES (".implode(", ", array_values($data)).");";

	if ( $conn->query($sql) === TRUE )
	{
		$result = array(
			'insert_id' => mysqli_insert_id($conn),
			'result' => 'success',
			'message' => ''
		);
		
		$conn->close();
		
		return $result;
	}
	else
	{
		$result = array(
			'result' => 'error',
			'message' => "Error: " . $sql . "<br>" . $conn->error
		);
		
		$conn->close();
		
		return $result;
	}
}