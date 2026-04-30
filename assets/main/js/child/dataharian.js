function dataharian() {
    const outputdataharian = $("#outputdataharian");
    if (outputdataharian.html() == "") {
        $.ajax({
            method: "POST",
            data: {
                user_id: useridfinal,
                token: tokenfinal,
                kandangperiode: idkandangperiode
            },
            url: base_url + 'ajax/dataharian/',
            cache: false,
            beforeSend: function () {
                outputdataharian.html(loadingnih());
            },
            success: function (response) {
                outputdataharian.html(response);
                getdataharian();
                getdataharianpakan();
                getdataharianovk();
                getdatahariangeneral();
            }
        });

    }
}

function getdataharian() {
    var tabledataharian = $('#tabledataharian').DataTable({
        "destroy": true,
        "filter": true,
        "info": true,
        // "destroy": true,
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
            text: 'Export Excel',
            className: 'btn btn-primary btn-sm',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16], // Kolom 1, 2, 3, 4 dan 5 akan disertakan dalam ekspor

            },
        }],
        "ajax": {
            'type': 'POST',
            'url': api_url + 'api/ternak2/dataharian',
            'data': {
                kandangperiode: idkandangperiode,
                token: tokenfinal
            },
            "dataSrc": "",
            beforeSend: function () {
                // $("#button_viewtablestockobat").prop('disabled', true); // disable button
                // document.querySelector('#button_viewtablestockobat').innerHTML = '<span class='spinner'border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
            },
        },
        "columns": [{
                'data': 'tanggal'
            },
            {
                'data': 'umur'
            },
            {
                'data': 'mati'
            },
            {
                'data': 'culling'
            },
            {
                'data': 'populasi'
            },
            {
                'data': 'bw'
            },
            {
                'data': 'std_bw'
            },
            {
                'data': 'qty_feed'
            },
            {
                'data': 'act_feed_intake'
            },
            {
                'data': 'std_feed_intake'
            },
            {
                'data': 'act_fcr'
            },
            {
                'data': 'std_fcr'
            },
            {
                'data': 'act_adg'
            },
            {
                'data': 'std_adg'
            },
            {
                'data': 'water'
            },
            {
                'data': 'cv'
            },
            {
                'data': 'uniformity'
            },
            {
                "data": 'id',
                "className": 'text-nowrap',
                "render": function (data, type, row) {
                    var return_result = `<!--<div class="btn-group" role="group" aria-label="Basic example">-->
                                            <a href='javascript:void(0);' class='btn btn-primary btn-edit  btn-sm' ><i class="far fa-edit"></i></a>        
                                            <a href='javascript:void(0);' class='btn btn-danger btn-hapus  btn-sm' ><i class='fa fa-trash'></i></a>
                                        <!--</div>-->
                                        `;
                    return return_result;
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
            // $("#button_viewtablelistuser").prop('disabled', false); // enable button
            // document.querySelector('#button_viewtablelistuser').innerHTML = 'Load';
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
    $('#tabledataharian tbody').on('click', '.btn-edit', function () {
        var dataedit = tabledataharian.row($(this).parents('tr')).data();
        modaleditdataharianshow(dataedit);
    });
    $('#tabledataharian tbody').on('click', '.btn-hapus', function () {
        var datahapus = tabledataharian.row($(this).parents('tr')).data();
        // console.log(datahapus)
        const buttonconfirm = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })
        buttonconfirm.fire({
            title: 'Apakah anda yakin hapus data tanggal ' + datahapus.tanggal + ' ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Jangan',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "POST",
                    data: {
                        token: tokenfinal,
                        id: datahapus.id
                    },
                    url: api_url + 'api/ternak2/hapusdataharian/',
                    cache: false,
                    success: function (response) {
                        output = JSON.parse(response);
                        set_flashdata('success', output.message);
                        $("#tabledataharian").DataTable().ajax.reload();
                    }
                });
            }
        })
    });
}

