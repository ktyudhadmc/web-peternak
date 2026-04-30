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
                        <h3 class="fw-bolder mb-1">Data Detail Panen</h3>
                        <div class="fs-6 text-gray-400" id="nomordo">List panen ayam per timbang</div>
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base" style="padding-right: 5px;">
                            <!--begin::Add user-->
                            <button type="button" class="btn btn-primary" onclick="view_page()">
                                Back
                            </button>
                            <!--end::Add user-->
                        </div>
                        <!--end::Toolbar-->
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                            <!--begin::Add user-->
                            <button type="button" class="btn btn-primary" onclick="view_page()">
                                <i class="fas fa-print" style="padding-right: 0rem;font-size: 1.5rem;"></i>
                            </button>
                            <!--end::Add user-->
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body pt-10 pb-0 px-5">
                    <!--begin::Table container-->

                    <div class="table-responsive">
                        <div class="card-body py-4">
                            <div class="row fv-row mb-7">
                                <div class="col-md-3">
                                    <div class="card-title flex-column">
                                        <h3 class="fw-bolder mb-1">Data Transaksi</h3>
                                        <div class="fs-6 text-gray-400" id="nomordo">Data transaksi per DO</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-3" style="text-align: right;">
                                    <!--begin::Input-->
                                    <button type="button" class="btn btn-primary" onclick="data_transaksi_update()">
                                        Update Data Transaksi
                                    </button>
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="row fv-row mb-7">
                                <div class="col-md-3">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span>Tanggal</span>
                                    </label>
                                    <!--end::Label-->
                                </div>
                                <div class="col-md-9">
                                    <!--begin::Input-->
                                    <input type="text" id="input_datatimbang_tanggal" class="form-control form-control-solid" />
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="row fv-row mb-7">
                                <div class="col-md-3">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span>Nopol</span>
                                    </label>
                                    <!--end::Label-->
                                </div>
                                <div class="col-md-9">
                                    <!--begin::Input-->
                                    <input type="text" id="input_datatimbang_nomor_mobil" class="form-control form-control-solid" />
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="row fv-row mb-7">
                                <div class="col-md-3">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span>Nama Pembeli</span>
                                    </label>
                                    <!--end::Label-->
                                </div>
                                <div class="col-md-9">
                                    <!--begin::Input-->
                                    <input type="text" id="input_datatimbang_namapembeli" class="form-control form-control-solid" />
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="row fv-row mb-7">
                                <div class="col-md-3">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span>Nama Penimbang </span>
                                    </label>
                                    <!--end::Label-->
                                </div>
                                <div class="col-md-9">
                                    <!--begin::Input-->
                                    <input type="text" id="input_datatimbang_namapenimbang" class="form-control form-control-solid" />
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="row fv-row mb-7">
                                <div class="col-md-3">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span>No Nota Manual</span>
                                    </label>
                                    <!--end::Label-->
                                </div>
                                <div class="col-md-9">
                                    <!--begin::Input-->
                                    <input type="text" id="input_datatimbang_nomornota" class="form-control form-control-solid" />
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="row fv-row mb-7">
                                <div class="col-md-3">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span>Kondisi ayam</span>
                                    </label>
                                    <!--end::Label-->
                                </div>
                                <div class="col-md-9">
                                    <!--begin::Input-->
                                    <!-- <input type="text" id="input_datatimbang_kondisiayam" class="form-control form-control-solid" /> -->
                                    <select id="input_datatimbang_kondisiayam" class="form-select form-select-solid" data-control="select2" data-hide-search="true" name="input_datatimbang_kondisiayam">
                                        <option value="normal">normal</option>
                                        <option value="afkir">afkir</option>
                                        <option value="sakit">sakit</option>
                                    </select>
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="row fv-row mb-7">
                                <div class="col-md-3">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span>Berat Keranjang</span>
                                    </label>
                                    <!--end::Label-->
                                </div>
                                <div class="col-md-9">
                                    <!--begin::Input-->
                                    <input type="text" id="input_datatimbang_beratkeranjang" class="form-control form-control-solid" />
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="row fv-row mb-20">
                                <div class="col-md-3">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span>Susut</span>
                                    </label>
                                    <!--end::Label-->
                                </div>
                                <div class="col-md-9">
                                    <!--begin::Input-->
                                    <input type="text" id="input_datatimbang_susut" class="form-control form-control-solid" />
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="row fv-row mb-7">
                                <div class="col-md-3">
                                    <div class="card-title flex-column">
                                        <h3 class="fw-bolder mb-1">Data Timbang</h3>
                                        <div class="fs-6 text-gray-400" id="nomordo">List panen ayam per timbang</div>
                                        <input type="hidden" id="input_datatimbang_nomorDO" class="form-control form-control-solid" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-3" style="text-align: right;">
                                    <!--begin::Input-->
                                    <button type="button" class="btn btn-primary" onclick="modaleditdatatimbangshow()">
                                        <span class="svg-icon svg-icon-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->Add Data Timbang
                                    </button>
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="table-responsive mb-20">
                                <table id="tabledatapanendetail" class="table align-middle gs-0 gy-5">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Qty Ekor</th>
                                            <th>Qty Kg</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="row fv-row mb-7">
                                <div class="col-md-3">
                                    <div class="card-title flex-column">
                                        <h3 class="fw-bolder mb-1">Tanda Tangan</h3>
                                        <div class="fs-6 text-gray-400" id="ttd">Tanda tangan Penimbang & Pembeli</div>
                                        <!-- <input type="hidden" id="input_datatimbang_nomorDO" class="form-control form-control-solid" /> -->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-3" style="text-align: right;">
                                    <!--begin::Input-->
                                    <button type="button" class="btn btn-primary" onclick="modalttd()">
                                        <span class="svg-icon svg-icon-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->Add Tanda Tangan
                                    </button>
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="row fv-row mb-7">
                                <div class="col-md-3">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span>TTD Pembeli</span>
                                    </label>
                                    <!--end::Label-->
                                </div>
                                <div class="col-md-9">
                                    <div id="imgttdpembeli" style="text-align: center;"></div>
                                    <!-- <img src="images/gallery/'.$result.'.jpg"> -->
                                </div>
                            </div>
                            <div class="row fv-row mb-7">
                                <div class="col-md-3">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span>TTD Penimbang</span>
                                    </label>
                                    <!--end::Label-->
                                </div>
                                <div class="col-md-9">
                                    <div id="imgttdpenimbang" style="text-align: center;"></div>
                                    <!-- <img src="images/gallery/'.$result.'.jpg"> -->
                                </div>
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
<?php $this->load->view('main/_partials/modal/penjualan'); ?>