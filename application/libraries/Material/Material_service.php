<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Material_service
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function docPakanMaterials()
    {
        $pakan = $this->CI->db
            ->select("id, brand as name, 'pakan' as type, code")
            ->from('pakan');
        $dataPakan = $pakan->get()->result_array();
        $doc = $this->CI->db
            ->select("id, name, 'doc' as type, code")
            ->from('doc');
        $dataDoc = $doc->get()->result_array();

        return array_merge($dataPakan, $dataDoc);
    }

    public function ovk()
    {
        $ovk = $this->CI->db
            ->select("id, brand as name, 'ovk' as type, code")
            ->from('obat')
            ->order_by('name', 'asc');
        return $ovk->get()->result_array();
    }

    public function doc()
    {
        $doc = $this->CI->db
            ->select("id, name, 'doc' as type, code")
            ->from('doc')
            ->order_by('name', 'asc');
        return $doc->get()->result_array();
    }
    public function pakan()
    {
        $pakan = $this->CI->db
            ->select("id, brand as name, 'pakan' as type, code")
            ->from('pakan')
            ->order_by('name', 'asc');
        return $pakan->get()->result_array();
    }

    public function livebird()
    {
        $livebird = $this->CI->db
            ->select("id, name, bw_min, bw_max, 'livebird' as type")
            ->from('livebird');
        return $livebird->get()->result_array();
    }
}
