function sapronak() {
    const outputsapornak = $("#outputsapornak");
    if (outputsapornak.html() == "") {
        $.ajax({
            method: "POST",
            data: {
                user_id: useridfinal,
                token: tokenfinal,
                kandangperiode: idkandangperiode
            },
            url: base_url + 'ajax/sapronak/',
            cache: false,
            beforeSend: function () {
                outputsapornak.html(loadingnih());
            },
            success: function (response) {
                outputsapornak.html(response);
                sapronak_doc();
            }
        });
    }
}


function sapronak_doc() {
    $('#tabledocsapronak').DataTable().destroy();
    $('#tablepakansapronak').DataTable().destroy();
    $('#tableovksapronak').DataTable().destroy();
    $('#tablegeneralsapronak').DataTable().destroy();
    const tabledocsapronak = $('#tabledocsapronak').DataTable({
        "destroy": true,
        "ajax": {
            'type': 'POST',
            'url': api_url + 'api/ternak2/getdoctable',
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
            'width': '10%',
            'data': 'tanggal_mulai'
        },
        {
            'width': '10%',
            'data': 'populasi_awal'
        },
        {
            'width': '10%',
            'data': 'harga_doc'
        },
        ],
        "columnDefs": [{
            "targets": '_all',
            "defaultContent": '0'
        }],
        "order": [
            [0, 'desc']
        ]
    });
    const tablepakansapronak = $('#tablepakansapronak').DataTable({
        "destroy": true,
        "ajax": {
            'type': 'POST',
            'url': api_url + 'api/ternak2/getpakantable',
            'data': {
                kandangperiode: idkandangperiode,
                token: tokenfinal
            },
            "dataSrc": "",
            beforeSend: function () {
                // $("#button_viewtablestockobat").prop('disabled', true); // disable button
                // document.querySelector('#button_viewtablestockobat').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
            },
        },
        "columns": [{
            'width': '10%',
            'data': 'tanggal'
        },
        {
            'width': '20%',
            'data': 'jenis'
        },
        {
            'width': '5%',
            'data': 'qty'
        },
        {
            'width': '5%',
            'data': 'harga'
        },
        {
            'width': '10%',
            'data': 'harga_tot'
        },
        {
            'width': '50%',
            'data': 'btn'
        }
        ],
        "columnDefs": [{
            "targets": '_all',
            "defaultContent": '0'
        }],
        "order": [
            [0, 'desc']
        ]
    });
    $('#tablepakansapronak tbody').on('click', '.btn-edit', function () {
        var dataedit = tablepakansapronak.row($(this).parents('tr')).data();
        modaltambahpakanshow(dataedit);
    });
    $('#tablepakansapronak tbody').on('click', '.btn-hapus', function () {
        var datahapus = tablepakansapronak.row($(this).parents('tr')).data();
        console.log(datahapus)
        const buttonconfirm = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })
        buttonconfirm.fire({
            title: 'Apakah anda yakin hapus ' + datahapus.jenis + '?',
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
                    url: api_url + 'kandang/hapus/',
                    cache: false,
                    success: function (response) {
                        output = JSON.parse(response);
                        set_flashdata('success', output.message);
                        $("#tablepakansapronak").DataTable().ajax.reload();
                    }
                });
            }
        })
    });

    // Table OVK
    const tableovksapronak = $('#tableovksapronak').DataTable({
        "destroy": true,
        "ajax": {
            'type': 'POST',
            'url': api_url + 'api/ternak2/getovktable',
            'data': {
                kandangperiode: idkandangperiode,
                token: tokenfinal
            },
            "dataSrc": "",
            beforeSend: function () { },
        },
        "columns": [{
            'data': 'tanggal'
        },
        {
            'data': 'jenis'
        },
        {
            'data': 'qty'
        },
        {
            'data': 'harga'
        },
        {
            'data': 'harga_tot'
        },
        {
            'data': 'btn'
        }
        ],
        "columnDefs": [{
            "targets": '_all',
            "defaultContent": '0'
        }],
        "order": [
            [0, 'desc']
        ]
    });
    $('#tableovksapronak tbody').on('click', '.btn-edit', function () {
        var dataedit = tableovksapronak.row($(this).parents('tr')).data();
        modaltambahovkshow(dataedit);
    });
    $('#tableovksapronak tbody').on('click', '.btn-hapus', function () {
        var datahapus = tableovksapronak.row($(this).parents('tr')).data();
        console.log(datahapus)
        const buttonconfirm = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })
        buttonconfirm.fire({
            title: 'Apakah anda yakin hapus ' + datahapus.jenis + '?',
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
                    url: api_url + 'kandang/hapus/',
                    cache: false,
                    success: function (response) {
                        output = JSON.parse(response);
                        set_flashdata('success', output.message);
                        $("#tableovksapronak").DataTable().ajax.reload();
                    }
                });
            }
        })
    });

    // Table GENERAL
    // Table OVK
    const tablegeneralsapronak = $('#tablegeneralsapronak').DataTable({
        "destroy": true,
        "ajax": {
            'type': 'POST',
            'url': api_url + 'api/ternak2/getgeneraltable',
            'data': {
                kandangperiode: idkandangperiode,
                token: tokenfinal
            },
            "dataSrc": "",
            beforeSend: function () { },
        },
        "columns": [{
            'data': 'tanggal'
        },
        {
            'data': 'jenis'
        },
        {
            'data': 'qty'
        },
        {
            'data': 'harga'
        },
        {
            'data': 'harga_tot'
        },
        {
            'data': 'btn'
        }
        ],
        "columnDefs": [{
            "targets": '_all',
            "defaultContent": '0'
        }],
        "order": [
            [0, 'desc']
        ]
    });
    $('#tablegeneralsapronak tbody').on('click', '.btn-edit', function () {
        var dataedit = tablegeneralsapronak.row($(this).parents('tr')).data();
        modaltambahgeneralshow(dataedit);
    });
    $('#tablegeneralsapronak tbody').on('click', '.btn-hapus', function () {
        var datahapus = tablegeneralsapronak.row($(this).parents('tr')).data();
        console.log(datahapus)
        const buttonconfirm = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })
        buttonconfirm.fire({
            title: 'Apakah anda yakin hapus ' + datahapus.jenis + '?',
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
                    url: api_url + 'kandang/hapus/',
                    cache: false,
                    success: function (response) {
                        output = JSON.parse(response);
                        set_flashdata('success', output.message);
                        $("#tablegeneralsapronak").DataTable().ajax.reload();
                    }
                });
            }
        })
    });

}


