function calculate() {
  var id_user = $("#filter_lokasi").val();
  var status = $("#status").val();
  var tahun_mulai = $("#tahun_mulai").val();
  var tahun_akhir = $("#tahun_akhir").val();
  var parsedata;

  if (id_user == "") {
    set_flashdata('error', 'Harap Pilih Lokasi Kandang');
    return;
  }
  if (status == 0) {
    set_flashdata('error', 'Harap Pilih Status Kandang');
    return;
  }
  if (tahun_mulai == 0) {
    set_flashdata('error', 'Harap Pilih Tahun Mulai');
    return;
  }
  if (tahun_akhir == 0) {
    set_flashdata('error', 'Harap Pilih Tahun Akhir');
    return;
  }
  if (tahun_akhir < tahun_mulai) {
    set_flashdata('error', 'Tahun Mulai Lebih Kecil Dari Tahun Akhir');
    return;
  }

  $.ajax({
    'type': "POST",
    'url': base_url + 'main/fcr/calculate',
    'data': {
      id: id_user,
      status: status,
      tahun_mulai: tahun_mulai,
      tahun_akhir: tahun_akhir,
    },
    'cache': false,
    'beforeSend': function () {
      $("#button_calculate").prop('disabled', true); // disable button
      $('#button_calculate').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading... ');

    },
    'success': function (data) {
      if (data === 'data tidak ditemukan') {
        set_flashdata('error', 'Data Tidak Ditemukan');
      } else if (data === 'salah pilih tahun') {
        set_flashdata('error', 'salah pilih tahun');
      } else {
        set_flashdata('success', 'Proses kalkulasi berhasil');
        parsedata = JSON.parse(data);
        let htmlContent = "";
        parsedata.forEach(item => {
          htmlContent += `
              <div class="card card-flush mt-5">
                  <div class="card-header mt-5">
                      <div class="card-title flex-column">
                          <h3 class="fw-bolder mb-1">${item.lokasi}</h3> 
                      </div>
                      <div class="card-body pt-0">
                      <div class='form-group row'>
                        <div class="col-2">
                          <div class="d-flex flex-stack">
                            <div class="d-flex align-items-center me-5">
                              <div class="symbol symbol-40px me-4">
                                <span class="symbol-label">
                                  <i class="fonticon-truck fs-1 p-0 text-gray-600"></i>
                                </span>
                              </div>
                              <div class="me-5">
                                <a href="#" class="text-gray-800 fw-bolder text-hover-primary fs-6">Strain</a>
                                <span id="strain" class="text-gray-400 fw-bold fs-7 d-block text-start ps-0">${item.summary.strain}</span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-2">
                          <div class="d-flex flex-stack">
                            <div class="d-flex align-items-center me-5">
                              <div class="symbol symbol-40px me-4">
                                <span class="symbol-label">
                                  <i class="fonticon-truck fs-1 p-0 text-gray-600"></i>
                                </span>
                              </div>
                              <div class="me-5">
                                <a href="#" class="text-gray-800 fw-bolder text-hover-primary fs-6">BW</a>
                                <span id="bw" class="text-gray-400 fw-bold fs-7 d-block text-start ps-0">${item.summary.bw} Gram</span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-2">
                          <div class="d-flex flex-stack">
                            <div class="d-flex align-items-center me-5">
                              <div class="symbol symbol-40px me-4">
                                <span class="symbol-label">
                                  <i class="fonticon-truck fs-1 p-0 text-gray-600"></i>
                                </span>
                              </div>
                              <div class="me-5">
                                <a href="#" class="text-gray-800 fw-bolder text-hover-primary fs-6">FCR Act</a>
                                <span id="fcr_act" class="text-gray-400 fw-bold fs-7 d-block text-start ps-0">${item.summary.fcr_act}</span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-2">
                          <div class="d-flex flex-stack">
                            <div class="d-flex align-items-center me-5">
                              <div class="symbol symbol-40px me-4">
                                <span class="symbol-label">
                                  <i class="fonticon-truck fs-1 p-0 text-gray-600"></i>
                                </span>
                              </div>
                              <div class="me-5">
                                <a href="#" class="text-gray-800 fw-bolder text-hover-primary fs-6">FCR Std</a>
                                <span id="fcr_std" class="text-gray-400 fw-bold fs-7 d-block text-start ps-0">${item.summary.fcr_std}</span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-2">
                          <div class="d-flex flex-stack">
                            <div class="d-flex align-items-center me-5">
                              <div class="symbol symbol-40px me-4">
                                <span class="symbol-label">
                                  <i class="fonticon-truck fs-1 p-0 text-gray-600"></i>
                                </span>
                              </div>
                              <div class="me-5">
                                <a href="#" class="text-gray-800 fw-bolder text-hover-primary fs-6">Diff FCR</a>
                                <span id="diff_fcr" class="text-gray-400 fw-bold fs-7 d-block text-start ps-0">${item.summary.diff_fcr}</span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-2">
                          <div class="d-flex flex-stack">
                            <div class="d-flex align-items-center me-5">
                              <div class="symbol symbol-40px me-4">
                                <span class="symbol-label">
                                  <i class="fonticon-truck fs-1 p-0 text-gray-600"></i>
                                </span>
                              </div>
                              <div class="me-5">
                                <a href="#" class="text-gray-800 fw-bolder text-hover-primary fs-6">Tot Populasi</a>
                                <span id="populasi" class="text-gray-400 fw-bold fs-7 d-block text-start ps-0">${item.summary.populasi} Ekor</span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class='form-group row mt-5'>
                        <div class="col-2">
                          <div class="d-flex flex-stack">
                            <div class="d-flex align-items-center me-5">
                              <div class="symbol symbol-40px me-4">
                                <span class="symbol-label">
                                  <i class="fonticon-truck fs-1 p-0 text-gray-600"></i>
                                </span>
                              </div>
                              <div class="me-5">
                                <a href="#" class="text-gray-800 fw-bolder text-hover-primary fs-6">Deplesi</a>
                                <span id="deplesi" class="text-gray-400 fw-bold fs-7 d-block text-start ps-0">${item.summary.deplesi} %</span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-2">
                          <div class="d-flex flex-stack">
                            <div class="d-flex align-items-center me-5">
                              <div class="symbol symbol-40px me-4">
                                <span class="symbol-label">
                                  <i class="fonticon-truck fs-1 p-0 text-gray-600"></i>
                                </span>
                              </div>
                              <div class="me-5">
                                <a href="#" class="text-gray-800 fw-bolder text-hover-primary fs-6">Pakan</a>
                                <span id="pakan" class="text-gray-400 fw-bold fs-7 d-block text-start ps-0">${item.summary.pakan} Kg</span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-2">
                          <div class="d-flex flex-stack">
                            <div class="d-flex align-items-center me-5">
                              <div class="symbol symbol-40px me-4">
                                <span class="symbol-label">
                                  <i class="fonticon-truck fs-1 p-0 text-gray-600"></i>
                                </span>
                              </div>
                              <div class="me-5">
                                <a href="#" class="text-gray-800 fw-bolder text-hover-primary fs-6">Panen Ekor</a>
                                <span id="panen_ekor" class="text-gray-400 fw-bold fs-7 d-block text-start ps-0">${item.summary.panen_ekor} Ekor</span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-2">
                          <div class="d-flex flex-stack">
                            <div class="d-flex align-items-center me-5">
                              <div class="symbol symbol-40px me-4">
                                <span class="symbol-label">
                                  <i class="fonticon-truck fs-1 p-0 text-gray-600"></i>
                                </span>
                              </div>
                              <div class="me-5">
                                <a href="#" class="text-gray-800 fw-bolder text-hover-primary fs-6">Panen Kg</a>
                                <span id="panen_kg" class="text-gray-400 fw-bold fs-7 d-block text-start ps-0">${item.summary.panen_kg} Kg</span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-2">
                          <div class="d-flex flex-stack">
                            <div class="d-flex align-items-center me-5">
                              <div class="symbol symbol-40px me-4">
                                <span class="symbol-label">
                                  <i class="fonticon-truck fs-1 p-0 text-gray-600"></i>
                                </span>
                              </div>
                              <div class="me-5">
                                <a href="#" class="text-gray-800 fw-bolder text-hover-primary fs-6">Umur Panen</a>
                                <span id="umur_panen" class="text-gray-400 fw-bold fs-7 d-block text-start ps-0">${item.summary.umur_panen} Hari</span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-2">
                          <div class="d-flex flex-stack">
                            <div class="d-flex align-items-center me-5">
                              <div class="symbol symbol-40px me-4">
                                <span class="symbol-label">
                                  <i class="fonticon-truck fs-1 p-0 text-gray-600"></i>
                                </span>
                              </div>
                              <div class="me-5">
                                <a href="#" class="text-gray-800 fw-bolder text-hover-primary fs-6">IP</a>
                                <span id="ip" class="text-gray-400 fw-bold fs-7 d-block text-start ps-0">${item.summary.ip}</span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="card-header mt-5">
              <div class="card-title flex-column mt-5">
                  <h3 class="fw-bolder mb-1">Detail</h3>
                  <div class="table-responsive mt-5">
                      <table id="tabel_${item.lokasi}" class="table gy-4 align-middle fw-bolder">
                          <thead class="fs-7 text-gray-400 text-uppercase">
                              <tr>
                                  <th>Nama Kandang</th>
                                  <th>Periode</th>
                                  <th>Pakan (Kg)</th>
                                  <th>Panen Ekor</th>
                                  <th>Panen (Kg)</th>
                                  <th>BW</th>
                                  <th>FCR Act</th>
                                  <th>FCR Std</th>
                                  <th>Diff FCR</th>
                                  <th>Strain</th>
                                  <th>Populasi</th>
                                  <th>Deplesi</th>
                                  <th>Umur Panen</th>
                                  <th>Daya Hidup</th>
                                  <th>IP</th>
                              </tr>
                          </thead>
                      </table>
                  </div>
              </div>
          </div>
          `;
        });
        $("#div_result_dinamis").html(htmlContent);
      }
    },
    'complete': function () {
      $("#button_calculate").prop('disabled', false); // Enable button
      $('#button_calculate').html('Calculate');


      parsedata.forEach(item => {
        $(`#tabel_${item.lokasi}`).DataTable({
          "info": false,
          "destroy": true,
          "lengthChange": true,
          "order": [[0, "desc"]],
          "paging": false,
          "scrollCollapse": true,
          "scrollY": "350px",
          "scrollX": true,
          dom: '<"top"B>rt<"bottom"ilp><"clear">',
          buttons: [
            { extend: 'excel', footer: true, title: `Tabel export data - ${item.lokasi}` },
            { extend: 'pdf', footer: true, title: `Tabel export data - ${item.lokasi}` },
            { extend: 'print', footer: true, title: `Tabel export data - ${item.lokasi}` },
            {
              extend: 'copy',
              text: 'Copy current page',
              exportOptions: { modifier: { page: 'current' } }
            }
          ],
          data: item.detail,
          columns: [
            { data: 'nama_kandang' },
            {
              "data": 'periode',
              "render": function (data, type, row) {
                return '<div class="d-flex align-items-center justify-content-center">' + data + '</div>'
              }
            },
            { data: 'data.pakan' },
            { data: 'data.panen_ekor' },
            { data: 'data.panen_kg' },
            { data: 'data.bw' },
            { data: 'data.fcr_act' },
            { data: 'data.fcr_std' },
            { data: 'data.diff_fcr' },
            { data: 'data.strain' },
            { data: 'data.populasi' },
            { data: 'data.deplesi' },
            { data: 'data.umur_panen' },
            { data: 'data.daya_hidup' },
            { data: 'data.ip' },
          ],
          columnDefs: [
            { targets: '_all', defaultContent: '0' },
            { targets: 0, visible: false },
          ],
          "initComplete": function () {
            this.api().buttons().container()
              .appendTo($('.col-md-6:eq(0)', this.api().table().container()));
          },

          "drawCallback": function () {
            var api = this.api();
            var rows = api.rows({ page: 'current' }).nodes();
            var lastKandang = null;

            rows.each(function (row, i) {
              var rowData = api.row(row).data();
              var kandang = rowData.nama_kandang;

              if (lastKandang !== kandang) {
                $(rows).eq(i).before(
                  `<tr class="group" style="background-color: #e4e6ef;">
                    <td colspan="15" class="bisa-diklik" role='button' data-key="${kandang}" data-table-id="tabel_${item.lokasi}" style="text-align:left;font-size:12px; border-bottom: 1px solid rgb(180, 180, 180);">
                        <p class="m-0" style="padding-left: 10px; font-weight:bold; font-size:10px">Kandang : ${kandang}</p>
                    </td>
                </tr>`
                );
                lastKandang = kandang;
              }
            });

            // Sembunyikan semua baris selain grup
            $(rows).not('.group').css('display', 'none');

            // Event klik untuk toggle tampilan
            $(`.bisa-diklik[data-table-id="tabel_${item.lokasi}"]`).off('click').on('click', function () {
              var groupId = $(this).data('key');
              var selectedRows = $(rows).not('.group').filter(function () {
                return api.row(this).data().nama_kandang === groupId;
              });

              // Toggle display
              if (selectedRows.css('display') === 'none') {
                selectedRows.css('display', 'table-row');
              } else {
                selectedRows.css('display', 'none');
              }
            });
          },
          "rowCallback": function (row, index) {
            if (index % 2 === 0) {
              $(row).css("background-color", "#f0f8ff"); // Warna biru muda untuk baris ganjil
            } else {
              $(row).css("background-color", "#ffffff"); // Warna putih untuk baris genap
            }
          }
        });
      });
    }

  });

}

