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
								<h3 id='tittle_table_export_data' class="fw-bolder mb-1">Tabel Export Data</h3>
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
									<?php //echo json_encode($getdatauser) 
									?>

									<select name="lokasi" id="filter_lokasi" class="form-select form-select-solid" data-control="select2" multiple="multiple" data-placeholder="Pilih Lokasi" tabindex="-1" aria-hidden="true">
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
										<option value='aktif' data-1='-' data-2='-' data-3='-'>Open</option>
										<option value='close' data-1='-' data-2='-' data-3='-'>Close</option>
									</select>
								</div>
							</div>
							<div class='form-group row mt-5'>
								<div class="col-4">
									<h4 class="fw-bolder mb-1">Tahun Chickin</h4>
								</div>
								<div class="col-8">
									<select name="status" id="tahun" class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Month">
										<option value='0' data-1='-' data-2='-' data-3='-'>Pilih Tahun</option>
										<?php for ($i = 2020; $i <= date('Y'); $i++) { ?>
											<option value='<?= $i ?>' data-1='-' data-2='-' data-3='-'><?= $i ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class='form-group row mt-5'>
								<div class="col-4">
									<h4 class="fw-bolder mb-1">Bulan Chickin</h4>
								</div>
								<div class="col-8">
									<select name="status" id="bulan" class="form-select form-select-solid" data-control="select2" multiple="multiple" data-hide-search="true" data-placeholder="Month">
										<option value='0' data-1='-' data-2='-' data-3='-'>Pilih Bulan</option>
										<option value='1' data-1='-' data-2='-' data-3='-'>Januari</option>
										<option value='2' data-1='-' data-2='-' data-3='-'>Februari</option>
										<option value='3' data-1='-' data-2='-' data-3='-'>Maret</option>
										<option value='4' data-1='-' data-2='-' data-3='-'>April</option>
										<option value='5' data-1='-' data-2='-' data-3='-'>Mei</option>
										<option value='6' data-1='-' data-2='-' data-3='-'>Juni</option>
										<option value='7' data-1='-' data-2='-' data-3='-'>Juli</option>
										<option value='8' data-1='-' data-2='-' data-3='-'>Agustus</option>
										<option value='9' data-1='-' data-2='-' data-3='-'>September</option>
										<option value='10' data-1='-' data-2='-' data-3='-'>Oktober</option>
										<option value='11' data-1='-' data-2='-' data-3='-'>Nopember</option>
										<option value='12' data-1='-' data-2='-' data-3='-'>Desember</option>
									</select>
								</div>
							</div>
							<div class='form-group row mt-5'>
								<!-- <div class="col-12">
									<a  class="btn btn-sm btn-primary" onclick="viewtableexportdata()" id='button_viewtableexportdata'>Load</a>
								</div> -->
							</div>
						</div>
						<!--end::Card body-->
						<!--begin::Card header-->
						<div class="card-header mt-5">
							<!--begin::Card title-->
							<div class="card-title flex-column">
								<h3 id='tittle_table_export_data_status' class="fw-bolder mb-1">Tabel Export Data</h3>
								<!-- <div class="fs-6 text-gray-400">Total $260,300 sepnt so far</div> -->
							</div>
							<!--begin::Card title-->
							<!--begin::Card toolbar-->
							<div class="card-toolbar my-1">
								<!-- begin::Primary button -->
								<a class="btn btn-sm btn-primary" onclick="viewtableexportdatastatus()">Load</a>
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
								<table id="exampletableexportdatastatus" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bolder">
									<!--begin::Head-->
									<thead class="fs-7 text-gray-400 text-uppercase">
										<tr>
											<th>Kode Kandang</th>
											<th>Periode</th>
											<th>Tgl Chick in</th>
											<th>Nama Kandang</th>
											<th>Populasi Awal</th>
											<th>Strain</th>
											<th>Pic</th>
											<th>ABK</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Kode Kandang</th>
											<th>Periode</th>
											<th>Tgl Chick in</th>
											<th>Nama Kandang</th>
											<th>Populasi Awal</th>
											<th>Strain</th>
											<th>Pic</th>
											<th>ABK</th>
										</tr>
									</tfoot>
								</table>
								<!--end::Table-->
							</div>
							<!--end::Table container-->
						</div>
						<!--end::Card body-->
						<!--begin::Card header-->
						<div class="card-header mt-5">
							<!--begin::Card title-->
							<div class="card-title flex-column">
								<h3 id='tittle_table_export_data_lhk' class="fw-bolder mb-1">Tabel Export LHK</h3>
								<!--<div class="fs-6 text-gray-400">Total $260,300 sepnt so far</div>-->
							</div>
							<!--begin::Card title-->
							<!--begin::Card toolbar-->
							<div class="card-toolbar my-1">
								<!--begin::Primary button-->
								<a class="btn btn-sm btn-primary" onclick="viewtableexportdatalhk()">Load</a>
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
								<table id="exampletableexportdatalhk" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bolder">
									<!--begin::Head-->
									<thead class="fs-7 text-gray-400 text-uppercase">
										<tr>
											<th>Kode Kandang</th>
											<th>Periode</th>
											<th>Nama Kandang</th>
											<th>Umur</th>
											<th>Sampling BW</th>
											<th>SB20</th>
											<th>BR0</th>
											<th>SB21CR</th>
											<th>SB21P</th>
											<th>BR1CR</th>
											<th>BR1P</th>
											<th>SB22</th>
											<th>BR2</th>
											<th>LL</th>
											<th>MATI</th>
											<th>CULLING</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Kode Kandang</th>
											<th>Periode</th>
											<th>Nama Kandang</th>
											<th>Umur</th>
											<th>Sampling BW</th>
											<th>SB20</th>
											<th>BR0</th>
											<th>SB21CR</th>
											<th>SB21P</th>
											<th>BR1CR</th>
											<th>BR1P</th>
											<th>SB22</th>
											<th>BR2</th>
											<th>LL</th>
											<th>MATI</th>
											<th>CULLING</th>
										</tr>
									</tfoot>
								</table>
								<!--end::Table-->
							</div>
							<!--end::Table container-->
						</div>
						<!--end::Card body-->
						<!--begin::Card header-->
						<div class="card-header mt-5">
							<!--begin::Card title-->
							<div class="card-title flex-column">
								<h3 id='tittle_table_export_data_panen' class="fw-bolder mb-1">Tabel Export Panen</h3>
								<!--<div class="fs-6 text-gray-400">Total $260,300 sepnt so far</div>-->
							</div>
							<!--begin::Card title-->
							<!--begin::Card toolbar-->
							<div class="card-toolbar my-1">
								<!--begin::Primary button-->
								<a class="btn btn-sm btn-primary" onclick="viewtableexportdatapanen()">Load</a>
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
								<table id="exampletableexportdatapanen" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bolder">
									<!--begin::Head-->
									<thead class="fs-7 text-gray-400 text-uppercase">
										<tr>
											<th>Tgl Panen</th>
											<th>No. DO</th>
											<th>No. Pol</th>
											<th>Kode Kandang</th>
											<th>Periode</th>
											<th>No. Nota Manual</th>
											<th>Nama Bakul</th>
											<th>Ekor</th>
											<th>Berat (Kg)</th>
											<th>Susut Kg</th>
											<th>Jml Kg Nett</th>
											<th>Kondisi Ayam</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Tgl Panen</th>
											<th>No. DO</th>
											<th>No. Pol</th>
											<th>Kode Kandang</th>
											<th>Periode</th>
											<th>No. Nota Manual</th>
											<th>Nama Bakul</th>
											<th>Ekor</th>
											<th>Berat (Kg)</th>
											<th>Susut Kg</th>
											<th>Jml Kg Nett</th>
											<th>Kondisi Ayam</th>
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