<?php
	
	include("config.php");
	//print_r($_POST);
	//exit;
	
	//SELECT m.name ,(SELECT count(f.id_family) FROM families f where f.fk_make = m.id_make) as count FROM makes m ORDER BY `count` ASC LIMIT 35
	
	//SELECT m.name ,(SELECT count(f.id_family) FROM families f where f.fk_make = m.id_make) as count_model,(SELECT count(r.id) FROM rb_data r where r.make_id = m.id_make) as count_cars FROM makes m ORDER BY `count_model` ASC limit 35
	
	//SELECT m.name, f.name,(SELECT count(r.id) FROM rb_data r where r.model_id = f.id_family) as count_cars , (SELECT count(r.id) FROM rb_data r where r.make_id = m.id_make) as count_cars2 FROM makes m JOIN families f ON f.fk_make = m.id_make ORDER BY m.name ASC LIMIT 353
	
	$make_id = "";
	$model_id = "";
	
	$make = "";
	$model = "";
	
	if(isset($_REQUEST['make_id']) && $_REQUEST['make_id']!="" && isset($_REQUEST['model_id']) && $_REQUEST['model_id']!="" )
	{
		$make_id = $_REQUEST['make_id'];
		$model_id = $_REQUEST['model_id'];
		
		//echo $query_r = "SELECT m.name as `make`, f.name as `family` FROM makes m	JOIN families f ON m.id_make = f.fk_make WHERE m.id_make = '".$make_id."' AND f.id_family = '".$model_id."' LIMIT 1";
		$query_r = "SELECT m.id_make,f.id_family,m.name as `make`, f.name as `family` FROM makes m JOIN families f ON m.id_make = f.fk_make WHERE m.id_make = '".$make_id."' AND f.rb_status = 0 ORDER by f.id_family ";
		$query_r = mysqli_query($con,$query_r);
											
		if(mysqli_num_rows($query_r ) > 0)
		{
			//$cars_name = mysql_fetch_array($query_r);
			while($cars_name = mysqli_fetch_array($query_r))
			{
				$make = $cars_name['make'];
				$model = $cars_name['family'];
			
				$make_id = $cars_name['id_make'];
				$model_id = $cars_name['id_family'];
			
			/***************/
				
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
						//echo $url ='https://www.carsales.com.au/cars/details/Audi-A3-2006/OAG-AD-16915920/?gts=OAG-AD-16915920&gtssaleid=OAG-AD-16915920&rankingType=TopSpot';
						echo '<br>';
						//$url ='https://www.redbook.com.au/cars/results?q='.$str;
						
						$html = file_get_html($url);  
						//echo "-----***----";
						//exit;
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
									foreach($e2->find('div.desc span.releasedate') as $e4){
										$item['date']= nl2br($e4->plaintext); 
									}
									
									
									$response_data[] =$item;
								
							}
						}
						echo '<pre>';print_r($response_data);
						if(!empty($response_data))
						{
							foreach($response_data as $inser_data)
							{
								$json_desc = addslashes( serialize($inser_data['desc']));
								$date = str_replace("Released:","",str_replace(" ","", $inser_data['date']));
								$year = date('Y',strtotime($date));
								$month = date('m',strtotime($date));
								
								$insert_q = "INSERT IGNORE INTO rb_data_temp SET make_id = '".$make_id."', model_id= '".$model_id."', car_id= '".$inser_data['id']."', name= '".$inser_data['name']."',img = '".$inser_data['img']."', price= '".$inser_data['price']."', des= '".$json_desc."', month = '".$month."', year='".$year."' ";
						
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
								
								
								foreach($p2->find('a') as $p3){
									$href = str_replace("/cars/results?","",$p3->href);
									//$count = count($array_page);
									//$array_page[$count]['num'] = nl2br($p3->plaintext);
									//$array_page[$count]['href'] = $href ;
									
									echo $re_url .= "/submit_data_new.php?make_id=".$make_id."&model_id=".$model_id."&".$href;
									
									break;
								}break;			
								
							}break;		
							
						}
						?>
						<script type="text/javascript">
							//alert("<?php echo $re_url ?>");
							//window.location.href='<?php echo $re_url; ?>';
							window.open('<?php echo $re_url; ?>','_blank');
						</script>
						<?php
						//die;
						//header($re_url);
						echo '--DONE--';		
						
						mysqli_query($con," UPDATE families SET rb_status = 1 WHERE id_family = '".$model_id."' ");
						
						
					}
				}
			/*******************/
		
		}
		
	}else
	//if(isset($_REQUEST['q']) && $_REQUEST['q']!="" )
	{
		
		echo 'No data found URL';
		exit;
		
	}			
	/*echo $make_id."--".$model_id;
	echo "<br>";
	echo $make."--".$model;
	exit;*/
		
	
	print_r($make_id);

echo 'done';
?>