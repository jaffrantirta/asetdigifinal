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
       
            $data['page'] = 'profile';
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
        $username = $this->input->post('username');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $usdt_wallet = $this->input->post('usdt_wallet');
        $secure_pin = $this->input->post('secure_pin');
        $data = $this->setting->get_profile($id);
        $current_profile_picture = $data->profile_picture;

        $config['upload_path'] = './assets/uploads/users/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = 2048;

        $this->load->library('upload', $config);

        if (isset($_FILES['picture']) && @$_FILES['picture']['error'] == '0') {
            if ($this->upload->do_upload('picture')) {
                $upload_data = $this->upload->data();
                $new_file_name = $upload_data['file_name'];

                $profile_picture = $new_file_name;

                if (file_exists('assets/uploads/users/' . $current_profile_picture))
                    unlink('./assets/uploads/users/' . $current_profile_picture);
            }
        } else {
            $profile_picture = $current_profile_picture;
        }
     
        $data = array(
            'name' => $nama,
            'username' => $username,
            'email' => $email,
            'password' => md5($password),
            'secure_pin' => md5($secure_pin),
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
