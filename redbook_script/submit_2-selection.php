<?php
	
	include("config.php");
	//print_r($_POST);
	//exit;
	
	$make_id = "";
	$model_id = "";
	
	$make = "";
	$model = "";
	
	if(isset($_REQUEST['make_id']) && $_REQUEST['make_id']!="" && isset($_REQUEST['model_id']) && $_REQUEST['model_id']!="" )
	{
		$make_id = $_REQUEST['make_id'];
		$model_id = $_REQUEST['model_id'];
		
		$query_r = "SELECT m.name as `make`, f.name as `family` FROM makes m	JOIN families f ON m.id_make = f.fk_make
		WHERE m.id_make = '".$make_id."' AND f.id_family = '".$model_id."' LIMIT 1";
		
		$query_r = mysqli_query($con,$query_r);
											
		if(mysqli_num_rows($query_r ) > 0)
		{
			$cars_name = mysqli_fetch_array($query_r);
			$make = $cars_name['make'];
			$model = $cars_name['family'];
			
		}
		
	}else
	//if(isset($_REQUEST['q']) && $_REQUEST['q']!="" )
	{
		
		echo 'No data found URL';
		exit;
		/*$make = $_POST['make_id'];
		$model = $_POST['model_id'];
		
		$query_r = "SELECT m.name as `make`, f.name as `family` FROM makes m	JOIN families f ON m.id_make = f.fk_make
		WHERE m.id_make = '".$make_id."' AND f.id_family = '".$model_id."' LIMIT 1";
		
		$query_r = mysql_query($query_r);
											
		if(mysql_num_rows($query_r ) > 0)
		{
			$cars_name = mysql_fetch_array($query_r);
			$make = $cars_name['make'];
			$model = $cars_name['family'];
			
		}*/
	}			
	/*echo $make_id."--".$model_id;
	echo "<br>";
	echo $make."--".$model;
	exit;*/
		
	
	$s = @$_REQUEST['s'];
	$evnt = @$_REQUEST['evnt'];
	$j = 0;
	$k = 0;
	//print_r($make);
	
	$response_data = array();
	
	if($make !="" && $model!="")
	{
		$str = urlencode("Make=[".$make."]&Model=[".$model."]");
		//$str = urlencode("Make=[".$make."]");
		
		echo $url ='https://www.redbook.com.au/cars/results?s='.$s.'&evnt='.$evnt.'&q='.$str;
		//$url ='https://www.redbook.com.au/cars/results?q='.$str;
		
		$html = file_get_html($url);
		$response_data = array();
		foreach($html->find('div.content') as $e) {
			foreach($e->find('a.item') as $e2){
					$item = array();
					$item['id']= $e2->id;
					foreach($e2->find('div.photos') as $e6){
							foreach($e6->find('img') as $e66){
								$item['img']= $e66->src; 
							}
					}
					
					foreach($e2->find('div.desc h3') as $e5){
						$item['name']=  nl2br($e5->plaintext);
					}
					
					foreach($e2->find('div.info span.price') as $e4){
						$item['price']= nl2br($e4->plaintext); 
					}
					foreach($e2->find('ul.summary') as $e3){
							foreach($e3->find('li') as $e31){
								$item['desc'][]=  nl2br($e31->plaintext);
							}
							
					}
					$response_data[] =$item;
				
			}
		}
		//print_r($response_data);
		if(!empty($response_data))
		{
			foreach($response_data as $inser_data)
			{
				$json_desc = addslashes( serialize($inser_data['desc']));
				
				
				$insert_q = "INSERT INTO rb_data SET make_id = '".$make_id."', model_id= '".$model_id."', car_id= '".$inser_data['id']."', name= '".$inser_data['name']."',img = '".$inser_data['img']."', price= '".$inser_data['price']."', des= '".$json_desc."' ";
		
				$insert_r = mysqli_query($con,$insert_q);
			}
		}
		else{
		
			echo "No data found in response_data";
			exit;
		}
		
		
		?>
		
		<?php 
		$array_page = array();
		$re_url = SITEURL;
		foreach($html->find('ul.pagination') as $p) {
			foreach($p->find('li.next') as $p2){
				$re_url = SITEURL;
				
				
				/*foreach($p2->find('span') as $p4){
				?>
					<li><?php echo nl2br($p4->plaintext); ?> </li>
				<?php
				}
				foreach($p2->find('a') as $p3){
					$href = str_replace("/cars/results?","",$p3->href);
				?>
					<li><a href="<?php echo SITEURL."/index.php?" ?><?php echo $href; ?>"> <?php echo nl2br($p3->plaintext); ?> </a></li>
				<?php 
				}
				/*
				foreach($p2->find('.prev') as $p3){
					$href = str_replace("/cars/results?","",$p3->href);
					$array_page['0']['num'] = nl2br($p3->plaintext);
					$array_page['0']['href'] = $href ;
				}
					
				foreach($p2->find('span') as $p4){
					
					$array_page[intval(nl2br($p4->plaintext))]['num'] = nl2br($p4->plaintext);
				}
				foreach($p2->find('a') as $p3){
					if(nl2br($p3->plaintext)!="Prev" && nl2br($p3->plaintext)!="Next")
					{
						$href = str_replace("/cars/results?","",$p3->href);
						$count = count($array_page);
						$array_page[$count]['num'] = nl2br($p3->plaintext);
						$array_page[$count]['href'] = $href ;
					}
				}*/
				foreach($p2->find('a') as $p3){
					$href = str_replace("/cars/results?","",$p3->href);
					//$count = count($array_page);
					//$array_page[$count]['num'] = nl2br($p3->plaintext);
					//$array_page[$count]['href'] = $href ;
					
					$re_url .= "/submit.php?make_id=".$make_id."&model_id=".$model_id."&".$href;
					
					break;
				}break;			
				
			}break;		
			
		}
		?>
		<script type="text/javascript">
			console.log("<?php echo $re_url ?>");
			window.location.href='<?php echo $re_url; ?>';
		</script>
		<?php
		die;
		//header($re_url);
		exit;		
		/*print_r($array_page);
		foreach($array_page as $val)
		{
			if(isset($val['href']))
			{?>
				<li><a href="<?php echo SITEURL."/index.php?" ?><?php echo $val['href']; ?>"><?php echo $val['num']; ?></a></li>
			<?php }
			else
			{?>
				<li><?php echo $val['num']; ?> </li>
			<?php }
		}
		*/
		
		
		
	}
	//print_r($response_data);


?>