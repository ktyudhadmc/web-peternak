<?php
$cookiex = getcookienya('user_data');
?>
<div id="kt_aside" class="aside aside-light aside-hoverable drawer drawer-start" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <div class="aside-logo flex-column-auto" id="kt_aside_logo">
        <a href="<?= base_url() ?>">
            <center>
                <img alt="Logo" src="<?= $this->config->item('app_url') ?>assets/resource/favicon/longbanner.png" class="h-30px logo" /> &nbsp;
            </center>
        </a>
        <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="aside-minimize">
            <span class="svg-icon svg-icon-1 rotate-180">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path opacity="0.5" d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z" fill="currentColor" />
                    <path d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z" fill="currentColor" />
                </svg>
            </span>
        </div>
    </div>
    <div class="aside-menu flex-column-fluid text-white " style="font-size: 11px;">
        <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0">
            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true" data-kt-menu-expand="false">
                <div class="menu-item">
                    <a class="menu-link <?= $this->uri->segment(1) == NULL ? "active" : NULL ?>" href="<?= base_url() ?>">
                        <span class="menu-icon">
                            <i class="fas fa-tachometer-alt fa-lg"></i>
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </div>
                <?php
                $getrole = $this->db->order_by("priority", "desc")->where(array('id_role' => $cookiex['role'], 'type_role' => 'navbar', 'is_main' => 1))
                    ->get('users_role_access')
                    ->result();

                if ($getrole > 0) {
                    //Dapat Role
                    $showparrent = false;
                    foreach ($getrole as $getroles) {
                        $navbars = $this->db->order_by("created_at", "asc")->where(array('is_main' => '1', 'is_developt' => '0', 'id' => $getroles->id_navbar))->get('web_navbar')->row();
                        if ($navbars !== NULL) {
                            if ($navbars->is_master == '1') {
                                if ($navbars->name !== "Ternak") {
                                    if ($navbars->singlemaster == 1) {
                                        $dowaiting = $navbars->dowaiting == 1 ? 'onclick="dowaiting(this); return false;"' : NULL;
                                        $iconnya = $navbars->icon !== "#" ? "<i class='{$navbars->icon} fa-lg'></i>" : "<img src='{$navbars->file_icon}' width=24>";
                                        $getstatusmaster = $this->db->order_by("created_at", "asc")->like('link', $this->uri->segment(2))->where(array('is_main' => '1', 'master_id' => $navbars->id, 'is_developt' => '0'))->get('web_navbar')->result();
                                        $showparrent = count($getstatusmaster) > 0  && $this->uri->segment(2) !== NULL ? true : false;
                                        $showparrentshow = $showparrent == true ? "here show" : NULL;
                                        $status_active = $this->uri->segment(1) . "/" . $this->uri->segment(2) == $navbars->link ? "active" : NULL;
                                        // Navbar Main
                                        echo "<div class='menu-item {$showparrentshow}'>
                                                <a class='menu-link {$status_active}' href='" . base_url() . "{$navbars->link}' {$dowaiting}>
                                                    <span class='menu-icon'>
                                                        {$iconnya} 
                                                    </span>
                                                    <span class='menu-title'>{$navbars->name}</span>
                                                </a>
                                              </div>\n";
                                    } else {
                                        $navoutput = array();
                                        $datauri = NULL;
                                        $showmaster = FALSE;
                                        // $getchild = $this->db->order_by("created_at", "asc")->where(array('is_main' => '1', 'master_id' => $navbars->id, 'is_developt' => '0'))->get('web_navbar')->result();
                                        $getchild = $this->MData->customresult("SELECT a.* FROM `web_navbar` a left JOIN users_role_access b on b.id_navbar = a.id where a.is_main = 1 and a.is_developt = 0 and a.master_id = {$navbars->id} and b.id_role = {$cookiex['role']} and b.type_role = 'navbar'");
                                        if (is_array($getchild) || is_object($getchild)) {
                                            foreach ($getchild as $getchilds) {
                                                $queryvalidariraw = "SELECT (SELECT id from users_role_function where nama_layanan = b.variable) as id_urf from users_role_access ura LEFT JOIN web_navbar b ON ura.id_navbar = b.id WHERE  ura.id_navbar = {$getchilds->id} ORDER BY b.created_at DESC";
                                                $queryvalidasi = $this->db->query($queryvalidariraw);
                                                if ($queryvalidasi->num_rows() > 0) {
                                                    if (isset($queryvalidasi->row()->id_urf)  && $queryvalidasi->row()->id_urf !== NULL) {
                                                        $showmaster = TRUE;
                                                        $linkchild = base_url($getchilds->link);
                                                        $dowaiting = $getchilds->dowaiting == 1 ? 'onclick="dowaiting(this); return false;"' : NULL;
                                                        $datauri[] = $linkchild;
                                                        $statuschild =  current_url() == $linkchild ? 'active' : '';
                                                        // echo json_encode($getchilds);
                                                        $navoutput[] = "
                                                                        <div class='menu-item'>
                                                                        <a class='menu-link $statuschild' href='{$linkchild}' {$dowaiting}>
                                                                            <span class='menu-bullet'>
                                                                            <span class='bullet bullet-dot'></span>
                                                                            </span>
                                                                            <span class='menu-title'>{$getchilds->name}</span>
                                                                        </a>
                                                                        </div>";
                                                    }
                                                }
                                            }
                                            if ($showmaster == TRUE) {
                                                $childoutput = "\n" . implode("", $navoutput);
                                                $getstatusmaster = $this->db->order_by("created_at", "asc")->like('link', $this->uri->segment(2))->where(array('is_main' => '1', 'master_id' => $navbars->id, 'is_developt' => '0'))->get('web_navbar')->result();
                                                // exit;
                                                $showparrent = count($getstatusmaster) > 0  && $this->uri->segment(2) !== NULL ? true : false;
                                                $showparrentshow = $showparrent == true ? "here show" : NULL;
                                                $iconnya = $navbars->icon !== "#" ? "<i class='{$navbars->icon} fa-lg'></i>" : "<img src='{$navbars->file_icon}' width=24>";
                                                echo "
                                                <div data-kt-menu-trigger='click' class='menu-item {$showparrentshow} menu-accordion'>
                                                    <span class='menu-link'>
                                                        <span class='menu-icon'>
                                                                {$iconnya}
                                                        </span>
                                                        <span class='menu-title'>{$navbars->name}</span>
                                                        <span class='menu-arrow'></span>
                                                    </span>
                                                    <div class='menu-sub menu-sub-accordion' kt-hidden-height='108' style=''>
                                                        {$childoutput}
                                                    </div>
                                                </div>
                                                \n";
                                            }
                                        }
                                    }
                                } else {
                                    $getstatusmaster = $this->db->order_by("created_at", "asc")->like('link', $this->uri->segment(2))->where(array('is_main' => '1', 'master_id' => $navbars->id, 'is_developt' => '0'))->get('web_navbar')->result();
                                    $showparrent = count($getstatusmaster) > 0  && $this->uri->segment(2) !== NULL ? true : false;
                                    $showparrentshow = $showparrent == true ? "here show" : NULL;

                                    $iconnya = $navbars->icon !== "#" ? "<i class='{$navbars->icon} fa-lg'></i>" : "<img src='{$navbars->file_icon}' width=24>";
                                    $listview = NULL;
                                    $triggerclick = NULL;
                                    $classacordion = NULL;
                                    // $readdatagroupingkandang = readfilejsoncookie("datagroupingkandang" . $cookiex['user_id']);
                                    $readdatagroupingkandang = $globalGroupingKandang;
                                    if (is_array($readdatagroupingkandang)) {
                                        $triggerclick = "data-kt-menu-trigger='click'";
                                        $classacordion = "menu-accordion";
                                        $arr = array();
                                        // foreach ($datagroupingkandang as $datagroupingkandangs) {
                                        //     $arr['first_name'][] = $datagroupingkandangs->nama_user . "-" . $datagroupingkandangs->id_kandang . "-" . $datagroupingkandangs->nama;
                                        // }
                                        $iduserlast = 0;
                                        $i = 0;
                                        $submenuoutputchild = array();

                                        // foreach ($arr['first_name'] as $key => $arrs) {
                                        foreach ($readdatagroupingkandang as $arrs) {
                                            // $explodearr = explode("-", $arrs);
                                            $parentcode = NULL;
                                            $i++;
                                            if ($iduserlast != $arrs['nama_user']) {
                                                $finalsubmenuoutputchild = implode("", $submenuoutputchild);
                                                $dataoutputchild[] = "<div data-kt-menu-trigger='click' class='menu-item menu-accordion {$parentcode}'>
                                                                        <span class='menu-link'>
                                                                            <span class='menu-bullet'>
                                                                                <span <i class='fas fa-door-open'></i></span>
                                                                            </span>
                                                                            <span class='menu-title'>{$iduserlast}</span>
                                                                            <span class='menu-arrow'></span>
                                                                        </span>
                                                                        <div class='menu-sub menu-sub-accordion menu-active-bg'>
                                                                        {$finalsubmenuoutputchild}
                                                                        </div>
                                                                    </div>";
                                                $submenuoutputchild = array();
                                                // $getlastperiode = $this->db->query("SELECT periode, status_kandang_activity from kandang_activity where id_kandang = '{ $arrs['id_kandang']}' ORDER BY tanggal_mulai DESC limit 1")->row();
                                                $periodenih = $arrs['periode'] == NULL ? NULL : $arrs['periode'];
                                                if ($this->uri->segment(5) == $arrs['id_kandang']) {
                                                    $parentcode = "here show";
                                                }
                                                $parentcodechild = $this->uri->segment(5) ==  $arrs['id_kandang'] ? "here show" : NULL;
                                                if ($periodenih !== NULL) {
                                                    $link = "href='" . base_url('main/ternak/detail/aktif/' .  $arrs['id_kandang'] . '/' . $periodenih) . "'";
                                                } else {
                                                    $link = "href='#' onclick ='notifalert(`Error`,`Periode tidak ada untuk kandang ini`, `error`);  return false;'";
                                                }
                                                $statuskandang = isset($arrs['status_kandang_activity']) && $arrs['status_kandang_activity'] == "AKTIF" ? "<span class='badge badge-light-success me-auto'>AKTIF</span>" : "<span class='badge badge-light-danger me-auto'>CLOSE</span>";
                                                $submenuoutputchild[] = "<div class='menu-item {$parentcodechild}'>
                                                                                <!--<a class='menu-link' href='" . base_url('main/ternak/view/' . $arrs['nama_user']) . "'>-->
                                                                                <a class='menu-link' {$link}>
                                                                                    <span class='menu-bullet'>
                                                                                        <span class='bullet bullet-dot'></span>
                                                                                    </span>
                                                                                    <span class='menu-title'>{$arrs['nama']}</span>
                                                                                    {$statuskandang}
                                                                                </a>
                                                                            </div>";
                                            } else if ($iduserlast == $arrs['nama_user']) {
                                                // $getlastperiode = $this->db->query("SELECT periode, status_kandang_activity from kandang_activity where id_kandang = '{ $arrs['id_kandang']}' ORDER BY tanggal_mulai DESC limit 1")->row();
                                                $periodenih = $arrs['periode'] == NULL ? NULL : $arrs['periode'];
                                                if ($this->uri->segment(5) ==  $arrs['id_kandang']) {
                                                    $parentcode = "here show";
                                                }
                                                $parentcodechild = $this->uri->segment(5) ==  $arrs['id_kandang'] ? "here show" : NULL;
                                                if ($periodenih !== NULL) {
                                                    $link = "href='" . base_url('main/ternak/detail/aktif/' .  $arrs['id_kandang'] . '/' . $periodenih) . "'";
                                                } else {
                                                    $link = "href='#' onclick ='notifalert(`Error`,`Periode tidak ada untuk kandang ini`, `error`);  return false;'";
                                                }
                                                $statuskandang = isset($arrs['status_kandang_activity']) && $arrs['status_kandang_activity'] == "AKTIF" ? "<span class='badge badge-light-success me-auto'>AKTIF</span>" : "<span class='badge badge-light-danger me-auto'>CLOSE</span>";
                                                $submenuoutputchild[] = "<div class='menu-item {$parentcodechild}'>
                                                                                <!--<a class='menu-link' href='" . base_url('main/ternak/view/' . $arrs['nama_user']) . "'>-->
                                                                                <a class='menu-link' {$link}>
                                                                                    <span class='menu-bullet'>
                                                                                        <span class='bullet bullet-dot'></span>
                                                                                    </span>
                                                                                    <span class='menu-title'>{$arrs['nama']}</span>
                                                                                    {$statuskandang}
                                                                                </a>
                                                                            </div>";
                                                // $getkandang = $this->db->query("select * from kandang where user_id = { $arrs['id_kandang']} and status_kandang not in ('delete')")->result();
                                                // foreach ($getkandang as $getkandangs) {
                                                // }
                                            }
                                            $iduserlast = $arrs['nama_user'];
                                        }
                                        $finalsubmenuoutputchild = implode("", $submenuoutputchild);
                                        $dataoutputchild[] = "<div data-kt-menu-trigger='click' class='menu-item menu-accordion {$parentcode}'>
                                                                        <span class='menu-link'>
                                                                            <span class='menu-bullet'>
                                                                                <span <i class='fas fa-door-open'></i></span>
                                                                            </span>
                                                                            <span class='menu-title'>{$iduserlast}</span>
                                                                            <span class='menu-arrow'></span>
                                                                        </span>
                                                                        <div class='menu-sub menu-sub-accordion menu-active-bg'>
                                                                        {$finalsubmenuoutputchild}
                                                                        </div>
                                                                    </div>";
                                        $listview = implode("", $dataoutputchild);
                                        // unset($dataoutputchild);
                                    }
                                    echo "
                                    <div {$triggerclick} class='menu-item {$classacordion} {$showparrentshow}'>
                                                <span class='menu-link'>
                                                    <span class='menu-icon'>
                                                        {$iconnya}
                                                    </span>
                                                    <span class='menu-title'>{$navbars->name}</span>
                                                    <span class='menu-arrow'></span>
                                                </span>
                                                <div class='menu-sub menu-sub-accordion' kt-hidden-height='108' style=''>
                                                {$listview}      
                                                </div>
                                    </div>
                                    <div class='menu-item'>
                                        <a class='menu-link' href='#' onclick='modaltambahternakshow();  return false;'>
                                            <span class='menu-bullet'>
                                                <span class='bullet bullet-dot'></span>
                                                </span>
                                            <span class='menu-title'>Tambah Ternak</span>
                                        </a>
                                    </div>";
                                }
                            }
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">