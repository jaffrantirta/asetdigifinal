<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting_model extends CI_Model
{
    public $user_id;

    public function __construct()
    {
        parent::__construct();
    }
    public function is_profile_exist($id)
    {
        return ($this->db->where('id', $id)->get('users')->num_rows() > 0) ? TRUE : FALSE;
    }
    public function get_profile($id)
    {
        // $id = $this->id;
        $user = $this->db->where('id', $id)->get('users');
        
        return $user->row();
    }

    public function update_profile($data)
    {
        $id = $this->user_id;

        return $this->db->where('id', $id)->update('users', $data);
    }
    function join2table()
    {
        $this->db->select('*');
        $this->db->from('sponsor_codes');
        $this->db->join('users', 'users.id = sponsor_codes.owner');
        $query = $this->db->get();
        return $query;
    }
    public function update($data)
    {
        return $this->db->where('id', $this->user_id)->update('users', $data);
    }

    public function update_account($data)
    {
        return $this->db->where('id', $this->user_id)->update('users', $data);
    }
    
}
