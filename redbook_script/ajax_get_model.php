<?php
	include("config.php");
	$respose = '';
	if(@$_POST['make_id'])
	{
		$make_id = $_POST['make_id'];
		$model_r = 'SELECT * FROM families WHERE fk_make = "'.$make_id.'" ORDER BY  id_family ASC';
		$model_r = mysqli_query($con,$model_r);
		
		if(mysqli_num_rows($model_r ) > 0)
		{
			while($models = mysqli_fetch_array($model_r))
			{
				$respose .= '<option value="'.$models['id_family'].'">'.$models['name'].'</option>';
			}
		}
		else
		{
			$respose .= '<option>No data Found</option>';
		}
	}else
	{
		
		$respose .= '<option>No data Found</option>';
	}	
	echo $respose;	
 ?>