function getdataharianpakan() {
    $('#tabledataharianpakan tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<br><input class="form-control" type="text" placeholder="Search ' + title + '" />');
    });
    var tabledataharianpakan = $('#tabledataharianpakan').DataTable({
        "destroy": true,
        "filter": true,
        "info": true,
        // "destroy": true,
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
        // dom: '<"top"B>rt<"bottom"ilp><"clear">',
        buttons: [{
                extend: 'excel',
                footer: true,
                title: 'Tabel'
            },
            {
                extend: 'pdf',
                footer: true,
                title: 'Tabel'
            },
            {
                extend: 'print',
                footer: true,
                title: 'Tabel'
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
            'url': api_url + 'api/ternak2/dataharianpakan',
            'data': {
                kandangperiode: idkandangperiode,
                token: tokenfinal
            },
            "dataSrc": "",
            beforeSend: function () {
                // $("#button_viewtablestockobat").prop('disabled', true); // disable button
                // document.querySelector('#button_viewtablestockobat').innerHTML = '<span class='spinner'border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
            },
        },
        "columns": [{
                'data': 'tanggal'
            },
            {
                'data': 'umur'
            },
            {
                'data': 'jenis'
            },
            {
                'data': 'qty'
            },
            {
                "data": 'id',
                "className": 'text-nowrap',
                "render": function (data, type, row) {
                    var return_result = `<!--<div class="btn-group" role="group" aria-label="Basic example">-->
                                            <a href='javascript:void(0);' class='btn btn-primary btn-edit  btn-sm' ><i class="far fa-edit"></i></a>        
                                            <a href='javascript:void(0);' class='btn btn-danger btn-hapus  btn-sm' ><i class='fa fa-trash'></i></a>
                                         <!--</div>-->
                                        `;
                    return return_result;
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
            // $("#button_viewtablelistuser").prop('disabled', false); // enable button
            // document.querySelector('#button_viewtablelistuser').innerHTML = 'Load';
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
    $('#tabledataharianpakan tbody').on('click', '.btn-edit', function () {
        var dataedit = tabledataharianpakan.row($(this).parents('tr')).data();
        modaleditpakanharianshow(dataedit);
    });
    $('#tabledataharianpakan tbody').on('click', '.btn-hapus', function () {
        var datahapus = tabledataharianpakan.row($(this).parents('tr')).data();
        // console.log(tabledataharianpakan.row($(this).parents('tr')).data());
        const buttonconfirm = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })
        buttonconfirm.fire({
            title: 'Apakah anda yakin hapus ' + datahapus.jenis + ' jumlah ' + datahapus.qty + ' tanggal ' + datahapus.tanggal + ' ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Jangan',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "POST",
                    data: {
                        token: tokenfinal,
                        id: datahapus.id
                    },
                    url: api_url + 'api/ternak2/hapuskonsumsiharian/',
                    cache: false,
                    success: function (response) {
                        output = JSON.parse(response);
                        set_flashdata('success', output.message);
                        $("#tabledataharianpakan").DataTable().ajax.reload();
                    }
                });
            }
        })
    });
}

