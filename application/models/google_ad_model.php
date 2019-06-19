<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Google_ad_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	public function get_all ($data, $start, $limit)
	{
		$heading_1_line_1 = isset($data['heading_1_line_1']) ? $data['heading_1_line_1'] : '';
		$heading_1_line_2 = isset($data['heading_1_line_2']) ? $data['heading_1_line_2'] : '';
		
		$this->db->from('advertisements');
		$this->db->join('landing_pages', 'advertisements.fk_landing_page = landing_pages.id_landing_page', 'left');
		
		$this->db->select('advertisements.*, landing_pages.root');
		$this->db->where('advertisements.deprecated != ', '1');

		if ($heading_1_line_1 != "")
		{
			$this->db->like('heading_1_line_1_text', $heading_1_line_1);
		}

		if ($heading_1_line_2 != "")
		{
			$this->db->like('heading_1_line_2_text', $heading_1_line_2);
		}

		$this->db->order_by('id_advertisement', 'desc');
		$this->db->limit($limit, $start);

		$query = $this->db->get();

		return $query->result();
	}

	public function get_all_count ($data)
	{
		$heading_1_line_1 = isset($data['heading_1_line_1']) ? $data['heading_1_line_1'] : '';
		$heading_1_line_2 = isset($data['heading_1_line_2']) ? $data['heading_1_line_2'] : '';
		
		$this->db->from('advertisements');
		$this->db->join('landing_pages', 'advertisements.fk_landing_page = landing_pages.id_landing_page', 'left');
		
		$this->db->select('COUNT(1) AS `cnt`');
		$this->db->where('advertisements.deprecated != ', '1');

		if ($heading_1_line_1 != "")
		{
			$this->db->like('heading_1_line_1_text', $heading_1_line_1);
		}

		if ($heading_1_line_2 != "")
		{
			$this->db->like('heading_1_line_2_text', $heading_1_line_2);
		}
		
		$query = $this->db->get();

		return $query->row_array();
	}
	
	public function getby_id ($ad_id)
	{	
		$this->db->from('advertisements');
		$this->db->join('landing_pages', 'advertisements.fk_landing_page = landing_pages.id_landing_page', 'left');
		
		$this->db->select('advertisements.*, landing_pages.root');
		
		$this->db->where('id_advertisement', $ad_id );
		$this->db->where('advertisements.deprecated != ', '1');
		
		$query = $this->db->get();
		return $query->result();
	}
	
	public function get_landing_page_make ($landing_page_id)
	{
		$query = "
		SELECT lp.fk_make AS `id_make`, m.name AS `make`
		FROM landing_pages lp
		LEFT JOIN makes m ON lp.fk_make = m.id_make
		WHERE lp.id_landing_page = '".$this->db->escape_str($landing_page_id)."'";
		return $this->db->query($query)->row_array();		
	}
	
	public function insert_ad ()
	{
		$post_data = $this->input->post();
		$image = isset($post_data['add_ad_car_photo']) ? $post_data['add_ad_car_photo'] : "";
		$new_ad = array(
			'fk_landing_page'              => $this->input->post('fk_landing_page'),
			'fk_make'					   => $this->input->post('fk_make'),
			'fk_family'					   => $this->input->post('fk_family'),

			'img'                          => $image,
			'slug'                         => $this->input->post('slug'),
			'description'                  => $this->input->post('description'),
			
			'heading_1_line_1_text'        => $this->input->post('heading_1_line_1_text'),
			'heading_1_line_1_font_size'   => $this->input->post('heading_1_line_1_font_size'),
			'heading_1_line_1_font_weight' => $this->input->post('heading_1_line_1_font_weight'),
			
			'heading_1_line_2_text'        => $this->input->post('heading_1_line_2_text'),
			'heading_1_line_2_font_size'   => $this->input->post('heading_1_line_2_font_size'),
			'heading_1_line_2_font_weight' => $this->input->post('heading_1_line_2_font_weight'),
			
			'heading_2_text'               => $this->input->post('heading_2_text'),
			'heading_2_font_size'          => $this->input->post('heading_2_font_size'),
			'heading_2_font_weight'        => $this->input->post('heading_2_font_weight'),
			
			'heading_3_text'               => $this->input->post('heading_3_text'),
			'heading_3_font_size'          => $this->input->post('heading_3_font_size'),
			'heading_3_font_weight'        => $this->input->post('heading_3_font_weight'),
			
			'list_1_text'                  => $this->input->post('list_1_text'),
			'list_1_font_size'             => $this->input->post('list_1_font_size'),
			'list_1_font_weight'           => $this->input->post('list_1_font_weight'),
			
			'list_2_text'                  => $this->input->post('list_2_text'),
			'list_2_font_size'             => $this->input->post('list_2_font_size'),
			'list_2_font_weight'           => $this->input->post('list_2_font_weight'),
			
			'list_3_text'                  => $this->input->post('list_3_text'),
			'list_3_font_size'             => $this->input->post('list_3_font_size'),
			'list_3_font_weight'           => $this->input->post('list_3_font_weight'),
			
			'list_4_text'                  => $this->input->post('list_4_text'),
			'list_4_font_size'             => $this->input->post('list_4_font_size'),
			'list_4_font_weight'           => $this->input->post('list_4_font_weight'),
			
			'heading_4_line_1_text'        => $this->input->post('heading_4_line_1_text'),
			'heading_4_line_1_font_size'   => $this->input->post('heading_4_line_1_font_size'),
			'heading_4_line_1_font_weight' => $this->input->post('heading_4_line_1_font_weight'),
			
			'heading_4_line_2_text'        => $this->input->post('heading_4_line_2_text'),
			'heading_4_line_2_font_size'   => $this->input->post('heading_4_line_2_font_size'),
			'heading_4_line_2_font_weight' => $this->input->post('heading_4_line_2_font_weight'),

			'created_at'                   => date("Y-m-d H:i:s")
		);
		$this->db->insert( 'advertisements', $new_ad );
		return $this->db->insert_id();
	}
	
	public function update_ad ()
	{	
		$this->db->where( 'id_advertisement', $this->input->post('ads_id') );
		$edit_ad = array(
			'fk_landing_page'              => $this->input->post('fk_landing_page'),
			'fk_make'					   => $this->input->post('fk_make'),
			'fk_family'					   => $this->input->post('fk_family'),

			'slug'                         => $this->input->post('slug'),
			'description'                  => $this->input->post('description'),
			
			'heading_1_line_1_text'        => $this->input->post('heading_1_line_1_text'),
			'heading_1_line_1_font_size'   => $this->input->post('heading_1_line_1_font_size'),
			'heading_1_line_1_font_weight' => $this->input->post('heading_1_line_1_font_weight'),
			
			'heading_1_line_2_text'        => $this->input->post('heading_1_line_2_text'),
			'heading_1_line_2_font_size'   => $this->input->post('heading_1_line_2_font_size'),
			'heading_1_line_2_font_weight' => $this->input->post('heading_1_line_2_font_weight'),
			
			'heading_2_text'               => $this->input->post('heading_2_text'),
			'heading_2_font_size'          => $this->input->post('heading_2_font_size'),
			'heading_2_font_weight'        => $this->input->post('heading_2_font_weight'),
			
			'heading_3_text'               => $this->input->post('heading_3_text'),
			'heading_3_font_size'          => $this->input->post('heading_3_font_size'),
			'heading_3_font_weight'        => $this->input->post('heading_3_font_weight'),
			
			'list_1_text'                  => $this->input->post('list_1_text'),
			'list_1_font_size'             => $this->input->post('list_1_font_size'),
			'list_1_font_weight'           => $this->input->post('list_1_font_weight'),
			
			'list_2_text'                  => $this->input->post('list_2_text'),
			'list_2_font_size'             => $this->input->post('list_2_font_size'),
			'list_2_font_weight'           => $this->input->post('list_2_font_weight'),
			
			'list_3_text'                  => $this->input->post('list_3_text'),
			'list_3_font_size'             => $this->input->post('list_3_font_size'),
			'list_3_font_weight'           => $this->input->post('list_3_font_weight'),
			
			'list_4_text'                  => $this->input->post('list_4_text'),
			'list_4_font_size'             => $this->input->post('list_4_font_size'),
			'list_4_font_weight'           => $this->input->post('list_4_font_weight'),
			
			'heading_4_line_1_text'        => $this->input->post('heading_4_line_1_text'),
			'heading_4_line_1_font_size'   => $this->input->post('heading_4_line_1_font_size'),
			'heading_4_line_1_font_weight' => $this->input->post('heading_4_line_1_font_weight'),
			
			'heading_4_line_2_text'        => $this->input->post('heading_4_line_2_text'),
			'heading_4_line_2_font_size'   => $this->input->post('heading_4_line_2_font_size'),
			'heading_4_line_2_font_weight' => $this->input->post('heading_4_line_2_font_weight')
		);
		$this->db->update( 'advertisements', $edit_ad );
	}

	public function update_image ($data)
	{
		$this->db->where('id_advertisement', $data['id']);
		$update_data = [
			'img' => $data['image']
		];
		$this->db->update('advertisements', $update_data);
	}
	
	public function delete_ad ()
	{
		$ad_id = $this->input->post('ads_id');	
		$this->db->where('id_advertisement', $ad_id);
		$del_ad = array('deprecated' => '1');
		return $this->db->update('advertisements', $del_ad);
	}

	public function get_all_landing_pages ()
	{
		$this->db->order_by('website_url', 'asc');
		$query = $this->db->get('landing_pages');
		return $query->result();
	}
	
	public function get_landing_page_by_id ($id)
	{
		$this->db->where('id_landing_page', $id);
		$query = $this->db->get('landing_pages');
		return $query->row_array();
	}
}