<div id="kt_fcr" class="tab-pane fade show">
    <div class="row g-6 g-xl-9">
        <!--begin::Col-->
        <div class="col-lg-12">
            <!--begin::Graph-->
            <div class="card card-flush h-lg-100">
                <!--begin::Card header-->
                <div class="card-header mt-6">
                    <!--begin::Card title-->
                    <div class="card-title flex-column">
                        <h3 class="fw-bolder mb-1">Chart FCR</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-10 pb-0 px-5">
                    <!--begin::Chart-->
                    <div id="kt_fcrchart" class="card-rounded-bottom" style="height: 300px"></div>
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

                    <!-- <table id="kt_profile_overview_table" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bolder">
                        
                        <thead class="fs-7 text-gray-400 text-uppercase">
                            <tr>
                                <th class="min-w-250px">Tanggal</th>
                                <th class="min-w-150px">Umur</th>
                                <th class="min-w-90px">Aktual</th>
                                <th class="min-w-90px">Standart</th>
                                <th class="min-w-50px">Indikasi</th>
                            </tr>
                        </thead>
                       
                        <tbody class="fs-6 text-gray-400 text-uppercase">
                            <?php
                            $std = 0;
                            $last_fcr = 0;
                            if (is_array($data_harian) || is_object($data_harian)) {
                                $tgl_fcr = "-";
                                $umur_fcr = "-";
                                $fcr_fcr = "-";
                                $std_fcr = "-";
                                foreach ($data_harian as $data_harians) {
                                    if ($std_fcr > $std_fcr) {
                                        $indikator = " <span class='badge badge-light-danger fw-bolder px-4 py-3'><i class='fas fa-chevron-down'></i></span>";
                                    } elseif ($std_fcr < $std_fcr) {
                                        $indikator = "<span class='badge badge-light-success fw-bolder px-4 py-3'><i class='fas fa-chevron-up'></i></span>";
                                    } else {
                                        $indikator = "<span class='badge badge-light-primary fw-bolder px-4 py-3'><i class='fas fa-minus'></i></span>";
                                    }

                                    if ($tgl_fcr != "-") {
                            ?>
                                        <tr>
                                            <td><?= $tgl_fcr ?></td>
                                            <td><?= $umur_fcr ?></td>
                                            <td><?= $fcr_fcr ?></td>
                                            <td><?= $std_fcr ?></td>
                                            <td><?= $indikator ?></td>
                                        </tr>
                                <?php
                                    }

                                    $tgl_fcr = date('d M Y', strtotime($data_harians->tanggal));
                                    $umur_fcr = $data_harians->umur;
                                    $fcr_fcr = $data_harians->act_fcr;
                                    $std_fcr = $data_harians->std_fcr;
                                    $last_fcr = $data_harians->act_fcr;
                                }
                                ?>
                                <tr>
                                    <td><?= $tgl_fcr ?></td>
                                    <td><?= $umur_fcr ?></td>
                                    <td><?= $fcr_fcr ?></td>
                                    <td><?= $std_fcr ?></td>
                                    <td><span class='badge badge-light-primary fw-bolder px-4 py-3'><i class='fas fa-minus'></i></span></td>
                                </tr>
                            <?php
                            } else {
                                echo "<p style='font-size:10px;color:red'>Tidak Ada Data</p>";
                            }
                            ?>
                        </tbody>
                    </table>
                    -->
                    <div class="card-body py-4">
                        <div class="table-responsive">
                            <table id="tablefcr" class="table align-middle gs-0 gy-5">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Umur</th>
                                        <th>Act</th>
                                        <th>Std</th>
                                        <th>Diff</th>
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

            </div>

        </div>
        <!--end::Card-->
    </div>
</div>