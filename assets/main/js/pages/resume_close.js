function viewtableresumeclose() {
    var id_user = $("#filter_lokasi").val();
    var tahun = $('#filter_tahun').val();
    console.log(tahun);
    var ss = document.getElementById("filter_lokasi");
    var lokasi = ss.options[ss.selectedIndex].getAttribute('data-1');
    $('#exampletableresumeclose tfoot th').each(function () {
        var title = $(this).text();
        // $(this).html('<br><input class="form-control" type="text" placeholder="Search ' + title + '" />');
        $(this).html('');
    });
    //---------Tabel Point Feed----------//
    var tpf = $('#exampletableresumeclose').DataTable({
        // filter: false,
        "info": true,
        "destroy": true,
        "lengthChange": true,
        "order": [
            [0, "desc"]
        ],
        "paging": false,
        "pageLength": -1,
        "lengthMenu": [
            [7, 10, 25, 50, -1],
            [7, 10, 25, 50, "All"]
        ],
        "scrollCollapse": true,
        "scrollY": "350px",
        "scrollX": true,
        dom: '<"top"B>rt<"bottom"ilp><"clear">',
        buttons: [{
                extend: 'excel',
                footer: true,
                title: 'Tabel Resume'
            },
            {
                extend: 'pdf',
                footer: true,
                title: 'Tabel Resume'
            },
            {
                extend: 'print',
                footer: true,
                title: 'Tabel Resume'
            },
            // {
            //     extend: 'copy',
            //     text: 'Copy current page',
            //     exportOptions: {
            //         modifier: {
            //             page: 'current'
            //         }
            //     }
            // }
        ],
        "ajax": {
            'type': 'POST',
            'url': base_url + 'main/resume_close/get_data_resume_close',
            'data': {
                lokasi: lokasi,
                id_user: id_user,
                tahun: tahun,
            },
            "dataSrc": "",
            beforeSend: function () {
                $("#button_viewtableresumeclose").prop('disabled', true); // disable button
                document.querySelector('#button_viewtableresumeclose').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
            },
        },
        "columns": [{
                "data": 'id_kandang',
                "className": 'text-nowrap',
                "render": function (data, type, row) {
                    var button = `  <a href="` + base_url + `/main/ternak/detail/` + row['status_kandang'] + `/` + row['id_kandang'] + `/` + row['periode'] + `"  class="btn btn-sm btn-icon btn-bg-color btn-active-color-primary">
                                        <i class="fas fa-search white-true" style="font-size: 14px;"></i>
                                    </a>`
                    return button;
                }
            },
            {
                'data': 'nama'
            },
            {
                'data': 'periode'
            },
            {
                'data': 'strain'
            },
            {
                'data': 'tanggal_chickin'
            },
            {
                'data': 'umur_rata_panen'
            },
            {
                'data': 'ip'
            },
            {
                'data': 'rg3'
            },
            {
                'data': 'rg7'
            },
            {
                'data': 'populasi_awal'
            },
            {
                'data': 'deplesi'
            },
            {
                'data': 'deplesi_persent'
            },
            {
                'data': 'bw'
            },
            {
                'data': 'panen_ekor'
            },
            {
                'data': 'panen_kg'
            },
            {
                'data': 'tot_feed'
            },
            {
                'data': 'total_sekam'
            },
            {
                'data': 'total_lpg'
            },
            {
                'data': 'act_fcr'
            },
            {
                'data': 'std_fcr'
            },
            {
                'data': 'diff_fcr'
            },
            {
                'data': 'tgl_awal_panen'
            },
            {
                'data': 'tgl_akhir_panen'
            },
            {
                "data": 'status_kandang',
                "className": 'text-nowrap',
                "render": function (data, type, row) {
                    if (data == 'AKTIF') {
                        var comment = `<span class="badge badge-light-success">` + data + `</span>`;
                    } else {
                        var comment = `<span class="badge badge-light-danger">` + data + `</span>`;
                    }
                    return `<a href="javascript:void(0);"  class="" onclick="openkandang(` + row['status_id'] + `,` + row['id_kandang'] + `)">` + comment + `</a>`;
                }
            }
        ],
        "columnDefs": [{
            "targets": '_all',
            "defaultContent": '0',
            "className": 'dt-center',
        }],
        "order": [
            [0, 'desc']
        ],

        initComplete: function () {
            this.api().buttons().container()
                .appendTo($('.col-md-6:eq(0)', this.api().table().container()));
            this.api()
                .columns()
                .every(function () {
                    var that = this;

                    $('input', this.footer()).on('keyup change clear', function () {
                        if (that.search() !== this.value) {
                            that.search(this.value).draw();
                        }
                    });
                });
            $("#button_viewtableresumeclose").prop('disabled', false); // enable button
            document.querySelector('#button_viewtableresumeclose').innerHTML = 'Load';
        },
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(),
                data;
            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                    i : 0;
            };

            var coltosum = []
            for (c in coltosum) {
                // Total over all pages
                // console.log(api.column( coltosum[c] ).data())
                // total = api.column( coltosum[c] ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                // Total over this page
                pageTotal = api.column(coltosum[c], {
                    page: 'current'
                }).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                // Update footer
                $(api.column(coltosum[c]).footer()).html(pageTotal);
            }
        }
    });
    //---------End Tabel Point Feed----------//



}

function openkandang(status_id, id_kandang) {
    // var id_user = document.querySelector('#filter_lokasi').value;
    // console.log(id_delete);
    Swal.fire({
        title: 'Open Periode ini?',
        text: 'Data ini akan dirubah, pastikan kembali anda tidak salah pencet',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Update',
        cancelButtonText: 'Tidak',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'POST',
                url: base_url + 'main/resume_close/openkandang',
                data: {
                    status_id: status_id,
                    id_kandang: id_kandang,
                },
                cache: false,
                beforeSend: function () {
                    loading("on");
                },
                success: function (data) {
                    // loading("off");
                    var parsedata = JSON.parse(data);
                    console.log(parsedata);
                    if (parsedata.status == 'success') {
                        set_flashdata('success', 'Berhasil Update Data');
                        viewtableresumeclose()


                    } else {
                        set_flashdata('error', 'Input Data Gagal');
                    }
                },
                complete: function () {

                },

            });
        }
    })

}