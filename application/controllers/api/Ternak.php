<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';

use chriskacerguis\RestServer\RestController;

class Ternak extends RestController
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->database();
        $this->load->model('MData');
        //load library form validasi
        $this->load->library('form_validation');
    }
    public function validatetoken($token)
    {
        $cekdata = $this->MData->selectdatawhere('users', ['token_ajax' => $token]);
        if ($cekdata !== FALSE) {
            return true;
        } else {
            return false;
        }
    }
    //Menampilkan data ternak
    function ternakview_post()
    {
        if ($this->input->post()) {
            if ($this->input->post('token')) {
                if ($this->validatetoken($this->input->post('token'))) {
                    $showdatakandang = $this->MData->customresult("SELECT * FROM kandang LEFT JOIN kandang_activity ON kandang.id = kandang_activity.id_kandang LEFT JOIN users on kandang.user_id = users.id where FIND_IN_SET('{$this->input->post('user_id')}', kandang.user_id_sharing) AND status_kandang in ('AKTIF','REHAT','CLOSE') AND status_kandang_activity in ('AKTIF','REHAT','CLOSE') AND users.first_name = '" . $this->input->post('groupingname') . "' ORDER BY kandang.nama ASC");
                    // $showdatakandang = $this->MData->customresult("SELECT k.user_id as user_id,u.first_name as nama_user,u.id_company, c.nama_company as company FROM `kandang` k INNER JOIN users u ON k.user_id = u.id LEFT JOIN company c ON c.id = u.id_company WHERE `status_kandang` in ('AKTIF','REHAT','CLOSE') GROUP BY  `user_id`");

                    if ($showdatakandang !== FALSE) {

                        $this->response(['status' => true, 'data' => $this->view_ternakview($this->input->post('groupingname'), $showdatakandang), 'responseCode' => 200]);
                    } else {
                        $this->response(['status' => false, 'data' => 'No data found', 'responseCode' => 500]);
                    }
                } else {
                    $this->response(['status' => false, 'data' => 'Token tidak ditemukan', 'responseCode' => 500]);
                    exit;
                }
            } else {
                $this->response(['status' => false, 'data' => 'Perlu token', 'responseCode' => 500]);
                exit;
            }
        } else {
            $this->response(['status' => false, 'data' => 'No data found', 'responseCode' => 500]);
        }
    }
    function view_ternakview($grouping, $datashown)
    {
        // $arr = array();
        // $outputmaster = "";
        // foreach ($datashown as $grouping) {
        //     $arr[$grouping->user_id] = $grouping->user_id;
        // }

        // foreach ($arr as $key => $groupingname) {
        // $getname = $this->db->select('first_name')->where(['id' => $groupingname])->get('users')->row();
        $outputmaster = '
        <div class="col-lg-12 col-xxl-12">
            <div class="card h-100">
                <div class="card-body p-9">
                    <div class="card-header border-0 pt-6">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="text-muted mt-1 fw-bold fs-7 mb-1">List kandang dari Owner</span>
                            <span class="card-label fw-bolder fs-3 mb-1">' . $grouping . '</span>
                        </h3>
                    </div>
                    <div class="pt-3"></div>
                    <div class="table-responsive">
                        <table id="ternakview"
                            class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer table-hover">
                            <thead>
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px sorting">Nama Kandang</th>
                                    <th class="min-w-125px sorting">Periode</th>
                                    <th class="min-w-125px sorting">Populasi</th>
                                    <th class="min-w-125px sorting">Stok Type</th>
                                    <th class="min-w-125px sorting">Status</th>
                                </tr>
                            </thead>
                            <tbody>';
        $outputchild = "";

        foreach ($datashown as $datashowns) {
            // if ($datashowns->user_id == $groupingname) {
            $statuskandang = $datashowns->status_kandang_activity == 'AKTIF' ? "<span class='badge badge-light-success'>" . ucwords($datashowns->status_kandang_activity) . "</span>" : "<span class='badge badge-light-danger'>" . ucwords($datashowns->status_kandang_activity) . "</span>";
            // if ($datashowns->status_kandang !== 'AKTIF') {
            $outputchild .= "
                                        <tr>
                                            <td class='d-flex align-items-center'>
                                                <div class='symbol symbol-circle symbol-50px overflow-hidden me-3'>
                                                    <span class='symbol-label'>
                                                        <img src='{$this->config->item('app_url')}{$datashowns->foto}' class='h-50 align-self-center' alt=''>
                                                    </span>
                                                </div>
                                                <div class='d-flex flex-column'>
                                                    <a class='text-gray-800 text-hover-primary mb-1'
                                                        href='" . base_url("main/ternak/detail/aktif/{$datashowns->id_kandang}/{$datashowns->periode}") . "'
                                                        class='btn btn-sm btn-icon btn-bg-light btn-active-color-primary'
                                                        onclick='dowaiting(this); return false;'>
                                                        {$datashowns->nama}
                                                    </a>
                                                    <span class='text-muted fw-bold d-block fs-7'>{$datashowns->alamat}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span
                                                    class='text-gray-800 text-hover-primary mb-1'>{$datashowns->periode}</span>
                                                <span class='text-muted fw-bold d-block fs-7'>Tanggal Chickin :
                                                    " . ucwords(date('M d, Y', strtotime($datashowns->tanggal_mulai))) . "</span>
                                            </td>
                                            <td>
                                                <span
                                                    class='text-muted fw-bolder text-hover-primary mb-1 fs-6'>" . number_format($datashowns->populasi_awal) . "
                                                    Ekor</span>
                                            </td>
                                            <td>
                                                <span
                                                    class='text-muted fw-bolder text-hover-primary mb-1 fs-6'>" . ucwords($datashowns->stock) . "</span>
                                            </td>
                                            <td>
                                            {$statuskandang}
                                            </td>
                                        </tr>";
            // }
        }
        $outputmaster .= $outputchild;
        $outputmaster .= '
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-5"></div>';
        // }
        return $outputmaster;
    }
}