function getdataharianovk() {
    $('#tabledataharianovk tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<br><input class="form-control" type="text" placeholder="Search ' + title + '" />');
    });
    var tabledataharianovk = $('#tabledataharianovk').DataTable({
        "destroy": true,
        "filter": true,
        "info": true,
        // "destroy": true,
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
        // dom: '<"top"B>rt<"bottom"ilp><"clear">',
        buttons: [{
                extend: 'excel',
                footer: true,
                title: 'Tabel'
            },
            {
                extend: 'pdf',
                footer: true,
                title: 'Tabel'
            },
            {
                extend: 'print',
                footer: true,
                title: 'Tabel'
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
            'url': api_url + 'api/ternak2/dataharianovk',
            'data': {
                kandangperiode: idkandangperiode,
                token: tokenfinal
            },
            "dataSrc": "",
            beforeSend: function () {
                // $("#button_viewtablestockobat").prop('disabled', true); // disable button
                // document.querySelector('#button_viewtablestockobat').innerHTML = '<span class='spinner'border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
            },
        },
        "columns": [{
                'data': 'tanggal'
            },
            {
                'data': 'umur'
            },
            {
                'data': 'jenis'
            },
            {
                'data': 'qty'
            },
            {
                "data": 'id',
                "className": 'text-nowrap',
                "render": function (data, type, row) {
                    var return_result = `<!--<div class="btn-group" role="group" aria-label="Basic example">-->
                                            <a href='javascript:void(0);' class='btn btn-primary btn-edit  btn-sm' ><i class="far fa-edit"></i></a>        
                                            <a href='javascript:void(0);' class='btn btn-danger btn-hapus  btn-sm' ><i class='fa fa-trash'></i></a>
                                        <!--</div>-->
                                        `;
                    return return_result;
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
            // $("#button_viewtablelistuser").prop('disabled', false); // enable button
            // document.querySelector('#button_viewtablelistuser').innerHTML = 'Load';
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
    $('#tabledataharianovk tbody').on('click', '.btn-edit', function () {
        var dataedit = tabledataharianovk.row($(this).parents('tr')).data();
        modaleditovkharianshow(dataedit);
    });
    $('#tabledataharianovk tbody').on('click', '.btn-hapus', function () {
        var datahapus = tabledataharianovk.row($(this).parents('tr')).data();
        // console.log(datahapus)
        const buttonconfirm = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })
        buttonconfirm.fire({
            title: 'Apakah anda yakin hapus ' + datahapus.jenis + ' jumlah ' + datahapus.qty + ' tanggal ' + datahapus.tanggal + ' ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Jangan',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "POST",
                    data: {
                        token: tokenfinal,
                        id: datahapus.id
                    },
                    url: api_url + 'api/ternak2/hapuskonsumsiharian/',
                    cache: false,
                    success: function (response) {
                        output = JSON.parse(response);
                        set_flashdata('success', output.message);
                        $("#tabledataharianovk").DataTable().ajax.reload();
                    }
                });
            }
        })
    });

}

function getdatahariangeneral() {
    $('#tabledatahariangeneral tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<br><input class="form-control" type="text" placeholder="Search ' + title + '" />');
    });
    var tabledatahariangeneral = $('#tabledatahariangeneral').DataTable({
        "destroy": true,
        "filter": true,
        "info": true,
        // "destroy": true,
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
        // dom: '<"top"B>rt<"bottom"ilp><"clear">',
        buttons: [{
                extend: 'excel',
                footer: true,
                title: 'Tabel'
            },
            {
                extend: 'pdf',
                footer: true,
                title: 'Tabel'
            },
            {
                extend: 'print',
                footer: true,
                title: 'Tabel'
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
            'url': api_url + 'api/ternak2/datahariangeneral',
            'data': {
                kandangperiode: idkandangperiode,
                token: tokenfinal
            },
            "dataSrc": "",
            beforeSend: function () {
                // $("#button_viewtablestockobat").prop('disabled', true); // disable button
                // document.querySelector('#button_viewtablestockobat').innerHTML = '<span class='spinner'border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
            },
        },
        "columns": [{
                'data': 'tanggal'
            },
            {
                'data': 'umur'
            },
            {
                'data': 'jenis'
            },
            {
                'data': 'qty'
            },
            {
                "data": 'id',
                "className": 'text-nowrap',
                "render": function (data, type, row) {
                    var return_result = `<!--<div class="btn-group" role="group" aria-label="Basic example">-->
                                            <a href='javascript:void(0);' class='btn btn-primary btn-edit  btn-sm' ><i class="far fa-edit"></i></a>        
                                            <a href='javascript:void(0);' class='btn btn-danger btn-hapus  btn-sm' ><i class='fa fa-trash'></i></a>
                                        <!--</div>-->
                                        `;
                    return return_result;
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
            // $("#button_viewtablelistuser").prop('disabled', false); // enable button
            // document.querySelector('#button_viewtablelistuser').innerHTML = 'Load';
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
    $('#tabledatahariangeneral tbody').on('click', '.btn-edit', function () {
        var dataedit = tabledatahariangeneral.row($(this).parents('tr')).data();
        modaleditgeneralharianshow(dataedit);
    });
    $('#tabledatahariangeneral tbody').on('click', '.btn-hapus', function () {
        var datahapus = tabledatahariangeneral.row($(this).parents('tr')).data();
        // console.log(datahapus)
        const buttonconfirm = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })
        buttonconfirm.fire({
            title: 'Apakah anda yakin hapus ' + datahapus.jenis + ' jumlah ' + datahapus.qty + ' tanggal ' + datahapus.tanggal + ' ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Jangan',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "POST",
                    data: {
                        token: tokenfinal,
                        id: datahapus.id
                    },
                    url: api_url + 'api/ternak2/hapuskonsumsiharian/',
                    cache: false,
                    success: function (response) {
                        output = JSON.parse(response);
                        set_flashdata('success', output.message);
                        $("#tabledatahariangeneral").DataTable().ajax.reload();
                    }
                });
            }
        })
    });
}

