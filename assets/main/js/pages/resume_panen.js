function viewtableresumepanen() {
    var range = document.querySelector('#filter_range').value;
    var id_user = $("#filter_lokasi").val();
    var ss = document.getElementById("filter_range");
    var range1 = ss.options[ss.selectedIndex].getAttribute('data-1');
    var range2 = ss.options[ss.selectedIndex].getAttribute('data-2');
    $('#exampletableresumepanen tfoot th').each(function () {
        var title = $(this).text();
        // $(this).html('<br><input class="form-control" type="text" placeholder="Search ' + title + '" />');
        $(this).html('');
    });
    //---------Tabel Point Feed----------//
    var tpf = $('#exampletableresumepanen').DataTable({
        // filter: false,
        "info": true,
        "destroy": true,
        "lengthChange": false,
        "order": [[0, "desc"]],
        "paging": true,
        "pageLength": -1,
        "lengthMenu": [[7, 10, 25, 50, -1], [7, 10, 25, 50, "All"]],
        "scrollCollapse": true,
        "scrollY": "350px",
        "scrollX": true,
        dom: '<"top"B>rt<"bottom"ilp><"clear">',
        buttons: [{ extend: 'excel', footer: true, title: 'Tabel Resume' },
        { extend: 'pdf', footer: true, title: 'Tabel Resume' },
        { extend: 'print', footer: true, title: 'Tabel Resume' },
            // {
            //     extend: 'copy',
            //     text: 'Copy current page',
            //     exportOptions: {
            //         modifier: {
            //             page: 'current'
            //         }
            //     }
            // }
        ],
        "ajax": {
            'type': 'POST',
            'url': base_url + 'main/resume_panen/get_data_resume_panen',
            'data': {
                range1: range1,
                range2: range2,
                id_user: id_user,
            },
            "dataSrc": "",
            beforeSend: function () {
                $("#button_viewtableresumepanen").prop('disabled', true); // disable button
                document.querySelector('#button_viewtableresumepanen').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
            },
        },
        "columns": [
            {
                "data": 'id_kandang',
                "className": 'text-nowrap',
                "render": function (data, type, row) {
                    var button = `  <a href="` + base_url + `/main/ternak/detail/` + row['status_kandang'] + `/` + row['id_kandang'] + `/` + row['periode'] + `"  class="btn btn-sm btn-icon btn-bg-color btn-active-color-primary">
                                        <i class="white-true fas fa-search" style="font-size: 14px;"></i>
                                    </a>`
                    return button;
                }
            },
            { 'data': 'nama' },
            { 'data': 'periode' },
            { 'data': 'strain' },
            { 'data': 'tanggal_chickin' },
            { 'data': 'umur' },
            { 'data': 'umur_saat_ini' },
            { 'data': 'populasi' },
            { 'data': 'deplesi' },
            { 'data': 'deplesi_persent' },
            { 'data': 'ip' },
            { 'data': 'act_adg' },
            { 'data': 'bw' },
            { 'data': 'act_fcr' },
            { 'data': 'tot_bw' },
        ],
        "columnDefs": [
            {
                "targets": '_all',
                "defaultContent": '0',
                "className": 'dt-center',
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
            $("#button_viewtableresumepanen").prop('disabled', false); // enable button
            document.querySelector('#button_viewtableresumepanen').innerHTML = 'Load';
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

            var coltosum = [];
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
