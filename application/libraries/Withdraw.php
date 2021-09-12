<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Withdraw {
    protected $ci;
    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('api_model');
    }
    public function request($data)
    {
        if($this->ci->api_model->insert_data('withdraws', $data)){
            return true;
        }else{
            return false;
        }
    }
}
