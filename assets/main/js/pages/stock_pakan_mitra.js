function viewtablepemakaianpakan() {

    var id_user = document.querySelector('#filter_lokasi').value;
    console.log(id_user);
    var ss = document.getElementById("filter_lokasi");
    var lokasi = ss.options[ss.selectedIndex].getAttribute('data-1');
    var tanggal_mulai = $('#input_range_tanggal').data('daterangepicker').startDate.format('YYYY-MM-DD');
    var tanggal_akhir = $('#input_range_tanggal').data('daterangepicker').endDate.format('YYYY-MM-DD');
    $('#exampletablepemakaianpakan tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<br><input class="form-control" type="text" placeholder="Search ' + title + '" />');
    });
    //---------Tabel Point Feed----------//
    var tpf = $('#exampletablepemakaianpakan').DataTable({
        // filter: false,
        "info": true,
        "destroy": true,
        "lengthChange": true,
        "order": [
            [0, "desc"]
        ],
        "paging": true,
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
                title: 'Pemakaian Pakan ' + lokasi + ' tanggal ' + tanggal_mulai + ' to ' + tanggal_akhir
            },
            {
                extend: 'pdf',
                footer: true,
                title: 'Pemakaian Pakan ' + lokasi + ' tanggal ' + tanggal_mulai + ' to ' + tanggal_akhir
            },
            {
                extend: 'print',
                footer: true,
                title: 'Pemakaian Pakan ' + lokasi + ' tanggal ' + tanggal_mulai + ' to ' + tanggal_akhir
            },
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
            'url': base_url + 'main/stock_pakan_mitra/get_data_pemakaian_pakan',
            'data': {
                id_user: id_user,
                tanggal_mulai: tanggal_mulai,
                tanggal_akhir: tanggal_akhir,
            },
            "dataSrc": "",
            beforeSend: function () {
                $("#button_viewtablepemakaianpakan").prop('disabled', true); // disable button
                document.querySelector('#button_viewtablepemakaianpakan').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
            },
        },

        "columns": [{
                'data': 'nama'
            },
            {
                'data': 'periode'
            },
            {
                'data': 'brand'
            },
            {
                'data': 'qty'
            },
        ],
        "columnDefs": [{
            "targets": '_all',
            "defaultContent": '0'
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
            $("#button_viewtablepemakaianpakan").prop('disabled', false); // enable button
            document.querySelector('#button_viewtablepemakaianpakan').innerHTML = 'Load';
            document.querySelector('#tittle_table_pemakaian_pakan').innerHTML = 'Pemakaian Pakan ' + lokasi;
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

            var coltosum = [3]
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

function viewtabledetailpemakaianpakan() {

    var id_user = document.querySelector('#filter_lokasi').value;
    console.log(id_user);
    var ss = document.getElementById("filter_lokasi");
    var lokasi = ss.options[ss.selectedIndex].getAttribute('data-1');
    var tanggal_mulai = $('#input_range_tanggal').data('daterangepicker').startDate.format('YYYY-MM-DD');
    var tanggal_akhir = $('#input_range_tanggal').data('daterangepicker').endDate.format('YYYY-MM-DD');
    $('#exampletabledetailpemakaianpakan tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<br><input class="form-control" type="text" placeholder="Search ' + title + '" />');
    });
    //---------Tabel Point Feed----------//
    var tpf = $('#exampletabledetailpemakaianpakan').DataTable({
        // filter: false,
        "info": true,
        "destroy": true,
        "lengthChange": true,
        "order": [
            [0, "desc"]
        ],
        "paging": true,
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
                title: 'Pemakaian Pakan ' + lokasi + ' tanggal ' + tanggal_mulai + ' to ' + tanggal_akhir
            },
            {
                extend: 'pdf',
                footer: true,
                title: 'Pemakaian Pakan ' + lokasi + ' tanggal ' + tanggal_mulai + ' to ' + tanggal_akhir
            },
            {
                extend: 'print',
                footer: true,
                title: 'Pemakaian Pakan ' + lokasi + ' tanggal ' + tanggal_mulai + ' to ' + tanggal_akhir
            },
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
            'url': base_url + 'main/stock_pakan_mitra/get_data_detail_pemakaian_pakan',
            'data': {
                id_user: id_user,
                tanggal_mulai: tanggal_mulai,
                tanggal_akhir: tanggal_akhir,
            },
            "dataSrc": "",
            beforeSend: function () {
                $("#button_viewtabledetailpemakaianpakan").prop('disabled', true); // disable button
                document.querySelector('#button_viewtabledetailpemakaianpakan').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
            },
        },

        "columns": [{
                'data': 'nama'
            },
            {
                'data': 'periode'
            },
            {
                'data': 'tgl'
            },
            {
                'data': 'brand'
            },
            {
                'data': 'qty'
            },
            {
                'data': 'created_at'
            },
            {
                'data': 'update_at'
            },
            {
                'data': 'edit_by'
            },
            {
                'data': 'number'
            },
        ],
        "columnDefs": [{
            "targets": '_all',
            "defaultContent": '0'
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
            $("#button_viewtablepemakaianpakan").prop('disabled', false); // enable button
            document.querySelector('#button_viewtabledetailpemakaianpakan').innerHTML = 'Load';
            document.querySelector('#tittle_table_detail_pemakaian_pakan').innerHTML = 'Pemakaian Pakan ' + lokasi;
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

            var coltosum = [4]
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

function viewtablestockpakan() {

    var id_user = document.querySelector('#filter_lokasi').value;
    var ss = document.getElementById("filter_lokasi");
    var lokasi = ss.options[ss.selectedIndex].getAttribute('data-1');
    var tanggal_akhir = $('#input_range_tanggal').data('daterangepicker').endDate.format('YYYY-MM-DD');
    $('#exampletablestockpakan tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<br><input class="form-control" type="text" placeholder="Search ' + title + '" />');
    });
    //---------Tabel Point Feed----------//
    var tso = $('#exampletablestockpakan').DataTable({
        // filter: false,
        "info": true,
        "destroy": true,
        "lengthChange": true,
        "order": [
            [0, "desc"]
        ],
        "paging": true,
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
                title: 'Stock Pakan ' + lokasi + ' tanggal ' + tanggal_akhir
            },
            {
                extend: 'pdf',
                footer: true,
                title: 'Stock Pakan ' + lokasi + ' tanggal ' + tanggal_akhir
            },
            {
                extend: 'print',
                footer: true,
                title: 'Stock Pakan ' + lokasi + ' tanggal ' + tanggal_akhir
            },
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
            'url': base_url + 'main/stock_pakan_mitra/get_data_stock_pakan',
            'data': {
                id_user: id_user,
                tanggal_akhir: tanggal_akhir,
            },
            "dataSrc": "",
            beforeSend: function () {
                $("#button_viewtablestockpakan").prop('disabled', true); // disable button
                document.querySelector('#button_viewtablestockpakan').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
            },
        },

        "columns": [{
                'data': 'brand'
            },
            {
                'data': 'stock'
            },
        ],
        "columnDefs": [{
            "targets": '_all',
            "defaultContent": '0'
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
            $("#button_viewtablestockpakan").prop('disabled', false); // enable button
            document.querySelector('#button_viewtablestockpakan').innerHTML = 'Load';
            document.querySelector('#tittle_table_stock_pakan').innerHTML = 'Stock Pakan ' + lokasi + ' Tanggal ' + tanggal_akhir;
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

            var coltosum = [1]
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
    $.ajax({
        type: 'POST',
        url: base_url + 'main/stock_pakan_mitra/kebutuhanpakan',
        data: {
            id_user: id_user,
            tanggal_akhir: tanggal_akhir,
        },
        cache: false,
        success: function (data) {
            var parsedata = JSON.parse(data);
            document.querySelector('#buffer').innerHTML = parsedata.bufferstock;
        },
    });
}

function viewtablekedatanganpakan() {

    var id_user = document.querySelector('#filter_lokasi').value;
    var ss = document.getElementById("filter_lokasi");
    var lokasi = ss.options[ss.selectedIndex].getAttribute('data-1');
    //  var tanggal_akhir = $('#input_range_tanggal').data('daterangepicker').endDate.format('YYYY-MM-DD');
    $('#exampletablekedatanganpakan tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<br><input class="form-control" type="text" placeholder="Search ' + title + '" />');
    });
    //---------Tabel Point Feed----------//
    var tso = $('#exampletablekedatanganpakan').DataTable({
        // filter: false,
        "info": true,
        "destroy": true,
        "lengthChange": true,
        "order": [
            [0, "desc"]
        ],
        "paging": true,
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
                title: 'Kedatangan Pakan ' + lokasi
            },
            {
                extend: 'pdf',
                footer: true,
                title: 'Kedatangan Pakan ' + lokasi
            },
            {
                extend: 'print',
                footer: true,
                title: 'Kedatangan Pakan ' + lokasi
            },
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
            'url': base_url + 'main/stock_pakan_mitra/get_data_kedatangan_pakan',
            'data': {
                id_user: id_user,
            },
            "dataSrc": "",
            beforeSend: function () {
                $("#button_viewtablekedatanganpakan").prop('disabled', true); // disable button
                document.querySelector('#button_viewtablekedatanganpakan').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
            },
        },

        "columns": [{
                'data': 'tanggal'
            },
            {
                'data': 'brand'
            },
            {
                'data': 'qty'
            },
            {
                "data": 'ket',
                "className": 'text-nowrap',
                "render": function (data, type, row) {
                    if (row['id_user_to']) {
                        return `Mutasi Dari Lokasi ` + row['lokasi'];
                    } else {
                        return data;
                    }
                }
            },
            {
                "data": 'id',
                "className": 'text-nowrap',
                "render": function (data, type, row) {
                    if (row['id_user_to']) {
                        return `Data Mutasi Tidak Dapat di Ubah`;
                    } else {
                        return `<a href="javascript:void(0);"  class="btn btn-primary btn-sm item_edit" data-id="` + data + `" data-brand="` + row['brand'] + `" data-ket="` + row['ket'] + `" data-qty="` + row['qty'] + `" data-tanggal="` + row['tanggal'] + `" data-id_this="` + row['id_this'] + `"><i class="fas fa-pencil-alt"></i>&nbsp Edit</a>
          <a href="javascript:void(0);"  class="btn btn-danger btn-sm" onclick="delete_kedatangan_mutasi_pakan(` + data + `,'stock_pakan_mitra/delete_kedatangan_pakan')"><i class="fa fa-trash"></i>&nbsp Delete</a>`;
                    }
                }
            }
        ],
        "columnDefs": [{
            "targets": '_all',
            "defaultContent": '0'
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
            $("#button_viewtablekedatanganpakan").prop('disabled', false); // enable button
            document.querySelector('#button_viewtablekedatanganpakan').innerHTML = 'Load';
            document.querySelector('#tittle_table_kedatangan_pakan').innerHTML = 'Kedatangan Pakan ' + lokasi;
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

            var coltosum = [2]
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

function viewtablemutasipakan() {

    var id_user = document.querySelector('#filter_lokasi').value;
    var ss = document.getElementById("filter_lokasi");
    var lokasi = ss.options[ss.selectedIndex].getAttribute('data-1');
    //  var tanggal_akhir = $('#input_range_tanggal').data('daterangepicker').endDate.format('YYYY-MM-DD');
    $('#exampletablemutasipakan tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<br><input class="form-control" type="text" placeholder="Search ' + title + '" />');
    });
    //---------Tabel Point Feed----------//
    var tso = $('#exampletablemutasipakan').DataTable({
        // filter: false,
        "info": true,
        "destroy": true,
        "lengthChange": true,
        "order": [
            [0, "desc"]
        ],
        "paging": true,
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
                title: 'Mutasi Pakan ' + lokasi
            },
            {
                extend: 'pdf',
                footer: true,
                title: 'Mutasi Pakan ' + lokasi
            },
            {
                extend: 'print',
                footer: true,
                title: 'Mutasi Pakan ' + lokasi
            },
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
            'url': base_url + 'main/stock_pakan_mitra/get_data_mutasi_pakan',
            'data': {
                id_user: id_user,
            },
            "dataSrc": "",
            beforeSend: function () {
                $("#button_viewtablemutasipakan").prop('disabled', true); // disable button
                document.querySelector('#button_viewtablemutasipakan').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
            },
        },

        "columns": [{
                'data': 'tanggal'
            },
            {
                'data': 'brand'
            },
            {
                'data': 'qty'
            },
            {
                'data': 'ket'
            },
            {
                "data": 'id',
                "className": 'text-nowrap',
                "render": function (data, type, row) {
                    return `<a href="javascript:void(0);"  class="btn btn-primary btn-sm item_edit" onclick="edit_mutasi_pakan_table('` + data + `','` + row['id_user_to'] + `','` + row['brand'] + `','` + row['id_this'] + `','` + row['qty'] + `','` + row['tanggal'] + `','` + row['first_name'] + `','` + row['lokasi_dari'] + `')" data-id="` + data + `"><i class="fas fa-pencil-alt"></i>&nbsp Edit</a>
        <a href="javascript:void(0);"  class="btn btn-danger btn-sm" onclick="delete_kedatangan_mutasi_pakan(` + data + `,'stock_pakan_mitra/delete_kedatangan_pakan')"><i class="fa fa-trash"></i>&nbsp Delete</a>`;
                }
            }
        ],
        "columnDefs": [{
            "targets": '_all',
            "defaultContent": '0'
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
            $("#button_viewtablemutasipakan").prop('disabled', false); // enable button
            document.querySelector('#button_viewtablemutasipakan').innerHTML = 'Load';
            document.querySelector('#tittle_table_mutasi_pakan').innerHTML = 'Mutasi Pakan ' + lokasi;
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

            var coltosum = [2]
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

function viewtablejenispakan() {

    // var id_user = document.querySelector('#filter_lokasi').value;
    // var ss = document.getElementById("filter_lokasi");
    // var lokasi = ss.options[ss.selectedIndex].getAttribute('data-1');
    //  var tanggal_akhir = $('#input_range_tanggal').data('daterangepicker').endDate.format('YYYY-MM-DD');
    $('#exampletablejenispakan tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<br><input class="form-control" type="text" placeholder="Search ' + title + '" />');
    });
    //---------Tabel Point Feed----------//
    var tso = $('#exampletablejenispakan').DataTable({
        // filter: false,
        "info": true,
        "destroy": true,
        "lengthChange": true,
        // "order": [[ 0, "desc" ]],
        "paging": true,
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
                title: 'Jenis Pakan'
            },
            {
                extend: 'pdf',
                footer: true,
                title: 'Jenis Pakan'
            },
            {
                extend: 'print',
                footer: true,
                title: 'Jenis Pakan'
            },
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
            'url': base_url + 'main/stock_pakan_mitra/get_data_pakan',
            'data': {
                // id_user: id_user,
            },
            "dataSrc": "",
            beforeSend: function () {
                $("#button_viewtablejenispakan").prop('disabled', true); // disable button
                document.querySelector('#button_viewtablejenispakan').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
            },
        },

        "columns": [{
                'data': 'brand'
            },
            {
                "data": 'id',
                "className": 'text-nowrap',
                "render": function (data, type, row) {
                    return `<a href="javascript:void(0);"  class="btn btn-primary btn-sm item_edit" onclick="edit_jenis_pakan('` + data + `','` + row['brand'] + `')"><i class="fas fa-pencil-alt"></i>&nbsp Edit</a>`;
                }
            },
        ],
        "columnDefs": [{
            "targets": '_all',
            "defaultContent": '0'
        }],
        // "order": [[ 0, 'desc' ]],

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
            $("#button_viewtablejenispakan").prop('disabled', false); // enable button
            document.querySelector('#button_viewtablejenispakan').innerHTML = 'Load';
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

function add_pakan() {
    // var id_user = document.querySelector('#filter_lokasi').value;
    $.ajax({
        type: 'POST',
        url: base_url + 'main/stock_pakan_mitra/add_pakan',
        data: {
            brand: document.querySelector('#add_brand_pakan').value,
        },
        cache: false,
        beforeSend: function () {
            $("#add_pakan_button").prop('disabled', true); // disable button
            document.querySelector('#add_pakan_label').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
        },
        success: function (data) {
            var parsedata = JSON.parse(data);
            console.log(parsedata);
            if (parsedata.status == 'success') {
                set_flashdata('success', 'Berhasil Input Data ' + parsedata.brand);
                document.querySelector('#add_brand_pakan').value = "";
                viewtablejenispakan()
            } else {
                set_flashdata('error', 'Input Data Gagal');
            }
        },
        complete: function () {
            $("#add_pakan_button").prop('disabled', false); // enable button
            document.querySelector('#add_pakan_label').innerHTML = 'Save';
        },

    });
}

function delete_kedatangan_mutasi_pakan(id_delete, fitur) {
    // var id_user = document.querySelector('#filter_lokasi').value;
    // console.log($('#edit_kedatangan_pakan_tanggal').data('daterangepicker').startDate.format('YYYY-MM-DD'));
    Swal.fire({
        title: 'Hapus data ini ?',
        text: 'Data ini akan dihapus dari sistem, pastikan kembali anda tidak salah pencet',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Tidak',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'POST',
                url: base_url + 'main/' + fitur,
                data: {
                    id: id_delete,
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
                        set_flashdata('success', 'Berhasil Delete Data');
                        if (fitur == 'delete_kedatangan_pakan') {
                            viewtablekedatanganpakan();
                        } else if (fitur == 'delete_mutasi_pakan') {
                            viewtablemutasipakan();
                        } else if (fitur == 'delete_kedatangan_ovk') {
                            viewtablekedatanganobat();
                        } else if (fitur == 'delete_mutasi_ovk') {
                            viewtablemutasiobat();
                        }


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

function add_mutasi_pakan() {
    // var id_user = document.querySelector('#filter_lokasi').value;
    // console.log($('#add_kedatangan_pakan_tanggal').data('daterangepicker').startDate.format('YYYY-MM-DD'));
    $.ajax({
        type: 'POST',
        url: base_url + 'main/stock_pakan_mitra/add_mutasi_pakan',
        data: {
            id_lokasi_dari: document.querySelector('#add_mutasi_pakan_lokasi_dari').value,
            id_lokasi_tujuan: document.querySelector('#add_mutasi_pakan_lokasi_tujuan').value,
            id_pakan: document.querySelector('#add_mutasi_pakan_brand').value,
            tanggal: $('#add_mutasi_pakan_tanggal').data('daterangepicker').startDate.format('YYYY-MM-DD'),
            quantity: document.querySelector('#add_mutasi_pakan_qty').value,
            // keterangan :document.querySelector('#add_mutasi_pakan_ket').value,
        },
        cache: false,
        beforeSend: function () {
            $("#add_mutasi_pakan_button").prop('disabled', true); // disable button
            document.querySelector('#add_mutasi_pakan_label').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
        },
        success: function (data) {
            var parsedata = JSON.parse(data);
            console.log(parsedata);
            if (parsedata.status == 'success') {
                set_flashdata('success', 'Berhasil Input Data');
                document.querySelector('#add_mutasi_pakan_qty').value = "0";
                $('#modal_mutasi_pakan').modal('hide');
            } else {
                set_flashdata('error', 'Input Data Gagal');
            }
        },
        complete: function () {
            $("#add_mutasi_pakan_button").prop('disabled', false); // enable button
            document.querySelector('#add_mutasi_pakan_label').innerHTML = 'Save';
        },

    });
}

function edit_kedatangan_pakan() {
    // var id_user = document.querySelector('#filter_lokasi').value;
    // console.log($('#edit_kedatangan_pakan_tanggal').data('daterangepicker').startDate.format('YYYY-MM-DD'));
    $.ajax({
        type: 'POST',
        url: base_url + 'main/stock_pakan_mitra/edit_kedatangan_pakan',
        data: {
            id: document.querySelector('#edit_kedatangan_pakan_id').value,
            id_pakan: document.querySelector('#edit_kedatangan_pakan_brand').value,
            tanggal: $('#edit_kedatangan_pakan_tanggal').data('daterangepicker').startDate.format('YYYY-MM-DD'),
            quantity: document.querySelector('#edit_kedatangan_pakan_qty').value,
            keterangan: document.querySelector('#edit_kedatangan_pakan_ket').value,
        },
        cache: false,
        beforeSend: function () {
            $("#edit_kedatangan_pakan_button").prop('disabled', true); // disable button
            document.querySelector('#edit_kedatangan_pakan_label').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
        },
        success: function (data) {
            var parsedata = JSON.parse(data);
            console.log(parsedata);
            if (parsedata.status == 'success') {
                set_flashdata('success', 'Berhasil Edit Data');
                // document.querySelector('#edit_kedatangan_pakan_qty').value = "0";
                $('#edit_kedatangan_pakan_tanggal').data('daterangepicker').hide();
                document.querySelector('#edit_kedatangan_pakan_ket').value = "";
                viewtablekedatanganpakan();
                $('#modal_edit_kedatangan_pakan').modal('hide');
            } else {
                set_flashdata('error', 'Input Data Gagal');
            }
        },
        complete: function () {
            $("#edit_kedatangan_pakan_button").prop('disabled', false); // enable button
            document.querySelector('#edit_kedatangan_pakan_label').innerHTML = 'Save';
        },

    });
}

function edit_mutasi_pakan_table(id, id_user_to, brand, id_this, qty, tanggal, first_name, lokasi_dari) {
    // console.log(id+id_user_to+brand+id_this+qty+tanggal)
    modal_jenis_pakan(`#edit_mutasi_pakan_brand`, id_this, brand);
    modal_lokasi(`#edit_mutasi_pakan_lokasi_tujuan`, id_user_to, first_name);
    $('#edit_mutasi_pakan_id').val(id);
    $('#edit_mutasi_pakan_tanggal').data('daterangepicker').setStartDate(reformatDate(tanggal));
    $('#edit_mutasi_pakan_brand').val(brand);
    $('#edit_mutasi_pakan_qty').val(qty);
    $('#edit_mutasi_pakan_lokasi_dari').val(lokasi_dari);
    $('#modal_edit_mutasi_pakan').modal('show');
}

function modal_jenis_pakan(id_combo_box, value = "0", label = "Pilih Jenis Pakan") {
    var temp = "";
    var parsedata;
    $.ajax({
        method: "POST",
        url: base_url + 'main/stock_pakan_mitra/get_data_pakan',
        cache: false,
        data: {

        },
        success: function (response) {
            parsedata = JSON.parse(response);
            temp += `<option value='` + value + `'>` + label + `</option>`;
            for (var i = 0; i < parsedata.length; i++) {

                temp += `<option value='` + parsedata[i].id + `' data-1='` + parsedata[i].id + `' data-2='` + parsedata[i].id + `' data-3='` + parsedata[i].id + `'>` + parsedata[i].brand + `</option>`;
            }
            $(id_combo_box).html(temp);
            // $("#add_mutasi_pakan_brand").html(temp);
        }
    });

}

function add_kedatangan_pakan() {
    // var id_user = document.querySelector('#filter_lokasi').value;
    // console.log($('#add_kedatangan_pakan_tanggal').data('daterangepicker').startDate.format('YYYY-MM-DD'));
    $.ajax({
        type: 'POST',
        url: base_url + 'main/stock_pakan_mitra/add_kedatangan_pakan',
        data: {
            id_lokasi: document.querySelector('#add_kedatangan_pakan_lokasi').value,
            id_pakan: document.querySelector('#add_kedatangan_pakan_brand').value,
            tanggal: $('#add_kedatangan_pakan_tanggal').data('daterangepicker').startDate.format('YYYY-MM-DD'),
            quantity: document.querySelector('#add_kedatangan_pakan_qty').value,
            keterangan: document.querySelector('#add_kedatangan_pakan_ket').value,
        },
        cache: false,
        beforeSend: function () {
            $("#add_kedatangan_pakan_button").prop('disabled', true); // disable button
            document.querySelector('#add_kedatangan_pakan_label').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
        },
        success: function (data) {
            var parsedata = JSON.parse(data);
            console.log(parsedata);
            if (parsedata.status == 'success') {
                set_flashdata('success', 'Berhasil Input Data');
                document.querySelector('#add_kedatangan_pakan_qty').value = "0";
                document.querySelector('#add_kedatangan_pakan_ket').value = "";
                $('#modal_kedatangan_pakan').modal('hide');
            } else {
                set_flashdata('error', 'Input Data Gagal');
            }
        },
        complete: function () {
            $("#add_kedatangan_pakan_button").prop('disabled', false); // enable button
            document.querySelector('#add_kedatangan_pakan_label').innerHTML = 'Save';
        },

    });
}

function edit_mutasi_pakan() {
    // var id_user = document.querySelector('#filter_lokasi').value;
    // console.log($('#edit_kedatangan_pakan_tanggal').data('daterangepicker').startDate.format('YYYY-MM-DD'));
    $.ajax({
        type: 'POST',
        url: base_url + 'main/stock_pakan_mitra/edit_mutasi_pakan',
        data: {
            id: document.querySelector('#edit_mutasi_pakan_id').value,
            id_pakan: document.querySelector('#edit_mutasi_pakan_brand').value,
            tanggal: $('#edit_mutasi_pakan_tanggal').data('daterangepicker').startDate.format('YYYY-MM-DD'),
            quantity: document.querySelector('#edit_mutasi_pakan_qty').value,
            id_user_to: document.querySelector('#edit_mutasi_pakan_lokasi_tujuan').value,
            lokasi_dari: document.querySelector('#edit_mutasi_pakan_lokasi_dari').value,
        },
        cache: false,
        beforeSend: function () {
            $("#edit_mutasi_pakan_button").prop('disabled', true); // disable button
            document.querySelector('#edit_mutasi_pakan_label').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
        },
        success: function (data) {
            var parsedata = JSON.parse(data);
            console.log(parsedata);
            if (parsedata.status == 'success') {
                set_flashdata('success', 'Berhasil Edit Data');
                $('#edit_mutasi_pakan_tanggal').data('daterangepicker').hide();
                viewtablemutasipakan();
                $('#modal_edit_mutasi_pakan').modal('hide');
            } else {
                set_flashdata('error', 'Input Data Gagal');
            }
        },
        complete: function () {
            $("#edit_mutasi_pakan_button").prop('disabled', false); // enable button
            document.querySelector('#edit_mutasi_pakan_label').innerHTML = 'Save';
        },

    });
}

function edit_jenis_pakan(id, brand) {
    // console.log('here');
    $('#edit_jenis_pakan_brand').val(brand);
    $('#edit_jenis_pakan_id').val(id);
    $('#modal_edit_jenis_pakan').modal('show');
}

function edit_jenis_pakan_query() {
    // var id_user = document.querySelector('#filter_lokasi').value;
    // console.log($('#edit_kedatangan_pakan_tanggal').data('daterangepicker').startDate.format('YYYY-MM-DD'));
    $.ajax({
        type: 'POST',
        url: base_url + 'main/stock_pakan_mitra/edit_jenis_pakan',
        data: {
            id: document.querySelector('#edit_jenis_pakan_id').value,
            brand: document.querySelector('#edit_jenis_pakan_brand').value,
        },
        cache: false,
        beforeSend: function () {
            $("#edit_jenis_pakan_buton").prop('disabled', true); // disable button
            document.querySelector('#edit_jenis_pakan_label').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
        },
        success: function (data) {
            var parsedata = JSON.parse(data);
            console.log(parsedata);
            if (parsedata.status == 'success') {
                set_flashdata('success', 'Berhasil Edit Data');
                viewtablejenispakan();
                $('#modal_edit_jenis_pakan').modal('hide');
            } else {
                set_flashdata('error', 'Input Data Gagal');
            }
        },
        complete: function () {
            $("#edit_jenis_pakan_buton").prop('disabled', false); // enable button
            document.querySelector('#edit_jenis_pakan_label').innerHTML = 'Save';
        },

    });
}
$('#exampletablekedatanganpakan').on('click', '.item_edit', function () {
    var id = $(this).data('id');
    var brand = $(this).data('brand');
    var tanggal = $(this).data('tanggal');
    var qty = $(this).data('qty');
    var ket = $(this).data('ket');
    var id_this = $(this).data('id_this');
    console.log(brand);
    modal_jenis_pakan(`#edit_kedatangan_pakan_brand`, id_this, brand);
    $('#modal_edit_kedatangan_pakan').modal('show');
    $('#edit_kedatangan_pakan_id').val(id);
    // $('#edit_kedatangan_pakan_tanggal').val(tanggal);
    console.log(reformatDate(tanggal));
    $('#edit_kedatangan_pakan_tanggal').data('daterangepicker').setStartDate(reformatDate(tanggal));
    $('#edit_kedatangan_pakan_brand').val(brand);
    $('#edit_kedatangan_pakan_qty').val(qty);
    $('#edit_kedatangan_pakan_ket').val(ket);
});