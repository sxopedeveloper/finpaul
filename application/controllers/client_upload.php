<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('unlogged_main.php');
require_once("./application/libraries/PDFMerger/PDFMerger.php");
require_once("./application/libraries/PDFMerger/fpdf/fpdf.php");
require_once("./application/libraries/PDFMerger/fpdi/fpdi.php");

class Client_upload extends Unlogged_main 
{
	function __construct()
	{
		parent::__construct();
		$this->data['user_id'] = "0";
	}

	public function index()
	{
		$result = [];

		$now = date('Y-m-d');
		$flag = TRUE;
		$get_data = $this->input->get();

		$tradein_id = isset($get_data['id']) ? $get_data['id'] : 0;
		$key = isset($get_data['key']) ?  $get_data['key']: "";

		$data['tradein_id'] = $tradein_id;

		if($key == "" || $tradein_id == 0)
		{
			$flag = FALSE;
		}
		else
		{
			$result = $this->user_model->get_tradein_data($tradein_id);
		}

		if(count($result) > 0)
		{
			if(trim($key) != trim($result['key']))
			{
				$flag = FALSE;
			}
			$data['tradein'] = $result;
			$data['tradein_docs'] = $this->user_model->get_tradein_documents($tradein_id);
		}
		else
		{
			$flag = FALSE;
		}
		
		if(!$flag)
		{
			$this->load->view('404_page');
		}
		else
		{
			$this->load->view('tradein_document_uploader', $data);
		}
	}

	public function upload_tradein_documents ()
	{
		$data = $this->data;
		$directory = './uploads/tradein_documents/';
		$prefix = time().'_'.'0'.'_';
		$file_name = $_FILES['file']['name'];
		$file_tmp = $_FILES['file']['tmp_name'];
		$file = $directory.$prefix.$file_name;
		$database_file_name = $prefix.$file_name;

		$post_data = $this->input->post();

		$tradein_id = $post_data['tradein_id'];
		$doc_id = $post_data['type'];
		$user = "0";

		$this->lead_model->insert_tradein_documents($tradein_id, $doc_id, $database_file_name, $file_name, $user);

		if (move_uploaded_file($file_tmp, $file))
		{
			echo base_url('uploads/tradein_documents/'.$database_file_name);
		}
	}

	public function get_pdf_count ($abspath)
	{
		$im = new Imagick();
		$im->pingImage($abspath);

		return $im->getNumberImages();
	}

	public function get_image_size ($file)
	{
		$img = new Imagick();
		$img->readImage($file);

		$d = $img->getImageGeometry(); 
		$w = $d['width']; 
		$h = $d['height'];

		$json_array = [
			'height' => $h,
			'width'  => $w
		];
		return $json_array;
	}
}
?>