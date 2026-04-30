					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
					    <!--begin::Toolbar-->
					    <div class="toolbar" id="kt_toolbar">
					        <!--begin::Container-->
					        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
					            <!--begin::Page title-->
					            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
					                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
					                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
					                <!--begin::Title-->
					                <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Ternak</h1>
					                <!--end::Title-->
					                <!--begin::Separator-->
					                <span class="h-20px border-gray-300 border-start mx-4"></span>
					                <!--end::Separator-->
					                <!--begin::Breadcrumb-->
					                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
					                    <!--begin::Item-->
					                    <li class="breadcrumb-item text-muted">
					                        <a href="<?= base_url() ?>" class="text-muted text-hover-primary">Home</a>
					                    </li>
					                    <!--end::Item-->
					                    <!--begin::Item-->
					                    <li class="breadcrumb-item">
					                        <span class="bullet bg-gray-300 w-5px h-2px"></span>
					                    </li>
					                    <!--end::Item-->
					                    <!--begin::Item-->
					                    <li class="breadcrumb-item text-dark">Ternak</li>
					                    <!--end::Item-->
					                </ul>
					                <!--end::Breadcrumb-->
					            </div>
					            <!--end::Page title-->
					        </div>
					        <!--end::Container-->
					    </div>
					    <!--end::Toolbar-->
					    <!--begin::Post-->
					    <div class="post d-flex flex-column-fluid" id="kt_post">
					        <!--begin::Container-->
					        <div id="kt_content_container" class="container-xxl">
					            <!--begin::Toolbar-->
					            <div class="d-flex flex-wrap flex-stack my-5">
					                <!--begin::Heading-->
					                <h2 class="fs-2 fw-bold my-2">Ternak
					                </h2>
					                <!--end::Heading-->
					                <!--begin::Controls-->
					                <div class="d-flex flex-wrap my-1">
					                    <div class="d-flex align-items-center gap-2 gap-lg-3" data-select2-id="select2-data-250-3vd8">
					                        <!--begin::Filter menu-->
					                        <div class="m-0" data-select2-id="select2-data-249-9a06">
					                            <select name="status" onchange="changeternak(this.value)" data-control="select2"
					                                data-hide-search="true"
					                                class="form-select form-select-sm bg-body border-body fw-bolder w-125px">
					                                <option value="aktif" <?= $selected == "aktif" ? "selected" : NULL ?>>Aktif
					                                </option>
					                                <option value="rehat" <?= $selected == "rehat" ? "selected" : NULL ?>>Rehat
					                                </option>
					                            </select>
					                        </div>
					                        <a href="../../demo1/dist/.html" class="btn btn-sm btn-primary" data-bs-toggle="modal"
					                            data-bs-target="#kt_modal_create_app">Buat Kandang</a>
					                        <!--end::Primary button-->
					                    </div>
					                </div>
					                <!--end::Controls-->
					            </div>
					            <!--end::Toolbar-->
					            <div class="pt-3"></div>

					            <!--begin::Stats-->
					            <div class="row g-6 g-xl-9">
					                <div id="outputternak">
					                    <?php for ($i = 0; $i < 4; $i++) { ?>
					                    <div class="col-lg-12 col-xxl-12">
					                        <div class="ph-item">
					                            <div class="ph-col-12">
					                                <div class="ph-row">
					                                    <div class="ph-col-4"></div>
					                                    <div class="ph-col-8 empty"></div>
					                                </div>
					                                <div class="ph-row">
					                                    <div class="ph-col-2"></div>
					                                    <div class="ph-col-10 empty"></div>
					                                </div>
					                                <div class="ph-row">
					                                    <br>
					                                </div>
					                                <div class="ph-row">
					                                    <div class="ph-col-12"></div>
					                                </div>
					                                <div class="ph-row">
					                                    <div class="ph-col-12"></div>
					                                </div>
					                                <div class="ph-row">
					                                    <div class="ph-col-12"></div>
					                                </div>
					                            </div>
					                        </div>
					                    </div>
					                    <?php } ?>
					                </div>
					                <?php
									$arr = array();
									foreach ($datashown as $grouping) {
										$arr[$grouping->user_id] = $grouping->user_id;
									}
									foreach ($arr as $key => $groupingname) {
										$getname = $this->db->where(['id' => $groupingname])->get('users')->row();
									?>
					                <!--<div class="col-lg-12 col-xxl-12">
					                    <div class="card h-100">
					                        <div class="card-body p-9">
					                            <div class="card-header border-0 pt-6">
					                                <h3 class="card-title align-items-start flex-column">
					                                    <span class="text-muted mt-1 fw-bold fs-7 mb-1">List kandang dari Owner</span>
					                                    <span class="card-label fw-bolder fs-3 mb-1"><?= $getname->first_name ?></span>
					                                </h3>
					                            </div>
					                            <div class="pt-3"></div>
					                            <div class="table-responsive">
					                                <table id="ternakview"
					                                    class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer table-hover">
					                                    <thead>
					                                        <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
					                                            <th class="min-w-125px sorting">Nama Kandang</th>
					                                            <th class="min-w-125px sorting">Periode</th>
					                                            <th class="min-w-125px sorting">Populasi</th>
					                                            <th class="min-w-125px sorting">Stok Type</th>
					                                            <th class="min-w-125px sorting">Status</th>
					                                        </tr>
					                                    </thead>
					                                    <tbody>
					                                        <?php foreach ($datashown as $datashowns) {
																if ($datashowns->user_id == $groupingname) { ?>
					                                        <tr>
					                                            <td class="d-flex align-items-center">
					                                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
					                                                    <span class="symbol-label">
					                                                        <img src="<?= $this->config->item('peternak') . $datashowns->foto ?>"
					                                                            class="h-50 align-self-center" alt="">
					                                                    </span>
					                                                </div>
					                                                <div class="d-flex flex-column">
					                                                    <a class="text-gray-800 text-hover-primary mb-1"
					                                                        href="<?= base_url("main/ternak/detail/{$this->uri->segment(4)}/{$datashowns->id_kandang}/{$datashowns->periode}") ?>"
					                                                        class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary"
					                                                        onclick="dowaiting(this); return false;">
					                                                        <?= $datashowns->nama ?>
					                                                    </a>
					                                                    <span
					                                                        class="text-muted fw-bold d-block fs-7"><?= $datashowns->alamat ?></span>
					                                                </div>
					                                            </td>
					                                            <td>
					                                                <span
					                                                    class="text-gray-800 text-hover-primary mb-1"><?= $datashowns->periode ?></span>
					                                                <span class="text-muted fw-bold d-block fs-7">Tanggal Chickin :
					                                                    <?= ucwords(date('M d, Y', strtotime($datashowns->tanggal_mulai))) ?></span>
					                                            </td>
					                                            <td>
					                                                <span
					                                                    class="text-muted fw-bolder text-hover-primary mb-1 fs-6"><?= number_format($datashowns->populasi_awal) ?>
					                                                    Ekor</span>
					                                            </td>
					                                            <td>
					                                                <span
					                                                    class="text-muted fw-bolder text-hover-primary mb-1 fs-6"><?= ucwords($datashowns->stock) ?></span>
					                                            </td>
					                                            <td>
					                                                <?= $datashowns->status_kandang == "AKTIF" ? "<span class='badge badge-light-success'>" . ucwords($datashowns->status_kandang) . "</span>" : "<span class='badge badge-light-danger'>" . ucwords($datashowns->status_kandang) . "</span>" ?></span>
					                                            </td>
					                                        </tr>
					                                        <?php }
															} ?>
					                                    </tbody>
					                                </table>
					                            </div>
					                        </div>
					                    </div>
					                </div>-->
					                <?php } ?>
					                <!--end::Stats-->
					                <!--begin::Row-->
					                <div id="loader"></div>
					                <div id="showdata">
					                    <!--begin::Pagination-->
					                    <div class="d-flex flex-stack flex-wrap pt-10">
					                        <!-- <div class="fs-6 fw-bold text-gray-700 text-end">Showing <?= $paginationdata['page'] ?> to <?= $paginationdata['dari'] ?> of <?= $paginationdata['total'] ?> entries</div> -->
					                        <!--begin::Pagination-->
					                        <?php //echo $this->pagination->create_links(); 
											?>
					                        <!--end::Pages-->
					                    </div>
					                    <!--end::Pagination-->
					                </div>
					                <!--begin::Modals-->
					                <!--begin::Modal - View Users-->
					                <div class="modal fade" id="kt_modal_view_users" tabindex="-1" aria-hidden="true">
					                    <!--begin::Modal dialog-->
					                    <div class="modal-dialog mw-650px">
					                        <!--begin::Modal content-->
					                        <div class="modal-content">
					                            <!--begin::Modal header-->
					                            <div class="modal-header pb-0 border-0 justify-content-end">
					                                <!--begin::Close-->
					                                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
					                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
					                                    <span class="svg-icon svg-icon-1">
					                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
					                                            viewBox="0 0 24 24" fill="none">
					                                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
					                                                transform="rotate(-45 6 17.3137)" fill="currentColor" />
					                                            <rect x="7.41422" y="6" width="16" height="2" rx="1"
					                                                transform="rotate(45 7.41422 6)" fill="currentColor" />
					                                        </svg>
					                                    </span>
					                                    <!--end::Svg Icon-->
					                                </div>
					                                <!--end::Close-->
					                            </div>
					                            <!--begin::Modal header-->
					                            <!--begin::Modal body-->
					                            <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
					                                <!--begin::Heading-->
					                                <div class="text-center mb-13">
					                                    <!--begin::Title-->
					                                    <h1 class="mb-3">Browse Users</h1>
					                                    <!--end::Title-->
					                                    <!--begin::Description-->
					                                    <div class="text-muted fw-bold fs-5">If you need more info, please check out
					                                        our
					                                        <a href="#" class="link-primary fw-bolder">Users Directory</a>.
					                                    </div>
					                                    <!--end::Description-->
					                                </div>
					                                <!--end::Heading-->
					                                <!--begin::Users-->
					                                <div class="mb-15">
					                                    <!--begin::List-->
					                                    <div class="mh-375px scroll-y me-n7 pe-7">
					                                        <!--begin::User-->
					                                        <div
					                                            class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
					                                            <!--begin::Details-->
					                                            <div class="d-flex align-items-center">
					                                                <!--begin::Avatar-->
					                                                <div class="symbol symbol-35px symbol-circle">
					                                                    <img alt="Pic"
					                                                        src="<?= base_url() ?>assets/main/media/avatars/300-6.jpg" />
					                                                </div>
					                                                <!--end::Avatar-->
					                                                <!--begin::Details-->
					                                                <div class="ms-6">
					                                                    <!--begin::Name-->
					                                                    <a href="#"
					                                                        class="d-flex align-items-center fs-5 fw-bolder text-dark text-hover-primary">Emma
					                                                        Smith
					                                                        <span class="badge badge-light fs-8 fw-bold ms-2">Art
					                                                            Director</span></a>
					                                                    <!--end::Name-->
					                                                    <!--begin::Email-->
					                                                    <div class="fw-bold text-muted">smith@kpmg.com</div>
					                                                    <!--end::Email-->
					                                                </div>
					                                                <!--end::Details-->
					                                            </div>
					                                            <!--end::Details-->
					                                            <!--begin::Stats-->
					                                            <div class="d-flex">
					                                                <!--begin::Sales-->
					                                                <div class="text-end">
					                                                    <div class="fs-5 fw-bolder text-dark">$23,000</div>
					                                                    <div class="fs-7 text-muted">Sales</div>
					                                                </div>
					                                                <!--end::Sales-->
					                                            </div>
					                                            <!--end::Stats-->
					                                        </div>
					                                        <!--end::User-->
					                                        <!--begin::User-->
					                                        <div
					                                            class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
					                                            <!--begin::Details-->
					                                            <div class="d-flex align-items-center">
					                                                <!--begin::Avatar-->
					                                                <div class="symbol symbol-35px symbol-circle">
					                                                    <span
					                                                        class="symbol-label bg-light-danger text-danger fw-bold">M</span>
					                                                </div>
					                                                <!--end::Avatar-->
					                                                <!--begin::Details-->
					                                                <div class="ms-6">
					                                                    <!--begin::Name-->
					                                                    <a href="#"
					                                                        class="d-flex align-items-center fs-5 fw-bolder text-dark text-hover-primary">Melody
					                                                        Macy
					                                                        <span class="badge badge-light fs-8 fw-bold ms-2">Marketing
					                                                            Analytic</span></a>
					                                                    <!--end::Name-->
					                                                    <!--begin::Email-->
					                                                    <div class="fw-bold text-muted">melody@altbox.com</div>
					                                                    <!--end::Email-->
					                                                </div>
					                                                <!--end::Details-->
					                                            </div>
					                                            <!--end::Details-->
					                                            <!--begin::Stats-->
					                                            <div class="d-flex">
					                                                <!--begin::Sales-->
					                                                <div class="text-end">
					                                                    <div class="fs-5 fw-bolder text-dark">$50,500</div>
					                                                    <div class="fs-7 text-muted">Sales</div>
					                                                </div>
					                                                <!--end::Sales-->
					                                            </div>
					                                            <!--end::Stats-->
					                                        </div>
					                                        <!--end::User-->
					                                        <!--begin::User-->
					                                        <div
					                                            class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
					                                            <!--begin::Details-->
					                                            <div class="d-flex align-items-center">
					                                                <!--begin::Avatar-->
					                                                <div class="symbol symbol-35px symbol-circle">
					                                                    <img alt="Pic"
					                                                        src="<?= base_url() ?>assets/main/media/avatars/300-1.jpg" />
					                                                </div>
					                                                <!--end::Avatar-->
					                                                <!--begin::Details-->
					                                                <div class="ms-6">
					                                                    <!--begin::Name-->
					                                                    <a href="#"
					                                                        class="d-flex align-items-center fs-5 fw-bolder text-dark text-hover-primary">Max
					                                                        Smith
					                                                        <span class="badge badge-light fs-8 fw-bold ms-2">Software
					                                                            Enginer</span></a>
					                                                    <!--end::Name-->
					                                                    <!--begin::Email-->
					                                                    <div class="fw-bold text-muted">max@kt.com</div>
					                                                    <!--end::Email-->
					                                                </div>
					                                                <!--end::Details-->
					                                            </div>
					                                            <!--end::Details-->
					                                            <!--begin::Stats-->
					                                            <div class="d-flex">
					                                                <!--begin::Sales-->
					                                                <div class="text-end">
					                                                    <div class="fs-5 fw-bolder text-dark">$75,900</div>
					                                                    <div class="fs-7 text-muted">Sales</div>
					                                                </div>
					                                                <!--end::Sales-->
					                                            </div>
					                                            <!--end::Stats-->
					                                        </div>
					                                        <!--end::User-->
					                                        <!--begin::User-->
					                                        <div
					                                            class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
					                                            <!--begin::Details-->
					                                            <div class="d-flex align-items-center">
					                                                <!--begin::Avatar-->
					                                                <div class="symbol symbol-35px symbol-circle">
					                                                    <img alt="Pic"
					                                                        src="<?= base_url() ?>assets/main/media/avatars/300-5.jpg" />
					                                                </div>
					                                                <!--end::Avatar-->
					                                                <!--begin::Details-->
					                                                <div class="ms-6">
					                                                    <!--begin::Name-->
					                                                    <a href="#"
					                                                        class="d-flex align-items-center fs-5 fw-bolder text-dark text-hover-primary">Sean
					                                                        Bean
					                                                        <span class="badge badge-light fs-8 fw-bold ms-2">Web
					                                                            Developer</span></a>
					                                                    <!--end::Name-->
					                                                    <!--begin::Email-->
					                                                    <div class="fw-bold text-muted">sean@dellito.com</div>
					                                                    <!--end::Email-->
					                                                </div>
					                                                <!--end::Details-->
					                                            </div>
					                                            <!--end::Details-->
					                                            <!--begin::Stats-->
					                                            <div class="d-flex">
					                                                <!--begin::Sales-->
					                                                <div class="text-end">
					                                                    <div class="fs-5 fw-bolder text-dark">$10,500</div>
					                                                    <div class="fs-7 text-muted">Sales</div>
					                                                </div>
					                                                <!--end::Sales-->
					                                            </div>
					                                            <!--end::Stats-->
					                                        </div>
					                                        <!--end::User-->
					                                        <!--begin::User-->
					                                        <div
					                                            class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
					                                            <!--begin::Details-->
					                                            <div class="d-flex align-items-center">
					                                                <!--begin::Avatar-->
					                                                <div class="symbol symbol-35px symbol-circle">
					                                                    <img alt="Pic"
					                                                        src="<?= base_url() ?>assets/main/media/avatars/300-25.jpg" />
					                                                </div>
					                                                <!--end::Avatar-->
					                                                <!--begin::Details-->
					                                                <div class="ms-6">
					                                                    <!--begin::Name-->
					                                                    <a href="#"
					                                                        class="d-flex align-items-center fs-5 fw-bolder text-dark text-hover-primary">Brian
					                                                        Cox
					                                                        <span class="badge badge-light fs-8 fw-bold ms-2">UI/UX
					                                                            Designer</span></a>
					                                                    <!--end::Name-->
					                                                    <!--begin::Email-->
					                                                    <div class="fw-bold text-muted">brian@exchange.com</div>
					                                                    <!--end::Email-->
					                                                </div>
					                                                <!--end::Details-->
					                                            </div>
					                                            <!--end::Details-->
					                                            <!--begin::Stats-->
					                                            <div class="d-flex">
					                                                <!--begin::Sales-->
					                                                <div class="text-end">
					                                                    <div class="fs-5 fw-bolder text-dark">$20,000</div>
					                                                    <div class="fs-7 text-muted">Sales</div>
					                                                </div>
					                                                <!--end::Sales-->
					                                            </div>
					                                            <!--end::Stats-->
					                                        </div>
					                                        <!--end::User-->
					                                        <!--begin::User-->
					                                        <div
					                                            class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
					                                            <!--begin::Details-->
					                                            <div class="d-flex align-items-center">
					                                                <!--begin::Avatar-->
					                                                <div class="symbol symbol-35px symbol-circle">
					                                                    <span
					                                                        class="symbol-label bg-light-warning text-warning fw-bold">C</span>
					                                                </div>
					                                                <!--end::Avatar-->
					                                                <!--begin::Details-->
					                                                <div class="ms-6">
					                                                    <!--begin::Name-->
					                                                    <a href="#"
					                                                        class="d-flex align-items-center fs-5 fw-bolder text-dark text-hover-primary">Mikaela
					                                                        Collins
					                                                        <span class="badge badge-light fs-8 fw-bold ms-2">Head Of
					                                                            Marketing</span></a>
					                                                    <!--end::Name-->
					                                                    <!--begin::Email-->
					                                                    <div class="fw-bold text-muted">mik@pex.com</div>
					                                                    <!--end::Email-->
					                                                </div>
					                                                <!--end::Details-->
					                                            </div>
					                                            <!--end::Details-->
					                                            <!--begin::Stats-->
					                                            <div class="d-flex">
					                                                <!--begin::Sales-->
					                                                <div class="text-end">
					                                                    <div class="fs-5 fw-bolder text-dark">$9,300</div>
					                                                    <div class="fs-7 text-muted">Sales</div>
					                                                </div>
					                                                <!--end::Sales-->
					                                            </div>
					                                            <!--end::Stats-->
					                                        </div>
					                                        <!--end::User-->
					                                        <!--begin::User-->
					                                        <div
					                                            class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
					                                            <!--begin::Details-->
					                                            <div class="d-flex align-items-center">
					                                                <!--begin::Avatar-->
					                                                <div class="symbol symbol-35px symbol-circle">
					                                                    <img alt="Pic"
					                                                        src="<?= base_url() ?>assets/main/media/avatars/300-9.jpg" />
					                                                </div>
					                                                <!--end::Avatar-->
					                                                <!--begin::Details-->
					                                                <div class="ms-6">
					                                                    <!--begin::Name-->
					                                                    <a href="#"
					                                                        class="d-flex align-items-center fs-5 fw-bolder text-dark text-hover-primary">Francis
					                                                        Mitcham
					                                                        <span class="badge badge-light fs-8 fw-bold ms-2">Software
					                                                            Arcitect</span></a>
					                                                    <!--end::Name-->
					                                                    <!--begin::Email-->
					                                                    <div class="fw-bold text-muted">f.mit@kpmg.com</div>
					                                                    <!--end::Email-->
					                                                </div>
					                                                <!--end::Details-->
					                                            </div>
					                                            <!--end::Details-->
					                                            <!--begin::Stats-->
					                                            <div class="d-flex">
					                                                <!--begin::Sales-->
					                                                <div class="text-end">
					                                                    <div class="fs-5 fw-bolder text-dark">$15,000</div>
					                                                    <div class="fs-7 text-muted">Sales</div>
					                                                </div>
					                                                <!--end::Sales-->
					                                            </div>
					                                            <!--end::Stats-->
					                                        </div>
					                                        <!--end::User-->
					                                        <!--begin::User-->
					                                        <div
					                                            class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
					                                            <!--begin::Details-->
					                                            <div class="d-flex align-items-center">
					                                                <!--begin::Avatar-->
					                                                <div class="symbol symbol-35px symbol-circle">
					                                                    <span
					                                                        class="symbol-label bg-light-danger text-danger fw-bold">O</span>
					                                                </div>
					                                                <!--end::Avatar-->
					                                                <!--begin::Details-->
					                                                <div class="ms-6">
					                                                    <!--begin::Name-->
					                                                    <a href="#"
					                                                        class="d-flex align-items-center fs-5 fw-bolder text-dark text-hover-primary">Olivia
					                                                        Wild
					                                                        <span class="badge badge-light fs-8 fw-bold ms-2">System
					                                                            Admin</span></a>
					                                                    <!--end::Name-->
					                                                    <!--begin::Email-->
					                                                    <div class="fw-bold text-muted">olivia@corpmail.com</div>
					                                                    <!--end::Email-->
					                                                </div>
					                                                <!--end::Details-->
					                                            </div>
					                                            <!--end::Details-->
					                                            <!--begin::Stats-->
					                                            <div class="d-flex">
					                                                <!--begin::Sales-->
					                                                <div class="text-end">
					                                                    <div class="fs-5 fw-bolder text-dark">$23,000</div>
					                                                    <div class="fs-7 text-muted">Sales</div>
					                                                </div>
					                                                <!--end::Sales-->
					                                            </div>
					                                            <!--end::Stats-->
					                                        </div>
					                                        <!--end::User-->
					                                        <!--begin::User-->
					                                        <div
					                                            class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
					                                            <!--begin::Details-->
					                                            <div class="d-flex align-items-center">
					                                                <!--begin::Avatar-->
					                                                <div class="symbol symbol-35px symbol-circle">
					                                                    <span
					                                                        class="symbol-label bg-light-primary text-primary fw-bold">N</span>
					                                                </div>
					                                                <!--end::Avatar-->
					                                                <!--begin::Details-->
					                                                <div class="ms-6">
					                                                    <!--begin::Name-->
					                                                    <a href="#"
					                                                        class="d-flex align-items-center fs-5 fw-bolder text-dark text-hover-primary">Neil
					                                                        Owen
					                                                        <span class="badge badge-light fs-8 fw-bold ms-2">Account
					                                                            Manager</span></a>
					                                                    <!--end::Name-->
					                                                    <!--begin::Email-->
					                                                    <div class="fw-bold text-muted">owen.neil@gmail.com</div>
					                                                    <!--end::Email-->
					                                                </div>
					                                                <!--end::Details-->
					                                            </div>
					                                            <!--end::Details-->
					                                            <!--begin::Stats-->
					                                            <div class="d-flex">
					                                                <!--begin::Sales-->
					                                                <div class="text-end">
					                                                    <div class="fs-5 fw-bolder text-dark">$45,800</div>
					                                                    <div class="fs-7 text-muted">Sales</div>
					                                                </div>
					                                                <!--end::Sales-->
					                                            </div>
					                                            <!--end::Stats-->
					                                        </div>
					                                        <!--end::User-->
					                                        <!--begin::User-->
					                                        <div
					                                            class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
					                                            <!--begin::Details-->
					                                            <div class="d-flex align-items-center">
					                                                <!--begin::Avatar-->
					                                                <div class="symbol symbol-35px symbol-circle">
					                                                    <img alt="Pic"
					                                                        src="<?= base_url() ?>assets/main/media/avatars/300-23.jpg" />
					                                                </div>
					                                                <!--end::Avatar-->
					                                                <!--begin::Details-->
					                                                <div class="ms-6">
					                                                    <!--begin::Name-->
					                                                    <a href="#"
					                                                        class="d-flex align-items-center fs-5 fw-bolder text-dark text-hover-primary">Dan
					                                                        Wilson
					                                                        <span class="badge badge-light fs-8 fw-bold ms-2">Web
					                                                            Desinger</span></a>
					                                                    <!--end::Name-->
					                                                    <!--begin::Email-->
					                                                    <div class="fw-bold text-muted">dam@consilting.com</div>
					                                                    <!--end::Email-->
					                                                </div>
					                                                <!--end::Details-->
					                                            </div>
					                                            <!--end::Details-->
					                                            <!--begin::Stats-->
					                                            <div class="d-flex">
					                                                <!--begin::Sales-->
					                                                <div class="text-end">
					                                                    <div class="fs-5 fw-bolder text-dark">$90,500</div>
					                                                    <div class="fs-7 text-muted">Sales</div>
					                                                </div>
					                                                <!--end::Sales-->
					                                            </div>
					                                            <!--end::Stats-->
					                                        </div>
					                                        <!--end::User-->
					                                        <!--begin::User-->
					                                        <div
					                                            class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
					                                            <!--begin::Details-->
					                                            <div class="d-flex align-items-center">
					                                                <!--begin::Avatar-->
					                                                <div class="symbol symbol-35px symbol-circle">
					                                                    <span
					                                                        class="symbol-label bg-light-danger text-danger fw-bold">E</span>
					                                                </div>
					                                                <!--end::Avatar-->
					                                                <!--begin::Details-->
					                                                <div class="ms-6">
					                                                    <!--begin::Name-->
					                                                    <a href="#"
					                                                        class="d-flex align-items-center fs-5 fw-bolder text-dark text-hover-primary">Emma
					                                                        Bold
					                                                        <span class="badge badge-light fs-8 fw-bold ms-2">Corporate
					                                                            Finance</span></a>
					                                                    <!--end::Name-->
					                                                    <!--begin::Email-->
					                                                    <div class="fw-bold text-muted">emma@intenso.com</div>
					                                                    <!--end::Email-->
					                                                </div>
					                                                <!--end::Details-->
					                                            </div>
					                                            <!--end::Details-->
					                                            <!--begin::Stats-->
					                                            <div class="d-flex">
					                                                <!--begin::Sales-->
					                                                <div class="text-end">
					                                                    <div class="fs-5 fw-bolder text-dark">$5,000</div>
					                                                    <div class="fs-7 text-muted">Sales</div>
					                                                </div>
					                                                <!--end::Sales-->
					                                            </div>
					                                            <!--end::Stats-->
					                                        </div>
					                                        <!--end::User-->
					                                        <!--begin::User-->
					                                        <div
					                                            class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
					                                            <!--begin::Details-->
					                                            <div class="d-flex align-items-center">
					                                                <!--begin::Avatar-->
					                                                <div class="symbol symbol-35px symbol-circle">
					                                                    <img alt="Pic"
					                                                        src="<?= base_url() ?>assets/main/media/avatars/300-12.jpg" />
					                                                </div>
					                                                <!--end::Avatar-->
					                                                <!--begin::Details-->
					                                                <div class="ms-6">
					                                                    <!--begin::Name-->
					                                                    <a href="#"
					                                                        class="d-flex align-items-center fs-5 fw-bolder text-dark text-hover-primary">Ana
					                                                        Crown
					                                                        <span class="badge badge-light fs-8 fw-bold ms-2">Customer
					                                                            Relationship</span></a>
					                                                    <!--end::Name-->
					                                                    <!--begin::Email-->
					                                                    <div class="fw-bold text-muted">ana.cf@limtel.com</div>
					                                                    <!--end::Email-->
					                                                </div>
					                                                <!--end::Details-->
					                                            </div>
					                                            <!--end::Details-->
					                                            <!--begin::Stats-->
					                                            <div class="d-flex">
					                                                <!--begin::Sales-->
					                                                <div class="text-end">
					                                                    <div class="fs-5 fw-bolder text-dark">$70,000</div>
					                                                    <div class="fs-7 text-muted">Sales</div>
					                                                </div>
					                                                <!--end::Sales-->
					                                            </div>
					                                            <!--end::Stats-->
					                                        </div>
					                                        <!--end::User-->
					                                        <!--begin::User-->
					                                        <div class="d-flex flex-stack py-5">
					                                            <!--begin::Details-->
					                                            <div class="d-flex align-items-center">
					                                                <!--begin::Avatar-->
					                                                <div class="symbol symbol-35px symbol-circle">
					                                                    <span
					                                                        class="symbol-label bg-light-info text-info fw-bold">A</span>
					                                                </div>
					                                                <!--end::Avatar-->
					                                                <!--begin::Details-->
					                                                <div class="ms-6">
					                                                    <!--begin::Name-->
					                                                    <a href="#"
					                                                        class="d-flex align-items-center fs-5 fw-bolder text-dark text-hover-primary">Robert
					                                                        Doe
					                                                        <span class="badge badge-light fs-8 fw-bold ms-2">Marketing
					                                                            Executive</span></a>
					                                                    <!--end::Name-->
					                                                    <!--begin::Email-->
					                                                    <div class="fw-bold text-muted">robert@benko.com</div>
					                                                    <!--end::Email-->
					                                                </div>
					                                                <!--end::Details-->
					                                            </div>
					                                            <!--end::Details-->
					                                            <!--begin::Stats-->
					                                            <div class="d-flex">
					                                                <!--begin::Sales-->
					                                                <div class="text-end">
					                                                    <div class="fs-5 fw-bolder text-dark">$45,500</div>
					                                                    <div class="fs-7 text-muted">Sales</div>
					                                                </div>
					                                                <!--end::Sales-->
					                                            </div>
					                                            <!--end::Stats-->
					                                        </div>
					                                        <!--end::User-->
					                                    </div>
					                                    <!--end::List-->
					                                </div>
					                                <!--end::Users-->
					                                <!--begin::Notice-->
					                                <div class="d-flex justify-content-between">
					                                    <!--begin::Label-->
					                                    <div class="fw-bold">
					                                        <label class="fs-6">Adding Users by Team Members</label>
					                                        <div class="fs-7 text-muted">If you need more info, please check budget
					                                            planning</div>
					                                    </div>
					                                    <!--end::Label-->
					                                    <!--begin::Switch-->
					                                    <label class="form-check form-switch form-check-custom form-check-solid">
					                                        <input class="form-check-input" type="checkbox" value=""
					                                            checked="checked" />
					                                        <span class="form-check-label fw-bold text-muted">Allowed</span>
					                                    </label>
					                                    <!--end::Switch-->
					                                </div>
					                                <!--end::Notice-->
					                            </div>
					                            <!--end::Modal body-->
					                        </div>
					                        <!--end::Modal content-->
					                    </div>
					                    <!--end::Modal dialog-->
					                </div>
					                <!--end::Modal - View Users-->
					                <!--begin::Modal - Users Search-->
					                <div class="modal fade" id="kt_modal_users_search" tabindex="-1" aria-hidden="true">
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
					                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
					                                            viewBox="0 0 24 24" fill="none">
					                                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
					                                                transform="rotate(-45 6 17.3137)" fill="currentColor" />
					                                            <rect x="7.41422" y="6" width="16" height="2" rx="1"
					                                                transform="rotate(45 7.41422 6)" fill="currentColor" />
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
					                                    <h1 class="mb-3">Search Users</h1>
					                                    <div class="text-muted fw-bold fs-5">Invite Collaborators To Your Project</div>
					                                </div>
					                                <!--end::Content-->
					                                <!--begin::Search-->
					                                <div id="kt_modal_users_search_handler" data-kt-search-keypress="true"
					                                    data-kt-search-min-length="2" data-kt-search-enter="enter"
					                                    data-kt-search-layout="inline">
					                                    <!--begin::Form-->
					                                    <form data-kt-search-element="form" class="w-100 position-relative mb-5"
					                                        autocomplete="off">
					                                        <!--begin::Hidden input(Added to disable form autocomplete)-->
					                                        <input type="hidden" />
					                                        <!--end::Hidden input-->
					                                        <!--begin::Icon-->
					                                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
					                                        <span
					                                            class="svg-icon svg-icon-2 svg-icon-lg-1 svg-icon-gray-500 position-absolute top-50 ms-5 translate-middle-y">
					                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
					                                                viewBox="0 0 24 24" fill="none">
					                                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
					                                                    height="2" rx="1" transform="rotate(45 17.0365 15.1223)"
					                                                    fill="currentColor" />
					                                                <path
					                                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
					                                                    fill="currentColor" />
					                                            </svg>
					                                        </span>
					                                        <!--end::Svg Icon-->
					                                        <!--end::Icon-->
					                                        <!--begin::Spinner-->
					                                        <span
					                                            class="position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-5"
					                                            data-kt-search-element="spinner">
					                                            <span
					                                                class="spinner-border h-15px w-15px align-middle text-muted"></span>
					                                        </span>
					                                        <!--end::Spinner-->
					                                        <!--begin::Reset-->
					                                        <span
					                                            class="btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 me-5 d-none"
					                                            data-kt-search-element="clear">
					                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
					                                            <span class="svg-icon svg-icon-2 svg-icon-lg-1 me-0">
					                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
					                                                    viewBox="0 0 24 24" fill="none">
					                                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
					                                                        rx="1" transform="rotate(-45 6 17.3137)"
					                                                        fill="currentColor" />
					                                                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
					                                                        transform="rotate(45 7.41422 6)" fill="currentColor" />
					                                                </svg>
					                                            </span>
					                                            <!--end::Svg Icon-->
					                                        </span>
					                                        <!--end::Reset-->
					                                    </form>
					                                    <!--end::Form-->
					                                    <!--begin::Wrapper-->
					                                    <div class="py-5">
					                                        <!--begin::Suggestions-->
					                                        <div data-kt-search-element="suggestions">
					                                            <!--begin::Heading-->
					                                            <h3 class="fw-bold mb-5">Recently searched:</h3>
					                                            <!--end::Heading-->
					                                            <!--begin::Users-->
					                                            <div class="mh-375px scroll-y me-n7 pe-7">
					                                                <!--begin::User-->
					                                                <a href="#"
					                                                    class="d-flex align-items-center p-3 rounded bg-state-light bg-state-opacity-50 mb-1">
					                                                    <!--begin::Avatar-->
					                                                    <div class="symbol symbol-35px symbol-circle me-5">
					                                                        <img alt="Pic"
					                                                            src="<?= base_url() ?>assets/main/media/avatars/300-6.jpg" />
					                                                    </div>
					                                                    <!--end::Avatar-->
					                                                    <!--begin::Info-->
					                                                    <div class="fw-bold">
					                                                        <span class="fs-6 text-gray-800 me-2">Emma Smith</span>
					                                                        <span class="badge badge-light">Art Director</span>
					                                                    </div>
					                                                    <!--end::Info-->
					                                                </a>
					                                                <!--end::User-->
					                                                <!--begin::User-->
					                                                <a href="#"
					                                                    class="d-flex align-items-center p-3 rounded bg-state-light bg-state-opacity-50 mb-1">
					                                                    <!--begin::Avatar-->
					                                                    <div class="symbol symbol-35px symbol-circle me-5">
					                                                        <span
					                                                            class="symbol-label bg-light-danger text-danger fw-bold">M</span>
					                                                    </div>
					                                                    <!--end::Avatar-->
					                                                    <!--begin::Info-->
					                                                    <div class="fw-bold">
					                                                        <span class="fs-6 text-gray-800 me-2">Melody Macy</span>
					                                                        <span class="badge badge-light">Marketing Analytic</span>
					                                                    </div>
					                                                    <!--end::Info-->
					                                                </a>
					                                                <!--end::User-->
					                                                <!--begin::User-->
					                                                <a href="#"
					                                                    class="d-flex align-items-center p-3 rounded bg-state-light bg-state-opacity-50 mb-1">
					                                                    <!--begin::Avatar-->
					                                                    <div class="symbol symbol-35px symbol-circle me-5">
					                                                        <img alt="Pic"
					                                                            src="<?= base_url() ?>assets/main/media/avatars/300-1.jpg" />
					                                                    </div>
					                                                    <!--end::Avatar-->
					                                                    <!--begin::Info-->
					                                                    <div class="fw-bold">
					                                                        <span class="fs-6 text-gray-800 me-2">Max Smith</span>
					                                                        <span class="badge badge-light">Software Enginer</span>
					                                                    </div>
					                                                    <!--end::Info-->
					                                                </a>
					                                                <!--end::User-->
					                                                <!--begin::User-->
					                                                <a href="#"
					                                                    class="d-flex align-items-center p-3 rounded bg-state-light bg-state-opacity-50 mb-1">
					                                                    <!--begin::Avatar-->
					                                                    <div class="symbol symbol-35px symbol-circle me-5">
					                                                        <img alt="Pic"
					                                                            src="<?= base_url() ?>assets/main/media/avatars/300-5.jpg" />
					                                                    </div>
					                                                    <!--end::Avatar-->
					                                                    <!--begin::Info-->
					                                                    <div class="fw-bold">
					                                                        <span class="fs-6 text-gray-800 me-2">Sean Bean</span>
					                                                        <span class="badge badge-light">Web Developer</span>
					                                                    </div>
					                                                    <!--end::Info-->
					                                                </a>
					                                                <!--end::User-->
					                                                <!--begin::User-->
					                                                <a href="#"
					                                                    class="d-flex align-items-center p-3 rounded bg-state-light bg-state-opacity-50 mb-1">
					                                                    <!--begin::Avatar-->
					                                                    <div class="symbol symbol-35px symbol-circle me-5">
					                                                        <img alt="Pic"
					                                                            src="<?= base_url() ?>assets/main/media/avatars/300-25.jpg" />
					                                                    </div>
					                                                    <!--end::Avatar-->
					                                                    <!--begin::Info-->
					                                                    <div class="fw-bold">
					                                                        <span class="fs-6 text-gray-800 me-2">Brian Cox</span>
					                                                        <span class="badge badge-light">UI/UX Designer</span>
					                                                    </div>
					                                                    <!--end::Info-->
					                                                </a>
					                                                <!--end::User-->
					                                            </div>
					                                            <!--end::Users-->
					                                        </div>
					                                        <!--end::Suggestions-->
					                                        <!--begin::Results(add d-none to below element to hide the users list by default)-->
					                                        <div data-kt-search-element="results" class="d-none">
					                                            <!--begin::Users-->
					                                            <div class="mh-375px scroll-y me-n7 pe-7">
					                                                <!--begin::User-->
					                                                <div class="rounded d-flex flex-stack bg-active-lighten p-4"
					                                                    data-user-id="0">
					                                                    <!--begin::Details-->
					                                                    <div class="d-flex align-items-center">
					                                                        <!--begin::Checkbox-->
					                                                        <label
					                                                            class="form-check form-check-custom form-check-solid me-5">
					                                                            <input class="form-check-input" type="checkbox"
					                                                                name="users" data-kt-check="true"
					                                                                data-kt-check-target="[data-user-id='0']"
					                                                                value="0" />
					                                                        </label>
					                                                        <!--end::Checkbox-->
					                                                        <!--begin::Avatar-->
					                                                        <div class="symbol symbol-35px symbol-circle">
					                                                            <img alt="Pic"
					                                                                src="<?= base_url() ?>assets/main/media/avatars/300-6.jpg" />
					                                                        </div>
					                                                        <!--end::Avatar-->
					                                                        <!--begin::Details-->
					                                                        <div class="ms-5">
					                                                            <a href="#"
					                                                                class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Emma
					                                                                Smith</a>
					                                                            <div class="fw-bold text-muted">smith@kpmg.com</div>
					                                                        </div>
					                                                        <!--end::Details-->
					                                                    </div>
					                                                    <!--end::Details-->
					                                                    <!--begin::Access menu-->
					                                                    <div class="ms-2 w-100px">
					                                                        <select
					                                                            class="form-select form-select-solid form-select-sm"
					                                                            data-control="select2" data-hide-search="true">
					                                                            <option value="1">Guest</option>
					                                                            <option value="2" selected="selected">Owner</option>
					                                                            <option value="3">Can Edit</option>
					                                                        </select>
					                                                    </div>
					                                                    <!--end::Access menu-->
					                                                </div>
					                                                <!--end::User-->
					                                                <!--begin::Separator-->
					                                                <div class="border-bottom border-gray-300 border-bottom-dashed">
					                                                </div>
					                                                <!--end::Separator-->
					                                                <!--begin::User-->
					                                                <div class="rounded d-flex flex-stack bg-active-lighten p-4"
					                                                    data-user-id="1">
					                                                    <!--begin::Details-->
					                                                    <div class="d-flex align-items-center">
					                                                        <!--begin::Checkbox-->
					                                                        <label
					                                                            class="form-check form-check-custom form-check-solid me-5">
					                                                            <input class="form-check-input" type="checkbox"
					                                                                name="users" data-kt-check="true"
					                                                                data-kt-check-target="[data-user-id='1']"
					                                                                value="1" />
					                                                        </label>
					                                                        <!--end::Checkbox-->
					                                                        <!--begin::Avatar-->
					                                                        <div class="symbol symbol-35px symbol-circle">
					                                                            <span
					                                                                class="symbol-label bg-light-danger text-danger fw-bold">M</span>
					                                                        </div>
					                                                        <!--end::Avatar-->
					                                                        <!--begin::Details-->
					                                                        <div class="ms-5">
					                                                            <a href="#"
					                                                                class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Melody
					                                                                Macy</a>
					                                                            <div class="fw-bold text-muted">melody@altbox.com</div>
					                                                        </div>
					                                                        <!--end::Details-->
					                                                    </div>
					                                                    <!--end::Details-->
					                                                    <!--begin::Access menu-->
					                                                    <div class="ms-2 w-100px">
					                                                        <select
					                                                            class="form-select form-select-solid form-select-sm"
					                                                            data-control="select2" data-hide-search="true">
					                                                            <option value="1" selected="selected">Guest</option>
					                                                            <option value="2">Owner</option>
					                                                            <option value="3">Can Edit</option>
					                                                        </select>
					                                                    </div>
					                                                    <!--end::Access menu-->
					                                                </div>
					                                                <!--end::User-->
					                                                <!--begin::Separator-->
					                                                <div class="border-bottom border-gray-300 border-bottom-dashed">
					                                                </div>
					                                                <!--end::Separator-->
					                                                <!--begin::User-->
					                                                <div class="rounded d-flex flex-stack bg-active-lighten p-4"
					                                                    data-user-id="2">
					                                                    <!--begin::Details-->
					                                                    <div class="d-flex align-items-center">
					                                                        <!--begin::Checkbox-->
					                                                        <label
					                                                            class="form-check form-check-custom form-check-solid me-5">
					                                                            <input class="form-check-input" type="checkbox"
					                                                                name="users" data-kt-check="true"
					                                                                data-kt-check-target="[data-user-id='2']"
					                                                                value="2" />
					                                                        </label>
					                                                        <!--end::Checkbox-->
					                                                        <!--begin::Avatar-->
					                                                        <div class="symbol symbol-35px symbol-circle">
					                                                            <img alt="Pic"
					                                                                src="<?= base_url() ?>assets/main/media/avatars/300-1.jpg" />
					                                                        </div>
					                                                        <!--end::Avatar-->
					                                                        <!--begin::Details-->
					                                                        <div class="ms-5">
					                                                            <a href="#"
					                                                                class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Max
					                                                                Smith</a>
					                                                            <div class="fw-bold text-muted">max@kt.com</div>
					                                                        </div>
					                                                        <!--end::Details-->
					                                                    </div>
					                                                    <!--end::Details-->
					                                                    <!--begin::Access menu-->
					                                                    <div class="ms-2 w-100px">
					                                                        <select
					                                                            class="form-select form-select-solid form-select-sm"
					                                                            data-control="select2" data-hide-search="true">
					                                                            <option value="1">Guest</option>
					                                                            <option value="2">Owner</option>
					                                                            <option value="3" selected="selected">Can Edit</option>
					                                                        </select>
					                                                    </div>
					                                                    <!--end::Access menu-->
					                                                </div>
					                                                <!--end::User-->
					                                                <!--begin::Separator-->
					                                                <div class="border-bottom border-gray-300 border-bottom-dashed">
					                                                </div>
					                                                <!--end::Separator-->
					                                                <!--begin::User-->
					                                                <div class="rounded d-flex flex-stack bg-active-lighten p-4"
					                                                    data-user-id="3">
					                                                    <!--begin::Details-->
					                                                    <div class="d-flex align-items-center">
					                                                        <!--begin::Checkbox-->
					                                                        <label
					                                                            class="form-check form-check-custom form-check-solid me-5">
					                                                            <input class="form-check-input" type="checkbox"
					                                                                name="users" data-kt-check="true"
					                                                                data-kt-check-target="[data-user-id='3']"
					                                                                value="3" />
					                                                        </label>
					                                                        <!--end::Checkbox-->
					                                                        <!--begin::Avatar-->
					                                                        <div class="symbol symbol-35px symbol-circle">
					                                                            <img alt="Pic"
					                                                                src="<?= base_url() ?>assets/main/media/avatars/300-5.jpg" />
					                                                        </div>
					                                                        <!--end::Avatar-->
					                                                        <!--begin::Details-->
					                                                        <div class="ms-5">
					                                                            <a href="#"
					                                                                class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Sean
					                                                                Bean</a>
					                                                            <div class="fw-bold text-muted">sean@dellito.com</div>
					                                                        </div>
					                                                        <!--end::Details-->
					                                                    </div>
					                                                    <!--end::Details-->
					                                                    <!--begin::Access menu-->
					                                                    <div class="ms-2 w-100px">
					                                                        <select
					                                                            class="form-select form-select-solid form-select-sm"
					                                                            data-control="select2" data-hide-search="true">
					                                                            <option value="1">Guest</option>
					                                                            <option value="2" selected="selected">Owner</option>
					                                                            <option value="3">Can Edit</option>
					                                                        </select>
					                                                    </div>
					                                                    <!--end::Access menu-->
					                                                </div>
					                                                <!--end::User-->
					                                                <!--begin::Separator-->
					                                                <div class="border-bottom border-gray-300 border-bottom-dashed">
					                                                </div>
					                                                <!--end::Separator-->
					                                                <!--begin::User-->
					                                                <div class="rounded d-flex flex-stack bg-active-lighten p-4"
					                                                    data-user-id="4">
					                                                    <!--begin::Details-->
					                                                    <div class="d-flex align-items-center">
					                                                        <!--begin::Checkbox-->
					                                                        <label
					                                                            class="form-check form-check-custom form-check-solid me-5">
					                                                            <input class="form-check-input" type="checkbox"
					                                                                name="users" data-kt-check="true"
					                                                                data-kt-check-target="[data-user-id='4']"
					                                                                value="4" />
					                                                        </label>
					                                                        <!--end::Checkbox-->
					                                                        <!--begin::Avatar-->
					                                                        <div class="symbol symbol-35px symbol-circle">
					                                                            <img alt="Pic"
					                                                                src="<?= base_url() ?>assets/main/media/avatars/300-25.jpg" />
					                                                        </div>
					                                                        <!--end::Avatar-->
					                                                        <!--begin::Details-->
					                                                        <div class="ms-5">
					                                                            <a href="#"
					                                                                class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Brian
					                                                                Cox</a>
					                                                            <div class="fw-bold text-muted">brian@exchange.com
					                                                            </div>
					                                                        </div>
					                                                        <!--end::Details-->
					                                                    </div>
					                                                    <!--end::Details-->
					                                                    <!--begin::Access menu-->
					                                                    <div class="ms-2 w-100px">
					                                                        <select
					                                                            class="form-select form-select-solid form-select-sm"
					                                                            data-control="select2" data-hide-search="true">
					                                                            <option value="1">Guest</option>
					                                                            <option value="2">Owner</option>
					                                                            <option value="3" selected="selected">Can Edit</option>
					                                                        </select>
					                                                    </div>
					                                                    <!--end::Access menu-->
					                                                </div>
					                                                <!--end::User-->
					                                                <!--begin::Separator-->
					                                                <div class="border-bottom border-gray-300 border-bottom-dashed">
					                                                </div>
					                                                <!--end::Separator-->
					                                                <!--begin::User-->
					                                                <div class="rounded d-flex flex-stack bg-active-lighten p-4"
					                                                    data-user-id="5">
					                                                    <!--begin::Details-->
					                                                    <div class="d-flex align-items-center">
					                                                        <!--begin::Checkbox-->
					                                                        <label
					                                                            class="form-check form-check-custom form-check-solid me-5">
					                                                            <input class="form-check-input" type="checkbox"
					                                                                name="users" data-kt-check="true"
					                                                                data-kt-check-target="[data-user-id='5']"
					                                                                value="5" />
					                                                        </label>
					                                                        <!--end::Checkbox-->
					                                                        <!--begin::Avatar-->
					                                                        <div class="symbol symbol-35px symbol-circle">
					                                                            <span
					                                                                class="symbol-label bg-light-warning text-warning fw-bold">C</span>
					                                                        </div>
					                                                        <!--end::Avatar-->
					                                                        <!--begin::Details-->
					                                                        <div class="ms-5">
					                                                            <a href="#"
					                                                                class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Mikaela
					                                                                Collins</a>
					                                                            <div class="fw-bold text-muted">mik@pex.com</div>
					                                                        </div>
					                                                        <!--end::Details-->
					                                                    </div>
					                                                    <!--end::Details-->
					                                                    <!--begin::Access menu-->
					                                                    <div class="ms-2 w-100px">
					                                                        <select
					                                                            class="form-select form-select-solid form-select-sm"
					                                                            data-control="select2" data-hide-search="true">
					                                                            <option value="1">Guest</option>
					                                                            <option value="2" selected="selected">Owner</option>
					                                                            <option value="3">Can Edit</option>
					                                                        </select>
					                                                    </div>
					                                                    <!--end::Access menu-->
					                                                </div>
					                                                <!--end::User-->
					                                                <!--begin::Separator-->
					                                                <div class="border-bottom border-gray-300 border-bottom-dashed">
					                                                </div>
					                                                <!--end::Separator-->
					                                                <!--begin::User-->
					                                                <div class="rounded d-flex flex-stack bg-active-lighten p-4"
					                                                    data-user-id="6">
					                                                    <!--begin::Details-->
					                                                    <div class="d-flex align-items-center">
					                                                        <!--begin::Checkbox-->
					                                                        <label
					                                                            class="form-check form-check-custom form-check-solid me-5">
					                                                            <input class="form-check-input" type="checkbox"
					                                                                name="users" data-kt-check="true"
					                                                                data-kt-check-target="[data-user-id='6']"
					                                                                value="6" />
					                                                        </label>
					                                                        <!--end::Checkbox-->
					                                                        <!--begin::Avatar-->
					                                                        <div class="symbol symbol-35px symbol-circle">
					                                                            <img alt="Pic"
					                                                                src="<?= base_url() ?>assets/main/media/avatars/300-9.jpg" />
					                                                        </div>
					                                                        <!--end::Avatar-->
					                                                        <!--begin::Details-->
					                                                        <div class="ms-5">
					                                                            <a href="#"
					                                                                class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Francis
					                                                                Mitcham</a>
					                                                            <div class="fw-bold text-muted">f.mit@kpmg.com</div>
					                                                        </div>
					                                                        <!--end::Details-->
					                                                    </div>
					                                                    <!--end::Details-->
					                                                    <!--begin::Access menu-->
					                                                    <div class="ms-2 w-100px">
					                                                        <select
					                                                            class="form-select form-select-solid form-select-sm"
					                                                            data-control="select2" data-hide-search="true">
					                                                            <option value="1">Guest</option>
					                                                            <option value="2">Owner</option>
					                                                            <option value="3" selected="selected">Can Edit</option>
					                                                        </select>
					                                                    </div>
					                                                    <!--end::Access menu-->
					                                                </div>
					                                                <!--end::User-->
					                                                <!--begin::Separator-->
					                                                <div class="border-bottom border-gray-300 border-bottom-dashed">
					                                                </div>
					                                                <!--end::Separator-->
					                                                <!--begin::User-->
					                                                <div class="rounded d-flex flex-stack bg-active-lighten p-4"
					                                                    data-user-id="7">
					                                                    <!--begin::Details-->
					                                                    <div class="d-flex align-items-center">
					                                                        <!--begin::Checkbox-->
					                                                        <label
					                                                            class="form-check form-check-custom form-check-solid me-5">
					                                                            <input class="form-check-input" type="checkbox"
					                                                                name="users" data-kt-check="true"
					                                                                data-kt-check-target="[data-user-id='7']"
					                                                                value="7" />
					                                                        </label>
					                                                        <!--end::Checkbox-->
					                                                        <!--begin::Avatar-->
					                                                        <div class="symbol symbol-35px symbol-circle">
					                                                            <span
					                                                                class="symbol-label bg-light-danger text-danger fw-bold">O</span>
					                                                        </div>
					                                                        <!--end::Avatar-->
					                                                        <!--begin::Details-->
					                                                        <div class="ms-5">
					                                                            <a href="#"
					                                                                class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Olivia
					                                                                Wild</a>
					                                                            <div class="fw-bold text-muted">olivia@corpmail.com
					                                                            </div>
					                                                        </div>
					                                                        <!--end::Details-->
					                                                    </div>
					                                                    <!--end::Details-->
					                                                    <!--begin::Access menu-->
					                                                    <div class="ms-2 w-100px">
					                                                        <select
					                                                            class="form-select form-select-solid form-select-sm"
					                                                            data-control="select2" data-hide-search="true">
					                                                            <option value="1">Guest</option>
					                                                            <option value="2" selected="selected">Owner</option>
					                                                            <option value="3">Can Edit</option>
					                                                        </select>
					                                                    </div>
					                                                    <!--end::Access menu-->
					                                                </div>
					                                                <!--end::User-->
					                                                <!--begin::Separator-->
					                                                <div class="border-bottom border-gray-300 border-bottom-dashed">
					                                                </div>
					                                                <!--end::Separator-->
					                                                <!--begin::User-->
					                                                <div class="rounded d-flex flex-stack bg-active-lighten p-4"
					                                                    data-user-id="8">
					                                                    <!--begin::Details-->
					                                                    <div class="d-flex align-items-center">
					                                                        <!--begin::Checkbox-->
					                                                        <label
					                                                            class="form-check form-check-custom form-check-solid me-5">
					                                                            <input class="form-check-input" type="checkbox"
					                                                                name="users" data-kt-check="true"
					                                                                data-kt-check-target="[data-user-id='8']"
					                                                                value="8" />
					                                                        </label>
					                                                        <!--end::Checkbox-->
					                                                        <!--begin::Avatar-->
					                                                        <div class="symbol symbol-35px symbol-circle">
					                                                            <span
					                                                                class="symbol-label bg-light-primary text-primary fw-bold">N</span>
					                                                        </div>
					                                                        <!--end::Avatar-->
					                                                        <!--begin::Details-->
					                                                        <div class="ms-5">
					                                                            <a href="#"
					                                                                class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Neil
					                                                                Owen</a>
					                                                            <div class="fw-bold text-muted">owen.neil@gmail.com
					                                                            </div>
					                                                        </div>
					                                                        <!--end::Details-->
					                                                    </div>
					                                                    <!--end::Details-->
					                                                    <!--begin::Access menu-->
					                                                    <div class="ms-2 w-100px">
					                                                        <select
					                                                            class="form-select form-select-solid form-select-sm"
					                                                            data-control="select2" data-hide-search="true">
					                                                            <option value="1" selected="selected">Guest</option>
					                                                            <option value="2">Owner</option>
					                                                            <option value="3">Can Edit</option>
					                                                        </select>
					                                                    </div>
					                                                    <!--end::Access menu-->
					                                                </div>
					                                                <!--end::User-->
					                                                <!--begin::Separator-->
					                                                <div class="border-bottom border-gray-300 border-bottom-dashed">
					                                                </div>
					                                                <!--end::Separator-->
					                                                <!--begin::User-->
					                                                <div class="rounded d-flex flex-stack bg-active-lighten p-4"
					                                                    data-user-id="9">
					                                                    <!--begin::Details-->
					                                                    <div class="d-flex align-items-center">
					                                                        <!--begin::Checkbox-->
					                                                        <label
					                                                            class="form-check form-check-custom form-check-solid me-5">
					                                                            <input class="form-check-input" type="checkbox"
					                                                                name="users" data-kt-check="true"
					                                                                data-kt-check-target="[data-user-id='9']"
					                                                                value="9" />
					                                                        </label>
					                                                        <!--end::Checkbox-->
					                                                        <!--begin::Avatar-->
					                                                        <div class="symbol symbol-35px symbol-circle">
					                                                            <img alt="Pic"
					                                                                src="<?= base_url() ?>assets/main/media/avatars/300-23.jpg" />
					                                                        </div>
					                                                        <!--end::Avatar-->
					                                                        <!--begin::Details-->
					                                                        <div class="ms-5">
					                                                            <a href="#"
					                                                                class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Dan
					                                                                Wilson</a>
					                                                            <div class="fw-bold text-muted">dam@consilting.com
					                                                            </div>
					                                                        </div>
					                                                        <!--end::Details-->
					                                                    </div>
					                                                    <!--end::Details-->
					                                                    <!--begin::Access menu-->
					                                                    <div class="ms-2 w-100px">
					                                                        <select
					                                                            class="form-select form-select-solid form-select-sm"
					                                                            data-control="select2" data-hide-search="true">
					                                                            <option value="1">Guest</option>
					                                                            <option value="2">Owner</option>
					                                                            <option value="3" selected="selected">Can Edit</option>
					                                                        </select>
					                                                    </div>
					                                                    <!--end::Access menu-->
					                                                </div>
					                                                <!--end::User-->
					                                                <!--begin::Separator-->
					                                                <div class="border-bottom border-gray-300 border-bottom-dashed">
					                                                </div>
					                                                <!--end::Separator-->
					                                                <!--begin::User-->
					                                                <div class="rounded d-flex flex-stack bg-active-lighten p-4"
					                                                    data-user-id="10">
					                                                    <!--begin::Details-->
					                                                    <div class="d-flex align-items-center">
					                                                        <!--begin::Checkbox-->
					                                                        <label
					                                                            class="form-check form-check-custom form-check-solid me-5">
					                                                            <input class="form-check-input" type="checkbox"
					                                                                name="users" data-kt-check="true"
					                                                                data-kt-check-target="[data-user-id='10']"
					                                                                value="10" />
					                                                        </label>
					                                                        <!--end::Checkbox-->
					                                                        <!--begin::Avatar-->
					                                                        <div class="symbol symbol-35px symbol-circle">
					                                                            <span
					                                                                class="symbol-label bg-light-danger text-danger fw-bold">E</span>
					                                                        </div>
					                                                        <!--end::Avatar-->
					                                                        <!--begin::Details-->
					                                                        <div class="ms-5">
					                                                            <a href="#"
					                                                                class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Emma
					                                                                Bold</a>
					                                                            <div class="fw-bold text-muted">emma@intenso.com</div>
					                                                        </div>
					                                                        <!--end::Details-->
					                                                    </div>
					                                                    <!--end::Details-->
					                                                    <!--begin::Access menu-->
					                                                    <div class="ms-2 w-100px">
					                                                        <select
					                                                            class="form-select form-select-solid form-select-sm"
					                                                            data-control="select2" data-hide-search="true">
					                                                            <option value="1">Guest</option>
					                                                            <option value="2" selected="selected">Owner</option>
					                                                            <option value="3">Can Edit</option>
					                                                        </select>
					                                                    </div>
					                                                    <!--end::Access menu-->
					                                                </div>
					                                                <!--end::User-->
					                                                <!--begin::Separator-->
					                                                <div class="border-bottom border-gray-300 border-bottom-dashed">
					                                                </div>
					                                                <!--end::Separator-->
					                                                <!--begin::User-->
					                                                <div class="rounded d-flex flex-stack bg-active-lighten p-4"
					                                                    data-user-id="11">
					                                                    <!--begin::Details-->
					                                                    <div class="d-flex align-items-center">
					                                                        <!--begin::Checkbox-->
					                                                        <label
					                                                            class="form-check form-check-custom form-check-solid me-5">
					                                                            <input class="form-check-input" type="checkbox"
					                                                                name="users" data-kt-check="true"
					                                                                data-kt-check-target="[data-user-id='11']"
					                                                                value="11" />
					                                                        </label>
					                                                        <!--end::Checkbox-->
					                                                        <!--begin::Avatar-->
					                                                        <div class="symbol symbol-35px symbol-circle">
					                                                            <img alt="Pic"
					                                                                src="<?= base_url() ?>assets/main/media/avatars/300-12.jpg" />
					                                                        </div>
					                                                        <!--end::Avatar-->
					                                                        <!--begin::Details-->
					                                                        <div class="ms-5">
					                                                            <a href="#"
					                                                                class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Ana
					                                                                Crown</a>
					                                                            <div class="fw-bold text-muted">ana.cf@limtel.com</div>
					                                                        </div>
					                                                        <!--end::Details-->
					                                                    </div>
					                                                    <!--end::Details-->
					                                                    <!--begin::Access menu-->
					                                                    <div class="ms-2 w-100px">
					                                                        <select
					                                                            class="form-select form-select-solid form-select-sm"
					                                                            data-control="select2" data-hide-search="true">
					                                                            <option value="1" selected="selected">Guest</option>
					                                                            <option value="2">Owner</option>
					                                                            <option value="3">Can Edit</option>
					                                                        </select>
					                                                    </div>
					                                                    <!--end::Access menu-->
					                                                </div>
					                                                <!--end::User-->
					                                                <!--begin::Separator-->
					                                                <div class="border-bottom border-gray-300 border-bottom-dashed">
					                                                </div>
					                                                <!--end::Separator-->
					                                                <!--begin::User-->
					                                                <div class="rounded d-flex flex-stack bg-active-lighten p-4"
					                                                    data-user-id="12">
					                                                    <!--begin::Details-->
					                                                    <div class="d-flex align-items-center">
					                                                        <!--begin::Checkbox-->
					                                                        <label
					                                                            class="form-check form-check-custom form-check-solid me-5">
					                                                            <input class="form-check-input" type="checkbox"
					                                                                name="users" data-kt-check="true"
					                                                                data-kt-check-target="[data-user-id='12']"
					                                                                value="12" />
					                                                        </label>
					                                                        <!--end::Checkbox-->
					                                                        <!--begin::Avatar-->
					                                                        <div class="symbol symbol-35px symbol-circle">
					                                                            <span
					                                                                class="symbol-label bg-light-info text-info fw-bold">A</span>
					                                                        </div>
					                                                        <!--end::Avatar-->
					                                                        <!--begin::Details-->
					                                                        <div class="ms-5">
					                                                            <a href="#"
					                                                                class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Robert
					                                                                Doe</a>
					                                                            <div class="fw-bold text-muted">robert@benko.com</div>
					                                                        </div>
					                                                        <!--end::Details-->
					                                                    </div>
					                                                    <!--end::Details-->
					                                                    <!--begin::Access menu-->
					                                                    <div class="ms-2 w-100px">
					                                                        <select
					                                                            class="form-select form-select-solid form-select-sm"
					                                                            data-control="select2" data-hide-search="true">
					                                                            <option value="1">Guest</option>
					                                                            <option value="2">Owner</option>
					                                                            <option value="3" selected="selected">Can Edit</option>
					                                                        </select>
					                                                    </div>
					                                                    <!--end::Access menu-->
					                                                </div>
					                                                <!--end::User-->
					                                                <!--begin::Separator-->
					                                                <div class="border-bottom border-gray-300 border-bottom-dashed">
					                                                </div>
					                                                <!--end::Separator-->
					                                                <!--begin::User-->
					                                                <div class="rounded d-flex flex-stack bg-active-lighten p-4"
					                                                    data-user-id="13">
					                                                    <!--begin::Details-->
					                                                    <div class="d-flex align-items-center">
					                                                        <!--begin::Checkbox-->
					                                                        <label
					                                                            class="form-check form-check-custom form-check-solid me-5">
					                                                            <input class="form-check-input" type="checkbox"
					                                                                name="users" data-kt-check="true"
					                                                                data-kt-check-target="[data-user-id='13']"
					                                                                value="13" />
					                                                        </label>
					                                                        <!--end::Checkbox-->
					                                                        <!--begin::Avatar-->
					                                                        <div class="symbol symbol-35px symbol-circle">
					                                                            <img alt="Pic"
					                                                                src="<?= base_url() ?>assets/main/media/avatars/300-13.jpg" />
					                                                        </div>
					                                                        <!--end::Avatar-->
					                                                        <!--begin::Details-->
					                                                        <div class="ms-5">
					                                                            <a href="#"
					                                                                class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">John
					                                                                Miller</a>
					                                                            <div class="fw-bold text-muted">miller@mapple.com</div>
					                                                        </div>
					                                                        <!--end::Details-->
					                                                    </div>
					                                                    <!--end::Details-->
					                                                    <!--begin::Access menu-->
					                                                    <div class="ms-2 w-100px">
					                                                        <select
					                                                            class="form-select form-select-solid form-select-sm"
					                                                            data-control="select2" data-hide-search="true">
					                                                            <option value="1">Guest</option>
					                                                            <option value="2">Owner</option>
					                                                            <option value="3" selected="selected">Can Edit</option>
					                                                        </select>
					                                                    </div>
					                                                    <!--end::Access menu-->
					                                                </div>
					                                                <!--end::User-->
					                                                <!--begin::Separator-->
					                                                <div class="border-bottom border-gray-300 border-bottom-dashed">
					                                                </div>
					                                                <!--end::Separator-->
					                                                <!--begin::User-->
					                                                <div class="rounded d-flex flex-stack bg-active-lighten p-4"
					                                                    data-user-id="14">
					                                                    <!--begin::Details-->
					                                                    <div class="d-flex align-items-center">
					                                                        <!--begin::Checkbox-->
					                                                        <label
					                                                            class="form-check form-check-custom form-check-solid me-5">
					                                                            <input class="form-check-input" type="checkbox"
					                                                                name="users" data-kt-check="true"
					                                                                data-kt-check-target="[data-user-id='14']"
					                                                                value="14" />
					                                                        </label>
					                                                        <!--end::Checkbox-->
					                                                        <!--begin::Avatar-->
					                                                        <div class="symbol symbol-35px symbol-circle">
					                                                            <span
					                                                                class="symbol-label bg-light-success text-success fw-bold">L</span>
					                                                        </div>
					                                                        <!--end::Avatar-->
					                                                        <!--begin::Details-->
					                                                        <div class="ms-5">
					                                                            <a href="#"
					                                                                class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Lucy
					                                                                Kunic</a>
					                                                            <div class="fw-bold text-muted">lucy.m@fentech.com
					                                                            </div>
					                                                        </div>
					                                                        <!--end::Details-->
					                                                    </div>
					                                                    <!--end::Details-->
					                                                    <!--begin::Access menu-->
					                                                    <div class="ms-2 w-100px">
					                                                        <select
					                                                            class="form-select form-select-solid form-select-sm"
					                                                            data-control="select2" data-hide-search="true">
					                                                            <option value="1">Guest</option>
					                                                            <option value="2" selected="selected">Owner</option>
					                                                            <option value="3">Can Edit</option>
					                                                        </select>
					                                                    </div>
					                                                    <!--end::Access menu-->
					                                                </div>
					                                                <!--end::User-->
					                                                <!--begin::Separator-->
					                                                <div class="border-bottom border-gray-300 border-bottom-dashed">
					                                                </div>
					                                                <!--end::Separator-->
					                                                <!--begin::User-->
					                                                <div class="rounded d-flex flex-stack bg-active-lighten p-4"
					                                                    data-user-id="15">
					                                                    <!--begin::Details-->
					                                                    <div class="d-flex align-items-center">
					                                                        <!--begin::Checkbox-->
					                                                        <label
					                                                            class="form-check form-check-custom form-check-solid me-5">
					                                                            <input class="form-check-input" type="checkbox"
					                                                                name="users" data-kt-check="true"
					                                                                data-kt-check-target="[data-user-id='15']"
					                                                                value="15" />
					                                                        </label>
					                                                        <!--end::Checkbox-->
					                                                        <!--begin::Avatar-->
					                                                        <div class="symbol symbol-35px symbol-circle">
					                                                            <img alt="Pic"
					                                                                src="<?= base_url() ?>assets/main/media/avatars/300-21.jpg" />
					                                                        </div>
					                                                        <!--end::Avatar-->
					                                                        <!--begin::Details-->
					                                                        <div class="ms-5">
					                                                            <a href="#"
					                                                                class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Ethan
					                                                                Wilder</a>
					                                                            <div class="fw-bold text-muted">ethan@loop.com.au</div>
					                                                        </div>
					                                                        <!--end::Details-->
					                                                    </div>
					                                                    <!--end::Details-->
					                                                    <!--begin::Access menu-->
					                                                    <div class="ms-2 w-100px">
					                                                        <select
					                                                            class="form-select form-select-solid form-select-sm"
					                                                            data-control="select2" data-hide-search="true">
					                                                            <option value="1" selected="selected">Guest</option>
					                                                            <option value="2">Owner</option>
					                                                            <option value="3">Can Edit</option>
					                                                        </select>
					                                                    </div>
					                                                    <!--end::Access menu-->
					                                                </div>
					                                                <!--end::User-->
					                                                <!--begin::Separator-->
					                                                <div class="border-bottom border-gray-300 border-bottom-dashed">
					                                                </div>
					                                                <!--end::Separator-->
					                                                <!--begin::User-->
					                                                <div class="rounded d-flex flex-stack bg-active-lighten p-4"
					                                                    data-user-id="16">
					                                                    <!--begin::Details-->
					                                                    <div class="d-flex align-items-center">
					                                                        <!--begin::Checkbox-->
					                                                        <label
					                                                            class="form-check form-check-custom form-check-solid me-5">
					                                                            <input class="form-check-input" type="checkbox"
					                                                                name="users" data-kt-check="true"
					                                                                data-kt-check-target="[data-user-id='16']"
					                                                                value="16" />
					                                                        </label>
					                                                        <!--end::Checkbox-->
					                                                        <!--begin::Avatar-->
					                                                        <div class="symbol symbol-35px symbol-circle">
					                                                            <img alt="Pic"
					                                                                src="<?= base_url() ?>assets/main/media/avatars/300-1.jpg" />
					                                                        </div>
					                                                        <!--end::Avatar-->
					                                                        <!--begin::Details-->
					                                                        <div class="ms-5">
					                                                            <a href="#"
					                                                                class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Max
					                                                                Smith</a>
					                                                            <div class="fw-bold text-muted">max@kt.com</div>
					                                                        </div>
					                                                        <!--end::Details-->
					                                                    </div>
					                                                    <!--end::Details-->
					                                                    <!--begin::Access menu-->
					                                                    <div class="ms-2 w-100px">
					                                                        <select
					                                                            class="form-select form-select-solid form-select-sm"
					                                                            data-control="select2" data-hide-search="true">
					                                                            <option value="1">Guest</option>
					                                                            <option value="2">Owner</option>
					                                                            <option value="3" selected="selected">Can Edit</option>
					                                                        </select>
					                                                    </div>
					                                                    <!--end::Access menu-->
					                                                </div>
					                                                <!--end::User-->
					                                            </div>
					                                            <!--end::Users-->
					                                            <!--begin::Actions-->
					                                            <div class="d-flex flex-center mt-15">
					                                                <button type="reset" id="kt_modal_users_search_reset"
					                                                    data-bs-dismiss="modal"
					                                                    class="btn btn-active-light me-3">Cancel</button>
					                                                <button type="submit" id="kt_modal_users_search_submit"
					                                                    class="btn btn-primary">Add Selected Users</button>
					                                            </div>
					                                            <!--end::Actions-->
					                                        </div>
					                                        <!--end::Results-->
					                                        <!--begin::Empty-->
					                                        <div data-kt-search-element="empty" class="text-center d-none">
					                                            <!--begin::Message-->
					                                            <div class="fw-bold py-10">
					                                                <div class="text-gray-600 fs-3 mb-2">No users found</div>
					                                                <div class="text-muted fs-6">Try to search by username, full name
					                                                    or email...</div>
					                                            </div>
					                                            <!--end::Message-->
					                                            <!--begin::Illustration-->
					                                            <div class="text-center px-5">
					                                                <img src="<?= base_url() ?>assets/main/media/illustrations/sketchy-1/1.png"
					                                                    alt="" class="w-100 h-200px h-sm-325px" />
					                                            </div>
					                                            <!--end::Illustration-->
					                                        </div>
					                                        <!--end::Empty-->
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
					                <!--end::Modal - Users Search-->
					                <!--end::Modals-->
					            </div>
					            <!--end::Container-->
					        </div>
					        <!--end::Post-->
					    </div>
					</div>
					<!--end::Content-->