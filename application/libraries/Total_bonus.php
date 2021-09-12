<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Total_bonus {
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
}
