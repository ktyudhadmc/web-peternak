<input type="hidden" id="groupingname" value="<?= urldecode($this->uri->segment(4)) ?>" class="form-control">
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<!--begin::Toolbar-->
	<input class="form-control" type="hidden" id="kandang_periode" value="<?= $idkandang . "|" . $periode ?>" required>
	<input class="form-control" type="hidden" id="id_kandang" value="<?= $idkandang ?>" required>
	<input class="form-control" type="hidden" id="status_kandang" value="<?= $status_kandang ?>" required>
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
					<a href="#" id="searchbutton" class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
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
									<input type="text" id="searchkandangperiode" class="form-control form-control-lg form-control-solid px-15" name="search" value="" placeholder="Cari data kandang lain" data-kt-search-element="input" onkeyup='elementsSearch()' />
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
					<div id="ternak_detail_top">
						<div class="ph-item">
							<div class="ph-col-2">
								<div class="ph-avatar"></div>
							</div>
							<div>
								<div class="ph-row">
									<div class="ph-col-2"></div>
									<div class="ph-col-8 empty"></div>
									<div class="ph-col-2"></div>
									<div class="ph-col-12"></div>
									<div class="ph-col-12"></div>
									<div class="ph-col-12"></div>
									<div class="ph-col-12"></div>
									<div class="ph-col-12"></div>
								</div>
							</div>
						</div>
					</div>
					<!--end::Details-->
					<div class="separator"></div>
					<!--begin::Nav-->
					<ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder">
						<!--begin::Nav item-->
						<li class="nav-item">
							<a class="nav-link text-active-primary py-5 me-6 active" data-bs-toggle="tab" href="#kt_resume" onclick="resume()">Resume</a>
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
							<a class="nav-link text-active-primary py-5 me-6" data-bs-toggle="tab" href="#kt_logrh" onclick="logrh()">Easy Climate</a>
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
				<div id="kt_resume" class="tab-pane fade active show">
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