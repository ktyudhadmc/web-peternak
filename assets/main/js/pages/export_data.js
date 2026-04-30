async function viewtableexportdatastatus() {
    var id_user = $("#filter_lokasi").val();
    var status = $("#status").val();
    var tahun = $("#tahun").val();
    var bulan = $("#bulan").val();


    if (id_user == "0" || status == "0" || tahun == "0" || bulan == "0") {
        set_flashdata('error', 'Input Data Gagal');
        return;
    }
    $('#exampletableexportdatastatus tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<br><input class="form-control" type="text" placeholder="Search ' + title + '" />');
    });
    //---------Tabel Point Feed----------//
    var tpf1 = $('#exampletableexportdatastatus').DataTable({
        // filter: false,
        "info": true,
        "destroy": true,
        "lengthChange": true,
        "order": [[0, "desc"]],
        "paging": true,
        "pageLength": -1,
        "lengthMenu": [[7, 10, 25, 50, -1], [7, 10, 25, 50, "All"]],
        "scrollCollapse": true,
        "scrollY": "350px",
        "scrollX": true,
        dom: '<"top"B>rt<"bottom"ilp><"clear">',
        buttons: [{ extend: 'excel', footer: true, title: 'Tabel export data status' },
        { extend: 'pdf', footer: true, title: 'Tabel export data status' },
        { extend: 'print', footer: true, title: 'Tabel export data status' },
        {
            extend: 'copy',
            text: 'Copy current page',
            exportOptions: {
                modifier: {
                    page: 'current'
                }
            }
        }
        ],
        "ajax": {
            'type': 'POST',
            'url': base_url + 'main/export_data/get_data_export_data_status',
            'data': {
                id_user: id_user,
                status: status,
                tahun: tahun,
                bulan: bulan,

            },
            "dataSrc": "",
            beforeSend: function () {
                // $("#button_viewtableresumeopen").prop('disabled', true); // disable button
                // document.querySelector('#button_viewtableresumeopen').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
            },
        },
        "columns": [
            { 'data': 'nama' },
            { 'data': 'periode' },
            { 'data': 'tanggal_mulai' },
            { 'data': 'alamat' },
            { 'data': 'populasi_awal' },
            { 'data': 'strain' },
            { 'data': 'pic' },
            { 'data': 'abk' },

        ],
        "columnDefs": [
            {
                "targets": '_all',
                "defaultContent": '0'
            }
        ],
        "order": [[0, 'desc']],

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
            // $("#button_viewtableresumeopen").prop('disabled', false); // enable button
            // document.querySelector('#button_viewtableresumeopen').innerHTML = 'Load';
            document.querySelector('#tittle_table_export_data_status').innerHTML = 'Tabel Export Data ' + status;
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
    //---------End Tabel Point Feed----------//
}
async function viewtableexportdatalhk() {
    var id_user = $("#filter_lokasi").val();
    var status = $("#status").val();
    var tahun = $("#tahun").val();
    var bulan = $("#bulan").val();


    if (id_user == "0" || status == "0" || tahun == "0" || bulan == "0") {
        set_flashdata('error', 'Input Data Gagal');
        return;
    }
    $('#exampletableexportdatalhk tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<br><input class="form-control" type="text" placeholder="Search ' + title + '" />');
    });
    //---------Tabel Point Feed----------//
    var tpf2 = $('#exampletableexportdatalhk').DataTable({
        // filter: false,
        "info": true,
        "destroy": true,
        "lengthChange": true,
        "order": [[0, "desc"]],
        "paging": true,
        "pageLength": 7,
        "lengthMenu": [[7, 10, 25, 50, -1], [7, 10, 25, 50, "All"]],
        "scrollCollapse": true,
        "scrollY": "350px",
        "scrollX": true,
        dom: '<"top"B>rt<"bottom"ilp><"clear">',
        buttons: [{ extend: 'excel', footer: true, title: 'Tabel export data lhk' },
        { extend: 'pdf', footer: true, title: 'Tabel export data lhk' },
        { extend: 'print', footer: true, title: 'Tabel export data lhk' },
        {
            extend: 'copy',
            text: 'Copy current page',
            exportOptions: {
                modifier: {
                    page: 'current'
                }
            }
        }
        ],
        "ajax": {
            'type': 'POST',
            'url': base_url + 'main/export_data/get_data_export_data_lhk',
            'data': {
                id_user: id_user,
                status: status,
                tahun: tahun,
                bulan: bulan,

            },
            "dataSrc": "",
            beforeSend: function () {
                // $("#button_viewtableresumeopen").prop('disabled', true); // disable button
                // document.querySelector('#button_viewtableresumeopen').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
            },
        },
        "columns": [
            { 'data': 'nama' },
            { 'data': 'periode' },
            { 'data': 'nama' },
            { 'data': 'umur' },
            { 'data': 'bw' },
            { 'data': 'sb20' },
            { 'data': 'br0' },
            { 'data': 'sb21cr' },
            { 'data': 'sb21p' },
            { 'data': 'br1cr' },
            { 'data': 'br1p' },
            { 'data': 'sb22' },
            { 'data': 'br2' },
            { 'data': 'other_feed' },
            { 'data': 'mati' },
            { 'data': 'culling' },
        ],
        "columnDefs": [
            {
                "targets": '_all',
                "defaultContent": '0'
            }
        ],
        "order": [[0, 'desc']],

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
            // $("#button_viewtableresumeopen").prop('disabled', false); // enable button
            // document.querySelector('#button_viewtableresumeopen').innerHTML = 'Load';
            document.querySelector('#tittle_table_export_data_lhk').innerHTML = 'Tabel Export Data LHK ' + status;
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

            var coltosum = [5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15]
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
    //---------End Tabel Point Feed----------//
}
async function viewtableexportdatapanen() {
    var id_user = $("#filter_lokasi").val();
    var status = $("#status").val();
    var tahun = $("#tahun").val();
    var bulan = $("#bulan").val();

    if (id_user == "0" || status == "0" || tahun == "0" || bulan == "0") {
        set_flashdata('error', 'Input Data Gagal');
        return;
    }
    $('#exampletableexportdatapanen tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<br><input class="form-control" type="text" placeholder="Search ' + title + '" />');
    });
    //---------Tabel Point Feed----------//
    var tpf3 = $('#exampletableexportdatapanen').DataTable({
        // filter: false,
        "info": true,
        "destroy": true,
        "lengthChange": true,
        "order": [[0, "desc"]],
        "paging": true,
        "pageLength": -1,
        "lengthMenu": [[7, 10, 25, 50, -1], [7, 10, 25, 50, "All"]],
        "scrollCollapse": true,
        "scrollY": "350px",
        "scrollX": true,
        dom: '<"top"B>rt<"bottom"ilp><"clear">',
        buttons: [{ extend: 'excel', footer: true, title: 'Tabel export data panen' },
        { extend: 'pdf', footer: true, title: 'Tabel export data panen' },
        { extend: 'print', footer: true, title: 'Tabel export data panen' },
        {
            extend: 'copy',
            text: 'Copy current page',
            exportOptions: {
                modifier: {
                    page: 'current'
                }
            }
        }
        ],
        "ajax": {
            'type': 'POST',
            'url': base_url + 'main/export_data/get_data_export_data_panen',
            'data': {
                id_user: id_user,
                status: status,
                tahun: tahun,
                bulan: bulan,

            },
            "dataSrc": "",
            beforeSend: function () {
                // $("#button_viewtableresumeopen").prop('disabled', true); // disable button
                // document.querySelector('#button_viewtableresumeopen').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
            },
        },
        "columns": [
            { 'data': 'tanggal' },
            { 'data': 'nomorDO' },
            { 'data': 'nomor_mobil' },
            { 'data': 'nama' },
            { 'data': 'periode' },
            { 'data': 'nomornota' },
            { 'data': 'namapembeli' },
            { 'data': 'totekor' },
            { 'data': 'totgram' },
            { 'data': 'susut' },
            { 'data': 'nett' },
            { 'data': 'kondisiayam' },
        ],
        "columnDefs": [
            {
                "targets": '_all',
                "defaultContent": '0'
            }
        ],
        "order": [[0, 'desc']],

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
            // $("#button_viewtableresumeopen").prop('disabled', false); // enable button
            // document.querySelector('#button_viewtableresumeopen').innerHTML = 'Load';
            document.querySelector('#tittle_table_export_data_panen').innerHTML = 'Tabel Export Data Panen ' + status;
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

            var coltosum = [7, 8, 9, 10]
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
    //---------End Tabel Point Feed----------//
}
