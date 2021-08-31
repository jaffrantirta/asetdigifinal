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
		$data['top_id'] = $this->input->get('top');
		$data['position'] = $this->input->get('position');
		$this->load->view('Customer/register', $data);
	}
	public function structur($hash)
	{
		if(!$this->session->userdata('authenticated_customer')){
			$this->login();
		}else{
			$data['session'] = $this->session->all_userdata();
			$data['page'] = 'Structur';
			$id = $hash;//base64_decode($hash);

			//parent1-start
			$data['parent_1']['data'] = $this->api_model->get_data_by_where('users', array('id'=>$id))->result()[0];
			if(count($_1_left = $this->db->query("SELECT p.*, u.name as top_name, u2.name as bottom_name FROM positions p INNER JOIN users u ON u.id=p.top INNER JOIN users u2 ON u2.id=p.bottom WHERE p.top = $id AND p.position = 1")->result()) == 1){
				$data['parent_1']['left'] = $_1_left[0];
				//parent2-start
				$data['parent_2']['data'] = $this->api_model->get_data_by_where('users', array('id'=>$_1_left[0]->bottom))->result()[0];
				if(count($_2_left = $this->db->query("SELECT p.*, u.name as top_name, u2.name as bottom_name FROM positions p INNER JOIN users u ON u.id=p.top INNER JOIN users u2 ON u2.id=p.bottom WHERE p.top = ".$_1_left[0]->bottom." AND p.position = 1")->result()) == 1){
					$data['parent_2']['left'] = $_2_left[0];
					//parent4-start
					$data['parent_4']['data'] = $this->api_model->get_data_by_where('users', array('id'=>$_2_left[0]->bottom))->result()[0];
					if(count($_4_left = $this->db->query("SELECT p.*, u.name as top_name, u2.name as bottom_name FROM positions p INNER JOIN users u ON u.id=p.top INNER JOIN users u2 ON u2.id=p.bottom WHERE p.top = ".$_2_left[0]->bottom." AND p.position = 1")->result()) == 1){
						$data['parent_4']['left'] = $_4_left[0];
					}else{
						$data['parent_4']['left'] = null;
					}
					
					if(count($_4_right = $this->db->query("SELECT p.*, u.name as top_name, u2.name as bottom_name FROM positions p INNER JOIN users u ON u.id=p.top INNER JOIN users u2 ON u2.id=p.bottom WHERE p.top = ".$_2_left[0]->bottom." AND p.position = 2")->result()) == 1){
						$data['parent_4']['right'] = $_4_right[0];
					}else{
						$data['parent_4']['right'] = null;
					}
					//parent4-end
				}else{
					$data['parent_2']['left'] = null;
					$data['parent_4']['left'] = null;
					$data['parent_4']['right'] = null;
					$data['parent_4']['data'] = null;
				}
				
				if(count($_2_right = $this->db->query("SELECT p.*, u.name as top_name, u2.name as bottom_name FROM positions p INNER JOIN users u ON u.id=p.top INNER JOIN users u2 ON u2.id=p.bottom WHERE p.top = ".$_1_left[0]->bottom." AND p.position = 0")->result()) == 1){
					$data['parent_2']['right'] = $_2_right[0];
					//parent5-start
					$data['parent_5']['data'] = $this->api_model->get_data_by_where('users', array('id'=>$_2_right[0]->bottom))->result()[0];
					if(count($_5_left = $this->db->query("SELECT p.*, u.name as top_name, u2.name as bottom_name FROM positions p INNER JOIN users u ON u.id=p.top INNER JOIN users u2 ON u2.id=p.bottom WHERE p.top = ".$_2_right[0]->bottom." AND p.position = 1")->result()) == 1){
						$data['parent_5']['left'] = $_5_left[0];
					}else{
						$data['parent_5']['left'] = null;
					}
					
					if(count($_5_right = $this->db->query("SELECT p.*, u.name as top_name, u2.name as bottom_name FROM positions p INNER JOIN users u ON u.id=p.top INNER JOIN users u2 ON u2.id=p.bottom WHERE p.top = ".$_2_right[0]->bottom." AND p.position = 0")->result()) == 1){
						$data['parent_5']['right'] = $_5_right[0];
					}else{
						$data['parent_5']['right'] = null;
					}
					//parent5-end
				}else{
					$data['parent_2']['right'] = null;
					$data['parent_5']['left'] = null;
					$data['parent_5']['right'] = null;
					$data['parent_5']['data'] = null;
				}
				//parent2-end
			}else{
				$data['parent_1']['left'] = null;
				$data['parent_2']['left'] = null;
				$data['parent_4']['left'] = null;
				$data['parent_5']['left'] = null;
				$data['parent_2']['right'] = null;
				$data['parent_4']['right'] = null;
				$data['parent_5']['right'] = null;
				$data['parent_4']['data'] = null;
				$data['parent_2']['data'] = null;
				$data['parent_5']['data'] = null;
			}

			
			if(count($_1_right = $this->db->query("SELECT p.*, u.name as top_name, u2.name as bottom_name FROM positions p INNER JOIN users u ON u.id=p.top INNER JOIN users u2 ON u2.id=p.bottom WHERE p.top = $id AND p.position = 2")->result()) == 1){
				$data['parent_1']['right'] = $_1_right[0];
				//parent3-start
				$data['parent_3']['data'] = $this->api_model->get_data_by_where('users', array('id'=>$_1_right[0]->bottom))->result()[0];
				if(count($_3_left = $this->db->query("SELECT p.*, u.name as top_name, u2.name as bottom_name FROM positions p INNER JOIN users u ON u.id=p.top INNER JOIN users u2 ON u2.id=p.bottom WHERE p.top = ".$_1_right[0]->bottom." AND p.position = 1")->result()) == 1){
					$data['parent_3']['left'] = $_3_left[0];
					//parent6-start
					$data['parent_6']['data'] = $this->api_model->get_data_by_where('users', array('id'=>$_3_left[0]->bottom))->result()[0];
					if(count($_6_left = $this->db->query("SELECT p.*, u.name as top_name, u2.name as bottom_name FROM positions p INNER JOIN users u ON u.id=p.top INNER JOIN users u2 ON u2.id=p.bottom WHERE p.top = ".$_3_left[0]->bottom." AND p.position = 1")->result()) == 1){
						$data['parent_6']['left'] = $_6_left[0];
					}else{
						$data['parent_6']['left'] = null;
					}
					
					if(count($_6_right = $this->db->query("SELECT p.*, u.name as top_name, u2.name as bottom_name FROM positions p INNER JOIN users u ON u.id=p.top INNER JOIN users u2 ON u2.id=p.bottom WHERE p.top = ".$_3_left[0]->bottom." AND p.position = 2")->result()) == 1){
						$data['parent_6']['right'] = $_6_right[0];
					}else{
						$data['parent_6']['right'] = null;
					}
					//parent6-end
				}else{
					$data['parent_3']['left'] = null;
					$data['parent_6']['left'] = null;
					$data['parent_6']['right'] = null;
					$data['parent_6']['data'] = null;
				}
				
				if(count($_3_right = $this->db->query("SELECT p.*, u.name as top_name, u2.name as bottom_name FROM positions p INNER JOIN users u ON u.id=p.top INNER JOIN users u2 ON u2.id=p.bottom WHERE p.top = ".$_1_right[0]->bottom." AND p.position = 2")->result()) == 1){
					$data['parent_3']['right'] = $_3_right[0];
					//parent7-start
					$data['parent_7']['data'] = $this->api_model->get_data_by_where('users', array('id'=>$_3_right[0]->bottom))->result()[0];
					if(count($_7_left = $this->db->query("SELECT p.*, u.name as top_name, u2.name as bottom_name FROM positions p INNER JOIN users u ON u.id=p.top INNER JOIN users u2 ON u2.id=p.bottom WHERE p.top = ".$_3_right[0]->bottom." AND p.position = 1")->result()) == 1){
						$data['parent_7']['left'] = $_7_left[0];
					}else{
						$data['parent_7']['left'] = null;
					}
					
					if(count($_7_right = $this->db->query("SELECT p.*, u.name as top_name, u2.name as bottom_name FROM positions p INNER JOIN users u ON u.id=p.top INNER JOIN users u2 ON u2.id=p.bottom WHERE p.top = ".$_3_right[0]->bottom." AND p.position = 2")->result()) == 1){
						$data['parent_7']['right'] = $_7_right[0];
					}else{
						$data['parent_7']['right'] = null;
					}
					//parent7-end
				}else{
					$data['parent_3']['right'] = null;
					$data['parent_7']['left'] = null;
					$data['parent_7']['right'] = null;
					$data['parent_7']['data'] = null;
				}
				//parent3-end
			}else{
				$data['parent_1']['right'] = null;
				$data['parent_3']['left'] = null;
				$data['parent_6']['left'] = null;
				$data['parent_7']['left'] = null;
				$data['parent_3']['right'] = null;
				$data['parent_6']['right'] = null;
				$data['parent_7']['right'] = null;
				$data['parent_6']['data'] = null;
				$data['parent_7']['data'] = null;
				$data['parent_3']['data'] = null;
			}
			//parent1-end

			$this->load->view('Customer/Template/header', $data);
			$this->load->view('Customer/structur', $data);
			$this->load->view('Customer/Template/footer', $data);

			// echo json_encode($data);
		}
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
				case "history":
					$data['page'] = 'History PIN Register';
					$this->load->view('Customer/Template/header', $data);
					$this->load->view('Customer/history_pin_register', $data);
					$this->load->view('Customer/Template/footer', $data);
					break;
				case "balance":
					$data['page'] = 'Balance PIN Register';
					$data['get_pins'] = count($this->api_model->get_data_by_where('pin_register', array('registered_by'=>$this->session->userdata('data')->id, 'is_active'=>true))->result());
					$this->load->view('Customer/Template/header', $data);
					$this->load->view('Customer/balance_pin_register', $data);
					$this->load->view('Customer/Template/footer', $data);
					break;
				case "transfer":
					$data['page'] = 'Transfer PIN Register';
					$data['get_pins'] = count($this->api_model->get_data_by_where('pin_register', array('registered_by'=>$this->session->userdata('data')->id, 'is_active'=>true))->result());
					$this->load->view('Customer/Template/header', $data);
					$this->load->view('Customer/transfer_pin_register', $data);
					$this->load->view('Customer/Template/footer', $data);
					// echo json_encode($data);
					break;
				case "order_detail":
					$order_id = $this->input->get('id');
					$this->get_order_detail_pin($order_id);
					break;
				case "transfer_history":
					$data['page'] = 'Transfer PIN Register History';
					$data['get_lisensies'] = $this->api_model->get_data_by_where('user_lisensies_complate_data', array('owner'=>$this->session->userdata('data')->id))->result();
					$this->load->view('Customer/Template/header', $data);
					$this->load->view('Customer/transfer_pin_register_history', $data);
					$this->load->view('Customer/Template/footer', $data);
					break;
				default :
					echo "404";
					break;
			}
		}
	}
	public function test()
	{
		$left[] = 12;
		$right[] = 0;
		$status = 'left';
		$i = 0;
		do{
			if($status == 'left'){
				$id = $left[$i];
				$status = 'right';
			}else{
				$id = $right[$i];
				$status = 'left';
			}
			$bottom = $this->api_model->get_data_by_where('positions', array('top'=>$id))->result();
			if(count($bottom) == 2){
				if($bottom[0]->position == 1){
					$left[] = $bottom[0]->id;
					$right[] = $bottom[1]->id;
				}else{
					$left[] = $bottom[1]->id;
					$right[] = $bottom[0]->id;
				}
			}else{

			}
			$i++;
		}while(count($bottom) == 2);
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
				case "history":
					$data['page'] = 'History Lisensi';
					$this->load->view('Customer/Template/header', $data);
					$this->load->view('Customer/history_lisensi', $data);
					$this->load->view('Customer/Template/footer', $data);
					break;
				case "balance":
					$data['get_lisensies'] = count($this->api_model->get_data_by_where('user_lisensies_complate_data', array('owner'=>$this->session->userdata('data')->id))->result());
					$data['page'] = 'Balance Lisensi';
					$this->load->view('Customer/Template/header', $data);
					$this->load->view('Customer/balance_lisensi', $data);
					$this->load->view('Customer/Template/footer', $data);
					break;
				case "order_detail":
					$order_id = $this->input->get('id');
					$this->get_order_detail_lisensi($order_id);
					break;
				case "transfer":
					$data['page'] = 'Transfer Lisensi';
					$data['get_lisensies'] = $this->api_model->get_data_by_where('user_lisensies_complate_data', array('owner'=>$this->session->userdata('data')->id))->result();
					$this->load->view('Customer/Template/header', $data);
					$this->load->view('Customer/transfer_lisensi', $data);
					$this->load->view('Customer/Template/footer', $data);
					break;
				case "transfer_history":
					$data['page'] = 'Transfer Lisensi History';
					$data['get_lisensies'] = $this->api_model->get_data_by_where('user_lisensies_complate_data', array('owner'=>$this->session->userdata('data')->id))->result();
					$this->load->view('Customer/Template/header', $data);
					$this->load->view('Customer/transfer_lisensi_history', $data);
					$this->load->view('Customer/Template/footer', $data);
					break;
				default :
					echo "404";
					break;
			}
		}
	}
	public function get_order_detail_pin($order_id)
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
	public function get_order_detail_lisensi($order_id)
	{
		if(!$this->session->userdata('authenticated_customer')){
			$this->login();
		}else{
			$data['session'] = $this->session->all_userdata();
			$data['page'] = 'Balance Lisensi';
			$data['order'] = $this->api_model->get_data_by_where('orders', array('id'=>$order_id))->result()[0];
			$data['lisensi']['data'] = $this->db->query("SELECT a.*, b.name as lisensi_name, b.id as lisensi_id, b.price as lisensi_price, b.is_active as lisensi_is_active, u.id as userid, u.name as username FROM orders a INNER JOIN user_lisensies l ON l.order_id = a.id INNER JOIN lisensies b ON b.id = l.lisensi_id INNER JOIN users u ON u.id = a.requested_by WHERE a.id = $order_id")->result();
			if(count($data['lisensi']['data']) != 0){
				$data['lisensi']['status'] = true;
			}else{
				$data['lisensi']['status'] = false;
			}
			$this->load->view('Customer/Template/header', $data);
			$this->load->view('Customer/order_detail_lisensi', $data);
			$this->load->view('Customer/Template/footer', $data);
			// echo json_encode($data);
			
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
