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
								<h3 class="fw-bolder mb-1">Filter <?= $title ?></h3>
								<!--<div class="fs-6 text-gray-400">Total $260,300 sepnt so far</div>-->
							</div>
							<!--begin::Card title-->
						</div>
						<!--end::Card header-->
						<!--begin::Card body-->
						<div class="card-body pt-0">
							<div class='form-group row'>
								<div class="col-4">
									<h4 class="fw-bolder mb-1">Pilih Lokasi</h4>
								</div>
								<div class="col-8">
									<select name="lokasi" id="filter_lokasi" class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Month">
										<?php
										if (is_array($getdatauser) || is_object($getdatauser)) {
											echo "<option value='0' data-1='-' data-2='-' data-3='-'>Pilih Lokasi</option>";
											foreach ($getdatauser as $getdatausers) {
												echo "<option value='{$getdatausers->id_lokasi}' data-1='{$getdatausers->lokasinya}' data-2='{$getdatausers->id_lokasi}' data-3='{$getdatausers->id}'>{$getdatausers->lokasinya}</option>";
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
									<h4 class="fw-bolder mb-1">Range Tanggal</h4>
								</div>
								<div class="col-8">
									<input class="form-control form-control-solid" placeholder="Pick date rage" id="input_range_tanggal" />
								</div>
							</div>

							<div class='form-group row mt-5'>
								<div class="col-12">
									<a href="#" onclick="modal_jenis_pakan(`#add_kedatangan_pakan_brand`)" class="btn btn-sm btn-light btn-primary" data-bs-toggle="modal" data-bs-target="#modal_kedatangan_pakan">Input Kedatangan Pakan</a>
									<a href="#" onclick="modal_jenis_pakan(`#add_mutasi_pakan_brand`)" class="btn btn-sm btn-light btn-primary" data-bs-toggle="modal" data-bs-target="#modal_mutasi_pakan">Input Mutasi Pakan</a>
									<!-- <a href="#" onclick="loading()" class="btn btn-sm btn-light btn-primary" >Loading</a> -->
								</div>
							</div>
						</div>
						<!--end::Card body-->
					</div>
					<!--end::Card-->
				</div>
				<!--end::Col-->
			</div>
			<!--end::Row-->
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
								<h3 id='tittle_table_pemakaian_pakan' class="fw-bolder mb-1">Pemakaian Pakan</h3>
								<!--<div class="fs-6 text-gray-400">Total $260,300 sepnt so far</div>-->
							</div>
							<!--begin::Card title-->
							<!--begin::Card toolbar-->
							<div class="card-toolbar my-1">
								<!--begin::Primary button-->
								<a class="btn btn-sm btn-primary" onclick="viewtablepemakaianpakan()" id='button_viewtablepemakaianpakan'>Load</a>
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
								<table id="exampletablepemakaianpakan" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bolder">
									<thead class="fs-7 text-gray-400 text-uppercase">
										<tr>

											<th>Kandang</th>
											<th>Periode</th>
											<th>Pakan</th>
											<th>Qty</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Kandang</th>
											<th>Periode</th>
											<th>Pakan</th>
											<th></th>

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
								<h3 id='tittle_table_detail_pemakaian_pakan' class="fw-bolder mb-1">Detail Pemakaian Pakan</h3>
								<!--<div class="fs-6 text-gray-400">Total $260,300 sepnt so far</div>-->
							</div>
							<!--begin::Card title-->
							<!--begin::Card toolbar-->
							<div class="card-toolbar my-1">
								<!--begin::Primary button-->
								<a class="btn btn-sm btn-primary" onclick="viewtabledetailpemakaianpakan()" id='button_viewtabledetailpemakaianpakan'>Load</a>
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
								<table id="exampletabledetailpemakaianpakan" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bolder">
									<thead class="fs-7 text-gray-400 text-uppercase">
										<tr>

											<th>Kandang</th>
											<th>Periode</th>
											<th>Tgl</th>
											<th>Pakan</th>
											<th>Qty</th>
											<th>Created_at</th>
											<th>Update_at</th>
											<th>Edit by</th>
											<th>number</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Kandang</th>
											<th>Periode</th>
											<th>Tgl</th>
											<th>Pakan</th>
											<th></th>
											<th>Created_at</th>
											<th>Update_at</th>
											<th>Edit by</th>
											<th>number</th>
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
								<h3 id='tittle_table_stock_pakan' class="fw-bolder mb-1">Stock Pakan</h3>
								<!--<div class="fs-6 text-gray-400">Total $260,300 sepnt so far</div>-->
							</div>
							<!--begin::Card title-->
							<!--begin::Card toolbar-->
							<div class="card-toolbar my-1">
								<!--begin::Primary button-->
								<a class="btn btn-sm btn-primary" onclick="viewtablestockpakan()" id='button_viewtablestockpakan'>Load</a>
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
								<div class='form-group row'>
									<div class="col-3">
										<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
											<div class="row">
												<div class="col-sm-7 fs-6 fw-bolder">Buffer Stock</div>
												<div class="col-sm-2 fw-bold fs-6 text-gray-400" id="buffer" style="text-align: end;">-</div>
												<div class="col-sm-3 fs-6 fw-bolder" style="text-align: end;">Hari</div>
											</div>
										</div>
									</div>
								</div>
								<div class='form-group row mt-5'>
									<div class="col-12">
										<table id="exampletablestockpakan" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bolder">
											<thead class="fs-7 text-gray-400 text-uppercase">
												<tr>
													<th>Nama Pakan</th>
													<th>Qty</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>Nama Pakan</th>
													<th></th>

												</tr>
											</tfoot>
										</table>
										<!--end::Table-->
									</div>
								</div>
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
								<h3 id='tittle_table_kedatangan_pakan' class="fw-bolder mb-1">Kedatangan Pakan</h3>
								<!--<div class="fs-6 text-gray-400">Total $260,300 sepnt so far</div>-->
							</div>
							<!--begin::Card title-->
							<!--begin::Card toolbar-->
							<div class="card-toolbar my-1">
								<!--begin::Primary button-->
								<a class="btn btn-sm btn-primary" onclick="viewtablekedatanganpakan()" id='button_viewtablekedatanganpakan'>Load</a>
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
								<table id="exampletablekedatanganpakan" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bolder">
									<thead class="fs-7 text-gray-400 text-uppercase">
										<tr>
											<th>Tanggal</th>
											<th>Pakan</th>
											<th>Qty</th>
											<th>Ket</th>
											<th>Option</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Tanggal</th>
											<th>Pakan</th>
											<th></th>
											<th>Ket</th>
											<th>Option</th>

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
								<h3 id='tittle_table_mutasi_pakan' class="fw-bolder mb-1">Mutasi Pakan</h3>
								<!--<div class="fs-6 text-gray-400">Total $260,300 sepnt so far</div>-->
							</div>
							<!--begin::Card title-->
							<!--begin::Card toolbar-->
							<div class="card-toolbar my-1">
								<!--begin::Primary button-->
								<a class="btn btn-sm btn-primary" onclick="viewtablemutasipakan()" id='button_viewtablemutasipakan'>Load</a>
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
								<table id="exampletablemutasipakan" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bolder">
									<thead class="fs-7 text-gray-400 text-uppercase">
										<tr>
											<th>Tanggal</th>
											<th>Pakan</th>
											<th></th>
											<th>Ket</th>
											<th>Option</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Tanggal</th>
											<th>Pakan</th>
											<th></th>
											<th>Ket</th>
											<th>Option</th>

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
					<!--begin::Products-->
					<div class="card card-flush">
						<!--begin::Card header-->
						<div class="card-header align-items-center py-5 gap-2 gap-md-5">
							<!--begin::Card title-->
							<div class="card-title">
								<!--begin::Title-->
								<h3>Add Pakan Form</h3>
								<!--end::Title-->
							</div>
							<!--end::Card title-->
						</div>
						<!--end::Card header-->
						<!--begin::Card body-->
						<div class="card-body pt-0">
							<!--begin::Form-->
							<!-- <form id="kt_ecommerce_settings_general_store" class="form" action="#"> -->
							<!--begin::Input group-->
							<div class="row fv-row mb-7">
								<div class="col-md-2">
									<!--begin::Label-->
									<label class="fs-6 fw-bold form-label mt-3">
										<!-- <span class="required">Add Medicine Form</span> -->
										<!-- <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Set the name of the store"></i> -->
										<span>Brand</span>
									</label>
									<!--end::Label-->
								</div>
								<div class="col-md-10">
									<!--begin::Input-->
									<input type="text" id="add_brand_pakan" class="form-control form-control-solid" name="store_name" value="" />
									<!--end::Input-->
								</div>
							</div>
							<!--end::Input group-->
							<!--begin::Action buttons-->
							<div class="row">
								<div class="col-md-10 offset-md-2">
									<!--begin::Separator-->
									<div class="separator mb-6"></div>
									<!--end::Separator-->
									<div class="d-flex justify-content-end">
										<!--begin::Button-->
										<!-- <button type="reset" data-kt-ecommerce-settings-type="cancel" class="btn btn-light me-3">Cancel</button> -->
										<!--end::Button-->
										<!--begin::Button-->
										<button type="button" id='add_pakan_button' onclick="add_pakan()" class="btn btn-primary">
											<span id='add_pakan_label' class="indicator-label">Save</span>
										</button>
										<!--end::Button-->
									</div>
								</div>
							</div>
							<!--end::Action buttons-->
							<!-- </form> -->
							<!--end::Form-->
						</div>
						<!--end::Card body-->
					</div>
					<!--end::Products-->
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
								<h3 id='tittle_table_jenis_pakan' class="fw-bolder mb-1">Jenis Pakan</h3>
								<!--<div class="fs-6 text-gray-400">Total $260,300 sepnt so far</div>-->
							</div>
							<!--begin::Card title-->
							<!--begin::Card toolbar-->
							<div class="card-toolbar my-1">
								<!--begin::Primary button-->
								<a class="btn btn-sm btn-primary" onclick="viewtablejenispakan()" id='button_viewtablejenispakan'>Load</a>
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
								<table id="exampletablejenispakan" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bolder">
									<thead class="fs-7 text-gray-400 text-uppercase">
										<tr>
											<th>Brand</th>
											<th>Option</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Brand</th>
											<th>Option</th>
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