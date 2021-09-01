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
    public function setting(){
        if (!$this->session->userdata('authenticated_customer')) {
            $this->login();
        } else {
            $data['page'] = 'profile';
            $data['session'] = $this->session->all_userdata();
            $profile['user'] = $this->setting->get_profile();
            // echo json_encode($data);
            $this->load->view('Customer/Template/header', $data);
            $this->load->view('Customer/profile', $profile);
            $this->load->view('Customer/Template/footer', $data);
        }
    }
    public function login()
    {
        $this->load->view('Customer/login');
    }
   
}
