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
        if($this->session->userdata('authenticated_customer') != true){
            if($this->session->userdata('authenticated_admin') != true){
                header("location:".base_url());
            }else{
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
		}else{
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
    }
    public function pairing_bonus($hash)
    {
        if($this->session->userdata('authenticated_customer') != true){
            if($this->session->userdata('authenticated_admin') != true){
                header("location:".base_url());
            }else{
                $role = base64_decode($hash);
                $token = explode("/", base64_decode($this->input->get('token')));
                $data['sponsor_code_bonus_id'] = $token[0];
                $data['sponsor_code_name'] = $token[1];
                $data['page'] = 'Pairing Bonus';
                $data['session'] = $this->session->all_userdata();
                $data['sistem_name'] = $this->api_model->sistem_name();
                if ($role == 'customer') {
                    $this->load->view('Customer/Template/header', $data);
                    $this->load->view('Customer/pairing_bonus', $data);
                    $this->load->view('Customer/Template/footer', $data);
                    // echo json_encode($data);
                } else if ($role == 'admin') {
                    $this->load->view('Admin/Template/header', $data);
                    $this->load->view('Admin/bonus_detail_sponsor_code', $data);
                    $this->load->view('Admin/Template/footer', $data);
                    // echo json_encode($data);
                }
            }
		}else{
            $role = base64_decode($hash);
            $token = explode("/", base64_decode($this->input->get('token')));
            $data['sponsor_code_bonus_id'] = $token[0];
            $data['sponsor_code_name'] = $token[1];
            $data['page'] = 'Pairing Bonus';
            $data['session'] = $this->session->all_userdata();
            $data['sistem_name'] = $this->api_model->sistem_name();
            if ($role == 'customer') {
                $this->load->view('Customer/Template/header', $data);
                $this->load->view('Customer/pairing_bonus', $data);
                $this->load->view('Customer/Template/footer', $data);
                // echo json_encode($data);
            } else if ($role == 'admin') {
                $this->load->view('Admin/Template/header', $data);
                $this->load->view('Admin/bonus_detail_sponsor_code', $data);
                $this->load->view('Admin/Template/footer', $data);
                // echo json_encode($data);
            }
        }
    }
    public function turnover($hash)
    {
        if($this->session->userdata('authenticated_customer') != true){
            if($this->session->userdata('authenticated_admin') != true){
                header("location:".base_url());
            }else{
                $role = base64_decode($hash);
                $token = explode("////", base64_decode($this->input->get('token')));
                $data['id_and_position'] = $token[0];
                $data['position_turnover'] = $token[1];
                $data['session'] = $this->session->all_userdata();
                $data['sistem_name'] = $this->api_model->sistem_name();
                if($role == 'customer'){
                    $data['page'] = 'Detail Omset '.$token[1];
                    $this->load->view('Customer/Template/header', $data);
                    $this->load->view('Customer/bonus_detail_turnover', $data);
                    $this->load->view('Customer/Template/footer', $data);
                }else if($role == 'admin'){
                    $data['page'] = 'Detail Omset '.$token[1];
                    $this->load->view('Admin/Template/header', $data);
                    $this->load->view('Admin/bonus_detail_turnover', $data);
                    $this->load->view('Admin/Template/footer', $data);
                }
            }
		}else{
            $role = base64_decode($hash);
            $token = explode("////", base64_decode($this->input->get('token')));
            $data['id_and_position'] = $token[0];
            $data['position_turnover'] = $token[1];
            $data['session'] = $this->session->all_userdata();
            $data['sistem_name'] = $this->api_model->sistem_name();
            if($role == 'customer'){
                $data['page'] = 'Detail Omset '.$token[1];
                $this->load->view('Customer/Template/header', $data);
                $this->load->view('Customer/bonus_detail_turnover', $data);
                $this->load->view('Customer/Template/footer', $data);
            }else if($role == 'admin'){
                $data['page'] = 'Detail Omset '.$token[1];
                $this->load->view('Admin/Template/header', $data);
                $this->load->view('Admin/bonus_detail_turnover', $data);
                $this->load->view('Admin/Template/footer', $data);
            }
        }
    }
    public function pairing()
    {
        $turnover = $this->db->query("SELECT a.*, c.max_bonus AS max_bonus FROM turnovers a LEFT JOIN user_lisensies b ON b.owner=a.owner LEFT JOIN lisensies c ON c.id=b.lisensi_id WHERE a.is_active = false")->result();
                $percentage = $this->api_model->get_data_by_where('settings', array('key'=>'turnover_percentage'))->result()[0]->content;
                if(count($turnover) > 0){
                    foreach($turnover as $data){
                        $left = $data->left_belance;
                        $right = $data->right_belance;
                        if($left >= $right){
                            $smaller = $right;
                            $update_left = $left - $right;
                            $update_right = 0;
                        }else{
                            $smaller = $left;
                            $update_left = 0;
                            $update_right = $right - $left;
                        }
                        $vbonus = $smaller / 100 * $percentage;
                        if($vbonus >= $data->max_bonus){
                            $bonus = $data->max_bonus;
                        }else{
                            $bonus = $vbonus;
                        }
                        $x = $this->api_model->get_data_by_where('total_bonuses', array('owner_id'=>$data->owner))->result();
                        if(count($x) > 0){
                            $balance = $x[0]->balance + $bonus;
                            $id_inout = 'BI'.time().'-'.$data->owner;
                            // $data2['balance'][] = $bonus;
                            $this->db->trans_start();
                            $this->api_model->update_data(array('id'=>$x[0]->id), 'total_bonuses', array('balance'=>$balance));
                            $this->api_model->insert_data('inout_bonuses', array('id_inout'=>$id_inout, 'type'=>1, 'balance'=>$bonus, 'note'=>'pairing bonus', 'total_bonus_id'=>$x[0]->id));
                            $this->api_model->update_data(array('id'=>$data->id), 'turnovers', array('is_active'=>true, 'left_belance'=>$update_left, 'right_belance'=>$update_right));
                            $this->db->trans_complete();
                            if($this->db->trans_status()){
                                echo true;
                            }else{
                                echo false;
                            }
                        }else{
                            $balance = $bonus;
                            $id_inout = 'BI'.time().'-'.$data->owner;
                            // $data2['balance'][] = $bonus;
                            $this->db->trans_start();
                            $this->api_model->insert_data('total_bonuses', array('owner_id'=>$data->owner, 'balance'=>$balance));
                            $this->api_model->insert_data('inout_bonuses', array('id_inout'=>$id_inout, 'type'=>1, 'balance'=>$bonus, 'note'=>'pairing bonus', 'total_bonus_id'=>$this->db->insert_id()));
                            $this->api_model->update_data(array('id'=>$data->id), 'turnovers', array('is_active'=>true, 'left_belance'=>$update_left, 'right_belance'=>$update_right));
                            $this->db->trans_complete();
                            if($this->db->trans_status()){
                                echo true;
                            }else{
                                echo false;
                            }
                        }
                        // echo json_encode($bonus);
                    }
                    // echo json_encode($data2);
                }else{
                    echo false;
                }
    }
}