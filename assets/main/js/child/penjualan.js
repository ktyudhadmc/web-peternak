function penjualan() {
    const outputpenjualan = $("#outputpenjualan");
    if (outputpenjualan.html() == "") {
        view_page();
    }
}
function view_page() {
    const outputpenjualan = $("#outputpenjualan");
    $.ajax({
        method: "POST",
        data: { user_id: useridfinal, token: tokenfinal, kandangperiode: idkandangperiode },
        url: base_url + 'ajax/penjualan/',
        cache: false,
        beforeSend: function () {
            outputpenjualan.html(loadingnih());
        },
        success: function (response) {
            outputpenjualan.html(response);
            getdatapanendo();
        }
    });
}
function see_detail_panen(nomorDO, type_input) {
    const outputpenjualan = $("#outputpenjualan");
    $.ajax({
        method: "POST",
        data: { user_id: useridfinal, token: tokenfinal, kandangperiode: idkandangperiode },
        url: base_url + 'ajax/penjualan/view_detail_panen',
        cache: false,
        beforeSend: function () {
            outputpenjualan.html(loadingnih());
        },
        success: function (response) {
            outputpenjualan.html(response);
            see_detail_panen_data(nomorDO, type_input);
        }
    });
}
function see_detail_panen_data(nomorDO, type_input) {
    const outputpenjualan = $("#outputpenjualan");
    var data;
    var datapanen;
    $.ajax({
        method: "POST",
        url: api_url + 'api/ternak2/datapanendetail',
        data: {
            kandangperiode: idkandangperiode,
            token: tokenfinal,
            nomordo: nomorDO,
            type_input: type_input,
        },
        cache: false,
        beforeSend: function () {
            // outputpenjualan.html(loadingnih());
        },
        success: function (response) {
            const dateinput = new Date().toLocaleDateString('en-US', { timeZone: 'Asia/Jakarta' });
            console.log(response);
            data = JSON.parse(response);
            datapanen = data['datapanen'];
            var nomordo = `List panen ayam per timbang nomor DO ` + data['do'];
            $('#nomordo').html(nomordo);
            $('#input_datatimbang_nomorDO').val(data['nomorDO']);
            $('#input_datatimbang_nomor_mobil').val(data['nomor_mobil']);
            $('#input_datatimbang_namapembeli').val(data['namapembeli']);
            $('#input_datatimbang_namapenimbang').val(data['namapenimbang']);
            $('#input_datatimbang_nomornota').val(data['nomornota']);
            $('#input_datatimbang_kondisiayam').val(data['kondisiayam']);
            $('#input_datatimbang_beratkeranjang').val(data['beratkeranjang']);
            $('#input_datatimbang_susut').val(data['susut']);

            $('#imgttdpembeli').html("<img style='border: 2px solid #bcbdbf;border-radius: 10px;' src='" + data['ttdpembeli'] + "'>");
            $('#imgttdpenimbang').html("<img style='border: 2px solid #bcbdbf;border-radius: 10px;' src='" + data['ttdpenimbang'] + "'>");

            if (data['type_input'] == 'edit') {
                $('#input_datatimbang_tanggal').val(data['tanggal']);
            } else {
                $('#input_datatimbang_tanggal').val(formatDate(dateinput));
            }
            $('#tabledatapanendetail tfoot th').each(function () {
                var title = $(this).text();
                $(this).html('<br><input class="form-control" type="text" placeholder="Search ' + title + '" />');
            });
            var tabledatapanendetail = $('#tabledatapanendetail').DataTable({
                "destroy": true,
                "filter": true,
                "info": true,
                // "destroy": true,
                "lengthChange": true,
                // "order": [[ 0, "desc" ]],
                "paging": true,
                "pageLength": -1,
                "lengthMenu": [[7, 10, 25, 50, -1], [7, 10, 25, 50, "All"]],
                "scrollCollapse": true,
                "scrollY": "350px",
                "scrollX": true,
                dom: '<"top"B>rt<"bottom"ilp><"clear">',
                buttons: [{ extend: 'excel', footer: true, title: 'Tabel' },
                { extend: 'pdf', footer: true, title: 'Tabel' },
                { extend: 'print', footer: true, title: 'Tabel' },
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
                "data": datapanen,
                "columns": [
                    {
                        "data": 'id',
                        "className": 'text-nowrap',
                        "width": "20%",
                        "render": function (data, type, row, meta) {

                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { 'data': 'qty_ekor' },
                    { 'data': 'qty_kg' },
                    {
                        "data": 'id',
                        "className": 'text-nowrap',
                        "width": "20%",
                        "render": function (data, type, row) {
                            var return_result = `<div class="btn-group" role="group" aria-label="Basic example">
                                            <a href='javascript:void(0);' class='btn btn-primary btn-edit  btn-sm' ><i class="far fa-edit"></i></a>        
                                            <a href='javascript:void(0);' class='btn btn-danger btn-hapus  btn-sm' ><i class='fa fa-trash'></i></a>
                                        </div>
                                        `;
                            return return_result;
                        }
                    }
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
                    // $("#button_viewtablelistuser").prop('disabled', false); // enable button
                    // document.querySelector('#button_viewtablelistuser').innerHTML = 'Load';
                    // document.querySelector('#tittle_table_mutasi_ovk').innerHTML = 'Jenis OVK';
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

                    var coltosum = [1, 2]
                    for (c in coltosum) {
                        // Total over all pages
                        // console.log(api.column( coltosum[c] ).data())
                        // total = api.column( coltosum[c] ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                        // Total over this page
                        pageTotal = api.column(coltosum[c], { page: 'current' }).data().reduce(function (a, b) { return intVal(a) + intVal(b); }, 0);
                        // Update footer
                        $(api.column(coltosum[c]).footer()).html(pageTotal.toFixed(3));
                    }
                }
            });
            $('#tabledatapanendetail tbody').on('click', '.btn-edit', function () {
                var dataedit = tabledatapanendetail.row($(this).parents('tr')).data();
                modaleditdatatimbangshow(dataedit);
            });
            $('#tabledatapanendetail tbody').on('click', '.btn-hapus', function () {
                var datahapus = tabledatapanendetail.row($(this).parents('tr')).data();
                // console.log(datahapus)
                const buttonconfirm = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })
                buttonconfirm.fire({
                    title: 'Apakah anda yakin hapus data timbang?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Jangan',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: "POST",
                            data: { token: tokenfinal, id: datahapus.id },
                            url: api_url + 'api/ternak2/hapusdatatimbang/',
                            cache: false,
                            success: function (response) {
                                output = JSON.parse(response);
                                set_flashdata('success', output.message);
                                $("#tabledatapanendetail").DataTable().clear().draw();
                                $("#tabledatapanendetail").DataTable().rows.add(output.datapanen); // Add new data
                                $("#tabledatapanendetail").DataTable().columns.adjust().draw(); // Redraw the DataTable
                                // $("#tabledataharian").DataTable().ajax.reload();
                            }
                        });
                    }
                })
            });
        }
    });


}
function getdatapanendo() {
    $('#tabledatapanendo tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<br><input class="form-control" type="text" placeholder="Search ' + title + '" />');
    });
    var tabledatapanendo = $('#tabledatapanendo').DataTable({
        "destroy": true,
        "filter": true,
        "info": true,
        // "destroy": true,
        "lengthChange": true,
        // "order": [[ 0, "desc" ]],
        "paging": true,
        "pageLength": -1,
        "lengthMenu": [[7, 10, 25, 50, -1], [7, 10, 25, 50, "All"]],
        "scrollCollapse": true,
        "scrollY": "350px",
        "scrollX": true,
        dom: '<"top"B>rt<"bottom"ilp><"clear">',
        buttons: [{ extend: 'excel', footer: true, title: 'Tabel' },
        { extend: 'pdf', footer: true, title: 'Tabel' },
        { extend: 'print', footer: true, title: 'Tabel' },
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
            'url': api_url + 'api/ternak2/datapanendo',
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
        "columns": [
            { 'data': 'tanggal' },
            {
                "data": 'do',
                "className": 'text-nowrap',
                "render": function (data, type, row) {
                    if (!data) {
                        return row['nomorDO'];
                    } else {
                        return data;
                    }
                }
            },
            { 'data': 'nomor_mobil' },
            { 'data': 'namapembeli' },
            { 'data': 'namapenimbang' },
            { 'data': 'nomornota' },
            { 'data': 'kondisiayam' },
            { 'data': 'total_ayam' },
            { 'data': 'bruto' },
            { 'data': 'susut' },
            { 'data': 'beratkeranjang' },
            { 'data': 'nett' },
            { 'data': 'rata' },
            {
                "data": 'id',
                "className": 'text-nowrap',
                "render": function (data, type, row) {
                    var return_result = `<div class="btn-group" role="group" aria-label="Basic example">
                                            <a class='btn btn-primary btn-sm' onclick="see_detail_panen('`+ row['nomorDO'] + `','edit')"><i class="far fa-edit"></i></a>        
                                            <a href='javascript:void(0);' class='btn btn-danger btn-hapus  btn-sm' ><i class='fa fa-trash'></i></a>
                                        </div>
                                        `;
                    return return_result;
                }
            }
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
            // $("#button_viewtablelistuser").prop('disabled', false); // enable button
            // document.querySelector('#button_viewtablelistuser').innerHTML = 'Load';
            // document.querySelector('#tittle_table_mutasi_ovk').innerHTML = 'Jenis OVK';
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

            var coltosum = [7, 8, 9, 10, 11]
            for (c in coltosum) {
                // Total over all pages
                // console.log(api.column( coltosum[c] ).data())
                // total = api.column( coltosum[c] ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                // Total over this page
                pageTotal = api.column(coltosum[c], { page: 'current' }).data().reduce(function (a, b) { return intVal(a) + intVal(b); }, 0);
                // Update footer
                $(api.column(coltosum[c]).footer()).html(pageTotal.toFixed(3));
            }
        }
    });
    $('#tabledatapanendo tbody').on('click', '.btn-hapus', function () {
        var datahapus = tabledatapanendo.row($(this).parents('tr')).data();
        // console.log(datahapus)
        const buttonconfirm = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })
        buttonconfirm.fire({
            title: 'Apakah anda yakin hapus data panen?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Jangan',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "POST",
                    data: { token: tokenfinal, nomorDO: datahapus.nomorDO, kandangperiode: idkandangperiode },
                    url: api_url + 'api/ternak2/hapusdatapanen/',
                    cache: false,
                    success: function (response) {
                        output = JSON.parse(response);
                        set_flashdata('success', output.message);
                        $("#tabledatapanendo").DataTable().ajax.reload();
                    }
                });
            }
        })
    });
}
function modaleditdatatimbangshow(data) {
    // const dateinput = new Date().toLocaleDateString('en-US', { timeZone: 'Asia/Jakarta' });
    console.log(data);
    var type_input = $("#type_input_datatimbang");
    var id_data = $("#id_data_datatimbang");
    if (data) {
        $("#headerdatatimbang").text("Edit Data Timbang");
        // $("#tanggal_dataharian").val(data.tanggal);
        $("#input_datatimbang_qty").val(data.qty_ekor);
        $("#input_datatimbang_tonase").val(data.qty_kg);
        type_input.val("edit");
        id_data.val(data.id);
    } else {
        $("#headerdatatimbang").text("Tambah Data Timbang");
        // $("#tanggal_dataharian").val(formatDate(dateinput));
        $("#input_datatimbang_qty").val("");
        $("#input_datatimbang_tonase").val("");
        type_input.val("tambah");
        id_data.val("");
    }
    $("#modaldatatimbang").modal('show');
}

