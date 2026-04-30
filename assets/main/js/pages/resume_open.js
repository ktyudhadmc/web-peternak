function viewtableresumeopen() {
    var id_user = $("#filter_lokasi").val();
    var ss = document.getElementById("filter_lokasi");
    var lokasi = ss.options[ss.selectedIndex].getAttribute('data-1');
    $('#exampletableresumeopen tfoot th').each(function (data) {
        var title = $(this).text();
        if (title == "Kandang" || title == "Periode") {
            $(this).html('<br><input class="form-control" type="text" placeholder="Search ' + title + '" />');
        } else {
            $(this).html('');
        }
    });
    //---------Tabel Point Feed----------//
    var tpf = $('#exampletableresumeopen').DataTable({
        // filter: false,
        "info": true,
        "destroy": true,
        "lengthChange": true,
        "order": [[2, "desc"]],
        "paging": false,
        "pageLength": -1,
        "lengthMenu": [[7, 10, 25, 50, -1], [7, 10, 25, 50, "All"]],
        "scrollCollapse": true,
        "scrollY": "350px",
        "scrollX": true,
        dom: '<"top"B>rt<"bottom"ilp><"clear">',
        buttons: [{ extend: 'excel', footer: true, title: 'Tabel Resume' },
        { extend: 'pdf', footer: true, title: 'Tabel Resume' },
        { extend: 'print', footer: true, title: 'Tabel Resume' },
        ],
        "ajax": {
            'type': 'POST',
            'url': base_url + 'main/resume_open/get_data_resume_open',
            'data': {
                lokasi: lokasi,
                id_user: id_user,
            },
            "dataSrc": "",
            beforeSend: function () {
                $("#button_viewtableresumeopen").prop('disabled', true); // disable button
                document.querySelector('#button_viewtableresumeopen').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
            },
        },
        "columns": [
            {
                "data": 'id_kandang',
                "className": 'dt-center ',
                "width": "1%",
                "render": function (data, type, row) {
                    var button = `  <a href="` + base_url + `/main/ternak/detail/` + row['status_kandang'] + `/` + row['id_kandang'] + `/` + row['periode'] + `"  class="btn btn-sm btn-icon btn-bg-color btn-active-color-primary">
                                        <i class="white-true fas fa-search" style="font-size: 14px;"></i>
                                    </a>`
                    return button;
                }
            },
            { "data": 'nama' },
            { 'data': 'umur', "width": "1%", },
            { 'data': 'umur_saat_ini', "width": "1%", },
            { 'data': 'bw', "width": "1%", },
            { 'data': 'deplesi_persent', "width": "1%", },
            { 'data': 'deplesi', "width": "1%", },
            { 'data': 'act_fcr', "width": "1%", },
            { 'data': 'populasi', "width": "1%", },
            {
                'data': 'tanggal_chickin',
                "className": 'dt-center ',
                "width": "1%",
                "render": function (data, type, row) {
                    var date_format = data.slice(8, 10) + `/` + data.slice(5, 7) + `/` + data.slice(2, 4);
                    return date_format;
                },
            },
            { 'data': 'periode' },
            { 'data': 'strain' },

            { 'data': 'ip', "width": "1%", },
            { 'data': 'act_adg', "width": "1%", },


            { 'data': 'rg3', "width": "1%", },
            { 'data': 'rg7', "width": "1%", },
            { 'data': 'lokasi_kandang', "width": "1%", },
            { 'data': 'pic', "width": "1%", },
            {
                "data": 'status_kandang',
                "className": 'dt-center',
                "render": function (data, type, row) {
                    if (data == 'AKTIF') {
                        var comment = `<span class="badge badge-light-success">` + data + `</span>`;
                    } else {
                        var comment = `<span class="badge badge-light-danger">` + data + `</span>`;
                    }
                    return `<a href="javascript:void(0);"  class="" onclick="closekandang(` + row['status_id'] + `,` + row['id_kandang'] + `)">` + comment + `</a>`;
                }
            }

        ],
        "columnDefs": [
            {
                "targets": '_all',
                "defaultContent": '0',
                "className": 'dt-center',
            }
        ],
        "order": [[2, 'desc']],

        initComplete: function () {
            this.api().buttons().container()
                .appendTo($('.col-md-6:eq(0)', this.api().table().container()));
            this.api()
                .columns()
                .every(function () {
                    var that = this;
                    $('input', this.footer()).on('keyup change clear', function () {
                        console.log(that.search(this.value).draw())
                        if (that.search() !== this.value) {
                            that.search(this.value).draw();
                        }
                    });
                });
            $("#button_viewtableresumeopen").prop('disabled', false); // enable button
            document.querySelector('#button_viewtableresumeopen').innerHTML = 'Load';
        },
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(), data;
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
                pageTotal = api.column(coltosum[c], { page: 'current' }).data().reduce(function (a, b) { return intVal(a) + intVal(b); }, 0);
                // Update footer
                $(api.column(coltosum[c]).footer()).html(pageTotal);
            }
        }
    });
    $('#exampletableresumeopen').on('click', 'tbody tr', function () {
        // // console.log(base_url); //http://192.168.58.58/peternak_main/
        // window.location.href = base_url + `waiting?loadto=main/ternak/detail/aktif/` + tpf.row(this).data().id_kandang + '/' + tpf.row(this).data().periode;
        // // http://192.168.58.58/peternak_main/waiting?loadto=main/ternak/detail/aktif/161/20220916114144
        // // var data = `/rankings/team/${tpf.row(this).data()[3]}/d1m`;
        // // console.log(tpf.row(this).data())
        // // http://192.168.58.58/peternak_main/main/ternak/detail/aktif/144/20220913101742
    });
    $('#exampletableresumeopen tbody tr').css('cursor', 'pointer');

}

function closekandang(status_id, id_kandang) {
    // var id_user = document.querySelector('#filter_lokasi').value;
    // console.log(id_delete);
    Swal.fire({
        title: 'Close Periode ini?',
        text: 'Data ini akan dirubah, pastikan kembali anda tidak salah pencet',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Update',
        cancelButtonText: 'Tidak',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax
                ({
                    type: 'POST',
                    url: base_url + 'main/resume_open/closekandang',
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
                            viewtableresumeopen()
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

