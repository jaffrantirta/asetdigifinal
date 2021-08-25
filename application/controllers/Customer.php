<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Customer extends CI_Controller {
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
        if($this->session->userdata('authenticated_customer')){
			$this->dashboard();
		}else{
			$this->login();
		}
	}
	public function dashboard(){
		if(!$this->session->userdata('authenticated_customer')){
			$this->login();
		}else{
			$data['page'] = 'Dashboard';
			$data['session'] = $this->session->all_userdata();
			// echo json_encode($data);
			$this->load->view('Customer/Template/header', $data);
			$this->load->view('Customer/dashboard', $data);
			$this->load->view('Customer/Template/footer', $data);
		}
	}
	
	public function login(){
		$this->load->view('Customer/login');
	}
	public function show_session(){
		$session = $this->session->all_userdata();
    	echo json_encode($session);
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect('Customer');
    }
	public function register()
	{
		$this->load->view('Customer/register');
	}
	public function pin()
	{
		if(!$this->session->userdata('authenticated_customer')){
			$this->login();
		}else{
			$action = $this->input->get('action');
			$data['session'] = $this->session->all_userdata();
			switch($action){
				case "buy":
					$data['page'] = 'Buy PIN Register';
					$setting = json_decode($this->api_model->get_data_by_where('settings', array('key'=>'pin_register_price'))->result()[0]->content);
					$data['price'] = $setting->price;
					$data['currency'] = $setting->currency;
					$this->load->view('Customer/Template/header', $data);
					$this->load->view('Customer/buy_pin_register', $data);
					$this->load->view('Customer/Template/footer', $data);
					break;
				case "balance":
					$data['page'] = 'Balance PIN Register';
					$this->load->view('Customer/Template/header', $data);
					$this->load->view('Customer/balance_pin_register', $data);
					$this->load->view('Customer/Template/footer', $data);
					break;
				case "order_detail":
					$order_id = $this->input->get('id');
					$this->get_order_detail($order_id);
					break;
				default :
					echo "404";
					break;
			}
		}
	}
	public function lisensi()
	{
		if(!$this->session->userdata('authenticated_customer')){
			$this->login();
		}else{
			$action = $this->input->get('action');
			$data['session'] = $this->session->all_userdata();
			switch($action){
				case "buy":
					$data['page'] = 'Buy Lisensi';
					$data['lisensi_currency'] = $this->api_model->get_data_by_where('settings', array('key'=>'lisensi_currency'))->result()[0]->content;
					$data['lisensies'] = $this->api_model->get_data_by_where('lisensies', array('is_active'=>true))->result();
					$this->load->view('Customer/Template/header', $data);
					$this->load->view('Customer/buy_lisensi', $data);
					$this->load->view('Customer/Template/footer', $data);
					break;
				case "balance":
					$data['page'] = 'Balance PIN Register';
					$this->load->view('Customer/Template/header', $data);
					$this->load->view('Customer/balance_pin_register', $data);
					$this->load->view('Customer/Template/footer', $data);
					break;
				case "order_detail":
					$order_id = $this->input->get('id');
					$this->get_order_detail($order_id);
					break;
				default :
					echo "404";
					break;
			}
		}
	}
	public function get_order_detail($order_id)
	{
		if(!$this->session->userdata('authenticated_customer')){
			$this->login();
		}else{
			$data['session'] = $this->session->all_userdata();
			$data['page'] = 'Balance PIN Register';
			$data['order'] = $this->api_model->get_data_by_where('orders', array('id'=>$order_id))->result()[0];
			$data['pin']['data'] = $this->api_model->get_data_by_where('pin_register', array('order_id'=>$order_id))->result();
			if(count($data['pin']['data']) != 0){
				$data['pin']['status'] = true;
			}else{
				$data['pin']['status'] = false;
			}
			$this->load->view('Customer/Template/header', $data);
			$this->load->view('Customer/order_detail', $data);
			$this->load->view('Customer/Template/footer', $data);
			
		}
	}
	public function upload_receipt($act)
	{
		if(!$this->session->userdata('authenticated_customer')){
			$this->login();
		}else{

		}
	}
	public function register_process()
	{
		if(!$this->session->userdata('authenticated_customer')){
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