// Form Input Pakan
function modaltambahpakanshow(data) {
    const dateinput = new Date().toLocaleDateString('en-US', {
        timeZone: 'Asia/Jakarta'
    });
    // console.log(dateinput.replace(/\//g, "-"));
    var type_input = $("#type_input");
    var id_data = $("#id_data");
    var jenispakan;
    if (data) {
        $("#headermodalinput").text("Edit Pakan");
        $("#inputpakantanggal").val(data.tanggal);
        $("#inputpakanqty").val(data.qty);
        $("#inputpakanharga").val(data.harga);
        jenispakan = data.jenis;
        type_input.val("edit");
        id_data.val(data.id);
        $("#kt_modal_new_address_cancel").hide();
    } else {
        jenispakan = false;
        $("#inputpakantanggal").val(formatDate(dateinput));
        $("#headermodalinput").text("Tambah Pakan");
        $("#inputpakanqty").val("");
        $("#inputpakanharga").val("");
        type_input.val("tambah");
        id_data.val("");
        $("#kt_modal_new_address_cancel").show();
    }
    $("#modaltambahpakan").modal('show');
    $.ajax({
        method: 'POST',
        url: api_url + 'kandang/jenispakan',
        data: {
            token: tokenfinal
        },
        success: function (response) {
            dataraw = JSON.parse(response);
            var r;
            for (let i = 0; i < dataraw.length; i++) {
                if (jenispakan !== false) {
                    if (dataraw[i].brand == jenispakan) {
                        r += `<option value="` + dataraw[i].id + `" selected>` + dataraw[i].brand + `</option>`;
                    } else {
                        r += `<option value="` + dataraw[i].id + `">` + dataraw[i].brand + `</option>`;
                    }
                } else {
                    r += `<option value="` + dataraw[i].id + `">` + dataraw[i].brand + `</option>`;
                }
            }
            $("#selectjenispakan").html(r);
        },
    });
}

function inputpakan() {
    var dataformnya = new FormData();
    var qty = $("#inputpakanqty").val() == "" ? return_set_flashdata("error", "Qty tidak boleh kosong") : $("#inputpakanqty").val();
    var harga = $("#inputpakanharga").val() == "" ? return_set_flashdata("error", "Harga tidak boleh kosong") : $("#inputpakanharga").val();
    if (qty !== false) {
        dataformnya.append('qty', qty);
    } else {
        return;
    }
    if (harga !== false) {
        dataformnya.append('harga', harga);
    } else {
        return;
    }
    dataformnya.append('tanggal_kandang_activity_log', $("#inputpakantanggal").val());
    dataformnya.append('jenis_pakan', $("#selectjenispakan").val());
    dataformnya.append('user_id', user_idjs);
    dataformnya.append('token', tokenfinal);
    dataformnya.append('type_input', $("#type_input").val());
    dataformnya.append('idkandangperiode', idkandangperiode);
    dataformnya.append('id', $("#id_data").val());
    $.ajax({
        type: 'POST',
        url: api_url + 'kandang/inputpakan',
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
            //Clear Modal Input Pakan
            $("#inputpakanqty").val("");
            $("#inputpakanharga").val("");
            $("#modaltambahpakan").modal("hide");
            $("#tablepakansapronak").DataTable().ajax.reload();
            //End Clear Modal Input Pakan
        },
    });
}

