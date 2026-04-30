function bop() {
    const outputbop = $("#outputbop");
    if (outputbop.html() == "") {
        $.ajax({
            method: "POST",
            data: {
                user_id: useridfinal,
                token: tokenfinal,
                kandangperiode: idkandangperiode
            },
            url: base_url + 'ajax/bop/',
            cache: false,
            beforeSend: function () {
                outputbop.html(loadingnih());
            },
            success: function (response) {
                outputbop.html(response);
                bop_view();
            }
        });
    }
}

function bop_view() {
    var data_ews_kematian = [];
    // for (let i = 0; i < datajson.length; i++) {
    //     let obj = {
    //         tanggal: datajson[i]['tanggal'],
    //         umur: datajson[i]['umur'],
    //         nilai: datajson[i]['total_mati'],
    //         ket: datajson[i]['ket_ews_mati'],
    //         id_ket: datajson[i]['id_ews_mati'],
    //         type_ews: 'mati',
    //     }
    //     if (datajson[i]['ews_mati']) {
    //         data_ews_kematian.push(obj);
    //     }
    // }
    var tablebop = $('#tablebop').DataTable({
        "info": true,
        "destroy": true,
        "lengthChange": true,
        "order": [
            [0, "desc"]
        ],
        "paging": false,
        "pageLength": -1,
        "lengthMenu": [
            [7, 10, 25, 50, -1],
            [7, 10, 25, 50, "All"]
        ],
        "scrollCollapse": true,
        "scrollY": "350px",
        "scrollX": true,
        // dom: '<"top"B>rt<"bottom"ilp><"clear">',
        // buttons: [{
        //         extend: 'excel',
        //         footer: true,
        //         title: 'Tabel Resume'
        //     },
        //     {
        //         extend: 'pdf',
        //         footer: true,
        //         title: 'Tabel Resume'
        //     },
        //     {
        //         extend: 'print',
        //         footer: true,
        //         title: 'Tabel Resume'
        //     },
        // ],
        "ajax": {
            'type': 'POST',
            'url': base_url + 'ajax/bop/getdata',
            'data': {
                user_id: useridfinal,
                token: tokenfinal,
                kandangperiode: idkandangperiode
            },
            "dataSrc": "",
            beforeSend: function () {
                // $("#button_viewtableresumeopen").prop('disabled', true); // disable button
                // document.querySelector('#button_viewtableresumeopen').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
            },
        },
        "columns": [{
                "data": 'tanggal'
            },
            {
                'data': 'harga'
            },
            {
                'data': null
            },
            {
                'data': 'satuan'
            },
            {
                'data': 'qty'
            },
            {
                'data': 'ket'
            },
            {
                'data': null
            }
        ],
        "columnDefs": [{
            "targets": '_all',
            "defaultContent": '0',
            "className": 'dt-center',
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
                        console.log(that.search(this.value).draw())
                        if (that.search() !== this.value) {
                            that.search(this.value).draw();
                        }
                    });
                });
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
    $('#tablebop').on('click', 'tbody tr', function () {
        // // console.log(base_url); //http://192.168.58.58/peternak_main/
        // window.location.href = base_url + `waiting?loadto=main/ternak/detail/aktif/` + tpf.row(this).data().id_kandang + '/' + tpf.row(this).data().periode;
        // // http://192.168.58.58/peternak_main/waiting?loadto=main/ternak/detail/aktif/161/20220916114144
        // // var data = `/rankings/team/${tpf.row(this).data()[3]}/d1m`;
        // // console.log(tpf.row(this).data())
        // // http://192.168.58.58/peternak_main/main/ternak/detail/aktif/144/20220913101742
    });
    $('#tablebop tbody tr').css('cursor', 'pointer');
}
function modaltambahbopshow() {
    $("#modalbop").modal('show');
}

function inputbop() {
    var tanggal = $("#tanggal_bop").val();
    var keterangan = $("#input_ket_bop").val();
    var qty = $("#input_qty_bop").val();
    var satuan = $("#input_satuan_bop").val();
    var harga = $("#input_harga_bop").val();
    const data = new FormData();
    data.append('tanggal',tanggal);
    data.append('keterangan',keterangan);
    data.append('qty',qty);
    data.append('satuan',satuan);
    data.append('harga',harga);
    console.log(data);
}