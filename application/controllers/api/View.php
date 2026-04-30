<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';

use chriskacerguis\RestServer\RestController;

class View extends RestController
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->database();
        $this->load->model('MData');
        //load library form validasi
        $this->load->library('form_validation');
    }
    public function validatetoken($token)
    {
        $cekdata = $this->MData->selectdatawhere('users', ['token_ajax' => $token]);
        if ($cekdata !== FALSE) {
            return true;
        } else {
            return false;
        }
    }
    //Menampilkan data ternak
    function ternak_get()
    {
        $table = 'kandang';
        $requiredparam = ['id', 'status_kandang', 'token'];
        if (count($this->input->get()) > 0) {
            foreach ($this->input->get() as $key => $value) {
                if (in_array($key, $requiredparam)) {
                    $this->db->where($key, $value);
                } else {
                    $this->response(['status' => false, 'data' => 'Wrong Parameter', 'responseCode' => 500]);
                }
            }
            $ternak = $this->db->get($table)->result();
        } else {
            $ternak = $this->db->get($table)->result();
        }
        if (count($ternak) > 0) {
            $this->response(['status' => true, 'data' => $ternak, 'responseCode' => 200]);
        } else {
            $this->response(['status' => false, 'data' => 'No data found', 'responseCode' => 500]);
        }
    }
    //Menampilkan data ternak
    function ternakview_post()
    {
        if ($this->input->post()) {
            if ($this->input->post('token')) {
                if ($this->validatetoken($this->input->post('token'))) {
                    $showdatakandang = $this->MData->customresult("SELECT *,users.first_name FROM kandang  LEFT JOIN kandang_activity ON kandang.id = kandang_activity.id_kandang LEFT JOIN users on kandang.user_id = users.id where status_kandang in ('AKTIF','REHAT','CLOSE') AND status_kandang_activity in ('AKTIF','REHAT','CLOSE') ORDER BY kandang.nama ASC");
                    if ($showdatakandang !== FALSE) {
                        $this->response(['status' => true, 'data' => $showdatakandang, 'responseCode' => 200]);
                    } else {
                        $this->response(['status' => false, 'data' => 'No data found', 'responseCode' => 500]);
                    }
                } else {
                    $this->response(['status' => false, 'data' => 'Token tidak ditemukan', 'responseCode' => 500]);
                    exit;
                }
            } else {
                $this->response(['status' => false, 'data' => 'Perlu token', 'responseCode' => 500]);
                exit;
            }
        } else {
            $this->response(['status' => false, 'data' => 'No data found', 'responseCode' => 500]);
        }
    }

    // Menampilkan data user
    function user_get()
    {
        $table = 'users';
        $id = $this->get('id');
        if ($id == '') {
            $user = $this->db->get($table)->result();
        } else {
            $this->db->where('id', $id);
            $user = $this->db->get($table)->result();
        }
        if (count($user) > 0) {
            $this->response(['status' => true, 'data' => $user, 'responseCode' => 200]);
        } else {
            $this->response(['status' => false, 'data' => 'No data found', 'responseCode' => 500]);
        }
    }
}