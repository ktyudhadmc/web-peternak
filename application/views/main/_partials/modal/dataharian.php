<!--begin::Modal - Tambah Data Harian-->
<div class="modal fade" id="modaldataharian" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder" id="headerdataharian">Data Laporan Harian</h2>
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
            <form method="post" id="dataharian">
                <div class="modal-body py-10 px-lg-17">
                    <!--begin::Scroll-->
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_new_address_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_new_address_header" data-kt-scroll-wrappers="#kt_modal_new_address_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-md-12 fv-row">
                                <label class="required fs-5 fw-bold mb-2">Tanggal</label>
                                <input type="date" class="form-control form-control-solid" id="tanggal_dataharian" value="<?= date('Y-m-d') ?>" name="nama" required />
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-md-12 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2">Mati</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="number" step="1" class="form-control form-control-solid" id="input_dataharian_mati" name="input_dataharian_mati" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-md-12 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2">Culling</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="number" step="1" class="form-control form-control-solid" id="input_dataharian_culling" name="input_dataharian_culling" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-md-12 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2">BW</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="number" step="1" class="form-control form-control-solid" id="input_dataharian_bw" name="input_dataharian_bw" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-md-12 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2">Water</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="number" step="1" class="form-control form-control-solid" id="input_dataharian_water" name="input_dataharian_water" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-md-12 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2">CV</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="number" step="1" class="form-control form-control-solid" id="input_dataharian_cv" name="input_dataharian_cv" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-md-12 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2">Uniformity</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="number" step="1" class="form-control form-control-solid" id="input_dataharian_uniformity" name="input_dataharian_uniformity" required />
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
                    <input type="hidden" id="id_data_dataharian">
                    <input type="hidden" id="type_input_dataharian" value="tambah" readonly>
                    <!-- <button type="reset" id="kt_modal_new_address_cancel" class="btn btn-light me-3">Reset</button> -->
                    <!--end::Button-->

                    <!--begin::Button-->
                    <button type="button" id="button_dataharian" class="btn btn-primary" onclick="inputdataharian()">
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
<!--end::Modal - Tambah Data Harian-->

<!--begin::Modal - Tambah Pakan-->
<div class="modal fade" id="modalpakanharian" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder" id="headerpakanharian">Pakan Harian</h2>
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
            <form method="post" id="pakanharian">
                <div class="modal-body py-10 px-lg-17">
                    <!--begin::Scroll-->
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_new_address_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_new_address_header" data-kt-scroll-wrappers="#kt_modal_new_address_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-md-12 fv-row">
                                <label class="required fs-5 fw-bold mb-2">Tanggal</label>
                                <input type="date" class="form-control form-control-solid" id="tanggal_pakanharian" value="<?= date('Y-m-d') ?>" name="nama" required />
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="d-flex flex-column mb-5 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Jenis Pakan</label>
                            <select id="selectjenispakan_pakanharian" class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Jenis Pakan" name="jenis_pakan" onchange="pakanharianselectfun()">
                            </select>
                        </div>
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-md-12 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2">Quantity Stock (Zak)</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" id="qty_stock_pakanharian" placeholder="Quantity Stock" name="qty_stock" readonly />
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-md-12 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2">Quantity(Zak)</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="number" step="0.01" class="form-control form-control-solid" id="inputpakanqty_pakanharian" placeholder="Quantity" name="qty" onkeyup="validateqtypakanharian(this.value)" required />
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
                    <input type="hidden" id="id_data_pakanharian">
                    <input type="hidden" id="type_input" value="tambah" readonly>
                    <!-- <button type="reset" id="kt_modal_new_address_cancel" class="btn btn-light me-3">Reset</button> -->
                    <!--end::Button-->

                    <!--begin::Button-->
                    <button type="button" id="button_pakanharian" class="btn btn-primary" onclick="inputpakanharian()">
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
<!--end::Modal - Tambah Pakan-->

<!--begin::Modal - Tambah OVK-->
<div class="modal fade" id="modalovkharian" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder" id="headerovkharian">OVK Harian</h2>
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
            <form method="post" id="ovkharian">
                <div class="modal-body py-10 px-lg-17">
                    <!--begin::Scroll-->
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_new_address_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_new_address_header" data-kt-scroll-wrappers="#kt_modal_new_address_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-md-12 fv-row">
                                <label class="required fs-5 fw-bold mb-2">Tanggal</label>
                                <input type="date" class="form-control form-control-solid" id="tanggal_ovkharian" value="<?= date('Y-m-d') ?>" name="nama" required />
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="d-flex flex-column mb-5 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Jenis OVK</label>
                            <select id="selectjenisovk_ovkharian" class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Jenis OVK" name="jenis_ovk" onchange="ovkharianselectfun()">
                            </select>
                        </div>
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-md-12 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2">Quantity Stock</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" id="qty_stock_ovkharian" placeholder="Quantity Stock" name="qty_stock" readonly />
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-md-12 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2">Quantity</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="number" class="form-control form-control-solid" id="inputovkqty_ovkharian" placeholder="Quantity" name="qty" onkeyup="validateqtyovkharian(this.value)" required />
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
                    <input type="hidden" id="id_data_ovkharian">
                    <input type="hidden" id="type_input_ovk" value="tambah" readonly>
                    <!-- <button type="reset" id="kt_modal_new_address_cancel" class="btn btn-light me-3">Reset</button> -->
                    <!--end::Button-->

                    <!--begin::Button-->
                    <button type="button" id="button_ovkharian" class="btn btn-primary" onclick="inputovkharian()">
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
<!--end::Modal - Tambah OVK-->

<!--begin::Modal - Tambah General-->
<div class="modal fade" id="modalgeneralharian" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder" id="headergeneralharian">General Harian</h2>
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
            <form method="post" id="generalharian">
                <div class="modal-body py-10 px-lg-17">
                    <!--begin::Scroll-->
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_new_address_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_new_address_header" data-kt-scroll-wrappers="#kt_modal_new_address_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-md-12 fv-row">
                                <label class="required fs-5 fw-bold mb-2">Tanggal</label>
                                <input type="date" class="form-control form-control-solid" id="tanggal_generalharian" value="<?= date('Y-m-d') ?>" name="nama" required />
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="d-flex flex-column mb-5 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Jenis General</label>
                            <select id="selectjenisgeneral_generalharian" class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Jenis General" name="jenis_general" onchange="generalharianselectfun()">
                            </select>
                        </div>
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-md-12 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2">Quantity Stock</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" id="qty_stock_generalharian" placeholder="Quantity Stock" name="qty_stock" readonly />
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-md-12 fv-row">
                                <!--begin::Label-->
                                <label class="required fs-5 fw-bold mb-2">Quantity</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" id="inputgeneralqty_generalharian" placeholder="Quantity" name="qty" onkeyup="validateqtygeneralharian(this.value)" required />
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
                    <input type="hidden" id="id_data_generalharian">
                    <input type="hidden" id="type_input_general" value="tambah" readonly>
                    <!-- <button type="reset" id="kt_modal_new_address_cancel" class="btn btn-light me-3">Reset</button> -->
                    <!--end::Button-->

                    <!--begin::Button-->
                    <button type="button" id="button_generalharian" class="btn btn-primary" onclick="inputgeneralharian()">
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
<!--end::Modal - Tambah General-->