<?php
//error_reporting(0);
set_time_limit(0);
ini_set('max_execution_time', 0);
$host="localhost"; 
$user="mynew106_fin_new"; 
$password="xN9esz&Uu2Cz"; 
$database="	mynew106_finquote_new"; 

$con = mysqli_connect("localhost","mynew106_fin_new","xN9esz&Uu2Cz","mynew106_finquote_new");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

// $Link_ID=mysql_connect($host, $user, $password); 
// if (!$Link_ID) 
// { 
// echo "Failed to connect to Server=".$host; 
//   return 0; 
// } 

	
	// echo "string";
	// exit();

// $db = mysql_connect("localhost", $user,$password);
// mysql_select_db($database,$db) or die("Unable to connect to database.");

define('SITEURL',"https://staging-new.finquote.com.au/redbook_script") ;
include("simple_html_dom.blade.php");

$make_array_ = array('Alfa Romeo',
					'Audi','BMW',
					'Chrysler',
					'Citroen',
					'Fiat',
					'Ford' ,
					'Holden' ,
					'Honda',
					'Hyundai',
					'Isuzu' ,
					'Jaguar',
					'Jeep',
					'Kia' ,
					'Lamborghini',
					'Land Rover' ,
					'Lexus','Mazda',
					'Mercedes Benz',
					'Mini',
					'Mitsubishi',
					'Nissan',
					'Peugeot',
					'Porsche','Renault',
					'Skoda',
					'Subaru','Suzuki',
					'Toyota' ,
					'Volkswagen',
					'Volvo'  );
?>