function modaleditpakanharianshow(data) {
    const dateinput = new Date().toLocaleDateString('en-US', {
        timeZone: 'Asia/Jakarta'
    });
    console.log(data);
    var type_input = $("#type_input");
    var id_data = $("#id_data_pakanharian");
    var jenispakan;
    var qty;
    if (data) {
        $("#headerpakanharian").text("Edit Pakan Harian");
        $("#tanggal_pakanharian").val(data.tanggal);
        $("#inputpakanqty_pakanharian").val(data.qty);
        jenispakan = data.jenis;
        qty = data.qty;
        type_input.val("edit");
        id_data.val(data.id);
        // $("#kt_modal_new_address_cancel").hide();
    } else {
        $("#headerpakanharian").text("Tambah Pakan Harian");
        $("#tanggal_pakanharian").val(formatDate(dateinput));
        $("#inputpakanqty_pakanharian").val("");
        jenispakan = false;
        qty = false;
        type_input.val("tambah");
        id_data.val("");
        // $("#kt_modal_new_address_cancel").show();
    }
    $("#modalpakanharian").modal('show');
    $.ajax({
        method: 'POST',
        url: api_url + 'kandang/jenispakanstock',
        data: {
            token: tokenfinal,
            kandangperiode: idkandangperiode
        },
        success: function (response) {
            dataraw = JSON.parse(response);
            var r;
            for (let i = 0; i < dataraw.length; i++) {
                if (jenispakan !== false) {
                    if (dataraw[i].brand == jenispakan) {
                        dataraw[i].qty_stok = parseFloat(dataraw[i].qty_stok) + parseFloat(qty);
                        r += dataraw[i].qty_stok != 0 ? `<option value="` + dataraw[i].id + `" data-stock="` + dataraw[i].qty_stok + `" selected>` + dataraw[i].brand + `</option>` : "";
                    } else {
                        r += dataraw[i].qty_stok != 0 ? `<option value="` + dataraw[i].id + `" data-stock="` + dataraw[i].qty_stok + `">` + dataraw[i].brand + `</option>` : "";
                    }
                } else {
                    r += dataraw[i].qty_stok != 0 ? `<option value="` + dataraw[i].id + `" data-stock="` + dataraw[i].qty_stok + `">` + dataraw[i].brand + `</option>` : "";
                }
            }
            $("#selectjenispakan_pakanharian").html(r);
            pakanharianselectfun();
        },
    });
}

