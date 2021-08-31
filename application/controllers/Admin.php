<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Admin extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Admin_model');
		$this->load->model('api_model');
		$this->load->library('Ssp');
		$this->load->library('mailer');
		$this->load->library('pdf');
		$this->load->library('pdf2');
	}
	public function index(){
        if($this->session->userdata('authenticated_admin')){
			$this->dashboard();
		}else{
			$this->login();
		}
	}
	public function dashboard(){
		if(!$this->session->userdata('authenticated_admin')){
			$this->login();
		}else{
			$data['page'] = 'Dashboard';
			$data['session'] = $this->session->all_userdata();
			// echo json_encode($data);
			$this->load->view('Admin/Template/header', $data);
			$this->load->view('Admin/dashboard', $data);
			$this->load->view('Admin/Template/footer', $data);
		}
	}
	
	public function login(){
		$this->load->view('Admin/login');
	}
	public function show_session(){
		$session = $this->session->all_userdata();
    	echo json_encode($session);
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect('admin');
    }
	public function register()
	{
		$this->load->view('Admin/register');
	}
	public function request()
	{
		if(!$this->session->userdata('authenticated_admin')){
			$this->login();
		}else{
			$action = $this->input->get('action');
			$data['session'] = $this->session->all_userdata();
			switch($action){
				case "pin":
					$data['page'] = 'Request PIN Register';
					$this->load->view('Admin/Template/header', $data);
					$this->load->view('Admin/balance_pin_register', $data);
					$this->load->view('Admin/Template/footer', $data);
					break;
				case "lisensi":
					$data['page'] = 'Request Lisensi';
					$this->load->view('Admin/Template/header', $data);
					$this->load->view('Admin/balance_lisensi', $data);
					$this->load->view('Admin/Template/footer', $data);
					break;
				case "order_detail":
					$order_id = $this->input->get('id');
					$this->get_order_detail($order_id);
					break;
				case "order_detail_lisensi":
					$order_id = $this->input->get('id');
					$this->get_order_detail_lisensi($order_id);
					break;
				default :
					echo "404";
					break;
			}
		}
	}
	public function get_order_detail($order_id)
	{
		if(!$this->session->userdata('authenticated_admin')){
			$this->login();
		}else{
			$data['session'] = $this->session->all_userdata();
			$data['page'] = 'Request PIN Register';
			$data['order'] = $this->db->query("SELECT a.*, b.name as user_register, b.id as user_id FROM orders a INNER JOIN users b ON b.id = a.requested_by WHERE a.id = $order_id")->result()[0];
			$data['pin']['data'] = $this->db->query("SELECT a.*, b.name as user_register, b.id as user_id FROM pin_register a INNER JOIN users b ON b.id = a.registered_by WHERE a.order_id = $order_id")->result();
			if(count($data['pin']['data']) != 0){
				$data['pin']['status'] = true;
			}else{
				$data['pin']['status'] = false;
			}
			$this->load->view('Admin/Template/header', $data);
			$this->load->view('Admin/order_detail', $data);
			$this->load->view('Admin/Template/footer', $data);
			// echo json_encode($data);
			
		}
	}
	public function get_order_detail_lisensi($order_id)
	{
		if(!$this->session->userdata('authenticated_admin')){
			$this->login();
		}else{
			$data['session'] = $this->session->all_userdata();
			$data['page'] = 'Request Lisensi';
			$data['order'] = $this->db->query("SELECT a.*, b.name as user_register, b.id as user_id FROM orders a INNER JOIN users b ON b.id = a.requested_by WHERE a.id = $order_id")->result()[0];
			$data['lisensi']['data'] = $this->db->query("SELECT a.*, b.name as lisensi_name, b.id as lisensi_id, b.price as lisensi_price, b.is_active as lisensi_is_active, u.id as userid, u.name as username FROM orders a INNER JOIN user_lisensies l ON l.order_id = a.id INNER JOIN lisensies b ON b.id = l.lisensi_id INNER JOIN users u ON u.id = a.requested_by WHERE a.id = $order_id")->result();
			if(count($data['lisensi']['data']) != 0){
				$data['lisensi']['status'] = true;
			}else{
				$data['lisensi']['status'] = false;
			}
			$this->load->view('Admin/Template/header', $data);
			$this->load->view('Admin/order_detail_lisensi', $data);
			$this->load->view('Admin/Template/footer', $data);
			// echo json_encode($data);
			
		}
	}
	public function upload_receipt($act)
	{
		if(!$this->session->userdata('authenticated_admin')){
			$this->login();
		}else{

		}
	}
	public function register_process()
	{
		if(!$this->session->userdata('authenticated_admin')){
			$this->login();
		}else{
			$name = $this->input->post('name');
			$email = $this->input->post('email');
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$re_password = $this->input->post('re_password');
			$secure_pin = $this->input->post('secure_pin');
			$re_secure_pin = $this->input->post('re_secure_pin');
		}
	}
}
