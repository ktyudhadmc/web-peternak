<style>
    .dataTables_wrapper {
        /*font-family: tahoma;*/
        font-size: 10px;
        /*position: relative;*/
        /*clear: both;*/
        /**zoom: 1;*/
        /*zoom: 1;*/
    }
</style>
<script>
    var flashdata_status = '';
    var flashdata_message = '';
</script>
<?php
if ($this->session->flashdata('success_message')) {
?>
    <script>
        var flashdata_status = 'success';
        var flashdata_message = '<?= $this->session->flashdata('success_message') ?>';
    </script>
<?php } elseif ($this->session->flashdata('danger_message')) { ?>
    <script>
        var flashdata_status = 'error';
        var flashdata_message = '<?= $this->session->flashdata('danger_message') ?>';
    </script>
<?php } ?>
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Toolbar-->
    <div class="toolbar" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <!--begin::Page title-->
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <!--begin::Title-->
                <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1"><?= $title ?></h1>
                <!-- <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1"><?php echo json_encode($list_kandang) ?></h1> -->
                <!--end::Title-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">

            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                <!--begin::Col-->
                <div class="col-xxl-12">
                    <!--begin::Table-->
                    <div class="card card-flush">
                        <!--begin::Card header-->
                        <div class="card-header mt-5">
                            <!--begin::Card title-->
                            <div class="card-title flex-column">
                                <h3 id='tittle_table_warning' class="fw-bolder mb-1">Import Data Input</h3>
                                <!--<div class="fs-6 text-gray-400">Total $260,300 sepnt so far</div>-->
                            </div>
                            <!--begin::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar my-1">
                                <!--begin::Primary button-->
                                <!-- <a  class="btn btn-sm btn-primary" onclick="viewtablewarning()" id='button_viewtablewarning'>Load</a> -->
                                <!--end::Primary button-->
                            </div>
                            <!--begin::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class='form-group row mb-5'>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-6">
                                            <h4 class="fw-bolder mb-1" style="margin-top: 10px;">Pilih Kandang</h4>
                                        </div>
                                        <div class="col-6" style="text-align-last: end;">
                                            <select name="lokasi" id="filter_lokasi" class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih Lokasi" tabindex="-1" aria-hidden="true" onchange="search_kandang(this.value)">
                                                <?php

                                                if (is_array($list_kandang) || is_object($list_kandang)) {
                                                    echo "<option value='0' data-1='-' data-2='-' data-3='-' disabled selected>Pilih Lokasi</option>";
                                                    foreach ($list_kandang as $list_kandangs) {
                                                        echo "<option value='{$list_kandangs->id_kandang}' >{$list_kandangs->nama}</option>";
                                                    }
                                                } else {
                                                    echo "<option value='-' data-1='-' data-2='-' data-3='-' disabled>Tidak ada data</option>";
                                                }

                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="border border-gray-300 border-dashed rounded   py-3 px-4  me-6 mb-3" style="min-width: 140px !important;">
                                                <div class="d-flex align-items-center">
                                                    <div class="fs-4 fw-bolder" id="id_kandang_value">
                                                        -
                                                    </div>
                                                </div>
                                                <div class="fw-bold fs-6 text-gray-400">Id Kandang</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="border border-gray-300 border-dashed rounded   py-3 px-4  me-6 mb-3" style="min-width: 140px !important;">
                                                <div class="d-flex align-items-center">
                                                    <div class="fs-4 fw-bolder" id="nomorDO_value">
                                                        -
                                                    </div>
                                                </div>
                                                <div class="fw-bold fs-6 text-gray-400">Nomor DO</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='form-group row'>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-6">
                                            <h4 class="fw-bolder mb-1" style="margin-top: 10px;">Import Panen</h4>
                                        </div>
                                        <div class="col-6" style="text-align-last: end;">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_upload" onclick="import_panen()">
                                                <span class="svg-icon svg-icon-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="currentColor" />
                                                        <path d="M10.4 3.60001L12 6H21C21.6 6 22 6.4 22 7V19C22 19.6 21.6 20 21 20H3C2.4 20 2 19.6 2 19V4C2 3.4 2.4 3 3 3H9.20001C9.70001 3 10.2 3.20001 10.4 3.60001ZM16 11.6L12.7 8.29999C12.3 7.89999 11.7 7.89999 11.3 8.29999L8 11.6H11V17C11 17.6 11.4 18 12 18C12.6 18 13 17.6 13 17V11.6H16Z" fill="currentColor" />
                                                        <path opacity="0.3" d="M11 11.6V17C11 17.6 11.4 18 12 18C12.6 18 13 17.6 13 17V11.6H11Z" fill="currentColor" />
                                                    </svg>
                                                </span>
                                                Upload Files</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-6">
                                            <!-- <h4 class="fw-bolder mb-1" style="margin-top: 10px;">Import Panen</h4> -->
                                        </div>
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-6" style="text-align-last: end;">

                                                </div>
                                                <div class="col-6" style="text-align-last: end;">
                                                    <!--begin::More-->
                                                    <div class="ms-2">
                                                        <button type="button" class="btn btn-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                            <!--begin::Svg Icon | path: icons/duotune/general/gen052.svg-->
                                                            Template
                                                            <span class="svg-icon svg-icon-5 m-0">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                    <rect x="10" y="10" width="4" height="4" rx="2" fill="currentColor" />
                                                                    <rect x="17" y="10" width="4" height="4" rx="2" fill="currentColor" />
                                                                    <rect x="3" y="10" width="4" height="4" rx="2" fill="currentColor" />
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </button>
                                                        <!--begin::Menu-->
                                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4" data-kt-menu="true">
                                                            <!--begin::Menu item-->
                                                            <div class="menu-item px-3">
                                                                <a href="<?php echo base_url(); ?>template/template panen.xlsx" class="menu-link px-3">Template</a>
                                                            </div>
                                                            <!--end::Menu item-->
                                                            <!--begin::Menu item-->
                                                            <div class="menu-item px-3">
                                                                <a href="<?php echo base_url(); ?>template/contoh template panen.xlsx" class="menu-link px-3">Contoh</a>
                                                            </div>
                                                            <!--end::Menu item-->

                                                        </div>
                                                        <!--end::Menu-->
                                                        <!--end::More-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>
<!--end::Content-->