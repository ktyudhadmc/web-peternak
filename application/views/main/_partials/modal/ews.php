<div class="modal fade" id="modalews" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder" id="headerews">Keterangan EWS</h2>
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
            <form method="post" id="ews">
                <div class="modal-body py-10 px-lg-17">
                    <!--begin::Scroll-->
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_new_address_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_new_address_header" data-kt-scroll-wrappers="#kt_modal_new_address_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-md-12 fv-row">
                                <label class="required fs-5 fw-bold mb-2">Tanggal</label>
                                <input type="date" class="form-control form-control-solid" id="tanggal_ews" value="<?= date('Y-m-d') ?>" name="nama" required />
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-md-12 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2">Type EWS</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" id="input_ews_type" name="input_ews_type" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-md-12 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2">Nilai</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="number" step="1" class="form-control form-control-solid" id="input_ews_nilai" name="input_ews_nilai" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-md-12 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2">Keterangan</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" id="input_ews_ket" name="input_ews_ket" required />
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
                    <input type="hidden" id="id_data_ews">
                    <input type="hidden" id="id_row_ews">
                    <input type="hidden" id="type_input_ews" value="tambah" readonly>
                    <!-- <button type="reset" id="kt_modal_new_address_cancel" class="btn btn-light me-3">Reset</button> -->
                    <!--end::Button-->

                    <!--begin::Button-->
                    <button type="button" id="button_ews" class="btn btn-primary" onclick="inputews()">
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