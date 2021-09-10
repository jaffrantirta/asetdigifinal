<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Profile extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Admin_model');
        $this->load->model('api_model');
        $this->load->library('Ssp');
        $this->load->library('mailer');
        $this->load->library('pdf');
        $this->load->library('pdf2');
        $this->load->library('form_validation');
        $this->load->model('setting_model', 'setting');
    }
    public function setting($id){
       
            $data['page'] = 'Profile';
            $data['sistem_name'] = $this->api_model->sistem_name();
            $data['session'] = $this->session->all_userdata();
            $dataa = $this->setting->get_profile($id);
            $users['users'] = $dataa;
            // echo json_encode($data);
            $this->load->view('Customer/Template/header', $data);
            $this->load->view('Customer/profile', $users);
            $this->load->view('Customer/Template/footer', $data);
      
    }
    public function login()
    {
        $this->load->view('Customer/login');
    }
    public function update(){
       
        $id = $this->input->post('id');
        $nama = $this->input->post('name');
        $email = $this->input->post('email');
        //$password = $this->input->post('password');
        $usdt_wallet = $this->input->post('usdt_wallet');
        //$secure_pin = $this->input->post('secure_pin');
        
        $config['upload_path']          = './upload/product/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['file_name']            = $this->id;
        $config['overwrite']			= true;
        $config['max_size']             = 2024; // 1MB
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;
    
        $this->load->library('upload', $config);
    
        if ($this->upload->do_upload('image')) {
            return $this->upload->data("file_name");
        }
     
        $data = array(
            'name' => $nama,
            'email' => $email,
            // 'password' => md5($password),
            // 'secure_pin' => md5($secure_pin),
            'usdt_wallet' => $usdt_wallet,
            'profile_picture' => $profile_picture
        );
     
        $where = array(
            'id' => $id
        );
     
        $this->api_model->update_data($where,'users',$data);
        redirect('profile/setting/'.$id);
    }
   
  
}
