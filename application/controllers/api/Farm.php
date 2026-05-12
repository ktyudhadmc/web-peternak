<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Farm extends Api_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Ternak/Ternak_service');
        $this->load->library('Rhpp/Rhpp_service');
    }

    public function getLokasi()
    {
        $id_company = $this->input->get('id_company');
        $data = $this->ternak_service->getLokasiList($id_company);
        echo $this->general_service->resApi('Data Lokasi berhasil diambil', $data);

    }

    public function getKandangByLokasi()
    {
        $id_lokasi = $this->input->get('id_lokasi');
        $data = $this->ternak_service->getKandangByLokasi($id_lokasi);
        echo $this->general_service->resApi('Data Kandang berhasil diambil', $data);
    }

    public function getByPeriode()
    {
        $id_kandang = $this->input->get('id_kandang');
        $periode = $this->input->get('periode');
        $data = $this->ternak_service->getByPeriode((int) $id_kandang, $periode);
        echo $this->general_service->resApi('Data Ternak berhasil diambil', $data);
    }

    public function getKandangList()
    {
        $id_kandang = $this->input->get('id_kandang');
        $periode = $this->input->get('periode') ?? null;
        $data = $this->ternak_service->getKandangList((int) $id_kandang, $periode);
        echo $this->general_service->resApi('Data Kandang berhasil diambil', $data);
    }

    public function getrhpp()
    {
        $id_kandang = $this->input->get('id_kandang');
        $periode = $this->input->get('periode') ?? null;
        $data = $this->rhpp_service->getRhppData((int) $id_kandang, $periode);
        echo $this->general_service->resApi('Data RHPP berhasil diambil', $data);
    }
}