function pakanharianselectfun() {
    var ss = document.getElementById("selectjenispakan_pakanharian");
    // var ovksatuan = ss.options[ss.selectedIndex].getAttribute('data-satuan');
    // var ovkqty = ss.options[ss.selectedIndex].getAttribute('data-qty');
    var qty_stock = ss.options[ss.selectedIndex].getAttribute('data-stock');
    // document.getElementById("inputovksatuan").value = ovksatuan;
    // document.getElementById("inputovkqtytersedia").value = ovkqty;
    document.getElementById("qty_stock_pakanharian").value = qty_stock;
}

function validateqtypakanharian(value) {
    let values, qtytersedia;
    values = value;
    qtytersedia = parseInt($("#qty_stock_pakanharian").val());
    if (isNaN(qtytersedia)) {
        set_flashdata('error', "Pastikan anda memilih jenis ovk");
        $("#inputpakanqty_pakanharian").val("");
    } else {
        if (values > qtytersedia) {
            set_flashdata('error', "Qty anda melebihi dari qty tersedia.");
            $("#inputpakanqty_pakanharian").val("");
        }
    }
}

function inputpakanharian() {
    var dataformnya = new FormData();
    var qty = $("#inputpakanqty_pakanharian").val() == "" ? return_set_flashdata("error", "Qty tidak boleh kosong") : $("#inputpakanqty_pakanharian").val();
    if (qty !== false) {
        dataformnya.append('qty', qty);
    } else {
        return;
    }

    dataformnya.append('tanggal_kandang_activity_log', $("#tanggal_pakanharian").val());
    dataformnya.append('id_this', $("#selectjenispakan_pakanharian").val());
    dataformnya.append('id_user', user_idjs);
    dataformnya.append('token', tokenfinal);
    dataformnya.append('type_input', $("#type_input").val());
    dataformnya.append('idkandangperiode', idkandangperiode);
    dataformnya.append('id', $("#id_data_pakanharian").val());
    dataformnya.append('method_sapronak', 'use');
    dataformnya.append('type_sapronak', 'pakan');
    $.ajax({
        type: 'POST',
        url: api_url + 'api/ternak2/inputkonsumsiharian',
        data: dataformnya,
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            outputjson = JSON.parse(response);
            if (outputjson.status == true) {
                set_flashdata('success', outputjson.message);
            } else {
                set_flashdata('error', outputjson.message);
            }
            //Clear Modal Input ovk
            $("#inputpakanqty_pakanharian").val("");
            $("#modalpakanharian").modal("hide");
            $("#tabledataharianpakan").DataTable().ajax.reload();
            //End Clear Modal Input ovk
        },
    });
}

function modaleditovkharianshow(data) {
    const dateinput = new Date().toLocaleDateString('en-US', {
        timeZone: 'Asia/Jakarta'
    });
    console.log(data);
    var type_input = $("#type_input_ovk");
    var id_data = $("#id_data_ovkharian");
    var jenisovk;
    var qty;
    if (data) {
        $("#headerovkharian").text("Edit OVK Harian");
        $("#tanggal_ovkharian").val(data.tanggal);
        $("#inputovkqty_ovkharian").val(data.qty);
        jenisovk = data.jenis;
        qty = data.qty;
        type_input.val("edit");
        id_data.val(data.id);
        // $("#kt_modal_new_address_cancel").hide();
    } else {
        $("#headerovkharian").text("Tambah OVK Harian");
        $("#tanggal_ovkharian").val(formatDate(dateinput));
        $("#inputovkqty_ovkharian").val("");
        jenisovk = false;
        qty = false;
        type_input.val("tambah");
        id_data.val("");
        // $("#kt_modal_new_address_cancel").show();
    }
    $("#modalovkharian").modal('show');
    $.ajax({
        method: 'POST',
        url: api_url + 'kandang/jenisovkstock',
        data: {
            token: tokenfinal,
            kandangperiode: idkandangperiode
        },
        success: function (response) {
            dataraw = JSON.parse(response);
            var r;
            for (let i = 0; i < dataraw.length; i++) {
                if (jenisovk !== false) {
                    if (dataraw[i].brand == jenisovk) {
                        dataraw[i].qty_stok = parseFloat(dataraw[i].qty_stok) + parseFloat(qty);
                        r += dataraw[i].qty_stok != 0 ? `<option value="` + dataraw[i].id + `" data-stock="` + dataraw[i].qty_stok + `" selected>` + dataraw[i].brand + `</option>` : "";
                    } else {
                        r += dataraw[i].qty_stok != 0 ? `<option value="` + dataraw[i].id + `" data-stock="` + dataraw[i].qty_stok + `">` + dataraw[i].brand + `</option>` : "";
                    }
                } else {
                    r += dataraw[i].qty_stok != 0 ? `<option value="` + dataraw[i].id + `" data-stock="` + dataraw[i].qty_stok + `">` + dataraw[i].brand + `</option>` : "";
                }
            }
            $("#selectjenisovk_ovkharian").html(r);
            ovkharianselectfun();
        },
    });
}

