<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Bop extends CI_Controller
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
                $this->view_bop();
            } else {
                echo json_encode(['status' => FALSE, 'message' => 'Wrong Token']);
            }
        } else {
            echo json_encode(['status' => FALSE, 'message' => 'Wrong Page']);
        }
    }
    function view_bop()
    {
        // Protector Jika URL Lebih dari 3 maka di tolak
        if (count($this->uri->segment_array()) < 3) {
            if ($this->input->post('kandangperiode')) {
                $kandangperiode = explode("|", $this->input->post('kandangperiode'));
                $idkandang = $kandangperiode[0];
                $periode = $kandangperiode[1];
                // echo json_encode(['idkandang' => $idkandang, 'periode' => $periode]);
                // exit;
                $this->load->view('main/content/ternak_detail_bop.php');
            }
        } else {
            echo json_encode(['status' => FALSE, 'message' => 'Wrong Page']);
        }
    }
    function getdata()
    {
        if ($this->input->post()) {
            $tokenstatus = $this->MThirdApp->validatetoken();
            if ($tokenstatus['status']) {
                $kandangperiode = explode("|", $this->input->post('kandangperiode'));
                $idkandang = $kandangperiode[0];
                $periode = $kandangperiode[1];
                $getdatakandang = $this->MData->selectdatawhere('kandang_activity_log_bop', array('id_kandang' => $idkandang,'periode'=>$periode));
                echo json_encode([$getdatakandang]);
            } else {
                echo json_encode(['status' => FALSE, 'message' => 'Wrong Token']);
            }
        } else {
            echo json_encode(['status' => FALSE, 'message' => 'Wrong Page']);
        }
    }
}



/* End of file Sapronak.php */
