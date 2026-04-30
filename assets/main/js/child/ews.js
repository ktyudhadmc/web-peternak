async function ews() {
    const outputews = $("#outputews");
    if (outputews.html() == "" || !datajson) {
        $.ajax({
            method: "POST",
            data: {
                user_id: useridfinal,
                token: tokenfinal,
                kandangperiode: idkandangperiode
            },
            url: base_url + 'ajax/ews/',
            cache: false,
            beforeSend: function () {
                outputews.html(loadingnih());
            },
            success: function (response) {
                if (!datajson) {
                    outputews.html(loadingnih());
                    ews();
                } else {
                    outputews.html(response);
                    ews_kematian();
                    ews_bw();
                }
            }
        });
    }
}

function ews_kematian() {
    var data_ews_kematian = [];
    for (let i = 0; i < datajson.length; i++) {
        let obj = {
            tanggal: datajson[i]['tanggal'],
            umur: datajson[i]['umur'],
            nilai: datajson[i]['total_mati'],
            ket: datajson[i]['ket_ews_mati'],
            id_ket: datajson[i]['id_ews_mati'],
            type_ews: 'mati',
        }
        if (datajson[i]['ews_mati']) {
            data_ews_kematian.push(obj);
        }
    }
    var tabledataewskematian = $('#tabledataewskematian').DataTable({
        // "destroy": true,
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
        "data": data_ews_kematian,
        "columns": [{
                'data': 'tanggal'
            },
            {
                'data': 'umur'
            },
            {
                'data': 'nilai'
            },
            {
                "data": 'ket',
                "className": 'text-nowrap',
                "render": function (data, type, row) {
                    if (data) {
                        var return_result = data;
                    } else {
                        var return_result = `-`;
                    }
                    return return_result;
                }
            },
            {
                "data": 'id_ket',
                "className": 'text-nowrap',
                "render": function (data, type, row) {
                    var return_result = `<div class="btn-group" role="group" aria-label="Basic example">
                                            <a href='javascript:void(0);' class='btn btn-primary btn-edit  btn-sm' ><i class="far fa-edit"></i></a>    
                                        </div>
                                        `;
                    return return_result;
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
    // tabledataewskematian.buttons('.export').remove();
    var buttontabledataewskematian = new $.fn.dataTable.Buttons(tabledataewskematian, {
        buttons: [{
                extend: 'excel',
                footer: true,
                title: 'Tabel EWS Kematian'
            },
            {
                extend: 'pdf',
                footer: true,
                title: 'Tabel EWS Kematian'
            },
            {
                extend: 'print',
                footer: true,
                title: 'Tabel EWS Kematian'
            },
        ]
    }).container().appendTo($('#buttonewskematian'));
    console.log(buttontabledataewskematian);
    $('#tabledataewskematian tbody').on('click', '.btn-edit', function () {
        var dataedit = tabledataewskematian.row($(this).parents('tr')).data();
        var row_table = tabledataewskematian.row($(this).parents('tr'))[0];
        modaleditewsshow(dataedit, row_table);
    });

}

function ews_bw() {
    var data_ews_bw = [];
    for (let i = 0; i < datajson.length; i++) {
        let obj = {
            tanggal: datajson[i]['tanggal'],
            umur: datajson[i]['umur'],
            nilai: datajson[i]['ews_bw_value'],
            ket: datajson[i]['ket_ews_bw'],
            id_ket: datajson[i]['id_ews_bw'],
            type_ews: 'bw',
        }
        if (datajson[i]['ews_bw']) {
            data_ews_bw.push(obj);
        }
    }
    var tabledataewsbw = $('#tabledataewsbw').DataTable({
        // "destroy": true,
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
        "data": data_ews_bw,
        "columns": [{
                'data': 'tanggal'
            },
            {
                'data': 'umur'
            },
            {
                'data': 'nilai'
            },
            {
                "data": 'ket',
                "className": 'text-nowrap',
                "render": function (data, type, row) {
                    if (data) {
                        var return_result = data;
                    } else {
                        var return_result = `-`;
                    }
                    return return_result;
                }
            },
            {
                "data": 'id_ket',
                "className": 'text-nowrap',
                "render": function (data, type, row) {
                    var return_result = `<div class="btn-group" role="group" aria-label="Basic example">
                                           <a href='javascript:void(0);' class='btn btn-primary btn-edit  btn-sm' ><i class="far fa-edit"></i></a>  
                                        </div>
                                        `;
                    return return_result;
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
    // tabledataewsbw.buttons('.export').remove();
    var buttontabledataewsbw = new $.fn.dataTable.Buttons(tabledataewsbw, {
        buttons: [{
                extend: 'excel',
                footer: true,
                title: 'Tabel BW '
            },
            {
                extend: 'pdf',
                footer: true,
                title: 'Tabel BW'
            },
            {
                extend: 'print',
                footer: true,
                title: 'Tabel BW'
            },
        ]
    }).container().appendTo($('#buttonewsbw'));
    console.log(buttontabledataewsbw);

    $('#tabledataewsbw tbody').on('click', '.btn-edit', function () {
        var dataedit = tabledataewsbw.row($(this).parents('tr')).data();
        var row_table = tabledataewsbw.row($(this).parents('tr'))[0];
        modaleditewsshow(dataedit, row_table);
    });
}

function modaleditewsshow(data, row_table) {
    const dateinput = new Date().toLocaleDateString('en-US', {
        timeZone: 'Asia/Jakarta'
    });
    console.log(data);
    var type_input = $("#type_input_ews");
    var id_data = $("#id_data_ews");
    $("#id_row_ews").val(row_table);
    if (data.id_ket) {
        $("#headerews").text("Edit Keterangan EWS");
        $("#tanggal_ews").val(data.tanggal);
        $("#input_ews_type").val(data.type_ews);
        $("#input_ews_nilai").val(data.nilai);
        $("#input_ews_ket").val(data.ket);
        type_input.val("edit");
        id_data.val(data.id_ket);
    } else {
        $("#headerews").text("Tambah Keterangan EWS");
        $("#tanggal_ews").val(data.tanggal);
        $("#input_ews_type").val(data.type_ews);
        $("#input_ews_nilai").val(data.nilai);
        $("#input_ews_ket").val("");
        type_input.val("tambah");
        id_data.val("");
    }
    $("#modalews").modal('show');
}

function inputews() {
    var dataformnya = new FormData();
    var type_ews = $("#input_ews_type").val();
    var row_table = $("#id_row_ews").val();

    dataformnya.append('token', tokenfinal);
    dataformnya.append('id_user', user_idjs);
    dataformnya.append('idkandangperiode', idkandangperiode);
    dataformnya.append('tanggal', $("#tanggal_ews").val());
    dataformnya.append('type_ews', type_ews);
    dataformnya.append('nilai', $("#input_ews_nilai").val());
    dataformnya.append('ket', $("#input_ews_ket").val());
    dataformnya.append('id', $("#id_data_ews").val());
    dataformnya.append('type_input', $("#type_input_ews").val());
    $.ajax({
        type: 'POST',
        url: api_url + 'ternak2/inputews',
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
            $("#modalews").modal("hide");
            if (type_ews == 'mati') {
                $("#tabledataewskematian").DataTable().row(row_table).data(outputjson.data).draw();
            } else {
                $("#tabledataewsbw").DataTable().row(row_table).data(outputjson.data).draw();
            }
            //End Clear Modal Input ovk
        },
    });
}