<div id="kt_nekropsi" class="tab-pane fade show">
    <!--begin::Row-->
    <?php
    if (is_array($nekropsidata)) {
        foreach ($nekropsidata as $nekropsidatas) {
            $datanya = json_decode($nekropsidatas->nekropsi_data, true);
            $fotonya = json_decode($nekropsidatas->foto, true);
    ?>
            <div class="card direction-rtl">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <p style="font-size:14px" class="text-dark"><strong><?= date('d M Y', strtotime($nekropsidatas->tanggal)) ?></strong></p>
                        </div>
                    </div>
                    <div class="row">
                        <!-- <div class="gallery-img" id="filterContainer"> -->
                        <?php
                        if (is_array($fotonya)) {
                            foreach ($fotonya as $fotonyas) {
                                echo "<div class='col-6 col-sm-4 col-md-3 mb-2'>";
                                echo "
                 <!--<a class='single-gallery-item' href='" . base_url($fotonyas) . "'><img src='" . base_url($fotonyas) . "' alt='' width='200px'></a>-->
                  <a href='#'><img src='" . $this->config->item('app_url') . $fotonyas . "' alt='' width='200px'>
                  ";
                                echo "</div>";
                            }
                        }
                        ?>
                        <!-- </div> -->
                    </div>
                    <div class="pt-3"></div>
                    <?php
                    if (is_array($datanya)) {
                        foreach ($datanya as $idatanyas => $datanyas) {
                    ?>
                            <div class="row border-bottom">
                                <div class="col-12 text-start">
                                    <p style="font-size:14px;color:black"><strong><?= strtoupper($idatanyas) ?></strong></p>
                                    <?php
                                    if (is_array($datanyas)) {
                                        foreach ($datanyas as $idn => $vdn) {
                                    ?>
                                            <div class="row">
                                                <div class="col-6">
                                                    <p style="font-size:12px;color:black"><?= ucwords(str_replace("_", " ", $idn)) ?> </p>
                                                </div>
                                                <div class="col-6 text-end">
                                            <?php
                                            if (is_array($vdn)) {
                                                echo '<p style="font-size:9px;color:black">' . ucwords(implode(", ", str_replace("_", " ", $vdn))) . "</p>";
                                            } else {
                                                echo $vdn;
                                            }
                                            echo "</div></div>";
                                        }
                                    }
                                            ?>
                                                </div>
                                            </div>
                                            <br>
                                    <?php }
                            } ?>
                                    <div class="row border-bottom">
                                        <div class="col-12 text-start">
                                            <p style="font-size:14px;color:black"><strong>Catatan</strong></p>
                                            <div class="row">
                                                <div class="col-12 text-start">
                                                    <p style="font-size:14px;color:black"><?= $nekropsidatas->catatan ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pt-3"></div>
                                    <div class="row">
                                        <div class="col-10 text-end">
                                        </div>
                                        <div class="col-2 text-end">
                                            <div class="form-group">
                                                <a href="<?= base_url("nekropsi/nekropsi_input/{$idkandang}/{$periode}/{$nekropsidatas->id}") ?>" type="button" class="btn btn-sm btn-danger" onclick="return confirm('Hapus nekropsi?')"><i class="fas fa-trash"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-3"></div>
                        <?php }
                } else {
                        ?>
                        <div class="row g-6 g-xl-9">
                            <div class="col-lg-12">
                                <div class="card card-flush h-lg-100" style="align-items: center;padding-bottom: 50px;">
                                    <img src="<?= base_url() ?>assets/main/media/illustrations/sketchy-1/4.png" style="width: 30%;padding-bottom: 50px;" />
                                    <h3 class="fw-bolder mb-1">Data Belum Bisa Ditampilkan</h3>
                                    <div class="fs-6 text-gray-400" id="nomordo">Tidak ada data</div>
                                </div>
                            </div>
                        </div>
                    <?php
                    // echo "<br /><center><img width='200px' src='" . base_url("assets/resource/icon/emptydata.svg") . "'><br /><br /><p class='needfontsize text-dark'>Tidak ada data</p></center>";
                } ?>


                    <!-- <div class="row g-6 g-xl-9">
                        <div class="col-lg-12">
                            <div class="card card-flush h-lg-100" style="align-items: center;padding-bottom: 50px;">
                                <img src="<?= base_url() ?>assets/main/media/illustrations/sketchy-1/4.png" style="width: 30%;padding-bottom: 50px;" />
                                <h3 class="fw-bolder mb-1">Sedang Dalam Perbaikan</h3>
                                <div class="fs-6 text-gray-400" id="nomordo">Test Halaman Belum Tersedia</div>
                            </div>
                        </div>
                    </div> -->
                    <!--end::Row-->
                </div>