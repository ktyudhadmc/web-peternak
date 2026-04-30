<style>
	.dataTables_wrapper {
		/*font-family: tahoma;*/
		font-size: 10px;
		/*position: relative;*/
		/*clear: both;*/
		/**zoom: 1;*/
		/*zoom: 1;*/
	}

	.hidden {
		display: none;
	}
</style>
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<!--begin::Toolbar-->
	<div class="toolbar" id="kt_toolbar">
		<!--begin::Container-->
		<div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
			<!--begin::Page title-->
			<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
				<!--begin::Title-->
				<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1"><?= $title ?></h1>
				<!--end::Title-->
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

			<!--begin::Row-->
			<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
				<!--begin::Col-->
				<div class="col-xxl-12">
					<!--begin::Table-->
					<div class="card card-flush">
						<!--begin::Card header-->
						<div class="card-header mt-5">
							<!--begin::Card title-->
							<div class="card-title flex-column">
								<h3 id='tittle_table_warning' class="fw-bolder mb-1">FCR Global</h3>
							</div>
							<div class="card-toolbar my-1">
							</div>
						</div>
						<!--end::Card header-->
						<!--begin::Card body-->
						<div class="card-body pt-0">
							<div class="separator"></div>
							<ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder">
								<li class="nav-item">
									<a class="nav-link text-active-primary py-5 me-6 active" data-bs-toggle="tab" href="#by_year">Data by Year</a>
								</li>
								<li class="nav-item">
									<a class="nav-link text-active-primary py-5 me-6" data-bs-toggle="tab" href="#by_kandang">Data by Kandang</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="tab-content">
						<div id="by_kandang" class="tab-pane fade show">
							<div class="card card-flush mt-5">
								<div class="card-body pt-5">
									<div class="card-body pt-0 pb-0 tab-content">
										<div class='form-group row align-items-center'>
											<div class="col-4">
												<h4 class="fw-bolder mb-1">Pilih Kandang</h4>
											</div>
											<div class="col-8">
												<select name="lokasi" id="filter_lokasi_kandang" class="form-select form-select-solid" data-control="select2" multiple="multiple" data-placeholder="Pilih Lokasi" tabindex="-1" aria-hidden="true">
													<?php

													if (is_array($getdatauser_kandang) || is_object($getdatauser_kandang)) {
														echo "<option value='0' data-1='-' data-2='-' data-3='-'>Pilih Kandang</option>";
														foreach ($getdatauser_kandang as $kandang) {
															echo "<option value='{$kandang->id}' >{$kandang->nama} - {$kandang->periode} - {$kandang->status}</option>";
														}
													} else {
														echo "<option value='-' data-1='-' data-2='-' data-3='-'>Tidak ada data</option>";
													}

													?>
												</select>
												<!--<input type="text" class="form-control form-control-solid" placeholder="" name="card_name" value="Max Doe">-->
											</div>
										</div>
										<div class='form-group row mt-5'>
											<div class="col-12">
												<a class="btn btn-sm btn-primary" onclick="calculate_by_kandang()" id='button_calculate_kandang'>Calculate</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div id="div_result_dinamis_by_kandang"></div>
						</div>
						<div id="by_year" class="tab-pane fade show active">
							<div class="card card-flush mt-5">
								<div class="card-body pt-5">
									<div class="card-body pt-0 pb-0 tab-content">
										<div class='form-group row mt-5'>
											<div class="col-4">
												<h4 class="fw-bolder mb-1">Pilih Lokasi</h4>
											</div>
											<div class="col-8">
												<select name="lokasi[]" id="filter_lokasi" class="form-select form-select-solid" data-control="select2" multiple="multiple" data-placeholder="Pilih Lokasi" tabindex="-1" aria-hidden="true">
													<?php

													if (is_array($getdatauser) || is_object($getdatauser)) {
														echo "<option value='0' data-1='-' data-2='-' data-3='-'>Pilih Lokasi</option>";
														foreach ($getdatauser as $getdatausers) {
															echo "<option value='" . implode(',', $getdatausers['id_kandang']) . "'>{$getdatausers['nama_user']}</option>";
														}
													} else {
														echo "<option value='-' data-1='-' data-2='-' data-3='-'>Tidak ada data</option>";
													}

													?>
												</select>
												<!--<input type="text" class="form-control form-control-solid" placeholder="" name="card_name" value="Max Doe">-->
											</div>
										</div>
										<div class='form-group row mt-5'>
											<div class="col-4">
												<h4 class="fw-bolder mb-1">Status</h4>
											</div>
											<div class="col-8">
												<select name="status" id="status" class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Month">
													<option value='0' data-1='-' data-2='-' data-3='-'>Pilih Status</option>
													<option value='open' data-1='-' data-2='-' data-3='-'>Open</option>
													<option value='close' data-1='-' data-2='-' data-3='-'>Close</option>
													<option value='all' data-1='-' data-2='-' data-3='-'>Open & Close</option>
												</select>
											</div>
										</div>
										<div class='form-group row mt-5'>
											<div class="col-4">
												<h4 class="fw-bolder mb-1">Tahun Mulai</h4>
											</div>
											<div class="col-8">
												<select name="tahun_mulai" id="tahun_mulai" class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Month">
													<option value='0' data-1='-' data-2='-' data-3='-'>Pilih Tahun</option>
													<?php for ($i = 2020; $i <= date('Y'); $i++) { ?>
														<option value='<?= $i ?>' data-1='-' data-2='-' data-3='-'><?= $i ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class='form-group row mt-5'>
											<div class="col-4">
												<h4 class="fw-bolder mb-1">Tahun Akhir</h4>
											</div>
											<div class="col-8">
												<select name="tahun_akhir" id="tahun_akhir" class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Month">
													<option value='0' data-1='-' data-2='-' data-3='-'>Pilih Tahun</option>
													<?php for ($i = 2020; $i <= date('Y'); $i++) { ?>
														<option value='<?= $i ?>' data-1='-' data-2='-' data-3='-'><?= $i ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class='form-group row mt-5'>
											<div class="col-12">
												<a class="btn btn-sm btn-primary" onclick="calculate()" id='button_calculate'>Calculate</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div id="div_result_dinamis"></div>
						</div>
					</div>
					<!--end::Card body-->
				</div>
			</div>
			<!--end::Card-->
		</div>
		<!--end::Col-->
		<!--begin::Col-->

		<!--end::Col-->
	</div>
	<!--end::Row-->
</div>
<!--end::Container-->
</div>
<!--end::Post-->
</div>
<!--end::Content-->