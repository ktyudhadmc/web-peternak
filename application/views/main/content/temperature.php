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
                <div class="col-xxl-12" id='card_filter'>
                    <!--begin::Table-->
                    <div class="card card-flush">
                        <!--begin::Card body-->
                        <div class="card-body">
                            <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                                <div class="col-xxl-12">
                                    <div class="row">
                                        <div class="col-2">
                                            <h3 class="fw-bolder mb-0" style="margin-top: 9px;">Filter Lokasi</h3>
                                        </div>
                                        <div class="col-8">
                                            <select name="lokasi" id="filter_kandang_sensor" class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Lokasi">
                                                <?php
                                                if (is_array($getdatauser) || is_object($getdatauser)) {
                                                    echo "<option value='0' data-1='-' data-2='-' data-3='-'>Pilih Lokasi</option>";
                                                    foreach ($getdatauser as $getdatausers) {
                                                        echo "<option value='{$getdatausers->id}' data-1='{$getdatausers->nama}' data-2='{$getdatausers->id}' data-3='{$getdatausers->id}'>{$getdatausers->nama}</option>";
                                                    }
                                                } else {
                                                    echo "<option value='-' data-1='-' data-2='-' data-3='-'>Tidak ada data</option>";
                                                }

                                                ?>
                                            </select>
                                            <input type="hidden" id="filter_periode_sensor" class="form-control form-control-solid" value="" />
                                        </div>
                                        <div class="col-2" style="text-align: right;">
                                            <a style="margin-top: 3px;" class="btn btn-sm btn-primary" onclick="loaddatasensor()"><i class="fas fa-search white-true"></i>&nbsp;Submit </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-12">
                                    <div class="row">
                                        <div class="col-2">
                                            <h3 class="fw-bolder mb-0" style="margin-top: 9px;">Pilih Sensor</h3>
                                        </div>
                                        <div class="col-8">
                                            <select name="lokasi" id="filter_sensor" class="form-select form-select-solid" data-control="select2" data-hide-search="true">
                                                <option value='0' data-1='-' data-2='-' data-3='-'>Pilih Sensor</option>
                                                <option value='temperature' data-1='-' data-2='-' data-3='-'>Temperature</option>
                                                <option value='humidity' data-1='-' data-2='-' data-3='-'>Humidity</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                </div>

                <?php
                $this->load->view('main/content/temperature_chart');
                ?>
                <!--end::Col-->
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>
<!--end::Content-->