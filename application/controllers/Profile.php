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
            $profile['user'] = $this->setting->join2table();
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
    public function edit_name()
    {
        $this->form_validation->set_rules('name', 'Nama lengkap', 'required|max_length[32]|min_length[4]');

        if ($this->form_validation->run() === FALSE) {
            $this->setting();
        } else {
            $data = new stdClass();

            $data->name = $this->input->post('name');
            $profile = $this->setting->get_profile();
            $old_profile = $profile->profile_picture;

            if (isset($_FILES) && @$_FILES['file']['error'] == '0') {
                $config['upload_path'] = './assets/uploads/users/';
                $config['allowed_types'] = 'jpg|png';
                $config['max_size'] = 2048;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file')) {
                    if ($old_profile) {
                        unlink('./assets/uploads/users/' . $old_profile);
                    }

                    $file_data = $this->upload->data();
                    $data->profile_picture = $file_data['file_name'];
                } else {
                    $errors = $this->upload->display_errors();
                    $errors .= '<p>';
                    $errors .= anchor('profile', '&laquo; Kembali');
                    $errors .= '</p>';

                    show_error($errors);
                }
            }

            $flash_message = ($this->profile->update($data)) ? 'Profil berhasil diperbarui!' : 'Terjadi kesalahan';

            $this->session->set_flashdata('profile', $flash_message);
            redirect('customer/profile');
        }
    }

    public function edit_account()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|max_length[16]|min_length[4]');
        $this->form_validation->set_rules('password', 'Password', 'min_length[4]');

        if ($this->form_validation->run() === FALSE) {
            $this->setting();
        } else {
            $data = new stdClass();
            $profile = $this->setting->get_profile();

            $get_password = $this->input->post('password');
            $get_pin = $this->input->post('pin');

            if (empty($get_password)) {
                $password = $profile->password;
            } else {
                $password = password_hash($get_password, PASSWORD_BCRYPT);
            }
            if (empty($get_pin)) {
                $pin = $profile->secure_pin;
            } else {
                $pin = password_hash($get_pin, PASSWORD_BCRYPT);
            }

            $data->username = $this->input->post('username');
            $data->password = $password;
            $data->secure_pin = $pin;

            $flash_message = ($this->profile->update_account($data)) ? 'Akun berhasil diperbarui' : 'Terjadi kesalahan';

            $this->session->set_flashdata('profile', $flash_message);
            $this->session->set_flashdata('show_tab', 'akun');

            redirect('profile/setting');
        }
    }

    public function edit_email()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[32]|min_length[10]');

        if ($this->form_validation->run() === FALSE) {
            $this->setting();
        } else {
            $data = new stdClass();

            $data->email = $this->input->post('email');

            $flash_message = ($this->setting->update_account($data)) ? 'Email berhasil diperbarui' : 'Terjadi kesalahan';

            $this->session->set_flashdata('profile', $flash_message);
            $this->session->set_flashdata('show_tab', 'email');

            redirect('profile/setting');
        }
    }
   
}