function ovkharianselectfun() {
    var ss = document.getElementById("selectjenisovk_ovkharian");
    // var ovksatuan = ss.options[ss.selectedIndex].getAttribute('data-satuan');
    // var ovkqty = ss.options[ss.selectedIndex].getAttribute('data-qty');
    var qty_stock = ss.options[ss.selectedIndex].getAttribute('data-stock');
    // document.getElementById("inputovksatuan").value = ovksatuan;
    // document.getElementById("inputovkqtytersedia").value = ovkqty;
    document.getElementById("qty_stock_ovkharian").value = qty_stock;
}

function validateqtyovkharian(value) {
    let values, qtytersedia;
    values = value;
    qtytersedia = parseInt($("#qty_stock_ovkharian").val());
    if (isNaN(qtytersedia)) {
        set_flashdata('error', "Pastikan anda memilih jenis ovk");
        $("#inputovkqty_ovkharian").val("");
    } else {
        if (values > qtytersedia) {
            set_flashdata('error', "Qty anda melebihi dari qty tersedia.");
            $("#inputovkqty_ovkharian").val("");
        }
    }
}

function inputovkharian() {
    var dataformnya = new FormData();
    var qty = $("#inputovkqty_ovkharian").val() == "" ? return_set_flashdata("error", "Qty tidak boleh kosong") : $("#inputovkqty_ovkharian").val();
    if (qty !== false) {
        dataformnya.append('qty', qty);
    } else {
        return;
    }

    dataformnya.append('tanggal_kandang_activity_log', $("#tanggal_ovkharian").val());
    dataformnya.append('id_this', $("#selectjenisovk_ovkharian").val());
    dataformnya.append('id_user', user_idjs);
    dataformnya.append('token', tokenfinal);
    dataformnya.append('type_input', $("#type_input_ovk").val());
    dataformnya.append('idkandangperiode', idkandangperiode);
    dataformnya.append('id', $("#id_data_ovkharian").val());
    dataformnya.append('method_sapronak', 'use');
    dataformnya.append('type_sapronak', 'ovk');
    $.ajax({
        type: 'POST',
        url: api_url + 'api/ternak2/inputkonsumsiharian',
        data: dataformnya,
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            outputjson = JSON.parse(response);
            if (outputjson.status == true) {
                set_flashdata('success', outputjson.message);
            } else {
                set_flashdata('error', outputjson.message);
            }
            //Clear Modal Input ovk
            $("#inputovkqty_ovkharian").val("");
            $("#modalovkharian").modal("hide");
            $("#tabledataharianovk").DataTable().ajax.reload();
            //End Clear Modal Input ovk
        },
    });
}

