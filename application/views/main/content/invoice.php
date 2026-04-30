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
                                <h3 id='tittle_table_warning' class="fw-bolder mb-1">Tabel Invoice</h3>
                                <!--<div class="fs-6 text-gray-400">Total $260,300 sepnt so far</div>-->
                            </div>
                            <!--begin::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar my-1">
                            </div>
                            <!--begin::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Table container-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table id="exampletablechickin" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bolder">
                                    <!--begin::Head-->
                                    <thead class="fs-7 text-gray-400 text-uppercase">
                                        <tr>
                                            <th>Kandang</th>
                                            <th>Tgl Chickin</th>
                                            <th>Populasi</th>
                                            <th>Periode</th>
                                            <th>Lokasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (is_array($getdata) || is_object($getdata)) {
                                            foreach ($getdata as $getdatas) {
                                        ?>
                                                <tr>
                                                    <th><?= $getdatas->kandang ?></th>
                                                    <th><?= $getdatas->tgl_chickin ?></th>
                                                    <th><?= $getdatas->populasi ?></th>
                                                    <th><?= $getdatas->periode ?></th>
                                                    <th><?= $getdatas->lokasi ?></th>
                                                </tr>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <th><?= "-" ?></th>
                                                <th><?= "-" ?></th>
                                                <th><?= "-" ?></th>
                                                <th><?= "-" ?></th>
                                                <th><?= "-" ?></th>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Kandang</th>
                                            <th>Tgl Chickin</th>
                                            <th>Populasi</th>
                                            <th>Periode</th>
                                            <th>Lokasi</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table container-->
                        </div>
                        <!--end::Card body-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Table container-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table id="exampletableinternal" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bolder">
                                    <!--begin::Head-->
                                    <thead class="fs-7 text-gray-400 text-uppercase">
                                        <tr>
                                            <th>Kandang</th>
                                            <th>Tgl Chickin</th>
                                            <th>Populasi</th>
                                            <th>Periode</th>
                                            <th>Lokasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (is_array($getdata_internal) || is_object($getdata_internal)) {
                                            foreach ($getdata_internal as $getdata_internals) {
                                        ?>
                                                <tr>
                                                    <th><?= $getdata_internals->kandang ?></th>
                                                    <th><?= $getdata_internals->tgl_chickin ?></th>
                                                    <th><?= $getdata_internals->populasi ?></th>
                                                    <th><?= $getdata_internals->periode ?></th>
                                                    <th><?= $getdata_internals->lokasi ?></th>
                                                </tr>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <th><?= "-" ?></th>
                                                <th><?= "-" ?></th>
                                                <th><?= "-" ?></th>
                                                <th><?= "-" ?></th>
                                                <th><?= "-" ?></th>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Kandang</th>
                                            <th>Tgl Chickin</th>
                                            <th>Populasi</th>
                                            <th>Periode</th>
                                            <th>Lokasi</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table container-->
                        </div>
                        <!--end::Card body-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Table container-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table id="exampletablebreeding" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bolder">
                                    <!--begin::Head-->
                                    <thead class="fs-7 text-gray-400 text-uppercase">
                                        <tr>
                                            <th>Lokasi</th>
                                            <th>Kandang</th>
                                            <th>Total</th>
                                            <th>Tgl</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // var_dump($getdata_breeding);
                                        if (is_array($getdata_breeding) || is_object($getdata_breeding)) {
                                            foreach ($getdata_breeding as $getdata_breedings) {
                                        ?>
                                                <tr>
                                                    <th><?= $getdata_breedings['lokasi'] ?></th>
                                                    <th><?= $getdata_breedings['kandang'] ?></th>
                                                    <th><?= $getdata_breedings['total'] ?></th>
                                                    <th><?= $getdata_breedings['tgl'] ?></th>
                                                </tr>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <th><?= "-" ?></th>
                                                <th><?= "-" ?></th>
                                                <th><?= "-" ?></th>
                                                <th><?= "-" ?></th>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Lokasi</th>
                                            <th>Kandang</th>
                                            <th>Total</th>
                                            <th>Tgl</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table container-->
                        </div>
                        <!--end::Card body-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Table container-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table id="exampletablebreedingmanado" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bolder">
                                    <!--begin::Head-->
                                    <thead class="fs-7 text-gray-400 text-uppercase">
                                        <tr>
                                            <th>Lokasi</th>
                                            <th>Kandang</th>
                                            <th>Total</th>
                                            <th>Tgl</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // var_dump($getdata_breeding);
                                        if (is_array($getdata_breeding_manado) || is_object($getdata_breeding_manado)) {
                                            foreach ($getdata_breeding_manado as $getdata_breeding_manados) {
                                        ?>
                                                <tr>
                                                    <th><?= $getdata_breeding_manados['lokasi'] ?></th>
                                                    <th><?= $getdata_breeding_manados['kandang'] ?></th>
                                                    <th><?= $getdata_breeding_manados['total'] ?></th>
                                                    <th><?= $getdata_breeding_manados['tgl'] ?></th>
                                                </tr>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <th><?= "-" ?></th>
                                                <th><?= "-" ?></th>
                                                <th><?= "-" ?></th>
                                                <th><?= "-" ?></th>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Lokasi</th>
                                            <th>Kandang</th>
                                            <th>Total</th>
                                            <th>Tgl</th>
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