function inputdatatimbang() {
    var dataformnya = new FormData();
    // var total_mati = parseInt($("#input_dataharian_mati").val()) + parseInt($("#input_dataharian_culling").val());

    dataformnya.append('token', tokenfinal);
    dataformnya.append('id_user', user_idjs);
    dataformnya.append('idkandangperiode', idkandangperiode);
    dataformnya.append('tanggal', $("#input_datatimbang_tanggal").val());
    dataformnya.append('nomorDO', $("#input_datatimbang_nomorDO").val());
    dataformnya.append('nomornota', $("#input_datatimbang_nomornota").val());
    dataformnya.append('nomor_mobil', $("#input_datatimbang_nomor_mobil").val());
    dataformnya.append('namapembeli', $("#input_datatimbang_namapembeli").val());
    dataformnya.append('kondisiayam', $("#input_datatimbang_kondisiayam").val());
    // dataformnya.append('kodebakul', $("#input_dataharian_uniformity").val());
    dataformnya.append('namapenimbang', $("#input_datatimbang_namapenimbang").val());
    dataformnya.append('beratkeranjang', $("#input_datatimbang_beratkeranjang").val());
    dataformnya.append('susut', $("#input_datatimbang_susut").val());
    dataformnya.append('qty_ekor', $("#input_datatimbang_qty").val());
    dataformnya.append('qty_kg', $("#input_datatimbang_tonase").val());
    dataformnya.append('harga', $("#input_datatimbang_harga").val());
    dataformnya.append('id', $("#id_data_datatimbang").val());
    dataformnya.append('type_input', $("#type_input_datatimbang").val());
    $.ajax({
        type: 'POST',
        url: api_url + 'api/ternak2/inputdatapanen',
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
            $("#modaldatatimbang").modal("hide");
            console.log(outputjson.datapanen);
            $("#tabledatapanendetail").DataTable().clear().draw();
            $("#tabledatapanendetail").DataTable().rows.add(outputjson.datapanen); // Add new data
            $("#tabledatapanendetail").DataTable().columns.adjust().draw(); // Redraw the DataTable
            // $("#tabledataharian").DataTable().ajax.reload();
            var nomordo = `List panen ayam per timbang nomor DO ` + outputjson.datapanendo.do;
            $('#nomordo').html(nomordo);
            $('#input_datatimbang_nomorDO').val(outputjson.datapanendo.nomorDO);
            $('#input_datatimbang_nomor_mobil').val(outputjson.datapanendo.nomor_mobil);
            $('#input_datatimbang_namapembeli').val(outputjson.datapanendo.namapembeli);
            $('#input_datatimbang_namapenimbang').val(outputjson.datapanendo.namapenimbang);
            $('#input_datatimbang_nomornota').val(outputjson.datapanendo.nomornota);
            $('#input_datatimbang_kondisiayam').val(outputjson.datapanendo.kondisiayam);
            $('#input_datatimbang_beratkeranjang').val(outputjson.datapanendo.beratkeranjang);
            $('#input_datatimbang_susut').val(outputjson.datapanendo.susut);
            //End Clear Modal Input ovk
        },
    });
}

