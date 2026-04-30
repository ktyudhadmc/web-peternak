<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Add_user extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MThirdApp');
        $this->load->model('MData');
        $this->MThirdApp->checksession();
    }

    public function index()
    {
        ob_start(); // tangkap semua output sebelum kita siap kirim

        header('Content-Type: application/json');

        $first_name = $this->input->post('first_name');
        $number     = $this->input->post('number');
        $role       = $this->input->post('role');
        $email      = $this->input->post('email');
        $alamat     = $this->input->post('alamat');

        if (empty($first_name) || empty($number) || empty($role)) {
            ob_end_clean(); // buang output sebelumnya
            echo json_encode([
                'status'  => 'error',
                'comment' => 'Nama, nomor, dan role tidak boleh kosong'
            ]);
            return;
        }

        $searchakun = $this->MData->selectdatawhere('users', ['number' => $number]);

        if ($searchakun !== FALSE) {
            ob_end_clean();
            echo json_encode([
                'status'  => 'error',
                'comment' => 'Nomor yang anda gunakan sudah terdaftar. Gunakan nomor lain'
            ]);
            return;
        }

        $this->MData->tambah('users', [
            'first_name' => $first_name,
            'number'     => $number,
            'role'       => $role,
            'email'      => $email,
            'alamat'     => $alamat,
        ]);

        ob_end_clean(); // buang semua output tidak diinginkan
        echo json_encode([
            'status'  => 'success',
            'comment' => 'Data user baru berhasil disimpan'
        ]);
    }
}
