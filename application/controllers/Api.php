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
    $this->load->library('upgrade');
		$this->load->library('pdf');
		$this->load->library('pdf2');
    $this->load->library('bonus');
    $this->load->library('secure_pin');
    $this->load->library('withdraw');
    $this->load->library('password');
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
    $user = $this->api_model->login($username, base64_decode($password))->result();
    if(count($user) > 0){
      if($user[0]->role == 'customer'){
        if(count($sponsor_code = $this->db->query("SELECT * FROM sponsor_codes a WHERE a.owner = ".$user[0]->id)->result()) > 0 ){
          $session = array(
            'authenticated_customer'=>true,
            'data'=>$user[0],
            'sponsor_code'=>$sponsor_code[0]
          );
          $this->session->set_userdata($session);
          $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Login berhasil', 'english'=>"You're logged"));
        }
      }else{
        $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Kridensial yang digunakan bukan customer', 'english'=>"Your kridential is not customer"));
        $this->output->set_status_header(401);
      }
    }else{
      $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Username atau Password tidak sesuai', 'english'=>"Username or Password is wrong"));
      $this->output->set_status_header(401);
    }
    echo json_encode($result);
  }
  public function login_process_admin()
  {
    $username = $this->input->post('username');
    $password = $this->input->post('password');
    $result['data'] = $this->api_model->login($username, base64_decode($password))->result();
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
  public function balance()
  {
    $id = $this->input->post('id');

    if(count($x = $this->api_model->get_data_by_where('total_bonuses', array('owner_id'=>$id))->result()) > 0 ){
      $result['balance'] = $x[0]->balance;
    }else{
      $result['balance'] = 0;
    }
    echo json_encode($result);

  }
  public function upgrade_licence()
  {
    if(!$this->session->userdata('authenticated_customer')){
			$this->login();
		}else{
      $secure_pin = $this->input->post('secure_pin');
      $id = $this->input->post('id');
      $upgrade_to = $this->input->post('upgrade_to');
      $payment = $this->input->post('payment');
      if($id != null){
        $auth = $this->db->query("SELECT * FROM users WHERE users.id = $id")->result()[0]->secure_pin;
      }else{
        $auth = 'empty';
      }
      if($auth == md5($secure_pin)){
        $data = $this->upgrade->licence($id, $upgrade_to, $payment);
        if($data['status']){
          $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Permintaan Berhasil', 'english'=>'Request Successful'));
          $result['data']['id'] = $data['id'];
        }else{
          $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Kesalahan [10001543]', 'english'=>$data['message']));
          $this->output->set_status_header(501);
        }
      }else{
        $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Secure PIN anda salah', 'english'=>'Your Secure PIN is Wrong'));
        $this->output->set_status_header(401);
      }
      echo json_encode($result);
    }
  }
  public function create_order()
  {
    if(!$this->session->userdata('authenticated_customer')){
			$this->login();
		}else{
      $secure_pin = $this->input->post('secure_pin');
      $id = $this->input->post('id');
      if($id != null){
        $auth = $this->db->query("SELECT * FROM users WHERE users.id = $id")->result()[0]->secure_pin;
      }else{
        $auth = 'empty';
      }
      if($auth == md5($secure_pin)){
        $amount = $this->input->post('amount');
        $currency = $this->input->post('currency');
        $type = $this->input->post('type');
        if($type == 'pin'){
          $setting = json_decode($this->api_model->get_data_by_where('settings', array('key'=>'pin_register_price'))->result()[0]->content);
          $price = $setting->price;
          $total_payment = $amount * $price;
          $order_number = 'PR'.time().strtoupper(random_string('alnum', 4));
          $this->db->trans_start();
          $insert = array(
            'order_number' => $order_number,
            'requested_by' => $id,
            'amount' => $amount,
            'total_payment' => $total_payment,
            'currency' => $currency
          );
          $this->api_model->insert_data('orders', $insert);
          $this->db->trans_complete();
          if($this->db->trans_status()){
            $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Permitaan Berhasil', 'english'=>'Request Successful'));
            $result['data']['order_number'] = $order_number; 
          }else{
            $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Permintaan Gagal', 'english'=>'Request Failed'));
            $this->output->set_status_header(502);
          }
        }else if($type == 'lisensi'){
          $check_lisensi = $this->api_model->get_data_by_where('user_lisensies', array('owner'=>$id, 'is_active'=>true))->result();
          if(count($check_lisensi) > 0){
            $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Anda telah memiliki Lisensi', 'english'=>'You already have a Lisensi'));
            $this->output->set_status_header(401);
          }else{
            $lisensi = $this->input->post('lisensi');
            $price = $this->api_model->get_data_by_where('lisensies', array('id'=>$lisensi))->result()[0]->price;
            $total_payment = $amount * $price;
            $order_number = 'L'.time().strtoupper(random_string('alnum', 5));
            $this->db->trans_start();
            $insert = array(
              'order_number' => $order_number,
              'requested_by' => $id,
              'amount' => $amount,
              'total_payment' => $total_payment,
              'currency' => $currency
            );
            $this->api_model->insert_data('orders', $insert);
            $id_order_lisensi = $this->db->insert_id();
            for($i=0;$i<$amount;$i++){
              $insert_detail_lisensi = array(
                'order_id' => $id_order_lisensi,
                'lisensi_id' => $lisensi,
                'owner' => $id
              );
              $this->api_model->insert_data('user_lisensies', $insert_detail_lisensi);
            }
            $this->db->trans_complete();
            if($this->db->trans_status()){
              $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Permitaan Berhasil', 'english'=>'Request Successful'));
              $result['data']['order_number'] = $order_number; 
            }else{
              $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Permintaan Gagal', 'english'=>'Request Failed'));
              $this->output->set_status_header(502);
            }
          }
        }
      }else{
        $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Secure PIN anda salah', 'english'=>'Your Secure PIN is Wrong'));
        $this->output->set_status_header(401);
      }
      echo json_encode($result);
    }
  }
  public function insert_turnover($user_id, $lisensi_price, $lisensi_id, $currency)
  {
    $this->db->trans_start();
    $child_id = $this->api_model->get_data_by_where('positions', array('bottom'=>$user_id))->result();;
    while(count($child_id) > 0) {
      $parent = $this->api_model->get_data_by_where('positions', array('bottom'=>$child_id[0]->id))->result();
      if(count($parent) > 0){
        $turnover = $this->api_model->get_data_by_where('turnovers', array('owner'=>$parent[0]->id))->result();
        if(count($turnover) > 0){
          if($parent[0]->position == 2){
            $position = 'right_belance';
            $bonus = $turnover[0]->right_belance + $lisensi_price;
          }else{
            $position = 'left_belance';
            $bonus = $turnover[0]->left_belance + $lisensi_price;
          }
          $this->api_model->update_data(array('id'=>$turnover[0]->id), 'turnovers', array($position => $bonus));
          $this->api_model->insert_data('turnover_details', array('turnover_id'=>$turnover[0]->id, 'position'=>$parent[0]->position, 'user_id'=>$child_id, 'lisensi_id'=>$lisensi_id, 'price_at_the_time'=>$lisensi_price, 'currency_at_the_time'=>$currency));
        }else{
          if($parent[0]->position == 2){
            $position = 'right_belance';
            $bonus = $lisensi_price;
          }else{
            $position = 'left_belance';
            $bonus = $lisensi_price;
          }
          $this->api_model->insert_data('turnovers', array('owner'=>$parent[0]->id, $position=>$lisensi_price));
          $last_turnover_id = $this->db->insert_id();
          $this->api_model->insert_data('turnover_details', array('turnover_id'=>$last_turnover_id, 'position'=>$parent[0]->position, 'user_id'=>$child_id, 'lisensi_id'=>$lisensi_id, 'price_at_the_time'=>$lisensi_price, 'currency_at_the_time'=>$currency));
        }
      }else{

      }
      $child_id = $this->api_model->get_data_by_where('positions', array('bottom'=>12))->result();
    }
    $this->db->trans_complete();
    if($this->db->trans_status()){
      return true;
    }else{
      return false;
    }
  }
  public function insert_detail_lisensi($id_order_lisensi, $amount, $lisensi, $id)
  {
    for($i=0;$i<$amount;$i++){
      $insert_detail_lisensi = array(
        'order_id' => $id_order_lisensi,
        'lisensi_id' => $lisensi,
        'owner' => $id
      );
      if($this->api_model->insert_data('user_lisensies', $insert_detail_lisensi)){
        $result['success'][] = $i; 
      }else{
        $result['failed'][] = $i;
      }
    }
    if(count($result['success']) == $amount){
      return true;
    }else{
      $this->insert_detail_lisensi($id_order_lisensi, count($result['failed']), $lisensi, $id);
    }
  }
  public function create_transfer()
  {
    if(!$this->session->userdata('authenticated_customer')){
			$this->login();
		}else{
      $secure_pin = $this->input->post('secure_pin');
      $id = $this->input->post('id');
      $recipient_username = $this->input->post('recipient_username');
      $type = $this->input->post('type');
      $auth = $this->db->query("SELECT * FROM users WHERE users.id = $id")->result()[0]->secure_pin;
      if($auth == md5($secure_pin)){
        $get_receive = $this->api_model->get_data_by_where('users', array('username'=>$recipient_username))->result();
        if(count($get_receive) != 0){
          if($type == 'pin'){
            $amount_transfer = $this->input->post('amount_transfer');
            $active_pin = $this->api_model->get_data_by_where('pin_register', array('registered_by'=>$id, 'is_active'=>true))->result();
            if(count($active_pin) >= $amount_transfer){
              if($this->process_transfer($recipient_username, 'PT', $id, $amount_transfer, $type, $get_receive, 'x')){
                $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Transfer Berhasil', 'english'=>'Transfer Success'));
              }else{
                $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Transfer Gagal', 'english'=>'Transfer Failed'));
                $this->output->set_status_header(501);
              }
            }else{
              $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Jumlah PIN aktif anda kurang', 'english'=>'Your active PIN not enough'));
              $this->output->set_status_header(501);
            }
          }else if($type == 'lisensi'){
            $lisensi_id = $this->input->post('lisensi_id');
            if($this->process_transfer($recipient_username, 'LT', $id, '1', $type, $get_receive, $lisensi_id)){
              $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Transfer Berhasil', 'english'=>'Transfer Success'));
            }
          }
        }else{
          $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Username penerima salah', 'english'=>'Recipient username is wrong'));
          $this->output->set_status_header(401);
        }
      }else{
        $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Secure PIN anda salah', 'english'=>'Your Secure PIN is Wrong'));
        $this->output->set_status_header(401);
      }
      echo json_encode($result);
    }
  }
  public function process_transfer($recipient_username, $code, $id, $amount_transfer, $type, $get_receive, $lisensi_id)
  {
              $transfer_number = $code.time().strtoupper(random_string('alnum', 4));
              $receive_by = $get_receive[0]->id;
              $insert = array(
                'transfer_number' => $transfer_number,
                'send_by' => $id,
                'receive_by' => $receive_by,
                'amount' => $amount_transfer
              );
              // $this->db->trans_start();
              if($this->api_model->insert_data('transfers', $insert)){
                $last_id = $this->db->insert_id();
                if($type == 'pin'){
                  $get_pin = $this->db->query("SELECT * FROM pin_register WHERE registered_by = $id AND is_active = true LIMIT $amount_transfer")->result();
                  if($this->transfer_pin_process($get_pin, $receive_by, $last_id, $id)){
                    return true;
                  }else{
                    return false;
                  }
                }else if($type == 'lisensi'){
                  if($this->transfer_lisensi($lisensi_id, $receive_by, $last_id, $id)){
                    return true;
                  }else{
                    return false;
                  }
                }
              }else{
                return false;
              }
              // $this->db->trans_complete();
  }
  public function transfer_lisensi($lisensi_id, $receive_by, $last_id, $id)
  {
    $insert = array(
      'transfer_id' => $last_id,
      'user_lisensi_id' => $lisensi_id
    );
    if($this->api_model->insert_data('transfer_details', $insert)){
      if($this->api_model->update_data(array('id'=>$lisensi_id), 'user_lisensies', array('owner'=>$receive_by))){
        return true;
      }
    }
  }
  public function transfer_pin_process($get_pin, $recipient_id, $last_id, $id)
  {
    $pin = count($get_pin);
    foreach($get_pin as $data){
      $insert = array(
        'transfer_id' => $last_id,
        'pin_id' => $data->id
      );
      if($this->api_model->insert_data('transfer_details', $insert)){
        if($this->api_model->update_data(array('id'=>$data->id), 'pin_register', array('registered_by'=>$recipient_id))){
          $result['success'][] = $data->id;
        }
      }else{
        $result['failed'][] = $data->id;
      }
    }
    if(count($result['success']) == count($get_pin)){
      return true;
    }else{
      $this->transfer_pin_process($result['failed'], $recipient_id, $last_id, $id);
    }
    
  }
  public function register_process()
	{
			$name = $this->input->post('name');
			$email = $this->input->post('email');
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$secure_pin = $this->input->post('secure_pin');
      $sponsor_code = $this->input->post('sponsor_code');
      $pin_register = $this->input->post('pin_register');
      $position = $this->input->post('position');
      $top_id = $this->input->post('top_id');

      // $this->db->trans_start();
      $check_position = $this->api_model->get_data_by_where('positions', array('position'=>$position, 'top'=>$top_id))->result();
      if(count($check_position) == 0){
        $check_sponsor = $this->api_model->get_data_by_where('sponsor_codes', array('code'=>$sponsor_code, 'is_active'=>true))->result();
        if(count($check_sponsor) == 1){
          $check_pin_register = $this->api_model->get_data_by_where('pin_register', array('pin'=>$pin_register, 'is_active'=>true))->result();
          if(count($check_pin_register) == 1){
            $auth = $this->db->query("SELECT * FROM users WHERE users.email = '$email' OR users.username = '$username'")->result();
            if(count($auth) == 0){
              $insert = array(
                'name' => strtoupper($name),
                'email' => $email,
                'username' => $username,
                'password' => md5($password),
                'role' => "customer",
                'secure_pin' => md5($secure_pin)
              );
              $this->db->trans_start();
              $this->api_model->insert_data('users', $insert);
              $last_id = $this->db->insert_id();
              $this->api_model->update_data(array('id'=>$check_pin_register[0]->id), 'pin_register', array('is_active'=>false, 'used_by'=>$last_id));
              $generate_sponsor = strtoupper(preg_replace("/[^a-zA-Z]/", "", substr($name,0,5).random_string('alnum', 3)));
              $sponsor_code = $generate_sponsor.rand(1,1000);
              $sponsor_insert = array(
                'code' => $sponsor_code,
                'owner' => $last_id
              );
              $this->api_model->insert_data('sponsor_codes', $sponsor_insert);
              $last_id_sponsor = $this->db->insert_id();
              $aponsor_use_insert = array(
                'sponsor_id' => $check_sponsor[0]->id,
                'used_by' => $last_id
              );
              $this->api_model->insert_data('sponsor_code_uses', $aponsor_use_insert);
              $insert_position = array(
                'position' => $position,
                'top' => $top_id,
                'bottom' => $last_id
              );
              $this->api_model->insert_data('positions', $insert_position);
              $this->db->trans_complete();
              if($this->db->trans_status()){
                $data_template = array(
                  'opening'=> 'Hi '.$name.', Terima kasih telah mendaftar di '.$this->db->query("SELECT * FROM settings a WHERE a.key = 'sistem_name'")->result()[0]->content.' <br>',
                  'email'=>$email,
                  'message'=>'Username : '.$username.' <br> Password : (gunakan password yang diinputkan) <br> Tanggal Registrasi : '.date("l, d M Y H:m:s").'<br> SEGERALAH MEMBELI PAKET LISENSI,
                  MELALUI ADMIN : '.$this->db->query("SELECT * FROM settings a WHERE a.key = 'phone_number'")->result()[0]->content.' <br>
                  Email : '.$this->db->query("SELECT * FROM settings a WHERE a.key = 'email'")->result()[0]->content.' <br>
                  Best Regards, <br>
                  PT. Windax Digital Indonesia'
                );
                $content = $this->email_template->template($data_template);
                $send_mail = array(
                  'email_penerima'=>$email,
                  'subjek'=>'Registration',
                  'content'=>$content,
                );
                $send = $this->mailer->send($send_mail);
                if($send['status']=="Sukses"){
                  $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Registrasi Berhasil', 'english'=>'Register Successful'));
                }else{
                  $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Registrasi Berhasil Namun Email Gagal Terkirim', 'english'=>'Register Success, But email failed send to you'));
                  $this->output->set_status_header(500);
                }
              }else{
                $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Registrasi Gagal', 'english'=>'Register Failed'));
                $this->output->set_status_header(500);
              }
            }else{
              $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Email atau Username sudah terdaftar', 'english'=>'Email of Username has been registered'));
              $this->output->set_status_header(501);
            }
          }else{
            $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'PIN Register tidak tersedia atau salah', 'english'=>'PIN Register unavailable or wrong'));
            $this->output->set_status_header(501);
          }
        }else{
          $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Kode Sponsor tidak tersedia atau salah', 'english'=>'Sponsor code unavailable or wrong'));
          $this->output->set_status_header(501);
        }
      }else{
        $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Posisi sudah terisi', 'english'=>'This position already with another person'));
        $this->output->set_status_header(501);
      }
      // $this->db->trans_complete();
      echo json_encode($result);
		}
    public function send_email(){
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
    public function upload_receipt_upgrade($id)
    {
      if(!$this->session->userdata('authenticated_customer')){
        $this->login();
      }else{
        if(isset($_FILES['file']['name'])){
            /* Getting file name */
            $file = $_FILES['file']['name'];
            $remove_char = preg_replace("/[^a-zA-Z]/", "", $file);
            $filename = $id.'_'.time().$remove_char.'.jpg';
        
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
                if($this->api_model->update_data(array('id'=>$id), 'lisensi_upgrades', array('receipt_of_payment'=>$filename))){
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
  public function update_status_order_test()
  {
    $action = $this->input->post('action');
    $id = $this->input->post('id');
    switch($action){
      case "pending":
        $this->db->trans_start();
        $this->bonus->sponsor_count($id);
        $this->bonus->update_omset($id);
        $this->api_model->update_data(array('order_id'=>$id), 'user_lisensies', array('is_active'=>true));
        $this->db->query("UPDATE `orders` SET `is_pending` = '0', `is_finish` = '1' WHERE `orders`.`id` = $id");
        $this->db->trans_complete();
        if($this->db->trans_status()){
          $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Terupdate', 'english'=>'Updated'));
        }else{
          $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Update Gagal', 'english'=>'Update Failed'));
          $this->output->set_status_header(501);
        }
        echo json_encode($result);
        break;
      case "reject":
        $update = $this->db->query("UPDATE `orders` SET `is_open` = '0', `is_pending` = '0', `is_finish` = '0', `is_reject` = '1' WHERE `orders`.`id` = $id");
        if($update){
          $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Terupdate', 'english'=>'Updated'));
        }else{
          $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Update Gagal', 'english'=>'Update Failed'));
          $this->output->set_status_header(501);
        }
        echo json_encode($result);
        break;
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
          $order = $this->api_model->get_data_by_where('orders', array('id'=>$id))->result()[0];
          $lisensi = $this->db->query("SELECT a.*, b.price AS lisensi_price, b.id AS lisensi_id FROM user_lisensies a INNER JOIN lisensies b ON b.id=a.lisensi_id WHERE a.owner = $order->requested_by")->result();
          $lisensi_id = $lisensi[0]->lisensi_id;
          $lisensi_price = $lisensi[0]->lisensi_price;
          $currency = $this->api_model->get_data_by_where('settings', array('key'=>'lisensi_currency'))->result()[0]->content;
          $owner_id = $this->db->query("SELECT a.*, c.id AS owner_id FROM sponsor_code_uses a INNER JOIN sponsor_codes b ON b.id=a.sponsor_id INNER JOIN users c ON c.id=b.owner WHERE a.used_by = $order->requested_by")->result()[0]->owner_id;
          $percentage = $this->db->query("SELECT * FROM settings a WHERE a.key = 'percentage_sponsor_bonus'")->result()[0]->content;
          $bonus_sponsor_fix = $lisensi_price / 100 * $percentage;
          if(count($sponsor_code_bonuses = $this->api_model->get_data_by_where('sponsor_code_bonuses', array('owner_id'=>$owner_id))->result()) == 0){
            $insert_sponsor_bonus = array(
              'owner_id'=>$owner_id,
              'balance'=>$bonus_sponsor_fix
            );
            $this->db->trans_start();
            $this->api_model->insert_data('sponsor_code_bonuses', $insert_sponsor_bonus);
            $sponsor_code_bonus_id = $this->db->insert_id();
            $this->db->trans_complete();
            if($this->db->trans_status()){
              $insert_sponsor_bonus_detail = array(
                'sponsor_code_bonus_id' => $sponsor_code_bonus_id,
                'register_bonus_by' => $order->requested_by,
                'lisensies_id' => $lisensi_id,
                'currency_at_the_time' => $currency,
                'belance' => $lisensi_price,
                'percentage_at_the_time' => $percentage
              );
              if($this->api_model->insert_data('sponsor_code_bonus_details', $insert_sponsor_bonus_detail)){
                $user_id_req  = $order->requested_by;
                $user_id = $order->requested_by;
                while(count($top = $this->api_model->get_data_by_where('positions', array('bottom'=>$user_id))->result()) == 1){
                  $top_id = $top[0]->top;
                  $position = $top[0]->position;
                  if(count($turnover = $this->api_model->get_data_by_where('turnovers', array('owner'=>$top_id))->result()) == 1){
                    $turnover_id = $turnover[0]->id;
                    if($position == 1){
                      $new_belance = $turnover[0]->left_belance + $lisensi_price;
                      $this->api_model->update_data(array('owner'=>$top_id), 'turnovers', array('left_belance'=>$new_belance, 'is_active'=>false));
                    }else{
                      $new_belance = $turnover[0]->right_belance + $lisensi_price;
                      $this->api_model->update_data(array('owner'=>$top_id), 'turnovers', array('right_belance'=>$new_belance, 'is_active'=>false));
                    }
                  }else{
                    if($position == 1){
                      $this->api_model->insert_data('turnovers', array('owner'=>$top_id, 'left_belance'=>$lisensi_price));
                      $turnover_id = $this->db->insert_id();
                    }else{
                      $this->api_model->insert_data('turnovers', array('owner'=>$top_id, 'right_belance'=>$lisensi_price));
                      $turnover_id = $this->db->insert_id();
                    }
                  }
                  $this->api_model->insert_data('turnover_details', array('turnover_id'=>$turnover_id, 'position'=>$position, 'user_id'=>$user_id_req, 'lisensi_id'=>$lisensi_id, 'price_at_the_time'=>$lisensi_price, 'currency_at_the_time'=>$currency));
                  $user_id = $top_id;
                }
               
                $x = $this->api_model->get_data_by_where('total_bonuses', array('owner_id'=>$owner_id))->result();
                if(count($x) > 0){
                    $balance = $x[0]->balance + $bonus_sponsor_fix;
                    $id_inout = 'BI'.time().'-'.$owner_id;
                    $this->db->trans_start();
                    $this->api_model->update_data(array('order_id'=>$id), 'user_lisensies', array('is_active'=>true));
                    $this->db->query("UPDATE `orders` SET `is_pending` = '0', `is_finish` = '1' WHERE `orders`.`id` = $id");
                    $this->api_model->update_data(array('id'=>$x[0]->id), 'total_bonuses', array('balance'=>$balance));
                    $this->api_model->insert_data('inout_bonuses', array('id_inout'=>$id_inout, 'type'=>1, 'balance'=>$bonus_sponsor_fix, 'note'=>'sponsor bonus', 'total_bonus_id'=>$x[0]->id));
                    $this->db->trans_complete();
                    if($this->db->trans_status()){
                      $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Terupdate', 'english'=>'Updated'));
                    }else{
                      $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Update Gagal', 'english'=>'Update Failed'));
                      $this->output->set_status_header(501);
                    }
                    echo json_encode($result);
                }else{
                    $balance = $bonus_sponsor_fix;
                    $id_inout = 'BI'.time().'-'.$owner_id;
                    $this->db->trans_start();
                    $this->api_model->update_data(array('order_id'=>$id), 'user_lisensies', array('is_active'=>true));
                    $this->db->query("UPDATE `orders` SET `is_pending` = '0', `is_finish` = '1' WHERE `orders`.`id` = $id");
                    $this->api_model->insert_data('total_bonuses', array('owner_id'=>$owner_id, 'balance'=>$balance));
                    $this->api_model->insert_data('inout_bonuses', array('id_inout'=>$id_inout, 'type'=>1, 'balance'=>$bonus_sponsor_fix, 'note'=>'sponsor bonus', 'total_bonus_id'=>$this->db->insert_id()));
                    $this->db->trans_complete();
                    if($this->db->trans_status()){
                      $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Terupdate', 'english'=>'Updated'));
                    }else{
                      $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Update Gagal', 'english'=>'Update Failed'));
                      $this->output->set_status_header(501);
                    }
                    echo json_encode($result);
                }
              }else{
                $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Update Gagal', 'english'=>'Update Failed'));
                $this->output->set_status_header(501);
                echo json_encode($result);
              }
            }else{
              $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Update Gagal', 'english'=>'Update Failed'));
              $this->output->set_status_header(501);
              echo json_encode($result);
            }
          }else{
            if($this->db->query("UPDATE `sponsor_code_bonuses` SET `balance` = balance+$bonus_sponsor_fix WHERE `sponsor_code_bonuses`.`id` = ".$sponsor_code_bonuses[0]->id)){
              $sponsor_code_bonus_id = $sponsor_code_bonuses[0]->id;
              $update_sponsor_bonus_detail = array(
                'sponsor_code_bonus_id' => $sponsor_code_bonus_id,
                'register_bonus_by' => $order->requested_by,
                'lisensies_id' => $lisensi_id,
                'currency_at_the_time' => $currency,
                'belance' => $lisensi_price,
                'percentage_at_the_time' => $percentage
              );
              if($this->api_model->insert_data('sponsor_code_bonus_details', $update_sponsor_bonus_detail)){
                $user_id_req  = $order->requested_by;
                $user_id = $order->requested_by;
                while(count($top = $this->api_model->get_data_by_where('positions', array('bottom'=>$user_id))->result()) == 1){
                  $top_id = $top[0]->top;
                  $position = $top[0]->position;
                  if(count($turnover = $this->api_model->get_data_by_where('turnovers', array('owner'=>$top_id))->result()) == 1){
                    $turnover_id = $turnover[0]->id;
                    if($position == 1){
                      $new_belance = $turnover[0]->left_belance + $lisensi_price;
                      $this->api_model->update_data(array('owner'=>$top_id), 'turnovers', array('left_belance'=>$new_belance, 'is_active'=>false));
                    }else{
                      $new_belance = $turnover[0]->right_belance + $lisensi_price;
                      $this->api_model->update_data(array('owner'=>$top_id), 'turnovers', array('right_belance'=>$new_belance, 'is_active'=>false));
                    }
                  }else{
                    if($position == 1){
                      $this->api_model->insert_data('turnovers', array('owner'=>$top_id, 'left_belance'=>$lisensi_price));
                      $turnover_id = $this->db->insert_id();
                    }else{
                      $this->api_model->insert_data('turnovers', array('owner'=>$top_id, 'right_belance'=>$lisensi_price));
                      $turnover_id = $this->db->insert_id();
                    }
                  }
                  $this->api_model->insert_data('turnover_details', array('turnover_id'=>$turnover_id, 'position'=>$position, 'user_id'=>$user_id_req, 'lisensi_id'=>$lisensi_id, 'price_at_the_time'=>$lisensi_price, 'currency_at_the_time'=>$currency));
                  $user_id = $top_id;
                }
                $x = $this->api_model->get_data_by_where('total_bonuses', array('owner_id'=>$owner_id))->result();
                if(count($x) > 0){
                    $balance = $x[0]->balance + $bonus_sponsor_fix;
                    $id_inout = 'BI'.time().'-'.$owner_id;
                    $this->db->trans_start();
                    $this->api_model->update_data(array('order_id'=>$id), 'user_lisensies', array('is_active'=>true));
                    $this->db->query("UPDATE `orders` SET `is_pending` = '0', `is_finish` = '1' WHERE `orders`.`id` = $id");
                    $this->api_model->update_data(array('id'=>$x[0]->id), 'total_bonuses', array('balance'=>$balance));
                    $this->api_model->insert_data('inout_bonuses', array('id_inout'=>$id_inout, 'type'=>1, 'balance'=>$bonus_sponsor_fix, 'note'=>'sponsor bonus', 'total_bonus_id'=>$x[0]->id));
                    $this->db->trans_complete();
                    if($this->db->trans_status()){
                      $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Terupdate', 'english'=>'Updated'));
                    }else{
                      $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Update Gagal', 'english'=>'Update Failed'));
                      $this->output->set_status_header(501);
                    }
                    echo json_encode($result);
                }else{
                    $balance = $bonus_sponsor_fix;
                    $id_inout = 'BI'.time().'-'.$owner_id;
                    $this->db->trans_start();
                    $this->api_model->update_data(array('order_id'=>$id), 'user_lisensies', array('is_active'=>true));
                    $this->db->query("UPDATE `orders` SET `is_pending` = '0', `is_finish` = '1' WHERE `orders`.`id` = $id");
                    $this->api_model->insert_data('total_bonuses', array('owner_id'=>$owner_id, 'balance'=>$balance));
                    $this->api_model->insert_data('inout_bonuses', array('id_inout'=>$id_inout, 'type'=>1, 'balance'=>$bonus_sponsor_fix, 'note'=>'sponsor bonus', 'total_bonus_id'=>$this->db->insert_id()));
                    $this->db->trans_complete();
                    if($this->db->trans_status()){
                      $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Terupdate', 'english'=>'Updated'));
                    }else{
                      $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Update Gagal', 'english'=>'Update Failed'));
                      $this->output->set_status_header(501);
                    }
                    echo json_encode($result);
                }
              }else{
                $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Update Gagal', 'english'=>'Update Failed'));
                $this->output->set_status_header(501);
                echo json_encode($result);
              }
            }else{
              $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Update Gagal', 'english'=>'Update Failed'));
              $this->output->set_status_header(501);
              echo json_encode($result);
            }
          }
          // echo json_encode($owner_id);
          break;
        case "finish":
          break;
        case "reject":
          $this->db->trans_start();
          $this->db->query("UPDATE `orders` SET `is_open` = '0', `is_pending` = '0', `is_finish` = '0', `is_reject` = '1' WHERE `orders`.`id` = $id");
          $this->db->query("DELETE FROM `user_lisensies` WHERE `user_lisensies`.`order_id` = $id");
          $this->db->trans_complete();
          if($this->db->trans_status()){
            $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Terupdate', 'english'=>'Updated'));
          }else{
            $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Update Gagal', 'english'=>'Update Failed'));
            $this->output->set_status_header(501);
          }
          echo json_encode($result);
          break;
      }
  }
  public function update_status_order_pin()
  {
      $action = $this->input->post('action');
      $id = $this->input->post('id');
      switch($action){
        case "open":
          $update = $this->db->query("UPDATE `orders` SET `is_open` = '0', `is_pending` = '1' WHERE `orders`.`id` = $id");
          break;
        case "pending":
          $update = $this->db->query("UPDATE `orders` SET `is_pending` = '0', `is_finish` = '1' WHERE `orders`.`id` = $id");
          if($update){
            $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Terupdate', 'english'=>'Updated'));
          }else{
            $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Update Gagal', 'english'=>'Update Failed'));
            $this->output->set_status_header(501);
          }
          echo json_encode($result);
          break;
        case "finish":
          break;
        case "reject":
          $update = $this->db->query("UPDATE `orders` SET `is_open` = '0', `is_pending` = '0', `is_finish` = '0', `is_reject` = '1' WHERE `orders`.`id` = $id");
          if($update){
            $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Terupdate', 'english'=>'Updated'));
          }else{
            $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Update Gagal', 'english'=>'Update Failed'));
            $this->output->set_status_header(501);
          }
          echo json_encode($result);
          break;
      }
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
      $random_number = rand(10000000,99999999);
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
  public function update_status_company_profile()
  {
    $sistem_name = $this->input->post('sistem_name');
    $phone_number = $this->input->post('phone_number');
    $email = $this->input->post('email');
    $address = $this->input->post('address');

    $this->db->trans_start();
    $this->api_model->update_data(array('key'=>'sistem_name'), 'settings', array('content'=>$sistem_name));
    $this->api_model->update_data(array('key'=>'phone_number'), 'settings', array('content'=>$phone_number));
    $this->api_model->update_data(array('key'=>'email'), 'settings', array('content'=>$email));
    $this->api_model->update_data(array('key'=>'address'), 'settings', array('content'=>$address));
    $this->db->trans_complete();
    if($this->db->trans_status()){
      $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Terupdate', 'english'=>'Updated'));
    }else{
      $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Update Gagal', 'english'=>'Update Failed'));
      $this->output->set_status_header(501);
    }
    echo json_encode($result);
  }
  public function update_pin_register()
  {
    $price = $this->input->post('price');
    $currency = $this->input->post('currency');

    $json = '{"price":'.$price.',"currency":"'.$currency.'"}';
    $this->db->trans_start();
    $this->api_model->update_data(array('key'=>'pin_register_price'), 'settings', array('content'=>$json));
    $this->db->trans_complete();
    if($this->db->trans_status()){
      $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Terupdate', 'english'=>'Updated'));
    }else{
      $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Update Gagal', 'english'=>'Update Failed'));
      $this->output->set_status_header(501);
    }
    echo json_encode($result);

  }
  public function update_licence_setting()
  {
    $name = $this->input->post('name');
    $id = $this->input->post('id');
    $price = $this->input->post('price');
    $percentage = $this->input->post('percentage');
    if($this->api_model->update_data(array('id'=>$id), 'lisensies', array('name'=>$name, 'price'=>$price, 'percentage'=>$percentage))){
      $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Terupdate', 'english'=>'Updated'));
    }else{
      $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Update Gagal', 'english'=>'Update Failed'));
      $this->output->set_status_header(501);
    }
    echo json_encode($result);

  }
  public function update_instruction()
  {
    $instruction = $this->input->post('instruction');
    if($this->api_model->update_data(array('key'=>'payment_tutorial'), 'settings', array('content'=>$instruction))){
      $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Terupdate', 'english'=>'Updated'));
    }else{
      $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Update Gagal', 'english'=>'Update Failed'));
      $this->output->set_status_header(501);
    }
    echo json_encode($result);

  }
  public function update_logo()
    {
      if(!$this->session->userdata('authenticated_admin')){
        $this->login();
      }else{
        if(isset($_FILES['file']['name'])){
            /* Getting file name */
            $file = $_FILES['file']['name'];
            $remove_char = preg_replace("/[^a-zA-Z]/", "", $file);
            $filename = 'LOGO_'.time().$remove_char.'.jpg';
        
            /* Location */
            $location = "upload/company/".$filename;
            $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
            $imageFileType = strtolower($imageFileType);
        
            /* Valid extensions */
            $valid_extensions = array("jpg","jpeg","png");
        
            $response = 0;
            /* Check file extension */
            if(in_array(strtolower($imageFileType), $valid_extensions)) {
              /* Upload file */
              if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
                if($this->api_model->update_data(array('key'=>'logo'), 'settings', array('content'=>$filename))){
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
    public function total_bonus()
    {
      $id = $this->input->post('id');
      if($id != null){
        $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Data ditemukan', 'english'=>'Data founded'));
        $result['data'] = $this->bonus->total($id);
      }else{
        $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Memerlukan ID customer', 'english'=>'ID customer is required'));
        $this->output->set_status_header(401);
      }
      echo json_encode($result);
    }
    public function pairing_bonus()
    {
      $id = $this->input->post('id');
      if($id != null){
        $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Data ditemukan', 'english'=>'Data founded'));
        $result['data'] = $this->bonus->total($id);
      }else{
        $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Memerlukan ID customer', 'english'=>'ID customer is required'));
        $this->output->set_status_header(401);
      }
      echo json_encode($result);
    }
    public function withdraw()
    {
      $id = $this->input->post('id');
      $amount = $this->input->post('amount');
      $secure_pin = base64_decode($this->input->post('secure_pin'));
      if($id != null){
        if($amount != null){
          if($secure_pin != null){
            if($this->secure_pin->check(array('id'=>$id, 'secure_pin'=>md5($secure_pin)))){
              $insert = array(
                'order_number'=>'W'.time().'-'.$id,
                'user_id' => $id,
                'amount' => $amount,
                'status' => 1
              );
              if($this->withdraw->request($insert)){
                $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Permintaan terkirim', 'english'=>'Request successful'));
              }else{
                $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Permintaan gagal', 'english'=>'Request failed'));
                $this->output->set_status_header(501);
              }
            }else{
              $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Secure PIN salah', 'english'=>'Secure PIN is wrong'));
              $this->output->set_status_header(401);
            }
          }else{
            $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Memerlukan ID customer', 'english'=>'Secure PIN is required'));
            $this->output->set_status_header(401);
          }
        }else{
          $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Memerlukan ID jumlah penarikan', 'english'=>'Amount is required'));
          $this->output->set_status_header(401);
        }
      }else{
        $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Memerlukan ID customer', 'english'=>'ID customer is required'));
        $this->output->set_status_header(401);
      }
      echo json_encode($result);
    }
    public function withdraw_detail()
    {
      $id = $this->input->post('id');
      if($id != ''){
        $data = $this->withdraw->detail($id);
        if($data != false){
          $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Data ditemukan', 'english'=>'Data founded'));
          $result['data'] = $data;
        }else{
          $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Data tidak ditemukan', 'english'=>'Data not found'));
          $this->output->set_status_header(401);
        }
      }else{
        $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Memerlukan ID', 'english'=>'ID is required'));
        $this->output->set_status_header(401);
      }
      echo json_encode($result);
    }
    public function update_status_withdraw()
    {
      $id = $this->input->post('id');
      $status = $this->input->post('status');
      if($id != ''){
        if($status != ''){
          if($this->withdraw->update_status(array('id'=>$id, 'status'=>$status))){
            $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Update berhasil', 'english'=>'Updated'));
          }else{
            $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Update gagal', 'english'=>'Update failed'));
            $this->output->set_status_header(501);
          }
        }else{
          $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Memerlukan Status', 'english'=>'Status is required'));
          $this->output->set_status_header(401);
        }
      }else{
        $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Memerlukan ID', 'english'=>'ID is required'));
        $this->output->set_status_header(401);
      }
      echo json_encode($result);
    }
    public function forgot_password()
    {
      $email = $this->input->post('email');
      $user = $this->api_model->get_data_by_where('users', array('email'=>$email))->result();
      if(count($user) > 0){
        if($this->password->forgot($email)){
          $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Email terkirim, MOHON CEK INBOX, SPAM ATAU PROMOSI', 'english'=>'Email sent, PLEASE CHECK INBOX, SPAM OR PROMOTION'));
        }else{
          $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Gagal kirim email', 'english'=>'Failed to send email'));
          $this->output->set_status_header(500);
        }
      }else{
        $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Tidak ada pengguna yang menggunakan email tersebut', 'english'=>'No one else use this email'));
        $this->output->set_status_header(401);
      }
      echo json_encode($result);
    }
    public function reset_password()
    {
      $password = $this->input->post('password');
      $password_confirm = $this->input->post('password_confirm');
      $id = $this->input->post('id');
      if($id != ''){
        if($password != ''){
          if($password_confirm != ''){
            if($password == $password_confirm){
              $data = array(
                'id' => $id,
                'insert' => array(
                  'password' => md5($password)
                )
              );
              if($this->password->reset($data)){
                $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Password Berubah', 'english'=>'Password Changed'));
              }else{
                $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Gagal mengubah password', 'english'=>'Failed to change password'));
                $this->output->set_status_header(401);
              }
            }else{
              $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Password tidak cocok', 'english'=>'Password not match'));
              $this->output->set_status_header(401);
            }
          }else{
            $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Password konfirmasi kosong', 'english'=>'Confirm Password is empty'));
            $this->output->set_status_header(401);
          }
        }else{
          $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Password kosong', 'english'=>'Password is empty'));
          $this->output->set_status_header(401);
        }
      }else{
        $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'ID diperlukan', 'english'=>'ID is required'));
        $this->output->set_status_header(401);
      }
      echo json_encode($result);
    }
    public function change_secure_pin()
    {
      $id = $this->input->post('id');
      $old_pin = $this->input->post('old_pin');
      $new_pin = $this->input->post('new_pin');
      $new_pin_confirm = $this->input->post('new_pin_confirm');
      if($id != ''){
        if($old_pin != ''){
          if($new_pin != ''){
            if($new_pin_confirm != ''){
              if($new_pin == $new_pin_confirm){
                $data = array(
                  'id'=>$id,
                  'insert' => array(
                    'secure_pin'=>md5($new_pin)
                  )
                );
                $user = $this->api_model->get_data_by_where('users', array('id'=>$id))->result();
                if(count($user) > 0){
                  if(md5($old_pin) == $user[0]->secure_pin){
                    if($this->password->change_secure_pin($data)){
                      $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Ganti PIN sukses', 'english'=>'Change PIN successful'));
                    }else{
                      $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Gagal ganti PIN', 'english'=>'Failed to change PIN'));
                      $this->output->set_status_header(401);
                    }
                  }else{
                    $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'PIN lama tidak sesuai', 'english'=>'Old PIN is wrong'));
                    $this->output->set_status_header(401);
                  }
                }else{
                  $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'User tidak ada', 'english'=>'User not found'));
                  $this->output->set_status_header(401);
                }
              }else{
                $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'PIN baru tidak sama', 'english'=>'New PIN not match'));
                $this->output->set_status_header(401);
              }
            }else{
              $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'PIN konfirmasi baru kosong', 'english'=>'New PIN confirm is empty'));
              $this->output->set_status_header(401);
            }
          }else{
            $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'PIN baru kosong', 'english'=>'New PIN is empty'));
            $this->output->set_status_header(401);
          }
        }else{
          $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'PIN lama kosong', 'english'=>'Old PIN is empty'));
          $this->output->set_status_header(401);
        }
      }else{
        $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'ID diperlukan', 'english'=>'ID is required'));
        $this->output->set_status_header(401);
      }
      echo json_encode($result);
    }
    public function user_detail()
    {
      $id = $this->input->post('id');
      if($id != ''){
        $data = $this->api_model->get_data_by_where('users', array('id'=>$id))->result();
        if(count($data) > 0){
          $result['data'] = $data[0];
          $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Data ditemukan', 'english'=>'Data founded'));
        }else{
          $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Data tidak ditemukan', 'english'=>'Data not found'));
          $this->output->set_status_header(401);
        }
      }else{
        $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'ID diperlukan', 'english'=>'ID is required'));
        $this->output->set_status_header(401);
      }
      echo json_encode($result);
    }
    public function change_password()
    {
      $old_password = $this->input->post('old_password');
      $password = $this->input->post('password');
      $password_confirm = $this->input->post('password_confirm');
      $id = $this->input->post('id');
      if($id != ''){
        if($old_password != ''){
          if($password != ''){
            if($password_confirm != ''){
              if($password == $password_confirm){
                $data = array(
                  'id' => $id,
                  'old_password' => $old_password,
                  'insert' => array(
                    'password' => md5($password)
                  )
                );
                if($this->password->change_password($data)){
                  $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Password Berubah', 'english'=>'Password Changed'));
                }else{
                  $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Gagal mengubah password', 'english'=>'Failed to change password'));
                  $this->output->set_status_header(401);
                }
              }else{
                $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Password tidak cocok', 'english'=>'Password not match'));
                $this->output->set_status_header(401);
              }
            }else{
              $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Password konfirmasi kosong', 'english'=>'Confirm Password is empty'));
              $this->output->set_status_header(401);
            }
          }else{
            $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Password kosong', 'english'=>'Password is empty'));
            $this->output->set_status_header(401);
          }
        }else{
          $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Password lama kosong', 'english'=>'Old password is empty'));
          $this->output->set_status_header(401);
        }
      }else{
        $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'ID diperlukan', 'english'=>'ID is required'));
        $this->output->set_status_header(401);
      }
      echo json_encode($result);
    }
    public function update_profile_picture($id)
    {
        if(isset($_FILES['file']['name'])){
            /* Getting file name */
            $file = $_FILES['file']['name'];
            $remove_char = preg_replace("/[^a-zA-Z]/", "", $file);
            $filename = $id.'_'.time().$remove_char.'.jpg';
        
            /* Location */
            $location = "upload/members/".$filename;
            $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
            $imageFileType = strtolower($imageFileType);
        
            /* Valid extensions */
            $valid_extensions = array("jpg","jpeg","png");
        
            $response = 0;
            /* Check file extension */
            if(in_array(strtolower($imageFileType), $valid_extensions)) {
              /* Upload file */
              if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
                if($this->api_model->update_data(array('id'=>$id), 'users', array('profile_picture'=>$filename))){
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
    public function get_pairing()
    {
      // $turnover = $this->db->qr
    }
    public function upgrade_licence_update_status()
    {
      $order_id = $this->input->post('order_id');
      $status = $this->input->post('status');
      $lisensi_id = $this->input->post('lisensi_id');
      $user_id = $this->input->post('user_id');
      if($order_id != null){
        if($status != null){
          switch($status){
            case 1:
              $this->db->trans_start();
              $this->api_model->update_data(array('id'=>$order_id), 'lisensi_upgrades', array('is_finish'=>1));
              $this->api_model->update_data(array('owner'=>$user_id), 'user_lisensies', array('lisensi_id'=>$lisensi_id));
              $this->db->trans_complete();
              if($this->db->trans_status()){
                $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Lisensi Terupdate', 'english'=>'Licence Upgraded'));
              }else{
                $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Gagal', 'english'=>'Failed'));
                $this->output->set_status_header(500);
              }
              break;
            case 2:
              $this->db->trans_start();
              $this->api_model->update_data(array('order_id'=>$order_id), 'lisensi_upgrades', array('is_finish'=>2));
              $this->db->trans_complete();
              if($this->db->trans_status()){
                $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Lisensi Ditolak', 'english'=>'Licence Rejected'));
              }else{
                $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Gagal', 'english'=>'Failed'));
                $this->output->set_status_header(500);
              }
              break;
          }
        }else{
          $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Status kosong', 'english'=>'Status required'));
          $this->output->set_status_header(500);
        }
      }else{
        $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'ID dibutuhkan', 'english'=>'ID required'));
        $this->output->set_status_header(500);
      }
      echo json_encode($result);
    }
    public function upgrade_licence_with_balance()
    {
      $id = $this->input->post('id');
      $lisensi_id = $this->input->post('lisensi_id');
      $secure_pin = $this->input->post('secure_pin');

      if($id != null){
        if($lisensi_id != null){
          $balance = $this->api_model->get_data_by_where('total_bonuses', array('owner_id'=>$id))->result();
          if(count($balance) > 0){
            $lisensi = $this->api_model->get_data_by_where('lisensies', array('id'=>$lisensi_id))->result();
            if(count($lisensi) > 0){
              $user_lisensi = $this->db->query("SELECT a.*, b.price AS price, c.secure_pin AS secure_pin FROM user_lisensies a INNER JOIN lisensies b ON b.id=a.lisensi_id INNER JOIN users c ON c.id=a.owner WHERE a.owner = $id AND a.is_active = true")->result();
              if(count($user_lisensi) > 0 && $user_lisensi[0]->secure_pin == md5($secure_pin)){
                $diff_balance = $lisensi[0]->price - $user_lisensi[0]->price;
                if($balance[0]->balance >= $diff_balance){
                  if($this->api_model->update_data(array('owner'=>$id), 'user_lisensies', array('lisensi_id'=>$lisensi_id))){
                    $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Lisensi Terupdate', 'english'=>'Licence Upgraded'));
                  }else{
                    $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Gagal', 'english'=>'Failed'));
                    $this->output->set_status_header(500);
                  }
                }else{
                  $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Saldo Bonus Tidak Cukup', 'english'=>'Balance Enough'));
                  $this->output->set_status_header(402);
                }
              }else{
                $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Lisensi Anda Tidak Ditemukan atau Secure PIN salah', 'english'=>'Your Licence Not Found or Secure PIN is wrong'));
                $this->output->set_status_header(404);
              }
            }else{
              $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Lisensi Dipilih Tidak Ditemukan', 'english'=>'Selected Licence Not Found'));
              $this->output->set_status_header(404);
            }
          }else{
            $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Saldo Bonus Tidak Ada', 'english'=>'Balance Not Found'));
            $this->output->set_status_header(402);
          }
        }else{
          $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Lisensi Diperlukan', 'english'=>'Licence Required'));
          $this->output->set_status_header(401);
        }
      }else{
        $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'ID kosong', 'english'=>'ID Required'));
        $this->output->set_status_header(401);
      }
      echo json_encode($result);
    }
    public function update_video_tutorial()
    {
      $link = $this->input->post('link');
      if($link != null){
        $embed = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i","https://www.youtube.com/embed/$1",$link);
        $json['video 1'] = $embed;
        if($this->api_model->update_data(array('key'=>'video_tutorial_link'), 'settings', array('content'=>json_encode($json)))){
          $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Update Berhasil', 'english'=>'Updated'));
        }else{
          $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Update Gagal', 'english'=>'Update Failed'));
          $this->output->set_status_header(401);
        }
      }else{
        $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Link Kosong', 'english'=>'Link Required'));
        $this->output->set_status_header(401);
      }
      echo json_encode($result);
    }
    public function update_video_dashboard()
    {
      $link1 = $this->input->post('link1');
      $link2 = $this->input->post('link2');
      if($link1 != null){
        if($link2 != null){
          $embed1 = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i","https://www.youtube.com/embed/$1",$link1);
          $embed2 = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i","https://www.youtube.com/embed/$1",$link2);
          $json['video 1'] = $embed1;
          $json['video 2'] = $embed2;
          if($this->api_model->update_data(array('key'=>'dashboard_video_link'), 'settings', array('content'=>json_encode($json)))){
            $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Update Berhasil', 'english'=>'Updated'));
          }else{
            $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Update Gagal', 'english'=>'Update Failed'));
            $this->output->set_status_header(401);
          }
        }else{
          $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Link 2 Kosong', 'english'=>'Link 2 Required'));
          $this->output->set_status_header(401);
        }
      }else{
        $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Link 1 Kosong', 'english'=>'Link 1 Required'));
        $this->output->set_status_header(401);
      }
      echo json_encode($result);
    }
    public function add_banner()
    {
        if(isset($_FILES['file']['name'])){
            $file = $_FILES['file']['name'];
            $remove_char = preg_replace("/[^a-zA-Z]/", "", $file);
            $filename = 'BANNER_'.time().$remove_char.'.jpg';
        
            $location = "asstes/img-banner/".$filename;
            $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
            $imageFileType = strtolower($imageFileType);
        
            $valid_extensions = array("jpg","jpeg","png");
        
            $response = 0;
            if(in_array(strtolower($imageFileType), $valid_extensions)) {
              if($this->api_model->insert_data('banners', array('name'=>$file, 'picture'=>$filename))){
                if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
                  $response = $location;
                }
              }else{
                echo 0;
              }
            }
            echo $response;
            exit;
        }
        echo 0;
    }
    public function update_banner()
    {
        if(isset($_FILES['file']['name'])){
            $file = $_FILES['file']['name'];
            $remove_char = preg_replace("/[^a-zA-Z]/", "", $file);
            $filename = 'BANNER_'.time().$remove_char.'.jpg';
        
            $location = "asstes/img-banner/".$filename;
            $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
            $imageFileType = strtolower($imageFileType);
        
            $valid_extensions = array("jpg","jpeg","png");
        
            $response = 0;
            if(in_array(strtolower($imageFileType), $valid_extensions)) {
              if($this->api_model->insert_data('banners', array('name'=>$file, 'picture'=>$filename))){
                if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
                  $response = $location;
                }
              }else{
                echo 0;
              }
            }
            echo $response;
            exit;
        }
        echo 0;
    }
    public function update_icon_wa()
    {
        if(isset($_FILES['file']['name'])){
            $file = $_FILES['file']['name'];
            $remove_char = preg_replace("/[^a-zA-Z]/", "", $file);
            $filename = 'ICON_'.time().$remove_char.'.png';
        
            $location = "asstes/icon-wa/".$filename;
            $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
            $imageFileType = strtolower($imageFileType);
        
            $valid_extensions = array("jpg","jpeg","png");
        
            $response = 0;
            if(in_array(strtolower($imageFileType), $valid_extensions)) {
              if($this->api_model->update_data(array('key'=>'icon_wa'), 'settings', array('content'=>$filename))){
                if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
                  $response = $location;
                }
              }else{
                echo 0;
              }
            }
            echo $response;
            exit;
        }
        echo 0;
    }
}

