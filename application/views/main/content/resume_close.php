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
						<!-- <div class="card-header mt-5"> -->
						<!--begin::Card title-->
						<!-- <div class="card-title flex-column"> -->
						<!-- <h3 id='tittle_table_resume_close' class="fw-bolder mb-1">Tabel Resume Close</h3> -->
						<!--<div class="fs-6 text-gray-400">Total $260,300 sepnt so far</div>-->
						<!-- </div> -->
						<!--begin::Card title-->
						<!--begin::Card toolbar-->
						<!-- <div class="card-toolbar my-1"> -->
						<!--begin::Primary button-->

						<!--end::Primary button-->
						<!-- </div> -->
						<!--begin::Card toolbar-->
						<!-- </div> -->
						<!--end::Card header-->
						<!--begin::Card body-->
						<div class="card-body pt-0 mt-15">
							<div class='form-group row'>
								<div class="col-4">
									<h4 class="fw-bolder mb-1" tyle="margin-top: 10px;">Pilih Lokasi</h4>
								</div>
								<div class="col-8">
									<select name="lokasi" id="filter_lokasi" class="form-select form-select-solid" data-control="select2" multiple="multiple" data-hide-search="true" data-placeholder="Lokasi">
										<?php

										if (is_array($getdatauser) || is_object($getdatauser)) {
											echo "<option value='0' data-1='-' data-2='-' data-3='-'>Pilih Lokasi</option>";
											foreach ($getdatauser as $getdatausers) {
												// echo "<option value='{$getdatausers->id}' data-1='{$getdatausers->first_name}' data-2='{$getdatausers->id}' data-3='{$getdatausers->id}'>{$getdatausers->first_name}</option>";
												echo "<option value='" . implode(',', $getdatausers['id_kandang']) . "' data-1='{$getdatausers->nama_user}'>{$getdatausers['nama_user']}</option>";
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
									<h4 class="fw-bolder mb-1" tyle="margin-top: 10px;">Pilih Tanggal</h4>
								</div>
								<div class="col-8">
									<input class="form-control form-control-solid" placeholder="Pick date rage" name="lokasi" id="filter_tahun">
									<!-- <select name="lokasi" id="filter_tahun" class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Month">
										<?php

										if (is_array($gettahun) || is_object($gettahun)) {
											echo "<option value='0' >Pilih Tahun</option>";
											foreach ($gettahun as $gettahuns) {
												echo "<option value='{$gettahuns->tahun}'>{$gettahuns->tahun}</option>";
											}
										} else {
											echo "<option value='-' data-1='-' data-2='-' data-3='-'>Tidak ada data</option>";
										}

										?>
									</select> -->
									<!--<input type="text" class="form-control form-control-solid" placeholder="" name="card_name" value="Max Doe">-->
								</div>
							</div>
							<div class='form-group row mt-5'>
								<div class="col-12">
									<a class="btn btn-sm btn-primary" onclick="viewtableresumeclose()" id='button_viewtableresumeclose'>Load</a>
								</div>
							</div>
						</div>
						<!--end::Card body-->
						<!--begin::Card body-->
						<div class="card-body pt-0">
							<!--begin::Table container-->
							<div class="table-responsive">
								<!--begin::Table-->
								<table id="exampletableresumeclose" class="table table-row-bordered table-row-dashed gy-4 align-middle table-striped ">
									<!--begin::Head-->
									<thead class="fs-7 text-black-400 text-uppercase fw-bolder">
										<tr>
											<th> View </th>
											<th> Kandang </th>
											<th> Periode </th>
											<th> Strain </th>
											<th> Chickin </th>
											<th> Umur Rata Panen </th>
											<th> IP </th>
											<th> Rg 3 </th>
											<th> Rg 7 </th>
											<th> Populasi </th>
											<th> Deplesi(ekor) </th>
											<th> Deplesi(%) </th>
											<th> BW Rata Panen </th>
											<th> Total Panen </th>
											<th> Berat Panen </th>
											<th> Total Pakan </th>
											<th> Total Sekam </th>
											<th> Total LPG </th>
											<th> Act FCR </th>
											<th> Std FCR </th>
											<th> Diff FCR </th>
											<th> Panen Awal </th>
											<th> Panen Akhir </th>
											<th> Status </th>

											<!-- <th >Tanggal Chick In</th>
											<th >Periode</th>
											<th >Kandang</th>
											<th >Populasi Awal</th>
											<th >Umur Rata Panen</th>
											<th >BW Rata panen (gram)</th>
											<th >FCR</th>
											<th >FCR Std</th>
											<th >diff FCR</th>
											<th >Deplesi (%)</th>
											<th >Deplesi (Ekor)</th>
											<th >IP</th>
											<th >R.G Umur 3Hari</th>
											<th >R.G Umur 7Hari</th>
											<th >Panen (ekor)</th>
											<th >Panen (kg)</th>
											<th >Tgl Panen Terakhir</th>
											<th >Strain</th>
											<th >Status</th>
											<th >PIC</th>
											<th >ABK</th> -->
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>


											<!-- <th >Tanggal Chick In</th>
											<th >Periode</th>
											<th >Kandang</th>
											<th >Populasi Awal</th>
											<th >Umur Rata Panen</th>
											<th >BW Rata panen (gram)</th>
											<th >FCR</th>
											<th >FCR Std</th>
											<th >diff FCR</th>
											<th >Deplesi (%)</th>
											<th >Deplesi (Ekor)</th>
											<th >IP</th>
											<th >R.G Umur 3Hari</th>
											<th >R.G Umur 7Hari</th>
											<th >Panen (ekor)</th>
											<th >Panen (kg)</th>
											<th >Tgl Panen Terakhir</th>
											<th >Strain</th>
											<th >Status</th>
											<th >PIC</th>
											<th >ABK</th> -->
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
<script>
	$("#filter_tahun").daterangepicker({
		timePicker: false,
		startDate: moment().startOf("hour"),
		endDate: moment().startOf("hour").add(32, "hour"),
		locale: {
			format: "Y/M/DD"
		}
	});
</script>