function modaleditgeneralharianshow(data) {
    const dateinput = new Date().toLocaleDateString('en-US', {
        timeZone: 'Asia/Jakarta'
    });
    console.log(data);
    var type_input = $("#type_input_general");
    var id_data = $("#id_data_generalharian");
    var jenisgeneral;
    var qty;
    if (data) {
        $("#headergeneralharian").text("Edit General Harian");
        $("#tanggal_generalharian").val(data.tanggal);
        $("#inputgeneralqty_generalharian").val(data.qty);
        jenisgeneral = data.jenis;
        qty = data.qty;
        type_input.val("edit");
        id_data.val(data.id);
        // $("#kt_modal_new_address_cancel").hide();
    } else {
        $("#headergeneralharian").text("Tambah General Harian");
        $("#tanggal_generalharian").val(formatDate(dateinput));
        $("#inputgeneralqty_generalharian").val("");
        jenisgeneral = false;
        qty = false;
        type_input.val("tambah");
        id_data.val("");
        // $("#kt_modal_new_address_cancel").show();
    }
    $("#modalgeneralharian").modal('show');
    $.ajax({
        method: 'POST',
        url: api_url + 'kandang/jenisgeneralstock',
        data: {
            token: tokenfinal,
            kandangperiode: idkandangperiode
        },
        success: function (response) {
            dataraw = JSON.parse(response);
            var r;
            for (let i = 0; i < dataraw.length; i++) {
                if (jenisgeneral !== false) {
                    if (dataraw[i].brand == jenisgeneral) {
                        dataraw[i].qty_stok = parseFloat(dataraw[i].qty_stok) + parseFloat(qty);
                        r += dataraw[i].qty_stok != 0 ? `<option value="` + dataraw[i].id + `" data-stock="` + dataraw[i].qty_stok + `" selected>` + dataraw[i].brand + `</option>` : "";
                    } else {
                        r += dataraw[i].qty_stok != 0 ? `<option value="` + dataraw[i].id + `" data-stock="` + dataraw[i].qty_stok + `">` + dataraw[i].brand + `</option>` : "";
                    }
                } else {
                    r += dataraw[i].qty_stok != 0 ? `<option value="` + dataraw[i].id + `" data-stock="` + dataraw[i].qty_stok + `">` + dataraw[i].brand + `</option>` : "";
                }
            }
            $("#selectjenisgeneral_generalharian").html(r);
            generalharianselectfun();
        },
    });
}

function generalharianselectfun() {
    var ss = document.getElementById("selectjenisgeneral_generalharian");
    // var ovksatuan = ss.options[ss.selectedIndex].getAttribute('data-satuan');
    // var ovkqty = ss.options[ss.selectedIndex].getAttribute('data-qty');
    var qty_stock = ss.options[ss.selectedIndex].getAttribute('data-stock');
    // document.getElementById("inputovksatuan").value = ovksatuan;
    // document.getElementById("inputovkqtytersedia").value = ovkqty;
    document.getElementById("qty_stock_generalharian").value = qty_stock;
}

function validateqtygeneralharian(value) {
    let values, qtytersedia;
    values = value;
    qtytersedia = parseInt($("#qty_stock_generalharian").val());
    if (isNaN(qtytersedia)) {
        set_flashdata('error', "Pastikan anda memilih jenis ovk");
        $("#inputgeneralqty_generalharian").val("");
    } else {
        if (values > qtytersedia) {
            set_flashdata('error', "Qty anda melebihi dari qty tersedia.");
            $("#inputgeneralqty_generalharian").val("");
        }
    }
}

