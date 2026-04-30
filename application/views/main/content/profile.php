<?php
$cookiex = getcookienya('user_data');
// $readdatakandang = readfilejsoncookie("datakandang" . $cookiex['user_id']);
$readdatakandang = $globalKandang;

// Data Chickin
$kandang_aktif = (int) ($readdatakandang['kandang_aktif'] ?? 0);
$kandang_rehat = (int) ($readdatakandang['kandang_rehat'] ?? 0);
$kandang_total = (int) ($readdatakandang['kandang_total'] ?? 0);

$activePercentage = 0;
$restPercentage = 0;

if ($kandang_total > 0) {
    $activePercentage = round($kandang_aktif / $kandang_total * 100, 2);
    $restPercentage = round($kandang_rehat / $kandang_total * 100, 2);
}

?>
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<!--begin::Toolbar-->
	<div class="toolbar" id="kt_toolbar">
		<!--begin::Container-->
		<div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
			<!--begin::Page title-->
			<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
				<!--begin::Title-->
				<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1"><?= ucwords($this->uri->segment(2)) ?></h1>
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
					<li class="breadcrumb-item text-muted"><?= ucwords($this->uri->segment(1)) ?></li>
					<!--end::Item-->
					<!--begin::Item-->
					<li class="breadcrumb-item">
						<span class="bullet bg-gray-300 w-5px h-2px"></span>
					</li>
					<!--end::Item-->
					<!--begin::Item-->
					<li class="breadcrumb-item text-dark"><?= ucwords($this->uri->segment(2)) ?></li>
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
					<!-- <a href="<?= current_url() ?>" class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
            <span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="currentColor" />
              </svg>
            </span>Filter</a> -->
					<!--end::Menu toggle-->
					<!--begin::Menu 1-->
					<div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_624475bd3a587">
						<!--begin::Header-->
						<div class="px-7 py-5">
							<div class="fs-5 text-dark fw-bolder">Filter Options</div>
						</div>
						<!--end::Header-->
						<!--begin::Menu separator-->
						<div class="separator border-gray-200"></div>
						<!--end::Menu separator-->
						<!--begin::Form-->
						<div class="px-7 py-5">
							<!--begin::Input group-->
							<div class="mb-10">
								<!--begin::Label-->
								<label class="form-label fw-bold">Status:</label>
								<!--end::Label-->
								<!--begin::Input-->
								<div>
									<select class="form-select form-select-solid" data-kt-select2="true" data-placeholder="Select option" data-dropdown-parent="#kt_menu_624475bd3a587" data-allow-clear="true">
										<option></option>
										<option value="1">Approved</option>
										<option value="2">Pending</option>
										<option value="2">In Process</option>
										<option value="2">Rejected</option>
									</select>
								</div>
								<!--end::Input-->
							</div>
							<!--end::Input group-->
							<!--begin::Input group-->
							<div class="mb-10">
								<!--begin::Label-->
								<label class="form-label fw-bold">Member Type:</label>
								<!--end::Label-->
								<!--begin::Options-->
								<div class="d-flex">
									<!--begin::Options-->
									<label class="form-check form-check-sm form-check-custom form-check-solid me-5">
										<input class="form-check-input" type="checkbox" value="1" />
										<span class="form-check-label">Author</span>
									</label>
									<!--end::Options-->
									<!--begin::Options-->
									<label class="form-check form-check-sm form-check-custom form-check-solid">
										<input class="form-check-input" type="checkbox" value="2" checked="checked" />
										<span class="form-check-label">Customer</span>
									</label>
									<!--end::Options-->
								</div>
								<!--end::Options-->
							</div>
							<!--end::Input group-->
							<!--begin::Input group-->
							<div class="mb-10">
								<!--begin::Label-->
								<label class="form-label fw-bold">Notifications:</label>
								<!--end::Label-->
								<!--begin::Switch-->
								<div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
									<input class="form-check-input" type="checkbox" value="" name="notifications" checked="checked" />
									<label class="form-check-label">Enabled</label>
								</div>
								<!--end::Switch-->
							</div>
							<!--end::Input group-->
							<!--begin::Actions-->
							<div class="d-flex justify-content-end">
								<button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true">Reset</button>
								<button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">Apply</button>
							</div>
							<!--end::Actions-->
						</div>
						<!--end::Form-->
					</div>
					<!--end::Menu 1-->
				</div>
				<!--end::Filter menu-->
				<!--begin::Secondary button-->
				<!--end::Secondary button-->
				<!--begin::Primary button-->
				<!-- <a href="../../demo1/dist/.html" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Create</a> -->
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
			<div class="card mb-5 mb-xxl-8">
				<div class="card-body pt-9 pb-0">
					<!--begin::Details-->
					<div class="d-flex flex-wrap flex-sm-nowrap">
						<!--begin: Pic-->
						<div class="me-7 mb-4">
							<div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
								<img src="<?= $this->config->item('app_url') . ($datauser->foto) ?>" alt="image" />
								<div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-white h-20px w-20px"></div>
							</div>
						</div>
						<!--end::Pic-->
						<!--begin::Info-->
						<div class="flex-grow-1">
							<!--begin::Title-->
							<div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
								<!--begin::User-->
								<div class="d-flex flex-column">
									<!--begin::Name-->
									<div class="d-flex align-items-center mb-2">
										<a href="<?= current_url() ?>" class="text-gray-900 text-hover-primary fs-2 fw-bolder me-1"><?= $datauser->first_name ?></a>
										<a href="<?= current_url() ?>">
											<!--begin::Svg Icon | path: icons/duotune/general/gen026.svg-->
											<span class="svg-icon svg-icon-1 svg-icon-primary">
												<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
													<path d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z" fill="#00A3FF" />
													<path class="permanent" d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z" fill="white" />
												</svg>
											</span>
											<!--end::Svg Icon-->
										</a>
									</div>
									<!--end::Name-->
									<!--begin::Info-->
									<div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
										<a href="tel:<?= $datauser->number ?>" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
											<span class="svg-icon svg-icon-4 me-1">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
													<path d="M8,2.5 C7.30964406,2.5 6.75,3.05964406 6.75,3.75 L6.75,20.25 C6.75,20.9403559 7.30964406,21.5 8,21.5 L16,21.5 C16.6903559,21.5 17.25,20.9403559 17.25,20.25 L17.25,3.75 C17.25,3.05964406 16.6903559,2.5 16,2.5 L8,2.5 Z" fill="currentColor" opacity="0.3" />
													<path d="M8,2.5 C7.30964406,2.5 6.75,3.05964406 6.75,3.75 L6.75,20.25 C6.75,20.9403559 7.30964406,21.5 8,21.5 L16,21.5 C16.6903559,21.5 17.25,20.9403559 17.25,20.25 L17.25,3.75 C17.25,3.05964406 16.6903559,2.5 16,2.5 L8,2.5 Z M8,1 L16,1 C17.5187831,1 18.75,2.23121694 18.75,3.75 L18.75,20.25 C18.75,21.7687831 17.5187831,23 16,23 L8,23 C6.48121694,23 5.25,21.7687831 5.25,20.25 L5.25,3.75 C5.25,2.23121694 6.48121694,1 8,1 Z M9.5,1.75 L14.5,1.75 C14.7761424,1.75 15,1.97385763 15,2.25 L15,3.25 C15,3.52614237 14.7761424,3.75 14.5,3.75 L9.5,3.75 C9.22385763,3.75 9,3.52614237 9,3.25 L9,2.25 C9,1.97385763 9.22385763,1.75 9.5,1.75 Z" fill="currentColor" />
												</svg>
											</span>
											<!--end::Svg Icon--><?= $datauser->number ?>
										</a>
									</div>
									<!--end::Info-->
								</div>
								<!--end::User-->
								<!--begin::Actions-->
								<div class="d-flex my-4">
									<a href="<?= current_url() ?>" class="btn btn-sm btn-light me-2" id="kt_user_follow_button">
										<!--begin::Svg Icon | path: icons/duotune/arrows/arr012.svg-->
										<span class="svg-icon svg-icon-3 d-none">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path opacity="0.3" d="M10 18C9.7 18 9.5 17.9 9.3 17.7L2.3 10.7C1.9 10.3 1.9 9.7 2.3 9.3C2.7 8.9 3.29999 8.9 3.69999 9.3L10.7 16.3C11.1 16.7 11.1 17.3 10.7 17.7C10.5 17.9 10.3 18 10 18Z" fill="currentColor" />
												<path d="M10 18C9.7 18 9.5 17.9 9.3 17.7C8.9 17.3 8.9 16.7 9.3 16.3L20.3 5.3C20.7 4.9 21.3 4.9 21.7 5.3C22.1 5.7 22.1 6.30002 21.7 6.70002L10.7 17.7C10.5 17.9 10.3 18 10 18Z" fill="currentColor" />
											</svg>
										</span>
										<!--end::Svg Icon-->
										<!--begin::Indicator-->
										<span class="indicator-label">Follow</span>
										<span class="indicator-progress">Please wait...
											<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
										<!--end::Indicator-->
									</a>
									<a href="<?= current_url() ?>" class="btn btn-sm btn-primary me-2" data-bs-toggle="modal" data-bs-target="#kt_modal_offer_a_deal">Hire Me</a>
									<!--begin::Menu-->
									<div class="me-0">
										<button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
											<i class="bi bi-three-dots fs-3"></i>
										</button>
										<!--begin::Menu 3-->
										<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
											<!--begin::Heading-->
											<div class="menu-item px-3">
												<div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Payments</div>
											</div>
											<!--end::Heading-->
											<!--begin::Menu item-->
											<div class="menu-item px-3">
												<a href="<?= current_url() ?>" class="menu-link px-3">Create Invoice</a>
											</div>
											<!--end::Menu item-->
											<!--begin::Menu item-->
											<div class="menu-item px-3">
												<a href="<?= current_url() ?>" class="menu-link flex-stack px-3">Create Payment
													<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify a target name for future usage and reference"></i></a>
											</div>
											<!--end::Menu item-->
											<!--begin::Menu item-->
											<div class="menu-item px-3">
												<a href="<?= current_url() ?>" class="menu-link px-3">Generate Bill</a>
											</div>
											<!--end::Menu item-->
											<!--begin::Menu item-->
											<div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end">
												<a href="<?= current_url() ?>" class="menu-link px-3">
													<span class="menu-title">Subscription</span>
													<span class="menu-arrow"></span>
												</a>
												<!--begin::Menu sub-->
												<div class="menu-sub menu-sub-dropdown w-175px py-4">
													<!--begin::Menu item-->
													<div class="menu-item px-3">
														<a href="<?= current_url() ?>" class="menu-link px-3">Plans</a>
													</div>
													<!--end::Menu item-->
													<!--begin::Menu item-->
													<div class="menu-item px-3">
														<a href="<?= current_url() ?>" class="menu-link px-3">Billing</a>
													</div>
													<!--end::Menu item-->
													<!--begin::Menu item-->
													<div class="menu-item px-3">
														<a href="<?= current_url() ?>" class="menu-link px-3">Statements</a>
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
												<a href="<?= current_url() ?>" class="menu-link px-3">Settings</a>
											</div>
											<!--end::Menu item-->
										</div>
										<!--end::Menu 3-->
									</div>
									<!--end::Menu-->
								</div>
								<!--end::Actions-->
							</div>
							<!--end::Title-->
							<!--begin::Stats-->
							<div class="d-flex flex-wrap flex-stack">
								<!--begin::Wrapper-->
								<div class="d-flex flex-column flex-grow-1 pe-8">
									<!--begin::Stats-->
									<div class="d-flex flex-wrap">
										<!--begin::Stat-->
										<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
											<!--begin::Number-->
											<div class="d-flex align-items-center">
												<!--end::Svg Icon-->
												<div class="fs-2 fw-bolder" data-kt-countup="true" data-kt-countup-value="<?= $readdatakandang['kandang_total'] ?>">0</div>
											</div>
											<!--end::Number-->
											<!--begin::Label-->
											<div class="fw-bold fs-6 text-gray-400">Total Kandang</div>
											<!--end::Label-->
										</div>
										<!--end::Stat-->
										<!--begin::Stat-->
										<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
											<!--begin::Number-->
											<div class="d-flex align-items-center">
												<!--end::Svg Icon-->
												<div class="fs-2 fw-bolder" data-kt-countup="true" data-kt-countup-value="<?= $readdatakandang['total_populasi'] ?>">0</div>
											</div>
											<!--end::Number-->
											<!--begin::Label-->
											<div class="fw-bold fs-6 text-gray-400">Populasi Total</div>
											<!--end::Label-->
										</div>
										<!--end::Stat-->
										<!--begin::Stat-->
										<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
											<!--begin::Number-->
											<div class="d-flex align-items-center">
												<div class="fs-2 fw-bolder" data-kt-countup="true" data-kt-countup-value="<?= $activePercentage ?>" data-kt-countup-prefix="%">0</div>
											</div>
											<!--end::Number-->
											<!--begin::Label-->
											<div class="fw-bold fs-6 text-gray-400">Chickin Rate</div>
											<!--end::Label-->
										</div>
										<!--end::Stat-->
										<!--begin::Stat-->
										<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
											<!--begin::Number-->
											<div class="d-flex align-items-center">
												<div class="fs-2 fw-bolder" data-kt-countup="true" data-kt-countup-value="<?= $restPercentage ?>" data-kt-countup-prefix="%">0</div>
											</div>
											<!--end::Number-->
											<!--begin::Label-->
											<div class="fw-bold fs-6 text-gray-400">Rehat Rate</div>
											<!--end::Label-->
										</div>
										<!--end::Stat-->
									</div>
									<!--end::Stats-->
								</div>
								<!--end::Wrapper-->
								<!--begin::Progress-->
								<div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
									<div class="d-flex justify-content-between w-100 mt-auto mb-2">
										<span class="fw-bold fs-6 text-gray-400">Profile Compleation</span>
										<span class="fw-bolder fs-6">50%</span>
									</div>
									<div class="h-5px mx-3 w-100 bg-light mb-3">
										<div class="bg-success rounded h-5px" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
								</div>
								<!--end::Progress-->
							</div>
							<!--end::Stats-->
						</div>
						<!--end::Info-->
					</div>
					<!--end::Details-->
					<!--begin::Navs-->
					<ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder">
						<!--begin::Nav item-->
						<li class="nav-item mt-2">
							<a class="nav-link text-active-primary ms-0 me-10 py-5 active" data-bs-toggle="tab" href="#kt_overlay">Overview</a>
						</li>
						<!--end::Nav item-->
						<!--begin::Nav item-->
						<li class="nav-item mt-2">
							<a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab" href="#kt_editprofile">Edit Profile</a>
						</li>
						<!--end::Nav item-->
						<!--begin::Nav item-->
						<li class="nav-item mt-2">
							<a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab" href="#kt_campaigns">Campaigns</a>
						</li>
						<!--end::Nav item-->
						<!--begin::Nav item-->
						<li class="nav-item mt-2">
							<a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab" href="#kt_documents">Documents</a>
						</li>
						<!--end::Nav item-->
						<!--begin::Nav item-->
						<li class="nav-item mt-2">
							<a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab" href="#kt_activity">Activity</a>
						</li>
						<!--end::Nav item-->
					</ul>
					<!--begin::Navs-->
				</div>
			</div>
			<!--end::Navbar-->
			<div class="tab-content">
				<div id="kt_overlay" class="tab-pane fade active show">
					<!--begin::Row-->
					<div class="row g-5 g-xxl-8">
						<div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
							<!--begin::Card header-->
							<div class="card-header cursor-pointer">
								<!--begin::Card title-->
								<div class="card-title m-0">
									<h3 class="fw-bolder m-0">Profile Details</h3>
								</div>
								<!--end::Card title-->
							</div>
							<!--begin::Card header-->
							<!--begin::Card body-->
							<div class="card-body p-9">
								<!--begin::Row-->
								<div class="row mb-7">
									<!--begin::Label-->
									<label class="col-lg-4 fw-bold text-muted">Nama Lengkap</label>
									<!--end::Label-->
									<!--begin::Col-->
									<div class="col-lg-8">
										<span class="fw-bolder fs-6 text-gray-800"><?= $datauser->first_name . " " . $datauser->last_name ?></span>
									</div>
									<!--end::Col-->
								</div>
								<!--end::Row-->
								<!--begin::Input group-->
								<div class="row mb-7">
									<!--begin::Label-->
									<label class="col-lg-4 fw-bold text-muted">Nomor HP
										<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="Nomor HP harus aktif" aria-label="Nomor HP harus aktif"></i></label>
									<!--end::Label-->
									<!--begin::Col-->
									<div class="col-lg-8 d-flex align-items-center">
										<span class="fw-bolder fs-6 text-gray-800 me-2"><?= $datauser->number ?></span>
										<span class="badge badge-success">Verified</span>
									</div>
									<!--end::Col-->
								</div>
								<!--end::Input group-->
								<!--begin::Input group-->
								<div class="row mb-7">
									<!--begin::Label-->
									<label class="col-lg-4 fw-bold text-muted">Alamat</label>
									<!--end::Label-->
									<!--begin::Col-->
									<div class="col-lg-8 fv-row">
										<span class="fw-bold text-gray-800 fs-6"><?= $datauser->alamat ?></span>
									</div>
									<!--end::Col-->
								</div>
								<!--end::Input group-->
								<!--begin::Notice-->
								<div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
									<!--begin::Icon-->
									<!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
									<span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
											<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"></rect>
											<rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor"></rect>
											<rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor"></rect>
										</svg>
									</span>
									<!--end::Svg Icon-->
									<!--end::Icon-->
									<!--begin::Wrapper-->
									<div class="d-flex flex-stack flex-grow-1">
										<!--begin::Content-->
										<div class="fw-bold">
											<h4 class="text-gray-900 fw-bolder">We need your attention!</h4>
											<div class="fs-6 text-gray-700">Your payment was declined. To start using tools, please
												<a class="fw-bolder" href="../../demo1/dist/account/billing.html">Add Payment Method</a>.
											</div>
										</div>
										<!--end::Content-->
									</div>
									<!--end::Wrapper-->
								</div>
								<!--end::Notice-->
							</div>
							<!--end::Card body-->
						</div>
					</div>
					<!--end::Row-->
				</div>
				<div id="kt_editprofile" class="tab-pane fade show">
					<!--begin::Row-->
					<div class="row g-5 g-xxl-8">
						<div class="card mb-5 mb-xl-10">
							<!--begin::Card header-->
							<div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
								<!--begin::Card title-->
								<div class="card-title m-0">
									<h3 class="fw-bolder m-0">Edit Profile Details</h3>
								</div>
								<!--end::Card title-->
							</div>
							<!--begin::Card header-->
							<!--begin::Content-->
							<div id="kt_account_settings_profile_details" class="collapse show">
								<!--begin::Form-->
								<form id="kt_account_profile_details_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate" method="POST" action="<?= base_url('user/input_user') ?>">
									<!--begin::Card body-->
									<div class="card-body border-top p-9">
										<!--begin::Input group-->
										<div class="row mb-6">
											<!--begin::Label-->
											<label class="col-lg-4 col-form-label fw-bold fs-6">Avatar</label>
											<!--end::Label-->
											<!--begin::Col-->
											<div class="col-lg-8">
												<!--begin::Image input-->
												<div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('assets/media/svg/avatars/blank.svg')">
													<!--begin::Preview existing avatar-->
													<div class="image-input-wrapper w-125px h-125px" style="background-image: url(<?= $this->config->item('app_url') . $datauser->foto ?>)"></div>
													<!--end::Preview existing avatar-->
													<!--begin::Label-->
													<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="" data-bs-original-title="Change avatar">
														<i class="bi bi-pencil-fill fs-7"></i>
														<!--begin::Inputs-->
														<input type="file" id="avatar" name="avatar" accept=".png, .jpg, .jpeg">
														<input type="hidden" name="avatar_remove">
														<!--end::Inputs-->
													</label>
													<!--end::Label-->
													<!--begin::Cancel-->
													<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="" data-bs-original-title="Cancel avatar">
														<i class="bi bi-x fs-2"></i>
													</span>
													<!--end::Cancel-->
													<!--begin::Remove-->
													<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="" data-bs-original-title="Remove avatar">
														<i class="bi bi-x fs-2"></i>
													</span>
													<!--end::Remove-->
												</div>
												<!--end::Image input-->
												<!--begin::Hint-->
												<div class="form-text">Allowed file types: png, jpg, jpeg.</div>
												<!--end::Hint-->
											</div>
											<!--end::Col-->
										</div>
										<!--end::Input group-->
										<!--begin::Input group-->
										<div class="row mb-6">
											<!--begin::Label-->
											<label class="col-lg-4 col-form-label required fw-bold fs-6">Full Name</label>
											<!--end::Label-->
											<!--begin::Col-->
											<div class="col-lg-8">
												<!--begin::Row-->
												<div class="row">
													<!--begin::Col-->
													<div class="col-lg-6 fv-row fv-plugins-icon-container">
														<input type="text" name="fname" id="first_name" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="First name" value="<?= $datauser->first_name ?>">
														<input type="hidden" name="id" id="id" value="<?= $datauser->id ?>">
														<div class="fv-plugins-message-container invalid-feedback"></div>
													</div>
													<!--end::Col-->
													<!--begin::Col-->
													<div class="col-lg-6 fv-row fv-plugins-icon-container">
														<input type="text" name="lname" id="last_name" class="form-control form-control-lg form-control-solid" placeholder="Last name" value="<?= $datauser->last_name ?>">
														<div class="fv-plugins-message-container invalid-feedback"></div>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Row-->
											</div>
											<!--end::Col-->
										</div>
										<!--end::Input group-->
										<!--begin::Input group-->
										<div class="row mb-6">
											<!--begin::Label-->
											<label class="col-lg-4 col-form-label fw-bold fs-6">
												<span class="required">Nomor HP</span>
												<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="Phone number must be active" aria-label="Phone number must be active"></i>
											</label>
											<!--end::Label-->
											<!--begin::Col-->
											<div class="col-lg-8 fv-row fv-plugins-icon-container">
												<input type="tel" name="phone" id="number" class="form-control form-control-lg form-control-solid" placeholder="Phone number" value="<?= $datauser->number ?>">
												<div class="fv-plugins-message-container invalid-feedback"></div>
											</div>
											<!--end::Col-->
										</div>
										<!--end::Input group-->
										<!--begin::Input group-->
										<div class="row mb-6">
											<!--begin::Label-->
											<label class="col-lg-4 col-form-label fw-bold fs-6">Alamat</label>
											<!--end::Label-->
											<!--begin::Col-->
											<div class="col-lg-8 fv-row">
												<textarea name="alamat" id="alamat" class="form-control form-control-lg form-control-solid" placeholder="Alamat"><?= $datauser->alamat ?></textarea>
												<!-- <input type="text" name="alamat" class="form-control form-control-lg form-control-solid" placeholder="Alamat" value="<?= $datauser->alamat ?>"> -->
											</div>
											<!--end::Col-->
										</div>
										<!--end::Input group-->
										<!--begin::Input group-->
										<div class="row mb-0">
											<!--begin::Label-->
											<label class="col-lg-4 col-form-label fw-bold fs-6">Banned</label>
											<!--begin::Label-->
											<!--begin::Label-->
											<div class="col-lg-8 d-flex align-items-center">
												<div class="form-check form-check-solid form-switch fv-row">
													<input class="form-check-input w-45px h-30px" type="checkbox" id="bannedid" checked="checked" onclick="bannedfunction()">
													<label class="form-check-label" for="bannedid"></label>
												</div>
											</div>
											<!--begin::Label-->
										</div>
										<!--end::Input group-->
									</div>
									<!--end::Card body-->
									<!--begin::Actions-->
									<div class="card-footer d-flex justify-content-end py-6 px-9">
										<button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
										<button type="button" class="btn btn-primary" id="kt_account_profile_details_submit" onclick="submitform()">Save Changes</button>
									</div>
									<!--end::Actions-->
									<input type="hidden">
									<div></div>
								</form>
								<!--end::Form-->
							</div>
							<!--end::Content-->
						</div>
					</div>
					<!--end::Row-->
				</div>
				<div id="kt_activity" class="tab-pane fade show">
					<!--begin::Row-->
					<div class="row g-5 g-xxl-8">
						<div class="card mb-5 mb-lg-10">
							<!--begin::Card header-->
							<div class="card-header border-0">
								<!--begin::Card title-->
								<div class="card-title">
									<h2>Logs</h2>
								</div>
								<!--end::Card title-->
								<!--begin::Card toolbar-->
								<div class="card-toolbar">
									<!--begin::Button-->
									<button type="button" class="btn btn-sm btn-light-primary">
										<!--begin::Svg Icon | path: icons/duotune/files/fil021.svg-->
										<span class="svg-icon svg-icon-3">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path opacity="0.3" d="M19 15C20.7 15 22 13.7 22 12C22 10.3 20.7 9 19 9C18.9 9 18.9 9 18.8 9C18.9 8.7 19 8.3 19 8C19 6.3 17.7 5 16 5C15.4 5 14.8 5.2 14.3 5.5C13.4 4 11.8 3 10 3C7.2 3 5 5.2 5 8C5 8.3 5 8.7 5.1 9H5C3.3 9 2 10.3 2 12C2 13.7 3.3 15 5 15H19Z" fill="currentColor"></path>
												<path d="M13 17.4V12C13 11.4 12.6 11 12 11C11.4 11 11 11.4 11 12V17.4H13Z" fill="currentColor"></path>
												<path opacity="0.3" d="M8 17.4H16L12.7 20.7C12.3 21.1 11.7 21.1 11.3 20.7L8 17.4Z" fill="currentColor"></path>
											</svg>
										</span>
										<!--end::Svg Icon-->Download Report
									</button>
									<!--end::Button-->
								</div>
								<!--end::Card toolbar-->
							</div>
							<!--end::Card header-->
							<!--begin::Card body-->
							<div class="card-body py-0">
								<!--begin::Table wrapper-->
								<div class="table-responsive">
									<!--begin::Table-->
									<table class="table align-middle table-row-dashed fw-bold text-gray-600 fs-6 gy-5" id="kt_table_customers_logs">
										<!--begin::Table body-->
										<tbody>
											<?php if ($datalogger !== FALSE) {
												foreach ($datalogger as $dataloggers) { ?>

													<tr>
														<td class="min-w-70px">
															<div class="badge badge-light-success">200 OK</div>
														</td>
														<td><?= $dataloggers->url ?></td>
														<td class="pe-0 text-end min-w-200px"><?= date('d M Y, H:i:s', strtotime($dataloggers->created_at)) ?></td>
													</tr>
													<!--end::Table row-->
											<?php }
											} ?>
										</tbody>
										<!--end::Table body-->
									</table>
									<!--end::Table-->
								</div>
								<!--end::Table wrapper-->
							</div>
							<!--end::Card body-->
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--end::Container-->
	</div>
	<!--end::Post-->
</div>
<!--end::Content-->