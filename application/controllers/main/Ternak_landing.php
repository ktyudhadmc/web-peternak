<?php

defined('BASEPATH') or exit('No direct script access allowed');
Sentry\init(['dsn' => 'https://4dba7b441a7ff5576bdc44cf8098b987@o4504875505483776.ingest.sentry.io/4506318591950848']);
class Ternak_landing extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MData');
        $this->load->model('MThirdApp');
        $this->load->model('MSql');
        $this->MThirdApp->checksession();
    }

    public function index()
    {
        echo "you should be here";
    }
    public function kandang($idkandang = null)
    {
        if ($idkandang !== NULL) {
            $datakandangactivity = $this->MData->selectdatawhereresult('kandang_activity', ['id_kandang' => $idkandang]);
        } else {
            redirect('main', 'refresh');
            exit;
        }
        // $datakandangactivity
        $data = array(
            'title' => 'Ternak Landing',
            'content' => 'ternak_view_landing',
        );
        $this->load->view('main/template', $data);
    }
}
