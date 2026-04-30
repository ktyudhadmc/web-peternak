<!-- <div id="kt_bop" class="tab-pane fade show">
    <div class="row g-6 g-xl-9">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100" style="align-items: center;padding-bottom: 50px;">
                <img src="<?= base_url() ?>assets/main/media/illustrations/sketchy-1/4.png" style="width: 30%;padding-bottom: 50px;" />
                <h3 class="fw-bolder mb-1">Sedang Dalam Perbaikan</h3>
                <div class="fs-6 text-gray-400" id="nomordo">Beberapa Halaman Belum Tersedia</div>
            </div>
        </div>
    </div>
</div> -->
<div id="kt_bop" class="tab-pane fade show">
    <!--begin::Row-->
    <div class="row g-6 g-xl-9">
        <!--begin::Col-->
        <div class="col-lg-12">
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header mt-6">
                    <!--begin::Card title-->
                    <div class="card-title flex-column">
                        <h3 class="fw-bolder mb-1">Input Biaya Operational</h3>
                        <div class="fs-6 text-gray-400">Data Biaya Operational</div>
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                            <!--begin::Add user-->
                            <button type="button" class="btn btn-primary" onclick="modaltambahbopshow()">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->Add BOP
                            </button>
                            <!--end::Add user-->
                        </div>
                        <div id="buttonewskematian"></div>
                    </div>

                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!--begin::Table-->
                    <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <!--begin::Table container-->
                        <div class="table-responsive">
                            <div class="card-body py-4">
                                <div class="table-responsive">
                                    <table id="tablebop" class="table align-middle gs-0 gy-5">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Harga per satuan</th>
                                                <th>Harga Total</th>
                                                <th>Satuan</th>
                                                <th>Qty</th>
                                                <th>Ket</th>
                                                <th>Option</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--end::Table container-->
                    </div>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->
</div>
<?php $this->load->view('main/_partials/modal/bop'); ?>