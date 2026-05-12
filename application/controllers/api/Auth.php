<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Auth/Auth_service');
    }

    public function request_otp()
    {
        $data   = json_decode($this->input->raw_input_stream, true);
        $number = isset($data['number']) ? $data['number'] : null;

        $result = $this->auth_service->requestOtp($number);

        echo json_encode([
            'status'            => $result['status'],
            'message'           => $result['message'],
            'api_token_request' => isset($result['api_token_request']) ? $result['api_token_request'] : null
        ]);

        if ($result['status']) {
            if (function_exists('fastcgi_finish_request')) {
                fastcgi_finish_request();
            }
            $this->MThirdApp->sendWa($result['payload_wa']['number'], $result['payload_wa']['message']);
        }
    }

    public function verify_otp()
    {
        $data          = json_decode($this->input->raw_input_stream, true);
        $otp           = isset($data['otp']) ? $data['otp'] : null;
        $token_request = isset($data['api_token_request']) ? $data['api_token_request'] : null;
        $result = $this->auth_service->verifyOtp($otp, $token_request);
        echo json_encode($result);
    }

    public function user_profile()
    {
        $bearer_token = $this->input->get_request_header('Authorization');
        $result = $this->auth_service->getUserProfile($bearer_token);
        echo json_encode($result);
    }
}
