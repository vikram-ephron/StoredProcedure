<?php
class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
    }

    public function index() {
        if ($this->session->userdata('logged_in') != 1) {
            redirect('login');
        }
         $this->load->view('user_view');
    
    }

    public function get_users() {
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $search = $this->input->post('search')['value'];

        $data = array(
            'data' => $this->User_model->get_users($limit, $start, $search),
            'recordsTotal' => $this->User_model->count_users($search),
            'recordsFiltered' => $this->User_model->count_users($search)
        );
        echo json_encode($data);
    }
    public function delete($id) {
        if ($this->session->userdata('logged_in') != 1) {
            redirect('login');
        } 
        $user = $this->User_model->get_user_by_id($id);

        $this->User_model->delete_user($id);
        echo json_encode(array('status' => 'success'));
    }
    public function edit($id) {
        $data['user'] = $this->User_model->get_user_by_id($id);
            $this->load->view('edit_user', $data);
                
         }
public function update() {
    if ($this->session->userdata('logged_in') != 1) {
        redirect('login');
    } 


    $id = $this->input->post('id');
    // print_r($id);
    // echo "<pre>";
    
    // exit;
    $update_data = array(
        'firstname' => $this->input->post('firstname'),
        'lastname' => $this->input->post('lastname'),
        'email' => $this->input->post('email'),
        'gender' => $this->input->post('gender'),
        'age' => $this->input->post('age'),
        'number' => $this->input->post('number'),
        'modify' => $this->input->post('modify') // status
    );

    $this->User_model->update_user($id, $update_data);
    redirect('admin/user');      
}
}
?>
