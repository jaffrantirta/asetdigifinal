<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Bonus extends CI_Controller {
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
        echo "404";
	}
    public function sponsor_code($hash)
    {
        $role = base64_decode($hash);
        $token = explode("/", base64_decode($this->input->get('token')));
        $data['sponsor_code_bonus_id'] = $token[0];
        $data['sponsor_code_name'] = $token[1];
        $data['page'] = 'Detail Bonus';
        $data['session'] = $this->session->all_userdata();
        $data['sistem_name'] = $this->api_model->sistem_name();
        if($role == 'customer'){
            $this->load->view('Customer/Template/header', $data);
			$this->load->view('Customer/bonus_detail_sponsor_code', $data);
			$this->load->view('Customer/Template/footer', $data);
            // echo json_encode($data);
        }else if($role == 'admin'){
            $this->load->view('Admin/Template/header', $data);
            $this->load->view('Admin/bonus_detail_sponsor_code', $data);
            $this->load->view('Admin/Template/footer', $data);
            // echo json_encode($data);
        }
    }
    public function turnover($hash)
    {
        $role = base64_decode($hash);
        $token = explode("////", base64_decode($this->input->get('token')));
        $data['id_and_position'] = $token[0];
        $data['position_turnover'] = $token[1];
        $data['page'] = 'Detail Bonus';
        $data['session'] = $this->session->all_userdata();
        $data['sistem_name'] = $this->api_model->sistem_name();
        if($role == 'customer'){
            $this->load->view('Customer/Template/header', $data);
			$this->load->view('Customer/bonus_detail_turnover', $data);
			$this->load->view('Customer/Template/footer', $data);
        }else if($role == 'admin'){
            $this->load->view('Admin/Template/header', $data);
            $this->load->view('Admin/bonus_detail_turnover', $data);
            $this->load->view('Admin/Template/footer', $data);
        }
    }
}