<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MThirdApp extends CI_Model
{
    public $cookiex;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MData');
        $this->db2 = $this->load->database('logger', TRUE);
        $this->load->library('user_agent');
        $this->cookiex = getcookienya('user_data');
        $this->load->library('WhatsAppLibrary');
    }
    public function getwebredirect()
    {
        $getcurrenturl = base_url();
        $word = "main.peternak.id";

        if (strpos($getcurrenturl, $word) !== false) {
            redirect('https://web.peternak.id', 'refresh');
        }
    }
    public function getfunctionrole($role, $function)
    {
        $cekdata = $this->MData->customrow("SELECT * FROM users_role_access r INNER JOIN users_role_function f ON r.id_navbar = f.id WHERE  r.id_role = {$role} AND f.nama_layanan = '{$function}'");
        if ($cekdata !== FALSE) {
            return true;
        } else {
            return false;
        }
    }
    public function fcmnotif($to, $judul, $message, $action = NULL, $updater = false)
    {
        if ($action !== NULL) {
            if ($updater == false) {
                $datamessage = '{ "notification": {
      "title": "' . $judul . '",
      "body": "' . $message . '",
      "click_action": "Open_URI",
      "content_available" : true,
      "priority" : "high"
    },
      "data": {
      "uri": "' . $action . '"
      },
    "to" : "' . $to . '"
  }';
            } else {
                $datamessage = '{ "notification": {
                    "title": "' . $judul . '",
                    "body": "' . $message . '",
                    "content_available" : true,
                    "priority" : "high"
                    },
                    "data": {
                    "link": "' . $action . '"
                    },
                    "to" : "' . $to . '"
                }';
            }
        } else {
            $datamessage = '{ "notification": {
          "title": "' . $judul . '",
          "body": "' . $message . '",
        },
        "to" : "' . $to . '"
      }';
        }
        $serverkey = $this->MData->selectdatawhere('web_setting', ['id' => 1])->fcm_serverkey;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $datamessage,

            CURLOPT_HTTPHEADER => array(
                "Authorization:  key={$serverkey}",
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        return $datamessage;
        curl_close($curl);
        // echo $response;
    }
    public function sendlogger()
    {
        $logger = array(
            'id' => null,
            'level'    => 'INFO',
            'logger' => date('Y-m-d H:i:s') . " [" . $this->cookiex['user_id'] . "] INFO " . $this->input->ip_address() . " - Akses URL : [main] " . current_url() . "",
            'ip' => $this->input->ip_address(),
            'created_at' => date('Y-m-d H:i:s'),
            'username' =>  $this->cookiex['user_id'],
            'url' => current_url()
        );
        // $username = isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : $this->cookiex['user_id'];
        $username = $this->cookiex['user_id'];
        $this->MData->edit(['id' => $username], 'users', ['last_login' => $logger['created_at']]);
        $this->db2->insert('logger', $logger);
    }
    public function getlocalip()
    {
        $string = $_SERVER['REMOTE_ADDR'];
        $array  = array('127.0.0.1', '192.168', '::1');
        return $this->strposa($string, $array);
    }
    function strposa(string $haystack, array $needles, int $offset = 0): bool
    {
        foreach ($needles as $needle) {
            if (strpos($haystack, $needle, $offset) !== false) {
                return true; // stop on first true result
            }
        }
        return false;
    }
    public function pushnotif($comment)
    {
        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );
        $pusher = new Pusher\Pusher(
            'eea33a26e3f15ecf5aa9',
            '37fdf5d621c2032a9f22',
            '1415872',
            $options
        );

        $data['message'] = $comment;
        $pusher->trigger('my-channel', 'my-event', $data);
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
    }
    public function countvisitor()
    {
        if ($this->uri->segment(2) == "public" && $this->uri->segment(2) !== NULL) {
            if ($this->uri->segment(3) !== NULL) {
                $id = $this->uri->segment(3);
                $check_visitor = $this->input->cookie(urldecode($id), FALSE);
                $ip = $this->input->ip_address();
                if ($check_visitor == NULL) {
                    $cookie = array("name" => urldecode($id), "value" => "$ip", "expire" => time() + 300, "secure" => false);
                    $this->input->set_cookie($cookie);
                    $this->db->query("UPDATE `blog` SET `visitor` = visitor + 1 WHERE `id` = '{$this->uri->segment(3)}'");
                }
            }
        }
    }
    public function generatoken($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function getcookie($id, $token)
    {
        // if (empty($_COOKIE["uuid"])) {
        //     $uuid = uniqid();  // or use a real UUID
        //     setcookie("uuid", $uuid, time() + 30 * 24 * 60 * 60, "/");
        //     setcookie("user_id", $id, time() + 30 * 24 * 60 * 60, "/");
        //     setcookie("token", $token, time() + 30 * 24 * 60 * 60, "/");
        // } else {
        //     $uuid = $_COOKIE["uuid"];
        // }
        // $data = array(
        //     'uuid' => $uuid,
        //     'user_id' => $id,
        //     'status' => 'run',
        //     'expired_at' => date('Y-m-d H:is', time() + 30 * 24 * 60 * 60)
        // );
        // $save = $this->MData->tambah('cookies', $data);
        // return $save;
    }
    public function validatetokensimple($token)
    {
        $cekdata = $this->MData->selectdatawhere('users', ['token_ajax' => $token]);
        if ($cekdata !== FALSE) {
            return true;
        } else {
            return false;
        }
    }
    public function validatetoken()
    {
        if ($this->input->post('token')) {
            $cekdata = $this->MData->selectdatawhere('users', ['token_ajax' => $this->input->post('token')]);
            if (!$cekdata) {
                return ['status' => FALSE, 'message' => 'Wrong Token'];
                exit;
            } else {
                return ['status' => TRUE, 'message' => $cekdata];
                exit;
            }
        } else {
            return ['status' => FALSE, 'message' => 'Wrong Parameter'];
        }
    }
    public function generatetoken($data)
    {
        return hash('ripemd160', $data);
    }
    public function caridataterdekat($data)
    {
        if (is_array($data) || is_object($data)) {
            foreach ($data as $data_harians) {

                foreach ($data as $obj) {
                    if ($data_harians->bw >= $obj->std_bw) {
                        $msg = $obj->umur;
                        break;
                    } else
                        $msg = 0;
                }
            }
        } else {
            $msg = 0;
        }
        // echo json_encode($data); exit;
        return $msg;
    }
    public function checkwavalid($number)
    {
        $getdata = $this->MData->selectdatawhere('web_setting', array('id' => '1'));
        $getstatus = $getdata->web_status_wa;
        if ($getstatus == 0) {
            $data = array(
                'status' => true,
                'message' => 'wa dimatikan'
            );
            return $data;
            exit;
        }
        $geturl = $getdata->web_domain_wa;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $geturl . "/checkregister",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => "number=$number",
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response, true);
    }

    public function sendWa($to, $message)
    {
        $url = $_ENV['WHATSAPP_BASE_URL'] . '/api/public/send-message';
        $body = json_encode(array('to' => $to, 'message' => $message), JSON_UNESCAPED_UNICODE);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Expect:',
                'Connection: keep-alive'
            ),
            // OPTIMASI JARINGAN
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
            CURLOPT_ENCODING => '',
        ));
        curl_setopt($curl, CURLOPT_TIMEOUT_MS, 1000);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            curl_close($curl);
            return ['status' => false, 'message' => $error_msg];
        }

        curl_close($curl);
        return json_decode($response, true);
    }

    public function sendotpwa1($message, $to, $role, $waverif = NULL)
    {
        $result = $this->whatsapplibrary->sendMessage($to, $message);
        return json_encode($result);
    }

    public function sendotpwa($pesan, $no, $role = 0)
    {
        // Cek setting
        // $setting = $this->MData->selectdatawhere('web_setting', array('id' => 1))->web_otp_setting;
        // if ($role == '1') {
        //     return false;
        //     exit;
        // }
        // if ($setting == '0') {
        //     return false;
        //     exit;
        // }
        $url = "https://appdmc.com/api/retrieve.php";
        $token = "119900";
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query(array('token' => $token, 'pesan' => $pesan, 'no' => $no)),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);
        return $response;

        curl_close($curl);
    }
    public function shortNumber($num)
    {
        $units = ['', 'K', 'M', 'B', 'T'];
        for ($i = 0; $num >= 1000; $i++) {
            $num /= 1000;
        }
        return round($num, 1) . $units[$i];
    }
    public function checksession()
    {
        // if (!$this->cookiex['number']) {
        // $this->getwebredirect();
        // $this->sendlogger();
        // $this->session->set_userdata(['cdn' => $this->config->item('cdn_url')]);
        // $this->session->set_userdata(['app' => $this->config->item('app_url')]);
        // if (isset($_COOKIE['user_id'])) {
        //     $iduser = $_COOKIE['user_id'];
        // } else {
        $cookiex = getcookienya('user_data');
        if (isset($cookiex['user_id'])) {
            $iduser = $cookiex['user_id'];
        } else {
            $this->destroyall();
            $this->session->set_flashdata('danger_message', 'Anda tidak bisa login, Hubungi Administrator');
            redirect(base_url('auth'), 'refresh');
        }


        // Get Data Kandang Per User
        // $dataquerydashboard = "select user_id,
        //     (select count(nama) from kandang where status_kandang = 'AKTIF' AND user_id = '{$iduser}') as kandang_aktif,
        //     (select count(nama) from kandang where status_kandang in ('REHAT') AND user_id = '{$iduser}') as kandang_rehat,
        //     (select sum(populasi_awal) from kandang_activity where id_user = '{$iduser}') as total_populasi,
        //     (select ROUND((select sum(populasi_awal) from kandang_activity where id_user = '{$iduser}') - sum(total_mati)) from kandang_activity_log where id_user = '{$iduser}') as total_deplesi,
        //     (select sum(total_mati) from kandang_activity_log where id_user = '{$iduser}') as total_mati,
        //     (select sum(bw) from kandang_activity_log where id_user = '{$iduser}' AND bw BETWEEN 1200 AND 1600) as total_bw12,
        //     (select sum(bw) from kandang_activity_log where id_user = '{$iduser}' AND bw BETWEEN 1600 AND 2000) as total_bw16,
        //     (select sum(bw) from kandang_activity_log where id_user = '{$iduser}' AND bw > 2000) as total_bw20up,
        //     (select count(bw) from kandang_activity_log where id_user = '{$iduser}' AND bw BETWEEN 1200 AND 1600) as totalekor_bw12,
        //     (select count(bw) from kandang_activity_log where id_user = '{$iduser}' AND bw BETWEEN 1600 AND 2000) as totalekor_bw16,
        //     (select count(bw) from kandang_activity_log where id_user = '{$iduser}' AND bw > 2000) as totalekor_bw20up
        //     from kandang LIMIT 1";
        // $datadashboard = $this->MData->customrow($dataquerydashboard);
        // $datakandang = array(
        //     "kandang_aktif" => $datadashboard->kandang_aktif,
        //     "kandang_rehat" => $datadashboard->kandang_rehat,
        //     "kandang_total" => (int)$datadashboard->kandang_aktif + (int)$datadashboard->kandang_rehat,
        //     "total_populasi" => $datadashboard->total_populasi,
        //     "total_deplesi" => $datadashboard->total_deplesi,
        //     "total_mati" => $datadashboard->total_mati,
        //     "total_bw12" => $datadashboard->total_bw12,
        //     "total_bw16" => $datadashboard->total_bw16,
        //     "total_bw20up" => $datadashboard->total_bw20up,
        //     "totalekor_bw12" => $datadashboard->totalekor_bw12,
        //     "totalekor_bw16" => $datadashboard->totalekor_bw16,
        //     "totalekor_bw20up" => $datadashboard->totalekor_bw20up
        // );

        // CALL API GET KANDANG
        // $endpoint = '/web/checksession';
        // $url = $_ENV['APP_API_URL_V1'] . $endpoint;
        // $withToken = true;

        // $payload["userId"] = $iduser;
        // $response = call_api("POST", $url, $payload, $withToken);
        // $datakandang = $response['data'];

        // $this->session->set_userdata(array('datakandang' => $datakandang));

        // echo json_encode($this->getgroupingkandang($iduser)); exit;
        // echo json_encode( $this->getgroupingkandang($iduser)); exit;
        //  $cookie_data = array(
        //             'user_id' => $cekdatatoken->user_id,
        //             'token'   => $getuser->token_ajax,
        //         );
        // //         // Mengatur cookie dengan nama 'user_data'

        // CREATE JSON COOKIE
        // DISABLE SEMENTARA - 250826 - MAINTENANCE
        // $this->session->set_userdata(array('datagroupingkandang' => $this->getgroupingkandang($iduser)));
        // $this->input->set_cookie('datakandang', json_encode(['datakandang' => $datakandang]), 86500); // 86500 detik = 1 hari
        // createfilejsoncookie($iduser, $datakandang, 'datakandang');
        // createfilejsoncookie($iduser, $this->getgroupingkandang($iduser), 'datagroupingkandang');
        // END DISABLE

        // $this->input->set_cookie('datagroupingkandang', json_encode($this->getgroupingkandang($iduser)), 86500); // 86500 detik = 1 hari

        // if (isset($_SESSION['datagroupingkandang']) && $_SESSION['datagroupingkandang']  == false || $_SESSION['datagroupingkandang']  <> null) {
        // }
        $getdataurl = $this->getplaintexturl(current_url());
        if ($getdataurl == "peternak.id") {
            redirect(base_url('home'), 'refresh');
            exit;
        }

        // DISABLE SEMENTARA - 250826 - MAINTENANCE
        // $datacookie = isset($_COOKIE['uuid']) ? $_COOKIE['uuid'] : NULL;
        // $exclude = array('chicken');
        // $ceksetting = $this->MData->selectdatawhere('web_setting', array('id' => 1));
        // $cekloader = $ceksetting->web_loader_page;
        // $cekinterval = $ceksetting->web_interval_license;
        // $cekmode = $ceksetting->web_mode;
        // $premiumblock = $ceksetting->web_premium_blok;
        // $premiummodal = $ceksetting->web_premium_modal;
        // if ($this->getlocalip() == true) {
        //     $homepage = $ceksetting->local_homepage;
        //     $mainpage = $ceksetting->local_mainpage;
        //     $mainloginpage = $ceksetting->local_mainloginpage;
        // } else {
        //     $homepage = $ceksetting->homepage;
        //     $mainpage = $ceksetting->mainpage;
        //     $mainloginpage = $ceksetting->mainloginpage;
        // }
        // $loaderdata = array('loader' => $cekloader, 'intervalcount' => $cekinterval, 'mode' => $cekmode);
        // END DISABLE

        // if (!in_array(strtolower($this->uri->segment(2)), $exclude)) {
        //     if ($datacookie !== NULL || !empty($datacookie)) {
        //         // Ambil data cookie
        //         $getuser = $this->MData->selectdatawhere('cookies', array('uuid' => $datacookie, 'status' => 'run'));
        //         if ($getuser !== FALSE) {
        //             $calldatauser = $this->MData->selectdatawhere('users', array('id' => $getuser->user_id));
        //             $dataanew = array_merge($loaderdata, (array)$calldatauser);
        //             $this->session->set_userdata($dataanew);
        //             $this->onlinestatus($_COOKIE['uuid']);
        //         } else {
        //             $this->destroyall();
        //             redirect($mainloginpage);
        //         }
        //     } else {
        //         $this->destroyall();
        //         redirect($mainloginpage);
        //     }
        // }
        // }
    }

    protected function getDatakandang($iduser)
    {
        $endpoint = '/web/checksession';
        $url = $_ENV['APP_API_URL_V1'] . $endpoint;

        $payload["userId"] = $iduser;
        $response = call_api("POST", $url, $payload, true);

        return $response['data'] ?? [];
    }

    protected function getHenhouseGrouping($userId, $role)
    {
        $endpoint = '/web/get-henhouse-group';
        $url = $_ENV['APP_API_URL_V1'] . $endpoint;

        $payload["userId"] = $userId;
        $payload["role"] = $role;
        $response = call_api("POST", $url, $payload, true);

        return $response['data'] ?? [];
    }


    public function getgroupingkandang($id = NULL)
    {
        if ($id == NULL) {
            $cookiex = getcookienya('user_data');
            $idx = $cookiex['user_id'];
        } else {
            $idx = $id;
        }

        // $query = "SELECT * FROM kandang k LEFT JOIN users u ON k.user_id = u.id where FIND_IN_SET($idx, user_id_sharing) AND status_kandang not in ('DELETE') ORDER BY `u`.`first_name` ASC";
        // $getdata = $this->MData->customresult($query);
        $getdata = $this->listkandang($idx);
        // echo json_encode($getdata);
        // exit;
        if ($getdata !== FALSE) {
            return $getdata;
        } else {
            return false;
        }
    }
    public function getplaintexturl($base_url)
    {
        $CI = &get_instance();
        return preg_replace("/^[\w]{2,6}:\/\/([\w\d\.\-]+).*$/", "$1", $CI->config->slash_item('base_url'));
    }
    public function destroyall()
    {
        $this->session->sess_destroy();
        delete_cookie('uuid');
    }
    public function getrole()
    {
        if ($this->cookiex['role_nm'] == "Superadmin") {
            return true;
        } else {
            return false;
        }
    }
    public function cekip()
    {
        $ip = $this->input->ip_address();
        // echo $ip;
        // exit;
        $people = array("103.254.169.138", "::1", "192.168.58.58", "Cleveland");

        if (!in_array($ip, $people)) {
            // redirect('app', 'refresh');
        }
    }
    public function onlinestatus($uuid)
    {
        $cekdata = $this->MData->customrow("SELECT *,cookies.status as statususer FROM cookies LEFT JOIN users ON cookies.user_id = users.id WHERE uuid = '{$uuid}'");
        if ($cekdata == false) {
            return json_encode(array('status' => false, 'message' => 'Wrong data'));
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
    }
    public function checksessiononhome()
    {
        $getdataurl = $this->getplaintexturl(current_url());
        $this->cekip();
        $urisegment = $this->uri->segment(1);
        // $datacookie = isset($_COOKIE['uuid']) ? $_COOKIE['uuid'] : NULL;
        $ceksetting = $this->MData->selectdatawhere('web_setting', array('id' => 1));
        $cekloader = $ceksetting->web_loader_page;
        $cekinterval = $ceksetting->web_interval_license;
        $cekmode = $ceksetting->web_mode;
        $premiumblock = $ceksetting->web_premium_blok;
        $premiummodal = $ceksetting->web_premium_modal;
        if ($this->getlocalip() == true) {
            $homepage = $ceksetting->local_homepage;
            $mainpage = $ceksetting->local_mainpage;
            $mainloginpage = $ceksetting->local_mainloginpage;
        } else {
            $homepage = $ceksetting->homepage;
            $mainpage = $ceksetting->mainpage;
            $mainloginpage = $ceksetting->mainloginpage;
        }
        $loaderdata = array('loader' => $cekloader, 'intervalcount' => $cekinterval, 'mode' => $cekmode);
        $exclude = array('chicken');
        // if ($datacookie !== NULL || !empty($datacookie)) {
        // Ambil data cookie
        // $getuser = $this->MData->selectdatawhere('cookies', array('uuid' => $datacookie, 'status' => 'run'));
        $cookiex = getcookienya('user_data');

        // var_dump($cookiex['user_id']); exit;
        if (is_array($cookiex) && isset($cookiex['user_id'])) {
            $calldatauser = $this->MData->customrow("SELECT *from users u INNER JOIN users_role ur ON u.role =  ur.id where u.id = '{$cookiex['user_id']}'");
            $datanew = array_merge($loaderdata, (array)$calldatauser);
            $this->session->set_userdata($datanew);
            // echo "here"; exit;
            // $this->onlinestatus($_COOKIE['uuid']);
            //find word in cookie bener tapi url salah
            $curr = current_url();
            // if ($getdataurl !== "app.peternak.id") {
            //     redirect($this->MData->selectdatawhere('web_setting',array('id' => 1))->homepage,'refresh');
            // //  $currenturl = str_replace("peternak.id","app.peternak.id",current_url());
            // //  $newurl = str_replace("auth","dist",$currenturl);
            // //  redirect($newurl,'refresh');
            // //  exit;
            // }else{
            //     // $redirectthis = str_replace(current_url(),$mainpage."dist",current_url());
            //     // redirect($redirectthis,'refresh');
            redirect($mainpage, 'refresh');
            // }
        }
        // }
    }

    public function expiredcart($date)
    {
        $cekexpiredtime = $this->MData->selectdatawhere('rpa_web_setting', array('id' => '1'));
        $getexpired = $cekexpiredtime->web_expired_cart;
        $datenew = date('Y-m-d H:i:s', strtotime($date . "+{$getexpired} days"));
        return $datenew;
    }
    public function cekword($data, $word)
    {
        if (strpos($data, $word) !== false) {
            return true;
        } else {
            return false;
        }
    }
    function import_status()
    {
        $cekfeature = $this->MData->selectdatawhere('rpa_web_setting', array('id' => '1'));
        return $cekfeature;
    }
    function importfeature($file_tmp, $file_name)
    {
        $cekfeature = $this->import_status;
        if ($cekfeature->web_import_status == "ACTIVE") {
            move_uploaded_file($file_tmp, $cekfeature->web_import_path . $file_name); // simpan filenya di folder uploads
        }
    }
    function indotime($time, $default = NULL)
    {
        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $time);
        if ($default == NULL) {
            return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
        } else if ($default == "MONTH") {
            return $bulan[(int)$pecahkan[1]];
        }
    }
    function timeline($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
    public function listkandang($id = NULL)
    {
        $cookiex = getcookienya('user_data');
        if ($id == NULL) {
            $iduser = $cookiex['user_id'];
        } else {
            $iduser = $id;
        }
        // $getuserss = $this->MData->selectdatawhere('users', ['id' => $id]);
        switch ($cookiex['role']) {
            case '1':
                $datarole = "";
                break;
            case '2':
                $datarole = " AND a.user_id in (SELECT id from users as a_user WHERE a_user.id_company = (SELECT id_company from users where id = '{$iduser}'))";
                break;

            case '3':
                $datarole = " AND a.user_id in (SELECT id from users as a_user WHERE a_user.id_company = (SELECT id_company from users where id = '{$iduser}'))";
                break;

            case '4':
                $datarole = " AND FIND_IN_SET('{$iduser}', a.user_id_sharing) ";
                break;

            default:
                $datarole = " AND FIND_IN_SET('{$this->cookiex['user_master']}', a.user_id_sharing) ";
                break;
        }

        $data_ternak_aktif_query = "SELECT
                            a.is_mitra,
                            a.nama,
                            a.foto,
                            a.id AS id_kandang,
                            a.kapasitas,
                            b.periode,
                            b.tanggal_mulai,
                            b.status_kandang_activity,
                            c.deplesi,
                            b.populasi_awal - IFNULL(c.deplesi, 0) - IFNULL(f.panen_ekor, 0) AS populasi,
                            IFNULL(g.location, e.first_name) AS nama_user
                            FROM
                                kandang AS a
                            LEFT JOIN
                                (
                                    SELECT
                                        id_kandang,
                                        MAX(periode) AS periode
                                    FROM
                                        kandang_activity
                                    WHERE
                                        status_kandang_activity not in ('DELETE')
                                    GROUP BY
                                        id_kandang
                                ) AS max_period
                            ON
                                a.id = max_period.id_kandang
                            LEFT JOIN
                                kandang_activity AS b
                            ON
                                max_period.id_kandang = b.id_kandang
                                AND max_period.periode = b.periode
                            LEFT JOIN
                                (
                                    SELECT
                                        SUM(total_mati) AS deplesi,
                                        periode,
                                        id_kandang
                                    FROM
                                        kandang_activity_log
                                    GROUP BY
                                        periode, id_kandang
                                ) AS c
                            ON
                                max_period.periode = c.periode
                                AND max_period.id_kandang = c.id_kandang
                            LEFT JOIN
                                users AS e
                            ON
                                a.user_id = e.id
                            LEFT JOIN
                                (
                                    SELECT
                                        SUM(qty_ekor) AS panen_ekor,
                                        periode,
                                        id_kandang
                                    FROM
                                        kandang_activity_log_panen
                                    GROUP BY
                                        id_kandang, periode
                                ) AS f
                            ON
                                max_period.periode = f.periode
                                AND max_period.id_kandang = f.id_kandang
                            LEFT JOIN
                                company_sub AS g
                            ON
                                a.id_lokasi = g.id
                                AND g.status = 1
                            WHERE
                                a.status_kandang NOT IN ('DELETE') {$datarole}
                            ORDER BY
                                nama_user, a.nama ASC";
        $data_ternak_aktif = $this->MData->customresult($data_ternak_aktif_query);
        return $data_ternak_aktif;
    }
    public function listkandang_new($id = NULL)
    {
        $cookiex = getcookienya('user_data');
        if ($id == NULL) {
            $iduser = $cookiex['user_id'];
        } else {
            $iduser = $id;
        }
        $getuserss = $this->MData->selectdatawhere('users', ['id' => $id]);
        switch ($cookiex['role']) {
            case '1':
                $datarole = "";
                break;
            case '2':
                $datarole = " AND a.user_id in (SELECT id from users as a_user WHERE a_user.id_company = (SELECT id_company from users where id = '{$iduser}'))";
                break;

            case '3':
                $datarole = " AND a.user_id in (SELECT id from users as a_user WHERE a_user.id_company = (SELECT id_company from users where id = '{$iduser}'))";
                break;

            case '4':
                $datarole = " AND FIND_IN_SET('{$iduser}', a.user_id_sharing) ";
                break;

            default:
                $datarole = " AND FIND_IN_SET('{$this->cookiex['user_master']}', a.user_id_sharing) ";
                break;
        }
        $data_ternak_aktif_query = "SELECT
                            a.is_mitra,
                            a.nama,
                            a.foto,
                            a.id AS id_kandang,
                            a.kapasitas,
                            b.periode,
                            b.tanggal_mulai,
                            b.status_kandang_activity,
                            IFNULL(g.location, e.first_name) AS nama_user
                            FROM
                                kandang AS a
                            LEFT JOIN
                                (
                                    SELECT
                                        id_kandang,
                                        MAX(periode) AS periode
                                    FROM
                                        kandang_activity
                                    WHERE
                                        status_kandang_activity not in ('DELETE')
                                    GROUP BY
                                        id_kandang
                                ) AS max_period
                            ON
                                a.id = max_period.id_kandang
                            LEFT JOIN
                                kandang_activity AS b
                            ON
                                max_period.id_kandang = b.id_kandang
                                AND max_period.periode = b.periode
                            LEFT JOIN
                                (
                                    SELECT
                                        periode,
                                        id_kandang
                                    FROM
                                        kandang_activity_log
                                    GROUP BY
                                        periode, id_kandang
                                ) AS c
                            ON
                                max_period.periode = c.periode
                                AND max_period.id_kandang = c.id_kandang
                            LEFT JOIN
                                users AS e
                            ON
                                a.user_id = e.id
                            LEFT JOIN
                                (
                                    SELECT
                                        periode,
                                        id_kandang
                                    FROM
                                        kandang_activity_log_panen
                                    GROUP BY
                                        id_kandang, periode
                                ) AS f
                            ON
                                max_period.periode = f.periode
                                AND max_period.id_kandang = f.id_kandang
                            LEFT JOIN
                                company_sub AS g
                            ON
                                a.id_lokasi = g.id
                                AND g.status = 1
                            WHERE
                                a.status_kandang NOT IN ('DELETE') {$datarole}
                            ORDER BY
                                nama_user, a.nama ASC";
        $data_ternak_aktif = $this->MData->customresult($data_ternak_aktif_query);
        return $data_ternak_aktif;
    }
}
