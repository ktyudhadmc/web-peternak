<style>
	.dataTables_wrapper {
		/*font-family: tahoma;*/
		font-size: 10px;
		/*position: relative;*/
		/*clear: both;*/
		/**zoom: 1;*/
		/*zoom: 1;*/
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
								<h3 id='tittle_table_warning' class="fw-bolder mb-1">Tabel Warning</h3>
								<!--<div class="fs-6 text-gray-400">Total $260,300 sepnt so far</div>-->
							</div>
							<!--begin::Card title-->
							<!--begin::Card toolbar-->
							<div class="card-toolbar my-1">
								<!--begin::Primary button-->
								<a class="btn btn-sm btn-primary" onclick="viewtablewarning()" id='button_viewtablewarning'>Load</a>
								<!--end::Primary button-->
							</div>
							<!--begin::Card toolbar-->
						</div>
						<!--end::Card header-->
						<!--begin::Card body-->
						<div class="card-body pt-0">
							<!--begin::Table container-->
							<div class="table-responsive">
								<!--begin::Table-->
								<table id="exampletablewarning" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bolder">
									<!--begin::Head-->
									<thead class="fs-7 text-gray-400 text-uppercase">
										<tr>
											<th>Kandang</th>
											<th>Periode</th>
											<th>Umur</th>
											<th>Status</th>
											<th>Tanggal</th>
											<th>Nilai</th>
											<th>Comment</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Kandang</th>
											<th>Periode</th>
											<th>Umur</th>
											<th>Status</th>
											<th>Tanggal</th>
											<th>Nilai</th>
											<th>Comment</th>
										</tr>
									</tfoot>
								</table>
								<!--end::Table-->
							</div>
							<!--end::Table container-->
						</div>
						<!--end::Card body-->
					</div>
					<!--end::Card-->
				</div>
				<!--end::Col-->
				<!--begin::Col-->
				<div class="col-xxl-12">
					<!--begin::Table-->
					<div class="card card-flush">
						<!--begin::Card header-->
						<div class="card-header mt-5">
							<!--begin::Card title-->
							<div class="card-title flex-column">
								<h3 class="fw-bolder mb-1">Tabel Warning Lokasi</h3>
								<!--<div class="fs-6 text-gray-400">Total $260,300 sepnt so far</div>-->
							</div>
							<!--begin::Card title-->
							<!--begin::Card toolbar-->
							<div class="card-toolbar my-1">
								<!--begin::Primary button-->

								<!--end::Primary button-->
							</div>
							<!--begin::Card toolbar-->
						</div>
						<!--end::Card header-->
						<!--begin::Card body-->
						<div class="card-body pt-0">
							<div class='form-group row'>
								<div class="col-4">
									<h4 class="fw-bolder mb-1">Pilih Lokasi</h4>
								</div>
								<div class="col-8">
									<select name="lokasi" id="filter_lokasi" class="form-select form-select-solid" data-control="select2" multiple="multiple" data-placeholder="Pilih Lokasi" tabindex="-1" aria-hidden="true">

										<?php

										if (is_array($getdatauser) || is_object($getdatauser)) {
											echo "<option value='0' data-1='-' data-2='-' data-3='-'>Pilih Lokasi</option>";
											foreach ($getdatauser as $getdatausers) {
												echo "<option value='{$getdatausers->id}' data-1='{$getdatausers->id_kandang}' data-2='{$getdatausers->periode}' data-3='{$getdatausers->id_kandang}'>{$getdatausers->nama} - {$getdatausers->periode} - {$getdatausers->tanggal_mulai}</option>";
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
									<a class="btn btn-sm btn-primary" onclick="viewtablewarninglokasi()" id='button_viewtablewarninglokasi'>Load</a>
									<!-- <a href="#" onclick="loading()" class="btn btn-sm btn-light btn-primary" >Loading</a> -->
								</div>
							</div>
						</div>
						<!--end::Card body-->
						<!--begin::Card body-->
						<div class="card-body pt-0">
							<!--begin::Table container-->
							<div class="table-responsive">
								<!--begin::Table-->
								<table id="exampletablewarninglokasi" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bolder">
									<!--begin::Head-->
									<thead class="fs-7 text-gray-400 text-uppercase">
										<tr>
											<th>Kandang</th>
											<th>Periode</th>
											<th>Umur</th>
											<th>Status</th>
											<th>Tanggal</th>
											<th>Nilai</th>
											<th>Comment</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Kandang</th>
											<th>Periode</th>
											<th>Umur</th>
											<th>Status</th>
											<th>Tanggal</th>
											<th>Nilai</th>
											<th>Comment</th>
										</tr>
									</tfoot>
								</table>
								<!--end::Table-->
							</div>
							<!--end::Table container-->
						</div>
						<!--end::Card body-->
					</div>
					<!--end::Card-->
				</div>
				<!--end::Col-->
			</div>
			<!--end::Row-->
		</div>
		<!--end::Container-->
	</div>
	<!--end::Post-->
</div>
<!--end::Content-->