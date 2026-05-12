<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rhpp extends Api_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Ternak/Ternak_service');
        $this->load->library('Rhpp/Rhpp_service');
    }

    public function getrhpp(int $id_kandang, string $periode)
    {
        $data = $this->rhpp_service->getRhppData($id_kandang, $periode);
        echo $this->general_service->resApi('Data RHPP berhasil diambil', $data);
    }
}