function data_transaksi_update() {
    var dataformnya = new FormData();
    dataformnya.append('token', tokenfinal);
    dataformnya.append('id_user', user_idjs);
    dataformnya.append('idkandangperiode', idkandangperiode);
    dataformnya.append('tanggal', $("#input_datatimbang_tanggal").val());
    dataformnya.append('nomorDO', $("#input_datatimbang_nomorDO").val());
    dataformnya.append('nomornota', $("#input_datatimbang_nomornota").val());
    dataformnya.append('nomor_mobil', $("#input_datatimbang_nomor_mobil").val());
    dataformnya.append('namapembeli', $("#input_datatimbang_namapembeli").val());
    dataformnya.append('kondisiayam', $("#input_datatimbang_kondisiayam").val());
    dataformnya.append('namapenimbang', $("#input_datatimbang_namapenimbang").val());
    dataformnya.append('beratkeranjang', $("#input_datatimbang_beratkeranjang").val());
    dataformnya.append('susut', $("#input_datatimbang_susut").val());
    $.ajax({
        type: 'POST',
        url: api_url + 'api/ternak2/data_transaksi_update',
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
            $("#modaldatatimbang").modal("hide");
            console.log(outputjson);
            // $("#tabledatapanendetail").DataTable().clear().draw();
            // $("#tabledatapanendetail").DataTable().rows.add(outputjson.datapanen); // Add new data
            // $("#tabledatapanendetail").DataTable().columns.adjust().draw(); // Redraw the DataTable
            // $("#tabledataharian").DataTable().ajax.reload();
            var nomordo = `List panen ayam per timbang nomor DO ` + outputjson.datapanendo.do;
            $('#nomordo').html(nomordo);
            $('#input_datatimbang_nomorDO').val(outputjson.datapanendo.nomorDO);
            $('#input_datatimbang_nomor_mobil').val(outputjson.datapanendo.nomor_mobil);
            $('#input_datatimbang_namapembeli').val(outputjson.datapanendo.namapembeli);
            $('#input_datatimbang_namapenimbang').val(outputjson.datapanendo.namapenimbang);
            $('#input_datatimbang_nomornota').val(outputjson.datapanendo.nomornota);
            $('#input_datatimbang_kondisiayam').val(outputjson.datapanendo.kondisiayam);
            $('#input_datatimbang_beratkeranjang').val(outputjson.datapanendo.beratkeranjang);
            $('#input_datatimbang_susut').val(outputjson.datapanendo.susut);
            //End Clear Modal Input ovk
        },
    });
}

