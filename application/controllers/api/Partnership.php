<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Partnership extends Api_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getByCompany()
    {
        $id = $this->input->get('id');
        $data = $this->general_service->getPartnershipList($id);
        echo $this->general_service->resApi('Data Partnership berhasil diambil', $data);
    }

    public function getAll()
    {
        $data = $this->general_service->getAllPartnerships();
        echo $this->general_service->resApi('Data Partnership berhasil diambil', $data);
    }
}
