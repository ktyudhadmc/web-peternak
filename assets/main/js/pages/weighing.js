
// function loaddatasensor(mindatefilter, maxdatefilter) {
function loaddatasensor_weighing() {
    var datatabel;
    var id_kandang = $('#filter_kandang_sensor').val();
    var periode = $('#filter_periode_sensor').val();
    // var sensor = $('#filter_sensor').val();

    var sensor = "weighing";
    var range_tanggal_sensor_max = $('#range_tanggal_sensor_max').val();
    var range_tanggal_sensor_min = $('#range_tanggal_sensor_min').val();

    var option_chart_data;
    if (document.getElementById("chartviewsensor_weighing").style.display == 'none') {
        option_chart_data = 'none';
    } else {
        option_chart_data = 'update';
    }
    $.ajax({
        'type': "POST",
        'url': base_url + 'main/temperature/loaddata_weighing',
        'data': {
            id_kandang: id_kandang,
            periode: periode,
            sensor: sensor,
            // mindate: mindatefilter,
            // maxdate: maxdatefilter,
        },
        'cache': false,
        'beforeSend': function () {
            document.getElementById("chartviewsensor_weighing").style.display = "none";
            document.getElementById("none_sensorchart_weighing").style.display = "none";
            document.getElementById("chartloadingsensor_weighing").style.display = "";
            // $("#button_calculate").prop('disabled', true); // disable button
            // document.querySelector('#button_calculate').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
        },
        'success': function (data) {
            var parsedata = JSON.parse(data);
            if (parsedata.status == "gagal") {
                set_flashdata('error', 'Belum Ada Data');
                document.getElementById("none_sensorchart_weighing").style.display = "";
                document.getElementById("chartviewsensor_weighing").style.display = "none";
                document.getElementById("chartloadingsensor_weighing").style.display = "none";
                document.getElementById("ket_notif_sensor_weighing").innerHTML = "Belum Ada Data";
            } else {
                var sensorchart_weighing = document.getElementById('kt_sensorchart_weighing');
                var sensorchart_line_weighing = document.getElementById('kt_sensorchart_line_weighing');
                var options_chart_head_weighing = {
                    series: [],
                    chart: {
                        id: 'chart2_weighing',
                        type: 'line',
                        height: 230,
                        toolbar: {
                            show: true,
                            autoSelected: 'zoom',
                            tools: {
                                download: true,
                                selection: false,
                                zoom: false,
                                zoomin: false,
                                zoomout: false,
                                pan: false,
                                reset: false | '<img src="/static/icons/reset.png" width="20">',
                                customIcons: []
                            },
                            export: {
                                csv: {
                                    filename: undefined,
                                    columnDelimiter: ',',
                                    headerCategory: 'category',
                                    headerValue: 'value',
                                    dateFormatter(timestamp) {
                                        return new Date(timestamp).toDateString()
                                    }
                                },
                                svg: {
                                    filename: undefined,
                                },
                                png: {
                                    filename: undefined,
                                }
                            },
                        },
                    },
                    colors: [
                        '#ff8303', '#949494'
                    ],
                    stroke: {
                        curve: 'smooth',
                        width: 1
                    },
                    legend: {
                        fontSize: "9px",
                        position: 'top',
                        horizontalAlign: 'left'
                    },
                    grid: {
                        borderColor: "#45404a2e",
                        padding: {
                            left: 0,
                            right: 0
                        },
                        strokeDashArray: 4,
                    },
                    dataLabels: {
                        enabled: false
                    },
                    fill: {
                        opacity: 1,
                    },
                    markers: {
                        size: 0
                    },
                    xaxis: {
                        type: 'datetime',
                        labels: {
                            formatter: function (value) {
                                var data_date = new Date(value).toString().slice(4, 10);
                                return data_date;
                            },
                        },
                        // categories: xaxis,
                    },
                    tooltip: {
                        custom: function ({
                            series,
                            seriesIndex,
                            dataPointIndex,
                            w
                        }) {
                            var data_weighing = w.globals.initialSeries[0].data[dataPointIndex];
                            var data_ratarata = w.globals.initialSeries[1].data[dataPointIndex];
                            var output = `
                            <div class="apexcharts-tooltip-title" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">Time : ` + data_weighing.x + `</div>
                            <div class="apexcharts-tooltip-series-group apexcharts-active" style="order: 1; display: flex;">
                                <div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                <div class="apexcharts-tooltip-y-group">
                                <span class="apexcharts-tooltip-text-y-label">BW : </span>
                                <span class="apexcharts-tooltip-text-y-value">` + data_weighing.y + ` Gram</span>
                                </div>
                                <div class="apexcharts-tooltip-y-group">
                                <span class="apexcharts-tooltip-text-y-label">Std BW : </span>
                                <span class="apexcharts-tooltip-text-y-value">` + data_ratarata.y + ` Gram</span>
                                </div>
                                <div class="apexcharts-tooltip-goals-group">
                                    <span class="apexcharts-tooltip-text-goals-label"></span>
                                    <span class="apexcharts-tooltip-text-goals-value"></span>
                                </div>
                                <div class="apexcharts-tooltip-z-group">
                                    <span class="apexcharts-tooltip-text-z-label"></span>
                                    <span class="apexcharts-tooltip-text-z-value"></span>
                                </div>
                                </div>
                            </div>                        
                            `
                            return output;

                        },
                        style: {
                            fontSize: '8px',
                        },
                        theme: 'light'
                    },
                };
                if (sensorchart_weighing) {
                    var sensorchart_head_render_weighing = new ApexCharts(sensorchart_weighing, options_chart_head_weighing);
                    var outputrenderhead = sensorchart_head_render_weighing.render();
                }
                var options_chart_line_top_weighing = {
                    series: [],
                    chart: {
                        id: 'chart1_weighing',
                        height: 130,
                        type: 'area',
                        brush: {
                            target: 'chart2_weighing',
                            enabled: true
                        },
                        selection: {
                            enabled: true,
                            xaxis: {

                            }
                        },
                    },
                    colors: ['#008FFB'],
                    fill: {
                        type: 'gradient',
                        gradient: {
                            opacityFrom: 0.91,
                            opacityTo: 0.1,
                        }
                    },
                    // xaxis: {
                    //     type: 'datetime',
                    //     min: new Date('01 Mar 2012').getTime(),
                    //     tickAmount: 6,
                    //     tooltip: {
                    //         enabled: false
                    //     }
                    // },
                    xaxis: {
                        type: 'datetime',
                        // categories: xaxis_sensor,
                        tooltip: {
                            enabled: false
                        }
                    },
                    yaxis: {
                        tickAmount: 2
                    }
                };
                if (sensorchart_line_weighing) {
                    var sensorchart_line_render_weighing = new ApexCharts(sensorchart_line_weighing, options_chart_line_top_weighing);
                    var outputrenderline = sensorchart_line_render_weighing.render();
                }
                document.getElementById("tittle_sensorchart_weighing").innerHTML = `Chart Logger BW ` + parsedata.namakandang;
                document.getElementById("tittle_sensorchart_weighing_total").innerHTML = `Total BW ` + parsedata.data_weighing + ` L `;
                var ketmindate = parsedata.ketmindate;
                var ketmaxdate = parsedata.ketmaxdate;
                var xaxis_sensor = [];
                var yaxis_sensor = [];
                var jsonchartdata_avg = [];
                var jsonchartdata_temp1 = [];
                var jsonchartdata_temp2 = [];
                var jsonchartdata_temp3 = [];
                var jsonchartdata_tempext = [];
                var jsonchartdata_set = [];
                var jsonchartdata_weighing = [];
                var minxaxis_sensor = parsedata.data[0].created_at;
                var maxxaxis_sensor = parsedata.data[parsedata.data.length - 1].created_at;
                datatabel = parsedata.data;
                for (let i = 0; i < parsedata.data.length; i++) {
                    // const element = array[i];
                    var datachart_avg = {
                        "x": parsedata.data[i].created_at,
                        "y": parsedata.data[i].bw_std,
                    };
                    var datachart_temp1 = {
                        "x": parsedata.data[i].created_at,
                        "y": parsedata.data[i].temp_1,
                    };
                    var datachart_temp2 = {
                        "x": parsedata.data[i].created_at,
                        "y": parsedata.data[i].temp_2,
                    };
                    var datachart_temp3 = {
                        "x": parsedata.data[i].created_at,
                        "y": parsedata.data[i].temp_3,
                    };
                    var datachart_tempext = {
                        "x": parsedata.data[i].created_at,
                        "y": parsedata.data[i].temp_ext,
                    };
                    var datachart_set = {
                        "x": parsedata.data[i].created_at,
                        "y": parsedata.data[i].set_temp,
                    };
                    var datachart_weighing = {
                        "x": parsedata.data[i].created_at,
                        "y": parsedata.data[i].bw,
                    };
                    jsonchartdata_avg.push(datachart_avg);
                    jsonchartdata_temp1.push(datachart_temp1);
                    jsonchartdata_temp2.push(datachart_temp2);
                    jsonchartdata_temp3.push(datachart_temp3);
                    jsonchartdata_tempext.push(datachart_tempext);
                    jsonchartdata_set.push(datachart_set);
                    jsonchartdata_set.push(datachart_set);
                    jsonchartdata_weighing.push(datachart_weighing);
                    xaxis_sensor.push(parsedata.data[i].created_at);
                    yaxis_sensor.push(parsedata.data[i].bw);

                }

                // console.log(xaxis_sensor);
                // console.log(jsonchartdata_avg);


                var options_chart_line = {
                    series: [{
                        name: 'Actual',
                        data: yaxis_sensor
                    }],
                    chart: {
                        id: 'chart1_weighing',
                        height: 130,
                        type: 'area',
                        brush: {
                            target: 'chart2_weighing',
                            enabled: true
                        },
                        selection: {
                            enabled: true,
                            xaxis: {
                                min: new Date(minxaxis_sensor).getTime(),
                                max: new Date(maxxaxis_sensor).getTime()
                            }
                        },
                    },
                    colors: ['#008FFB'],
                    fill: {
                        type: 'gradient',
                        gradient: {
                            opacityFrom: 0.91,
                            opacityTo: 0.1,
                        }
                    },
                    xaxis: {
                        type: 'datetime',
                        categories: xaxis_sensor,
                        labels: {
                            formatter: function (value) {
                                var data_date = new Date(value).toString().slice(4, 10);
                                return data_date;
                            },
                        },
                        tooltip: {
                            enabled: false
                        }
                    },
                    yaxis: {
                        tickAmount: 2
                    }
                };




                // var tpfsensor = $('#tablesensor_weighing').DataTable({
                //     // filter: false,
                //     "info": true,
                //     "destroy": true,
                //     "lengthChange": true,
                //     "order": [
                //         [0, "desc"]
                //     ],
                //     "paging": false,
                //     "pageLength": -1,
                //     "lengthMenu": [
                //         [7, 10, 25, 50, -1],
                //         [7, 10, 25, 50, "All"]
                //     ],
                //     "scrollCollapse": true,
                //     "scrollY": "300px",
                //     "scrollX": true,
                //     dom: '<"top">rt<"bottom"><"clear">',

                //     "data": datatabel,
                //     "columns": [{
                //         'data': 'created_at'
                //     },
                //     {
                //         'data': 'BW'
                //     },

                //     ],
                //     "columnDefs": [{
                //         "targets": '_all',
                //         "defaultContent": '0',
                //         "className": 'dt-center',
                //     }],
                //     "order": [
                //         [0, 'desc']
                //     ],

                //     initComplete: function () {
                //         this.api().buttons().container()
                //             .appendTo($('.col-md-6:eq(0)', this.api().table().container()));
                //         this.api()
                //             .columns()
                //             .every(function () {
                //                 var that = this;
                //                 $('input', this.footer()).on('keyup change clear', function () {
                //                     // console.log(that.search(this.value).draw())
                //                     if (that.search() !== this.value) {
                //                         that.search(this.value).draw();
                //                     }
                //                 });
                //             });
                //     },
                //     "footerCallback": function (row, data, start, end, display) {
                //         var api = this.api(),
                //             data;
                //         // Remove the formatting to get integer data for summation
                //         var intVal = function (i) {
                //             return typeof i === 'string' ?
                //                 i.replace(/[\$,]/g, '') * 1 :
                //                 typeof i === 'number' ?
                //                     i : 0;
                //         };

                //         var coltosum = []
                //         for (c in coltosum) {
                //             // Total over all pages
                //             // console.log(api.column( coltosum[c] ).data())
                //             // total = api.column( coltosum[c] ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
                //             // Total over this page
                //             pageTotal = api.column(coltosum[c], {
                //                 page: 'current'
                //             }).data().reduce(function (a, b) {
                //                 return intVal(a) + intVal(b);
                //             }, 0);
                //             // Update footer
                //             $(api.column(coltosum[c]).footer()).html(pageTotal);
                //         }
                //     }
                // });
                // var buttonsadg = new $.fn.dataTable.Buttons(tpfsensor, {
                //     buttons: [{
                //         extend: 'excel',
                //         footer: true,
                //         title: 'Tabel Sensor'
                //     },
                //     {
                //         extend: 'pdf',
                //         footer: true,
                //         title: 'Tabel Sensor'
                //     },
                //     {
                //         extend: 'print',
                //         footer: true,
                //         title: 'Tabel Sensor'
                //     },
                //     ]
                // }).container().appendTo($('#buttonsmodaltabelsensor_weighing'));
                document.getElementById("none_sensorchart_weighing").style.display = "none";
                document.getElementById("chartloadingsensor_weighing").style.display = "none";
                document.getElementById("chartviewsensor_weighing").style.display = "";

                // if (mindatefilter && maxdatefilter) {
                sensorchart_head_render_weighing.updateSeries([{
                    name: 'BW',
                    data: jsonchartdata_weighing
                }, {
                    name: 'STD BW',
                    data: jsonchartdata_avg
                },
                ])
                sensorchart_line_render_weighing.updateOptions(options_chart_line)
                //     $('#range_tanggal_sensor').daterangepicker({
                //         startDate: new Date(minxaxis_sensor),
                //         endDate: new Date(maxxaxis_sensor),
                //         minDate: new Date(range_tanggal_sensor_min),
                //         maxDate: new Date(range_tanggal_sensor_max),
                //     });

                //     $('#ketrangetgl').html(`Data Tersedia ` + ketmindate + ` -> ` + ketmaxdate);

                //     set_flashdata('success', 'Proses kalkulasi berhasil');
                // } else {
                //     $('#range_tanggal_sensor_min').val(minxaxis_sensor);
                //     $('#range_tanggal_sensor_max').val(maxxaxis_sensor);
                //     $('#range_tanggal_sensor').daterangepicker(
                //         {
                //             minDate: new Date(minxaxis_sensor),
                //             maxDate: new Date(maxxaxis_sensor),
                //             startDate: new Date(minxaxis_sensor),
                //             endDate: new Date(maxxaxis_sensor),
                //         });
                //     $('#ketrangetgl').html(`Data Tersedia ` + ketmindate + ` -> ` + ketmaxdate);
                // }
            }
        },
        'complete': function () {

            // $("#button_calculate").prop('disabled', false); // enable button
            // document.querySelector('#button_calculate').innerHTML = 'Calculate';
        },

    });

}
$('#modal_sensorchart_weighing').on('shown.bs.modal', function (e) {
    $('#tablesensor_weighing').DataTable()
        .columns.adjust()
        .fixedColumns().relayout();
})

// function loaddatasensortanggal() {
//     var mindatefilter = $('#range_tanggal_sensor').data('daterangepicker').startDate.format('YYYY-MM-DD');
//     var maxdatefilter = $('#range_tanggal_sensor').data('daterangepicker').endDate.format('YYYY-MM-DD');
//     loaddatasensor(mindatefilter, maxdatefilter)
// }