$('#exampletablechickin tfoot th').each(function () {
    var title = $(this).text();
    $(this).html('<br><input class="form-control" type="text" placeholder="Search ' + title + '" />');
});
//---------Tabel Point Feed----------//
var tpf = $('#exampletablechickin').DataTable({
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
    buttons: [{ extend: 'excel', footer: true, title: 'Tabel Invoice Internal' },
    { extend: 'pdf', footer: true, title: 'Tabel Invoice Internal' },
    { extend: 'print', footer: true, title: 'Tabel Invoice Internal' },
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
        // $("#button_viewtablewarning").prop('disabled', false); // enable button
        // document.querySelector('#button_viewtablewarning').innerHTML = 'Load';
        // document.querySelector('#tittle_table_warning').innerHTML = 'Tabel Warning';
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

$('#exampletableinternal tfoot th').each(function () {
    var title = $(this).text();
    $(this).html('<br><input class="form-control" type="text" placeholder="Search ' + title + '" />');
});
//---------Tabel Point Feed----------//
var tpf = $('#exampletableinternal').DataTable({
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
    buttons: [{ extend: 'excel', footer: true, title: 'Tabel Invoice Internal' },
    { extend: 'pdf', footer: true, title: 'Tabel Invoice Internal' },
    { extend: 'print', footer: true, title: 'Tabel Invoice Internal' },
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
        // $("#button_viewtablewarning").prop('disabled', false); // enable button
        // document.querySelector('#button_viewtablewarning').innerHTML = 'Load';
        // document.querySelector('#tittle_table_warning').innerHTML = 'Tabel Warning';
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

$('#exampletablebreeding tfoot th').each(function () {
    var title = $(this).text();
    $(this).html('<br><input class="form-control" type="text" placeholder="Search ' + title + '" />');
});
//---------Tabel Point Feed----------//
var tpf = $('#exampletablebreeding').DataTable({
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
    buttons: [{ extend: 'excel', footer: true, title: 'Tabel Invoice Breeding' },
    { extend: 'pdf', footer: true, title: 'Tabel Invoice Breeding' },
    { extend: 'print', footer: true, title: 'Tabel Invoice Breeding' },
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
        // $("#button_viewtablewarning").prop('disabled', false); // enable button
        // document.querySelector('#button_viewtablewarning').innerHTML = 'Load';
        // document.querySelector('#tittle_table_warning').innerHTML = 'Tabel Warning';
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
$('#exampletablebreedingmanado tfoot th').each(function () {
    var title = $(this).text();
    $(this).html('<br><input class="form-control" type="text" placeholder="Search ' + title + '" />');
});
//---------Tabel Point Feed----------//
var tpf = $('#exampletablebreedingmanado').DataTable({
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
    buttons: [{ extend: 'excel', footer: true, title: 'Tabel Invoice Breeding' },
    { extend: 'pdf', footer: true, title: 'Tabel Invoice Breeding' },
    { extend: 'print', footer: true, title: 'Tabel Invoice Breeding' },
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
        // $("#button_viewtablewarning").prop('disabled', false); // enable button
        // document.querySelector('#button_viewtablewarning').innerHTML = 'Load';
        // document.querySelector('#tittle_table_warning').innerHTML = 'Tabel Warning';
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

