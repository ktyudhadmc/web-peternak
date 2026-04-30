<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Firebase\JWT\JWT;

class Jwt_auth {

    private $CI;
    private $secret_key;

    public function __construct() {
        $this->CI =& get_instance();
        $this->secret_key = 'tetapi_hari_ini_di_jogja_saya_sampaikan_saya_akan_lawan'; 
    }

    public function generate($data) {
        $issuedAt = time();
        $expirationTime = $issuedAt + (60 * 60 * 24); // Token berlaku 24 Jam
        $payload = array(
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'data' => $data // Berisi user_id, role, dll
        );

        return JWT::encode($payload, $this->secret_key);
    }

    // Fungsi untuk validasi token di setiap request API
    public function validate() {
        $header = $this->CI->input->get_request_header('Authorization');
        if (!$header) {
            $this->send_error("Token tidak ditemukan");
        }

        $token = str_replace('Bearer ', '', $header);

        try {
            $decoded = JWT::decode($token, $this->secret_key, array('HS256'));
            return $decoded->data; // Kembalikan data user jika valid
        } catch (Exception $e) {
            $this->send_error("Token tidak valid atau expired");
        }
    }

    private function send_error($message) {
        $this->CI->output
            ->set_status_header(401)
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => false, 'message' => $message]))
            ->_display();
        exit;
    }
}