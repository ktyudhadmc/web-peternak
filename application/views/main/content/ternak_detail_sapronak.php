<!-- <div id="kt_sapronak" class="tab-pane fade show"> -->
<!--begin::Row-->
<div class="row g-6 g-xl-9">
    <!--begin::Col-->
    <div class="col-lg-6">
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header mt-6">
                <!--begin::Card title-->
                <div class="card-title flex-column">
                    <h3 class="fw-bolder mb-1">DOC</h3>
                    <div class="fs-6 text-gray-400">List Dari DOC Sapronak</div>
                </div>
                <!--end::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modaltest">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                                </svg>
                            </span>
                        </button> -->
                    </div>
                    <!--end::Toolbar-->
                    <!--end::Modal - New Card-->
                    <!--begin::Modal - Add task-->
                </div>
            </div>
            <div class="card-body py-4">
                <div class="table-responsive">
                    <table id="tabledocsapronak" class="table align-middle gs-0 gy-5">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Populasi</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <div class="card-title flex-column">
                    <h3 class="fw-bolder mb-1">Pakan Masuk</h3>
                    <div class="fs-6 fw-bold text-gray-400">List Dari Pakan Sapronak</div>
                </div>
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <!--begin::Add user-->
                        <button type="button" class="btn btn-primary" onclick="modaltambahpakanshow()">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->Add Pakan
                        </button>
                        <!--end::Add user-->
                    </div>
                    <!--end::Toolbar-->
                    <!--end::Modal - New Card-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <div class="card-body py-4">
                <div class="table-responsive">
                    <table id="tablepakansapronak" class="table align-middle gs-0 gy-5">
                        <thead>
                            <tr>
                                <th class="min-w-80px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1" colspan="1" style="width: 80px;">Tanggal</th>
                                <th class="min-w-80px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1" colspan="1" style="width: 80px;">Produk</th>
                                <th class="min-w-80px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1" colspan="1" style="width: 80px;">Zak</th>
                                <th class="min-w-80px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1" colspan="1" style="width: 80px;">Harga</th>
                                <th class="min-w-80px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1" colspan="1" style="width: 100px;">Harga Total</th>
                                <th class="min-w-80px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1" colspan="1" style="width: 80px;">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    <!--end::Col-->
    <!--begin::Col-->
    <div class="col-lg-6">
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <div class="card-title flex-column">
                    <h3 class="fw-bolder mb-1">OVK Sapronak</h3>
                    <div class="fs-6 fw-bold text-gray-400">List Dari Pakan Sapronak</div>
                </div>
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <button type="button" class="btn btn-primary" onclick="modaltambahovkshow()">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->Add Ovk
                        </button>
                        <!--end::Add user-->
                    </div>
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">
                <!--begin::Table-->
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer" id="tableovksapronak">
                        <!--begin::Table head-->
                        <thead>
                            <tr>
                                <th class="min-w-80px sorting" tabindex="0" aria-controls="tableovksapronak" rowspan="1" colspan="1" style="width: 267.101px;">Tanggal</th>
                                <th class="min-w-80px sorting" tabindex="0" aria-controls="tableovksapronak" rowspan="1" colspan="1" style="width: 267.101px;">Produk</th>
                                <th class="min-w-80px sorting" tabindex="0" aria-controls="tableovksapronak" rowspan="1" colspan="1" style="width: 267.101px;">Zak</th>
                                <th class="min-w-80px sorting" tabindex="0" aria-controls="tableovksapronak" rowspan="1" colspan="1" style="width: 267.101px;">Harga</th>
                                <th class="min-w-80px sorting" tabindex="0" aria-controls="tableovksapronak" rowspan="1" colspan="1" style="width: 267.101px;">Harga Total</th>
                                <th class="min-w-80px sorting" tabindex="0" aria-controls="tableovksapronak" rowspan="1" colspan="1" style="width: 267.101px;">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
    </div>
    <!--end::Col-->
    <!--begin::Col-->
    <div class="col-lg-6">
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <div class="card-title flex-column">
                    <h3 class="fw-bolder mb-1">General Masuk</h3>
                    <div class="fs-6 fw-bold text-gray-400">List Dari General Sapronak</div>
                </div>
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <!--begin::Add user-->
                        <button type="button" class="btn btn-primary" onclick="modaltambahgeneralshow()">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->Add General
                        </button>
                        <!--end::Add user-->
                    </div>
                    <!--end::Toolbar-->
                    <!--end::Modal - New Card-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <div class="card-body py-4">
                <div class="table-responsive">
                    <table id="tablegeneralsapronak" class="table align-middle gs-0 gy-5">
                        <thead>
                            <tr>
                                <th class="min-w-80px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1" colspan="1" style="width: 267.101px;">Tanggal</th>
                                <th class="min-w-80px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1" colspan="1" style="width: 267.101px;">Produk</th>
                                <th class="min-w-80px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1" colspan="1" style="width: 267.101px;">Zak</th>
                                <th class="min-w-80px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1" colspan="1" style="width: 267.101px;">Harga</th>
                                <th class="min-w-80px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1" colspan="1" style="width: 267.101px;">Harga Total</th>
                                <th class="min-w-80px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1" colspan="1" style="width: 267.101px;">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<!--end::Col-->
</div>
<!--end::Row-->
<!-- </div> -->
<?php $this->load->view('main/_partials/modal/sapronak'); ?>