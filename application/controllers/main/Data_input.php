<?php

defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';
Sentry\init(['dsn' => 'https://4dba7b441a7ff5576bdc44cf8098b987@o4504875505483776.ingest.sentry.io/4506318591950848']);

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;


class Data_input extends CI_Controller
{
    public $cookiex;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MData');
        $this->load->model('MThirdApp');
        // $this->MThirdApp->checksession();
        $this->load->library('Dummy');
        // $this->load->library(array('excel', 'session'));
        $this->cookiex = getcookienya('user_data');
    }

    public function index()
    {
        $id_user = $this->cookiex['user_id'];
        // $getdatauser = $this->MData->customresult("SELECT * FROM `kandang` LEFT JOIN users as a on kandang.user_id = a.id where a.id_company = 1  GROUP by user_id ORDER BY `a`.`first_name` ASC");
        $list_kandang = $this->MThirdApp->listkandang_new();
        $data = array(
            'title' => 'Data Input',
            'content' => 'data_input',
            'list_kandang' => $list_kandang,
            // 'getdatauser' => $getdatauser,
        );
        $this->load->view('main/template', $data);
    }
    public function import_excel()
    {
        if (isset($_FILES["fileExcel"]["name"])) {
            $path = $_FILES["fileExcel"]["tmp_name"];
            $temp = explode(".", $_FILES["fileExcel"]["name"]);
            $extension = end($temp);
            $mimes = ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
            $allowedExts = ['xls', 'xlsx'];
            if (in_array($_FILES["fileExcel"]["type"], $mimes) && in_array($extension, $allowedExts)) {
                $inputFileName = $path;
                $spreadsheet = IOFactory::load($inputFileName);
                $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                // var_dump($sheetData);
                // $query_insert = "INSERT INTO `kandang_activity_log_panen` (`id_kandang`, `periode`, `tanggal`, `qty_ekor`, `qty_kg`, `harga`, `nomorDO`, `nomornota`, `nomor_mobil`, `namapembeli`, `kondisiayam`, `namapenimbang`, `beratkeranjang`, `susut`, `id_user`) VALUES ";

                for ($i = 1; $i <= count($sheetData); $i++) {
                    if ($i > 1) {

                        $data_id_kandang = $sheetData[$i]['A'];
                        $data_periode = $sheetData[$i]['B'];
                        $data_tanggal = $sheetData[$i]['C'];
                        $data_qty_ekor = $sheetData[$i]['D'];
                        $data_qty_kg = $sheetData[$i]['E'];
                        $data_harga = $sheetData[$i]['F'];
                        $data_nomorDO = $sheetData[$i]['G'];
                        $data_nomornota = $sheetData[$i]['H'];
                        $data_nomor_mobil = $sheetData[$i]['I'];
                        $data_namapembeli = $sheetData[$i]['J'];
                        $data_kondisiayam = $sheetData[$i]['K'];
                        $data_namapenimbang = $sheetData[$i]['L'];
                        $data_beratkeranjang = $sheetData[$i]['M'];
                        $data_susut = $sheetData[$i]['N'];
                        // if ($data_id_kandang != $_POST['id_kandang'] || $data_periode == "" || $data_tanggal == "") {
                        if ($data_id_kandang == "" || $data_periode == "" || $data_tanggal == "") {
                            $this->session->set_flashdata('danger_message', "Data yang anda masukan tidak lengkap / id_kandang salah");
                            redirect(base_url('main/data_input'), 'refresh');
                            exit;
                        }

                        if ($data_kondisiayam == "LB SEHAT") {
                            $kondisi_ayam = "normal";
                        } elseif ($data_kondisiayam == "LB SAKIT / AFKIR") {
                            $kondisi_ayam = "afkir";
                        } else {
                            $kondisi_ayam = $data_kondisiayam;
                        }
                        // if ($i != count($sheetData)) {
                        //     $query_insert .= " ('{$data_id_kandang}','{$data_periode}','{$data_tanggal}','{$data_qty_ekor}','{$data_qty_kg}','{$data_harga}','{$data_nomorDO}','{$data_nomornota}','{$data_nomor_mobil}','{$data_namapembeli}','{$data_kondisiayam}','{$data_namapenimbang}','{$data_beratkeranjang}','{$data_susut}','1'),";
                        // } else {
                        //     $query_insert .= " ('{$data_id_kandang}','{$data_periode}','{$data_tanggal}','{$data_qty_ekor}','{$data_qty_kg}','{$data_harga}','{$data_nomorDO}','{$data_nomornota}','{$data_nomor_mobil}','{$data_namapembeli}','{$data_kondisiayam}','{$data_namapenimbang}','{$data_beratkeranjang}','{$data_susut}','1');";
                        // }
                        $data = array(
                            "id_kandang" => $data_id_kandang,
                            "periode" => $data_periode,
                            "tanggal" => $data_tanggal,
                            "qty_ekor" => $data_qty_ekor,
                            "qty_kg" => $data_qty_kg,
                            "harga" => $data_harga,
                            "nomorDO" => $data_nomorDO,
                            "nomornota" => $data_nomornota,
                            "nomor_mobil" => $data_nomor_mobil,
                            "namapembeli" => $data_namapembeli,
                            "kondisiayam" => $kondisi_ayam,
                            "namapenimbang" => $data_namapenimbang,
                            "beratkeranjang" => $data_beratkeranjang,
                            "susut" => $data_susut,
                        );
                        $this->MData->tambah('kandang_activity_log_panen', $data);
                    } else {
                        // id_kandang	periode	tanggal	qty_ekor	qty_kg	harga	nomorDO	nomornota	nomor_mobil	namapembeli	kondisiayam	namapenimbang	beratkeranjang	susut
                        $data_coloumn = array(
                            "A" => "id_kandang",
                            "B" => "periode",
                            "C" => "tanggal",
                            "D" => "qty_ekor",
                            "E" => "qty_kg",
                            "F" => "harga",
                            "G" => "nomorDO",
                            "H" => "nomornota",
                            "I" => "nomor_mobil",
                            "J" => "namapembeli",
                            "K" => "kondisiayam",
                            "L" => "namapenimbang",
                            "M" => "beratkeranjang",
                            "N" => "susut",
                        );
                        foreach (range('A', 'N') as $char) {
                            // echo $sheetData[$i][$char] . " == " . $data_coloumn[$char] . "\n";
                            if ($sheetData[$i][$char] != $data_coloumn[$char]) {
                                $this->session->set_flashdata('danger_message', "Format yang anda masukan salah");
                                redirect(base_url('main/data_input'), 'refresh');
                                exit;
                            }
                        }
                    }
                }
                // echo json_encode(array($data, $query_insert));
                // $this->MData->customrow('kandang_activity_log_panena', $data);
                $this->session->set_flashdata('success_message', 'Import Berhasil');
                redirect(base_url('main/data_input'), 'refresh');
                exit;
            } else {
                $this->session->set_flashdata('danger_message', "File yang anda masukkan salah");
                redirect(base_url('main/data_input'), 'refresh');
                exit;
                // $dataaa = array(
                //     'path' => $path,
                //     'temp' => $temp,
                //     'extension' => $extension
                // );
                // echo json_encode($dataaa);
            }
        } else {
            $this->session->set_flashdata('danger_message', 'File tidak ditemukan');
            redirect(base_url('main/data_input'), 'refresh');
            exit;
        }
    }
    public function search_kandang()
    {
        if (isset($_POST['id'])) {
            $id_kandang = $_POST['id'];

            $query = "
            SELECT a.id, 
                   IFNULL(
                       (SELECT MAX(nomorDO) 
                        FROM kandang_activity_log_panen 
                        WHERE id_kandang = a.id), 0
                   ) AS nomorDO 
            FROM kandang AS a 
            WHERE a.id = '{$id_kandang}'
        ";

            // langsung query tanpa MData
            $q = $this->db->query($query);
            if ($q->num_rows() > 0) {
                $search_kandang = $q->row();
            } else {
                $search_kandang = false;
            }

            $result = array(
                "status"  => "success",
                "message" => "Found data",
                "result"  => $search_kandang,
            );
        } else {
            $result = array(
                "status"  => "error",
                "message" => "Data not found",
            );
        }

        echo json_encode($result);
    }
}
