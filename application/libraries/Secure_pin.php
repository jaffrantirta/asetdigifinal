<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Secure_pin {
    protected $ci;
    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('api_model');
    }
    public function check($data)
    {
        $user = $this->ci->api_model->get_data_by_where('users', array('id'=>$data['id']))->result();
        if(count($user) > 0){
            if($user[0]->secure_pin == $data['secure_pin']){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}
