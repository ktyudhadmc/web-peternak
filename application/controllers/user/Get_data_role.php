<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Get_data_role extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MThirdApp');
        $this->load->model('MData');
        $this->MThirdApp->checksession();
    }

    public function index()
    {
        $cookie_data = json_decode($_COOKIE['user_data'] ?? null, true);
        $getrole     = $cookie_data['role'] ?? null;

        if (empty($getrole)) {
            echo json_encode(['status' => 'error', 'message' => 'Sesi habis']);
            return;
        }

        $datarole = $this->MData->selectdatawhereresult('users_role', ['status_role' => 1]);

        $excluded = [];

        switch ((string) $getrole) {
            case '1': // Superadmin — tampilkan semua
                $excluded = [];
                break;
            case '2': // Admin
                $excluded = ['Superadmin', 'Manager', 'Dokter'];
                break;
            case '3':
                $excluded = ['Superadmin', 'Manager', 'Dokter', 'Admin'];
                break;
            case '4': // Hanya Sub-General
                $filtered = array_filter($datarole, fn($r) => $r->id == 5);
                echo json_encode(array_values($filtered));
                return;
            default: // Hanya General
                $filtered = array_filter($datarole, fn($r) => $r->id == 4);
                echo json_encode(array_values($filtered));
                return;
        }

        // Filter berdasarkan excluded list
        if (!empty($excluded)) {
            $datarole = array_filter($datarole, fn($r) => !in_array($r->role_nm, $excluded));
        }

        echo json_encode(array_values($datarole));
    }
}
