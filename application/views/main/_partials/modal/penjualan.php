<!--begin::Modal - Tambah Data Timbang-->
<div class="modal fade" id="modaldatatimbang" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder" id="headerdatatimbang">Data Timbang</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <form method="post" id="datatimbang">
                <div class="modal-body py-10 px-lg-17">
                    <!--begin::Scroll-->
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_new_address_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_new_address_header" data-kt-scroll-wrappers="#kt_modal_new_address_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-md-12 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2">Qty (Ekor)</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="number" step="1" class="form-control form-control-solid" id="input_datatimbang_qty" name="input_datatimbang_qty" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-md-12 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2">Tonase (Kg)</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="number" step="0.01" class="form-control form-control-solid" id="input_datatimbang_tonase" name="input_datatimbang_tonase" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-md-12 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2">Harga per Kg</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="number" step="0.01" class="form-control form-control-solid" id="input_datatimbang_harga" name="input_datatimbang_harga" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                    </div>
                    <!--end::Scroll-->
                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->
                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <input type="hidden" id="id_data_datatimbang">
                    <input type="hidden" id="type_input_datatimbang" value="tambah" readonly>
                    <!-- <button type="reset" id="kt_modal_new_address_cancel" class="btn btn-light me-3">Reset</button> -->
                    <!--end::Button-->

                    <!--begin::Button-->
                    <button type="button" id="button_datatimbang" class="btn btn-primary" onclick="inputdatatimbang()">
                        <span class="indicator-label">Submit</span>
                        <!-- <span class="indicator-progress">Please wait...
                              <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span> -->
                    </button>
                    <!--end::Button-->
                </div>
            </form>
            <!--end::Modal footer-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Tambah Data Timbang-->

<!--begin::Modal - Tambah Data Timbang-->
<div class="modal fade" id="modalttd" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder" id="headerttd">Data Timbang</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <form method="post" id="ttd">
                <div class="modal-body py-10 px-lg-17">
                    <!--begin::Scroll-->
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_new_address_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_new_address_header" data-kt-scroll-wrappers="#kt_modal_new_address_scroll" data-kt-scroll-offset="300px">
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-md-12 fv-row">
                                <label class="required fs-5 fw-bold mb-2">TTD Penimbang</label>
                            </div>
                            <div class="col-md-12 fv-row" style="text-align: center;">
                                <div class="col-md-12 fv-row">
                                    <canvas id="signature-pad-penimbang" class="signature-pad"></canvas>
                                </div>
                                <div class="col-md-12 fv-row">
                                    <button type="button" id="resetpenimbang" class="btn btn-danger"><span class="indicator-label">Reset TTD Penimbang</span></button>
                                </div>
                            </div>
                            <div class="col-md-12 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2">TTD Pembeli</label>
                                <!--end::Label-->
                            </div>
                            <div class="col-md-12 fv-row" style="text-align: center;">
                                <div class="col-md-12 fv-row">
                                    <canvas id="signature-pad-pembeli" class="signature-pad"></canvas>
                                </div>
                                <div class="col-md-12 fv-row">
                                    <button type="button" id="resetpembeli" class="btn btn-danger"><span class="indicator-label">Reset TTD Pembeli</span></button>
                                </div>
                            </div>
                            <!--end::Col-->

                        </div>
                    </div>
                    <!--end::Scroll-->
                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->
                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <input type="hidden" id="id_data_ttd">
                    <input type="hidden" id="type_input_ttd" value="tambah" readonly>
                    <!-- <button type="reset" id="kt_modal_new_address_cancel" class="btn btn-light me-3">Reset</button> -->
                    <!--end::Button-->

                    <!--begin::Button-->
                    <!-- <button class="btn btn-primary" id="save-all">Send Data</button> -->
                    <button type="button" id="button_ttd" class="btn btn-primary" onclick="inputttd()">
                        <span class="indicator-label">Submit</span>
                        <!-- <span class="indicator-progress">Please wait...
                              <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span> -->
                    </button>
                    <!--end::Button-->
                </div>
            </form>
            <!--end::Modal footer-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Tambah Data Timbang-->