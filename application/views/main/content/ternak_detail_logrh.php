<div id="kt_logrh" class="tab-pane fade show">
    <input type="hidden" id="filter_kandang_sensor" class="form-control form-control-solid" value="<?= $idkandang ?>" />
    <input type="hidden" id="filter_periode_sensor" class="form-control form-control-solid" value="<?= $periode ?>" />
    <input type="hidden" id="filter_sensor" class="form-control form-control-solid" value="temperature" />
    <!--begin::Row-->
    <!-- <div class="row g-6 g-xl-9">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100" style="align-items: center;padding-bottom: 50px;">
                <img src="<?= base_url() ?>assets/main/media/illustrations/sketchy-1/4.png" style="width: 30%;padding-bottom: 50px;" />
                <h3 class="fw-bolder mb-1">Sedang Dalam Perbaikan</h3>
                <div class="fs-6 text-gray-400" id="nomordo">Beberapa Halaman Belum Tersedia</div>
            </div>
        </div>
    </div> -->
    <!--end::Row-->
    <div class="row g-6 g-xl-9">
        <div class="col-xxl-12">
            <div class="card card-flush">
                <div class="card-body pt-9 pb-0">
                    <!--begin::Nav-->
                    <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder">
                        <li class="nav-item">
                            <a class="nav-link text-active-primary py-5 me-6 active" data-bs-toggle="tab" href="#kt_realtime">Realtime</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary py-5 me-6" data-bs-toggle="tab" href="#kt_temp_sensor">Temp</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary py-5 me-6" data-bs-toggle="tab" href="#kt_water_sensor">Water</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary py-5 me-6" data-bs-toggle="tab" href="#kt_weighing_sensor">Weighing</a>
                        </li>
                    </ul>
                    <!--end::Nav-->
                </div>
            </div>
        </div>
        <div class="tab-content">
            <div id="kt_realtime" class="tab-pane fade active show">
                <?php
                $this->load->view('main/content/realtime');
                ?>
            </div>
            <div id="kt_temp_sensor" class="tab-pane fade show">
                <?php
                $this->load->view('main/content/temperature_chart');
                ?>
            </div>
            <div id="kt_water_sensor" class="tab-pane fade show">
                <?php
                $this->load->view('main/content/water_chart');
                ?>
            </div>
            <div id="kt_weighing_sensor" class="tab-pane fade show">
                <?php
                $this->load->view('main/content/weighing_chart');
                ?>
            </div>
        </div>
    </div>
</div>