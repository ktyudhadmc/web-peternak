<?php

defined('BASEPATH') or exit('No direct script access allowed');
Sentry\init(['dsn' => 'https://4dba7b441a7ff5576bdc44cf8098b987@o4504875505483776.ingest.sentry.io/4506318591950848']);
class Invoice extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MData');
        $this->load->model('MThirdApp');
        $this->MThirdApp->checksession();
        $this->load->library('Dummy');
    }
    public function index()
    {
        $query = "SELECT b.nama as kandang, a.tanggal_mulai as tgl_chickin, a.populasi_awal as populasi, a.periode, c.first_name as lokasi FROM `kandang_activity` as a LEFT JOIN kandang as b on a.id_kandang = b.id LEFT JOIN users as c on b.user_id = c.id where b.user_id in (101,102,103,104,105,106,107,108,109,110,111,112,144)";
        $getdata = $this->MData->customresult($query);
        $getdata_breeding = $this->invoice_breeding(date('m'), date('Y'));
        $getdata_breeding_manado = $this->invoice_breeding_manado(date('m'), date('Y'));
        $getdata_internal = $this->invoice_internal();
        $data = array(
            'title' => 'Invoice',
            'content' => 'invoice',
            'getdata' => $getdata,
            'getdata_breeding' => json_decode($getdata_breeding, true),
            'getdata_breeding_manado' => json_decode($getdata_breeding_manado, true),
            'getdata_internal' => $getdata_internal,

        );
        $this->load->view('main/template', $data);
    }
    public function invoice_internal($tanggal = NULL)
    {
        if ($tanggal) {
            $filter_tgl = "";
        } else {
            $filter_tgl = "";
        }
        $query = "SELECT 
                    b.nama as kandang, 
                    a.tanggal_mulai as tgl_chickin,
                    IF(SUBSTRING(a.tanggal_mulai, 6, 2) = SUBSTRING(curdate(), 6, 2), 
                        0, 
                        a.populasi_awal - ifNULL((SELECT sum(total_mati) FROM `kandang_activity_log` where id_kandang = a.id_kandang and periode = a.periode and tanggal <= concat(substring(a.tanggal_mulai,1,5),substring(curdate(),6,2),substring(a.tanggal_mulai,8,3))),0)
                        ) as populasi,
                    a.periode,
                    UPPER(b.alamat) as lokasi 
                FROM `kandang_activity` a
                LEFT JOIN kandang b on a.id_kandang = b.id
                    where a.status_kandang_activity = 'AKTIF'  and 
                    SUBSTRING(a.tanggal_mulai, 9, 2) < 32 and 
                    id_kandang in (SELECT id from kandang where user_id in (101,102,103,104,105,106,107,108,109,110,111,112,144))";
        $getdata = $this->MData->customresult($query);
        // echo json_encode($getdata);
        return $getdata;
    }
    public function invoice_breeding($bulan, $tahun)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://appdmc.com/admin/invoice/invoice_breeding.php",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"bulan\"\r\n\r\n{$bulan}\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"tahun\"\r\n\r\n{$tahun}\r\n-----011000010111000001101001--\r\n",
            CURLOPT_HTTPHEADER => [
                "Accept: */*",
                "User-Agent: Thunder Client (https://www.thunderclient.com)",
                "content-type: multipart/form-data; boundary=---011000010111000001101001"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }
    public function invoice_breeding_manado($bulan, $tahun)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://appdmc.com/admin/invoice/invoice_breeding_manado.php",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"bulan\"\r\n\r\n{$bulan}\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"tahun\"\r\n\r\n{$tahun}\r\n-----011000010111000001101001--\r\n",
            CURLOPT_HTTPHEADER => [
                "Accept: */*",
                "User-Agent: Thunder Client (https://www.thunderclient.com)",
                "content-type: multipart/form-data; boundary=---011000010111000001101001"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }
}
