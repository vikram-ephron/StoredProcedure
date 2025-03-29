<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->library('email'); 
        $this->load->library('session');  
        $this->load->helper('url');

    }

    public function index() {
      
        $this->load->view('login_form');
    }

    public function verify() {
        $email = $this->input->get('mail'); 
        $password = $this->input->get('pwd');

        $email = base64_decode($email);
        $password = base64_decode($password);

        $check_user = $this->user_model->checkverify_user($email, $password); 

        if ($check_user != FALSE) {
            redirect(base_url().'login');
        } else {
            echo 'Invalid email or password';
        }
    }
    public function submit() {
      $data = array(
          'email' => $this->input->post('email'),
          'pwd' => $this->input->post('password'),
      );
  
      $verify_user = $this->user_model->login_user($data);
      if ($verify_user) {
          // Set session
          $session_data = array(
              'email' => $verify_user->email,
              'id' => $verify_user->id,
              'firstname' => $verify_user->firstname,
              'lastname' => $verify_user->lastname,
              'status' => $verify_user->modify,
              'logged_in' => TRUE
          );
  
          $this->session->set_userdata($session_data);
 
          echo json_encode([
              'success' => true,
              'message' => 'Login successful!'
          ]);
      } else {
          echo json_encode([
              'success' => false,
              'message' => 'Invalid email or password, or account not active.'
          ]);
      }
  }
  
public function logout() {
  // Destroy session
  $this->session->sess_destroy();
  redirect(base_url().'login');
}
}
