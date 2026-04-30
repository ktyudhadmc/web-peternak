<style>
    .dataTables_wrapper {
        /*font-family: tahoma;*/
        font-size: 10px;
        /*position: relative;*/
        /*clear: both;*/
        /**zoom: 1;*/
        /*zoom: 1;*/
    }

    table.dataTable thead .sorting,
    table.dataTable thead .sorting_asc,
    table.dataTable thead .sorting_desc {
        background: none;
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
                        <div class="card-body pt-0 mt-15">
                            <div class='form-group row'>
                                <div class="form-group col-2 align-items-center">
                                    <h4 class="fw-bolder mb-1" style="margin-top: 10px;">Pilih Lokasi</h4>
                                </div>
                                <div class="form-group col-6">
                                    <select name="lokasi" id="filter_lokasi" class="form-select form-select-solid" data-control="select2" multiple="multiple" data-hide-search="true" data-placeholder="Pilih Lokasi">
                                        <?php
                                        if (is_array($getdatauser) || is_object($getdatauser)) {
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
                                <div class="form-group col-4" style="text-align: right;">
                                    <a class="btn btn-primary" onclick="viewtablekandangprofil()" id='button_viewtablekandangprofil'>Load</a>
                                    <a class="btn btn-primary" onclick="selectall('filter_lokasi')" id='selectall'>Select All</a>
                                    <a class="btn btn-primary" onclick="addprofil()" id='button_addprofil'>Add Profil</a>
                                </div>
                            </div>
                        </div>
                        <!--end::Card body-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Table container-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table id="exampletablekandangprofil" class="table table-row-bordered table-row-dashed gy-4 align-middle table-striped">
                                    <!--begin::Head-->
                                    <thead class="fs-7 text-black-400 text-uppercase fw-bolder dt-center">
                                        <tr>
                                            <th style="font-size: 8px;">View</th>
                                            <th style="font-size: 8px;">Kandang</th>
                                            <th style="font-size: 8px;">Panjang</th>
                                            <th style="font-size: 8px;">Lebar</th>
                                            <th style="font-size: 8px;">Tinggi</th>
                                            <th style="font-size: 8px;">Kipas</th>
                                            <th style="font-size: 8px;">CoolingPad</th>
                                            <th style="font-size: 8px;">Tiggi CP</th>
                                            <th style="font-size: 8px;">Pakan</th>
                                            <th style="font-size: 8px;">Feed Tray</th>
                                            <th style="font-size: 8px;">Minum</th>
                                            <th style="font-size: 8px;">Heater</th>
                                            <th style="font-size: 8px;">Volume</th>
                                            <th style="font-size: 8px;">Uk. Kipas</th>
                                            <th style="font-size: 8px;">Merk Kipas</th>
                                            <th style="font-size: 8px;">Luas Inlet</th>
                                            <th style="font-size: 8px;">Pan Feeder</th>
                                            <th style="font-size: 8px;">Nipple</th>
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