<?php
defined('BASEPATH') or exit('No direct script access allowed');

class General_service
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function getPartnershipList(int $id)
    {
        $query = $this->CI->db
            ->select('id, location as name')
            ->from('company_sub')
            ->where('id_company', $id)
            ->order_by('location', 'ASC');

        return $query->get()->result_array();
    }
    public function getAllPartnerships()
    {
        $query = $this->CI->db
            ->select('id, location as name')
            ->from('company_sub')
            ->where_in('id_company', [1, 10])
            ->order_by('location', 'ASC');

        return $query->get()->result_array();
    }

    public function resApi(
        string $message,
        array $data = [],
        bool $status = true,
        int $code = 200
    ) {
        http_response_code($code);

        header('Content-Type: application/json');

        return json_encode([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
    }
}
