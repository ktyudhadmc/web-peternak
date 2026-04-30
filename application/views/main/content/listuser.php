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
                    <a class="btn btn-sm btn-primary" onclick="viewtablelistuser()" id='button_viewtablelistuser'>Load</a>
                    <a href="#" onclick="select_role(`#add_user_role`)" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add_user">Add User</a>
                    <!--end::Primary button-->
                  </div>
                </div>
              </div>
              <!--begin::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
              <!--begin::Table container-->
              <div class="table-responsive">
                <!--begin::Table-->
                <table id="exampletablelistuser" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bolder">
                  <!--begin::Head-->
                  <thead class="fs-7 text-gray-400 text-uppercase">
                    <tr>
                      <th>ID User</th>
                      <th>Nama</th>
                      <th>No HP</th>
                      <th>Role</th>
                      <th>Member</th>
                      <th>Status</th>
                      <th>Banned</th>
                      <th>Last Log in</th>
                      <th>Option</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>ID User</th>
                      <th>Nama</th>
                      <th>No HP</th>
                      <th>Role</th>
                      <th>Member</th>
                      <th>Status</th>
                      <th>Banned</th>
                      <th>Last Log in</th>
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
                <h3 id='tittle_table_akses_user' class="fw-bolder mb-1">Tabel Akses Kandang</h3>
                <!--<div class="fs-6 text-gray-400">Total $260,300 sepnt so far</div>-->
              </div>
              <!--begin::Card title-->
              <!--begin::Card toolbar-->
              <div class="card-toolbar my-1">
                <div class='row'>
                  <div class="col-12">
                    <!--begin::Primary button-->
                    <a class="btn btn-sm btn-primary" onclick="viewtableaksesuser()" id='button_viewtableaksesuser'>Load</a>
                    <!--end::Primary button-->
                  </div>
                </div>
              </div>
              <!--begin::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
              <!--begin::Table container-->
              <div class="table-responsive">
                <!--begin::Table-->
                <table id="exampletableaksesuser" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bolder">
                  <!--begin::Head-->
                  <thead class="fs-7 text-gray-400 text-uppercase">
                    <tr>
                      <th>ID user</th>
                      <th>Nama</th>
                      <th>Kandang</th>
                      <th>Lokasi</th>
                      <th>Option</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>ID user</th>
                      <th>Nama</th>
                      <th>Kandang</th>
                      <th>Lokasi</th>
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
                <h3 id='tittle_table_akses_user' class="fw-bolder mb-1">Tabel Notif WA Number</h3>
                <!--<div class="fs-6 text-gray-400">Total $260,300 sepnt so far</div>-->
              </div>
              <!--begin::Card title-->
              <!--begin::Card toolbar-->
              <div class="card-toolbar my-1">
                <div class='row'>
                  <div class="col-12">
                    <!--begin::Primary button-->
                    <a class="btn btn-sm btn-primary" onclick="viewtablenotifwanumber()" id='button_viewtablenotifwanumber'>Load</a>
                    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add_number_notif">Add Number Notif</a>
                    <!--end::Primary button-->
                  </div>
                </div>
              </div>
              <!--begin::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
              <!--begin::Table container-->
              <div class="table-responsive">
                <!--begin::Table-->
                <table id="exampletablenotifwanumber" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bolder">
                  <!--begin::Head-->
                  <thead class="fs-7 text-gray-400 text-uppercase">
                    <tr>
                      <th>Lokasi</th>
                      <th>Type Number</th>
                      <th>Nama</th>
                      <th>Number</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Lokasi</th>
                      <th>Type Number</th>
                      <th>Nama</th>
                      <th>Number</th>
                      <th>Status</th>
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