function modalttd() {
    $("#modalttd").modal('show');

    var canvas_pembeli = document.getElementById('signature-pad-pembeli');
    var canvas_penimbang = document.getElementById('signature-pad-penimbang');
    // if (canvas_pembeli) {
    // console.log('1');
    var signaturePad_pembeli = new SignaturePad(canvas_pembeli, {
        backgroundColor: 'rgb(255, 255, 255)' // necessary for saving image as JPEG; can be removed is only saving as PNG or SVG
    });
    var signaturePad_penimbang = new SignaturePad(canvas_penimbang, {
        backgroundColor: 'rgb(255, 255, 255)' // necessary for saving image as JPEG; can be removed is only saving as PNG or SVG
    });
    document.getElementById('resetpenimbang').addEventListener('click', function () {
        signaturePad_penimbang.clear();
    });
    document.getElementById('resetpembeli').addEventListener('click', function () {
        signaturePad_pembeli.clear();
    });
    document.getElementById('button_ttd').addEventListener('click', function () {
        if (signaturePad_penimbang.isEmpty() || signaturePad_pembeli.isEmpty()) {
            return alert("Please provide a signature first.");
        }
        var datattdpenimbang = signaturePad_penimbang.toDataURL('image/png');
        var datattdpembeli = signaturePad_pembeli.toDataURL('image/png');


        var data = new FormData()
        data.append('token', tokenfinal);
        data.append('id_user', user_idjs);
        data.append('image_penimbang', datattdpenimbang)
        data.append('image_pembeli', datattdpembeli)
        data.append('idkandangperiode', idkandangperiode);
        data.append('nomorDO', $("#input_datatimbang_nomorDO").val());

        console.log(data);
        $.ajax({
            type: 'POST',
            url: api_url + 'api/ternak2/data_ttd_update',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                outputjson = JSON.parse(response);
                if (outputjson.status == true) {
                    set_flashdata('success', outputjson.message);
                } else {
                    set_flashdata('error', outputjson.message);
                };
                $("#modalttd").modal("hide");
                // console.log(outputjson);
            },
        });

    });

}
