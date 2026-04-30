<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Search extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('MData');
        $this->load->model('MThirdApp');
        $this->load->model('MSql');
    }

    //Menampilkan data ternak
    function index()
    {
        echo json_encode(['status' => FALSE, 'message' => 'Wrong Page']);
    }
    function kandang()
    {
        $tokenstatus = $this->MThirdApp->validatetoken();
        if ($tokenstatus['status']) {
            $idx = $this->input->post('user_id');
            $showdatakandang = $this->MData->customresult("SELECT *,users.first_name FROM kandang  LEFT JOIN kandang_activity ON kandang.id = kandang_activity.id_kandang LEFT JOIN users on kandang.user_id = users.id where FIND_IN_SET({$idx}, user_id_sharing) and status_kandang in ('AKTIF','REHAT','CLOSE') AND status_kandang_activity in ('AKTIF','REHAT','CLOSE') ORDER BY kandang.nama ASC");
            if ($showdatakandang !== FALSE) {
                $output = '<div id="elementsSearchListaktif" class="mh-300px scroll-y me-n5 pe-5">';
                foreach ($showdatakandang as $showdatakandangs) {
                    $statuskandang = $showdatakandangs->status_kandang == "AKTIF" ? '<span class="badge badge-light-success">' . $showdatakandangs->status_kandang . '</span>' : '<span class="badge badge-light-danger">' . $showdatakandangs->status_kandang . '</span>';
                    $output .= "
                    <a href='" . base_url("main/ternak/detail/aktif/{$showdatakandangs->id_kandang}/{$showdatakandangs->periode}") . "' class='d-flex text-dark text-hover-primary align-items-center mb-5 element-item'>
                        <div class='symbol symbol-40px me-4'>
                           <img alt='Pic' src='" . $this->config->item('app_url') . $showdatakandangs->foto . "'>
                        </div>
                        <div class='d-flex flex-column justify-content-start fw-bold'>
                            <span class='fs-6 fw-bold'>{$showdatakandangs->nama} {$statuskandang}</span>
                            <span class='fs-7 fw-bold text-muted'>{$showdatakandangs->periode}</span>
                        </div>
                    </a>";
                }
                $output .= '</div>';
                echo $output;
            } else {
                echo NULL;
            }
        } else {
            echo json_encode(['status' => FALSE, 'message' => 'Wrong Token']);
        }
    }
}

/* End of file Sapronak.php */
