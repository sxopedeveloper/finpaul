<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('admin_main.php');
class Rb_data extends Admin_main
{
	function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$data = $this->data;
		$data['title'] = 'Redbook Data';
		$this->load->view('admin/rb_data', $data);
	}
	
	public function getData(){
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$config['table'] = 'rb_data rb';
		$config['select'] = "rb.*,m.name as make, f.name as model"; 
		$config['joins'][] = array('join_table' => 'makes m', 'join_by' => 'm.id_make = rb.make_id', 'join_type' => 'left');
		$config['joins'][] = array('join_table' => 'families f', 'join_by' => 'f.id_family = rb.model_id', 'join_type' => 'left');
		$config['order'] = array('rb.id' => 'DESC');
		$config['length'] = $limit;
		$config['start'] = $start;
		
		$this->load->library('datatables', $config, 'datatable');
		
		$list = $this->datatable->get_datatables();
		/*echo $this->db->last_query();
		exit;*/
		$data = array();		
		foreach ($list as $k=>$rec) {
			$rb_data_des = unserialize($rec->des);
			$edit = '<a href="javascript:;" class="rb-data-edit" data-id="'.$rec->id.'"><i class="fa fa-pencil-square-o"></i></a>';
			$row = array();
			
			$row[] =  $k+1;
			$row[] = $edit; 
			$row[] = $rec->make; 
			$row[] = $rec->model; 
			$row[] = $rec->car_id; 
			$row[] = $rec->name;
			$row[] = $rec->price;  
			$row[] = implode(",",$rb_data_des);   
			$row[] = $rec->month." - ".$rec->year;  
			$data[] = $row;    
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->datatable->count_filtered(),
			"recordsFiltered" =>$this->datatable->count_filtered() ,
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function save(){
		$type = $this->input->post('type');
		$make_id = $this->input->post('search_make');
		$model_id = $this->input->post('search_model');
		
		$car_id = $this->input->post('car_id');
		$name = $this->input->post('name');
		$price = $this->input->post('price');
		$price = '$'.number_format($price).'*';
		$des = $this->input->post('des');
		$month = $this->input->post('month');
		$year = $this->input->post('year');
			
		if($type == 'insert'){
			$img = '/Content/images/listing/no_photo.gif?width=150';
			if (!empty($_FILES['image']['name'])){
				$path = 'uploads/rb_data/';
				$config['upload_path']          = $path;
				$config['allowed_types']        = 'gif|jpg|png|jpeg';
				$this->load->library('upload', $config);
				if ($this->upload->do_upload('image'))
				{
					$imageDetailArray = $this->upload->data();
					$img =  base_url().$path.$imageDetailArray['file_name'];
				}else{
					$error = array('error' => $this->upload->display_errors());
				}
			}
	
			$data = array(
				'make_id' => $make_id,
				'model_id' => $model_id,
				'car_id' => $car_id,
				'name' => $name,
				'img'=> $img,
				'price' =>$price,
				'des' => serialize($des),
				'month' => $month,
				'year' => $year,
			);
			if($this->db->insert('rb_data', $data)){
				$this->session->set_flashdata('success', 'Redbook Data Inserted Successfully');
			}else{
				$this->session->set_flashdata('error', 'Some Problem Occured... Please Try Again');
			}
		
		}else{
		
			$img = '/Content/images/listing/no_photo.gif?width=150';
			if (!empty($_FILES['image']['name'])){
				$path = 'uploads/rb_data/';
				$config['upload_path']          = $path;
				$config['allowed_types']        = 'gif|jpg|png|jpeg';
				$this->load->library('upload', $config);
				if (  $this->upload->do_upload('image'))
				{
					
					$imageDetailArray = $this->upload->data();
					$img =  base_url().$path.$imageDetailArray['file_name'];
					if($this->input->post('old_image') != '/Content/images/listing/no_photo.gif?width=150'){
						echo $this->input->post('old_image');
						unlink($this->input->post('old_image'));
					}else{
						echo "f";
					}
				
				}else{
					
					$error = array('error' => $this->upload->display_errors());
				}
			}else{
			
				$img = $this->input->post('old_image');
			}
		
			$data = array(
				'make_id' => $make_id,
				'model_id' => $model_id,
				'car_id' => $car_id,
				'name' => $name,
				'img'=> $img,
				'price' =>$price,
				'des' => serialize($des),
				'month' => $month,
				'year' => $year,
			);
			$this->db->where('id', $this->input->post('id'));
			
			if($this->db->update('rb_data', $data)){
				$this->session->set_flashdata('success', 'Redbook Data Updated Successfully');
			}else{
				$this->session->set_flashdata('error', 'Some Problem Occured... Please Try Again');
			}
		}
		redirect(base_url().'index.php/rb_data');
	}

	public function get_rb_detail(){
		$id = $this->input->post('id');
		$getData = $this->db->select('*')->from('rb_data')->where('id', $id )->get()->result();

		$desc = unserialize($getData[0]->des);
		$price = str_replace("$",'',$getData[0]->price);
		$price = str_replace("*",'',$price);
		$price = str_replace(",",'',$price);
		$price = str_replace(".",'',$price);
		$price=trim($price );
		
	

		$post_data = array('code'=> '2','id_make' => $getData[0]->make_id);
		$return_array = $this->fapplication_model->get_dropdown_data($post_data);
		$option = '<option value="">-Model-</option>';
		foreach ($return_array as $result)
		{
			if($getData[0]->model_id == $result['id_family']){
				$option.= '<option selected="selected"  value="'.$result['id_family'].'">'.$result['name'].'</option>';
			}else{
				$option.= '<option  value="'.$result['id_family'].'">'.$result['name'].'</option>';
			}
			
		}

		$output= array(
			"make_id" => $getData[0]->make_id,
			"model_id" => $getData[0]->model_id,
			"car_id" => $getData[0]->car_id,
			"name" => $getData[0]->name,
			"price" => $price,
			"img" => $getData[0]->img,
			"desc1" => $desc[0],
			"desc2" => $desc[1],
			"desc3" => $desc[2],
			"desc4" => $desc[3],
			"month" => $getData[0]->month,
			"year" => $getData[0]->year,
			'model_data' =>$option,
		);
	
		echo json_encode($output);
		
	}
}
?>