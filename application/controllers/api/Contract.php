<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contract extends Api_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Contract/Contract_service');
        $this->load->library('General/General_service');
        $this->load->library('Rhpp/Rhpp_service');
    }

    public function index()
    {
        $id_ref = $this->input->get('id_ref');
        $type = $this->input->get('type');
        $data = $this->contract_service->getAllContracts($id_ref, $type);
        echo $this->general_service->resApi('Data Contract berhasil diambil', $data);
    }

    public function create()
    {
        $payload = json_decode(file_get_contents('php://input'), true);
        $data = $this->contract_service->create($payload);
        echo ($data);
    }

    public function createMaterials()
    {
        $payload = json_decode(file_get_contents('php://input'), true);
        $data = $this->contract_service->createMaterials($payload);
        echo ($data);
    }

    public function createSales()
    {
        $payload = json_decode(file_get_contents('php://input'), true);
        $data = $this->contract_service->createSales($payload);
        echo ($data);
    }

    public function show(int $id)
    {
        $data = $this->contract_service->show((int) $id);
        echo $this->general_service->resApi('Data Contract berhasil diambil', $data);
    }

    public function update(int $id)
    {
        $payload = json_decode(file_get_contents('php://input'), true);
        $data = $this->contract_service->update((int) $id, $payload);
        echo ($data);
    }

    public function delete(int $id)
    {
        $data = $this->contract_service->delete((int) $id);
        echo ($data);
    }
}
