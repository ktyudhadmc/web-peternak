<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Ternak_detail_top extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('MData');
        $this->load->model('MThirdApp');
        $this->load->model('MSql');
    }

    //Menampilkan data ternak
    function index()
    {
        if ($this->input->post()) {
            $tokenstatus = $this->MThirdApp->validatetoken();
            if ($tokenstatus['status']) {
                $this->view_top();
            } else {
                echo json_encode(['status' => FALSE, 'message' => 'Wrong Token']);
            }
        } else {
            echo json_encode(['status' => FALSE, 'message' => 'Wrong Page']);
        }
    }
    function view_top()
    {
        // Protector Jika URL Lebih dari 3 maka di tolak
        if (count($this->uri->segment_array()) < 3) {
            if ($this->input->post('kandangperiode')) {
                $kandangperiode = explode("|", $this->input->post('kandangperiode'));
                $idkandang = $kandangperiode[0];
                $periode = $kandangperiode[1];
                $getactivitydetail_join = $this->MData->customrow("SELECT status_kandang_activity,status_kandang FROM kandang_activity LEFT JOIN kandang ON kandang.id = kandang_activity.id_kandang where id_kandang = '{$idkandang}' AND periode ='{$periode}' ORDER BY kandang_activity.created_at DESC");
                $data['datakandang'] =  $this->MData->customrow("SELECT * FROM kandang INNER JOIN kandang_type ON kandang.type_kandang = kandang_type.id where kandang.id ='{$idkandang}'");
                // $data['dataresume'] = $this->MSql->dataresume($getactivitydetail_join->status_kandang_activity != 'AKTIF' || $getactivitydetail_join->status_kandang != "AKTIF" ? "CLOSE" : "AKTIF", $idkandang, $periode);
                $data_resume_top = $this->MSql->dataresume_api($this->input->post('kandangperiode'), $this->input->post('token'), $this->input->post('user_id'));
                $data['dataresume'] = json_decode($data_resume_top);
                $data['datakandangstatus'] = $getactivitydetail_join;
                $data['periode'] = $this->MData->customresult("SELECT * FROM `kandang_activity` where id_kandang = '{$idkandang}'");

                // Cleansing
                $userIds = explode(",", $data['datakandang']->user_id_sharing);
                $userIds = array_filter($userIds);

                // Ambil data sekaligus pakai WHERE IN
                $data['users'] = $this->db
                    ->select('id, first_name, foto')
                    ->from('users')
                    ->where_in('id', $userIds)
                    ->get()
                    ->result();

                $this->load->view('main/content/ternak_detail_top.php', $data);
            }
        } else {
            echo json_encode(['status' => FALSE, 'message' => 'Wrong Page']);
        }
    }
}

/* End of file Sapronak.php */