function inputgeneralharian() {
    var dataformnya = new FormData();
    var qty = $("#inputgeneralqty_generalharian").val() == "" ? return_set_flashdata("error", "Qty tidak boleh kosong") : $("#inputgeneralqty_generalharian").val();
    if (qty !== false) {
        dataformnya.append('qty', qty);
    } else {
        return;
    }

    dataformnya.append('tanggal_kandang_activity_log', $("#tanggal_generalharian").val());
    dataformnya.append('id_this', $("#selectjenisgeneral_generalharian").val());
    dataformnya.append('id_user', user_idjs);
    dataformnya.append('token', tokenfinal);
    dataformnya.append('type_input', $("#type_input_general").val());
    dataformnya.append('idkandangperiode', idkandangperiode);
    dataformnya.append('id', $("#id_data_generalharian").val());
    dataformnya.append('method_sapronak', 'use');
    dataformnya.append('type_sapronak', 'general');
    $.ajax({
        type: 'POST',
        url: api_url + 'api/ternak2/inputkonsumsiharian',
        data: dataformnya,
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            outputjson = JSON.parse(response);
            if (outputjson.status == true) {
                set_flashdata('success', outputjson.message);
            } else {
                set_flashdata('error', outputjson.message);
            }
            //Clear Modal Input ovk
            $("#inputgeneralqty_generalharian").val("");
            $("#modalgeneralharian").modal("hide");
            $("#tabledatahariangeneral").DataTable().ajax.reload();
            //End Clear Modal Input ovk
        },
    });
}

function modaleditdataharianshow(data) {
    const dateinput = new Date().toLocaleDateString('en-US', {
        timeZone: 'Asia/Jakarta'
    });
    console.log(data);
    var type_input = $("#type_input_dataharian");
    var id_data = $("#id_data_dataharian");
    if (data) {
        $("#headerdataharian").text("Edit Data Laporan Harian");
        $("#tanggal_dataharian").val(data.tanggal);
        $("#input_dataharian_mati").val(data.mati);
        $("#input_dataharian_culling").val(data.culling);
        $("#input_dataharian_bw").val(data.bw);
        $("#input_dataharian_water").val(data.water);
        $("#input_dataharian_cv").val(data.cv);
        $("#input_dataharian_uniformity").val(data.uniformity);
        type_input.val("edit");
        id_data.val(data.id);
    } else {
        $("#headerdataharian").text("Tambah Data Laporan Harian");
        $("#tanggal_dataharian").val(formatDate(dateinput));
        $("#input_dataharian_mati").val("");
        $("#input_dataharian_culling").val("");
        $("#input_dataharian_bw").val("");
        $("#input_dataharian_water").val("");
        $("#input_dataharian_cv").val("");
        $("#input_dataharian_uniformity").val("");
        type_input.val("tambah");
        id_data.val("");
    }
    $("#modaldataharian").modal('show');
}

function inputdataharian() {
    var dataformnya = new FormData();
    var total_mati = parseInt($("#input_dataharian_mati").val()) + parseInt($("#input_dataharian_culling").val());

    dataformnya.append('token', tokenfinal);
    dataformnya.append('id_user', user_idjs);
    dataformnya.append('idkandangperiode', idkandangperiode);
    dataformnya.append('tanggal', $("#tanggal_dataharian").val());
    dataformnya.append('mati', $("#input_dataharian_mati").val());
    dataformnya.append('culling', $("#input_dataharian_culling").val());
    dataformnya.append('bw', $("#input_dataharian_bw").val());
    dataformnya.append('total_mati', total_mati);
    dataformnya.append('cv', $("#input_dataharian_cv").val());
    dataformnya.append('uniformity', $("#input_dataharian_uniformity").val());
    dataformnya.append('id', $("#id_data_dataharian").val());
    dataformnya.append('type_input', $("#type_input_dataharian").val());
    $.ajax({
        type: 'POST',
        url: api_url + 'api/ternak2/inputdataharian',
        data: dataformnya,
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            outputjson = JSON.parse(response);
            if (outputjson.status == true) {
                set_flashdata('success', outputjson.message);
            } else {
                set_flashdata('error', outputjson.message);
            }
            //Clear Modal Input ovk
            $("#modaldataharian").modal("hide");
            $("#tabledataharian").DataTable().ajax.reload();
            //End Clear Modal Input ovk
        },
    });
}