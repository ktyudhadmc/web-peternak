
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
                <h3 id='tittle_table_pemakaian_ovk' class="fw-bolder mb-1">Tabel <?= $title ?></h3>
                <!--<div class="fs-6 text-gray-400">Total $260,300 sepnt so far</div>-->
              </div>
              <!--begin::Card title-->
              <!--begin::Card toolbar-->
              <div class="card-toolbar my-1">
                <div class='row'>
                  <div class="col-12">
                    <!--begin::Primary button-->

                    <a href="#" onclick="view_modal_add_navbar()" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add_navbar">Add Navbar</a>
                    <!--end::Primary button-->
                  </div>
                </div>
              </div>
              <!--begin::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
              <div class='form-group row mt-5'>
								<div class="col-4">
									<h4 class="fw-bolder mb-1">Pilih Role</h4>
								</div>
								<div class="col-8">
									<select name="" id="filter_role" class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Month">
										<?php

										if (is_array($datarole) || is_object($datarole)) {
											echo "<option value='0' data-1='-' data-2='-' data-3='-'>Pilih Role</option>";
											foreach ($datarole as $dataroles) {
												echo "<option value='{$dataroles->id}' data-1='{$dataroles->role_nm}' data-2='{$dataroles->id}' data-3='{$dataroles->id}'>{$dataroles->role_nm}</option>";
											}
										}else{
											echo "<option value='-' data-1='-' data-2='-' data-3='-'>Tidak ada data</option>";
										}

										?>
									</select>
									<!--<input type="text" class="form-control form-control-solid" placeholder="" name="card_name" value="Max Doe">-->
								</div>
							</div>
              <div class='form-group row mt-5'>
								<div class="col-4">
									<a  class="btn btn-sm btn-primary" onclick="viewtablerole()" id='button_viewtablerole'>Load</a>
								</div>
								<div class="col-8">

								</div>
							</div>
              <!--begin::Table container-->
              <div class="table-responsive mt-5">
                <!--begin::Table-->
                <table id="exampletablerole" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bolder">
                  <!--begin::Head-->
                  <thead class="fs-7 text-gray-400 text-uppercase">
                    <tr>
                      <th>Role</th>
                      <th>Navbar</th>
                      <th>Master</th>
                      <th>Master id</th>
                      <th>Status</th>
                      <th>Is Developt</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Role</th>
                      <th>Navbar</th>
                      <th>Master</th>
                      <th>Master id</th>
                      <th>Status</th>
                      <th>Is Developt</th>
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
                <h3 id='tittle_table_navbar' class="fw-bolder mb-1">Tabel Navbar</h3>
                <!--<div class="fs-6 text-gray-400">Total $260,300 sepnt so far</div>-->
              </div>
              <!--begin::Card title-->
              <!--begin::Card toolbar-->
              <div class="card-toolbar my-1">
                <div class='row'>
                  <div class="col-12">
                    <!--begin::Primary button-->

                    <!-- <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add_navbar">Add Navbar</a> -->
                    <!--end::Primary button-->
                  </div>
                </div>
              </div>
              <!--begin::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
              <div class='form-group row mt-5'>
                <div class="col-4">
                  <a  class="btn btn-sm btn-primary" onclick="viewtablenavbar()" id='button_viewtablenavbar'>Load</a>
                </div>
                <div class="col-8">

                </div>
              </div>
              <!--begin::Table container-->
              <div class="table-responsive mt-5">
                <!--begin::Table-->
                <table id="exampletablenavbar" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bolder">
                  <!--begin::Head-->
                  <thead class="fs-7 text-gray-400 text-uppercase">
                    <tr>
                      <th>Main</th>
                      <th>Name</th>
                      <th>Master</th>
                      <th>Master id</th>
                      <th>Variable</th>
                      <th>link</th>
                      <th>icon</th>
                      <th>Is Developt</th>
                      <th>Option</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Main</th>
                      <th>Name</th>
                      <th>Master</th>
                      <th>Master id</th>
                      <th>Variable</th>
                      <th>link</th>
                      <th>icon</th>
                      <th>Is Developt</th>
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
