<div id="kt_ews" class="tab-pane fade show">
    <!--begin::Row-->
    <div class="row g-6 g-xl-9">
        <!--begin::Col-->
        <div class="col-lg-6">
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header mt-6">
                    <!--begin::Card title-->
                    <div class="card-title flex-column">
                        <h3 class="fw-bolder mb-1">EWS Kematian</h3>
                        <div class="fs-6 text-gray-400">Data EWS Kematian</div>
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <div id="buttonewskematian"></div>
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!--begin::Table-->
                    <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <!--begin::Table container-->
                        <div class="table-responsive">
                            <div class="card-body py-4">
                                <div class="table-responsive">
                                    <table id="tabledataewskematian" class="table align-middle gs-0 gy-5">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Umur</th>
                                                <th>Nilai</th>
                                                <th>Ket</th>
                                                <th>Option</th>
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
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-lg-6">
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header mt-6">
                    <div class="card-title flex-column">
                        <h3 class="fw-bolder mb-1">EWS BW</h3>
                        <div class="fs-6 fw-bold text-gray-400">Data EWS BW</div>
                    </div>
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <div id="buttonewsbw"></div>
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!--begin::Table-->
                    <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <!--begin::Table container-->
                        <div class="table-responsive">
                            <div class="card-body py-4">
                                <div class="table-responsive">
                                    <table id="tabledataewsbw" class="table align-middle gs-0 gy-5">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Umur</th>
                                                <th>Nilai</th>
                                                <th>Ket</th>
                                                <th>Option</th>
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
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
        </div>
        <!--end::Col-->

    </div>
    <!--end::Row-->
</div>
<?php $this->load->view('main/_partials/modal/ews'); ?>