//Form Input Ovk
function modaltambahovkshow(data) {
    var type_input = $("#type_input");
    var id_data = $("#id_data");
    var jenisovk;
    if (data) {
        $("#headermodalinputovk").text("Edit OVK");
        $("#inputovktanggal").val(data.tanggal);
        $("#inputovkqty").val(data.qty);
        $("#inputovkharga").val(data.harga);
        jenisovk = data.jenis;
        type_input.val("edit");
        id_data.val(data.id);
        $("#kt_modal_new_address_cancel").hide();
    } else {
        jenisovk = false;
        $("#headermodalinputovk").text("Tambah OVK");
        $("#inputovkqty").val("");
        $("#inputovkharga").val("");
        type_input.val("tambah");
        id_data.val("");
        $("#kt_modal_new_address_cancel").show();
    }
    $("#modaltambahovk").modal('show');
    $.ajax({
        method: 'POST',
        url: api_url + 'kandang/jenisovk',
        data: {
            token: tokenfinal
        },
        success: function (response) {
            dataraw = JSON.parse(response);
            var r;
            r = `<option value="0" data-satuan="">-Pilih OVK-</option>`;
            for (let i = 0; i < dataraw.length; i++) {
                if (jenisovk !== false) {
                    if (dataraw[i].brand == jenisovk) {
                        r += `<option value="` + dataraw[i].id + `" selected data-satuan="` + dataraw[i].satuan + `" data-qty="` + dataraw[i].quantity + `">` + dataraw[i].brand + `</option>`;
                    } else {
                        r += `<option value="` + dataraw[i].id + `" data-satuan="` + dataraw[i].satuan + `" data-qty="` + dataraw[i].quantity + `">` + dataraw[i].brand + `</option>`;
                    }
                } else {
                    r += `<option value="` + dataraw[i].id + `" data-satuan="` + dataraw[i].satuan + `" data-qty="` + dataraw[i].quantity + `">` + dataraw[i].brand + `</option>`;
                }
            }
            $("#selectjenisovk").html(r);
        },
    });
}

function ovkselectfun() {
    var ss = document.getElementById("selectjenisovk");
    var ovksatuan = ss.options[ss.selectedIndex].getAttribute('data-satuan');
    var ovkqty = ss.options[ss.selectedIndex].getAttribute('data-qty');
    var qty_stock = ss.options[ss.selectedIndex].getAttribute('data-stock');
    document.getElementById("inputovksatuan").value = ovksatuan;
    document.getElementById("inputovkqtytersedia").value = ovkqty;
    // document.getElementById("qty_stock").value = qty_stock;
}

function validateqtyovk(value) {
    let values, qtytersedia;
    values = value;
    qtytersedia = parseInt($("#inputovkqtytersedia").val());
    if (isNaN(qtytersedia)) {
        set_flashdata('error', "Pastikan anda memilih jenis ovk");
        $("#inputovkqty").val("");
    } else {
        if (values > qtytersedia) {
            set_flashdata('error', "Qty anda melebihi dari qty tersedia.");
            $("#inputovkqty").val("");
        }
    }
}

function inputovk() {
    var dataformnya = new FormData();
    var qty = $("#inputovkqty").val() == "" ? return_set_flashdata("error", "Qty tidak boleh kosong") : $("#inputovkqty").val();
    var harga = $("#inputovkharga").val() == "" ? return_set_flashdata("error", "Harga tidak boleh kosong") : $("#inputovkharga").val();
    if (qty !== false) {
        dataformnya.append('qty', qty);
    } else {
        return;
    }
    if (harga !== false) {
        dataformnya.append('harga', harga);
    } else {
        return;
    }

    dataformnya.append('tanggal_kandang_activity_log', $("#inputovktanggal").val());
    dataformnya.append('jenis_ovk', $("#selectjenisovk").val());
    dataformnya.append('user_id', user_idjs);
    dataformnya.append('token', tokenfinal);
    dataformnya.append('type_input', $("#type_input").val());
    dataformnya.append('idkandangperiode', idkandangperiode);
    dataformnya.append('id', $("#id_data").val());
    $.ajax({
        type: 'POST',
        url: api_url + 'kandang/inputovk',
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
            $("#inputovkqty").val("");
            $("#inputovkharga").val("");
            $("#modaltambahovk").modal("hide");
            $("#tableovksapronak").DataTable().ajax.reload();
            //End Clear Modal Input ovk
        },
    });
}

