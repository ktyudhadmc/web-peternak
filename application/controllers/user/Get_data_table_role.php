<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Get_data_table_role extends CI_Controller
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
        $role = $_POST['role'];
        $urf = "(SELECT id from users_role_access WHERE id_navbar = c.id and id_role = {$role} and type_role = 'function' and is_main = 1)";
        $getdatarole = $this->MData->customresult("SELECT
                                                  {$role} as id_role,
                                              	  (SELECT role_nm from users_role where id = {$role}) as role_nm,
                                              	  a.name as name_navbar,
                                                  b.id as ura,
                                                  c.id as idc,
                                                  {$urf} as urf,
                                                  a.is_master,
                                                  if(b.id IS NOT NULL and {$urf} IS NOT NULL,1,0) as status,
                                                  ifnull((SELECT name from web_navbar WHERE id = a.master_id),'-') as master,
                                                  a.id as id_navbar,
                                                  a.is_developt
                                              FROM web_navbar as a
                                              LEFT join users_role_access as b on b.id_navbar = a.id and b.id_role = {$role} and b.type_role = 'navbar' and b.is_main = 1
                                              LEFT join users_role_function as c on a.variable = c.nama_layanan
                                              Where a.is_main = 1 ORDER BY `a`.`id` ASC");
        echo json_encode($getdatarole);
    }
}
