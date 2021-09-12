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
          $order_number = 'PR'.time().strtoupper(random_string('alnum`', 4));
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

      $this->db->trans_start();
      $check_position = $this->api_model->get_data_by_where('positions', array('position'=>$position, 'top'=>$top_id))->result();
      if(count($check_position) == 0){
        $check_sponsor = $this->api_model->get_data_by_where('sponsor_codes', array('code'=>$sponsor_code, 'is_active'=>true))->result();
        if(count($check_sponsor) == 1){
          $check_pin_register = $this->api_model->get_data_by_where('pin_register', array('pin'=>$pin_register, 'is_active'=>true))->result();
          if(count($check_pin_register) == 1){
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
                $last_id = $this->db->insert_id();
                if($this->api_model->update_data(array('pin'=>$pin_register), 'pin_register', array('is_active'=>false, 'used_by'=>$last_id))){
                  $generate_sponsor = strtoupper(preg_replace("/[^a-zA-Z]/", "", substr($name,0,5).random_string('alnum', 3)));
                  $sponsor_code = $generate_sponsor.rand(1,1000);
                  $sponsor_insert = array(
                    'code' => $sponsor_code,
                    'owner' => $last_id
                  );
                  if($this->api_model->insert_data('sponsor_codes', $sponsor_insert)){
                    $last_id_sponsor = $this->db->insert_id();
                    $aponsor_use_insert = array(
                      'sponsor_id' => $check_sponsor[0]->id,
                      'used_by' => $last_id
                    );
                    if($this->api_model->insert_data('sponsor_code_uses', $aponsor_use_insert)){
                      $insert_position = array(
                        'position' => $position,
                        'top' => $top_id,
                        'bottom' => $last_id
                      );
                      if($this->api_model->insert_data('positions', $insert_position)){
                        $data_template = array(
                          'opening'=> 'Hi '.$name.', Terima kasih telah mendaftar di Asset Digital <br> Username : '.$username.' <br> Password : (gunakan password yang diinputkan) <br> Tanggal Registrasi : '.date("l, d M Y H:m:s").'<br>',
                          'email'=>$email,
                          'message'=>'SEGERALAH MEMBELI PAKET LISENSI,
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
                          $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Registrasi Gagal', 'english'=>'Register Failed'));
                          $this->output->set_status_header(501);
                        }
                      }
                    }else{
                      $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Registrasi Gagal', 'english'=>'Register Failed'));
                      $this->output->set_status_header(501);
                    }
                  }else{
                    $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Registrasi Gagal', 'english'=>'Register Failed'));
                    $this->output->set_status_header(501);
                  }
                }else{
                  $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Registrasi Gagal', 'english'=>'Register Failed'));
                  $this->output->set_status_header(501);
                }
              }else{
                $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Registrasi Gagal', 'english'=>'Register Failed'));
                $this->output->set_status_header(501);
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
      $this->db->trans_complete();
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
          $percentage = $this->db->query("SELECT a.id, b.percentage AS percentage FROM user_lisensies a INNER JOIN lisensies b ON b.id=a.lisensi_id WHERE a.owner = $owner_id")->result()[0]->percentage;
          $bonus_sponsor_fix = $lisensi_price / 100 * $percentage;
          if(count($sponsor_code_bonuses = $this->api_model->get_data_by_where('sponsor_code_bonuses', array('owner_id'=>$owner_id))->result()) == 0){
            $insert_sponsor_bonus = array(
              'owner_id'=>$owner_id,
              'balance'=>$bonus_sponsor_fix
            );
            if($this->api_model->insert_data('sponsor_code_bonuses', $insert_sponsor_bonus)){
              $sponsor_code_bonus_id = $this->db->insert_id();
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
                      $this->api_model->update_data(array('owner'=>$top_id), 'turnovers', array('left_belance'=>$new_belance));
                    }else{
                      $new_belance = $turnover[0]->right_belance + $lisensi_price;
                      $this->api_model->update_data(array('owner'=>$top_id), 'turnovers', array('right_belance'=>$new_belance));
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
                if($this->api_model->update_data(array('order_id'=>$id), 'user_lisensies', array('is_active'=>true))){
                  $update = $this->db->query("UPDATE `orders` SET `is_pending` = '0', `is_finish` = '1' WHERE `orders`.`id` = $id");
                  if($update){
                    $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Terupdate', 'english'=>'Updated'));
                  }else{
                    $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Update Gagal', 'english'=>'Update Failed'));
                    $this->output->set_status_header(501);
                  }
                  echo json_encode($result);
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
                      $this->api_model->update_data(array('owner'=>$top_id), 'turnovers', array('left_belance'=>$new_belance));
                    }else{
                      $new_belance = $turnover[0]->right_belance + $lisensi_price;
                      $this->api_model->update_data(array('owner'=>$top_id), 'turnovers', array('right_belance'=>$new_belance));
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
                if($this->api_model->update_data(array('order_id'=>$id), 'user_lisensies', array('is_active'=>true))){
                  $update = $this->db->query("UPDATE `orders` SET `is_pending` = '0', `is_finish` = '1' WHERE `orders`.`id` = $id");
                  if($update){
                    $result['response'] = $this->response(array('status'=>true, 'indonesia'=>'Terupdate', 'english'=>'Updated'));
                  }else{
                    $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Update Gagal', 'english'=>'Update Failed'));
                    $this->output->set_status_header(501);
                  }
                  echo json_encode($result);
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
              $result['response'] = $this->response(array('status'=>false, 'indonesia'=>'Update Gagal', 'english'=>'Update Failed'));
              $this->output->set_status_header(501);
              echo json_encode($result);
            }
          }
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
}

