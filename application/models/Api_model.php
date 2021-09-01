<?php
class Api_model extends CI_Model {
    function __construct(){
        parent::__construct();
    }
    function login($username, $password){
        $this->db->select('*'); 
        $this->db->from('users');
        $this->db->where('username', $username);
        $this->db->where('password', md5($password));
        return $this->db->get();
    }
    public function sistem_name()
    {
        return $this->db->query("SELECT * FROM settings s WHERE s.key = 'sistem_name'")->result()[0]->content;
    }
    function get_data($table){
        $this->db->select('*');
        $this->db->from($table);
        return $this->db->get();
    }
    function get_data_by_where($table, $data){
        return $this->db->get_where($table, $data);
    }
    function get_data_by_where_and_order($table, $where, $order){
        $this->db->order_by($order['content'], $order['control']);
        return $this->db->get_where($table, $where);
    }
    function custom_query($query){
        return $this->db->query($query);
    }
    function insert_data($table, $data){
        return $this->db->insert($table, $data);
    }
    function update_data($whare_clouse, $table, $data){
        return $this->db->update($table, $data, $whare_clouse);
    }
}


