<?php

defined('BASEPATH') or exit('No direct script access allowed');
Sentry\init(['dsn' => 'https://4dba7b441a7ff5576bdc44cf8098b987@o4504875505483776.ingest.sentry.io/4506318591950848']);
class Cron extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('MData');
        $this->load->model('MThirdApp');
    }

    public function index()
    {
        echo json_encode(['status' => false, 'message' => 'Cant Access']);
    }

    public function generatetokenajax()
    {
        $cekdatauser = $this->MData->customresult("SELECT * FROM users WHERE token_ajax is NULL");
        // echo json_encode($cekdatauser);
        if ($cekdatauser !== FALSE) {
            foreach ($cekdatauser as $cekdatausers) {
                $data = ['token_ajax' => $this->MThirdApp->generatetoken($cekdatausers->number)];
                $this->MData->edit(['id' => $cekdatausers->id], 'users', $data);
            }
            echo json_encode(['status' => true, 'message' => 'Berhasil update token']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Tidak ada data']);
        }
    }
    public function sendnotifupdate()
    {
        //Untuk follow up notif app ke user yang belum update aplikasi ke versi terbaru
        $cekcurrent = $this->MData->selectdatawhere('updaterversion', ['status' => 'currentv']);
        $cekweb_updateminimal = $this->MData->selectdatawhere('web_setting', ['id' => 1])->web_updateminimal;
        $cekstatusupdate = $this->MData->customrow("CALL ratarataupdate('{$cekcurrent->versionapp}')");
        if ($cekstatusupdate->presentase < $cekweb_updateminimal) {
            $query = "SELECT *FROM users where token_fcm is not null AND app_version != '{$cekcurrent->versionapp}'";
            $cekuser = $this->MData->customresult($query);
            $judul = "Aku butuh update 🐤🐤🐤 ({$cekcurrent->versionapp})";
            $action = $this->config->item('app_url') . "update";
            foreach ($cekuser as $cekusers) {
                $message = "Wah aplikasi kamu masih di versi {$cekusers->app_version} nih, tolong di update ya 😅";
                $to = $cekusers->token_fcm;
                $output = $this->MThirdApp->fcmnotif($to, $judul, $message, $action, FALSE);
                $outputnya[] = $output;
            }
            echo json_encode(['status' => true, 'message' => $outputnya]);
        } else {
            echo json_encode(['status' => false, 'message' => 'Semua user sudah update mantap']);
            exit;
        }
    }
    public function sendnotifcustom()
    {
        //Untuk follow up notif app ke user yang belum update aplikasi ke versi terbaru
        $cekstatusupdate = $this->MData->customresult("SELECT * FROM users where token_fcm is not null");
        if ($cekstatusupdate !== FALSE) {
            $judul = "Masukan untuk PETERNAK.ID";
            $action = "https://forms.gle/pEgP1M7za9M69Zx78";
            foreach ($cekstatusupdate as $cekusers) {
                $message = "Halo {$cekusers->first_name},\nKami baru saja melakukan update beberapa perubahan di app.\nBeritahu kami tentang pengalaman penggunaan app Peternak.ID dengan mengisi survey di bawah ini.\n\n" . $action . "\nAbaikan jika sudah mengisi.";
                $to = $cekusers->token_fcm;
                $output = $this->MThirdApp->fcmnotif($to, $judul, $message, $action, FALSE);
                $outputnya[] = $output;
            }
            echo json_encode($outputnya);
        } else {
            echo json_encode(['status' => false, 'message' => 'Semua user sudah update mantap']);
            exit;
        }
    }
    public function getdata()
    {
        $cekdata = $this->MData->customrow("SELECT GROUP_CONCAT(DISTINCT val ORDER BY val ASC) AS unique_values
        FROM (
            SELECT DISTINCT SUBSTRING_INDEX(SUBSTRING_INDEX(k.user_id_sharing, ',', n.n), ',', -1) AS val
            FROM (
                SELECT user_id_sharing
                FROM kandang
                WHERE id_lokasi IN (SELECT id FROM company_sub WHERE id_company = '1')
            ) k
            CROSS JOIN (
                SELECT 1 AS n UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5
            ) n
            WHERE n.n <= CHAR_LENGTH(k.user_id_sharing) - CHAR_LENGTH(REPLACE(k.user_id_sharing, ',', '')) + 1
        ) subquery");
        $string = $cekdata->unique_values;
        // Membagi string menjadi array berdasarkan koma
        $items = explode(",", $string);

        // Menghapus nilai yang duplikat
        $uniqueItems = array_unique($items);
        $implode  = implode(",", $uniqueItems);
        $cekuser = $this->MData->customresult("select * from users where id in ({$implode})");
        if ($cekuser) {
            foreach ($cekuser as $cekusers) {
                if ($cekusers->token_fcm <> NULL) {
                    echo $cekusers->first_name . "<br>";
                    // $databaru[] = $cekusers;
                }
            }
        }
        // echo count($databaru);
    }
    public function sendnotifcustomwa()
    {
        //Untuk follow up notif app ke user yang belum update aplikasi ke versi terbaru
        $cekstatusupdate = $this->MData->customresult("SELECT * FROM users where token_fcm is not null");
        if ($cekstatusupdate !== FALSE) {
            $judul = "*Masukan untuk PETERNAK.ID*\n\n";
            // $action = "https://forms.gle/u8a6TMv9B8nCvmBy5";
            $action = "https://forms.gle/pEgP1M7za9M69Zx78";
            foreach ($cekstatusupdate as $cekusers) {
                $message = $judul . "Halo *{$cekusers->first_name}*,\nKami baru saja melakukan update beberapa perubahan di app.\nBeritahu kami tentang pengalaman penggunaan app Peternak.ID dengan mengisi survey di bawah ini.\n\n" . $action . "\n*Abaikan jika sudah mengisi.*";
                $output = $this->MThirdApp->sendotpwa($message, $cekusers->number);
                $outputnya[] = $output;
                // if ($cekusers->id == '41') {
                // }
            }
            echo json_encode($outputnya);
        } else {
            echo json_encode(['status' => false, 'message' => 'Semua user sudah update mantap']);
            exit;
        }
    }
    public function cekpendinguser()
    {
        //Untuk follow up notif wa ke user yang status nya pending 
        $cekuser = $this->MData->selectdatawhereresult('users', ['status' => 'pending']);
        if ($cekuser !== FALSE) {
            foreach ($cekuser as $cekusers) {
                $message = "Halo {$cekusers->first_name},\nAkun anda belum sepenuhnya teraktivasi di PETERNAK.ID 🐤🐤.\nYuk lakukan login ulang ke PETERNAK.ID 🐤🐤";
                $statussend = $this->MThirdApp->sendotpwa($message, $cekusers->number) !== FALSE ? true : false;
                $output[] = [
                    'send' => $statussend,
                    'number' => $cekusers->number,
                    'name' => $cekusers->first_name
                ];
            }
            echo json_encode(['status' => true, 'data' => $output]);
        } else {
            echo json_encode(['status' => false, 'data' => 'no data']);
        }
    }
    public function cekadsuser($iduser)
    {
        $cekuser = $this->MData->selectdatawhere('users', ['id' => $iduser]);
        if ($cekuser !== FALSE) {
            echo json_encode(['status' => (int)$cekuser->ads]);
        } else {
            echo json_encode(['status' => false]);
        }
    }
}
