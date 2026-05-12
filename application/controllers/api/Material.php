<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Material extends Api_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Material/Material_service');
    }

    public function index()
    {
        $data = $this->material_service->docPakanMaterials();
        echo $this->general_service->resApi('Data Material berhasil diambil', $data);
    }
    public function ovk()
    {
        $data = $this->material_service->ovk();
        echo $this->general_service->resApi('Data OVK berhasil diambil', $data);
    }
    public function pakan()
    {
        $data = $this->material_service->pakan();
        echo $this->general_service->resApi('Data Pakan berhasil diambil', $data);
    }
    public function doc()
    {
        $data = $this->material_service->doc();
        echo $this->general_service->resApi('Data Dokumen berhasil diambil', $data);
    }
    public function livebird()
    {
        $data = $this->material_service->livebird();
        echo $this->general_service->resApi('Data Live Bird berhasil diambil', $data);
    }
}
