function viewtablelistuser() {
    $('#exampletablelistuser tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<br><input class="form-control" type="text" placeholder="Search ' + title + '" />');
    });
    //---------Tabel Point Feed----------//
    var tso = $('#exampletablelistuser').DataTable({
        // filter: false,
        "info": true,
        "destroy": true,
        "lengthChange": true,
        // "order": [[ 0, "desc" ]],
        "paging": true,
        "pageLength": -1,
        "lengthMenu": [[7, 10, 25, 50, -1], [7, 10, 25, 50, "All"]],
        "scrollCollapse": true,
        "scrollY": "350px",
        "scrollX": true,
        dom: '<"top"B>rt<"bottom"ilp><"clear">',
        buttons: [{ extend: 'excel', footer: true, title: 'Tabel user' },
        { extend: 'pdf', footer: true, title: 'Tabel user' },
        { extend: 'print', footer: true, title: 'Tabel user' },
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
            'url': base_url + 'user/get_data_listuser',
            'data': {
                // id_user: id_user,
            },
            "dataSrc": "",
            beforeSend: function () {
                $("#button_viewtablelistuser").prop('disabled', true); // disable button
                document.querySelector('#button_viewtablelistuser').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
            },
        },
        "columns": [
            { 'data': 'id_user' },
            { 'data': 'first_name' },
            { 'data': 'number' },
            { 'data': 'role_nm' },
            { 'data': 'user_member' },
            { 'data': 'banned_users' },
            { 'data': 'status' },
            { 'data': 'last_login' },
            {
                "data": 'id_user',
                "className": 'text-nowrap',
                "render": function (data, type, row) {
                    return `<a href="javascript:void(0);"  class="btn btn-primary btn-sm " onclick="edit_user_table(` + data + `,'` + row['first_name'] + `','` + row['number'] + `','` + row['role_nm'] + `','` + row['role'] + `','` + row['user_member'] + `','` + row['banned_users'] + `','` + row['status'] + `')" ><i class="fas fa-pencil-alt"></i>&nbsp Edit</a>
        <a href="javascript:void(0);"  class="btn btn-danger btn-sm" onclick="delete_user(`+ data + `,'delete_user')"><i class="fa fa-trash"></i>&nbsp Delete</a>`;
                }
            }
        ],
        "columnDefs": [
            {
                "targets": '_all',
                "defaultContent": '0'
            }
        ],
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
            $("#button_viewtablelistuser").prop('disabled', false); // enable button
            document.querySelector('#button_viewtablelistuser').innerHTML = 'Load';
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
function viewtableaksesuser() {
    $('#exampletableaksesuser tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<br><input class="form-control" type="text" placeholder="Search ' + title + '" />');
    });
    //---------Tabel Point Feed----------//
    var tso = $('#exampletableaksesuser').DataTable({
        // filter: false,
        "info": true,
        "destroy": true,
        "lengthChange": true,
        "order": [[1, "asc"]],
        "paging": true,
        "pageLength": -1,
        "lengthMenu": [[7, 10, 25, 50, -1], [7, 10, 25, 50, "All"]],
        "scrollCollapse": true,
        "scrollY": "350px",
        "scrollX": true,
        dom: '<"top"B>rt<"bottom"ilp><"clear">',
        buttons: [{ extend: 'excel', footer: true, title: 'Tabel Akses Kandang' },
        { extend: 'pdf', footer: true, title: 'Tabel Akses Kandang' },
        { extend: 'print', footer: true, title: 'Tabel Akses Kandang' },
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
            'url': base_url + 'user/get_data_akses_user',
            'data': {
                // id_user: id_user,
            },
            "dataSrc": "",
            beforeSend: function () {
                $("#button_viewtableaksesuser").prop('disabled', true); // disable button
                document.querySelector('#button_viewtableaksesuser').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
            },
        },
        "columns": [
            { 'data': 'id' },
            { 'data': 'nama' },
            { 'data': 'nama_kandang' },
            { 'data': 'lokasi' },
            {
                'data': 'b_id',
                "className": 'text-nowrap',
                "render": function (data, type, row) {
                    return `<a href="javascript:void(0);"   onclick="deleteuseridsharing('` + row['id'] + `','` + data + `')" ><i class="fas fa-trash-alt text-danger fa-2x"></i></a>`;
                }
            },

        ],
        "columnDefs": [
            {
                "targets": '_all',
                "defaultContent": '0'
            }
        ],
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
            $("#button_viewtableaksesuser").prop('disabled', false); // enable button
            document.querySelector('#button_viewtableaksesuser').innerHTML = 'Load';
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
function viewtablenotifwanumber() {
    $('#exampletablenotifwanumber tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<br><input class="form-control" type="text" placeholder="Search ' + title + '" />');
    });
    //---------Tabel Point Feed----------//
    var tso = $('#exampletablenotifwanumber').DataTable({
        // filter: false,
        "info": true,
        "destroy": true,
        "lengthChange": true,
        "order": [[1, "asc"]],
        "paging": true,
        "pageLength": -1,
        "lengthMenu": [[7, 10, 25, 50, -1], [7, 10, 25, 50, "All"]],
        "scrollCollapse": true,
        "scrollY": "350px",
        "scrollX": true,
        dom: '<"top"B>rt<"bottom"ilp><"clear">',
        buttons: [{ extend: 'excel', footer: true, title: 'Tabel Notif WA Number' },
        { extend: 'pdf', footer: true, title: 'Tabel Notif WA Number' },
        { extend: 'print', footer: true, title: 'Tabel Notif WA Number' },
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
            'url': base_url + 'user/get_data_akses_user/notifwanumber',
            'data': {
                // id_user: id_user,
            },
            "dataSrc": "",
            beforeSend: function () {
                $("#button_viewtablenotifwanumber").prop('disabled', true); // disable button
                document.querySelector('#button_viewtablenotifwanumber').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
            },
        },
        "columns": [
            { 'data': 'lokasi' },
            { 'data': 'type_number' },
            { 'data': 'nama' },
            { 'data': 'number' },
            {
                'data': 'status',
                "className": 'text-nowrap',
                "render": function (data, type, row) {
                    if (data == 1) {
                        return `<a href="javascript:void(0);"   onclick="notifwanumber(` + row['id'] + `,` + data + `)" ><i class="fas fa-check-circle text-success fa-2x"></i></a>`;
                    } else {
                        return `<a href="javascript:void(0);"   onclick="notifwanumber(` + row['id'] + `,` + data + `)" ><i class="fas fa-times-circle text-danger fa-2x"></i></a>`;
                    }
                }
            },
        ],
        "columnDefs": [
            {
                "targets": '_all',
                "defaultContent": '0'
            }
        ],
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
            $("#button_viewtablenotifwanumber").prop('disabled', false); // enable button
            document.querySelector('#button_viewtablenotifwanumber').innerHTML = 'Load';
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
function notifwanumber(id_role, fitur) {

    if (fitur == '1') {
        title = 'Nonaktif fitur ini?';
        var fitur_func = 'delete';
    } else {
        title = 'Aktifkan fitur ini?';
        var fitur_func = 'aktif';
    }
    Swal.fire({
        title: title,
        text: 'Data ini akan diupdate, pastikan kembali anda tidak salah pencet',
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
                    url: base_url + 'user/get_data_akses_user/updatenotifwanumber',
                    data: {
                        id: id_role,
                        fitur: fitur_func,
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
                            set_flashdata(parsedata.status, parsedata.comment);
                        } else {
                            set_flashdata(parsedata.status, parsedata.comment);
                        }
                        viewtablenotifwanumber();
                    },
                    complete: function () {

                    },

                });
        }
    })

}
function deleteuseridsharing(id_user, b_id) {
    console.log('here');

    var title = 'Delete Akun dari Kandang?';

    Swal.fire({
        title: title,
        text: 'Data ini akan diupdate, pastikan kembali anda tidak salah pencet',
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
                    url: base_url + 'user/get_data_akses_user/deleteuseridsharing',
                    data: {
                        id_user: id_user,
                        b_id: b_id,
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
                            set_flashdata(parsedata.status, parsedata.comment);
                        } else {
                            set_flashdata(parsedata.status, parsedata.comment);
                        }
                        viewtableaksesuser();
                    },
                    complete: function () {

                    },

                });
        }
    })

}
function add_number_notif_wa() {
    var id_user = $('#lokasi_number_wa').val();
    var type_number = $('#type_number_wa').val();
    var status_number = $('#status_number_wa').val();
    var number = $('#number_number_wa').val();
    $.ajax
        ({
            type: 'POST',
            url: base_url + 'user/get_data_akses_user/add_number_notif_wa',
            data: {
                id_user: id_user,
                type_number: type_number,
                status: status_number,
                number: number,
            },
            cache: false,
            beforeSend: function () {
            },
            success: function (data) {
                // loading("off");
                var parsedata = JSON.parse(data);
                console.log(parsedata);
                if (parsedata.status == 'success') {
                    set_flashdata(parsedata.status, parsedata.comment);
                    $('#number_number_wa').val('0');
                    $('#lokasi_number_wa').val('0').change();
                    $('#type_number_wa').val('group').change();
                    $('#status_number_wa').val('1').change();
                    $('#modal_add_number_notif').modal('hide');
                } else {
                    set_flashdata(parsedata.status, parsedata.comment);
                }
                viewtablenotifwanumber();
            },
            complete: function () {

            },

        });
}
