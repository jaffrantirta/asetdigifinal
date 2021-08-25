<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Api extends CI_Controller {
	public function __construct()
  {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('api_model');
		$this->load->library('Ssp');
		$this->load->library('mailer');
		$this->load->library('pdf');
		$this->load->library('pdf2');
    $this->load->library('email_template');
    $this->load->helper('string');
	}
	public function index()
  {
    if($this->session->userdata('authenticated_customer')){
			$this->dashboard();
		}else{
			$this->login();
		}
	}
  public function cek_session()
  {
    echo json_encode($this->session->all_userdata());
  }
	public function dashboard()
  {
		$this->load->view('admin/template/header');
		$this->load->view('admin/dashboard');
		$this->load->view('admin/template/footer');
	}
	public function login()
  {
		$this->load->view('admin/login');
	}
  public function login_process()
  {
    $username = $this->input->post('username');
    $password = $this->input->post('password');
    $result['data'] = $this->api_model->login($username, $password)->result();
    if(count($result['data']) > 0){
      if($result['data'][0]->role == 'customer'){
        $session = array(
          'authenticated_customer'=>true,
          'data'=>$result['data'][0]
        );
        $this->session->set_userdata($session);
        $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'login berhasil', 'english'=>"you're logged"));
      }else{
        $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'kridensial yang digunakan bukan customer', 'english'=>"your kridential is not customer"));
        $this->output->set_status_header(401);
      }
    }else{
      $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'login gagal', 'english'=>"logging failed"));
      $this->output->set_status_header(401);
    }
    echo json_encode($result);
  }
  public function login_process_admin()
  {
    $username = $this->input->post('username');
    $password = $this->input->post('password');
    $result['data'] = $this->api_model->login($username, $password)->result();
    if(count($result['data']) > 0){
      if($result['data'][0]->role == 'admin'){
        $session = array(
          'authenticated_admin'=>true,
          'data'=>$result['data'][0]
        );
        $this->session->set_userdata($session);
        $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'login berhasil', 'english'=>"you're logged"));
      }else{
        $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'kridensial yang digunakan bukan admin', 'english'=>"your kridential is not administrator"));
        $this->output->set_status_header(401);
      }
    }else{
      $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'login gagal', 'english'=>"logging failed"));
      $this->output->set_status_header(401);
    }
    echo json_encode($result);
  }

    // --------------------------------------------------- DYNAMIC FUNCTION -------------------------------
  public function insert_data($table, $data)
  {
    $result['data'] = $this->api_model->insert_data($table, $data);
      if($result['data']){
        $result['status'] = 'success';
        $result['message']['indonesia'] = 'berhasil ditambahkan';
        $result['message']['english'] = 'successful added';
      }else{
        $result['status'] = 'failed';
        $result['message']['indonesia'] = 'gagal ditambahkan';
        $result['message']['english'] = 'failed to add';
        $this->output->set_status_header(501);
      }
    echo json_encode($result);
  }
  public function response($message) 
  {
    $result['status'] = $message['status'];
    $result['message']['indonesia'] = $message['indonesia'];
    $result['message']['english'] = $message['english'];
    return $result;
  }

  public function send_message(){
    $name = $this->input->post('name');
    $email = $this->input->post('email');
    $comment = $this->input->post('comment');
    $subject = $this->input->post('subject');
    $message = $this->input->post('message');

    $data_template = array(
      'name'=>$name,
      'email'=>$email,
      'comment'=>$comment,
      'subject'=>$subject,
      'message'=>$message
    );
    $content = $this->email_template->template($data_template);
    $send_mail = array(
      'email_penerima'=>$email,
      'subjek'=>$subject,
      'content'=>$content,
    );
    $send = $this->mailer->send($send_mail);
    if($send['status']=="Sukses"){
      $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Terkirim', 'english'=>'Sent'));
      $this->output->set_status_header(200);
    }else{
      $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Gagal mengirim', 'english'=>'failed to send'));
      $this->output->set_status_header(501);
    }
    echo json_encode($result);
  }

  public function create_order()
  {
    if(!$this->session->userdata('authenticated_customer')){
			$this->login();
		}else{
      $secure_pin = $this->input->post('secure_pin');
      $id = $this->input->post('id');
      $auth = $this->db->query("SELECT * FROM users WHERE users.id = $id")->result()[0]->secure_pin;
      if($auth == md5($secure_pin)){
        $amount = $this->input->post('amount');
        $currency = $this->input->post('currency');
        $type = $this->input->post('type');
        if($type == 'pin'){
          $setting = json_decode($this->api_model->get_data_by_where('settings', array('key'=>'pin_register_price'))->result()[0]->content);
          $price = $setting->price;
          $total_payment = $amount * $price;
          $order_number = 'PR'.time().strtoupper(random_string('alnum', 4));
        }else if($type == 'lisensi'){
          $lisensi = $this->input->post('lisensi');
          $price = $this->api_model->get_data_by_where('lisensies', array('id'=>$lisensi))->result()[0]->price;
          $total_payment = $amount * $price;
          $order_number = 'L'.time().strtoupper(random_string('alnum', 5));
        }
        $insert = array(
          'order_number' => $order_number,
          'requested_by' => $id,
          'amount' => $amount,
          'total_payment' => $total_payment,
          'currency' => $currency
        );
        $this->db->trans_start();
        if($this->api_model->insert_data('orders', $insert)){
          if($type == 'lisensi'){
            $insert_detail_lisensi = array(
              'order_id' => $this->db->insert_id(),
              'lisensi_id' => $lisensi,
              'registered_by' => $id
            );
            if($this->api_model->insert_data('order_detail_lisensies', $insert_detail_lisensi)){
              $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Permitaan Berhasil', 'english'=>'Request Successful'));
            }else{
              $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Permintaan Gagal', 'english'=>'Request Failed'));
              $this->output->set_status_header(502);
            }
          }else{
            $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Permitaan Berhasil', 'english'=>'Request Successful'));
          }
        }else{
          $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Permintaan Gagal', 'english'=>'Request Failed'));
          $this->output->set_status_header(501);
        }
        $this->db->trans_complete();
      }else{
        $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Secure PIN anda salah', 'english'=>'Your Secure PIN is Wrong'));
        $this->output->set_status_header(401);
      }
      echo json_encode($result);
    }
  }
  public function register_process()
	{
			$name = $this->input->post('name');
			$email = $this->input->post('email');
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$secure_pin = $this->input->post('secure_pin');

      $auth = $this->db->query("SELECT * FROM users WHERE users.email = '$email' OR users.username = '$username'")->result();
      if(count($auth) == 0){
        $insert = array(
          'name' => $name,
          'email' => $email,
          'username' => $username,
          'password' => md5($password),
          'role' => "customer",
          'secure_pin' => md5($secure_pin)
        );
        if($this->api_model->insert_data('users', $insert)){
          $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Registrasi Berhasil', 'english'=>'Register Successful'));
        }else{
          $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Registrasi Gagal', 'english'=>'Register Failed'));
          $this->output->set_status_header(501);
        }
      }else{
        $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Email atau Username sudah terdaftar', 'english'=>'Email of Username has been registered'));
        $this->output->set_status_header(501);
      }
      echo json_encode($result);
		}
    public function upload_receipt($order_number)
    {
      if(!$this->session->userdata('authenticated_customer')){
        $this->login();
      }else{
        if(isset($_FILES['file']['name'])){
            /* Getting file name */
            $file = $_FILES['file']['name'];
            $remove_char = preg_replace("/[^a-zA-Z]/", "", $file);
            $filename = $order_number.'_'.time().$remove_char.'.jpg';
        
            /* Location */
            $location = "upload/receipt/pin/".$filename;
            $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
            $imageFileType = strtolower($imageFileType);
        
            /* Valid extensions */
            $valid_extensions = array("jpg","jpeg","png");
        
            $response = 0;
            /* Check file extension */
            if(in_array(strtolower($imageFileType), $valid_extensions)) {
              /* Upload file */
              if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
                if($this->api_model->update_data(array('order_number'=>$order_number), 'orders', array('receipt_of_payment'=>$filename))){
                  $response = $location;
                }else{
                  echo 0;
                }
              }
            }
            echo $response;
            exit;
        }
        echo 0;
      }
    }
  public function update_status_order()
  {
      $action = $this->input->post('action');
      $id = $this->input->post('id');
      switch($action){
        case "open":
          $update = $this->db->query("UPDATE `orders` SET `is_open` = '0', `is_pending` = '1' WHERE `orders`.`id` = $id");
          break;
        case "pending":
          $update = $this->db->query("UPDATE `orders` SET `is_pending` = '0', `is_finish` = '1' WHERE `orders`.`id` = $id");
          break;
        case "finish":
          break;
        case "reject":
          $update = $this->db->query("UPDATE `orders` SET `is_open` = '0', `is_pending` = '0', `is_finish` = '0', `is_reject` = '1' WHERE `orders`.`id` = $id");
          break;
      }
      if($update){
        $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Terupdate', 'english'=>'Updated'));
      }else{
        $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Update Gagal', 'english'=>'Update Failed'));
        $this->output->set_status_header(501);
      }
      echo json_encode($result);
  }
  public function generate_pin()
  {
    $id = $this->input->post('id');
    $order = $this->api_model->get_data_by_where('orders', array('id'=>$id))->result()[0];
    $get_amount = $order->amount;
    $user_register = $order->requested_by;
    $this->generate_process($get_amount, $user_register, $id);
  }
  public function generate_process($get_amount, $user_register, $id)
  {
    for($i=0;$i<$get_amount;$i++){
      $random_number = rand(1000,9999);
      if($this->api_model->insert_data('pin_register', array('pin'=>$random_number, 'registered_by'=>$user_register, 'order_id'=>$id))){
        $result['success'][] = $i;
      }else{
        $result['fail'][] = $i;
      }
    }
    if(count($result['success']) == $get_amount){
      $this->result_generate();
    }else{
      $this->generate_process(count($result['fail']), $user_register, $id);
    }
  }
  public function result_generate()
  {
    $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'PIN dibuat', 'english'=>'PIN has been generated'));
    echo json_encode($result);
  }
}

