function viewtablepemakaianobat() {

    var id_user = document.querySelector('#filter_lokasi').value;
    console.log(id_user);
    var ss = document.getElementById("filter_lokasi");
    var lokasi = ss.options[ss.selectedIndex].getAttribute('data-1');
    var tanggal_mulai = $('#input_range_tanggal').data('daterangepicker').startDate.format('YYYY-MM-DD');
    var tanggal_akhir = $('#input_range_tanggal').data('daterangepicker').endDate.format('YYYY-MM-DD');
    $('#exampletablepemakaianovk tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<br><input class="form-control" type="text" placeholder="Search ' + title + '" />');
    });
    //---------Tabel Point Feed----------//
    var tpf = $('#exampletablepemakaianovk').DataTable({
        // filter: false,
        "info": true,
        "destroy": true,
        "lengthChange": true,
        "order": [
            [0, "desc"]
        ],
        "paging": true,
        "pageLength": 7,
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
                title: 'Pemakaian Obat ' + lokasi + ' tanggal ' + tanggal_mulai + ' to ' + tanggal_akhir
            },
            {
                extend: 'pdf',
                footer: true,
                title: 'Pemakaian Obat ' + lokasi + ' tanggal ' + tanggal_mulai + ' to ' + tanggal_akhir
            },
            {
                extend: 'print',
                footer: true,
                title: 'Pemakaian Obat ' + lokasi + ' tanggal ' + tanggal_mulai + ' to ' + tanggal_akhir
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
            'url': base_url + 'main/stock_ovk/get_data_pemakaian_ovk',
            'data': {
                id_user: id_user,
                tanggal_mulai: tanggal_mulai,
                tanggal_akhir: tanggal_akhir,
            },
            "dataSrc": "",
            beforeSend: function () {
                $("#button_viewtablepemakaianobat").prop('disabled', true); // disable button
                document.querySelector('#button_viewtablepemakaianobat').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
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
                'data': 'qty',
                'render': function (data) {
                    console.log(data);
                    return parseFloat(data).toFixed(2);
                }
            },
            {
                'data': 'konsumsi_qty',
                'render': function (data) {
                    console.log(data);
                    return parseFloat(data).toFixed(2);
                }
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
            $("#button_viewtablepemakaianobat").prop('disabled', false); // enable button
            document.querySelector('#button_viewtablepemakaianobat').innerHTML = 'Load';
            document.querySelector('#tittle_table_pemakaian_ovk').innerHTML = 'Pemakaian OVK ' + lokasi;
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

            var coltosum = [3, 4]
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

function viewtablestockobat() {

    var id_user = document.querySelector('#filter_lokasi').value;
    var ss = document.getElementById("filter_lokasi");
    var lokasi = ss.options[ss.selectedIndex].getAttribute('data-1');
    var tanggal_akhir = $('#input_range_tanggal').data('daterangepicker').endDate.format('YYYY-MM-DD');
    $('#exampletablestockovk tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<br><input class="form-control" type="text" placeholder="Search ' + title + '" />');
    });
    //---------Tabel Point Feed----------//
    var tso = $('#exampletablestockovk').DataTable({
        // filter: false,
        "info": true,
        "destroy": true,
        "lengthChange": true,
        "order": [
            [0, "desc"]
        ],
        "paging": true,
        "pageLength": 7,
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
                title: 'Stock Obat ' + lokasi + ' tanggal ' + tanggal_akhir
            },
            {
                extend: 'pdf',
                footer: true,
                title: 'Stock Obat ' + lokasi + ' tanggal ' + tanggal_akhir
            },
            {
                extend: 'print',
                footer: true,
                title: 'Stock Obat ' + lokasi + ' tanggal ' + tanggal_akhir
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
            'url': base_url + 'main/stock_ovk/get_data_stock_ovk',
            'data': {
                id_user: id_user,
                tanggal_akhir: tanggal_akhir,
            },
            "dataSrc": "",
            beforeSend: function () {
                $("#button_viewtablestockobat").prop('disabled', true); // disable button
                document.querySelector('#button_viewtablestockobat').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
            },
        },

        "columns": [{
                'data': 'brand'
            },
            {
                'data': 'stock',
                'render': function (data) {
                    console.log(data);
                    return parseFloat(data).toFixed(2);
                }
            }, {
                'data': 'stock_qty',
                'render': function (data) {
                    console.log(data);
                    return parseFloat(data).toFixed(2);
                }
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
            $("#button_viewtablestockobat").prop('disabled', false); // enable button
            document.querySelector('#button_viewtablestockobat').innerHTML = 'Load';
            document.querySelector('#tittle_table_stock_ovk').innerHTML = 'Stock OVK ' + lokasi;
        },
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(),
                data;
            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ? parseFloat(i.replace(/[\$,]/g, '')).toFixed(2) * 1 || 0 : typeof i === 'number' ? i : 0;
            };

            var coltosum = [1, 2]
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

function viewtablekedatanganobat() {

    var id_user = document.querySelector('#filter_lokasi').value;
    var ss = document.getElementById("filter_lokasi");
    var lokasi = ss.options[ss.selectedIndex].getAttribute('data-1');
    //  var tanggal_akhir = $('#input_range_tanggal').data('daterangepicker').endDate.format('YYYY-MM-DD');
    $('#exampletablekedatanganovk tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<br><input class="form-control" type="text" placeholder="Search ' + title + '" />');
    });
    //---------Tabel Point Feed----------//
    var tso = $('#exampletablekedatanganovk').DataTable({
        // filter: false,
        "info": true,
        "destroy": true,
        "lengthChange": true,
        "order": [
            [0, "desc"]
        ],
        "paging": true,
        "pageLength": 7,
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
                title: 'Kedatangan Obat ' + lokasi
            },
            {
                extend: 'pdf',
                footer: true,
                title: 'Kedatangan Obat ' + lokasi
            },
            {
                extend: 'print',
                footer: true,
                title: 'Kedatangan Obat ' + lokasi
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
            'url': base_url + 'main/stock_ovk/get_data_kedatangan_ovk',
            'data': {
                id_user: id_user,
            },
            "dataSrc": "",
            beforeSend: function () {
                $("#button_viewtablekedatanganobat").prop('disabled', true); // disable button
                document.querySelector('#button_viewtablekedatanganobat').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
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
                        return `<a href="javascript:void(0);"  class="btn btn-primary btn-sm item_edit" data-id="` + data + `" data-brand="` + row['brand'] + `" data-quantity="` + row['quantity'] + `" data-satuan="` + row['satuan'] + `" data-ket="` + row['ket'] + `" data-qty="` + row['qty'] + `" data-tanggal="` + row['tanggal'] + `" data-id_this="` + row['id_this'] + `"><i class="fas fa-pencil-alt"></i>&nbsp Edit</a>
          <a href="javascript:void(0);"  class="btn btn-danger btn-sm" onclick="delete_kedatangan_mutasi_ovk(` + data + `,'stock_ovk/delete_kedatangan_ovk')"><i class="fa fa-trash"></i>&nbsp Delete</a>`;
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
            $("#button_viewtablekedatanganobat").prop('disabled', false); // enable button
            document.querySelector('#button_viewtablekedatanganobat').innerHTML = 'Load';
            document.querySelector('#tittle_table_kedatangan_ovk').innerHTML = 'Kedatangan OVK ' + lokasi;
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

function viewtablemutasiobat() {

    var id_user = document.querySelector('#filter_lokasi').value;
    var ss = document.getElementById("filter_lokasi");
    var lokasi = ss.options[ss.selectedIndex].getAttribute('data-1');
    //  var tanggal_akhir = $('#input_range_tanggal').data('daterangepicker').endDate.format('YYYY-MM-DD');
    $('#exampletablemutasiovk tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<br><input class="form-control" type="text" placeholder="Search ' + title + '" />');
    });
    //---------Tabel Point Feed----------//
    var tso = $('#exampletablemutasiovk').DataTable({
        // filter: false,
        "info": true,
        "destroy": true,
        "lengthChange": true,
        "order": [
            [0, "desc"]
        ],
        "paging": true,
        "pageLength": 7,
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
                title: 'Mutasi Obat ' + lokasi
            },
            {
                extend: 'pdf',
                footer: true,
                title: 'Mutasi Obat ' + lokasi
            },
            {
                extend: 'print',
                footer: true,
                title: 'Mutasi Obat ' + lokasi
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
            'url': base_url + 'main/stock_ovk/get_data_mutasi_ovk',
            'data': {
                id_user: id_user,
            },
            "dataSrc": "",
            beforeSend: function () {
                $("#button_viewtablemutasiobat").prop('disabled', true); // disable button
                document.querySelector('#button_viewtablemutasiobat').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
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
                    return `<a href="javascript:void(0);"  class="btn btn-primary btn-sm item_edit" onclick="edit_mutasi_ovk_table('` + data + `','` + row['id_user_to'] + `','` + row['brand'] + `','` + row['satuan'] + `','` + row['quantity'] + `','` + row['id_this'] + `','` + row['qty'] + `','` + row['tanggal'] + `','` + row['first_name'] + `','` + row['lokasi_dari'] + `')" data-id="` + data + `"><i class="fas fa-pencil-alt"></i>&nbsp Edit</a>
        <a href="javascript:void(0);"  class="btn btn-danger btn-sm" onclick="delete_kedatangan_mutasi_ovk(` + data + `,'stock_ovk/delete_kedatangan_ovk')"><i class="fa fa-trash"></i>&nbsp Delete</a>`;
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
            $("#button_viewtablemutasiobat").prop('disabled', false); // enable button
            document.querySelector('#button_viewtablemutasiobat').innerHTML = 'Load';
            document.querySelector('#tittle_table_mutasi_ovk').innerHTML = 'Mutasi OVK ' + lokasi;
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

function viewtablejenisobat() {

    // var id_user = document.querySelector('#filter_lokasi').value;
    // var ss = document.getElementById("filter_lokasi");
    // var lokasi = ss.options[ss.selectedIndex].getAttribute('data-1');
    //  var tanggal_akhir = $('#input_range_tanggal').data('daterangepicker').endDate.format('YYYY-MM-DD');
    $('#exampletablejenisovk tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<br><input class="form-control" type="text" placeholder="Search ' + title + '" />');
    });
    //---------Tabel Point Feed----------//
    var tso = $('#exampletablejenisovk').DataTable({
        // filter: false,
        "info": true,
        "destroy": true,
        "lengthChange": true,
        // "order": [[ 0, "desc" ]],
        "paging": true,
        "pageLength": 7,
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
                title: 'Jenis Obat'
            },
            {
                extend: 'pdf',
                footer: true,
                title: 'Jenis Obat'
            },
            {
                extend: 'print',
                footer: true,
                title: 'Jenis Obat'
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
            'url': base_url + 'main/stock_ovk/get_data_ovk',
            'data': {
                // id_user: id_user,
            },
            "dataSrc": "",
            beforeSend: function () {
                $("#button_viewtablejenisobat").prop('disabled', true); // disable button
                document.querySelector('#button_viewtablejenisobat').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
            },
        },

        "columns": [{
                'data': 'brand'
            },
            {
                'data': 'satuan'
            },
            {
                'data': 'quantity'
            },
            {
                "data": 'id',
                "className": 'text-nowrap',
                "render": function (data, type, row) {
                    return `<a href="javascript:void(0);"  class="btn btn-primary btn-sm item_edit" onclick="edit_jenis_ovk('` + data + `','` + row['brand'] + `','` + row['satuan'] + `','` + row['quantity'] + `')"><i class="fas fa-pencil-alt"></i>&nbsp Edit</a>`;
                }
            }
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
            $("#button_viewtablejenisobat").prop('disabled', false); // enable button
            document.querySelector('#button_viewtablejenisobat').innerHTML = 'Load';
            // document.querySelector('#tittle_table_mutasi_ovk').innerHTML = 'Jenis OVK';
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

function add_medicine() {
    var id_user = document.querySelector('#filter_lokasi').value;
    $.ajax({
        type: 'POST',
        url: base_url + 'main/stock_ovk/add_medicine',
        data: {
            brand: document.querySelector('#add_brand').value,
            satuan: document.querySelector('#add_satuan').value,
            quantity: document.querySelector('#add_quantity').value,
        },
        cache: false,
        beforeSend: function () {
            $("#add_medicine_button").prop('disabled', true); // disable button
            document.querySelector('#add_medicine_label').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
        },
        success: function (data) {
            var parsedata = JSON.parse(data);
            console.log(parsedata);
            if (parsedata.status == 'success') {
                set_flashdata('success', 'Berhasil Input Data ' + parsedata.brand);
                document.querySelector('#add_brand').value = "";
                document.querySelector('#add_quantity').value = "";
                viewtablejenisobat()
            } else {
                set_flashdata('error', 'Input Data Gagal');
            }
        },
        complete: function () {
            $("#add_medicine_button").prop('disabled', false); // enable button
            document.querySelector('#add_medicine_label').innerHTML = 'Save';
        },

    });
}

function modal_jenis_ovk(id_combo_box, value = "0", label = "Pilih Jenis OVK", satuan = "-", qty = "-") {
    var temp = "";
    var parsedata;
    $.ajax({
        method: "POST",
        url: base_url + 'main/stock_ovk/get_data_ovk',
        cache: false,
        data: {

        },
        success: function (response) {
            parsedata = JSON.parse(response);
            temp += `<option value='` + value + `' data-satuan='` + satuan + `' data-qty='` + qty + `'>` + label + `</option>`;
            for (var i = 0; i < parsedata.length; i++) {
                // echo "<option value='{$jenis_ovks->id}' data-satuan='{$jenis_ovks->satuan}' data-qty='{$jenis_ovks->quantity}'  data-stock='-'>{$jenis_ovks->brand}</option>";
                temp += `<option value='` + parsedata[i].id + `' data-satuan='` + parsedata[i].satuan + `' data-qty='` + parsedata[i].quantity + `' data-3='` + parsedata[i].id + `'>` + parsedata[i].brand + `</option>`;
            }
            $(id_combo_box).html(temp);
            // selectovkfunction(id_combo_box);
            // $("#add_mutasi_pakan_brand").html(temp);
        }
    });

}

function add_mutasi_ovk() {
    // var id_user = document.querySelector('#filter_lokasi').value;
    // console.log($('#add_kedatangan_pakan_tanggal').data('daterangepicker').startDate.format('YYYY-MM-DD'));
    $.ajax({
        type: 'POST',
        url: base_url + 'main/stock_ovk/add_mutasi_ovk',
        data: {
            id_lokasi_dari: document.querySelector('#add_mutasi_ovk_lokasi_dari').value,
            id_lokasi_tujuan: document.querySelector('#add_mutasi_ovk_lokasi_tujuan').value,
            id_ovk: document.querySelector('#add_mutasi_ovk_brand').value,
            tanggal: $('#add_mutasi_ovk_tanggal').data('daterangepicker').startDate.format('YYYY-MM-DD'),
            quantity: document.querySelector('#add_mutasi_ovk_qty').value,
            // keterangan :document.querySelector('#add_mutasi_pakan_ket').value,
        },
        cache: false,
        beforeSend: function () {
            $("#add_mutasi_ovk_button").prop('disabled', true); // disable button
            document.querySelector('#add_mutasi_ovk_label').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
        },
        success: function (data) {
            var parsedata = JSON.parse(data);
            console.log(parsedata);
            if (parsedata.status == 'success') {
                set_flashdata('success', 'Berhasil Input Data');
                document.querySelector('#add_mutasi_ovk_qty').value = "0";
                $('#modal_mutasi_ovk').modal('hide');
            } else {
                set_flashdata('error', 'Input Data Gagal');
            }
        },
        complete: function () {
            $("#add_mutasi_ovk_button").prop('disabled', false); // enable button
            document.querySelector('#add_mutasi_ovk_label').innerHTML = 'Save';
        },

    });
}

function edit_kedatangan_ovk() {
    $.ajax({
        type: 'POST',
        url: base_url + 'main/stock_ovk/edit_kedatangan_ovk',
        data: {
            id: document.querySelector('#edit_kedatangan_ovk_id').value,
            id_ovk: document.querySelector('#edit_kedatangan_ovk_brand').value,
            tanggal: $('#edit_kedatangan_ovk_tanggal').data('daterangepicker').startDate.format('YYYY-MM-DD'),
            quantity: document.querySelector('#edit_kedatangan_ovk_qty').value,
            keterangan: document.querySelector('#edit_kedatangan_ovk_ket').value,
        },
        cache: false,
        beforeSend: function () {
            $("#edit_kedatangan_ovk_button").prop('disabled', true); // disable button
            document.querySelector('#edit_kedatangan_ovk_label').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
        },
        success: function (data) {
            var parsedata = JSON.parse(data);
            console.log(parsedata);
            if (parsedata.status == 'success') {
                set_flashdata('success', 'Berhasil Edit Data');
                // document.querySelector('#edit_kedatangan_pakan_qty').value = "0";
                $('#edit_kedatangan_ovk_tanggal').data('daterangepicker').hide();
                document.querySelector('#edit_kedatangan_ovk_ket').value = "";
                viewtablekedatanganobat();
                $('#modal_edit_kedatangan_ovk').modal('hide');
            } else {
                set_flashdata('error', 'Input Data Gagal');
            }
        },
        complete: function () {
            $("#edit_kedatangan_ovk_button").prop('disabled', false); // enable button
            document.querySelector('#edit_kedatangan_ovk_label').innerHTML = 'Save';
        }
    });
}

function edit_mutasi_ovk() {
    // var id_user = document.querySelector('#filter_lokasi').value;
    // console.log($('#edit_kedatangan_pakan_tanggal').data('daterangepicker').startDate.format('YYYY-MM-DD'));
    $.ajax({
        type: 'POST',
        url: base_url + 'main/stock_ovk/edit_mutasi_ovk',
        data: {
            id: document.querySelector('#edit_mutasi_ovk_id').value,
            id_ovk: document.querySelector('#edit_mutasi_ovk_brand').value,
            tanggal: $('#edit_mutasi_ovk_tanggal').data('daterangepicker').startDate.format('YYYY-MM-DD'),
            quantity: document.querySelector('#edit_mutasi_ovk_qty').value,
            id_user_to: document.querySelector('#edit_mutasi_ovk_lokasi_tujuan').value,
            lokasi_dari: document.querySelector('#edit_mutasi_ovk_lokasi_dari').value,
        },
        cache: false,
        beforeSend: function () {
            $("#edit_mutasi_ovk_button").prop('disabled', true); // disable button
            document.querySelector('#edit_mutasi_ovk_label').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
        },
        success: function (data) {
            var parsedata = JSON.parse(data);
            console.log(parsedata);
            if (parsedata.status == 'success') {
                set_flashdata('success', 'Berhasil Edit Data');
                $('#edit_mutasi_ovk_tanggal').data('daterangepicker').hide();
                viewtablemutasiobat();
                $('#modal_edit_mutasi_ovk').modal('hide');
            } else {
                set_flashdata('error', 'Input Data Gagal');
            }
        },
        complete: function () {
            $("#edit_mutasi_ovk_button").prop('disabled', false); // enable button
            document.querySelector('#edit_mutasi_ovk_label').innerHTML = 'Save';
        },

    });
}

function edit_jenis_ovk_query() {
    // var id_user = document.querySelector('#filter_lokasi').value;
    // console.log($('#edit_kedatangan_pakan_tanggal').data('daterangepicker').startDate.format('YYYY-MM-DD'));
    $.ajax({
        type: 'POST',
        url: base_url + 'main/stock_ovk/edit_jenis_ovk',
        data: {
            id: document.querySelector('#edit_jenis_ovk_id').value,
            brand: document.querySelector('#edit_jenis_ovk_brand').value,
            satuan: document.querySelector('#edit_jenis_ovk_satuan').value,
            quantity: document.querySelector('#edit_jenis_ovk_qty').value,
        },
        cache: false,
        beforeSend: function () {
            $("#edit_jenis_ovk_buton").prop('disabled', true); // disable button
            document.querySelector('#edit_jenis_ovk_label').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
        },
        success: function (data) {
            var parsedata = JSON.parse(data);
            console.log(parsedata);
            if (parsedata.status == 'success') {
                set_flashdata('success', 'Berhasil Edit Data');
                viewtablejenisobat();
                $('#modal_edit_ovk').modal('hide');
            } else {
                set_flashdata('error', 'Input Data Gagal');
            }
        },
        complete: function () {
            $("#edit_jenis_ovk_buton").prop('disabled', false); // enable button
            document.querySelector('#edit_jenis_ovk_label').innerHTML = 'Save';
        },

    });
}

function delete_kedatangan_mutasi_ovk(id_delete, fitur) {
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

function edit_mutasi_ovk_table(id, id_user_to, brand, satuan, quantity, id_this, qty, tanggal, first_name, lokasi_dari) {
    // console.log(id+id_user_to+brand+id_this+qty+tanggal)
    modal_jenis_ovk(`#edit_mutasi_ovk_brand`, id_this, brand, satuan, quantity);
    modal_lokasi(`#edit_mutasi_ovk_lokasi_tujuan`, id_user_to, first_name);
    $('#edit_mutasi_ovk_id').val(id);
    $('#edit_mutasi_ovk_tanggal').data('daterangepicker').setStartDate(reformatDate(tanggal));
    $('#edit_mutasi_ovk_brand').val(brand);
    $('#edit_mutasi_ovk_qty').val(qty);
    $('#ovk_qty_mutasi_edit').val(quantity);
    $('#ovk_satuan_mutasi_edit').val(satuan);
    $('#modal_edit_mutasi_ovk').modal('show');
    $('#edit_mutasi_ovk_lokasi_dari').val(lokasi_dari);
}

function edit_jenis_ovk(id, brand, satuan, quantity) {
    // console.log('here');
    $('#edit_jenis_ovk_brand').val(brand);
    $('#edit_jenis_ovk_satuan').val(satuan).change();
    $('#edit_jenis_ovk_qty').val(quantity);
    $('#edit_jenis_ovk_id').val(id);
    $('#modal_edit_ovk').modal('show');
}

function add_kedatangan_ovk() {
    // var id_user = document.querySelector('#filter_lokasi').value;
    // console.log($('#add_kedatangan_pakan_tanggal').data('daterangepicker').startDate.format('YYYY-MM-DD'));
    $.ajax({
        type: 'POST',
        url: base_url + 'main/stock_ovk/add_kedatangan_ovk',
        data: {
            id_lokasi: document.querySelector('#add_kedatangan_ovk_lokasi').value,
            id_ovk: document.querySelector('#add_kedatangan_ovk_brand').value,
            tanggal: $('#add_kedatangan_ovk_tanggal').data('daterangepicker').startDate.format('YYYY-MM-DD'),
            quantity: document.querySelector('#add_kedatangan_ovk_qty').value,
            keterangan: document.querySelector('#add_kedatangan_ovk_ket').value,
        },
        cache: false,
        beforeSend: function () {
            $("#add_kedatangan_ovk_button").prop('disabled', true); // disable button
            document.querySelector('#add_kedatangan_ovk_label').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
        },
        success: function (data) {
            var parsedata = JSON.parse(data);
            console.log(parsedata);
            if (parsedata.status == 'success') {
                set_flashdata('success', 'Berhasil Input Data');
                document.querySelector('#add_kedatangan_ovk_qty').value = "0";
                document.querySelector('#add_kedatangan_ovk_ket').value = "";
                $('#modal_kedatangan_ovk').modal('hide');
            } else {
                set_flashdata('error', 'Input Data Gagal');
            }
        },
        complete: function () {
            $("#add_kedatangan_ovk_button").prop('disabled', false); // enable button
            document.querySelector('#add_kedatangan_ovk_label').innerHTML = 'Save';
        },

    });
}

$('#exampletablekedatanganovk').on('click', '.item_edit', function () {
    var id = $(this).data('id');
    var brand = $(this).data('brand');
    var ket = $(this).data('ket');
    var qty = $(this).data('qty');
    var tanggal = $(this).data('tanggal');
    var id_this = $(this).data('id_this');
    var satuan = $(this).data('satuan');
    var quantity = $(this).data('quantity');
    // console.log(brand);
    modal_jenis_ovk(`#edit_kedatangan_ovk_brand`, id_this, brand, satuan, quantity);
    $('#edit_kedatangan_ovk_id').val(id);
    $('#edit_kedatangan_ovk_tanggal').val(tanggal);
    console.log(reformatDate(tanggal));
    $('#edit_kedatangan_ovk_tanggal').data('daterangepicker').setStartDate(reformatDate(tanggal));
    // $('#edit_kedatangan_ovk_brand').val(brand);
    $('#edit_kedatangan_ovk_qty').val(qty);
    $('#edit_kedatangan_ovk_ket').val(ket);
    $('#ovk_qty_edit').val(quantity);
    $('#ovk_satuan_edit').val(satuan);
    $('#modal_edit_kedatangan_ovk').modal('show');
    // selectovkfunction("edit_kedatangan_ovk_brand");
});

function selectovkfunction(fitur) {
    console.log(fitur);
    var ss = document.getElementById(fitur);
    var ovksatuan = ss.options[ss.selectedIndex].getAttribute('data-satuan');
    var ovkqty = ss.options[ss.selectedIndex].getAttribute('data-qty');
    if (fitur == "add_kedatangan_ovk_brand") {
        document.getElementById("ovk_satuan").value = ovksatuan;
        document.getElementById("ovk_qty").value = ovkqty;
    } else if (fitur == "edit_kedatangan_ovk_brand") {
        document.getElementById("ovk_satuan_edit").value = ovksatuan;
        document.getElementById("ovk_qty_edit").value = ovkqty;
    } else if (fitur == "add_mutasi_ovk_brand") {
        document.getElementById("ovk_satuan_mutasi").value = ovksatuan;
        document.getElementById("ovk_qty_mutasi").value = ovkqty;
    } else if (fitur == "edit_mutasi_ovk_brand") {
        document.getElementById("ovk_satuan_mutasi_edit").value = ovksatuan;
        document.getElementById("ovk_qty_mutasi_edit").value = ovkqty;
    }
}