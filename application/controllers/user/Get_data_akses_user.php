<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Get_data_akses_user extends CI_Controller
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
    $queryaksesuser = "SELECT
    a.id,
    concat(a.first_name,' ',a.last_name) as nama,
    b.nama as nama_kandang,
    c.first_name as lokasi,
    b.id as b_id,
    b.user_id_sharing
    FROM `users` as a
    left join kandang as b on FIND_IN_SET(a.id, b.user_id_sharing)  and b.status_kandang not in ('DELETE')
    left join users as c on b.user_id = c.id
    where concat(a.first_name,' ',a.last_name) is not NULL
    ORDER BY `nama`,b.nama  ASC";
    $dataaksesuser = $this->MData->customresult($queryaksesuser);
    echo json_encode($dataaksesuser);
  }
  public function notifwanumber()
  {
    $querynotifwanumber = "SELECT a.*,
    CASE a.type_number WHEN 'number' THEN concat(b.first_name,' ',b.last_name) ELSE d.nama END as nama,
    c.first_name as lokasi
    FROM `web_notif_sendto` as a
    left join users as b on a.number = b.number
    left join groups_number as d on a.number = d.number
    left join users as c on a.id_user = c.id";
    $datanotifwanumber = $this->MData->customresult($querynotifwanumber);
    echo json_encode($datanotifwanumber);
  }
  public function updatenotifwanumber()
  {
    $id = $_POST['id'];
    $fitur = $_POST['fitur'];
    if (isset($_POST["id"])) {
      if ($fitur == 'aktif') {
        $this->MData->edit(array('id' => $id), 'web_notif_sendto', array('status' => '1'));
        $status = 'success';
        $comment = 'Data berhasil diupdate';
      } else {
        $this->MData->edit(array('id' => $id), 'web_notif_sendto', array('status' => '0'));
        $status = 'success';
        $comment = 'Data berhasil diupdate';
      }
    } else {
      $status = 'error';
      $comment = 'Gagal update Data';
    }
    $result = array(
      "status" => $status,
      "comment" => $comment,
    );
    echo json_encode($result);
  }
  public function add_number_notif_wa()
  {
    if ($this->input->post()) {
      $get_id = $this->MData->tambah('web_notif_sendto', $this->input->post());
      $status = 'success';
      $comment = 'Data berhasil diupdate';
    } else {
      $status = 'error';
      $comment = 'Gagal update Data';
    }
    $result = array(
      "status" => $status,
      "comment" => $comment,
    );
    echo json_encode($result);
  }
  public function deleteuseridsharing()
  {
    if ($this->input->post('b_id')) {
      $b_id = $this->input->post('b_id');
      $id_user = $this->input->post('id_user');
      $query_get = "Select user_id_sharing from kandang where id = '{$b_id}'";
      $data_get = $this->MData->customrow($query_get);
      $dataarray = explode(",", $data_get->user_id_sharing);
      $lenght =  count($dataarray);
      for ($x = 0; $x < $lenght; $x++) {
        if ($dataarray[$x] != $id_user) {
          $id_user_sharing_array[] = $dataarray[$x];
        }
      }
      $id_user_sharing_update = implode(',', $id_user_sharing_array);
      $this->MData->edit(array('id' => $b_id), 'kandang', array('user_id_sharing' => $id_user_sharing_update));
      $status = 'success';
      $comment = 'Data berhasil diupdate';
    } else {
      $status = 'error';
      $comment = 'Gagal update Data';
    }


    $result = array(
      "status" => $status,
      "comment" => $comment,
    );
    echo json_encode($result);
  }
}
