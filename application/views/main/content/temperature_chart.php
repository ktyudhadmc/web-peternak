<style>
    .loader {
        border: 8px solid #f0592417;
        border-radius: 50%;
        border-top: 8px solid #f05924;
        width: 90px;
        height: 90px;
        -webkit-animation: spin 2s linear infinite;
        /* Safari */
        animation: spin 2s linear infinite;
    }

    /* Safari */
    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
<div class="col-xxl-12">
    <!--begin::Table-->
    <div id="none_sensorchart" class="card card-flush h-lg-100" style="align-items: center;padding-bottom: 50px;">
        <img src="<?= base_url() ?>assets/main/media/illustrations/sketchy-1/4.png" style="width: 30%;padding-bottom: 50px;" />
        <h3 class="fw-bolder mb-1">Chart Belum Bisa Ditampilkan</h3>
        <div class="fs-6 text-gray-400" id="ket_notif_sensor">Pilih lokasi dan jenis sensor</div>
    </div>
    <!--begin::Card header-->
    <div id="chartloadingsensor" class="card card-flush h-lg-100" style="align-items: center;padding-bottom: 50px;display:none">
        <center style="padding: 52px;">
            <!-- <img src=" <?= base_url('assets/resource/images/chartloading.svg') ?>" width="200"><br><br> -->
            <div class="loader"></div>
            <div class="pt-5"></div>
            <small>
                <p style="font-style: normal; font-size: 12px;color:black">Sedang menyiapkan chart ...</p>
            </small>
        </center>
    </div>
    <div class="card card-flush" id="chartviewsensor" style="display:none">

        <div class="card-header mt-0" style="min-height: 50px;">
            <div class="card-title flex-column">
                <h3 class="fw-bolder mb-0" id="tittle_sensorchart">Chart Sensor</h3>
            </div>
            <div class="card-toolbar">
                <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal_sensorchart"><i class="fas fa-search white-true"></i>&nbsp;Tabel </a>
            </div>
        </div>
        <!--end::Card header-->
        <!-- <div class="card-body">
            <div class='row  g-5 g-xl-10 mb-5 mb-xl-10'>
                <div class="col-5">
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center mb-1">
                            <h4 class="fw-bolder mb-1">Range Tanggal</h4>
                        </div>
                        <div class="d-flex flex-wrap fw-bold mb-4 fs-5 text-gray-400" id="ketrangetgl">

                        </div>
                    </div>
                </div>
                <div class="col-5">
                    <input class="form-control form-control-solid" placeholder="Pick date rage" id="range_tanggal_sensor" />
                    <input type="hidden" id="range_tanggal_sensor_max" class="form-control form-control-solid" value="" />
                    <input type="hidden" id="range_tanggal_sensor_min" class="form-control form-control-solid" value="" />
                </div>
                <div class="col-2" style="text-align: right;">
                    <a style="margin-top: 3px;" class="btn btn-sm btn-primary" onclick="loaddatasensortanggal()"><i class="fas fa-filter white-true"></i></i>&nbsp;Filter </a>
                </div>
            </div>
        </div> -->
        <!--begin::Card body-->
        <div class="card-body pt-5 pb-0 px-5">
            <!--begin::Chart-->
            <div id="kt_sensorchart" style="min-height: 200px;"></div>
            <!-- <div id="kt_project_overview_graph" class="card-rounded-bottom" style="height: 300px"></div> -->
            <!--end::Chart-->
        </div>
        <div class="card-body pt-5 pb-0 px-5">
            <!--begin::Chart-->
            <div id="kt_sensorchart_line" style="min-height: 50px;"></div>
            <!-- <div id="kt_project_overview_graph" class="card-rounded-bottom" style="height: 300px"></div> -->
            <!--end::Chart-->
        </div>

        <!--end::Card body-->
    </div>
</div>