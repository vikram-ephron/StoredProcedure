<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function get_orders($limit, $start, $search = null, $status = null) {
        // Call the stored procedure
        $query = $this->db->query("CALL search_orders(?, ?, ?, ?)", array(
            $limit,
            $start,
            $search,
            $status
        ));
        // echo "<pre>";
        // print_r($this->db->last_query());exit;

        $result = $query->result_array();
        $query->free_result();
        
        return $result;
    }
    // Get orders with user and product details
    public function get_orders_old($limit, $start, $search = null, $status = null) {
        $this->db->select('orders.*, users.firstname as user_name, users.email, 
                           products.name as product_name, products.price');
        $this->db->from('orders');
        $this->db->join('users', 'users.id = orders.user_id');
        $this->db->join('products', 'products.id = orders.product_id');
        
        // Apply search filters if provided
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('users.firstname', $search);
            $this->db->or_like('users.email', $search);
            $this->db->or_like('products.name', $search);
            $this->db->group_end();
        }
        
        // Filter by status if provided
        if (!empty($status)) {
            $this->db->where('orders.status', $status);
        }
        
        // Apply limit and offset for pagination
        $this->db->limit($limit, $start);
        $this->db->order_by('orders.created_at', 'DESC');
        
        $query = $this->db->get();
        echo "<pre>";
        print_r($this->db->last_query()); exit;

        // listing orders

        // SELECT `orders`.*, `users`.`firstname` as `user_name`, `users`.`email`, `products`.`name` as `product_name`, `products`.`price`
        // FROM `orders`
        // JOIN `users` ON `users`.`id` = `orders`.`user_id`
        // JOIN `products` ON `products`.`id` = `orders`.`product_id`
        // ORDER BY `orders`.`created_at` DESC
        //  LIMIT 10


        // search listing

//         SELECT `orders`.*, `users`.`firstname` as `user_name`, `users`.`email`, `products`.`name` as `product_name`, `products`.`price`
// FROM `orders`
// JOIN `users` ON `users`.`id` = `orders`.`user_id`
// JOIN `products` ON `products`.`id` = `orders`.`product_id`
// WHERE   (
// `users`.`firstname` LIKE '%vikram%' ESCAPE '!'
// OR  `users`.`email` LIKE '%vikram%' ESCAPE '!'
// OR  `products`.`name` LIKE '%vikram%' ESCAPE '!'
//  )
// ORDER BY `orders`.`created_at` DESC
//  LIMIT 10

        return $query->result_array();
    }
    
    // Count total orders (for pagination)
    public function count_orders($search = null, $status = null) {
        $this->db->select('COUNT(*) as count');
        $this->db->from('orders');
        $this->db->join('users', 'users.id = orders.user_id');
        $this->db->join('products', 'products.id = orders.product_id');
        
        // Apply search filters if provided
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('users.firstname', $search);
            $this->db->or_like('users.email', $search);
            $this->db->or_like('products.name', $search);
            $this->db->group_end();
        }
        
        // Filter by status if provided
        if (!empty($status)) {
            $this->db->where('orders.status', $status);
        }
        
        $query = $this->db->get();
        $result = $query->row();
        return $result->count;
    }
    
    // Get order details by ID
    public function get_order_by_id($id) {
        $this->db->select('orders.*, users.firstname as user_name, users.email, 
                           products.name as product_name, products.price, products.description');
        $this->db->from('orders');
        $this->db->join('users', 'users.id = orders.user_id');
        $this->db->join('products', 'products.id = orders.product_id');
        $this->db->where('orders.id', $id);
        
        $query = $this->db->get();
        return $query->row_array();
    }
    
    // Create new order
    public function create_order($data) {
        $this->db->insert('orders', $data);
        return $this->db->insert_id();
    }
    
    // Update order
    public function update_order($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('orders', $data);
    }
    
    // Delete order
    public function delete_order($id) {
        $this->db->where('id', $id);
        return $this->db->delete('orders');
    }
    
    // Get product details
    public function get_product_by_id($id) {
        $query = $this->db->get_where('products', array('id' => $id));
        return $query->row_array();
    }
    
    // Get active users for dropdown
    public function get_active_users() {
        $this->db->select('id, firstname, email');
        $this->db->from('users');
        $this->db->where('modify', 1);
        $this->db->order_by('firstname', 'ASC');
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    // Get available products for dropdown
    public function get_available_products() {
        $this->db->select('id, name, price, stock');
        $this->db->from('products');
        $this->db->where('stock >', 0);
        $this->db->order_by('name', 'ASC');
        
        $query = $this->db->get();
        return $query->result_array();
    }
}