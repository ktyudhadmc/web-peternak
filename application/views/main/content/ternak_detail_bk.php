					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Toolbar-->
						<input class="form-control" type="hidden" id="kandang_periode" value="<?= $idkandang . "|" . $periode ?> " required>
						<div class="toolbar" id="kt_toolbar">
							<!--begin::Container-->
							<div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
								<!--begin::Page title-->
								<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
									<!--begin::Title-->
									<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Ternak Detail</h1>
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
										<li class="breadcrumb-item text-muted">
											<a href="<?= base_url('main/ternak/view/aktif/') ?>" class="text-muted text-hover-primary">Ternak</a>
										</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item">
											<span class="bullet bg-gray-300 w-5px h-2px"></span>
										</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item text-dark">Ternak Detail</li>
										<!--end::Item-->
									</ul>
									<!--end::Breadcrumb-->
								</div>
								<!--end::Page title-->
								<!--begin::Actions-->
								<div class="d-flex align-items-center gap-2 gap-lg-3">
									<!--begin::Filter menu-->
									<div class="m-0">
										<!--begin::Menu toggle-->
										<a href="#" id="searchbutton" class="btn btn-sm btn-flex btn-light btn-primary fw-bolder" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
											<!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
											<!-- <span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
													<path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="currentColor" />
												</svg>
											</span> -->
											<span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
													<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
													<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor"></path>
												</svg>
											</span>
											<!--end::Svg Icon-->Search
										</a>
										<!--end::Menu toggle-->
										<!--begin::Menu 1-->
										<div class="menu menu-sub menu-sub-dropdown p-7 w-325px w-md-375px" data-kt-menu="true" id="kt_menu_624475c6715c1">
											<!--begin::Main wrapper-->
											<div id="kt_docs_search_handler_basic" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="true" data-kt-search-layout="inline">
												<div data-kt-search-element="wrapper">
													<!--begin::Input Form-->
													<form data-kt-search-element="form" class="w-100 position-relative mb-3" autocomplete="off">
														<!--begin::Hidden input(Added to disable form autocomplete)-->
														<input type="hidden" />
														<!--end::Hidden input-->
														<span class="svg-icon svg-icon-2 svg-icon-lg-1 svg-icon-gray-500 position-absolute top-50 ms-5 translate-middle-y">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
																<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor"></path>
															</svg>
														</span>
														<!--begin::Input-->
														<input type="text" class="form-control form-control-lg form-control-solid px-15" name="search" value="" placeholder="Cari data kandang lain" data-kt-search-element="input" />
														<!--end::Input-->

														<!--begin::Spinner-->
														<span class="position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-5" data-kt-search-element="spinner">
															<span class="spinner-border h-15px w-15px align-middle text-gray-400"></span>
														</span>
														<!--end::Spinner-->

														<!--begin::Reset-->
														<span class="btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 me-5 d-none" data-kt-search-element="clear">

															<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
														</span>
														<!--end::Reset-->
													</form>
													<!--end::Form-->

													<!--begin::Wrapper-->
													<div class="py-5">
														<!--being::Search suggestion-->
														<div data-kt-search-element="suggestions">
															<div class="text-center px-4">
																<img class="mw-100 mh-200px" alt="image" src="<?= base_url() ?>assets/main/media/illustrations/sketchy-1/1.png">
															</div>
														</div>
														<!--end::Suggestion wrapper-->

														<!--begin::Search results-->
														<div data-kt-search-element="results" id="resultsearch" class="d-none">
														</div>
														<!--end::Search results-->

														<!--begin::Empty search-->
														<div data-kt-search-element="empty" class="text-center d-none">
															<!--begin::Message-->
															<div class="fw-bold py-0 mb-10">
																<div class="text-gray-600 fs-3 mb-2">No users found</div>
																<div class="text-gray-400 fs-6">Try to search by username, full name or email...</div>
															</div>
															<!--end::Message-->
															<!--begin::Illustration-->
															<div class="text-center px-4">
																<img class="mw-100 mh-200px" alt="image" src="<?= base_url() ?>assets/main/media/illustrations/sketchy-1/2.png">
															</div>
															<!--end::Illustration-->
														</div>
														<!--end::Empty search-->
													</div>
												</div>
												<!--end::Wrapper-->
											</div>
											<!--end::Main wrapper-->
										</div>
										<!--end::Menu 1-->
									</div>
									<!--end::Filter menu-->
									<a href="../../demo1/dist/.html" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Create</a>
									<!--end::Primary button-->
								</div>
								<!--end::Actions-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Toolbar-->
						<!--begin::Post-->
						<div class="post d-flex flex-column-fluid" id="kt_post">
							<!--begin::Container-->
							<div id="kt_content_container" class="container-xxl">
								<!--begin::Navbar-->
								<div class="card mb-6 mb-xl-9">
									<div class="card-body pt-9 pb-0">
										<!--begin::Details-->
										<div class="d-flex flex-wrap flex-sm-nowrap mb-6">
											<!--begin::Image-->
											<div class="d-flex flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
												<img class="mw-50px mw-lg-75px" src="<?= $this->config->item('app_url') . $datakandang->foto ?>" alt="image" />
											</div>
											<!--end::Image-->
											<!--begin::Wrapper-->
											<div class="flex-grow-1">
												<!--begin::Head-->
												<div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
													<!--begin::Details-->
													<div class="d-flex flex-column">
														<!--begin::Status-->
														<div class="d-flex align-items-center mb-1">
															<!-- {"id":"2088","user_id":"102","user_id_sharing":"102,39,119,129,156,157,134,164,172,173,174,175,176,191,162,196","nama":"BPP01N","alamat":"Balikpapan","type_kandang":"3","kapasitas":"100000","status_kandang":"AKTIF","foto":"assets\/mobile\/img\/bg-img\/kandangcustom.png","stock":"lokasi","change_by":null,"created_at":"2022-09-14 10:01:08","updated_at":"2022-09-30 08:47:01","id_kandang":"48","populasi_awal":"7500","strain":"ROSS","status_kandang_activity":"AKTIF","tanggal_mulai":"2022-09-02","harga_doc":"0","ip":null,"periode":"2201","id_user":"156"} -->
															<a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bolder me-3"><?= $datakandang->nama ?></a>
															<?php if ($datakandang->status_kandang == "AKTIF") { ?>
																<span class="badge badge-light-success me-auto"><?= $datakandang->status_kandang ?></span>
															<?php } else { ?>
																<span class="badge badge-light-danger me-auto"><?= $datakandang->status_kandang ?></span>
															<?php } ?>
														</div>
														<!--end::Status-->
														<!--begin::Description-->
														<!-- $dataresume :
														{"umur":"39","tanggal_chickin":"2022-08-26","id_kandang":"56","periode":"2204","strain":"LOHMANN","deplesi_persent":"7.02","deplesi":"576","populasi":"4","tot_feed":"518","bw":"2275","rg3":"124","rg7":"368","act_fcr":"1.493","act_adg":"58","ip":"363"} -->
														<div class="d-flex flex-wrap fw-bold mb-4 fs-5 text-gray-400">
															<?= $datakandang->alamat ?>
														</div>
														<!--end::Description-->
													</div>
													<!--end::Details-->
													<!--begin::Actions-->
													<div class="d-flex mb-4">
														<a href="#" class="btn btn-sm btn-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_users_search">Tambah User Sharing</a>
														<!-- <a href="#" class="btn btn-sm btn-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target">Add Target</a> -->
														<!--begin::Menu-->
														<div class="me-0">
															<button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
																<i class="bi bi-three-dots fs-3"></i>
															</button>
															<!--begin::Menu 3-->
															<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
																<!--begin::Heading-->
																<div class="menu-item px-3">
																	<div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">
																		Payments</div>
																</div>
																<!--end::Heading-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3">Create Invoice</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link flex-stack px-3">Create Payment
																		<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify a target name for future usage and reference"></i></a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3">
																	<a href="#" class="menu-link px-3">Generate Bill</a>
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end">
																	<a href="#" class="menu-link px-3">
																		<span class="menu-title">Subscription</span>
																		<span class="menu-arrow"></span>
																	</a>
																	<!--begin::Menu sub-->
																	<div class="menu-sub menu-sub-dropdown w-175px py-4">
																		<!--begin::Menu item-->
																		<div class="menu-item px-3">
																			<a href="#" class="menu-link px-3">Plans</a>
																		</div>
																		<!--end::Menu item-->
																		<!--begin::Menu item-->
																		<div class="menu-item px-3">
																			<a href="#" class="menu-link px-3">Billing</a>
																		</div>
																		<!--end::Menu item-->
																		<!--begin::Menu item-->
																		<div class="menu-item px-3">
																			<a href="#" class="menu-link px-3">Statements</a>
																		</div>
																		<!--end::Menu item-->
																		<!--begin::Menu separator-->
																		<div class="separator my-2"></div>
																		<!--end::Menu separator-->
																		<!--begin::Menu item-->
																		<div class="menu-item px-3">
																			<div class="menu-content px-3">
																				<!--begin::Switch-->
																				<label class="form-check form-switch form-check-custom form-check-solid">
																					<!--begin::Input-->
																					<input class="form-check-input w-30px h-20px" type="checkbox" value="1" checked="checked" name="notifications" />
																					<!--end::Input-->
																					<!--end::Label-->
																					<span class="form-check-label text-muted fs-6">Recuring</span>
																					<!--end::Label-->
																				</label>
																				<!--end::Switch-->
																			</div>
																		</div>
																		<!--end::Menu item-->
																	</div>
																	<!--end::Menu sub-->
																</div>
																<!--end::Menu item-->
																<!--begin::Menu item-->
																<div class="menu-item px-3 my-1">
																	<a href="#" class="menu-link px-3">Settings</a>
																</div>
																<!--end::Menu item-->
															</div>
															<!--end::Menu 3-->
														</div>
														<!--end::Menu-->
													</div>
													<!--end::Actions-->
												</div>
												<!--end::Head-->
												<!--begin::Info-->
												<div class="d-flex flex-wrap justify-content-start">
													<!--begin::Stats-->
													<div class="d-flex flex-wrap">
														<!--begin::Stat-->
														<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
															<!--begin::Number-->
															<div class="d-flex align-items-center">
																<div class="fs-4 fw-bolder">
																	<?= date('d M, Y', strtotime($dataresume->tanggal_chickin)) ?>
																</div>
															</div>
															<!--end::Number-->
															<!--begin::Label-->
															<div class="fw-bold fs-6 text-gray-400">Tanggal Chickin</div>
															<!--end::Label-->
														</div>
														<!--end::Stat-->
														<!--begin::Stat-->
														<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
															<!--begin::Number-->
															<div class="d-flex align-items-center">
																<div class="fs-4 fw-bolder"><?= $dataresume->strain ?></div>
															</div>
															<!--end::Number-->
															<!--begin::Label-->
															<div class="fw-bold fs-6 text-gray-400">Strain</div>
															<!--end::Label-->
														</div>
														<!--end::Stat-->
														<!--begin::Stat-->
														<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
															<!--begin::Number-->
															<div class="d-flex align-items-center">
																<div class="fs-4 fw-bolder">
																	<?= isset($dataresume->umur) && $dataresume->umur !== NULL ? $dataresume->umur : 0 ?>
																</div>
															</div>
															<!--end::Number-->
															<!--begin::Label-->
															<div class="fw-bold fs-6 text-gray-400">Umur (Hari)</div>
															<!--end::Label-->
														</div>
														<!--end::Stat-->
														<!--begin::Stat-->
														<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
															<!--begin::Number-->
															<div class="d-flex align-items-center">
																<div class="fs-4 fw-bolder" data-kt-countup="true" data-kt-countup-value="<?= isset($dataresume->populasi) ? $dataresume->populasi : 0 ?>" data-kt-countup-prefix="">0</div>
															</div>
															<!--end::Number-->
															<!--begin::Label-->
															<div class="fw-bold fs-6 text-gray-400">Populasi (Ekor)</div>
															<!--end::Label-->
														</div>
														<!--end::Stat-->
														<!--begin::Stat-->
														<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
															<!--begin::Number-->
															<div class="d-flex align-items-center">
																<div class="fs-4 fw-bolder">
																	<?= isset($dataresume->deplesi) ? $dataresume->deplesi : 0 ?></div>
															</div>
															<!--end::Number-->
															<!--begin::Label-->
															<div class="fw-bold fs-6 text-gray-400">Deplesi (Ekor)</div>
															<!--end::Label-->
														</div>
														<!--end::Stat-->
														<!--begin::Stat-->
														<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
															<!--begin::Number-->
															<div class="d-flex align-items-center">
																<div class="fs-4 fw-bolder"><?= $dataresume->deplesi_persent ?></div>
															</div>
															<!--end::Number-->
															<!--begin::Label-->
															<div class="fw-bold fs-6 text-gray-400">Deplesi (%)</div>
															<!--end::Label-->
														</div>
														<!--end::Stat-->
														<!--begin::Stat-->
														<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
															<!--begin::Number-->
															<div class="d-flex align-items-center">
																<div class="fs-4 fw-bolder"><?= $dataresume->ip ?></div>
															</div>
															<!--end::Number-->
															<!--begin::Label-->
															<div class="fw-bold fs-6 text-gray-400">Index Performance</div>
															<!--end::Label-->
														</div>
														<!--begin::Stat-->
														<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
															<!--begin::Number-->
															<div class="d-flex align-items-center">
																<div class="fs-4 fw-bolder">
																	<?= isset($dataresume->act_adg) ? $dataresume->act_adg : 0; ?>
																</div>
															</div>
															<!--end::Number-->
															<!--begin::Label-->
															<div class="fw-bold fs-6 text-gray-400">ADG</div>
															<!--end::Label-->
														</div>
														<!--end::Stat-->
														<!--begin::Stat-->
														<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
															<!--begin::Number-->
															<div class="d-flex align-items-center">
																<div class="fs-4 fw-bolder"><?= $dataresume->act_fcr ?></div>
															</div>
															<!--end::Number-->
															<!--begin::Label-->
															<div class="fw-bold fs-6 text-gray-400">FCR</div>
															<!--end::Label-->
														</div>
														<!--end::Stat-->
														<!--begin::Stat-->
														<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
															<!--begin::Number-->
															<div class="d-flex align-items-center">
																<div class="fs-4 fw-bolder">
																	<?= isset($dataresume->rg3) ? $dataresume->rg3 : 0 ?></div>
															</div>
															<!--end::Number-->
															<!--begin::Label-->
															<div class="fw-bold fs-6 text-gray-400">RG3</div>
															<!--end::Label-->
														</div>
														<!--end::Stat-->
														<!--begin::Stat-->
														<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
															<!--begin::Number-->
															<div class="d-flex align-items-center">
																<div class="fs-4 fw-bolder">
																	<?= isset($dataresume->rg7) ? $dataresume->rg7 : 0 ?></div>
															</div>
															<!--end::Number-->
															<!--begin::Label-->
															<div class="fw-bold fs-6 text-gray-400">RG7</div>
															<!--end::Label-->
														</div>
														<!--end::Stat-->
														<!--begin::Stat-->
														<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
															<!--begin::Number-->
															<div class="d-flex align-items-center">
																<div class="fs-4 fw-bolder" data-kt-countup="true" data-kt-countup-value="<?= $dataresume->bw !== NULL ? $dataresume->bw : 0 ?>" data-kt-countup-prefix="">0</div>
															</div>
															<!--end::Number-->
															<!--begin::Label-->
															<div class="fw-bold fs-6 text-gray-400">BW</div>
															<!--end::Label-->
														</div>
														<!--end::Stat-->
													</div>
													<!--end::Stats-->
													<!--begin::Users-->
													<div class="symbol-group symbol-hover mb-3">
														<?php
														$datasharing = explode(",", $datakandang->user_id_sharing);
														foreach ($datasharing as $key => $datasharings) {
															$datausers = $this->db->select('first_name,foto')->from('users')->where(['id' => $datasharings])->get()->row(); ?>
															<!--begin::User-->
															<a href="<?= base_url("main/profile/{$datasharings}") ?>" onclick="dowaiting(this); return false;">
																<div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="<?= $datausers->first_name ?>">
																	<img alt="Pic" src="<?= $this->config->item('app_url') . $datausers->foto ?>" />
																</div>
															</a>
															<!--begin::User-->
														<?php } ?>
													</div>
													<!--end::Users-->
												</div>
												<!--end::Info-->
											</div>
											<!--end::Wrapper-->
										</div>
										<!--end::Details-->
										<div class="separator"></div>
										<!--begin::Nav-->
										<ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder">
											<!--begin::Nav item-->
											<li class="nav-item">
												<a class="nav-link text-active-primary py-5 me-6 " data-bs-toggle="tab" href="#kt_resume" onclick="resume()">Resume</a>
											</li>
											<!--end::Nav item-->
											<!--begin::Nav item-->
											<li class="nav-item">
												<a class="nav-link text-active-primary py-5 me-6" data-bs-toggle="tab" href="#kt_sapronak" onclick="sapronak()">Sapronak</a>
											</li>
											<!--end::Nav item-->
											<!--begin::Nav item-->
											<li class=" nav-item">
												<a class="nav-link text-active-primary py-5 me-6" data-bs-toggle="tab" href="#kt_dataharian" onclick="dataharian()">Dataharian</a>
											</li>
											<!--end::Nav item-->
											<!--begin::Nav item-->
											<li class="nav-item">
												<a class="nav-link text-active-primary py-5 me-6" data-bs-toggle="tab" href="#kt_nekropsi" onclick="nekropsi()">Nekropsi</a>
											</li>
											<!--end::Nav item-->
											<!--begin::Nav item-->
											<li class="nav-item">
												<a class="nav-link text-active-primary py-5 me-6" data-bs-toggle="tab" href="#kt_logrh" onclick="logrh()">Log Temp & RH</a>
											</li>
											<!--end::Nav item-->
											<!--begin::Nav item-->
											<li class="nav-item">
												<a class="nav-link text-active-primary py-5 me-6" data-bs-toggle="tab" href="#kt_ews" onclick="ews()">Log Ews</a>
											</li>
											<!--end::Nav item-->
											<!--begin::Nav item-->
											<li class="nav-item">
												<a class="nav-link text-active-primary py-5 me-6" data-bs-toggle="tab" href="#kt_bop" onclick="bop()">Biaya Operational</a>
											</li>
											<!--end::Nav item-->
											<!--begin::Nav item-->
											<li class="nav-item">
												<a class="nav-link text-active-primary py-5 me-6" data-bs-toggle="tab" href="#kt_penjualan" onclick="penjualan()">Penjualan</a>
											</li>
											<!--end::Nav item-->
											<!--begin::Nav item-->
											<li class="nav-item">
												<a class="nav-link text-active-primary py-5 me-6" data-bs-toggle="tab" href="#kt_pendapatan" onclick="pendapatan()">Pendapatan</a>
											</li>
											<!--end::Nav item-->
										</ul>
										<!--end::Nav-->
									</div>
								</div>
								<!--end::Navbar-->
								<div class="tab-content">
									<?php
									// $this->load->view('main/content/ternak_detail_resume');
									// $this->load->view('main/content/ternak_detail_sapronak');
									// $this->load->view('main/content/ternak_detail_dataharian');
									// $this->load->view('main/content/ternak_detail_nekropsi');
									// $this->load->view('main/content/ternak_detail_logrh');
									// $this->load->view('main/content/ternak_detail_ews');
									// $this->load->view('main/content/ternak_detail_bop');
									// $this->load->view('main/content/ternak_detail_penjualan');
									// $this->load->view('main/content/ternak_detail_pendapatan');
									?>
									<div id="kt_resume" class="tab-pane fade show">
										<div id="outputresume"></div>
									</div>
									<div id="kt_sapronak" class="tab-pane fade show">
										<div id="outputsapornak"></div>
									</div>
									<div id="kt_dataharian" class="tab-pane fade show">
										<div id="outputdataharian"></div>
									</div>
									<div id="kt_nekropsi" class="tab-pane fade show">
										<div id="outputnekropsi"></div>
									</div>
									<div id="kt_logrh" class="tab-pane fade show">
										<div id="outputlogrh"></div>
									</div>
									<div id="kt_ews" class="tab-pane fade show">
										<div id="outputews"></div>
									</div>
									<div id="kt_bop" class="tab-pane fade show">
										<div id="outputbop"></div>
									</div>
									<div id="kt_penjualan" class="tab-pane fade show">
										<div id="outputpenjualan"></div>
									</div>
									<div id="kt_pendapatan" class="tab-pane fade show">
										<div id="outputpendapatan"></div>
									</div>
									<!--end::Container-->
								</div>
								<!--end::Post-->
							</div>
							<!--end::Content-->
						</div>
					</div>