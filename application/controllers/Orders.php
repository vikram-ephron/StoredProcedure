<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('order_model');
        $this->load->helper('url');
        $this->load->library('pagination');
        $this->load->library('session');
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }
    
    public function index() {
        // Get search parameters
        $search = $this->input->get('search');
        
        // if($this->input->get('status')){
            $status = $this->input->get('status');
        // }else{
        //     $status =1;  
        // }
        
        // Pagination configuration
        $config['base_url'] = base_url('orders');
        $config['total_rows'] = $this->order_model->count_orders($search, $status);
        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'page-link');
        
        $this->pagination->initialize($config);
        
        $page = ($this->input->get('page')) ? $this->input->get('page') : 0;
        
        // Get orders with pagination
        $data['orders'] = $this->order_model->get_orders($config['per_page'], $page, $search, $status);
        $data['pagination'] = $this->pagination->create_links();
        $data['search'] = $search;
        $data['status'] = $status;
        $data['total_rows'] = $config['total_rows'];
        
        // Load view
        $this->load->view('templates/header');
        $this->load->view('orders/index', $data);
        $this->load->view('templates/footer');
    }
    
    public function view($id) {
        // Get order details
        $data['order'] = $this->order_model->get_order_by_id($id);
        
        if (empty($data['order'])) {
            show_404();
        }
        
        // Load view
        $this->load->view('templates/header');
        $this->load->view('orders/view', $data);
        $this->load->view('templates/footer');
    }
    
    public function create() {
        // Form validation rules
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_id', 'User', 'required');
        $this->form_validation->set_rules('product_id', 'Product', 'required');
        $this->form_validation->set_rules('quantity', 'Quantity', 'required|numeric|greater_than[0]');
        
        if ($this->form_validation->run() === FALSE) {
            // Get users and products for dropdowns
            $data['users'] = $this->order_model->get_active_users();
            $data['products'] = $this->order_model->get_available_products();
            
            // Load view
            $this->load->view('templates/header');
            $this->load->view('orders/create', $data);
            $this->load->view('templates/footer');
        } else {
            // Get form data
            $user_id = $this->input->post('user_id');
            $product_id = $this->input->post('product_id');
            $quantity = $this->input->post('quantity');
            
            // Get product details
            $product = $this->order_model->get_product_by_id($product_id);
            
            // Calculate total price
            $total_price = $product['price'] * $quantity;
            
            // Create order data
            $order_data = array(
                'user_id' => $user_id,
                'product_id' => $product_id,
                'quantity' => $quantity,
                'total_price' => $total_price,
                'status' => 'pending'
            );
            
            // Create order
            $this->order_model->create_order($order_data);
            
            // Set flash message
            $this->session->set_flashdata('success', 'Order created successfully.');
            
            // Redirect to orders list
            redirect('orders');
        }
    }
    
    public function edit($id) {
        // Get order details
        $data['order'] = $this->order_model->get_order_by_id($id);
        
        if (empty($data['order'])) {
            show_404();
        }
        
        // Form validation rules
        $this->load->library('form_validation');
        $this->form_validation->set_rules('status', 'Status', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            // Get users and products for dropdowns
            $data['users'] = $this->order_model->get_active_users();
            $data['products'] = $this->order_model->get_available_products();
            
            // Load view
            $this->load->view('templates/header');
            $this->load->view('orders/edit', $data);
            $this->load->view('templates/footer');
        } else {
            // Update order data
            $order_data = array(
                'status' => $this->input->post('status')
            );
            
            // Update order
            $this->order_model->update_order($id, $order_data);
            
            // Set flash message
            $this->session->set_flashdata('success', 'Order updated successfully.');
            
            // Redirect to orders list
            redirect('orders');
        }
    }
    
    public function delete($id) {
        // Get order details
        $order = $this->order_model->get_order_by_id($id);
        
        if (empty($order)) {
            show_404();
        }
        
        // Delete order
        $this->order_model->delete_order($id);
        
        // Set flash message
        $this->session->set_flashdata('success', 'Order deleted successfully.');
        
        // Redirect to orders list
        redirect('orders');
    }
}