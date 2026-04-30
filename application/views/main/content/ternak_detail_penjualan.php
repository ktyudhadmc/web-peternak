<div id="kt_penjualan" class="tab-pane fade show">
    <!--begin::Row-->
    <div class="row g-6 g-xl-9">
        <div class="col-lg-12">
            <!--begin::Graph-->
            <div class="card card-flush h-lg-100">
                <!--begin::Card header-->
                <div class="card-header mt-6">
                    <!--begin::Card title-->
                    <div class="card-title flex-column">
                        <h3 class="fw-bolder mb-1">Data Penjualan</h3>
                        <div class="fs-6 text-gray-400">List panen ayam per DO</div>
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                            <!--begin::Add user-->
                            <button type="button" class="btn btn-primary" onclick="see_detail_panen('','tambah')">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->Add Penjualan
                            </button>
                            <!--end::Add user-->
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Card header-->
                </div>
                <!--begin::Card body-->
                <div class="card-body pt-10 pb-0 px-5">
                    <!--begin::Table container-->
                    <div class="card-body py-4">
                        <div class="table-responsive">
                            <table id="tabledatapanendo" class="table align-middle gs-0 gy-5">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>DO</th>
                                        <th>NoPol</th>
                                        <th>Nama Pembeli</th>
                                        <th>Nama Penimbang</th>
                                        <th>Nota Manual</th>
                                        <th>Kondisi Ayam</th>
                                        <th>Ekor</th>
                                        <th>Bruto</th>
                                        <th>Susut</th>
                                        <th>Keranjang</th>
                                        <th>Nett</th>
                                        <th>Rata</th>
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
                                    </tr>
                                </tfoot>
                            </table>
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