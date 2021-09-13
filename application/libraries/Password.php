<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Password {
    protected $ci;
    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('api_model');
        $this->ci->load->library('mailer');
        $this->ci->load->library('email_template');
    }
    public function forgot($email)
    {
        $user = $this->ci->api_model->get_data_by_where('users', array('email'=>$email))->result();
        if(count($user) > 0){
            $date = $this->start_time();
            $link = base_url('password?token='.base64_encode($user[0]->id.'/'.$date));
            $data_template = array(
                'opening'=> 'Hi '.$user[0]->name.', We received a request to reset the password on your '.$this->ci->api_model->sistem_name().' Account.',
                'email'=>$email,
                'message'=>'Click link to reset your password : '.$link
              );
            $content = $this->ci->email_template->template($data_template);
            $send_mail = array(
                'email_penerima'=>$email,
                'subjek'=>'Reset Password',
                'content'=>$content,
            );
            $send = $this->ci->mailer->send($send_mail);
            if($send['status']=="Sukses"){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    public function reset($data)
    {
        if($this->ci->api_model->update_data(array('id'=>$data['id']), 'users', $data['insert'])){
            return true;
        }else{
            return false;
        }
    }
    public function change_password($data)
    {
        $user = $this->ci->api_model->get_data_by_where('users', array('id'=>$data['id']))->result();
        if(count($user) > 0){
            if(md5($data['old_password']) == $user[0]->password){
                if($this->ci->api_model->update_data(array('id'=>$data['id']), 'users', $data['insert'])){
                    return true;
                }else{
                    return false;
                }
            }else{

            }
        }else{
            return false;
        }
    }
    public function start_time()
    {
        date_default_timezone_set("Asia/Makassar");
		$startTime = date('Y-m-d H:i:s');
		$cenvertedTime = date('Y-m-d H:i:s',strtotime('+5 minutes',strtotime($startTime)));
        return $cenvertedTime;
    }
    public function end_time($ex)
    {
        date_default_timezone_set("Asia/Makassar");
		$expire_date = $ex;
		$now = date("Y-m-d H:i:s");
		if ($now>$expire_date) {
		    return false;
		}else{
            return true;
        }
    }
    public function change_secure_pin($data)
    {
        $user = $this->ci->api_model->get_data_by_where('users', array('id'=>$data['id']))->result();
        if(count($user) > 0){
            if($this->ci->api_model->update_data(array('id'=>$data['id']), 'users', $data['insert'])){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}