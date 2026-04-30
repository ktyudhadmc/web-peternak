<?php

defined('BASEPATH') or exit('No direct script access allowed');
Sentry\init(['dsn' => 'https://4dba7b441a7ff5576bdc44cf8098b987@o4504875505483776.ingest.sentry.io/4506318591950848']);
class Stock_general extends CI_Controller
{

  public $cookiex;
  public function __construct()
  {
    parent::__construct();
    $this->load->model('MData');
    $this->load->model('MThirdApp');
    $this->MThirdApp->checksession();
    $this->load->library('Dummy');
    $this->cookiex = getcookienya('user_data');
  }

  public function index()
  {
    $id_user = $this->cookiex['user_id'];
    $getdatauser = $this->MData->customresult("SELECT * FROM `kandang` LEFT JOIN users as a on kandang.user_id = a.id where stock = 'lokasi' GROUP by user_id ORDER BY `a`.`first_name` ASC");
    $data = array(
      'title' => 'Manajemen Stock General',
      'content' => 'stock_general',
      'getdatauser' => $getdatauser,
    );
    $this->load->view('main/template', $data);
  }
  public function get_data_pemakaian_pakan()
  {
    $id_user = $_POST['id_user'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_akhir = $_POST['tanggal_akhir'];
    $querykonsumsipakan = "SELECT
    c.nama,
    a.id_kandang,
    a.periode,
    sum(a.qty) as qty,
    b.brand
    FROM `kandang_activity_log_sapronak` as a
    LEFT JOIN general as b on b.id = a.id_this
    LEFT JOIN kandang as c on c.id = a.id_kandang
    where a.id_kandang in (SELECT id from kandang WHERE user_id = '{$id_user}' and stock = 'lokasi') and a.tanggal_kandang_activity_log BETWEEN '{$tanggal_mulai}' and '{$tanggal_akhir}' and type_sapronak = 'general' and method_sapronak = 'use'
    GROUP by a.id_this,a.id_kandang,a.periode
    ORDER BY `b`.`brand` ASC";
    $getdatakonsumsipakan = $this->MData->customresult($querykonsumsipakan);
    echo json_encode($getdatakonsumsipakan);
  }
  public function get_data_stock_pakan()
  {
    $id_user = $_POST['id_user'];
    $tanggal_akhir = $_POST['tanggal_akhir'];
    $stock_in = "IFNULL((SELECT SUM(qty) AS tot_qty FROM `kandang_activity_stock` WHERE tanggal <= '{$tanggal_akhir}' and method_stock = 'in' and type_stock = 'general' AND id_user = '{$id_user}' AND id_this = b.id),0)";
    $stock_mutasi = "IFNULL((SELECT SUM(qty) AS tot_qty FROM `kandang_activity_stock` WHERE tanggal <= '{$tanggal_akhir}' and method_stock = 'out' and type_stock = 'general' AND id_user_to = '{$id_user}' AND id_this = b.id),0)";
    $stock_out = "IFNULL((SELECT SUM(qty) AS tot_qty FROM `kandang_activity_stock` WHERE tanggal <= '{$tanggal_akhir}' and method_stock = 'out' and type_stock = 'general' AND id_user = '{$id_user}' AND id_this = b.id),0)";
    $querystockpakan = "SELECT
    IFNULL(SUM(a.qty),0) AS tot_qty_use,
    {$stock_in} AS tot_qty_in,
    {$stock_out} AS tot_qty_out,
    {$stock_mutasi} AS tot_qty_mutasi,
    {$stock_in} + {$stock_mutasi} - {$stock_out} - IFNULL(SUM(a.qty),0) AS stock,
    b.brand
    FROM
    general AS b
    LEFT JOIN `kandang_activity_log_sapronak` AS a ON b.id = a.id_this and a.id_kandang IN (SELECT id FROM kandang WHERE user_id = '{$id_user}' and stock = 'lokasi') AND a.type_sapronak = 'general' AND a.method_sapronak = 'use' and a.tanggal_kandang_activity_log <= '{$tanggal_akhir}'
    GROUP BY
    b.id
    ORDER BY `b`.`brand` ASC";
    $getdatastockpakan = $this->MData->customresult($querystockpakan);
    echo json_encode($getdatastockpakan);
  }
  public function get_data_kedatangan_pakan()
  {
    $id_user = $_POST['id_user'];
    $queryinpakan = "SELECT a.tanggal, a.id, a.qty, b.brand, a.ket, a.id_this, a.id_user_to, c.first_name as lokasi
    FROM `kandang_activity_stock` as a
    LEFT JOIN general as b on a.id_this = b.id
    LEFT JOIN users as c on a.id_user = c.id
    WHERE id_user = '{$id_user}' and type_stock = 'general' and method_stock = 'in' or id_user_to = '{$id_user}' and type_stock = 'general'";
    $getdatainpakan = $this->MData->customresult($queryinpakan);
    echo json_encode($getdatainpakan);
  }
  public function get_data_mutasi_pakan()
  {
    $id_user = $_POST['id_user'];
    $querymutasipakan = "SELECT a.tanggal, a.id, a.qty, b.brand, a.ket, a.id_this, a.id_user_to, c.first_name, d.first_name as lokasi_dari
    FROM `kandang_activity_stock` as a
    LEFT JOIN general as b on a.id_this = b.id
    LEFT JOIN users as c on a.id_user_to = c.id
    LEFT JOIN users as d on a.id_user = d.id
    WHERE id_user = '{$id_user}' and type_stock = 'general' and method_stock = 'out'";
    $getdatamutasipakan = $this->MData->customresult($querymutasipakan);
    echo json_encode($getdatamutasipakan);
  }
  public function get_data_general()
  {
    $getdatapakan = $this->MData->customresult("SELECT * from `general` order by id desc");
    echo json_encode($getdatapakan);
  }
  public function add_pakan()
  {
    $data_input['input']['brand'] = $_POST['brand'];
    $data_input['input']['satuan'] = $_POST['satuan'];
    $checkdata = $this->MData->customresult("SELECT * from general where brand = '{$data_input['input']['brand']}'");
    if ($data_input['input']['brand'] != "") {
      if (!$checkdata) {
        $this->MData->tambah('general', $data_input['input']);
        $status = 'success';
      } else {
        $status = 'error';
      }
    } else {
      $status = 'error';
    }
    $result = array(
      "status" => $status,
      "brand" => $data_input['input']['brand'],
    );
    echo json_encode($result);
  }
  public function add_kedatangan_pakan()
  {
    $data_input['input']['id_user'] = $_POST['id_lokasi'];
    $data_input['input']['id_this'] = $_POST['id_pakan'];
    $data_input['input']['tanggal'] = $_POST['tanggal'];
    $data_input['input']['qty'] = $_POST['quantity'];
    $data_input['input']['ket'] = $_POST['keterangan'];
    $data_input['input']['method_stock'] = 'in';
    $data_input['input']['type_stock'] = 'general';
    if ($data_input['input']['id_user'] != "0" && $data_input['input']['qty'] != "0" && $data_input['input']['id_this'] != "0") {
      $this->MData->tambah('kandang_activity_stock', $data_input['input']);
      $status = 'success';
    } else {
      $status = 'error';
    }
    $result = array(
      "status" => $status,
    );
    echo json_encode($result);
  }
  public function delete_kedatangan_pakan()
  {
    $id = $_POST['id'];
    if ($id != "0") {
      $this->MData->delete('kandang_activity_stock', array('id' => $id));
      $status = 'success';
    } else {
      $status = 'error';
    }
    $result = array(
      "status" => $status,
    );
    echo json_encode($result);
  }
  public function add_mutasi_pakan()
  {

    $data_input['input']['id_this'] = $_POST['id_pakan'];
    $data_input['input']['tanggal'] = $_POST['tanggal'];
    $data_input['input']['qty'] = $_POST['quantity'];
    $data_input['input']['id_user'] = $_POST['id_lokasi_dari'];
    $data_input['input']['id_user_to'] = $_POST['id_lokasi_tujuan'];
    $data_input['input']['type_stock'] = 'general';
    $lokasi_dari = $this->MData->customrow("SELECT first_name FROM `users` where id = '{$_POST['id_lokasi_dari']}'");
    $lokasi_tujuan = $this->MData->customrow("SELECT first_name FROM `users` where id = '{$_POST['id_lokasi_tujuan']}'");


    if ($data_input['input']['id_user'] != "0" && $data_input['input']['qty'] != "0" && $data_input['input']['id_this'] != "0" && $data_input['input']['id_user_to'] != "0") {

      $data_input['input']['method_stock'] = 'out';
      $data_input['input']['ket'] = "Mutasi ke {$lokasi_tujuan->first_name}";
      $this->MData->tambah('kandang_activity_stock', $data_input['input']);
      // $data_input['input']['id_user'] = $_POST['id_lokasi_tujuan'];
      // $data_input['input']['id_user_to'] = $_POST['id_lokasi_dari'];
      // $data_input['input']['method_stock'] = 'in';
      // $data_input['input']['ket'] = "Mutasi dari {$lokasi_dari->first_name}";
      // $this->MData->tambah('kandang_activity_stock', $data_input['input']);
      $status = 'success';
    } else {
      $status = 'error';
    }
    $result = array(
      "status" => $status,
    );
    echo json_encode($result);
  }
  public function edit_kedatangan_pakan()
  {
    $id = $_POST['id'];
    $data_input['input']['id_this'] = $_POST['id_pakan'];
    $data_input['input']['tanggal'] = $_POST['tanggal'];
    $data_input['input']['qty'] = $_POST['quantity'];
    $data_input['input']['ket'] = $_POST['keterangan'];
    $data_input['input']['method_stock'] = 'in';
    $data_input['input']['type_stock'] = 'general';
    if ($id != "0" && $data_input['input']['qty'] != "0" && $data_input['input']['id_this'] != "0") {
      // $this->MData->tambah('kandang_activity_stock', $data_input['input']);
      $this->MData->edit(array('id' => $id), 'kandang_activity_stock', $data_input['input']);
      $status = 'success';
    } else {
      $status = 'error';
    }
    $result = array(
      "status" => $status,
    );
    echo json_encode($result);
  }
  public function edit_mutasi_pakan()
  {

    $id = $_POST['id'];
    $lokasi_dari = $_POST['lokasi_dari'];
    $lokasi_tujuan = $this->MData->customrow("SELECT first_name FROM `users` where id = '{$_POST['id_user_to']}'");
    $checkdata = $this->MData->customrow("SELECT `id_user` as id_user_to, `tanggal`,  `type_stock`, `id_this`, `qty`, `id_user_to` as id_user from kandang_activity_stock where id = '{$id}'");

    if ($checkdata) {
      $data_input['input']['id_this'] = $_POST['id_pakan'];
      $data_input['input']['tanggal'] = $_POST['tanggal'];
      $data_input['input']['qty'] = $_POST['quantity'];
      $data_input['input']['id_user_to'] = $_POST['id_user_to'];
      $data_input['input']['method_stock'] = 'out';
      $data_input['input']['type_stock'] = 'general';
      $data_input['input']['ket'] = "Mutasi ke {$lokasi_tujuan->first_name}";
      $this->MData->edit(array('id' => $id), 'kandang_activity_stock', $data_input['input']);
      // $data_input['input2']['id_this'] = $_POST['id_pakan'];
      // $data_input['input2']['tanggal'] = $_POST['tanggal'];
      // $data_input['input2']['qty'] = $_POST['quantity'];
      // $data_input['input2']['id_user'] = $_POST['id_user_to'];
      // $data_input['input2']['method_stock'] = 'in';
      // $data_input['input2']['type_stock'] = 'pakan';
      // $data_input['input2']['ket'] = "Mutasi dari {$lokasi_dari}";
      // $this->MData->edit(array('id' => $checkdatamutasi->id), 'kandang_activity_stock', $data_input['input2']);
      $status = 'success';
    } else {
      $status = 'error';
    }
    // $status = 'success';
    $result = array(
      "status" => $status,
    );
    echo json_encode($result);
  }
  public function edit_jenis_general()
  {
    $id = $_POST['id'];
    $data_input['input']['brand'] = $_POST['brand'];
    $data_input['input']['satuan'] = $_POST['satuan'];
    if ($id != "0" && $data_input['input']['brand'] != "") {
      $this->MData->edit(array('id' => $id), 'general', $data_input['input']);
      $status = 'success';
    } else {
      $status = 'error';
    }
    // $status = 'success';
    $result = array(
      "status" => $status,
    );
    echo json_encode($result);
  }
}

/* End of file Stock_pakan.php */
