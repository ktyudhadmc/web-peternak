<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Logrh extends CI_Controller
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
                $this->view_logrh();
            } else {
                echo json_encode(['status' => FALSE, 'message' => 'Wrong Token']);
            }
        } else {
            echo json_encode(['status' => FALSE, 'message' => 'Wrong Page']);
        }
    }
    function view_logrh()
    {
        // Protector Jika URL Lebih dari 3 maka di tolak
        if (count($this->uri->segment_array()) < 3) {
            if ($this->input->post('kandangperiode')) {
                $kandangperiode = explode("|", $this->input->post('kandangperiode'));
                $idkandang = $kandangperiode[0];
                $periode = $kandangperiode[1];

                // echo json_encode(['idkandang' => $idkandang, 'periode' => $periode]);
                // exit;
                $data = array(
                    // 'content' => 'ternak_detail_logrh',
                    'idkandang' => $idkandang,
                    'periode' =>  $periode,
                );
                // $this->load->view('main/template', $data);
                $this->load->view('main/content/ternak_detail_logrh', $data);
            }
        } else {
            echo json_encode(['status' => FALSE, 'message' => 'Wrong Page']);
        }
    }
}

/* End of file Sapronak.php */
