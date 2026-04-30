<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Plc extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('MDataPlc', 'MData');
    }

    public function getdataplc($idkandang)
    {
        $table = "Environment{$idkandang}";
        $cekdata = $this->MData->customrow("SELECT table_name
        FROM information_schema.tables
        WHERE table_schema = 'u1734578_mqtt'
        AND table_name = '{$table}'");
        if (!$cekdata) {
            die(json_encode(['status' => false, 'message' => 'Tabel tidak ditemukan']));
        }
        $getdata = $this->MData->customrow("SELECT *FROM {$table} LIMIT 1");
        die(json_encode(['status' => true, 'message' => $getdata]));
    }
}

/* End of file Controllername.php */
