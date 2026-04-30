<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sapronak extends CI_Controller
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
                $this->view_sapronak();
            } else {
                echo json_encode(['status' => FALSE, 'message' => 'Wrong Token']);
            }
        } else {
            echo json_encode(['status' => FALSE, 'message' => 'Wrong Page']);
        }
    }
    function view_sapronak()
    {
        // Protector Jika URL Lebih dari 3 maka di tolak
        if (count($this->uri->segment_array()) < 3) {
            if ($this->input->post('kandangperiode')) {
                $this->load->view('main/content/ternak_detail_sapronak.php');
            }
        } else {
            echo json_encode(['status' => FALSE, 'message' => 'Wrong Page']);
        }
    }
}
