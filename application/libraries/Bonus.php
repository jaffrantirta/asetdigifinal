<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Bonus {
    protected $ci;
    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('api_model');
    }

    public function sum($id){
        if(count($x = $this->ci->api_model->get_data_by_where('sponsor_code_bonuses', array('owner_id'=>$id))->result()) > 0){
            $sponsor = $x[0]->balance;
        }else{
            $sponsor = 0;
        }
        if(count($y = $this->ci->api_model->get_data_by_where('turnovers', array('owner'=>$id))->result()) > 0){
            $left_turnover = $y[0]->left_belance;
            $right_turnover = $y[0]->right_belance;
            if($left_turnover < $right_turnover){
                $turnover = $left_turnover;
            }else{
                $turnover = $right_turnover;
            }
        }else{
            $turnover = 0;
        }
        $total = $sponsor + $turnover;
        if(count($total_bonus = $this->ci->api_model->get_data_by_where('total_bonuses', array('owner_id'=>$id))->result()) > 0){
            $result = $this->ci->api_model->update_data(array('id'=>$total_bonus[0]->id), 'total_bonuses', array('balance'=>$total));
        }else{
            $result = $this->ci->api_model->insert_data('total_bonuses', array('owner_id'=>$id, 'balance'=>$total));
        }
        if($result){
            return $total;
        }else{
            return -1;
        }
    }
    public function total($id)
    {
        $total_bonus = $this->ci->db->query("SELECT a.*, b.name AS user_name FROM total_bonuses a LEFT JOIN users b ON b.id=a.owner_id WHERE a.owner_id = $id")->result();
        if(count($total_bonus) > 0){
            return $total_bonus[0];
        }else{
            return false;
        }
    }
    public function pairing($id)
    {
        $pairing = $this->ci->db->query("SELECT a.*, b.name AS user_name FROM total_bonuses a LEFT JOIN users b ON b.id=a.owner_id WHERE a.owner_id = $id")->result();
        if(count($pairing) > 0){
            return $pairing[0];
        }else{
            return false;
        }
    }
    public function sponsor_count($user_id)
    {
        $x = $this->ci->api_model->get_data_by_where('sponsor_code_uses_complete_data', array('used_by'=>$user_id))->result();
        if(count($x) > 0){
            $bonus = $x[0]->user_lisensi_price /100 * $x[0]->owner_percentage;
            $sponsor_bonus = $this->ci->api_model->get_data_by_where('sponsor_code_bonuses', array('owner_id'=>$x[0]->owner_id))->result();
            if(count($sponsor_bonus) > 0){
                $balance_update = $sponsor_bonus[0]->balance + $bonus;
                $this->ci->db->trans_start();
                $this->ci->api_model->update_data(array('owner_id'=>$x[0]->owner_id), 'sponsor_code_bonuses', array('balance'=>$balance_update));
                $this->ci->api_model->insert_data('sponsor_code_bonus_details', array('sponsor_code_bonus_id'=>$sponsor_bonus[0]->id,'register_bonus_by'=>$x[0]->user_id, 'lisensies_id'=>$x[0]->user_lisensi_id, 'currency_at_the_time'=>'USDT', 'belance'=>$bonus, 'percentage_at_the_time'=>$x[0]->owner_percentage));
                $this->ci->db->trans_complete();
                if($this->ci->db->status()){
                    return true;
                }else{
                    return false;
                }
            }else{
                $this->ci->db->trans_start();
                $this->ci->api_model->insert_data('sponsor_code_bonuses', array('owner_id'=>$x[0]->owner_id, 'balance'=>$bonus));
                $this->ci->api_model->insert_data('sponsor_code_bonus_details', array('sponsor_code_bonus_id'=>$this->ci->db->insert_id(),'register_bonus_by'=>$x[0]->user_id, 'lisensies_id'=>$x[0]->user_lisensi_id, 'currency_at_the_time'=>'USDT', 'belance'=>$bonus, 'percentage_at_the_time'=>$x[0]->owner_percentage));
                $this->ci->db->trans_complete();
                if($this->ci->db->status()){
                    return true;
                }else{
                    return false;
                }
            }
        }else{
            return false;
        }
    }
}
