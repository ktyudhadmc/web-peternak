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
<div id="kt_dataharian" class="tab-pane fade show">
    <!--begin::Row-->
    <div class="row g-6 g-xl-9">
        <div class="col-lg-12">
            <!--begin::Graph-->
            <div class="card card-flush h-lg-100">
                <!--begin::Card header-->
                <div class="card-header mt-6">
                    <!--begin::Card title-->
                    <div class="card-title flex-column">
                        <h3 class="fw-bolder mb-1">Data Laporan Harian</h3>
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                            <!--begin::Add user-->
                            <button type="button" class="btn btn-primary" onclick="modaleditdataharianshow()">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->Add Data Harian
                            </button>
                            <!--end::Add user-->
                        </div>
                        <!--end::Toolbar-->
                        <!--end::Modal - New Card-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-10 pb-0 px-5">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <div class="card-body py-4">
                            <div class="table-responsive">
                                <table id="tabledataharian" class="table align-middle gs-0 gy-5">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Umur</th>
                                            <th>Mati</th>
                                            <th>Culling</th>
                                            <th>Populasi</th>
                                            <th>BW act</th>
                                            <th>BW std</th>
                                            <th>Tot Pakan</th>
                                            <th>FI act</th>
                                            <th>FI std</th>
                                            <th>FCR act</th>
                                            <th>FCR std</th>
                                            <th>ADG act</th>
                                            <th>ADG std</th>
                                            <th>Water</th>
                                            <th>CV</th>
                                            <th>Uniformity</th>
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
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
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
                <!--end::Card body-->
            </div>
            <!--end::Graph-->
        </div>
        <div class="col-lg-6">
            <!--begin::Graph-->
            <div class="card card-flush h-lg-100">
                <!--begin::Card header-->
                <div class="card-header mt-6">
                    <!--begin::Card title-->
                    <div class="card-title flex-column">
                        <h3 class="fw-bolder mb-1">Data Laporan Harian Pakan</h3>
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                            <!--begin::Add user-->
                            <button type="button" class="btn btn-primary" onclick="modaleditpakanharianshow()">
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
                <!--begin::Card body-->
                <div class="card-body pt-10 pb-0 px-5">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <div class="card-body py-4">
                            <div class="table-responsive">
                                <table id="tabledataharianpakan" class="table align-middle gs-0 gy-5">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Umur</th>
                                            <th>Item</th>
                                            <th>Qty</th>
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
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--end::Table container-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Graph-->
        </div>
        <div class="col-lg-6">
            <!--begin::Graph-->
            <div class="card card-flush h-lg-100">
                <!--begin::Card header-->
                <div class="card-header mt-6">
                    <!--begin::Card title-->
                    <div class="card-title flex-column">
                        <h3 class="fw-bolder mb-1">Data Laporan Harian OVK</h3>
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                            <!--begin::Add user-->
                            <button type="button" class="btn btn-primary" onclick="modaleditovkharianshow()">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->Add OVK
                            </button>
                            <!--end::Add user-->
                        </div>
                        <!--end::Toolbar-->
                        <!--end::Modal - New Card-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-10 pb-0 px-5">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <div class="card-body py-4">
                            <div class="table-responsive">
                                <table id="tabledataharianovk" class="table align-middle gs-0 gy-5">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Umur</th>
                                            <th>Item</th>
                                            <th>Qty</th>
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
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--end::Table container-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Graph-->
        </div>
        <div class="col-lg-12">
            <!--begin::Graph-->
            <div class="card card-flush h-lg-100">
                <!--begin::Card header-->
                <div class="card-header mt-6">
                    <!--begin::Card title-->
                    <div class="card-title flex-column">
                        <h3 class="fw-bolder mb-1">Data Laporan Harian General</h3>
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                            <!--begin::Add user-->
                            <button type="button" class="btn btn-primary" onclick="modaleditgeneralharianshow()">
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
                <!--begin::Card body-->
                <div class="card-body pt-10 pb-0 px-5">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <div class="card-body py-4">
                            <div class="table-responsive">
                                <table id="tabledatahariangeneral" class="table align-middle gs-0 gy-5">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Umur</th>
                                            <th>Item</th>
                                            <th>Qty</th>
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
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--end::Table container-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Graph-->
        </div>
    </div>
    <!--end::Row-->
</div>
<?php $this->load->view('main/_partials/modal/dataharian'); ?>