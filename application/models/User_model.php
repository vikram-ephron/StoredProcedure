<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function verify_user($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('users'); 
        
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function create_user($data) {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }
    public function checkverify_user($email, $password) {

        $this->db->where('email', $email);
        $this->db->where('pwd', $password); 
        $query = $this->db->get('users'); 
            if ($query->num_rows() > 0) {
            $user = $query->row(); 
            //print_r($user);
            $user_id = $user->id; 
            $this->db->where('id', $user_id);
            $this->db->update('users', array('modify' => 1)); 
            //echo "User ID: " . $user_id . " is verified.";
            return true; 
        } else {
            return false;  
        }
    }
    public function get_users($limit, $start, $search) {
        $this->db->select('*');
        $this->db->from('users');

        if (!empty($search)) {
            $this->db->like('name', $search);
        }
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        echo "<pre>";
        print_r($this->db->last_query());
        // return $query->result_array();
    }

    public function count_users($search) {
        $this->db->select('COUNT(*) AS count');
        $this->db->from('users');
        if (!empty($search)) {
            $this->db->like('name', $search);
        }
        $query = $this->db->get();
        $result = $query->row();
        return $result->count;
    }
    public function login_user($data) {

        $this->db->where('email', $data['email']);
        $this->db->where('pwd', $data['pwd']);
        $this->db->where('modify', 1);

        $query = $this->db->get('users');

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;  
        }
    }
    public function get_user_by_id($id) {
        $query = $this->db->get_where('users', array('id' => $id));
        return $query->row_array();
    }
    public function delete_user($id) {
        $this->db->where('id', $id);
        return $this->db->delete('users');
    }
    public function update_user($id, $data) {

        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }
}