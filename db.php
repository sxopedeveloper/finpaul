<?php 

$con = mysqli_connect("localhost","mynew106_fin_new","xN9esz&Uu2Cz","mynew106_finquote_new");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

  	$sql = "SELECT * FROM rb_data_temp";
	$result = $con->query($sql);
	$counter = 0;
	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {

  		$sql2 = "SELECT car_id FROM rb_data WHERE car_id = '".$row['car_id']."' ";
  		$result2 = $con->query($sql2);
	  		
	  		if($result2->num_rows > 0){

	  			$update = "UPDATE `rb_data` SET `make_id`='".$row['make_id']."',
	  								`model_id` = '".$row['model_id']."',
					  				`car_id`='".$row['car_id']."',
					  				`name`='".$row['name']."',
					  				`img`='".$row['img']."',
					  				`price`='".$row['price']."' ,
					  				`des`='".$row['des']."' ,
					  				`month`='".$row['month']."' ,
					  				`year`='".$row['year']."',
					  				`flag`='1' WHERE car_id = '".$row['car_id']."' ";
	  			if($con->query($update)===TRUE){
		  		
		  			$counter++;
		  			echo "Update".$counter."<br/>" ;
		  		}
		  		else{
		  		    echo $update."<br/>";
		  		}

	  		}
	  		else{

	    		$aa = "INSERT INTO `rb_data` (`make_id`,`model_id`,`car_id`,`name`,`img`,`price`,`des`,`month`,`year`,`flag`) VALUES ('".$row['make_id']."','".$row['model_id']."','".$row['car_id']."','".$row['name']."','".$row['img']."','".$row['price']."','".$row['des']."','".$row['month']."','".$row['year']."','2')";
	  			if($con->query($aa)===TRUE){
		  		
		  			$counter++;
		  			echo "Record Inserted".$counter."<br/>" ;
		  		}
		  		else{
		  			echo "<br/>".$aa."<br/>";
		  		}
	    	}


	  		}
	} else {
	    echo "0 results";
	}


?>