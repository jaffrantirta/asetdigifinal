<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Upgrade {
    protected $ci;
    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('api_model');
        $this->ci->load->helper('string');
    }

    public function licence($id, $upgrade_to, $payment){
        $check = $this->ci->api_model->get_data_by_where('lisensi_upgrades', array('request_by'=>$id, 'is_finish'=>false))->result();
        if(count($check) > 0){
            $data['status'] = false;
            $data['message'] = "You have active request right now";
            return $data;
        }else{
            $user = $this->ci->db->query("SELECT a.*, c.id AS licence_id, c.price AS licence_price FROM users a LEFT JOIN user_lisensies b ON b.owner=a.id LEFT JOIN lisensies c ON c.id=b.lisensi_id WHERE a.id = $id")->result();
            if(count($user) > 0){
                $licence_upgrade = $this->ci->api_model->get_data_by_where('lisensies', array('id'=>$upgrade_to))->result()[0];
                $diff_payment = $licence_upgrade->price - $user[0]->licence_price;
                $insert = array(
                    'order_number' => 'UL'.time().strtoupper(random_string('alnum', 5)),
                    'request_by' => $user[0]->id,
                    'current_lisensi' => $user[0]->licence_id,
                    'upgrade_to' => $licence_upgrade->id,
                    'diff_payment' => $diff_payment,
                    'payment_method' => $payment
                );
                if($this->ci->api_model->insert_data('lisensi_upgrades', $insert)){
                    $last_id = $this->ci->db->insert_id();
                    $data['status'] = true;
                    $data['message'] = "Requested";
                    $data['id'] = $last_id;
                    return $data;
                }else{
                    $data['status'] = false;
                    $data['message'] = "Failed to request";
                    return $data;
                }
            }else{
                $data['status'] = false;
                $data['message'] = "Not have Licence";
                return $data;
            }
        }
    }
}
