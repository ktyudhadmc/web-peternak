<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Nekropsi extends CI_Controller
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
                $this->view_nekropsi();
            } else {
                echo json_encode(['status' => FALSE, 'message' => 'Wrong Token']);
            }
        } else {
            echo json_encode(['status' => FALSE, 'message' => 'Wrong Page']);
        }
    }
    function view_nekropsi()
    {
        // Protector Jika URL Lebih dari 3 maka di tolak
        if (count($this->uri->segment_array()) < 3) {
            if ($this->input->post('kandangperiode')) {
                $kandangperiode = explode("|", $this->input->post('kandangperiode'));
                $idkandang = $kandangperiode[0];
                $periode = $kandangperiode[1];
                $getdata = $this->MData->selectdatawhereresult('nekropsi', array('nekropsi_kandang' => $idkandang, 'nekropsi_periode' => $periode));
                // echo json_encode($getdata);
                $data = array(
                    // 'content' => 'ternak_detail_logrh',
                    'idkandang' => $idkandang,
                    'periode' =>  $periode,
                    'nekropsidata' =>  $getdata,
                );
                $this->load->view('main/content/ternak_detail_nekropsi.php', $data);
            }
        } else {
            echo json_encode(['status' => FALSE, 'message' => 'Wrong Page']);
        }
    }
}

/* End of file Sapronak.php */
