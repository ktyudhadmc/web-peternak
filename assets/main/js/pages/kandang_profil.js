function viewtablekandangprofil() {
    var id_user = $("#filter_lokasi").val();
    var ss = document.getElementById("filter_lokasi");
    var lokasi = ss.options[ss.selectedIndex].getAttribute('data-1');
    $('#exampletablekandangprofil tfoot th').each(function (data) {
        var title = $(this).text();
        if (title == "Kandang" || title == "Periode") {
            $(this).html('<br><input class="form-control" type="text" placeholder="Search ' + title + '" />');
        } else {
            $(this).html('');
        }
    });
    //---------Tabel Point Feed----------//
    var tpf = $('#exampletablekandangprofil').DataTable({
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
        buttons: [{ extend: 'excel', footer: true, title: 'Tabel Profil Kandang' },
        { extend: 'pdf', footer: true, title: 'Tabel Profil Kandang' },
        { extend: 'print', footer: true, title: 'Tabel Profil Kandang' },
        ],
        "ajax": {
            'type': 'POST',
            'url': base_url + 'main/kandang_profil/get_data_kandang_profil',
            'data': {
                lokasi: lokasi,
                id_user: id_user,
            },
            "dataSrc": "",
            beforeSend: function () {
                $("#button_viewtablekandangprofil").prop('disabled', true); // disable button
                document.querySelector('#button_viewtablekandangprofil').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
            },
        },
        "columns": [
            {
                "data": 'id',
                "className": 'dt-center ',
                "width": "1%",
                "render": function (data, type, row) {
                    var button = `  <a class="btn btn-sm btn-icon btn-bg-color btn-active-color-primary">
                                        <i class="white-true fas fa-search" style="font-size: 14px;"></i>
                                    </a>`
                    return button;
                }
            },
            { "data": 'nama' },
            { "data": 'panjang' },
            { "data": 'lebar' },
            { "data": 'tinggi' },
            { "data": 'kipas' },
            { "data": 'coolingpad' },
            { "data": 'tinggi_coolingpad' },
            { "data": 'pakan' },
            { "data": 'feeder_tray' },
            { "data": 'minum' },
            { "data": 'heater' },
            { "data": 'volumekandang' },
            { "data": 'ukurankipas' },
            { "data": 'merkkipas' },
            { "data": 'luasinlet' },
            { "data": 'panfeeder' },
            { "data": 'nipple' },

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
            $("#button_viewtablekandangprofil").prop('disabled', false); // enable button
            document.querySelector('#button_viewtablekandangprofil').innerHTML = 'Load';
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
    $('#exampletablekandangprofil').on('click', 'tbody tr', function () {
        // // console.log(base_url); //http://192.168.58.58/peternak_main/
        // window.location.href = base_url + `waiting?loadto=main/ternak/detail/aktif/` + tpf.row(this).data().id_kandang + '/' + tpf.row(this).data().periode;
        // // http://192.168.58.58/peternak_main/waiting?loadto=main/ternak/detail/aktif/161/20220916114144
        // // var data = `/rankings/team/${tpf.row(this).data()[3]}/d1m`;
        // // console.log(tpf.row(this).data())
        // // http://192.168.58.58/peternak_main/main/ternak/detail/aktif/144/20220913101742
    });
    $('#exampletablekandangprofil tbody tr').css('cursor', 'pointer');

}
function addprofil() {
    $('#modal_add_profil').modal('show');
}


