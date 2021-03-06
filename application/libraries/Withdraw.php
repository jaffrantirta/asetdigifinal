<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Withdraw {
    protected $ci;
    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('api_model');
    }
    public function request($data)
    {
        $lisensi = $this->ci->api_model->get_data_by_where('user_lisensies', array('owner'=>$data['user_id'], 'is_active'=>true))->result();
        if(count($lisensi) > 0){
            $total_bonus = $this->ci->api_model->get_data_by_where('total_bonuses', array('owner_id'=>$data['user_id']))->result();
            if(count($total_bonus) > 0){
                if($total_bonus[0]->balance >= $data['amount']){
                    if($this->ci->api_model->insert_data('withdraws', $data)){
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    public function detail($id)
    {
        $withdraw = $this->ci->api_model->get_data_by_where('withdraws', array('id'=>$id))->result();
        if(count($withdraw) > 0){
            $user = $this->ci->api_model->get_data_by_where('users', array('id'=>$withdraw[0]->user_id))->result();
            if(count($user) > 0){
                $pecentage_properties = $this->ci->api_model->get_data_by_where('settings', array('key'=>'auto_save_properties'))->result()[0]->content;
                $auto_amount = $withdraw[0]->amount / 100 * $pecentage_properties;
                $withdraw_amount = $withdraw[0]->amount - $auto_amount;
                $data['transfer']['withdraw_amount'] = $withdraw_amount;
                $data['transfer']['auto_amount'] = $auto_amount; 
                $data['withdraw'] = $withdraw[0];
                $data['user'] = $user[0];
                return $data;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    public function update_status($data)    
    {
        $withdraw = $this->ci->api_model->get_data_by_where('withdraws', array('id'=>$data['id']))->result();
        if(count($withdraw) > 0){
            if($data['status'] == 3){
                $update =$this->ci->api_model->update_data(array('id'=>$data['id']), 'withdraws', array('status'=>3));
                if($update){
                    return true;
                }else{
                    return false;
                }
            }else{
                $total_bonus = $this->ci->api_model->get_data_by_where('total_bonuses', array('owner_id'=>$withdraw[0]->user_id))->result();
                $pecentage_properties = $this->ci->api_model->get_data_by_where('settings', array('key'=>'auto_save_properties'))->result()[0]->content;
                $auto_amount = $withdraw[0]->amount / 100 * $pecentage_properties;
                if($total_bonus[0]->balance >= $withdraw[0]->amount){
                    $balance = $total_bonus[0]->balance - $withdraw[0]->amount;
                    $this->ci->db->trans_start();
                    $this->ci->api_model->update_data(array('id'=>$data['id']), 'withdraws', array('status'=>2));
                    $this->ci->api_model->update_data(array('id'=>$total_bonus[0]->id), 'total_bonuses', array('balance'=>$balance));
                    $insert_auto_properties = array(
                        'user_id'=>$total_bonus[0]->owner_id,
                        'amount'=>$auto_amount
                    );
                    $insert = array(
                        'id_inout'=>'BI'.time().'-'.$total_bonus[0]->owner_id,
                        'type'=>2,
                        'balance'=>$withdraw[0]->amount,
                        'note'=>'withdraw',
                        'total_bonus_id'=>$total_bonus[0]->id
                    );
                    $this->ci->api_model->insert_data('auto_save_properties', $insert_auto_properties);
                    $this->ci->api_model->insert_data('inout_bonuses', $insert);
                    $this->ci->db->trans_complete();
                    if($this->ci->db->trans_status()){
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            }
        }else{
            return false;
        }
    }
}
