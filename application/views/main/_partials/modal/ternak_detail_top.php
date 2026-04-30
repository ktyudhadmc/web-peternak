 <!--begin::Modal - Input Kandang-->
 <div class="modal fade" id="modalperiode" tabindex="-1" aria-hidden="true">
     <!--begin::Modal dialog-->
     <div class="modal-dialog modal-dialog-centered mw-650px">
         <!--begin::Modal content-->
         <div class="modal-content">
             <!--begin::Form-->
             <form method="post" id="selectperiode">
                 <!--begin::Modal header-->
                 <div class="modal-header" id="kt_modal_new_address_header">
                     <!--begin::Modal title-->
                     <h2>Select Periode</h2>
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
                 <div class="modal-body py-10 px-lg-17">
                     <!--begin::Scroll-->
                     <div class="scroll-y me-n7 pe-7" id="kt_modal_new_address_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_new_address_header" data-kt-scroll-wrappers="#kt_modal_new_address_scroll" data-kt-scroll-offset="300px">

                         <div class="d-flex flex-column mb-5 fv-row">
                             <label class="required fs-6 fw-bold mb-2">Select Periode</label>
                             <select id="selectperiodeinput" class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Select Periode" name="periode">
                                 <?php
                                    foreach ($periode as $periodes) {
                                        if ($periodes->periode == $dataresume->periode) { ?>
                                         <option value="<?= $periodes->periode ?>" selected><?= $periodes->periode ?></option>
                                     <?php } else { ?>
                                         <option value="<?= $periodes->periode ?>"><?= $periodes->periode ?></option>
                                 <?php }
                                    } ?>
                             </select>
                         </div>

                     </div>
                     <!--end::Scroll-->
                 </div>
                 <!--end::Modal body-->
                 <!--begin::Modal footer-->
                 <div class="modal-footer flex-center">
                     <!--begin::Button-->
                     <!-- <button type="reset" id="kt_modal_new_address_cancel" class="btn btn-light me-3">Reset</button> -->
                     <!--end::Button-->
                     <!--begin::Button-->
                     <button type="button" id="selectperiodebutton" class="btn btn-primary" onclick="selectperiodeaction()">
                         <span class="indicator-label">Submit</span>
                         <!-- <span class="indicator-progress">Please wait...
                              <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span> -->
                     </button>
                     <!--end::Button-->
                 </div>
                 <!--end::Modal footer-->
             </form>
             <!--end::Form-->
         </div>
     </div>
 </div>
 <!--end::Modal - Input Kandang-->
 <div class="modal fade" id="modallistuser" tabindex="-1" aria-hidden="true">
     <!--begin::Modal dialog-->
     <div class="modal-dialog modal-dialog-centered mw-650px">
         <!--begin::Modal content-->
         <div class="modal-content">
             <!--begin::Modal header-->
             <div class="modal-header pb-0 border-0 justify-content-end">
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
             <!--begin::Modal header-->
             <!--begin::Modal body-->
             <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                 <!--begin::Content-->
                 <div class="text-center mb-13">
                     <h1 class="mb-3">List User</h1>
                     <div class="text-muted fw-bold fs-5">Semua user yang dapat mengakses kandang <?= $datakandang->nama ?></div>
                 </div>
                 <!--end::Content-->
                 <!--begin::Search-->
                 <div id="kt_modal_users_search_handler" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="inline">

                     <!--begin::Wrapper-->
                     <div class="py-5">
                         <!--begin::Suggestions-->
                         <div data-kt-search-element="suggestions">
                             <!--begin::Heading-->
                             <!-- <h3 class="fw-bold mb-5">Recently searched:</h3> -->
                             <!--end::Heading-->
                             <!--begin::Users-->
                             <div class="mh-375px scroll-y me-n7 pe-7">
                                 <!--begin::User-->
                                 <?php
                                    foreach ($users as $key => $user) {
                                    ?>
                                     <a href="<?= base_url("main/profile/{$user->id}") ?>" class="d-flex align-items-center p-3 rounded bg-state-light bg-state-opacity-50 mb-1">
                                         <!--begin::Avatar-->
                                         <div class="symbol symbol-35px symbol-circle me-5">
                                             <img alt="Pic" src="<?= $this->config->item('app_url') . $user->foto ?>" />
                                         </div>
                                         <!--end::Avatar-->
                                         <!--begin::Info-->
                                         <div class="fw-bold">
                                             <span class="fs-6 text-gray-800 me-2"><?= $user->first_name ?></span>
                                             <!-- <span class="badge badge-light">Art Director</span> -->
                                         </div>
                                         <!--end::Info-->
                                     </a>
                                 <?php } ?>
                             </div>
                             <!--end::Users-->
                         </div>
                         <!--end::Suggestions-->
                     </div>
                     <!--end::Wrapper-->
                 </div>
                 <!--end::Search-->
             </div>
             <!--end::Modal body-->
         </div>
         <!--end::Modal content-->
     </div>
     <!--end::Modal dialog-->
 </div>