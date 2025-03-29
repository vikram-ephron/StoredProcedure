
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->library('email'); 
    }

    public function index() {
        $this->load->view('signup_form');
    }

    public function submit() {
        // echo "<pre>";
        // print_r( $this->input->post());exit;
        $data = array(
            'firstname' => $this->input->post('fname'),
            'lastname' => $this->input->post('lname'),
            'email' => $this->input->post('email'),
            'gender' => $this->input->post('gender'),
            'age' => $this->input->post('age'),
            'number' => $this->input->post('phone'),
            'pwd' => $this->input->post('password'),
            'cdate' => date('Y-m-d H:i:s'),
            'modify' => 0
        );

        // Check if the user already exists
        $verify_user = $this->user_model->verify_user($data['email']);
        if ($verify_user) {
            // User already exists
            echo json_encode([
                'success' => false,
                'message' => 'User already exists!'
            ]);
            return;
        } 

        // Create new user
        $user_id = $this->user_model->create_user($data);
        if ($user_id) {
            // Send verification email
            $mail_verify = $this->send_verification_email($data);
            if ($mail_verify) {
                // Signup successful, email sent
                echo json_encode([
                    'success' => true,
                    'message' => 'Signup successful! Please check your email for verification.'
                ]);
            } else {
                // Signup successful, but email failed
                echo json_encode([
                    'success' => false,
                    'message' => 'Signup successful, but failed to send verification email.'
                ]);
            }
        } else {
            // Failed to create user
            echo json_encode([
                'success' => false,
                'message' => 'Failed to create user. Please try again later.'
            ]);
        }
    }

    private function send_verification_email($data) {
        $verification_link = base_url() . 'Login/verify?mail=' . urlencode(base64_encode($data['email'])) . '&pwd=' . urlencode(base64_encode($data['pwd']));
        
        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 587,
            'smtp_user' => 'vigneshwaran@ephrontech.com', 
            'smtp_pass' => 'qqov jjkm qgbv cwct', 
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n",
            'smtp_crypto' => 'tls'
        );
    
        $this->email->initialize($config);
        $this->email->from('test@example.com', $data['firstname'] . ' ' . $data['lastname']);
        $this->email->to($data['email']);
        $this->email->subject('SignUp Verification');
        
        $message = "
            <html>
            <head>
                <title>Verify Your Email</title>
            </head>
            <body>
                <h2>Thank you for signing up!</h2>
                <p>Please click the link below to verify your email address:</p>
                <p><a href='" . $verification_link . "'>Verify</a></p>
            </body>
            </html>
        ";
    
        $this->email->message($message);

        if ($this->email->send()) {
            return true; 
        } else {
            echo $this->email->print_debugger();
            return false;
        }
    }
    
    
    
}