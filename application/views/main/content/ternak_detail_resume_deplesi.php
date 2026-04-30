<div id="kt_deplesi" class="tab-pane fade show">
    <div class="row g-6 g-xl-9">
        <!--begin::Col-->
        <div class="col-lg-12">
            <!--begin::Graph-->
            <div class="card card-flush h-lg-100">
                <!--begin::Card header-->
                <div class="card-header mt-6">
                    <!--begin::Card title-->
                    <div class="card-title flex-column">
                        <h3 class="fw-bolder mb-1">Chart Deplesi</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-10 pb-0 px-5">
                    <!--begin::Chart-->
                    <div id="kt_deplesichart" class="card-rounded-bottom" style="height: 300px"></div>
                    <!--end::Chart-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Graph-->
        </div>
        <!--begin::Table-->
        <div class="card card-flush mt-6 mt-xl-9">
            <!--begin::Card header-->
            <div class="card-header mt-5">
                <!--begin::Card title-->
                <div class="card-title flex-column">
                    <h3 class="fw-bolder mb-1">Tabel FCR</h3>
                    <!-- <div class="fs-6 text-gray-400">List tabel FCR dari chart diatas</div> -->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar my-1">
                    <!--begin::Select-->
                    <div class="me-4 my-1">
                        <!-- <a href="https://peternak.id/export/data/fcr/<?= $idkandang ?>/<?= $periode_byid ?>" class="btn btn-sm btn-primary me-3"> <i class="fas fa-download"></i> Export FCR</a> -->
                    </div>
                    <!--end::Select-->

                </div>
                <!--begin::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table container-->
                <div class="table-responsive">
                    <div class="card-body py-4">
                        <div class="table-responsive">
                            <table id="tabledeplesi" class="table align-middle gs-0 gy-5">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Umur</th>
                                        <th>Mati</th>
                                        <th>Culling</th>
                                        <th>Tot Deplesi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <!--end::Table container-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
</div>