//Form Input General
function modaltambahgeneralshow(data) {
    var type_input = $("#type_input");
    var id_data = $("#id_data");
    var jenisgeneral;
    if (data) {
        $("#headermodalinputgeneral").text("Edit General");
        $("#inputgeneraltanggal").val(data.tanggal);
        $("#inputgeneralqty").val(data.qty);
        $("#inputgeneralharga").val(data.harga);
        jenisgeneral = data.jenis;
        type_input.val("edit");
        id_data.val(data.id);
        $("#kt_modal_new_address_cancel").hide();
    } else {
        jenisgeneral = false;
        $("#headermodalinputgeneral").text("Tambah General");
        $("#inputgeneralqty").val("");
        $("#inputgeneralharga").val("");
        type_input.val("tambah");
        id_data.val("");
        $("#kt_modal_new_address_cancel").show();
    }
    $("#modaltambahgeneral").modal('show');
    $.ajax({
        method: 'POST',
        url: api_url + 'kandang/jenisgeneral',
        data: {
            token: tokenfinal
        },
        success: function (response) {
            dataraw = JSON.parse(response);
            var r;
            r = `<option value="0" data-satuan="">-Pilih general-</option>`;
            for (let i = 0; i < dataraw.length; i++) {
                if (jenisgeneral !== false) {
                    if (dataraw[i].brand == jenisgeneral) {
                        r += `<option value="` + dataraw[i].id + `" selected data-satuan="` + dataraw[i].satuan + `" data-qty="` + dataraw[i].quantity + `">` + dataraw[i].brand + `</option>`;
                    } else {
                        r += `<option value="` + dataraw[i].id + `" data-satuan="` + dataraw[i].satuan + `" data-qty="` + dataraw[i].quantity + `">` + dataraw[i].brand + `</option>`;
                    }
                } else {
                    r += `<option value="` + dataraw[i].id + `" data-satuan="` + dataraw[i].satuan + `" data-qty="` + dataraw[i].quantity + `">` + dataraw[i].brand + `</option>`;
                }
            }
            $("#selectjenisgeneral").html(r);
        },
    });
}

function generalselectfun() {
    var ss = document.getElementById('selectjenisgeneral');
    var generalsatuan = ss.options[ss.selectedIndex].getAttribute('data-satuan');
    var generalqty = ss.options[ss.selectedIndex].getAttribute('data-qty');
    var qty_stock = ss.options[ss.selectedIndex].getAttribute('data-stock');
    $("#inputgeneralsatuan").val(generalsatuan);
    $("#inputgeneralqtytersedia").val(generalqty);
}

function validateqtygeneral(value) {
    let values, qtytersedia;
    values = value;
    qtytersedia = parseInt($("#inputgeneralqtytersedia").val());
    if (isNaN(qtytersedia)) {
        set_flashdata('error', "Pastikan anda memilih jenis general");
        $("#inputgeneralqty").val("");
    } else {
        if (values > qtytersedia) {
            set_flashdata('error', "Qty anda melebihi dari qty tersedia.");
            $("#inputgeneralqty").val("");
        }
    }
}

function inputgeneral() {
    var dataformnya = new FormData();
    var qty = $("#inputgeneralqty").val() == "" ? return_set_flashdata("error", "Qty tidak boleh kosong") : $("#inputgeneralqty").val();
    var harga = $("#inputgeneralharga").val() == "" ? return_set_flashdata("error", "Harga tidak boleh kosong") : $("#inputgeneralharga").val();
    if (qty !== false) {
        dataformnya.append('qty', qty);
    } else {
        return;
    }
    if (harga !== false) {
        dataformnya.append('harga', harga);
    } else {
        return;
    }

    dataformnya.append('tanggal_kandang_activity_log', $("#inputgeneraltanggal").val());
    dataformnya.append('jenis_general', $("#selectjenisgeneral").val());
    dataformnya.append('user_id', user_idjs);
    dataformnya.append('token', tokenfinal);
    dataformnya.append('type_input', $("#type_input").val());
    dataformnya.append('idkandangperiode', idkandangperiode);
    dataformnya.append('id', $("#id_data").val());
    $.ajax({
        type: 'POST',
        url: api_url + 'kandang/inputgeneral',
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
            //Clear Modal Input general
            $("#inputgeneralqty").val("");
            $("#inputgeneralharga").val("");
            $("#modaltambahgeneral").modal("hide");
            $("#tablegeneralsapronak").DataTable().ajax.reload();
            //End Clear Modal Input general
        },
    });
}