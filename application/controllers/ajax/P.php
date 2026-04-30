<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class P extends CI_Controller
{
    public $cookiex;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MThirdApp');
        $this->load->model('MData');
        $this->load->model('MSql');
        // $this->MThirdApp->checksession();
        $this->cookiex = getcookienya('user_data');
    }

    public function index()
    {
        redirect('error404', 'refresh');
        exit;
    }
    public function getgrouping()
    {
        if ($this->input->post()) {
            $sql = "select k.id, k.nama, ka.periode from kandang k inner join kandang_activity ka on k.id = ka.id_kandang where ka.status_kandang_activity = 'AKTIF' AND user_id in (select user_id from kandang where id = '{$this->input->post('id')}')";
            echo json_encode($this->MData->customresult($sql));
        }
    }
    public function getbilling()
    {
        $cekdatas = $this->MData->customresult("SELECT ka.periode, k.id_lokasi, cs.id_company ,IFNULL((SELECT nama_company FROM company c WHERE c.id = cs.id_company),'Umum') as nama_company, k.nama as nama_kandang, ka.* FROM kandang_activity ka LEFT JOIN kandang k ON k.id = ka.id_kandang LEFT JOIN company_sub cs ON k.id_lokasi = cs.id WHERE ka.billing = '0'");
        if ($cekdatas) {
            foreach ($cekdatas as $cekdata) {
                $cekharga = $cekdata->id_company <> 1 ?  $this->MData->selectdatawhere('package_list', ['nama' => 'Mitra']) : $this->MData->selectdatawhere('package_list', ['nama' => 'Internal']);
                $data = [
                    'id_activity' => $cekdata->id,
                    'company' => $cekdata->nama_company,
                    'id_kandang' => $cekdata->id_kandang,
                    'periode' => $cekdata->periode,
                    'nama_kandang' => $cekdata->nama_kandang,
                    'populasi' => $cekdata->populasi_awal,
                    'price'    => $cekharga->harga,
                    'total'    => (int)$cekdata->populasi_awal * (int)$cekharga->harga
                ];
                $this->MData->tambah("billing_log", $data);
                $this->MData->edit(['id' => $cekdata->id], 'kandang_activity', ['billing' => '1']);
            }
        }
        $total = $cekdatas ? count($cekdatas) : 0;
        echo json_encode(['status' => 'Success', 'msg' => "There {$total} data billing"]);
    }

    public function getverified()
    {
        $cekdata = $this->MData->customresult("SELECT * from kandang where status_kandang not in('DELETE') and id_lokasi is not null");
        foreach ($cekdata as $cekdatas) {
            $cekdatamitra = $this->MData->customresult(" CALL `getcompanyfromsub`('{$cekdatas->id}')");
            echo json_encode($cekdatamitra);
            // if ($cekdatamitra) {
            //     echo $cekdatas->id . " -> " . $cekdatas->nama . " adalah mitra<br>";
            // }
        }
    }
    public function mutasisync()
    {
        //Check data mutasi out yang id_kandang_to nya bukan 1 karena 1 itu dan lain lain
        $checkdata = $this->MData->customresult("
        SELECT out_data.*
        FROM kandang_activity_log_sapronak AS out_data
        WHERE method_sapronak = 'OUT'
        AND id_kandang_to IS NOT NULL
        AND id_kandang_to NOT IN ('1')
        AND periode IS NOT NULL
        AND qty IS NOT NULL
        AND id_this IS NOT NULL
        AND type_sapronak IS NOT NULL
        AND is_approved = 1
        AND NOT EXISTS (
            SELECT 1
            FROM kandang_activity_log_sapronak AS in_data
            WHERE in_data.method_sapronak = 'IN'
            AND in_data.id_kandang = out_data.id_kandang_to
            AND in_data.id_kandang_to IS NOT NULL
            AND in_data.periode = out_data.periode
            AND in_data.qty = out_data.qty
            AND in_data.id_this = out_data.id_this
            AND in_data.type_sapronak = out_data.type_sapronak
        )");
        if ($checkdata) {
            foreach ($checkdata as $checkdatas) {
                $inputdatakandangto = [
                    'id_kandang' => $checkdatas->id_kandang_to,
                    'id_kandang_to' => $checkdatas->id_kandang,
                    'periode' => $checkdatas->periode,
                    'tanggal_kandang_activity_log' => $checkdatas->tanggal_kandang_activity_log,
                    'type_sapronak' => $checkdatas->type_sapronak,
                    'method_sapronak' => 'in',
                    'id_this' => $checkdatas->id_this,
                    'harga' => $checkdatas->harga,
                    'qty' => $checkdatas->qty,
                    'id_user' => $_COOKIE['user_id'],
                    'is_approved' => '1',
                    'ket' => $checkdatas->ket,
                ];
                $this->MData->tambah('kandang_activity_log_sapronak', $inputdatakandangto);
            }
            echo json_encode(['status' => true, 'data' => 'Data OUT yang tidak ada IN nya ' . count($checkdata)]);
            exit;
        }
        echo json_encode(['status' => false, 'data' => 'No data']);
    }

    public function mutasikandang($id)
    {
        if ($this->input->post()) {
            if (count(explode("-", $this->input->post('data'))) > 1) {
                $dataarr = explode("-", $this->input->post('data'));
                for ($i = 0; $i < count($dataarr); $i++) {
                    $this->MData->edit(['id' => $dataarr[$i]], 'kandang', ['user_id' => $id, 'change_by' => $this->cookiex['user_id']]);
                }
                echo json_encode(['status' => true, 'message' => $this->input->post()]);
            } else {
                $this->MData->edit(['id' => $this->input->post('data')], 'kandang', ['user_id' => $id, 'change_by' => $this->cookiex['user_id']]);
                echo json_encode(['status' => true, 'message' => $this->input->post()]);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'Gagal']);
        }
    }
    public function ping()
    {
        $connected = @fsockopen("google.com", 80);
        //website, port  (try 80 or 443)
        if ($connected) {
            $is_conn = true; //action when connected
            fclose($connected);
        } else {
            $is_conn = false; //action in connection failure
        }
        echo $is_conn;
    }
    public function test()
    {
        $data = array(
            'content' => 'page-coming-soon',
            'title' => 'Comming Soon',
        );
        $this->load->view('mobile/template', $data);
    }
    public function getratingapp()
    {
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $checkdata = $this->MData->selectdatawhere('users', array('id' => $id));
            if ($checkdata !== FALSE) {
                $value = array('rating_app' => $this->input->post('value'));
                $this->MData->edit(array('id' => $id), 'users', $value);
                echo json_encode(array('status' => true, 'message' => 'Rating telah diberikan, Terimakasih'));
            } else {
                echo json_encode(array('status' => false, 'message' => 'Wrong data'));
            }
        } else {
            echo json_encode(array('status' => false, 'message' => 'Wrong'));
        }
    }
    public function maintenance()
    {
        $data = array(
            'title' => "Maintenance",
            'content' => "maintenance",
        );
        $this->load->view('mobile/template', $data);
    }
    public function updateversion()
    {
        $getdata = $this->MData->selectdatawhere('users', array('id' => $this->cookiex['user_id']));
        $getcurrentv = $this->MData->selectdatawhere('updaterversion', array('status' => 'currentv'));
        $dataupdate = array('app_version' => $getcurrentv->versionapp);
        $this->MData->edit(array('id' => $getdata->id), 'users', $dataupdate);
        echo json_encode(array('status' => true, 'message' => 'Aplikasi berhasil diperbarui'));
    }
    public function updatecache()
    {
        if ($this->input->post()) {
            $getdata = $this->MData->selectdatawhere('users', array('id' => $this->input->post('id')));
            $this->MData->edit(array('id' => $this->input->post('id')), 'users', ['cache' => '0']);
            echo json_encode(array('status' => true, 'message' => 'Aplikasi berhasil direfresh'));
        }
    }
    public function pushnotif($id, $message)
    {
        if ($id !== "" && $message !== "") {
            $cekuser = $this->MData->selectdatawhereresult("cookies", ['user_id' => $id, 'status' => 'run']);
            if ($cekuser !== FALSE) {
                foreach ($cekuser as $cekusers) {
                    $this->MThirdApp->pushnotif($cekusers->uuid, $message);
                }
            }
        }
    }
    public function pushnotifapp()
    {
        if ($this->input->post()) {
            $judul = $this->input->post('judul');
            $message = $this->input->post('message');
            $to = $this->MData->selectdatawhere('users', ['id' => $this->input->post('id')])->token_fcm;
            $action = $this->input->post('action');
            $output = $this->MThirdApp->fcmnotif($to, $judul, $message, $action, FALSE);
        } else {
            echo json_encode(['status' => false, 'message' => 'wrong command']);
        }
    }
    public function notiftelatinputapp()
    {
        $query = "SELECT a.id_kandang,
                  a.periode,
                  c.nama as nama_kandang,
                  ifNULL((a.populasi_awal - b.total_mati - d.qty_ekor),0) as populasi,
                  c.user_id,
                  IFNULL(tanggal ,a.tanggal_mulai) as tgl_input,
                  now() as tgl,
                  wn.number as tujuan,
                  IFNULL(DATEDIFF(now(),IFNULL(max(b.tanggal),a.tanggal_mulai)) -1,0) as selisih,
                  c.user_id_sharing as user_sharing,
                  IF(IFNULL(DATEDIFF(now(),IFNULL(max(b.tanggal),a.tanggal_mulai)) -1,0)>=3, 1, 0) as notif
                  FROM `kandang_activity` as a
                  left join (SELECT sum(total_mati) as total_mati, id_kandang, periode, max(tanggal) as tanggal from kandang_activity_log GROUP by periode,id_kandang) as b on a.id_kandang = b.id_kandang and a.periode = b.periode
                  LEFT join kandang as c on c.id = a.id_kandang
                  left join (SELECT sum(qty_ekor) as qty_ekor, id_kandang, periode from kandang_activity_log_panen group by periode,id_kandang) as d on a.id_kandang = d.id_kandang and a.periode = d.periode
                  LEFT JOIN web_notif_sendto wn on wn.id_user = c.user_id AND wn.type_number ='group' and wn.status = '1'
                  where a.status_kandang_activity = 'AKTIF' and wn.number != '' and wn.number not in ('120363023322096287@g.us','120363020867036201@g.us')
                  GROUP by a.id_kandang,a.periode,wn.number  
                  ORDER BY `c`.`user_id`  ASC";
        $data = $this->MData->customresult($query);
        $dataoutput = array();
        foreach ($data as $datas) {
            if ($datas->notif == "1" and $datas->populasi > 100) {
                $message = "Kandang $datas->nama_kandang belum diinput sejak $datas->selisih hari yang lalu.";
                $user_sharingshar = explode(",", $datas->user_sharing);
                foreach ($user_sharingshar as $key => $id_user) {
                    $cektoken = $this->MData->customrow("SELECT * FROM users where id = '{$id_user}' AND token_fcm is not NULL");
                    if ($cektoken !== FALSE) {
                        $dataresulfcm = $this->MThirdApp->fcmnotif($cektoken->token_fcm, "Notifikasi telat input !", $message, base_url("ternak/ternak_input_harian/$datas->id_kandang/$datas->periode"));
                    }
                }
                $dataoutput[] = $datas;
            }
        }
        echo json_encode($dataoutput);
    }
    public function testdata($idkandang)
    {
        $cekuserid = $this->MData->selectdatawhere('kandang', ['id' => $idkandang]);
        $usersharingkandang = NULL;
        if ($cekuserid !== false) {
            $usersharingkandang = $cekuserid->user_id_sharing;
        }
        if ($usersharingkandang !== NULL) {
            $cektokenfcm = $this->MData->customresult("select first_name, token_fcm from users where id in ({$usersharingkandang}) and token_fcm is not null");
            if ($cektokenfcm !== FALSE) {
                foreach ($cektokenfcm as $cektokenfcms) {
                    $judul = "Info Terbaru";
                    $message = "Test saja";
                    $to = $cektokenfcms->token_fcm;
                    $this->MThirdApp->fcmnotif($to, $judul, $message, "https://app.peternak.id/dist", FALSE);
                    // echo json_encode($cektokenfcms);
                }
            }
        }
        // echo $usersharingkandang;
    }
    public function notiftelatinputwa()
    {
        $query = "SELECT a.id_kandang,
                  a.periode,
                  c.nama as nama_kandang,
                  ifNULL((a.populasi_awal - b.total_mati - d.qty_ekor),0) as populasi,
                  c.user_id,
                  IFNULL(tanggal ,a.tanggal_mulai) as tgl_input,
                  now() as tgl,
                  wn.number as tujuan,
                  IFNULL(DATEDIFF(now(),IFNULL(max(b.tanggal),a.tanggal_mulai)) -1,0) as selisih,
                  c.user_id_sharing as user_sharing,
                  IF(IFNULL(DATEDIFF(now(),IFNULL(max(b.tanggal),a.tanggal_mulai)) -1,0)>=3, 1, 0) as notif
                  FROM `kandang_activity` as a
                  left join (SELECT sum(total_mati) as total_mati, id_kandang, periode, max(tanggal) as tanggal from kandang_activity_log GROUP by periode,id_kandang) as b on a.id_kandang = b.id_kandang and a.periode = b.periode
                  LEFT join kandang as c on c.id = a.id_kandang
                  left join (SELECT sum(qty_ekor) as qty_ekor, id_kandang, periode from kandang_activity_log_panen group by periode,id_kandang) as d on a.id_kandang = d.id_kandang and a.periode = d.periode
                  LEFT JOIN web_notif_sendto wn on wn.id_user = c.user_id AND wn.type_number ='group' and wn.status = '1'
                  where a.status_kandang_activity = 'AKTIF' and wn.number != '' and wn.number not in ('120363023322096287@g.us','120363020867036201@g.us')
                  GROUP by a.id_kandang,a.periode,wn.number  
                  ORDER BY `c`.`user_id`  ASC";
        $data = $this->MData->customresult($query);
        $dataoutput = array();
        foreach ($data as $datas) {
            if ($datas->notif == "1" and $datas->populasi > 100) {
                $message = "Kandang $datas->nama_kandang, sudah $datas->selisih hari data tidak diinput, dari tanggal $datas->tgl_input.";
                $user_sharingshar = explode(",", $datas->user_sharing);
                if ($datas->tujuan !== "") {
                    $dataresulfcm = $this->MThirdApp->sendantrian($message, $datas->tujuan);
                }
                $dataoutput[] = $datas;
            }
        }
        echo json_encode($dataoutput);
    }

    public function deletekandang()
    {
        if ($this->input->post()) {
            $id_kandang_raw = $this->input->post('id_kandang');
            if (strpos($id_kandang_raw, ',') !== false) {
                $id_kandang = explode(",", $id_kandang_raw);
                for ($i = 0; $i < count($id_kandang); $i++) {
                    $this->MData->edit(array('id' => $id_kandang[$i]), 'kandang', array('status_kandang' => 'DELETE'));
                }
            } else {
                $id_kandang = $id_kandang_raw;
                $this->MData->edit(array('id' => $id_kandang), 'kandang', array('status_kandang' => 'DELETE'));
            }
            echo json_encode(array('status' => true, 'message' => 'Data berhasil dihapus'));
        } else {
            echo json_encode(array('status' => false, 'message' => 'Tidak ada data'));
        }
    }
    public function deletepanendo()
    {
        if ($this->input->post()) {
            $cekdata = $this->MData->selectdatawhere('kandang_activity_log_panen', array('id' => $this->input->post('id')));
            if ($cekdata !== FALSE) {
                $cekdatacount = $this->MData->selectdatawhereresult('kandang_activity_log_panen', array('id_kandang' => $cekdata->id_kandang, 'periode' => $cekdata->periode, 'nomorDO' => $cekdata->nomorDO));
                // echo count((array)$cekdatacount); exit;
                if (count((array)$cekdatacount) == 1) {
                    $this->MData->edit(['id' => $this->input->post('id')], "kandang_activity_log_panen", ['qty_ekor' => NULL, 'qty_kg' => NULL, 'harga' => NULL]);
                } else {
                    $this->MData->delete('kandang_activity_log_panen', array('id' => $this->input->post('id')));
                }
                echo json_encode(array('status' => true, 'message' => 'Data berhasil dihapus'));
            } else {
                echo json_encode(array('status' => false, 'message' => 'Data tidak ditemukan'));
            }
        } else {
            echo json_encode(array('status' => false, 'message' => 'Data salah'));
        }
    }
    public function checkkandanglog()
    {
        if ($this->input->post()) {
            $idkandang = $this->input->post('idkandang');
            $periode = $this->input->post('periode');
            $cektanggal = $this->MData->selectdatawhere('kandang_activity_log', array('id_kandang' => $idkandang, 'periode' => $periode, 'tanggal' => $_POST['tanggal']));
            if ($cektanggal == false) {
                $html = "<input class='form-control form-control-sm' name='input[id_kandang]' type='hidden' value='{$idkandang}' required>
        <input class='form-control form-control-sm' name='input[periode]' type='hidden' value='{$periode}' required>
        <div class='form-group'>
        <label class='form-label text-dark' for='exampleInputText'>Mati(ekor) </label>&nbsp; <i class='fas fa-question-circle' data-toggle='tooltip' data-placement='top' title='ayam yang mati'></i>
        <input class='form-control form-control-sm' id='exampleInputText' name='input[mati]' type='number' placeholder='0' required autofocus>
        </div>
        <div class='form-group'>
        <label class='form-label text-dark' for='periode'>Culling(ekor) </label>&nbsp; <i class='fas fa-question-circle' data-toggle='tooltip' data-placement='top' title='pemisahan ayam yang dinilai potensinya mungkin berpengaruh terhadap produksi/performa.'></i>
        <input class='form-control form-control-sm' id='periode' name='input[culling]' type='number' placeholder='0' required>
        </div>
        <div class='form-group'>
        <label class='form-label text-dark' for='periode'>BW(gram) </label>&nbsp; <i class='fas fa-question-circle' data-toggle='tooltip' data-placement='top' title='Bobot rata - rata ayam'></i>
        <input class='form-control form-control-sm' id='periode' name='input[bw]' type='number' placeholder='0' required>
        </div>
        <div class='form-group'>
        <label class='form-label text-dark' for='periode'>Water(liter) </label>&nbsp; <i class='fas fa-question-circle' data-toggle='tooltip' data-placement='top' title='Bobot rata - rata ayam'></i>
        <input class='form-control form-control-sm' id='periode' name='input[water]' type='number' placeholder='0' required>
        </div>
        <div class='form-group'>
        <label class='form-label text-dark' for='periode'>CV </label>&nbsp; <i class='fas fa-question-circle' data-toggle='tooltip' data-placement='top' title='Bobot rata - rata ayam'></i>
        <input class='form-control form-control-sm' id='periode' name='input[cv]' type='number' step='0.01' placeholder='0' required>
        </div>
        <div class='form-group'>
        <label class='form-label text-dark' for='periode'>Uniformity </label>&nbsp; <i class='fas fa-question-circle' data-toggle='tooltip' data-placement='top' title='Bobot rata - rata ayam'></i>
        <input class='form-control form-control-sm' id='periode' name='input[uniformity]' type='number' step='0.01' placeholder='0' required>
        </div>";
                echo json_encode(array('status' => true, 'message' => $html));
            } else {
                echo json_encode(array('status' => false, 'message' => true));
            }
        } else {
            echo json_encode(array('status' => true, 'message' => 'false'));
        }
    }
    public function getnavdrop()
    {
        if ($this->input->post()) {
            $_POST['user_id'] = $this->cookiex['user_id'];
            $getdata = $this->MData->selectdatawhereresult('web_header_tab', array('user_id' => $this->cookiex['user_id']));
            if ($getdata !== FALSE) {
                foreach ($getdata as $getdatas) {
                    if ($getdatas->nav_group == $this->input->post('nav_group')) {
                        $data = array('status' => 1);
                        $this->session->set_userdata(array('nav_tab' => $this->input->post('nav_group')));
                        $_SESSION['nav_tab'] = array(
                            'nav_group' => $getdatas->nav_group,
                            // 'link' => base_url("ternak_x/ternak_detail/aktif/{$this->input->post('id_kandang')}/{$this->input->post('periode')}/{$getdatas->link}"),
                            'link' => base_url("ternak_x/ternak_detail/aktif/{$this->input->post('id_kandang')}/{$this->input->post('periode')}/{$getdatas->link}"),
                        );
                    } else {
                        $data = array('status' => 0);
                    }
                    $this->MData->edit(array('id' => $getdatas->id), 'web_header_tab', $data);
                }
                // echo json_encode(array('status'=>true,'message'=>$this->session->userdata()));
                // echo json_encode($this->session->userdata());
            } else {
                echo json_encode(array('status' => false, 'message' => 'fail'));
            }
        } else {
            echo json_encode(array('status' => false, 'message' => 'fail'));
        }
    }
    public function deletenomordo()
    {
        if ($this->input->post()) {
            $cekdata = $this->MData->selectdatawhereresult('kandang_activity_log_panen', $_POST);
            $this->MData->delete('kandang_activity_log_panen', $_POST);
            echo json_encode(array('status' => true, 'message' => "Data Nomor DO :{$_POST['nomorDO']} berhasil dihapus.."));
        } else {
            echo json_encode(array('status' => false, 'message' => 'No Data Found'));
        }
    }
    public function updatetesti()
    {
        $id = $_COOKIE['user_id'];
        $this->MData->edit(['id' => $id], 'users', ['is_testimonial' => '2']);
    }
    public function updatetestiproses()
    {
        $id = $_COOKIE['user_id'];
        $testimoni = $this->input->post('testimoni');
        $datainput = [
            'id_user' => $id,
            'testimoni' => $testimoni
        ];
        $this->MData->tambah('testimoni', $datainput);
        $this->MData->edit(['id' => $id], 'users', ['is_testimonial' => '3']);
    }
    public function savettdimage()
    {
        if ($this->input->post()) {
            $idkandang = $this->input->post('id_kandang');
            $periode = $this->input->post('periode');
            $nomordo = $this->input->post('nomordo');
            $data_penimbang = $this->input->post('image_penimbang');
            $data_pembeli = $this->input->post('image_pembeli');
            // Penimbang
            list($type, $data_penimbang) = explode(';', $data_penimbang);
            list(, $data_penimbang
            )      = explode(',', $data_penimbang);
            $filename_penimbang = "ttdpenimbang_{$idkandang}_{$periode}_{$nomordo}" . date('Ymdhis') . ".png";
            $data_penimbang = base64_decode($data_penimbang);
            $pathpenimbang = str_replace('application', 'assets/mobile/img/ttd', APPPATH) . $filename_penimbang;
            file_put_contents($pathpenimbang, $data_penimbang);
            // Pembeli
            list($type, $data_pembeli) = explode(';', $data_pembeli);
            list(, $data_pembeli
            )      = explode(',', $data_pembeli);
            $data_pembeli = base64_decode($data_pembeli);
            $filename_pembeli = "ttdpembeli_{$idkandang}_{$periode}_{$nomordo}" . date('Ymdhis') . ".png";
            $pathpembeli = str_replace('application', 'assets/mobile/img/ttd', APPPATH) . $filename_pembeli;
            file_put_contents($pathpembeli, $data_pembeli);
            $this->MData->edit(array('id_kandang' => $idkandang, 'periode' => $periode, 'nomorDO' => $nomordo), 'kandang_activity_log_panen', array('ttdpembeli' =>  base_url('assets/mobile/img/ttd/' . $filename_pembeli), 'ttdpenimbang' =>  base_url("assets/mobile/img/ttd/" . $filename_penimbang)));
            echo json_encode(array('status' => true, 'message' => 'TTD Berhasil masuk kedatabase'));
        } else {
            echo json_encode(array('status' => false, 'message' => 'Data tidak ditemukan'));
        }
    }
    public function searchuserbynumber()
    {
        if ($this->input->post('token') !== "") {
            $token = $this->input->post('token');
            $input = $this->input->post('input');
            $owner = $this->input->post('owner');
            $getdata = $this->MData->selectdatawhere('users', ['token_ajax' => $token]);
            if ($getdata !== false) {
                $datausers = $this->MData->selectdatawhere('users', ['number' => $input]);
                $getmastercompany = $this->MData->selectdatawhere('users', ['id' => $owner]);
                if ($datausers !== false) {
                    $getrole = $this->MData->selectdatawhere('users_role', ['id' => $datausers->role]);
                    //Data ditemukan
                    $cekrole = $this->MThirdApp->checkrulecompanyadd($datausers->role);
                    if ($datausers->id_company !== "0" && $datausers->id_company !== NULL) {
                        $onalertrole = "onclick ='notifalert(`Error`,`Akun ini sudah mempunyai company`,`error`)'";
                    } else {
                        if ($cekrole == true) {
                            $onalertrole = "onclick='sendcompany(`{$datausers->first_name}`, `{$datausers->id}`,`{$getmastercompany->id_company}`)'";
                        } else {
                            $onalertrole = "onclick ='notifalert(`Error`,`Tidak bisa tambah company diakun ini`,`error`)'";
                        }
                    }
                    $addcompany = "
                        <a class='text-dark needfontsize' {$onalertrole} href='#' style='background-color: #f05924;' data-bs-toggle='modal' data-bs-target='#ternak_edit_aktifModal'>
                            <li class='dropdown-item'>
                                <img src='" . base_url() . "assets/resource/icon/add_circled.svg' style='width:18px;height:18px;'>&nbsp;Add to company
                            </li>
                        </a>";
                    $dataoutput = "<table class='table'>
                                    <tbody>
                                        <tr>
                                            <td colspan='3' class='needfontsize text-dark'>
                                                <div class='row'>
                                                    <div class='col-8 text-start' style='font-size:16px;margin-top: 8px;margin-bottom: 8px'>$datausers->first_name</div>
                                                    <div class='col-4 text-end' style='margin-top: 8px;margin-bottom: 8px'>
                                                        <div class='col-12 text-end dropstart' data-bs-toggle='dropdown'>
                                                            <img src='" . base_url() . "assets/resource/icon/more_vertical.svg' style='width:18px;height:18px;'>
                                                        </div>
                                                        <ul class='dropdown-menu' style='color:black;border-radius: 10px;width:30px;'>
                                                            {$addcompany}
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class='needfontsize text-dark'>Number</td>
                                            <td class='needfontsize text-dark' style='width: 90px;'>:</td>
                                            <td class='needfontsize text-dark'>" . $datausers->number . "</td>
                                        </tr>
                                        <tr>
                                            <td class='needfontsize text-dark'>Role</td>
                                            <td class='needfontsize text-dark' style='width: 90px;'>:</td>
                                            <td class='needfontsize text-dark'>" . $getrole->role_nm . "</td>
                                        </tr>
                                        <tr>
                                            <td class='needfontsize text-dark'>Company</td>
                                            <td class='needfontsize text-dark' style='width: 90px;'>:</td>
                                            <td class='needfontsize text-dark'>" . $datausers->id_company . "</td>
                                        </tr>
                                    </tbody>
                                </table>";
                    echo json_encode(['status' => true, 'message' => $dataoutput]);
                } else {
                    echo json_encode(['status' => false, 'message' => "Nomor {$input} tidak ditemukan"]);
                }
            } else {
                echo json_encode(['status' => false, 'message' => 'Unknown']);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'Cant Access']);
        }
    }
    public function addcompanyproses()
    {
        if ($this->input->post('token') !== "") {
            $token = $this->input->post('token');
            $iduser = $this->input->post('id_user');
            $getdata = $this->MData->selectdatawhere('users', ['token_ajax' => $token]);
            if ($getdata !== false) {
                $cekuser = $this->MData->selectdatawhere('users', ['id' => $iduser]);
                if ($cekuser !== false) {
                    $this->MData->edit(['id' => $iduser], 'users', ['id_company' => $this->input->post('mastercompany')]);
                    echo json_encode(['status' => true, 'message' => 'User ini berhasil ditambahkan ke company anda']);
                } else {
                    echo json_encode(['status' => false, 'message' => 'User tidak ditemukan']);
                }
            } else {
                echo json_encode(['status' => false, 'message' => 'Token Salah']);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'Token cant null']);
        }
    }
    public function delete_lokasi()
    {
        if ($this->input->post('token') !== "") {
            $token = $this->input->post('token');
            $idlokasi = $this->input->post('id');
            $getdata = $this->MData->selectdatawhere('users', ['token_ajax' => $token]);
            if ($getdata !== false) {
                $cekuser = $this->MData->selectdatawhere('company_sub', ['id' => $idlokasi]);
                if ($cekuser !== false) {
                    $this->MData->delete('company_sub', ['id' => $idlokasi]);
                    echo json_encode(['status' => true, 'message' => 'Lokasi ini berhasil dihapus']);
                } else {
                    echo json_encode(['status' => false, 'message' => 'Lokasi tidak ditemukan']);
                }
            } else {
                echo json_encode(['status' => false, 'message' => 'Token Salah']);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'Token cant null']);
        }
    }
    public function unlink()
    {
        if ($this->input->post('token') !== "") {
            $token = $this->input->post('token');
            $iduser = $this->input->post('id_user');
            $getdata = $this->MData->selectdatawhere('users', ['token_ajax' => $token]);
            if ($getdata !== false) {
                $cekuser = $this->MData->selectdatawhere('users', ['id' => $iduser]);
                if ($cekuser !== false) {
                    $this->MData->edit(['id' => $iduser], 'users', ['id_company' => NULL, 'role' => 4]);
                    $this->MData->edit(['user_id' => $iduser], 'kandang', ['id_lokasi' => NULL]);
                    echo json_encode(['status' => true, 'message' => 'User ini berhasil diunlink dari company anda']);
                } else {
                    echo json_encode(['status' => false, 'message' => 'User tidak ditemukan']);
                }
            } else {
                echo json_encode(['status' => false, 'message' => 'Token Salah']);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'Token cant null']);
        }
    }
    public function addlokasi()
    {
        if ($this->input->post('input') !== "") {
            $data = [
                'id_company' => $_POST['input']['id_company'],
                'location' => $_POST['input']['lokasi'],
                'status' => '1'
            ];
            $this->MData->tambah('company_sub', $data);
            echo json_encode(['status' => true, 'message' => 'Tambah lokasi berhasil']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Gagal simpan']);
        }
    }
    public function syncnavsetting()
    {
        $getmasternav = $this->MData->selectdatawhereresult('web_header_tab_master', array('status' => 1));
        $cekuser = $this->MData->selectdataglobal2('users');
        // echo json_encode($cekuser);
        $no = 1;
        foreach ($getmasternav as $getmasternavs) {
            foreach ($cekuser as $cekusers) {
                $ceknavbar = $this->MData->selectdatawhere('web_header_tab', array('user_id' => $cekusers->id, 'nav_group' => $getmasternavs->name));
                if ($ceknavbar == false) {
                    $data = array(
                        'nav_group'  => $getmasternavs->name,
                        'status'  => 0,
                        'user_id'  => $cekusers->id,
                        'link'  => "?" . strtolower($getmasternavs->name) . "=true"
                    );
                    $this->MData->tambah('web_header_tab', $data);
                }
            }
        }
        echo "done";
    }
    public function syncusersetting()
    {
        $getuser = $this->MData->selectdataglobal2('users');
        foreach ($getuser as $getusers) {
            $getnavbar = $this->MData->selectdatawhere('users_setting', array('id_user' => $getusers->id));
            if ($getnavbar == FALSE) {
                $data = array('id_user' => $getusers->id);
                $this->MData->tambah('users_setting', $data);
            }
        }
        echo "done";
    }
    public function delete()
    {
        if ($this->input->post()) {
            $status = "status_" . $this->input->post('table');
            $data = array(
                $status => 'DELETE',
            );
            $this->MData->edit(array('id' => $this->input->post('id')), $this->input->post('table'), $data);
            echo json_encode(array('status' => true, 'message' => 'Data Berhasil Dihapus'));
        } else {
            echo json_encode(array('status' => false, 'message' => 'no data'));
        }
    }
    public function setting()
    {
        if ($this->input->post()) {
            $this->MData->edit(array(), 'web_setting', array($this->input->post('index') => $this->input->post("value")));
            echo json_encode(array('status' => true, 'message' => 'True'));
        } else {
            echo json_encode(array('status' => false, 'message' => 'Wrong'));
        }
    }
    public function onlinestatus()
    {
        $datenow = date('Y-m-d');
        $idku = $this->cookiex['user_id'];
        if ($this->input->post()) {
            $uuid = $this->input->post('uuid');
            $cekdata = $this->MData->customrow("SELECT *,cookies.status as statususer FROM cookies LEFT JOIN users ON cookies.user_id = users.id WHERE uuid = '{$uuid}'");
            if ($cekdata == false) {
                echo json_encode(array('status' => false, 'message' => 'Wrong data'));
                return;
            }
            $idnew = date('Ymd') . $cekdata->user_id;
            $cekonline = $this->MData->selectdatawhere('users_online', array('id' => $idnew));
            $data = array(
                'id' => $idnew,
                'id_user' => $cekdata->user_id,
                'status' => 'on',
                'updated_at' => date('Y-m-d H:i:s')
            );
            if ($cekonline == false) {
                $this->MData->tambah('users_online', $data);
            } else {
                $data = array('status' => 'on', 'updated_at' => date('Y-m-d H:i:s'));
                $this->MData->edit(array('id' => $cekonline->id), 'users_online', $data);
            }
            $cekuseronline = $this->MData->customresult("
      SELECT
      uo.id_user as id,
      u.first_name as name,
      u.foto as foto
      from users_online uo LEFT JOIN users u ON uo.id_user = u.id
      where uo.status = 'on' and uo.created_at like '%{$datenow}%' and uo.id_user not in ({$idku})");
            if ($cekuseronline !== FALSE) {
                foreach ($cekuseronline as $cekuseronlines) {
                    $datanya[] = "<div>
          <div class='user-status-slide'>
          <a href='" . base_url("chat/chat_detail/{$cekuseronlines->id}") . "'><img src='" . base_url($cekuseronlines->foto) . "' alt=''>
          <div class='active-status'></div>
          <p class='mb-0 mt-2 text-truncate'>{$cekuseronlines->name}</p></a>
          </div>
          </div>";
                }
                $datafinal = array(
                    'status' => true,
                    'message' => implode("", $datanya)
                );
                echo json_encode($datafinal);
            } else {
                echo json_encode(array('status' => false, 'message' => 'No online data'));
            }
        } else {
            echo json_encode(array('status' => false, 'message' => 'No data'));
        }
    }

    public function ternakviewpost()
    {

        if ($this->MThirdApp->validatetokensimple($this->input->post('token'))) {
            $sqlshowdatakandang = "SELECT a.* from (SELECT id_kandang, MAX(tanggal_mulai) as tanggal_mulai FROM `kandang_activity` where kandang_activity.id_kandang in (select id from kandang where kandang.user_id in (SELECT id from users where users.first_name = '" . $this->input->post('groupingname') . "')) group by id_kandang) as asal
                                            LEFT join (SELECT kandang.foto, kandang.nama, kandang.alamat, kandang.stock, kandang_activity.id_kandang, kandang_activity.periode, kandang_activity.populasi_awal, kandang_activity.tanggal_mulai, kandang_activity.status_kandang_activity FROM kandang LEFT JOIN kandang_activity ON kandang.id = kandang_activity.id_kandang LEFT JOIN users on kandang.user_id = users.id where FIND_IN_SET('39', kandang.user_id_sharing) AND status_kandang in ('AKTIF','REHAT','CLOSE') AND status_kandang_activity in ('AKTIF','REHAT','CLOSE') AND users.first_name = '" . $this->input->post('groupingname') . "' ORDER BY kandang.nama ASC) as a on a.tanggal_mulai = asal.tanggal_mulai and a.id_kandang = asal.id_kandang";
            $showdatakandang = $this->MData->customresult($sqlshowdatakandang);
            if ($showdatakandang !== FALSE) {
                echo json_encode(['status' => true, 'data' => $this->view_ternakview($this->input->post('groupingname'), $showdatakandang), 'responseCode' => 200]);
            } else {
                echo json_encode(['status' => false, 'data' => 'No data found', 'responseCode' => 500]);
            }
        } else {
            echo json_encode(['status' => false, 'data' => 'Token tidak ditemukan', 'responseCode' => 500]);
            exit;
        }
    }

    public function ternakview($kandang = NULL)
    {
        if ($kandang == NULL) {
            redirect('error404', 'refresh');
        } else {
            switch ($kandang) {
                case 'aktif':
                    $kandangaktif = $this->MData->selectdatawhereresult('kandang', array('user_id' => $this->cookiex['user_id'], 'status_kandang' => 'aktif'));
                    if (is_array($kandangaktif)) {
                        foreach ($kandangaktif as $kandangaktifs) {
                            $output[] = "
              <div class='container'>
              <a href='" . base_url("ternak_x/ternak_detail/aktif/{$kandangaktifs->id}") . "'>
              <div class='card card-bg-img bg-img bg-overlay' style='background-image: url('" . base_url($kandangaktifs->foto) . "')'>
              <!-- <span class='badge bg-success'>{periode_kandang}<br>{status}</span> -->
              <div class='card-body'>
              <div class='h-50'>
              <div class='slide-text'>
              <div class='row'>
              <div class='col-6'>
              <p class='text-white' style='font-size: 12px;'><strong>" . strtoupper($kandangaktifs->nama) . "</strong></p>
              <p class='text-white' style='font-size: 9px;'>{periode_kandang}<br>{tgl_chickin}</p>
              </div>
              <div class='col-6'>
              <p class='text-white' style='font-size: 9px;'><strong></strong></p>
              <p class='text-white' style='font-size: 9px;'><i class='fa fa-calendar'></i> 31 hari <br>Populasi : 1500 Ekor<br>BW : 120 gr</p>
              </div>
              </div>
              <div class='row'>
              </div>
              </div>
              </div>
              </div>
              </div>
              </a>
              </div>
              <div class='pt-3'></div>";
                        }
                    } else {
                        $output = array();
                        echo '<strong>Belum ada kandang aktif</strong>';
                    }
                    echo implode("", $output);
                    break;
                case 'rehat':
                    $kandangrehat = $this->MData->selectdatawhereresult('kandang', array('user_id' => $this->cookiex['user_id'], 'status_kandang' => 'rehat'));
                    if (is_array($kandangrehat)) {
                        foreach ($kandangrehat as $kandangrehats) {
                            $output[] = '
              <div class="container">
              <a href="' . base_url("ternak/ternak_detail/rehat/{$kandangrehats->id}") . '">
              <div class="card card-bg-img bg-img bg-overlay" style="background-image: url("' . base_url($kandangrehats->foto) . '")">
              <!-- <span class="badge bg-success">{periode_kandang}<br>{status}</span> -->
              <div class="card-body">
              <div class="h-50">
              <div class="slide-text">
              <div class="row">
              <div class="col-6">
              <p class="text-white" style="font-size: 9px;"><strong>' . $kandangrehats->nama . '</strong></p>
              <p class="text-white" style="font-size: 9px;">{status}<br>Tanggal Rehat : {date}</p>
              </div>
              <div class="col-6">
              <p class="text-white" style="font-size: 9px;"><strong></strong></p>
              <p class="text-white" style="font-size: 9px;">Periode Terakhir : {kode}<br>Populasi : {item.value}<br>IP : {ip}</p>
              </div>
              </div>
              <div class="row">
              <div class="col-6">
              <a class="btn btn-success btn-sm" href="' . base_url("ternak/ternak_input_aktif/{$kandangrehats->id}") . '" style="font-size: 12px;">Chickin</a>
              </div>
              <div class="col-6">
              <a class="btn btn-info btn-sm" href="' . base_url("ternak/ternak_detail/rehat/{$kandangrehats->id}") . '" style="font-size: 12px;">Detail</a>
              </div>
              </div>
              </div>
              </div>
              </div>
              </div>
              </a>
              </div>
              <div class="pt-3"></div>';
                        }
                    } else {
                        $output = array();
                        echo "<strong>Belum ada kandang rehat</strong>";
                    }
                    echo implode("", $output);
                    break;
                default:
                    redirect('error404', 'refresh');
                    break;
            }
        }
    }

    public function konsumsi_obat_all($id_user = NULL)
    {
        if ($id_user = NULL) {
            echo json_encode(array('status' => false, 'message' => 'Wrong Command'));
        } else {

            $getdatakonsumsiobat = $this->MData->customresult("SELECT
          a.*,
          sum(a.qty) as tot_qty,
          b.*
          FROM `kandang_activity_log_sapronak` as a
          LEFT JOIN obat as b on b.id = a.id_this
          where a.id_kandang in (SELECT id from kandang WHERE user_id = '{$id_user}') and type_sapronak = 'ovk' and method_sapronak = 'use' GROUP by a.id_this");

            echo json_encode($getdatakonsumsiobat);
        }
    }
    public function konsumsi_obat_kadang_aktif($id_user = NULL)
    {
        if ($id_user = NULL) {
            echo json_encode(array('status' => false, 'message' => 'Wrong Command'));
        } else {

            $getdatakonsumsiobat = $this->MData->customresult("SELECT
            d.nama,
            a.*,
            sum(a.qty) as tot_qty,
            b.*
            FROM `kandang_activity_log_sapronak` as a
            LEFT JOIN obat as b on b.id = a.id_this
            INNER JOIN (SELECT id_kandang,periode FROM `kandang_activity` WHERE id_kandang in (SELECT id from kandang where user_id = '{$id_user}') and status_kandang_activity = 'AKTIF') as c on a.id_kandang = c.id_kandang and a.periode = c.periode
            LEFT JOIN kandang as d on d.id = a.id_kandang
            where a.id_kandang in (SELECT id from kandang WHERE user_id = '{$id_user}') and type_sapronak = 'ovk' and method_sapronak = 'use' GROUP by a.id_this,a.periode,a.id_kandang
            ORDER BY `d`.`nama` ASC");

            echo json_encode($getdatakonsumsiobat);
        }
    }
    public function stock_obat($id_user = NULL)
    {
        if ($id_user = NULL) {
            echo json_encode(array('status' => false, 'message' => 'Wrong Command'));
        } else {
            $stock_in = "IFNULL((SELECT SUM(qty) AS tot_qty FROM `kandang_activity_stock` WHERE method_stock = 'in' and type_stock = 'ovk' AND id_user = '{$id_user}' AND id_this = a.id_this),0)";
            $stock_out = "IFNULL((SELECT SUM(qty) AS tot_qty FROM `kandang_activity_stock` WHERE method_stock = 'out' and type_stock = 'ovk' AND id_user = '{$id_user}' AND id_this = a.id_this),0)";
            $getdatastockobat = $this->MData->customresult("SELECT
              IFNULL(SUM(a.qty),0) AS tot_qty_use,
              {$stock_in} AS tot_qty_in,
              {$stock_out} AS tot_qty_out,
              {$stock_in} - {$stock_out} - IFNULL(SUM(a.qty),0) AS stock,
              IFNULL(({$stock_in} - {$stock_out} - IFNULL(SUM(a.qty),0)) / b.quantity,0) as stock_qty,
              b.brand,
              b.satuan,
              b.quantity
              FROM
              obat AS b
              LEFT JOIN `kandang_activity_log_sapronak` AS a  ON b.id = a.id_this AND a.id_kandang IN (SELECT id FROM kandang WHERE user_id = '{$id_user}') AND type_sapronak = 'ovk' AND method_sapronak = 'use'
              GROUP BY
              b.id
              ORDER BY `b`.`brand` ASC");

            echo json_encode($getdatastockobat);
        }
    }

    public function bw()
    {
        if ($this->input->post()) {
            if ($this->input->post('idkandang') && $this->input->post('periode')) {
                $idkandang = $this->input->post('idkandang');
                $periode = $this->input->post('periode');
                $getactivitydetail = $this->MData->customrow("SELECT * FROM kandang_activity where id_kandang = '{$idkandang}' AND periode ='{$periode}'  ORDER BY created_at DESC");
                $getactivitydetail_join = $this->MData->customrow("SELECT * FROM kandang_activity LEFT JOIN kandang ON kandang.id = kandang_activity.id_kandang where id_kandang = '{$idkandang}' AND periode ='{$periode}'  ORDER BY kandang_activity.created_at DESC");
                if ($getactivitydetail_join->status_kandang_activity != 'AKTIF' || $getactivitydetail_join->status_kandang != "AKTIF") {
                    $panen_ekor = "(SELECT sum(qty_ekor) as panen_ekor from kandang_activity_log_panen where periode = b.periode and id_kandang = b.id_kandang)";
                    $panen_kg = "(SELECT round(sum(tot_kg) - sum(beratkeranjang) - sum(susut),3) as kg from (SELECT aaa.susut, aaa.beratkeranjang, sum(aaa.qty_kg) as tot_kg  FROM `kandang_activity_log_panen` as aaa where aaa.id_kandang = '{$idkandang}' and aaa.periode = '{$periode}' GROUP by aaa.nomorDO) as tot)";
                    $umur_rata_panen = "(SELECT round(sum(DATEDIFF(bb.tanggal, (SELECT tanggal_chickin from kandang_activity_log WHERE periode = bb.periode and id_kandang = bb.id_kandang order by id DESC limit 1 ))*qty_ekor)/sum(qty_ekor),0) as umur_rata_panen  FROM `kandang_activity_log_panen` as bb where bb.periode = b.periode and bb.id_kandang = b.id_kandang)";
                    $querydresumerehat = "SELECT
                                  IFNULL(round({$panen_kg}/{$panen_ekor}*1000,0),0) as bw,
                                  {$umur_rata_panen} as umur_rata_panen
                                  FROM kandang as a
                                  LEFT JOIN kandang_activity as b ON a.id = b.id_kandang
                                  where a.id ='{$idkandang}' AND b.periode = '{$periode}'";

                    $dataresume = $this->MData->customrow($querydresumerehat);
                    $bwratapanen = $dataresume->bw;
                    $umurratapanen = $dataresume->umur_rata_panen;
                    $status_kandang_activity = "rehat";
                } else {
                    $bwratapanen = NULL;
                    $umurratapanen = NULL;
                    $status_kandang_activity = "aktif";
                }
                $panen_kg = "IFNULL((SELECT round(sum(tot_kg) - sum(beratkeranjang) - sum(susut),3) as kg from (SELECT aaa.susut, aaa.beratkeranjang, sum(aaa.qty_kg) as tot_kg, tanggal  FROM `kandang_activity_log_panen` as aaa where aaa.id_kandang = {$idkandang} and aaa.periode = '{$periode}'  GROUP by aaa.nomorDO) as tot where tot.tanggal <= a.tanggal),0)";
                $panen_ekor = "IFNULL((SELECT sum(qty_ekor) FROM `kandang_activity_log_panen` WHERE id_kandang = a.id_kandang and periode = a.periode and tanggal <= a.tanggal),0)";
                $populasi = "((SELECT populasi_awal from kandang_activity WHERE id_kandang = a.id_kandang and periode = a.periode) - IFNULL((SELECT sum(total_mati) FROM `kandang_activity_log` WHERE id_kandang = a.id_kandang and periode = a.periode and tanggal <= a.tanggal),0) - {$panen_ekor})";
                $tot_feed = "((SELECT sum(qty) from kandang_activity_log_sapronak WHERE id_kandang = a.id_kandang and periode = a.periode and type_sapronak = 'pakan' and method_sapronak = 'use' and tanggal_kandang_activity_log = a.tanggal))";
                $tot_feed_fcr = "((SELECT sum(qty) from kandang_activity_log_sapronak WHERE id_kandang = a.id_kandang and periode = a.periode and type_sapronak = 'pakan' and method_sapronak = 'use' and tanggal_kandang_activity_log <= a.tanggal))";
                $std_bw_0_harian = "(SELECT bw FROM `std_bw` where strain = '{$getactivitydetail->strain}' AND day = 0)";
                $act_bw_0_harian = "(SELECT bw FROM `kandang_activity_log` where id_kandang = '{$idkandang}' AND periode = '{$periode}' AND tanggal = tanggal_chickin)";
                $querybw = "SELECT
                  a.id,
                  DATEDIFF(a.tanggal, a.tanggal_chickin) as umur,
                  a.tanggal,
                  a.bw,
                  a.mati,
                  a.culling,
                  a.water,
                  a.total_mati,
                  d.populasi_awal,
                  ({$populasi}) as populasi,
                  ({$tot_feed}) as qty_feed,
                  IFNULL(round({$tot_feed_fcr} * 50000 / ({$populasi} + {$panen_ekor}) / a.bw,3), 0) as act_fcr_lama,
                  IFNULL(round({$tot_feed_fcr} * 50000 / (({$populasi} * a.bw) + ({$panen_kg} * 1000)),3), 0) as act_fcr,
                  IFNULL(round(b.fcr,3), 0) as std_fcr,
                  IFNULL(round({$tot_feed} * 50000 / {$populasi},3), 0) as act_feed_intake,
                  IF({$act_bw_0_harian}<{$std_bw_0_harian}, round(({$act_bw_0_harian} / {$std_bw_0_harian} * IFNULL(round(c.feedintake,3), 0)),3), IFNULL(round(c.feedintake,3), 0))  as std_feed_intake,
                  IFNULL(round(a.bw / DATEDIFF(a.tanggal, a.tanggal_chickin)), 0) as act_adg,
                  IF(a.total_mati >= round(d.populasi_awal * 0.003 ,0),a.mati,NULL) as ews_mati,
                  IFNULL(round(a.total_mati / d.populasi_awal * 100 ,2),0) as persen_deplesi,
                  IF({$act_bw_0_harian}<{$std_bw_0_harian}, round(({$act_bw_0_harian} / {$std_bw_0_harian} * c.bw),0), c.bw) as std_bw,
                  IFNULL(round(IF({$act_bw_0_harian}<{$std_bw_0_harian}, round(({$act_bw_0_harian} / {$std_bw_0_harian} * c.bw),0), c.bw)/DATEDIFF(a.tanggal, a.tanggal_chickin),2), 0) as std_adg,
                  IFNULL((SELECT ket from kandang_activity_log_ews where type_ews = 'mati' and id_kandang = a.id_kandang and periode = a.periode and tanggal = a.tanggal ORDER by id desc limit 1),NULL) as ket_ews_mati,
                  IFNULL((SELECT ket from kandang_activity_log_ews where type_ews = 'bw' and id_kandang = a.id_kandang and periode = a.periode and tanggal = a.tanggal ORDER by id desc limit 1),NULL) as ket_ews_bw,
                  IFNULL((SELECT id from kandang_activity_log_ews where type_ews = 'mati' and id_kandang = a.id_kandang and periode = a.periode and tanggal = a.tanggal ORDER by id desc limit 1),NULL) as id_ews_mati,
                  IFNULL((SELECT id from kandang_activity_log_ews where type_ews = 'bw' and id_kandang = a.id_kandang and periode = a.periode and tanggal = a.tanggal ORDER by id desc limit 1),NULL) as id_ews_bw
                  FROM `kandang_activity_log` as a
                  LEFT JOIN (SELECT * from std where strain = '{$getactivitydetail->strain}') as b on b.bw = a.bw
                  LEFT JOIN (SELECT * from std_bw WHERE strain = '{$getactivitydetail->strain}') as c on c.day = DATEDIFF(a.tanggal, a.tanggal_chickin)
                  LEFT JOIN kandang_activity as d on d.periode = a.periode and d.id_kandang = a.id_kandang
                  WHERE a.id_kandang = '{$idkandang}' AND a.periode = '{$periode}' ORDER BY a.tanggal ASC";
                $getdataharian = $this->MData->customresult($querybw);

                $data_chart = array();
                if (is_array($getdataharian) || is_object($getdataharian)) {
                    $std = 0;
                    $data_harian_bw = $getdataharian;
                    function cmp($a, $b)
                    {
                        return strcmp($a->tanggal, $b->tanggal);
                    }
                    usort($data_harian_bw, "cmp");
                    foreach ($data_harian_bw as $data_harian_bws) {
                        foreach ($data_harian_bw as $v) {
                            $map[$v->umur] = abs($data_harian_bws->bw - $v->std_bw);
                        }

                        $msg = array_search(min($map), $map);
                        if ($data_harian_bws->umur >= 7 && $data_harian_bws->umur <= 35) {
                            if ($data_harian_bws->umur - $msg > $std && $data_harian_bws->bw < $data_harian_bws->std_bw && $data_harian_bws->umur - $msg != 0) {
                                $ket = $data_harian_bws->bw;
                                $value_ews_bw = $data_harian_bws->umur - $msg;
                            } else {
                                $ket = NULL;
                                $value_ews_bw = "-";
                            }
                            $std = $data_harian_bws->umur - $msg;
                        } else {
                            $ket = NULL;
                            $value_ews_bw = "-";
                        }

                        if ($data_harian_bws->umur == $umurratapanen) {
                            $databwpanen = $bwratapanen;
                            $dataumurpanen = $umurratapanen;
                        } else {
                            $databwpanen = NULL;
                            $dataumurpanen = NULL;
                        }

                        $data_chart[] = array(

                            'umur' => $data_harian_bws->umur,
                            'bw' => $data_harian_bws->bw,
                            'std_bw' => $data_harian_bws->std_bw,
                            'act_fcr' => $data_harian_bws->act_fcr,
                            'std_fcr' => $data_harian_bws->std_fcr,
                            'act_feed_intake' => $data_harian_bws->act_feed_intake,
                            'std_feed_intake' => $data_harian_bws->std_feed_intake,
                            'act_adg' => $data_harian_bws->act_adg,
                            'std_adg' => $data_harian_bws->std_adg,
                            'populasi' => $data_harian_bws->populasi,
                            'mati' => $data_harian_bws->mati,
                            'culling' => $data_harian_bws->culling,
                            'tanggal' => $data_harian_bws->tanggal,
                            'ews_bw' => $ket,
                            'ews_bw_value' => $value_ews_bw,
                            'ews_mati' => $data_harian_bws->ews_mati,
                            'total_mati' => $data_harian_bws->total_mati,
                            'persen_deplesi' => $data_harian_bws->persen_deplesi,
                            'ket_ews_bw' => $data_harian_bws->ket_ews_bw,
                            'ket_ews_mati' => $data_harian_bws->ket_ews_mati,
                            'id_ews_bw' => $data_harian_bws->id_ews_bw,
                            'id_ews_mati' => $data_harian_bws->id_ews_mati,
                            'bw_panen' => $databwpanen,
                            'umur_rata_panen' => $dataumurpanen,
                            'status_kandang_activity' => $status_kandang_activity,

                        );
                    }
                }
                echo json_encode($data_chart);
            } else {
                echo json_encode(array('status' => false, 'message' => 'Wrong Command'));
            }
        } else {
            echo json_encode(array('status' => false, 'message' => 'Wrong Command'));
        }
    }
    public function bw3()
    {
        if ($this->input->post()) {
            if ($this->input->post('idkandang') && $this->input->post('periode')) {
                $idkandang = $this->input->post('idkandang');
                $periode = $this->input->post('periode');
                $getactivitydetail = $this->MData->customrow("SELECT * FROM kandang_activity where id_kandang = '{$idkandang}' AND periode ='{$periode}'  ORDER BY created_at DESC");
                $getactivitydetail_join = $this->MData->customrow("SELECT * FROM kandang_activity LEFT JOIN kandang ON kandang.id = kandang_activity.id_kandang where id_kandang = '{$idkandang}' AND periode ='{$periode}'  ORDER BY kandang_activity.created_at DESC");
                if ($getactivitydetail_join->status_kandang_activity != 'AKTIF' || $getactivitydetail_join->status_kandang != "AKTIF") {
                    $panen_ekor = "(SELECT sum(qty_ekor) as panen_ekor from kandang_activity_log_panen where periode = b.periode and id_kandang = b.id_kandang)";
                    $panen_kg = "(SELECT round(sum(tot_kg) - sum(beratkeranjang) - sum(susut),3) as kg from (SELECT aaa.susut, aaa.beratkeranjang, sum(aaa.qty_kg) as tot_kg  FROM `kandang_activity_log_panen` as aaa where aaa.id_kandang = '{$idkandang}' and aaa.periode = '{$periode}' GROUP by aaa.nomorDO) as tot)";
                    $umur_rata_panen = "(SELECT round(sum(DATEDIFF(bb.tanggal, (SELECT tanggal_chickin from kandang_activity_log WHERE periode = bb.periode and id_kandang = bb.id_kandang order by id DESC limit 1 ))*qty_ekor)/sum(qty_ekor),0) as umur_rata_panen  FROM `kandang_activity_log_panen` as bb where bb.periode = b.periode and bb.id_kandang = b.id_kandang)";
                    $querydresumerehat = "SELECT
                                  IFNULL(round({$panen_kg}/{$panen_ekor}*1000,0),0) as bw,
                                  {$umur_rata_panen} as umur_rata_panen
                                  FROM kandang as a
                                  LEFT JOIN kandang_activity as b ON a.id = b.id_kandang
                                  where a.id ='{$idkandang}' AND b.periode = '{$periode}'";

                    $dataresume = $this->MData->customrow($querydresumerehat);
                    $bwratapanen = $dataresume->bw;
                    $umurratapanen = $dataresume->umur_rata_panen;
                    $status_kandang_activity = "rehat";
                } else {
                    $bwratapanen = NULL;
                    $umurratapanen = NULL;
                    $status_kandang_activity = "aktif";
                }
                $panen_kg = "IFNULL((SELECT round(sum(tot_kg) - sum(beratkeranjang) - sum(susut),3) as kg from (SELECT aaa.susut, aaa.beratkeranjang, sum(aaa.qty_kg) as tot_kg, tanggal  FROM `kandang_activity_log_panen` as aaa where aaa.id_kandang = {$idkandang} and aaa.periode = '{$periode}'  GROUP by aaa.nomorDO) as tot where tot.tanggal = a.tanggal),0)";
                $panen_ekor = "IFNULL((SELECT sum(qty_ekor) FROM `kandang_activity_log_panen` WHERE id_kandang = a.id_kandang and periode = a.periode and tanggal = a.tanggal),0)";
                // $populasi = "(d.populasi_awal - IFNULL((SELECT sum(total_mati) FROM `kandang_activity_log` WHERE id_kandang = a.id_kandang and periode = a.periode and tanggal <= a.tanggal),0) - {$panen_ekor})";
                $tot_feed = "((SELECT sum(qty) from kandang_activity_log_sapronak WHERE id_kandang = a.id_kandang and periode = a.periode and type_sapronak = 'pakan' and method_sapronak = 'use' and tanggal_kandang_activity_log = a.tanggal))";
                // $tot_feed_fcr = "((SELECT sum(qty) from kandang_activity_log_sapronak WHERE id_kandang = a.id_kandang and periode = a.periode and type_sapronak = 'pakan' and method_sapronak = 'use' and tanggal_kandang_activity_log <= a.tanggal))";
                $std_bw_0_harian = "(SELECT bw FROM `std_bw` where strain = '{$getactivitydetail_join->strain}' AND day = 0)";
                $act_bw_0_harian = "(SELECT bw FROM `kandang_activity_log` where id_kandang = '{$idkandang}' AND periode = '{$periode}' AND tanggal = tanggal_chickin)";

                // IFNULL(round({$tot_feed_fcr} * 50000 / (({$populasi} * a.bw) + ({$panen_kg} * 1000)),3), 0) as act_fcr,
                $queryraw = "SELECT
                  a.id,
                  DATEDIFF(a.tanggal, a.tanggal_chickin) as umur,
                  a.tanggal,
                  a.bw,
                  a.mati,
                  a.culling,
                  a.water,
                  a.total_mati,
                  d.populasi_awal,
                  
                  ({$tot_feed}) as qty_feed,
                  ({$panen_kg}) as panen_kg,
                  ({$panen_ekor}) as panen_ekor,
                  IFNULL(round(b.fcr,3), 0) as std_fcr,
                  IFNULL(round(c.feedintake,3), 0) as std_feed_intake,
                  IFNULL(round(a.bw / DATEDIFF(a.tanggal, a.tanggal_chickin)), 0) as act_adg,
                  IF(a.total_mati >= round(d.populasi_awal * 0.003 ,0),a.mati,NULL) as ews_mati,
                  IFNULL(round(a.total_mati / d.populasi_awal * 100 ,2),0) as persen_deplesi,
                  IF({$act_bw_0_harian}<{$std_bw_0_harian}, round(({$act_bw_0_harian} / {$std_bw_0_harian} * c.bw),0), c.bw) as std_bw,
                  IFNULL((SELECT ket from kandang_activity_log_ews where type_ews = 'mati' and id_kandang = a.id_kandang and periode = a.periode and tanggal = a.tanggal ORDER by id desc limit 1),NULL) as ket_ews_mati,
                  IFNULL((SELECT ket from kandang_activity_log_ews where type_ews = 'bw' and id_kandang = a.id_kandang and periode = a.periode and tanggal = a.tanggal ORDER by id desc limit 1),NULL) as ket_ews_bw,
                  IFNULL((SELECT id from kandang_activity_log_ews where type_ews = 'mati' and id_kandang = a.id_kandang and periode = a.periode and tanggal = a.tanggal ORDER by id desc limit 1),NULL) as id_ews_mati,
                  IFNULL((SELECT id from kandang_activity_log_ews where type_ews = 'bw' and id_kandang = a.id_kandang and periode = a.periode and tanggal = a.tanggal ORDER by id desc limit 1),NULL) as id_ews_bw
                  FROM `kandang_activity_log` as a
                  LEFT JOIN (SELECT * from std where strain = '{$getactivitydetail_join->strain}') as b on b.bw = a.bw
                  LEFT JOIN (SELECT * from std_bw WHERE strain = '{$getactivitydetail_join->strain}') as c on c.day = DATEDIFF(a.tanggal, a.tanggal_chickin)
                  LEFT JOIN kandang_activity as d on d.periode = a.periode and d.id_kandang = a.id_kandang
                  WHERE a.id_kandang = '{$idkandang}' AND a.periode = '{$periode}' ORDER BY a.tanggal ASC";

                $getdataharian = $this->MData->customresult($queryraw);
                $getdatastd = $this->MData->customresult("SELECT * from std_bw WHERE strain = '{$getactivitydetail_join->strain}'");
                $getdatamax_umur = $this->MData->customrow("SELECT DATEDIFF(MAX(tanggal), tanggal_chickin) as max_umur FROM `kandang_activity_log`  where id_kandang = '{$idkandang}' and periode = '{$periode}'");

                if (is_array($getdataharian) || is_object($getdataharian)) {
                    $total_mati = 0;
                    $panen_ekor = 0;
                    $panen_kg = 0;
                    $tot_pakan = 0;
                    // IFNULL(round((({$act_fcr} / {$std_fcr}) - 1) * 100,2),0)
                    // IFNULL(round({$tot_feed_fcr} * 50000 / (({$populasi} * a.bw) + ({$panen_kg} * 1000)),3), 0) as act_fcr,
                    foreach ($getdataharian as $getdataharians) {
                        $total_mati = $total_mati + $getdataharians->total_mati;
                        $panen_ekor = $panen_ekor + $getdataharians->panen_ekor;
                        $panen_kg = $panen_kg + $getdataharians->panen_kg;
                        $tot_pakan = $tot_pakan + $getdataharians->qty_feed;

                        $populasi = $getdataharians->populasi_awal - $total_mati - $panen_ekor;
                        $act_feed_intake = $populasi != 0 ? round($getdataharians->qty_feed * 50000 / $populasi, 3) : 0;
                        $bagi_fcr = (($populasi * $getdataharians->bw) + ($panen_kg * 1000));
                        $act_fcr = $bagi_fcr != 0 ? round($tot_pakan * 50000 / $bagi_fcr, 3) : 0;
                        $diff_fcr = $getdataharians->std_fcr != 0 ? round((($act_fcr / $getdataharians->std_fcr) - 1) * 100, 2) : 0;


                        $getdataharians->populasi = $populasi;
                        $getdataharians->act_feed_intake = $act_feed_intake;
                        $getdataharians->act_fcr = $act_fcr;
                        $getdataharians->diff_fcr = $diff_fcr;
                    }
                }
                $data_chart_1 = array();
                $status_bw = 'normal';
                $umur  = NULL;
                $tanggal  = NULL;
                foreach ($getdatastd as $getdatastds) {
                    if (is_array($getdataharian) || is_object($getdataharian)) {

                        $bw  = NULL;
                        $std_fcr  = NULL;
                        $act_adg  = NULL;
                        $mati  = NULL;
                        $culling  = NULL;
                        $ews_mati  = NULL;
                        $total_mati  = NULL;
                        $persen_deplesi  = NULL;
                        $ket_ews_bw  = NULL;
                        $ket_ews_mati  = NULL;
                        $id_ews_bw  = NULL;
                        $id_ews_mati  = NULL;
                        $populasi = NULL;
                        $act_feed_intake = NULL;
                        $act_fcr = NULL;
                        $diff_fcr = NULL;
                        foreach ($getdataharian as $getdataharians) {
                            if ($getdatastds->day == $getdataharians->umur) {
                                $umur  = $getdataharians->umur;
                                $tanggal  = $getdataharians->tanggal;
                                $bw  = $getdataharians->bw;
                                $std_fcr  = $getdataharians->std_fcr;
                                $act_adg  = $getdataharians->act_adg;
                                $mati  = $getdataharians->mati;
                                $culling  = $getdataharians->culling;
                                $ews_mati  = $getdataharians->ews_mati;
                                $total_mati  = $getdataharians->total_mati;
                                $persen_deplesi  = $getdataharians->persen_deplesi;
                                $ket_ews_bw  = $getdataharians->ket_ews_bw;
                                $ket_ews_mati  = $getdataharians->ket_ews_mati;
                                $id_ews_bw  = $getdataharians->id_ews_bw;
                                $id_ews_mati  = $getdataharians->id_ews_mati;
                                $populasi = $getdataharians->populasi;
                                $act_feed_intake = $getdataharians->act_feed_intake;
                                $act_fcr = $getdataharians->act_fcr;
                                $diff_fcr = $getdataharians->diff_fcr;
                            }
                        }

                        if ($getdatastds->day == 0) {
                            $rasio_adjust_bw = $bw / $getdatastds->bw;
                            if ($bw >= $getdatastds->bw) {
                                $status_bw = 'normal';
                            } else {
                                $status_bw = 'adjust';
                            }
                        }

                        if ($getactivitydetail_join->is_mitra == "1") {
                            $std_bw = $getdatastds->bw;
                            $umur == 0 ? $std_adg = 0 : $std_adg = round($std_bw / $umur, 2);
                            // $std_adg = round($std_bw / $umur, 2);
                            $std_feed_intake = $getdatastds->feedintake;
                        } else {
                            if ($status_bw == 'normal') {
                                $std_bw = $getdatastds->bw;
                                $umur == 0 ? $std_adg = 0 : $std_adg = round($std_bw / $umur, 2);
                                // $std_adg = round($std_bw / $umur, 2);
                                $std_feed_intake = $getdatastds->feedintake;
                            } else {
                                $std_bw = round($rasio_adjust_bw * $getdatastds->bw, 0);
                                $umur == 0 ? $std_adg = 0 : $std_adg = round($std_bw / $umur, 2);
                                $std_feed_intake = round($rasio_adjust_bw * $getdatastds->feedintake, 3);
                            }
                        }
                        $data_chart_1[] = (object) array(
                            'std_day'           => $getdatastds->day,
                            'std_bw'            => $std_bw,
                            'std_feed_intake'   => $std_feed_intake,
                            'umur'              => $umur,
                            'tanggal'           => $tanggal,
                            'bw'                => $bw,
                            'std_fcr'           => $std_fcr,
                            'act_adg'           => $act_adg,
                            'std_adg'           => $std_adg,
                            'mati'              => $mati,
                            'culling'           => $culling,
                            'ews_mati'          => $ews_mati,
                            'total_mati'        => $total_mati,
                            'persen_deplesi'    => $persen_deplesi,
                            'ket_ews_bw'        => $ket_ews_bw,
                            'ket_ews_mati'      => $ket_ews_mati,
                            'id_ews_bw'         => $id_ews_bw,
                            'id_ews_mati'       => $id_ews_mati,
                            'populasi'          => $populasi,
                            'act_feed_intake'   => $act_feed_intake,
                            'act_fcr'           => $act_fcr,
                            'diff_fcr'           => $diff_fcr,
                        );
                        $date = $tanggal;
                        $date1 = str_replace('-', '/', $date);

                        // $umur  = NULL;
                        $tanggal  = date('Y-m-d', strtotime($date1 . "+1 days"));
                        $bw  = NULL;
                        $std_fcr  = NULL;
                        $act_adg  = NULL;
                        $mati  = NULL;
                        $culling  = NULL;
                        $total_mati  = NULL;
                        $persen_deplesi  = NULL;
                        $ket_ews_bw  = NULL;
                        $ket_ews_mati  = NULL;
                        $id_ews_bw  = NULL;
                        $id_ews_mati  = NULL;
                        $populasi = NULL;
                        $act_feed_intake = NULL;
                        $act_fcr = NULL;
                        $diff_fcr = NULL;
                    } else {
                        echo json_encode([
                            'status' => false,
                            'icon' => 'error',
                            'message' => 'Data Kosong'
                        ]);
                        exit;
                    }
                }
                // var_dump($data_chart_1);
                // var_dump($getdataharian);
                // exit;
                $data_chart = array();
                if (is_array($getdataharian) || is_object($getdataharian)) {
                    $std = 0;
                    // $data_harian_bw = $getdataharian;
                    $data_harian_bw = $data_chart_1;
                    function cmp($a, $b)
                    {
                        return strcmp($a->tanggal, $b->tanggal);
                    }
                    usort($data_harian_bw, "cmp");
                    foreach ($data_harian_bw as $data_harian_bws) {
                        foreach ($data_harian_bw as $v) {
                            $map[$v->std_day] = abs($data_harian_bws->bw - $v->std_bw);
                        }

                        $msg = array_search(min($map), $map);
                        if ($data_harian_bws->std_day <= $data_harian_bws->umur) {
                            if ($data_harian_bws->umur >= 7 && $data_harian_bws->umur <= 35) {
                                if ($data_harian_bws->umur - $msg > $std && $data_harian_bws->bw < $data_harian_bws->std_bw && $data_harian_bws->umur - $msg != 0) {
                                    $ket = $data_harian_bws->bw;
                                    $value_ews_bw = $data_harian_bws->umur - $msg;
                                } else {
                                    $ket = NULL;
                                    $value_ews_bw = "-";
                                }
                                $std = $data_harian_bws->umur - $msg;
                            } else {
                                $ket = NULL;
                                $value_ews_bw = "-";
                            }
                        } else {
                            $ket = NULL;
                            $value_ews_bw = "-";
                        }

                        if ($data_harian_bws->std_day == $umurratapanen) {
                            $databwpanen = $bwratapanen;
                            $dataumurpanen = $umurratapanen;
                        } else {
                            $databwpanen = NULL;
                            $dataumurpanen = NULL;
                        }

                        $data_chart[] = array(


                            'umur' => $data_harian_bws->std_day,
                            'max_umur' => $getdatamax_umur->max_umur,
                            'msg' => $msg,
                            'act_umur' => $data_harian_bws->umur,
                            'tanggal' => $data_harian_bws->tanggal,
                            'bw' => $data_harian_bws->bw,
                            'std_bw' => $data_harian_bws->std_bw,
                            'act_fcr' => $data_harian_bws->act_fcr,
                            'diff_fcr' => $data_harian_bws->diff_fcr,
                            'std_fcr' => $data_harian_bws->std_fcr,
                            'act_feed_intake' => $data_harian_bws->act_feed_intake,
                            'std_feed_intake' => $data_harian_bws->std_feed_intake,
                            'act_adg' => $data_harian_bws->act_adg,
                            'std_adg' => $data_harian_bws->std_adg,
                            'populasi' => $data_harian_bws->populasi,
                            'mati' => $data_harian_bws->mati,
                            'culling' => $data_harian_bws->culling,
                            'tanggal' => $data_harian_bws->tanggal,
                            'ews_bw' => $ket,
                            'ews_bw_value' => $value_ews_bw,
                            'ews_mati' => $data_harian_bws->ews_mati,
                            'total_mati' => $data_harian_bws->total_mati,
                            'persen_deplesi' => $data_harian_bws->persen_deplesi,
                            'ket_ews_bw' => $data_harian_bws->ket_ews_bw,
                            'ket_ews_mati' => $data_harian_bws->ket_ews_mati,
                            'id_ews_bw' => $data_harian_bws->id_ews_bw,
                            'id_ews_mati' => $data_harian_bws->id_ews_mati,
                            'bw_panen' => $databwpanen,
                            'umur_rata_panen' => $dataumurpanen,
                            'status_kandang_activity' => $status_kandang_activity,

                        );
                    }
                }
                // usort($data_chart_1, function ($first, $second) {
                //     return strtolower($first->umur) < strtolower($second->umur);
                // });
                echo json_encode($data_chart);
            } else {
                echo json_encode(array('status' => false, 'message' => 'Wrong Command'));
            }
        } else {
            echo json_encode(array('status' => false, 'message' => 'Wrong Command'));
        }
    }

    public function bw2()
    {
        if ($this->input->post()) {
            if ($this->input->post('idkandang') && $this->input->post('periode')) {
                $idkandang = $this->input->post('idkandang');
                $periode = $this->input->post('periode');
                $getactivitydetail = $this->MData->customrow("SELECT * FROM kandang_activity where id_kandang = '{$idkandang}' AND periode ='{$periode}'  ORDER BY created_at DESC");
                $getactivitydetail_join = $this->MData->customrow("SELECT * FROM kandang_activity LEFT JOIN kandang ON kandang.id = kandang_activity.id_kandang where id_kandang = '{$idkandang}' AND periode ='{$periode}'  ORDER BY kandang_activity.created_at DESC");
                if ($getactivitydetail_join->status_kandang_activity != 'AKTIF' || $getactivitydetail_join->status_kandang != "AKTIF") {
                    $panen_ekor = "(SELECT sum(qty_ekor) as panen_ekor from kandang_activity_log_panen where periode = b.periode and id_kandang = b.id_kandang)";
                    $panen_kg = "(SELECT round(sum(tot_kg) - sum(beratkeranjang) - sum(susut),3) as kg from (SELECT aaa.susut, aaa.beratkeranjang, sum(aaa.qty_kg) as tot_kg  FROM `kandang_activity_log_panen` as aaa where aaa.id_kandang = '{$idkandang}' and aaa.periode = '{$periode}' GROUP by aaa.nomorDO) as tot)";
                    $umur_rata_panen = "(SELECT round(sum(DATEDIFF(bb.tanggal, (SELECT tanggal_chickin from kandang_activity_log WHERE periode = bb.periode and id_kandang = bb.id_kandang order by id DESC limit 1 ))*qty_ekor)/sum(qty_ekor),0) as umur_rata_panen  FROM `kandang_activity_log_panen` as bb where bb.periode = b.periode and bb.id_kandang = b.id_kandang)";
                    $querydresumerehat = "SELECT
                                  IFNULL(round({$panen_kg}/{$panen_ekor}*1000,0),0) as bw,
                                  {$umur_rata_panen} as umur_rata_panen
                                  FROM kandang as a
                                  LEFT JOIN kandang_activity as b ON a.id = b.id_kandang
                                  where a.id ='{$idkandang}' AND b.periode = '{$periode}'";

                    $dataresume = $this->MData->customrow($querydresumerehat);
                    $bwratapanen = $dataresume->bw;
                    $umurratapanen = $dataresume->umur_rata_panen;
                    $status_kandang_activity = "rehat";
                } else {
                    $bwratapanen = NULL;
                    $umurratapanen = NULL;
                    $status_kandang_activity = "aktif";
                }
                $panen_kg = "IFNULL((SELECT round(sum(tot_kg) - sum(beratkeranjang) - sum(susut),3) as kg from (SELECT aaa.susut, aaa.beratkeranjang, sum(aaa.qty_kg) as tot_kg, tanggal  FROM `kandang_activity_log_panen` as aaa where aaa.id_kandang = {$idkandang} and aaa.periode = '{$periode}'  GROUP by aaa.nomorDO) as tot where tot.tanggal = a.tanggal),0)";
                $panen_ekor = "IFNULL((SELECT sum(qty_ekor) FROM `kandang_activity_log_panen` WHERE id_kandang = a.id_kandang and periode = a.periode and tanggal = a.tanggal),0)";
                // $populasi = "(d.populasi_awal - IFNULL((SELECT sum(total_mati) FROM `kandang_activity_log` WHERE id_kandang = a.id_kandang and periode = a.periode and tanggal <= a.tanggal),0) - {$panen_ekor})";
                $tot_feed = "((SELECT sum(qty) from kandang_activity_log_sapronak WHERE id_kandang = a.id_kandang and periode = a.periode and type_sapronak = 'pakan' and method_sapronak = 'use' and tanggal_kandang_activity_log = a.tanggal))";
                // $tot_feed_fcr = "((SELECT sum(qty) from kandang_activity_log_sapronak WHERE id_kandang = a.id_kandang and periode = a.periode and type_sapronak = 'pakan' and method_sapronak = 'use' and tanggal_kandang_activity_log <= a.tanggal))";
                $std_bw_0_harian = "(SELECT bw FROM `std_bw` where strain = '{$getactivitydetail_join->strain}' AND day = 0)";
                $act_bw_0_harian = "(SELECT bw FROM `kandang_activity_log` where id_kandang = '{$idkandang}' AND periode = '{$periode}' AND tanggal = tanggal_chickin)";

                // IFNULL(round({$tot_feed_fcr} * 50000 / (({$populasi} * a.bw) + ({$panen_kg} * 1000)),3), 0) as act_fcr,
                $getdataharian = $this->MData->customresult("SELECT
                  a.id,
                  DATEDIFF(a.tanggal, a.tanggal_chickin) as umur,
                  a.tanggal,
                  a.bw,
                  a.mati,
                  a.culling,
                  a.water,
                  a.total_mati,
                  d.populasi_awal,
                  
                  ({$tot_feed}) as qty_feed,
                  ({$panen_kg}) as panen_kg,
                  ({$panen_ekor}) as panen_ekor,
                  IFNULL(round(b.fcr,3), 0) as std_fcr,
                  IFNULL(round(c.feedintake,3), 0) as std_feed_intake,
                  IFNULL(round(a.bw / DATEDIFF(a.tanggal, a.tanggal_chickin)), 0) as act_adg,
                  IF(a.total_mati >= round(d.populasi_awal * 0.003 ,0),a.mati,NULL) as ews_mati,
                  IFNULL(round(a.total_mati / d.populasi_awal * 100 ,2),0) as persen_deplesi,
                  IF({$act_bw_0_harian}<{$std_bw_0_harian}, round(({$act_bw_0_harian} / {$std_bw_0_harian} * c.bw),0), c.bw) as std_bw,
                  IFNULL((SELECT ket from kandang_activity_log_ews where type_ews = 'mati' and id_kandang = a.id_kandang and periode = a.periode and tanggal = a.tanggal ORDER by id desc limit 1),NULL) as ket_ews_mati,
                  IFNULL((SELECT ket from kandang_activity_log_ews where type_ews = 'bw' and id_kandang = a.id_kandang and periode = a.periode and tanggal = a.tanggal ORDER by id desc limit 1),NULL) as ket_ews_bw,
                  IFNULL((SELECT id from kandang_activity_log_ews where type_ews = 'mati' and id_kandang = a.id_kandang and periode = a.periode and tanggal = a.tanggal ORDER by id desc limit 1),NULL) as id_ews_mati,
                  IFNULL((SELECT id from kandang_activity_log_ews where type_ews = 'bw' and id_kandang = a.id_kandang and periode = a.periode and tanggal = a.tanggal ORDER by id desc limit 1),NULL) as id_ews_bw
                  FROM `kandang_activity_log` as a
                  LEFT JOIN (SELECT * from std where strain = '{$getactivitydetail_join->strain}') as b on b.bw = a.bw
                  LEFT JOIN (SELECT * from std_bw WHERE strain = '{$getactivitydetail_join->strain}') as c on c.day = DATEDIFF(a.tanggal, a.tanggal_chickin)
                  LEFT JOIN kandang_activity as d on d.periode = a.periode and d.id_kandang = a.id_kandang
                  WHERE a.id_kandang = '{$idkandang}' AND a.periode = '{$periode}' ORDER BY a.tanggal ASC");

                $getdatastd = $this->MData->customresult("SELECT * from std_bw WHERE strain = '{$getactivitydetail_join->strain}'");
                $getdatamax_umur = $this->MData->customrow("SELECT DATEDIFF(MAX(tanggal), tanggal_chickin) as max_umur FROM `kandang_activity_log`  where id_kandang = '{$idkandang}' and periode = '{$periode}'");

                if (is_array($getdataharian) || is_object($getdataharian)) {
                    $total_mati = 0;
                    $panen_ekor = 0;
                    $panen_kg = 0;
                    $tot_pakan = 0;
                    // IFNULL(round((({$act_fcr} / {$std_fcr}) - 1) * 100,2),0)
                    // IFNULL(round({$tot_feed_fcr} * 50000 / (({$populasi} * a.bw) + ({$panen_kg} * 1000)),3), 0) as act_fcr,
                    foreach ($getdataharian as $getdataharians) {
                        $total_mati = $total_mati + $getdataharians->total_mati;
                        $panen_ekor = $panen_ekor + $getdataharians->panen_ekor;
                        $panen_kg = $panen_kg + $getdataharians->panen_kg;
                        $tot_pakan = $tot_pakan + $getdataharians->qty_feed;

                        $populasi = $getdataharians->populasi_awal - $total_mati - $panen_ekor;
                        $act_feed_intake = $populasi != 0 ? round($getdataharians->qty_feed * 50000 / $populasi, 3) : 0;
                        $bagi_fcr = (($populasi * $getdataharians->bw) + ($panen_kg * 1000));
                        $act_fcr = $bagi_fcr != 0 ? round($tot_pakan * 50000 / $bagi_fcr, 3) : 0;
                        $diff_fcr = $getdataharians->std_fcr != 0 ? round((($act_fcr / $getdataharians->std_fcr) - 1) * 100, 2) : 0;


                        $getdataharians->populasi = $populasi;
                        $getdataharians->act_feed_intake = $act_feed_intake;
                        $getdataharians->act_fcr = $act_fcr;
                        $getdataharians->diff_fcr = $diff_fcr;
                    }
                }
                $data_chart_1 = array();
                $status_bw = 'normal';
                $umur  = NULL;
                $tanggal  = NULL;
                foreach ($getdatastd as $getdatastds) {
                    if (is_array($getdataharian) || is_object($getdataharian)) {

                        $bw  = NULL;
                        $std_fcr  = NULL;
                        $act_adg  = NULL;
                        $mati  = NULL;
                        $culling  = NULL;
                        $ews_mati  = NULL;
                        $total_mati  = NULL;
                        $persen_deplesi  = NULL;
                        $ket_ews_bw  = NULL;
                        $ket_ews_mati  = NULL;
                        $id_ews_bw  = NULL;
                        $id_ews_mati  = NULL;
                        $populasi = NULL;
                        $act_feed_intake = NULL;
                        $act_fcr = NULL;
                        $diff_fcr = NULL;
                        foreach ($getdataharian as $getdataharians) {
                            if ($getdatastds->day == $getdataharians->umur) {
                                $umur  = $getdataharians->umur;
                                $tanggal  = $getdataharians->tanggal;
                                $bw  = $getdataharians->bw;
                                $std_fcr  = $getdataharians->std_fcr;
                                $act_adg  = $getdataharians->act_adg;
                                $mati  = $getdataharians->mati;
                                $culling  = $getdataharians->culling;
                                $ews_mati  = $getdataharians->ews_mati;
                                $total_mati  = $getdataharians->total_mati;
                                $persen_deplesi  = $getdataharians->persen_deplesi;
                                $ket_ews_bw  = $getdataharians->ket_ews_bw;
                                $ket_ews_mati  = $getdataharians->ket_ews_mati;
                                $id_ews_bw  = $getdataharians->id_ews_bw;
                                $id_ews_mati  = $getdataharians->id_ews_mati;
                                $populasi = $getdataharians->populasi;
                                $act_feed_intake = $getdataharians->act_feed_intake;
                                $act_fcr = $getdataharians->act_fcr;
                                $diff_fcr = $getdataharians->diff_fcr;
                            }
                        }

                        if ($getdatastds->day == 0) {
                            $rasio_adjust_bw = $bw / $getdatastds->bw;
                            if ($bw >= $getdatastds->bw) {
                                $status_bw = 'normal';
                            } else {
                                $status_bw = 'adjust';
                            }
                        }

                        if ($getactivitydetail_join->is_mitra == "1") {
                            $std_bw = $getdatastds->bw;
                            $umur == 0 ? $std_adg = 0 : $std_adg = round($std_bw / $umur, 2);
                            // $std_adg = round($std_bw / $umur, 2);
                            $std_feed_intake = $getdatastds->feedintake;
                        } else {
                            if ($status_bw == 'normal') {
                                $std_bw = $getdatastds->bw;
                                $umur == 0 ? $std_adg = 0 : $std_adg = round($std_bw / $umur, 2);
                                // $std_adg = round($std_bw / $umur, 2);
                                $std_feed_intake = $getdatastds->feedintake;
                            } else {
                                $std_bw = round($rasio_adjust_bw * $getdatastds->bw, 0);
                                $umur == 0 ? $std_adg = 0 : $std_adg = round($std_bw / $umur, 2);
                                $std_feed_intake = round($rasio_adjust_bw * $getdatastds->feedintake, 3);
                            }
                        }
                        $data_chart_1[] = (object) array(
                            'std_day'           => $getdatastds->day,
                            'std_bw'            => $std_bw,
                            'std_feed_intake'   => $std_feed_intake,
                            'umur'              => $umur,
                            'tanggal'           => $tanggal,
                            'bw'                => $bw,
                            'std_fcr'           => $std_fcr,
                            'act_adg'           => $act_adg,
                            'std_adg'           => $std_adg,
                            'mati'              => $mati,
                            'culling'           => $culling,
                            'ews_mati'          => $ews_mati,
                            'total_mati'        => $total_mati,
                            'persen_deplesi'    => $persen_deplesi,
                            'ket_ews_bw'        => $ket_ews_bw,
                            'ket_ews_mati'      => $ket_ews_mati,
                            'id_ews_bw'         => $id_ews_bw,
                            'id_ews_mati'       => $id_ews_mati,
                            'populasi'          => $populasi,
                            'act_feed_intake'   => $act_feed_intake,
                            'act_fcr'           => $act_fcr,
                            'diff_fcr'           => $diff_fcr,
                        );
                        $date = $tanggal;
                        $date1 = str_replace('-', '/', $date);

                        // $umur  = NULL;
                        $tanggal  = date('Y-m-d', strtotime($date1 . "+1 days"));
                        $bw  = NULL;
                        $std_fcr  = NULL;
                        $act_adg  = NULL;
                        $mati  = NULL;
                        $culling  = NULL;
                        $total_mati  = NULL;
                        $persen_deplesi  = NULL;
                        $ket_ews_bw  = NULL;
                        $ket_ews_mati  = NULL;
                        $id_ews_bw  = NULL;
                        $id_ews_mati  = NULL;
                        $populasi = NULL;
                        $act_feed_intake = NULL;
                        $act_fcr = NULL;
                        $diff_fcr = NULL;
                    } else {
                        echo json_encode([
                            'status' => false,
                            'icon' => 'error',
                            'message' => 'Data Kosong'
                        ]);
                        exit;
                    }
                }
                // var_dump($data_chart_1);
                // var_dump($getdataharian);
                // exit;
                $data_chart = array();
                if (is_array($getdataharian) || is_object($getdataharian)) {
                    $std = 0;
                    // $data_harian_bw = $getdataharian;
                    $data_harian_bw = $data_chart_1;
                    function cmp($a, $b)
                    {
                        return strcmp($a->tanggal, $b->tanggal);
                    }
                    usort($data_harian_bw, "cmp");
                    foreach ($data_harian_bw as $data_harian_bws) {
                        foreach ($data_harian_bw as $v) {
                            $map[$v->std_day] = abs($data_harian_bws->bw - $v->std_bw);
                        }

                        $msg = array_search(min($map), $map);
                        if ($data_harian_bws->std_day <= $data_harian_bws->umur) {
                            if ($data_harian_bws->umur >= 7 && $data_harian_bws->umur <= 35) {
                                if ($data_harian_bws->umur - $msg > $std && $data_harian_bws->bw < $data_harian_bws->std_bw && $data_harian_bws->umur - $msg != 0) {
                                    $ket = $data_harian_bws->bw;
                                    $value_ews_bw = $data_harian_bws->umur - $msg;
                                } else {
                                    $ket = NULL;
                                    $value_ews_bw = "-";
                                }
                                $std = $data_harian_bws->umur - $msg;
                            } else {
                                $ket = NULL;
                                $value_ews_bw = "-";
                            }
                        } else {
                            $ket = NULL;
                            $value_ews_bw = "-";
                        }

                        if ($data_harian_bws->std_day == $umurratapanen) {
                            $databwpanen = $bwratapanen;
                            $dataumurpanen = $umurratapanen;
                        } else {
                            $databwpanen = NULL;
                            $dataumurpanen = NULL;
                        }

                        $data_chart[] = array(


                            'umur' => $data_harian_bws->std_day,
                            'max_umur' => $getdatamax_umur->max_umur,
                            'msg' => $msg,
                            'act_umur' => $data_harian_bws->umur,
                            'tanggal' => $data_harian_bws->tanggal,
                            'bw' => $data_harian_bws->bw,
                            'std_bw' => $data_harian_bws->std_bw,
                            'act_fcr' => $data_harian_bws->act_fcr,
                            'diff_fcr' => $data_harian_bws->diff_fcr,
                            'std_fcr' => $data_harian_bws->std_fcr,
                            'act_feed_intake' => $data_harian_bws->act_feed_intake,
                            'std_feed_intake' => $data_harian_bws->std_feed_intake,
                            'act_adg' => $data_harian_bws->act_adg,
                            'std_adg' => $data_harian_bws->std_adg,
                            'populasi' => $data_harian_bws->populasi,
                            'mati' => $data_harian_bws->mati,
                            'culling' => $data_harian_bws->culling,
                            'tanggal' => $data_harian_bws->tanggal,
                            'ews_bw' => $ket,
                            'ews_bw_value' => $value_ews_bw,
                            'ews_mati' => $data_harian_bws->ews_mati,
                            'total_mati' => $data_harian_bws->total_mati,
                            'persen_deplesi' => $data_harian_bws->persen_deplesi,
                            'ket_ews_bw' => $data_harian_bws->ket_ews_bw,
                            'ket_ews_mati' => $data_harian_bws->ket_ews_mati,
                            'id_ews_bw' => $data_harian_bws->id_ews_bw,
                            'id_ews_mati' => $data_harian_bws->id_ews_mati,
                            'bw_panen' => $databwpanen,
                            'umur_rata_panen' => $dataumurpanen,
                            'status_kandang_activity' => $status_kandang_activity,

                        );
                    }
                }
                // usort($data_chart_1, function ($first, $second) {
                //     return strtolower($first->umur) < strtolower($second->umur);
                // });
                echo json_encode($data_chart);
            } else {
                echo json_encode(array('status' => false, 'message' => 'Wrong Command'));
            }
        } else {
            echo json_encode(array('status' => false, 'message' => 'Wrong Command'));
        }
    }
    public function get_data()
    {
        if ($this->input->post()) {
            if ($this->input->post('responsenya') !== NULL) {
                $datanya = $this->input->post('responsenya');
                $this->MData->tambah('response', $this->input->post());
                // $datanya = '[{"Id":"3","IdKandang":"128|Test ya","Tanggal":"22/08/2022","Periode":"20220822144009","Pakan":"58|CP_510|11","Qty":"1","Pakan2":"40|DMC_BR0|120","Qty2":"1","Pakan3":"40|DMC_BR0|120","Qty3":"","Mati":"","Culling":"","Bw":"","Water":"","User_id":"153","Status":"F"}]';
                $dataarr1 = json_decode($datanya);
                $wrong = false;
                foreach ($dataarr1 as $dataarr) {
                    $gettanggalchikin = $this->MData->selectdatawhere('kandang_activity', ['id_kandang' => explode("|", $dataarr->IdKandang)['0'], 'periode' => $dataarr->Periode]);
                    if ($gettanggalchikin !== false) {
                        $getdateraw =  explode("/", $dataarr->Tanggal);
                        if ($dataarr->Bw == "" && $dataarr->Culling == "" && $dataarr->Mati == "" && $dataarr->Water == "") {
                            //
                        } else {
                            $datainputactivitylog = [
                                "id_kandang" => explode("|", $dataarr->IdKandang)['0'],
                                "periode" => $dataarr->Periode,
                                // "id_pakan" => explode("|",$dataarr->Pakan)['0'],
                                "tanggal" => $getdateraw[2] . "-" . $getdateraw[1] . "-" . $getdateraw[0],
                                "tanggal_chickin" => $gettanggalchikin->tanggal_mulai,
                                "bw" => $dataarr->Bw == "" ? 0 : $dataarr->Bw,
                                "culling" => $dataarr->Culling == "" ? 0 : $dataarr->Culling,
                                "mati" => $dataarr->Mati == "" ? 0 : $dataarr->Mati,
                                "total_mati" => $dataarr->Culling == "" ? 0 : ($dataarr->Culling + $dataarr->Mati == "" ? 0 : $dataarr->Mati),
                                "water" => $dataarr->Water == "" ? 0 : $dataarr->Water,
                                "cv" => 0,
                                "uniformity" => 0,
                                "id_user" => $dataarr->User_id,
                            ];
                            $this->MData->tambah('kandang_activity_log', $datainputactivitylog);
                        }
                        // Start Input Pakan
                        $datainputpakan1 = [
                            'id_kandang' => explode("|", $dataarr->IdKandang)['0'],
                            'periode' => $dataarr->Periode,
                            'tanggal_kandang_activity_log' => $getdateraw[2] . "-" . $getdateraw[1] . "-" . $getdateraw[0],
                            'type_sapronak' => 'pakan',
                            'method_sapronak' => 'use',
                            'id_this' => explode("|", $dataarr->Pakan)['0'],
                            'harga' => 0,
                            'qty' => $dataarr->Qty,
                            'id_user' => $dataarr->User_id
                        ];
                        $this->MData->tambah('kandang_activity_log_sapronak', $datainputpakan1);
                        if ($dataarr->Qty2 !== "") {
                            $datainputpakan2 = [
                                'id_kandang' => explode("|", $dataarr->IdKandang)['0'],
                                'periode' => $dataarr->Periode,
                                'tanggal_kandang_activity_log' => $getdateraw[2] . "-" . $getdateraw[1] . "-" . $getdateraw[0],
                                'type_sapronak' => 'pakan',
                                'method_sapronak' => 'use',
                                'id_this' => explode("|", $dataarr->Pakan2)['0'],
                                'harga' => 0,
                                'qty' => $dataarr->Qty2,
                                'id_user' => $dataarr->User_id
                            ];
                            // Save
                            $this->MData->tambah('kandang_activity_log_sapronak', $datainputpakan2);
                        }
                        if ($dataarr->Qty3 !== "") {
                            $datainputpakan3 = [
                                'id_kandang' => explode("|", $dataarr->IdKandang)['0'],
                                'periode' => $dataarr->Periode,
                                'tanggal_kandang_activity_log' => $getdateraw[2] . "-" . $getdateraw[1] . "-" . $getdateraw[0],
                                'type_sapronak' => 'pakan',
                                'method_sapronak' => 'use',
                                'id_this' => explode("|", $dataarr->Pakan3)['0'],
                                'harga' => 0,
                                'qty' => $dataarr->Qty3,
                                'id_user' => $dataarr->User_id
                            ];
                            // Save
                            $this->MData->tambah('kandang_activity_log_sapronak', $datainputpakan3);
                        }
                    } else {
                        $datainputactivitylog = NULL;
                        $wrong = true;
                    }
                    // End Input Kandang Activity Log
                }
                if ($wrong == true) {
                    echo json_encode(['status' => true, 'message' => "Ada kandang yang tidak di temukan periode nya"]);
                } else {
                    echo json_encode(['status' => true, 'message' => "Berhasil sync data ke server"]);
                }
            } else {
                echo json_encode(['status' => false, 'message' => 'Server tidak menerima data']);
                $this->MData->tambah('response', ['responsenya' => 'Gak ada']);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'Ada error disisi server']);
            $this->MData->tambah('response', ['responsenya' => 'Gak ada']);
        }
    }
    public function cek_data($user_id = NULL, $mode = NULL)
    {
        // $getkandangaktif = $this->MData->customresult("SELECT a.nama, a.user_id, a.id as id_kandang, b.* FROM `kandang` as a INNER JOIN kandang_activity as b on b.id_kandang = a.id and b.status_kandang_activity = 'AKTIF' WHERE user_id = {$user_id}");
        $getkandangaktif = $this->MData->customresult("SELECT * FROM kandang LEFT JOIN kandang_activity ON kandang.id = kandang_activity.id_kandang where FIND_IN_SET('{$user_id}', user_id_sharing) AND status_kandang = 'AKTIF' AND status_kandang_activity = 'AKTIF'");
        if ($getkandangaktif == FALSE) {
            $data_stok = array(
                'qty_stok' => '0',
                'id_brand' => '0',
                'brand' => '0',
                'idkandang' => '0',
                'periode' => '0',
                'nama_kandang' => '0',
            );
            $getkandangaktif = [
                "nama" => "0",
                "user_id" => "0",
                "id_kandang" => "0",
                "id" => "0",
                "populasi_awal" => "0",
                "strain" => "0",
                "status_kandang_activity" => "0",
                "tanggal_mulai" => "0",
                "harga_doc" => "0",
                "ip" => "0",
                "periode" => "0",
                "id_user" => "0",
                "created_at" => "0"
            ];
            $success = 0;
        } else {
            foreach ($getkandangaktif as $getkandangaktifs) {
                $query = "SELECT
              (SELECT sum(qty) from kandang_activity_log_sapronak where type_sapronak = 'pakan' and method_sapronak = 'in' and id_this = a.id_this and id_kandang = a.id_kandang and periode = a.periode) -
              IFNULL((SELECT sum(qty) from kandang_activity_log_sapronak where type_sapronak = 'pakan' and method_sapronak = 'out' and id_this = a.id_this and id_kandang = a.id_kandang and periode = a.periode),0) -
              IFNULL((SELECT sum(qty) from kandang_activity_log_sapronak where type_sapronak = 'pakan' and method_sapronak = 'use' and id_this = a.id_this and id_kandang = a.id_kandang and periode = a.periode),0) as qty_stok, b.id, b.brand

              FROM `kandang_activity_log_sapronak` as a
              LEFT JOIN pakan as b on a.id_this = b.id
              WHERE a.type_sapronak = 'pakan' and a.id_kandang = '{$getkandangaktifs->id_kandang}' AND a.periode = '{$getkandangaktifs->periode}'  GROUP BY a.id_this";
                // echo $query; exit;
                $getstokpakan = $this->MData->customresult("SELECT
              (SELECT sum(qty) from kandang_activity_log_sapronak where type_sapronak = 'pakan' and method_sapronak = 'in' and id_this = a.id_this and id_kandang = a.id_kandang and periode = a.periode) -
              IFNULL((SELECT sum(qty) from kandang_activity_log_sapronak where type_sapronak = 'pakan' and method_sapronak = 'out' and id_this = a.id_this and id_kandang = a.id_kandang and periode = a.periode),0) -
              IFNULL((SELECT sum(qty) from kandang_activity_log_sapronak where type_sapronak = 'pakan' and method_sapronak = 'use' and id_this = a.id_this and id_kandang = a.id_kandang and periode = a.periode),0) as qty_stok, b.id, b.brand

              FROM `kandang_activity_log_sapronak` as a
              LEFT JOIN pakan as b on a.id_this = b.id
              WHERE a.type_sapronak = 'pakan' and a.id_kandang = '{$getkandangaktifs->id_kandang}' AND a.periode = '{$getkandangaktifs->periode}'  GROUP BY a.id_this");
                if ($getstokpakan !== FALSE) {
                    foreach ($getstokpakan as $getstokpakans) {
                        $data_stok[] = array(
                            'qty_stok' => $getstokpakans->qty_stok == null ? 0 : $getstokpakans->qty_stok,
                            'id_brand' => $getstokpakans->id,
                            'brand' => $getstokpakans->brand,
                            'idkandang' => $getkandangaktifs->id_kandang,
                            'periode' => $getkandangaktifs->periode,
                            'nama_kandang' => $getkandangaktifs->nama,
                        );
                    }
                    $success = 1;
                } else {
                    $success = 0;
                }
            }
        }
        if ($mode == NULL) {
            echo json_encode(['success' => $success, 'data' => $data_stok]);
        } else {
            echo json_encode(['success' => $success, 'data' => $getkandangaktif]);
        }
        // var_dump($data_stok);
        // exit;
        // $data = array(
        //     'content' => 'cek_data',
        //     'title' => 'cek data',
        //     'kandang_aktif' => $getkandangaktif,
        //     'stock_pakan' => $data_stok,

        // );
        // $this->load->view('mobile/template', $data);
    }
    public function stock($id_user = NULL)
    {
        $id_user = $id_user;
        $stock_in = "IFNULL((SELECT SUM(qty) AS tot_qty FROM `kandang_activity_stock` WHERE  method_stock = 'in' and type_stock = 'pakan' AND id_user = '{$id_user}' AND id_this = b.id),0)";
        $stock_out = "IFNULL((SELECT SUM(qty) AS tot_qty FROM `kandang_activity_stock` WHERE  method_stock = 'out' and type_stock = 'pakan' AND id_user = '{$id_user}' AND id_this = b.id),0)";
        $querystockpakan = "SELECT
      IFNULL(SUM(a.qty),0) AS tot_qty_use,
      {$stock_in} AS tot_qty_in,
      {$stock_out} AS tot_qty_out,
      {$stock_in} - {$stock_out} - IFNULL(SUM(a.qty),0) AS stock,
      b.brand,
      b.id,
      c.first_name AS lokasi
      FROM
      pakan AS b
      LEFT JOIN `kandang_activity_log_sapronak` AS a ON b.id = a.id_this and a.id_kandang IN (SELECT id FROM kandang WHERE user_id = '{$id_user}' and stock = 'lokasi') AND a.type_sapronak = 'pakan' AND a.method_sapronak = 'use'
      LEFT JOIN `users` As c On c.id = '{$id_user}'
      GROUP BY
      b.id
      ORDER BY `b`.`brand` ASC";
        $getdatastockpakan = $this->MData->customrow($querystockpakan);
        if (is_array($getdatastockpakan)) {
            foreach ($getdatastockpakan as $getdatastockpakans) {
                if ($getdatastockpakans->stock != 0) {
                    $data_stok[] = array(
                        'qty_stok' => $getdatastockpakans->stock,
                        'id_brand' => $getdatastockpakans->id,
                        'brand' => $getdatastockpakans->brand,
                        'lokasi' => $getdatastockpakans->lokasi,
                    );
                }
            }
        }
        $result[] = array(
            'stock_lokasi' => isset($data_stok) ? $data_stok : NULL,
            'stock_kandang' => $getdatastockpakan,
        );
        echo json_encode($result);
    }
    public function get_data_stock_ovk($id_user = NULL)
    {
        $id_user = $id_user;
        $stock_in = "IFNULL((SELECT SUM(qty) AS tot_qty FROM `kandang_activity_stock` WHERE method_stock = 'in' and type_stock = 'ovk' AND id_user = '{$id_user}' AND id_this = b.id),0)";
        $stock_out = "IFNULL((SELECT SUM(qty) AS tot_qty FROM `kandang_activity_stock` WHERE method_stock = 'out' and type_stock = 'ovk' AND id_user = '{$id_user}' AND id_this = b.id),0)";
        $querystockobat = "SELECT
      IFNULL(SUM(a.qty),0) AS tot_qty_use,
      {$stock_in} AS tot_qty_in,
      {$stock_out} AS tot_qty_out,
      {$stock_in} - {$stock_out} - IFNULL(SUM(a.qty),0) AS stock,
      IFNULL(({$stock_in} - {$stock_out} - IFNULL(SUM(a.qty),0)) / b.quantity,0) as stock_qty,
      b.brand,
      b.satuan,
      b.quantity,
      b.id,
      c.first_name AS lokasi
      FROM
      obat AS b
      LEFT JOIN `kandang_activity_log_sapronak` AS a ON b.id = a.id_this and a.id_kandang IN (SELECT id FROM kandang WHERE user_id = '{$id_user}' and stock = 'lokasi') AND a.type_sapronak = 'ovk' AND a.method_sapronak = 'use'
      LEFT JOIN `users` As c On c.id = '{$id_user}'
      GROUP BY
      b.id
      ORDER BY `b`.`brand` ASC";
        $getdatastockobat = $this->MData->customresult($querystockobat);
        if (is_array($getdatastockobat)) {
            foreach ($getdatastockobat as $getdatastockobats) {
                if ($getdatastockobats->stock != 0) {
                    $data_stok[] = array(
                        'qty_stok' => $getdatastockobats->stock,
                        'id_brand' => $getdatastockobats->id,
                        'brand' => $getdatastockobats->brand,
                        'lokasi' => $getdatastockobats->lokasi,
                    );
                }
            }
        }
        $result[] = array(
            'stock_lokasi' => isset($data_stok) ? $data_stok : NULL,
            'stock_kandang' => $getdatastockobat,
        );
        echo json_encode($result);
    }
    public function get_data_stock_general($id_user = NULL)
    {
        $id_user = $id_user;
        $stock_in = "IFNULL((SELECT SUM(qty) AS tot_qty FROM `kandang_activity_stock` WHERE method_stock = 'in' and type_stock = 'general' AND id_user = '{$id_user}' AND id_this = b.id),0)";
        $stock_out = "IFNULL((SELECT SUM(qty) AS tot_qty FROM `kandang_activity_stock` WHERE method_stock = 'out' and type_stock = 'general' AND id_user = '{$id_user}' AND id_this = b.id),0)";
        $querystockobat = "SELECT
      IFNULL(SUM(a.qty),0) AS tot_qty_use,
      {$stock_in} AS tot_qty_in,
      {$stock_out} AS tot_qty_out,
      {$stock_in} - {$stock_out} - IFNULL(SUM(a.qty),0) AS stock,
      b.brand,
      b.satuan,
      b.id,
      c.first_name AS lokasi
      FROM
      general AS b
      LEFT JOIN `kandang_activity_log_sapronak` AS a ON b.id = a.id_this and a.id_kandang IN (SELECT id FROM kandang WHERE user_id = '{$id_user}' and stock = 'lokasi') AND a.type_sapronak = 'general' AND a.method_sapronak = 'use'
      LEFT JOIN `users` As c On c.id = '{$id_user}'
      GROUP BY
      b.id
      ORDER BY `b`.`brand` ASC";
        $getdatastockobat = $this->MData->customresult($querystockobat);
        if (is_array($getdatastockobat)) {
            foreach ($getdatastockobat as $getdatastockobats) {
                if ($getdatastockobats->stock != 0) {
                    $data_stok[] = array(
                        'qty_stok' => $getdatastockobats->stock,
                        'id_brand' => $getdatastockobats->id,
                        'brand' => $getdatastockobats->brand,
                        'lokasi' => $getdatastockobats->lokasi,
                    );
                }
            }
        }
        $result[] = array(
            'stock_lokasi' => isset($data_stok) ? $data_stok : NULL,
            'stock_kandang' => $getdatastockobat,
        );
        echo json_encode($result);
    }
    public function sendloggerresponse()
    {
        if ($this->input->post('id_user') !== "" && $this->input->post('response') !== "") {
            // echo json_encode($_POST);
            $datainput = [
                'message' => $this->input->post('response'),
                'id_user' => $this->input->post('id_user')
            ];
            $this->MData->tambah('logger_activity', $datainput);
        }
        // params . put("id_user", id_usernew);
        // params . put("response", outputnew);
    }
    public function getsequencedate()
    {
        if ($this->input->post()) {
            $idkandang = $this->input->post('idkandang');
            $periode = $this->input->post('periode');
            $tanggal = $this->input->post('tanggal');
            $getdata = $this->MData->customresult("SELECT *FROM kandang_activity_log where id_kandang = '{$idkandang}' AND periode ='{$periode}' ORDER BY tanggal desc");
            $tanggalbatas = date('Y-m-d');
            if ($getdata <> false) {
                $no = 1;
                foreach ($getdata as $getdatas) {
                    if ($no == 1) {
                        $tanggalbatas = $getdatas->tanggal;
                    }
                    if ($getdatas->tanggal == $tanggal) {
                        echo json_encode(['status' => false, 'message' => 'Anda sudah pernah menginput ditanggal ' . $tanggal, 'icon' => 'error']);
                        exit;
                    }
                    $no++;
                }

                $mustsequence =  date('Y-m-d', strtotime($tanggalbatas . ' +1 day'));
                if ($tanggal !== $mustsequence) {
                    echo json_encode(['status' => false, 'message' => 'Pastikan anda memasukkan tanggal berurutan , harusnya tanggal ' . $mustsequence, 'icon' => 'error']);
                    // echo json_encode(['status' => false, 'message' => $tanggal . "--" . $getdatass->tanggal, 'icon' => 'error']);
                    exit;
                }
            }
            // echo json_encode($getdata); exit;
        }
    }
    public function getpakanglobal()
    {
        if ($this->input->post()) {
            $getdata = $this->MData->selectdataglobal2('pakan');
            echo json_encode(['status' => true, 'message' => $getdata]);
        }
    }
    public function getpakan()
    {
        //    {"type_stock":"pakan"}
        $user_id = $this->input->post('user_id');
        $type_stock = $this->input->post('type_stock');
        switch ($type_stock) {
            case 'ovk':
                $table = "obat";
                break;

            default:
                $table = $type_stock;
                break;
        }

        $where = " and user_id = '{$user_id}'";
        $query_cek_user_id = "SELECT user_id FROM `kandang` where stock = 'lokasi' {$where} GROUP by user_id";
        $cek_user_id = $this->MData->customresult($query_cek_user_id);
        if (
            is_array($cek_user_id) || is_object($cek_user_id)
        ) {
            foreach ($cek_user_id as $cek_user_ids) {
                $stock_in = "IFNULL((SELECT SUM(qty) AS tot_qty FROM `kandang_activity_stock` WHERE  method_stock = 'in' and type_stock = '{$type_stock}' AND id_user = '{$cek_user_ids->user_id}'  AND id_this = b.id),0)";
                $stock_out = "IFNULL((SELECT SUM(qty) AS tot_qty FROM `kandang_activity_stock` WHERE  method_stock = 'out' and type_stock = '{$type_stock}' AND id_user = '{$cek_user_ids->user_id}'  AND id_this = b.id),0)";
                $querystockpakan = "SELECT
              b.id AS id_pakan,
              IFNULL(SUM(a.qty),0) AS tot_qty_use,
              {$stock_in} AS tot_qty_in,
              {$stock_out} AS tot_qty_out,
              {$stock_in} - {$stock_out} - IFNULL(SUM(a.qty),0) AS stock,
              b.brand,
              b.id,
              c.first_name AS lokasi
              FROM
              {$table} AS b
              LEFT JOIN `kandang_activity_log_sapronak` AS a ON b.id = a.id_this and a.id_kandang IN (SELECT id FROM kandang WHERE user_id = '{$cek_user_ids->user_id}' and stock = 'lokasi') AND a.type_sapronak = '{$type_stock}' AND a.method_sapronak = 'use'
              LEFT JOIN `users` As c On c.id = '{$cek_user_ids->user_id}'
              GROUP BY
              b.id
              ORDER BY `b`.`brand` ASC";
                $getdatastockpakan = $this->MData->customresult($querystockpakan);
                if (is_array($getdatastockpakan) || is_object($getdatastockpakan)) {
                    foreach ($getdatastockpakan as $getdatastockpakans) {
                        $result[] = array(
                            'id_pakan' => $getdatastockpakans->id_pakan,
                            'tot_qty_use' => $getdatastockpakans->tot_qty_use,
                            'tot_qty_in' => $getdatastockpakans->tot_qty_in,
                            'tot_qty_out' => $getdatastockpakans->tot_qty_out,
                            'stock' => $getdatastockpakans->stock,
                            'brand' => $getdatastockpakans->brand,
                            'id' => $getdatastockpakans->id,
                            'lokasi' => $getdatastockpakans->lokasi,
                        );
                    }
                    foreach ($getdatastockpakan as $getbrandlists) {
                        if ($getbrandlists->stock !== "0") {
                            if ((int)$getbrandlists->stock > 0) {
                                $outputbrand[] =  "<option value='{$getbrandlists->id_pakan}'>$getbrandlists->brand - Stock ($getbrandlists->stock)</option>";
                            } else {
                                $outputbrand[] = NULL;
                            }
                        } else {
                            $outputbrand[] = NULL;
                        }
                    }
                }
            }
            $brandfinal = implode("", $outputbrand);
            echo json_encode(['status' => true, 'brandlist' => $brandfinal]);
        }
    }
    public function getstd()
    {
        if ($this->input->post()) {
            $data = $this->MData->selectdatawhereresult('std', ['strain' => $this->input->post('strain')], 'id');
            echo json_encode($data);
        }
    }
    public function getpakanmutasi()
    {
        //    {"type_stock":"pakan"}
        $id_kandang = $this->input->post('id_kandang');
        $type_stock = $this->input->post('type_stock');
        $periode = $this->input->post('periode');
        switch ($type_stock) {
            case 'ovk':
                $table = "obat";
                $getdatastockpakan = $this->MSql->getstokovk($id_kandang, $periode);
                break;

            case 'general':
                $table = "general";
                $getdatastockpakan = $this->MSql->getstokgeneral($id_kandang, $periode);
                break;

            default:
                $table = $type_stock;
                $getdatastockpakan = $this->MSql->getstokpakan($id_kandang, $periode);
                break;
        }
        // $stock_in = "IFNULL((SELECT sum(qty) FROM kandang_activity_log_sapronak where id_kandang = '{$id_kandang}' and type_sapronak = '$type_stock' and method_sapronak = 'in' and id_this = kals.id_this),0)";
        // $stock_use = "IFNULL((SELECT sum(qty) FROM kandang_activity_log_sapronak where id_kandang = '{$id_kandang}' and type_sapronak = '$type_stock' and method_sapronak = 'use' and id_this = kals.id_this),0)";
        // $stock_out = "IFNULL((SELECT sum(qty) FROM kandang_activity_log_sapronak where id_kandang = '{$id_kandang}' and type_sapronak = '$type_stock' and method_sapronak = 'out' and id_this = kals.id_this and is_approved = '1'),0)";
        // $querystockpakan = "SELECT kals.id_this, (SELECT brand from $table where id = kals.id_this) as brand, $stock_in - $stock_use - $stock_out as totalqty FROM kandang_activity_log_sapronak kals where id_kandang = '{$id_kandang}' and type_sapronak = '$type_stock' GROUP BY brand";
        // $getdatastockpakan = $this->MData->customresult($querystockpakan);
        // $getdatastockpakan = $this->MSql->getstokpakan($id_kandang, $periode);
        $outputbrand = array();
        // if (is_array($getdatastockpakan) || is_object($getdatastockpakan)) {
        //     foreach ($getdatastockpakan as $getdatastockpakans) {
        //         $result[] = array(
        //             'stock' => $getdatastockpakans->totalqty,
        //             'brand' => $getdatastockpakans->brand,
        //             'id' => $getdatastockpakans->id_this,
        //         );
        //     }
        //     foreach ($result as $getbrandlists) {
        //         if ($getbrandlists['stock'] !== "0") {
        //             if ((int)$getbrandlists['stock'] > 0) {
        //                 $outputbrand[] =  "<option value='{$getbrandlists['id']}'>{$getbrandlists['brand']} - Stock ({$getbrandlists['stock']})</option>";
        //             } else {
        //                 $outputbrand[] = NULL;
        //             }
        //         } else {
        //             $outputbrand[] = NULL;
        //         }
        //     }
        // }
        if (is_array($getdatastockpakan) || is_object($getdatastockpakan)) {
            foreach ($getdatastockpakan as $getdatastockpakans) {
                $result[] = array(
                    'stock' => $getdatastockpakans->qty_stok,
                    'brand' => $getdatastockpakans->brand,
                    'id' => $getdatastockpakans->id,
                );
            }
            foreach ($result as $getbrandlists) {
                if ($getbrandlists['stock'] !== "0") {
                    if ((int)$getbrandlists['stock'] > 0) {
                        $outputbrand[] =  "<option value='{$getbrandlists['id']}'>{$getbrandlists['brand']} - Stock ({$getbrandlists['stock']})</option>";
                    } else {
                        $outputbrand[] = NULL;
                    }
                } else {
                    $outputbrand[] = NULL;
                }
            }
        }
        $brandfinal = implode("", $outputbrand);
        echo json_encode(['status' => true, 'brandlist' => $brandfinal]);
    }
    public function writecookie($index, $value)
    {
        setcookie($index, $value, time() + 30 * 24 * 60 * 60, "/");
    }
}

          /* End of file P.php */
