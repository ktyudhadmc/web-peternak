<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Listuser extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MThirdApp');
        $this->load->model('MData');
        $this->MThirdApp->checksession();
    }
    // public function index()
    // {
    //     $getrole_raw = isset($_COOKIE['user_data']) ? $_COOKIE['user_data'] : NULL;
    //     $cookie_data = json_decode($getrole_raw, true);
    //     $getrole = $cookie_data['role'] ?? null;



    //     if ($this->input->post()) {
    //         $searchakun = $this->MData->selectdatawhere('users', array('number' => $this->input->post('number')));
    //         if ($searchakun !== FALSE) {
    //             $this->session->set_flashdata('danger_message', 'Nomor yang anda gunakan sudah terdaftar. Gunakan nomor lain');
    //         } else {
    //             $get_id = $this->MData->tambah('users', $this->input->post());
    //             $this->MThirdApp->syncusersetting();
    //             $this->session->set_flashdata('success_message', 'Data user baru disimpan');
    //         }
    //     }
    //     $getrole = $this->session->userdata('role');
    //     // echo json_encode($this->session->userdata());
    //     // exit;
    //     // Cek Role Function
    //     $cekrole = $this->MThirdApp->getfunctionrole($getrole, 'listuser');
    //     if ($cekrole == false) {
    //         $this->session->set_flashdata('danger_message', 'Anda tidak boleh akses halaman ini');
    //         redirect('user/listuser', 'refresh');
    //         exit;
    //     }
    //     $getdatalokasi = $this->MData->customresult("select a.user_id, b.first_name as lokasi from kandang as a left join users as b on a.user_id = b.id group by a.user_id order by b.first_name asc");
    //     // $datauser = $this->MData->customresult("select *,r.role_nm as role_nm,u.id as id_user from users u left join users_role r on u.role = r.id where u.status not in ('delete') order by u.created_at desc");
    //     // $datarole = $this->MData->selectdatawhereresult('users_role',array('status_role' => 1));
    //     // $datakandang = $this->MData->customresult("SELECT *,kandang.id as id_kandang FROM kandang inner join users on users.id = kandang.user_id where kandang.status_kandang not in ('DELETE') ORDER BY kandang.created_at");
    //     $data = array(
    //         'title' => 'List User',
    //         'content' => 'listuser',
    //         'lokasi' => $getdatalokasi,
    //         // 'datauser' => $datauser,
    //         // 'datarole' => $datarole,
    //         // 'datakandang' => $datakandang
    //     );
    //     $this->load->view('main/template', $data);
    // }

    public function index()
    {
        // 1. Ambil Role dari Cookie
        $cookie_data = json_decode($_COOKIE['user_data'] ?? null, true);
        $getrole     = $cookie_data['role'] ?? null;

        // 2. Validasi Sesi & Akses Role
        if (empty($getrole)) {
            $this->session->set_flashdata('danger_message', 'Sesi anda habis, silahkan login kembali');
            redirect('auth/login', 'refresh');
            return;
        }

        $hasAccess = $this->MThirdApp->getfunctionrole($getrole, 'listuser');
        if (!$hasAccess) {
            $this->session->set_flashdata('danger_message', 'Anda tidak boleh akses halaman ini');
            redirect('user/listuser', 'refresh');
            return;
        }

        // 3. Proses Form Tambah User (jika ada POST)
        if ($this->input->post()) {
            $this->_handleTambahUser();
        }

        // 4. Ambil Data untuk View
        $getdatalokasi = $this->MData->customresult("
        SELECT a.user_id, b.first_name AS lokasi
        FROM kandang AS a
        LEFT JOIN users AS b ON a.user_id = b.id
        GROUP BY a.user_id
        ORDER BY b.first_name ASC
    ");



        // 5. Load View
        $this->load->view('main/template', [
            'title'   => 'List User',
            'content' => 'listuser',
            'lokasi'  => $getdatalokasi,
        ]);
    }


    private function _handleTambahUser()
    {
        $number     = $this->input->post('number');
        $searchakun = $this->MData->selectdatawhere('users', ['number' => $number]);

        if ($searchakun !== FALSE) {
            $this->session->set_flashdata('danger_message', 'Nomor yang anda gunakan sudah terdaftar. Gunakan nomor lain');
            return;
        }

        $this->MData->tambah('users', $this->input->post());
        $this->MThirdApp->syncusersetting();
        $this->session->set_flashdata('success_message', 'Data user baru disimpan');
    }
}
