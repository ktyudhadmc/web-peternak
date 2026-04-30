<?php

defined('BASEPATH') or exit('No direct script access allowed');
require_once 'vendor/autoload.php';
Sentry\init(['dsn' => 'https://4dba7b441a7ff5576bdc44cf8098b987@o4504875505483776.ingest.sentry.io/4506318591950848']);
class Auth extends CI_Controller
{

  public $status;
  public $roles;

  function __construct()
  {
    parent::__construct();
    $this->load->model('User_model', 'user_model', TRUE);
    $this->load->library('form_validation');
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    $this->status = $this->config->item('status');
    $this->roles = $this->config->item('roles');
    $this->load->library('userlevel');
    $this->load->library('sendmail');
    $this->load->library('recaptcha');
    $this->load->library('curl');
    $this->load->model('MThirdApp');
  }
  public function index()
  {
    $data = array();
    $data['title'] = 'Login';
    $data['content'] = 'login';

    $this->MThirdApp->checksessiononhome();
    $registercheck = true;
    $digits = 4;
    // Login Via Google
    // $google_client = new Google_Client();
    // $google_client->setClientId('218328949136-vtbl71873krtblr075jqf3cpdleri88c.apps.googleusercontent.com');
    // $google_client->setClientSecret('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');
    // $google_client->setRedirectUri(base_url('auth'));
    // $google_client->addScope('email');
    // $google_client->addScope('profile');
    // $data['googleurl'] = $google_client->createAuthUrl();
    // $datagoogle = NULL;
    // if ($this->input->get('code')) {
    //   $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
    //   if (!isset($token["error"])) {
    //     $google_client->setAccessToken($token['access_token']);
    //     $google_service = new Google_Service_Oauth2($google_client);
    //     $datagoogle_raw = $google_service->userinfo->get();
    //     $current_datetime = date('Y-m-d H:i:s');
    //     if ($datagoogle_raw['verifiedEmail'] == true) {
    //       $datagoogle = array(
    //         'first_name' => $datagoogle_raw['given_name'],
    //         'last_name'  => $datagoogle_raw['family_name'],
    //         'email_address' => $datagoogle_raw['email'],
    //         'profile_picture' => $datagoogle_raw['picture'],
    //         'updated_at' => $current_datetime,
    //         'verified_email' => $datagoogle_raw['verifiedEmail']
    //       );
    //     }
    //   }
    // if ($datagoogle !== NULL) {
    //   $cekemailgoogle = $this->MData->selectdatawhere('users', array('email' => $datagoogle['email_address']));
    //   if ($cekemailgoogle !== false) {
    //     if ($cekemailgoogle->banned_users == "ban") {
    //       $this->session->set_flashdata('danger_message', 'Akun anda diban, Silahkan hub admin');
    //       redirect(base_url('auth'), 'refresh');
    //       exit;
    //     }
    //     if ($cekemailgoogle->status == "active") {
    //       $getuser = $this->MData->customrow("SELECT *,u.id as user_id from users u INNER JOIN users_role ur ON u.role = ur.id where u.id ='{$cekemailgoogle->id}'");
    //       if ($getuser->status_role == '0') {
    //         $this->session->set_flashdata('danger_message', 'Role anda sedang di nonaktifkan , Hub ADMIN');
    //         redirect('auth', 'refresh');
    //         exit;
    //       }
    //       $datalastlogin = array('last_login' => date('Y-m-d H:i:s'));
    //       $this->MData->edit(array('id' => $cekemailgoogle->id), 'users', $datalastlogin);
    //       $this->session->set_userdata((array)$getuser);
    //       $this->MThirdApp->getcookie($cekemailgoogle->id, $cekemailgoogle->token_ajax);
    //       redirect(base_url('main'), 'refresh');
    //       exit;
    //     } else {
    //       $this->session->set_flashdata('danger_message', 'Akun anda belum aktif Klik link : ' . "<a href='" . base_url("auth/register/{$number}") . "'>&nbsp;Aktivasi</a>");
    //       redirect(base_url('auth'), 'refresh');
    //       exit;
    //     }
    //   } else {
    //     $this->session->set_flashdata('danger_message', 'Data anda belum terdaftar didatabase');
    //   }
    // }
    // }
    // End Google

    // Login Manual NO HP
    if ($this->input->post()) {
      $number = $this->input->post('nomor');
      if ($this->input->post('nomor') == "") {
        $this->session->set_flashdata('danger_message', 'Pastikan anda mengisi nomor dengan benar');
        redirect(base_url('auth'), 'refresh');
        exit;
      }
      // $checknomorwa = $this->MThirdApp->checkwavalid($number);
      // Cek nomor di database
      $ceknomor = $this->MData->selectdatawhere('users', array('number' => $number));
      if ($ceknomor !== false) {
        // Cek  akun aktif apa nggak
        if ($ceknomor->banned_users == "ban") {
          $this->session->set_flashdata('danger_message', 'Akun anda diban, Silahkan hub admin');
          redirect(base_url('auth'), 'refresh');
          exit;
        }
        if ($ceknomor->is_webapp == "0") {
          // $this->session->set_flashdata('danger_message', 'Akun anda diban, Silahkan hub admin');
          redirect($this->config->item('app_url') . "home/kemitraan/showmessage");
          exit;
        }
        if ($ceknomor->status == "active") {
          //Jika data ada di database, send otp
          $otp = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
          $message = $this->sendmail->sendotpformat($otp);
          $gettoken = $this->MThirdApp->generatoken(20);
          if ($ceknomor->wa_verif == "0") {
            $getuser = $this->MData->customrow("SELECT *,u.id as user_id from users u INNER JOIN users_role ur ON u.role = ur.id where u.id ='{$ceknomor->id}'");
            $this->session->set_userdata((array)$getuser);
            redirect(base_url('main'), 'refresh');
            exit;
          }
          $otpsend = $this->MThirdApp->sendotpwa1($message, $number, $ceknomor->role);
          if ($otpsend == false) {
            $getuser = $this->MData->customrow("SELECT *,u.id as user_id from users u INNER JOIN users_role ur ON u.role = ur.id where u.id ='{$ceknomor->id}'");
            if ($getuser->status_role == '0') {
              $this->session->set_flashdata('danger_message', 'Role anda sedang di nonaktifkan , Hub ADMIN');
              redirect('auth', 'refresh');
              exit;
            }
            // Update last login
            $datalastlogin = array('last_login' => date('Y-m-d H:i:s'));
            $this->MData->edit(array('id' => $ceknomor->id), 'users', $datalastlogin);
            //End Update last Login
            $this->session->set_userdata((array)$getuser);
            $this->MThirdApp->getcookie($ceknomor->id, $ceknomor->token_ajax);
            // $this->MThirdApp->getgroupingkandang($ceknomor->id) == false ? $this->MThirdApp->getgroupingkandang($ceknomor->id) : json_encode($this->MThirdApp->getgroupingkandang($ceknomor->id));

            redirect(base_url('main'), 'refresh');
            exit;
          }
          $datatoken = array(
            'token' => $gettoken,
            'user_id' => $ceknomor->id,
            'otp' => $otp,
            'status' => 'login'
          );
          $this->MData->tambah('token', $datatoken);
          // id	token	user_id	otp	status	expired	created
          $data['title'] = 'OTP Verifikasi';
          $data['nomor'] = $number;
          $data['lastnumber'] = substr($number, -4);
          $data['content'] = 'verif';
          $data['token'] = $gettoken;
          $this->session->set_flashdata('success_message', 'Silahkan cek OTP dinomor wa anda');
        } else {
          $this->session->set_flashdata('danger_message', 'Akun anda belum aktif Klik link : ' . "<a href='" . base_url("auth/register/{$number}") . "'>&nbsp;Aktivasi</a>");
          redirect(base_url('auth'), 'refresh');
          exit;
        }
      } else {
        if ($registercheck == true) {
          $data['title'] = 'Register';
          $data['nomor'] = $number;
          $data['content'] = 'login';
          redirect($this->config->item('app_url') . "home/kemitraan/showmessage");
        } else {
          $data['title'] = 'Login';
          $data['nomor'] = $number;
          $data['content'] = 'login';
          redirect($this->config->item('app_url') . "home/kemitraan/showmessage");
        }
      }
    }
    $data['homepage'] = $this->MData->selectdatawhere('web_setting', array('id' => 1))->homepage;
    $this->load->view('main/auth/template', $data);
  }
  public function verifikasi()
  {
    if ($this->input->post()) {
      if ($_POST['token'] == NULL || $_POST['token'] == "") {
        echo json_encode(array('status' => false, 'message' => 'Anda tidak bisa akses url ini'));
        exit;
      } else {
        $otp = implode("", $_POST['otp']);
        $token = $this->input->post('token');
        $cekdatatoken = $this->MData->selectdatawhere('token', array('token' => $token, 'otp' => $otp));
        if ($cekdatatoken !== false) {
          // Cek Type OTP
          $getuser = $this->MData->customrow("SELECT *,u.id as user_id from users u INNER JOIN users_role ur ON u.role = ur.id where u.id ='{$cekdatatoken->user_id}'");
          switch ($cekdatatoken->status) {
            case 'register':
              $dataeditregister = array('status' => 'active', 'last_login' => date('Y-m-d H:i:s'));
              $this->MData->edit(array('id' => $cekdatatoken->user_id), 'users', $dataeditregister);
              $this->session->set_userdata((array)$getuser);
              // $this->MThirdApp->getcookie($cekdatatoken->user_id, $getuser->token_ajax);
              // $this->MThirdApp->getgroupingkandang($cekdatatoken->id) == false ? $this->MThirdApp->getgroupingkandang($cekdatatoken->id) : json_encode($this->MThirdApp->getgroupingkandang($cekdatatoken->id));

              // $this->MThirdApp->getrole() == true ? redirect(base_url("auth/choosemenu/{$this->session->userdata('user_id')}"),'refresh') : NULL;
              redirect(base_url('main'), 'refresh');
              break;

            case 'login':
              // Update last login
              $datalastlogin = ['last_login' => date('Y-m-d H:i:s')];
              $this->MData->edit(['id' => $cekdatatoken->user_id], 'users', $datalastlogin);
              //End Update last Login
              $this->session->set_userdata((array)$getuser);
              // $this->input->set_cookie('user_data', json_encode($getuser), 86500); // 86500 detik = 1 hari
              $cookie_data = array(
                'user_id' => $cekdatatoken->user_id,
                'user_master' => $getuser->user_master,
                'number'   => $getuser->number,
                'role'   => $getuser->role,
                'role_nm'   => $getuser->role_nm,
                'token'   => $getuser->token_ajax,
              );

              // Mengatur cookie dengan nama 'user_data'
              $this->input->set_cookie('user_data', json_encode($cookie_data), 86500); // 86500 detik = 1 hari
              createfilejsoncookie($cekdatatoken->user_id, $getuser);

              // $this->MThirdApp->getcookie($cekdatatoken->user_id, $getuser->token_ajax);
              // $this->MThirdApp->getgroupingkandang($cekdatatoken->id) == false ? $this->MThirdApp->getgroupingkandang($cekdatatoken->id) : json_encode($this->MThirdApp->getgroupingkandang($cekdatatoken->id));

              // if (!$this->session->userdata('number')) {


              // if ($this->MThirdApp->getrole() == true) {
              //   redirect(base_url("auth/choosemenu/{$this->session->userdata('user_id')}"),'refresh');
              //   exit;
              // }
              // Debugging session
              log_message('debug', 'Session Data: ' . print_r($this->session->userdata(), TRUE));
              // Menyimpan data ke dalam cookie

              // Mengatur cookie dengan nama 'user_data'

              redirect(base_url('main'), 'refresh');
              break;
          }
        } else {
          $this->session->set_flashdata('danger_message', 'OTP yang anda masukkan tidak sesuai');
          redirect(base_url('auth'), 'refresh');
        }
      }
    } else {
      redirect(base_url(), 'refresh');
    }
  }
  public function again($number)
  {
    if ($this->input->get()) {
      $mode = $this->input->get('mode');
      if ($mode !== NULL && $mode == 'resend' && $number !== NULL) {
        $ceknumber = $this->MData->selectdatawhere('users', array('number' => $number));
        if ($ceknumber !== FALSE) {
          //Check token by last user id
          $cektoken = $this->MData->customrow("SELECT * FROM token where user_id = '{$ceknumber->id}' order by created DESC LIMIT 1");
          $timecreated = $cektoken->created;
          $timedelay = $this->MData->selectdatawhere('web_setting', array('id' => '1'))->web_otp_delay;
          $expiredtime = date('Y-m-d H:i:s', strtotime("+{$timedelay} minutes", strtotime($timecreated)));
          if (strtotime(date('Y-m-d H:i:s')) > strtotime($expiredtime)) {
            $digits = 4;
            $otp = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
            $message = $this->sendmail->sendotpformat($otp);
            $gettoken = $this->MThirdApp->generatoken(20);
            $otpsend = $this->MThirdApp->sendotpwa1($message, $number, $ceknumber->role);
            $datatoken = array(
              'token' => $gettoken,
              'user_id' => $ceknumber->id,
              'otp' => $otp,
              'status' => 'login'
            );
            $this->MData->tambah('token', $datatoken);
            $data['title'] = 'OTP Verifikasi';
            $data['nomor'] = $number;
            $data['lastnumber'] = substr($number, -4);
            $data['content'] = 'verif';
            $data['token'] = $gettoken;
            $this->session->set_flashdata('success_message', 'Silahkan cek OTP dinomor wa anda');
          } else {
            $data['title'] = 'OTP Verifikasi';
            $data['nomor'] = $number;
            $data['lastnumber'] = substr($number, -4);
            $data['content'] = 'verif';
            $data['token'] = $cektoken->token;
            $data['timer'] = strtotime($expiredtime) - strtotime(date('Y-m-d H:i:s'));
            $this->session->set_flashdata('danger_message', 'Waktu otp belum berakhir');
          }
          $this->load->view('main/auth/template', $data);
        }
      }
    }
  }
  public function register($number = NULL)
  {
    if ($number == NULL) {
      if ($this->input->post()) {
        $number = $this->input->post('number');
        $_POST['token_ajax'] = $this->MThirdApp->generatetoken($number);
        // Cek Apakah akun pernah di ban?
        $searchakun = $this->MData->selectdatawhere('users', array('number' => $number));
        if ($searchakun !== FALSE) {
          $this->session->set_flashdata('danger_message', 'Nomor yang anda gunakan sudah terdaftar. Gunakan nomor lain');
          redirect(base_url('auth'), 'refresh');
          exit;
        }
        $get_id = $this->MData->tambah('users', $this->input->post());
        $this->MThirdApp->syncusersetting();
        $digits = 4;
        $otp = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
        $message = $this->sendmail->sendotpformat($otp);
        $gettoken = $this->MThirdApp->generatoken(20);
        $otpsend = $this->MThirdApp->sendotpwa1($message, $number, '4');
        if ($otpsend == false) {
          $ceknomor = $this->MData->selectdatawhere('users', array('number' => $number));
          // Pasti ada karena baru disimpan
          $getuser = $this->MData->customrow("SELECT *,u.id as user_id from users u INNER JOIN users_role ur ON u.role = ur.id where u.id ='{$ceknomor->id}'");
          if ($getuser->status_role == '0') {
            $this->session->set_flashdata('danger_message', 'Role anda sedang di nonaktifkan , Hub ADMIN');
            redirect('auth', 'refresh');
            exit;
          }
          // Update last login
          $datalastlogin = array('status' => 'active', 'last_login' => date('Y-m-d H:i:s'));
          $this->MData->edit(array('id' => $ceknomor->id), 'users', $datalastlogin);
          //End Update last Login
          $this->session->set_userdata((array)$getuser);
          $this->MThirdApp->getcookie($ceknomor->id, $ceknomor->token_ajax);
          // $this->MThirdApp->getgroupingkandang($ceknomor->id) == false ? $this->MThirdApp->getgroupingkandang($ceknomor->id) : json_encode($this->MThirdApp->getgroupingkandang($ceknomor->id));

          // $this->MThirdApp->getrole() == true ? redirect(base_url("auth/choosemenu/{$this->session->userdata('user_id')}"),'refresh') : NULL;
          redirect(base_url('main'), 'refresh');
          exit;
        }
        $datatoken = array(
          'token' => $gettoken,
          'user_id' => $get_id,
          'otp' => $otp,
          'status' => 'register'
        );
        $this->MData->tambah('token', $datatoken);
        // id	token	user_id	otp	status	expired	created
        $data['title'] = 'OTP Verifikasi';
        $data['nomor'] = $number;
        $data['lastnumber'] = substr($number, -4);
        $data['content'] = 'verif';
        $data['token'] = $gettoken;
        $this->session->set_flashdata('success_message', 'Silahkan cek OTP dinomor wa anda');
        $this->load->view('mobile/auth/template', $data);
      } else {
        redirect(base_url('auth'), 'refresh');
      }
    } else {
      $checkdata = $this->MData->selectdatawhere('users', array('number' => $number, 'status' => 'pending'));
      if ($checkdata !== false) {
        $digits = 4;
        $otp = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
        $message = $this->sendmail->sendotpformat($otp);
        $gettoken = $this->MThirdApp->generatoken(20);
        $otpsend = $this->MThirdApp->sendotpwa1($message, $number, $checkdata->role);
        $datatoken = array(
          'token' => $gettoken,
          'user_id' => $checkdata->id,
          'otp' => $otp,
          'status' => 'register'
        );
        $this->MData->tambah('token', $datatoken);
        // id	token	user_id	otp	status	expired	created
        $data['title'] = 'OTP Verifikasi';
        $data['nomor'] = $number;
        $data['content'] = 'verif';
        $data['token'] = $gettoken;
        $this->session->set_flashdata('success_message', 'Silahkan cek OTP dinomor wa anda');
        $this->load->view('mobile/auth/template', $data);
      } else {
        $this->session->set_flashdata('danger_message', 'Nomor tidak sesuai / Sudah aktif, Coba login kembali');
        redirect(base_url('auth'), 'refresh');
      }
    }
  }
  public function choosemenu($id = NULL)
  {
    if ($id == NULL) {
      redirect(base_url('auth'), 'refresh');
      exit;
    }
    if ($this->MThirdApp->getrole() !== true) {
      redirect(base_url('auth'), 'refresh');
      exit;
    }
    $data = array(
      'title' => 'Choose Menu',
      'content' => 'choose'
    );
    $this->load->view('mobile/auth/template', $data);
  }
  public function logout()
  {
    $cookiex = getcookienya('user_data');
    $idx = $cookiex['user_id'];
    $this->MData->edit(['id' => $idx], 'users', ['token_fcm' => NULL]);
    $this->session->sess_destroy();
    $datacookie = isset($_COOKIE['uuid']) ? $_COOKIE['uuid'] : NULL;
    $dataupdate = array(
      'status' => 'logout',
      'expired_at' => date('Y-m-d H:i:s')
    );
    $datacookie == NULL ? NULL : $this->MData->edit(array('uuid' => $datacookie), 'cookies', $dataupdate);
    deletefilejsoncookie($idx, 'datauser');
    deletefilejsoncookie($idx, 'datakandang');
    deletefilejsoncookie($idx, 'datagroupingkandang');
    $this->output->delete_cache();
    destroycookie();
    delete_cookie('uuid');
    redirect(base_url('auth'), 'refresh');
  }
}