function calculate_by_kandang() {
  var kandang = $("#filter_lokasi_kandang").val();
  var parsedata;

  if (kandang == "") {
    set_flashdata('error', 'Harap Pilih Kandang');
    return;
  }

  $.ajax({
    'type': "POST",
    'url': base_url + 'main/fcr/calculate_by_kandang',
    'data': {
      id: kandang,
    },
    'cache': false,
    'beforeSend': function () {
      $('#button_calculate_kandang').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading... ');
    },
    'success': function (result) {
      data = JSON.parse(result);
      if (data === 'data tidak ditemukan') {
        set_flashdata('error', 'Data Tidak Ditemukan');
      } else if (data === 'salah pilih tahun') {
        set_flashdata('error', 'salah pilih tahun');
      } else {
        set_flashdata('success', 'Proses kalkulasi berhasil');
        let htmlContent = "";
        htmlContent += `
              <div class="card card-flush mt-5">
                <div class='form-group row m-5 mt-15'>
                  <div class="col-2">
                    <div class="d-flex flex-stack">
                      <div class="d-flex align-items-center me-5">
                        <div class="symbol symbol-40px me-4">
                          <span class="symbol-label">
                            <i class="fonticon-truck fs-1 p-0 text-gray-600"></i>
                          </span>
                        </div>
                        <div class="me-5">
                          <a href="#" class="text-gray-800 fw-bolder text-hover-primary fs-6">Strain</a>
                          <span id="strain" class="text-gray-400 fw-bold fs-7 d-block text-start ps-0">${data.strain ?? '-'}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-2">
                    <div class="d-flex flex-stack">
                      <div class="d-flex align-items-center me-5">
                        <div class="symbol symbol-40px me-4">
                          <span class="symbol-label">
                            <i class="fonticon-truck fs-1 p-0 text-gray-600"></i>
                          </span>
                        </div>
                        <div class="me-5">
                          <a href="#" class="text-gray-800 fw-bolder text-hover-primary fs-6">BW</a>
                          <span id="bw" class="text-gray-400 fw-bold fs-7 d-block text-start ps-0">${data.bw ?? '0'} Gram</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-2">
                    <div class="d-flex flex-stack">
                      <div class="d-flex align-items-center me-5">
                        <div class="symbol symbol-40px me-4">
                          <span class="symbol-label">
                            <i class="fonticon-truck fs-1 p-0 text-gray-600"></i>
                          </span>
                        </div>
                        <div class="me-5">
                          <a href="#" class="text-gray-800 fw-bolder text-hover-primary fs-6">FCR Act</a>
                          <span id="fcr_act" class="text-gray-400 fw-bold fs-7 d-block text-start ps-0">${data.fcr_act ?? '-'}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-2">
                    <div class="d-flex flex-stack">
                      <div class="d-flex align-items-center me-5">
                        <div class="symbol symbol-40px me-4">
                          <span class="symbol-label">
                            <i class="fonticon-truck fs-1 p-0 text-gray-600"></i>
                          </span>
                        </div>
                        <div class="me-5">
                          <a href="#" class="text-gray-800 fw-bolder text-hover-primary fs-6">FCR Std</a>
                          <span id="fcr_std" class="text-gray-400 fw-bold fs-7 d-block text-start ps-0">${data.fcr_std ?? '-'}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-2">
                    <div class="d-flex flex-stack">
                      <div class="d-flex align-items-center me-5">
                        <div class="symbol symbol-40px me-4">
                          <span class="symbol-label">
                            <i class="fonticon-truck fs-1 p-0 text-gray-600"></i>
                          </span>
                        </div>
                        <div class="me-5">
                          <a href="#" class="text-gray-800 fw-bolder text-hover-primary fs-6">Diff FCR</a>
                          <span id="diff_fcr" class="text-gray-400 fw-bold fs-7 d-block text-start ps-0">${data.diff_fcr ?? '-'}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-2">
                    <div class="d-flex flex-stack">
                      <div class="d-flex align-items-center me-5">
                        <div class="symbol symbol-40px me-4">
                          <span class="symbol-label">
                            <i class="fonticon-truck fs-1 p-0 text-gray-600"></i>
                          </span>
                        </div>
                        <div class="me-5">
                          <a href="#" class="text-gray-800 fw-bolder text-hover-primary fs-6">Tot Populasi</a>
                          <span id="populasi" class="text-gray-400 fw-bold fs-7 d-block text-start ps-0">${data.populasi ?? '-'} Ekor</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class='form-group row m-5 mb-15'>
                  <div class="col-2">
                    <div class="d-flex flex-stack">
                      <div class="d-flex align-items-center me-5">
                        <div class="symbol symbol-40px me-4">
                          <span class="symbol-label">
                            <i class="fonticon-truck fs-1 p-0 text-gray-600"></i>
                          </span>
                        </div>
                        <div class="me-5">
                          <a href="#" class="text-gray-800 fw-bolder text-hover-primary fs-6">Deplesi</a>
                          <span id="deplesi" class="text-gray-400 fw-bold fs-7 d-block text-start ps-0">${data.deplesi ?? '-'} %</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-2">
                    <div class="d-flex flex-stack">
                      <div class="d-flex align-items-center me-5">
                        <div class="symbol symbol-40px me-4">
                          <span class="symbol-label">
                            <i class="fonticon-truck fs-1 p-0 text-gray-600"></i>
                          </span>
                        </div>
                        <div class="me-5">
                          <a href="#" class="text-gray-800 fw-bolder text-hover-primary fs-6">Pakan</a>
                          <span id="pakan" class="text-gray-400 fw-bold fs-7 d-block text-start ps-0">${data.pakan ?? '-'} Kg</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-2">
                    <div class="d-flex flex-stack">
                      <div class="d-flex align-items-center me-5">
                        <div class="symbol symbol-40px me-4">
                          <span class="symbol-label">
                            <i class="fonticon-truck fs-1 p-0 text-gray-600"></i>
                          </span>
                        </div>
                        <div class="me-5">
                          <a href="#" class="text-gray-800 fw-bolder text-hover-primary fs-6">Panen Ekor</a>
                          <span id="panen_ekor" class="text-gray-400 fw-bold fs-7 d-block text-start ps-0">${data.panen_ekor ?? '-'} Ekor</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-2">
                    <div class="d-flex flex-stack">
                      <div class="d-flex align-items-center me-5">
                        <div class="symbol symbol-40px me-4">
                          <span class="symbol-label">
                            <i class="fonticon-truck fs-1 p-0 text-gray-600"></i>
                          </span>
                        </div>
                        <div class="me-5">
                          <a href="#" class="text-gray-800 fw-bolder text-hover-primary fs-6">Panen Kg</a>
                          <span id="panen_kg" class="text-gray-400 fw-bold fs-7 d-block text-start ps-0">${data.panen_kg ?? '-'} Kg</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-2">
                    <div class="d-flex flex-stack">
                      <div class="d-flex align-items-center me-5">
                        <div class="symbol symbol-40px me-4">
                          <span class="symbol-label">
                            <i class="fonticon-truck fs-1 p-0 text-gray-600"></i>
                          </span>
                        </div>
                        <div class="me-5">
                          <a href="#" class="text-gray-800 fw-bolder text-hover-primary fs-6">Umur Panen</a>
                          <span id="umur_panen" class="text-gray-400 fw-bold fs-7 d-block text-start ps-0">${data.umur_panen ?? '-'} Hari</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-2">
                    <div class="d-flex flex-stack">
                      <div class="d-flex align-items-center me-5">
                        <div class="symbol symbol-40px me-4">
                          <span class="symbol-label">
                            <i class="fonticon-truck fs-1 p-0 text-gray-600"></i>
                          </span>
                        </div>
                        <div class="me-5">
                          <a href="#" class="text-gray-800 fw-bolder text-hover-primary fs-6">IP</a>
                          <span id="ip" class="text-gray-400 fw-bold fs-7 d-block text-start ps-0">${data.ip ?? '-'}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            `
        $("#div_result_dinamis_by_kandang").html(htmlContent);
      }
    },
    'complete': function () {
      $("#button_calculate").prop('disabled', false); // Enable button
      document.querySelector('#button_calculate_kandang').innerHTML = 'Calculate';
    }

  });

}
