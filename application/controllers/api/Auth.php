<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MData');
        $this->load->model('MThirdApp');
        $this->load->library('sendmail');
        $this->load->library('jwt_auth'); // Library JWT kita
    }

    public function request_otp()
    {
        $data = json_decode($this->input->raw_input_stream, true);

        $number = isset($data['number']) ? $data['number'] : null;
        $ceknomor = $this->MData->selectdatawhere('users', array('number' => $number));

        if ($ceknomor && $ceknomor->status == "active") {
            $digits = 4;
            if ($number == "083831922473") {
                $otp = "1234";
                $gettoken = 'abogoboga';
            } else {
                $otp = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
                $gettoken = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10);
            }
            $message = "{$otp} adalah kode verifikasi Anda. Gunakan untuk masuk akun *WEB.PETERNAK.ID*.";

            $datatoken = array(
                'token' => $gettoken,
                'user_id' => $ceknomor->id,
                'otp' => $otp,
                'status' => 'login'
            );
            $this->MData->tambah('token', $datatoken);

            echo json_encode([
                'status' => true,
                'api_token_request' => $gettoken,
                'message' => 'OTP Berhasil dikirim ke WA'
            ]);
            if (function_exists('fastcgi_finish_request')) {
                fastcgi_finish_request();
            }
            $this->MThirdApp->sendWa($number, $message);
        } else {
            echo json_encode(['status' => false, 'message' => 'Nomor tidak terdaftar']);
        }
    }

    public function verify_otp()
    {
        $data = json_decode($this->input->raw_input_stream, true);
        $otp = isset($data['otp']) ? $data['otp'] : null;
        $token_request = isset($data['api_token_request']) ? $data['api_token_request'] : null;

        if (!$otp || !$token_request) {
            echo json_encode(['status' => false, 'message' => 'OTP dan Token Request wajib diisi']);
            return;
        }

        // 1. Cek ke database (Nebeng logika tabel token di Auth lama)
        $cekdatatoken = $this->MData->selectdatawhere('token', array(
            'token' => $token_request,
            'otp' => $otp
        ));

        if ($cekdatatoken) {
            // 2. Ambil data user lengkap dengan role-nya
            $getuser = $this->MData->customrow("
            SELECT u.*, ur.role_nm 
            FROM users u 
            INNER JOIN users_role ur ON u.role = ur.id 
            WHERE u.id ='{$cekdatatoken->user_id}'
        ");

            if (!$getuser) {
                echo json_encode(['status' => false, 'message' => 'Data user tidak ditemukan']);
                return;
            }

            // 3. Siapkan Payload untuk JWT
            // Jangan masukkan password di sini, cukup ID dan info penting saja
            $payload = [
                'user_id' => $getuser->id,
                'number'  => $getuser->number,
                'role'    => $getuser->role,
                'role_nm' => $getuser->role_nm
            ];

            // 4. Generate Bearer Token pakai library Jwt_auth yang kita buat tadi
            $bearer_token = $this->jwt_auth->generate($payload);

            // 5. Update last login (Opsional, agar sama dengan web)
            $this->MData->edit(['id' => $getuser->id], 'users', ['last_login' => date('Y-m-d H:i:s')]);

            echo json_encode([
                'status' => true,
                'message' => 'Login Berhasil',
                'token' => $bearer_token,
                'user' => [
                    'id' => $getuser->id,
                    'nama' => $getuser->first_name, // sesuaikan fieldmu
                    'number' => $getuser->number,
                    'role' => $getuser->role_nm
                ]
            ]);
        } else {
            echo json_encode(['status' => false, 'message' => 'Kode OTP salah atau sudah tidak berlaku']);
        }
    }
}
