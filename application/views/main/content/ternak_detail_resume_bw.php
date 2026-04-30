<div id="kt_bw" class="tab-pane fade show active">
    <div class="row g-6 g-xl-9">
        <!--begin::Col-->
        <div class="col-lg-12">
            <!--begin::Graph-->
            <div class="card card-flush h-lg-100">
                <!--begin::Card header-->
                <div class="card-header mt-6">
                    <div class="card-title flex-column">
                        <h3 class="fw-bolder mb-1">Chart BW</h3>
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-10 pb-0 px-5">
                    <!--begin::Chart-->
                    <div id="kt_bwchart" style="height: 350px; min-height: 365px;"></div>
                    <!-- <div id="kt_project_overview_graph" class="card-rounded-bottom" style="height: 300px"></div> -->
                    <!--end::Chart-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Graph-->
        </div>
    </div>
    <div class="pt-4"></div>
    <div class="row g-6 g-xl-9">
        <div class="col-lg-12">
            <div class="card card-flush h-lg-100">
                <!--begin::Card header-->
                <div class="card-header mt-5">
                    <div class="card-title flex-column">
                        <h3 class="fw-bolder mb-1">Tabel BW</h3>
                        <!-- <div class="fs-6 text-gray-400">List tabel bw dari chart diatas</div> -->
                    </div>
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar my-1">
                        <!--begin::Select-->
                        <div class="me-4 my-1">
                            <!-- <a href="https://peternak.id/export/data/bw/<?= $idkandang ?>/<?= $periode_byid ?>" class="btn btn-sm btn-primary me-3"> <i class="fas fa-download"></i> Export BW</a> -->
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
                           
                            <thead class="fs-7 text-dark-400 text-uppercase">
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
                                $last_bw = 0;
                                if (is_array($data_harian) || is_object($data_harian)) {
                                    $tgl_bw = "-";
                                    $umur_bw = "-";
                                    $bw_bw = "-";
                                    $std_bw = "-";
                                    foreach ($data_harian as $data_harians) {
                                        if ($std_bw > $data_harians->bw) {
                                            $indikator = " <span class='badge badge-light-danger fw-bolder px-4 py-3'><i class='fas fa-chevron-down'></i></span>";
                                        } elseif ($std_bw < $data_harians->bw) {
                                            $indikator = "<span class='badge badge-light-success fw-bolder px-4 py-3'><i class='fas fa-chevron-up'></i></span>";
                                        } else {
                                            $indikator = "<span class='badge badge-light-primary fw-bolder px-4 py-3'><i class='fas fa-minus'></i></span>";
                                        }

                                        if ($tgl_bw != "-") {
                                ?>
                                            <tr>
                                                <td><?= $tgl_bw ?></td>
                                                <td><?= $umur_bw ?></td>
                                                <td><?= $bw_bw ?></td>
                                                <td><?= $std_bw ?></td>
                                                <td><?= $indikator ?></td>
                                            </tr>
                                    <?php
                                        }

                                        $last_bw = $data_harians->bw;
                                        $tgl_bw = date('d M Y', strtotime($data_harians->tanggal));
                                        $umur_bw = $data_harians->umur;
                                        $bw_bw = $data_harians->bw;
                                        $std_bw = $data_harians->std_bw;
                                    }
                                    ?>
                                    <tr>
                                        <td><?= $tgl_bw ?></td>
                                        <td><?= $umur_bw ?></td>
                                        <td><?= $bw_bw ?></td>
                                        <td><?= $std_bw ?></td>
                                        <td><span class='badge badge-light-primary fw-bolder px-4 py-3'><i class='fas fa-minus'></i></span></td>
                                    </tr>
                                <?php
                                } else {
                                    echo "<p style='font-size:10px;color:red'>Tidak Ada Data</p>";
                                }
                                ?>
                            </tbody>
                           
                        </table> -->
                        <div class="card-body py-4">
                            <div class="table-responsive">
                                <table id="tablebw" class="table align-middle gs-0 gy-5">
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
                    <!--end::Table container-->
                </div>
                <!--end::Card body-->
            </div>
        </div>
    </div>
</div>