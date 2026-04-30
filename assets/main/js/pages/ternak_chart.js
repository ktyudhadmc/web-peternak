var data;
var tablebw;
var tablefcr;
var tablefeed;
var tabledeplesi;
var tablepopulasi;
var tableadg;
let datajson;

function chartjs() {

    var bwxaxis = [];
    var bwvalue = [];
    var bwstd = [];
    var bwews = [];
    var act_fcr = [];
    var std_fcr = [];
    var act_feed_intake = [];
    var std_feed_intake = [];
    var act_adg = [];
    var std_adg = [];
    var populasi = [];
    var mati = [];
    var matiews = [];
    var culling = [];
    var json_ews_bw = [];
    var json_bw_act = [];
    var json_bw_std = [];
    var json_mati = [];
    var json_matiews = [];
    var json_culling = [];
    var json_bw_panen = [];
    let datanew2 = ["a", "c", "d"];
    var status_kandang_activity;

    var url = base_url + 'ajax/p/bw';
    // var url = base_url + 'ajax/p/bw3';
    var kandang_periode = document.getElementById('kandang_periode');
    kandang_periode = kandang_periode.value.split("|");
    var databw = new FormData()
    databw.append('idkandang', kandang_periode[0])
    databw.append('periode', kandang_periode[1])
    var bwchart = document.getElementById('kt_bwchart');
    var fcrchart = document.getElementById('kt_fcrchart');
    var feedchart = document.getElementById('kt_feedchart');
    var deplesichart = document.getElementById('kt_deplesichart');
    var populasichart = document.getElementById('kt_populasichart');
    var adgchart = document.getElementById('kt_adgchart');
    // console.log(loadingnih());
    const bwchartload = $("#kt_bwchart");
    const fcrchartload = $('#kt_fcrchart');
    const feedchartload = $('#kt_feedchart');
    const deplesichartload = $('#kt_deplesichart');
    const populasichartload = $('#kt_populasichart');
    const adgchartload = $('#kt_adgchart');
    bwchartload.html(loadingnih());
    fcrchartload.html(loadingnih());
    feedchartload.html(loadingnih());
    deplesichartload.html(loadingnih());
    populasichartload.html(loadingnih());
    adgchartload.html(loadingnih());
    // console.log(senddata(url, data, 'post',responseText))
    senddata(url, databw, 'post', function (responseText) {
        //   console.log(JSON.parse(responseText));
        datanew1 = JSON.parse(responseText);
        // console.log(datanew1);
        datajson = datanew1;
        datanew1.forEach((element) => {
            var data_ews_bw = {
                "x": element.umur,
                "y": element.ews_bw,
                "nilai": element.ews_bw_value,
                "ket": element.bw
            };
            var data_bw_act = {
                "x": element.umur,
                "y": element.bw,
                "nilai": element.umur,
                "ket": element.bw
            };
            var data_bw_std = {
                "x": element.umur,
                "y": element.std_bw,
                "nilai": element.umur,
                "ket": element.bw
            };
            var data_bw_panen = {
                "x": element.umur,
                "y": element.bw_panen,
                "umur": element.umur_rata_panen,
            };
            json_ews_bw.push(data_ews_bw);
            json_bw_act.push(data_bw_act);
            json_bw_std.push(data_bw_std);
            json_bw_panen.push(data_bw_panen);
            var data_mati = {
                "x": element.umur,
                "y": element.mati,
            };
            var data_culling = {
                "x": element.umur,
                "y": element.culling,
            };
            var data_matiews = {
                "x": element.umur,
                "y": element.ews_mati,
                "persen_deplesi": element.persen_deplesi,
                "total_mati": element.total_mati,
            };
            json_mati.push(data_mati);
            json_culling.push(data_culling);
            json_matiews.push(data_matiews);
            bwxaxis.push(element.umur);
            bwvalue.push(element.bw);
            bwstd.push(element.std_bw);
            bwews.push(element.ews_bw);
            act_fcr.push(element.act_fcr);
            std_fcr.push(element.std_fcr);
            act_feed_intake.push(element.act_feed_intake);
            std_feed_intake.push(element.std_feed_intake);
            act_adg.push(element.act_adg);
            std_adg.push(element.std_adg);
            populasi.push(element.populasi);
            mati.push(element.mati);
            matiews.push(element.ews_mati);
            culling.push(element.culling);
            status_kandang_activity = element.status_kandang_activity;
        });
        var color_bw;
        var series_bw;
        var fill_bw;
        var markers_bw;
        var tooltip_bw;

        if (status_kandang_activity === 'aktif') {
            color_bw = ['#ff8303', '#C0C0C0', '#fa1302'];
            series_bw = [{
                name: 'Actual',
                data: json_bw_act,
                type: 'area'
            }, {
                name: 'Standard',
                data: json_bw_std,
                type: 'area'
            }, {
                name: 'Ews',
                data: json_ews_bw,
                type: 'scatter'

            }];
            fill_bw = {
                type: ['solid', 'solid', 'image'],
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.3,
                    stops: [0, 90, 100]
                },
                image: {
                    src: ['solid', 'solid', base_url_ternak + 'assets/resource/icon/warning.svg'],
                    width: 20,
                    height: 20
                },
                colors: ['transparent', 'transparent', 'transparent']
            };
            markers_bw = {
                size: [0, 0, 10],
                strokeWidth: 0,
                hover: {
                    sizeOffset: 0
                }
            };
        } else {
            color_bw = ['#ff8303', '#C0C0C0', '#fa1302', '#8DC3A7'];
            series_bw = [{
                name: 'Actual',
                data: json_bw_act,
                type: 'area'
            }, {
                name: 'Standard',
                data: json_bw_std,
                type: 'area'
            }, {
                name: 'Ews',
                data: json_ews_bw,
                type: 'scatter'

            }, {
                name: 'Rataan panen',
                data: json_bw_panen,
                type: 'column'

            }];
            fill_bw = {
                // type: 'image',
                type: ['solid', 'solid', 'image', 'solid'],
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.3,
                    stops: [0, 90, 100]
                },
                image: {
                    // src: ['solid', 'solid', base_url_ternak + 'assets/resource/icon/warning.svg', base_url_ternak + 'assets/resource/icon/chick.svg'],
                    src: ['solid', 'solid', base_url_ternak + 'assets/resource/icon/warning.svg', 'solid'],
                    width: 20,
                    height: 20
                },
                // image2: {
                //     src: base_url_ternak + 'assets/resource/icon/chick.svg',
                //     width: 20,
                //     height: 20
                // },
                colors: ['transparent', 'transparent', 'transparent', '#8DC3A7']
                // colors: ['transparent']
            };
            markers_bw = {
                size: [0, 0, 10, 10],
                strokeWidth: 0,
                hover: {
                    sizeOffset: 0
                }
            };
        }
        // console.log(color_bw);
        var options_chart_bw = {
            chart: {
                height: 300,
                width: '100%',
                type: 'area',
                stacked: false,
                toolbar: {
                    show: true,
                    tools: {
                        download: true,
                        selection: false,
                        zoom: false,
                        zoomin: false,
                        zoomout: false,
                        pan: false,
                        reset: false | '<img src="/static/icons/reset.png" width="20">',
                        customIcons: [],
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
                zoomType: 'x',
                scrollablePlotArea: {
                    minWidth: 600,
                    scrollPositionX: 1
                },
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 300
                    }
                }
            }],
            colors: color_bw,
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 1
            },
            grid: {
                borderColor: "#45404a2e",
                padding: {
                    left: 0,
                    right: 0
                },
                strokeDashArray: 4,
            },
            // markers: {
            //     size: 0,
            //     hover: {
            //         size: 0
            //     }
            // },
            markers: markers_bw,
            series: series_bw,
            xaxis: {
                type: 'number',
                // categories: bwxaxis,
                axisBorder: {
                    show: true,
                    color: '#45404a2e',
                },
                axisTicks: {
                    show: true,
                    color: '#45404a2e',
                },
                labels: {
                    style: {
                        fontSize: '7px'
                    },
                },
                tickAmount: 20
            },
            yaxis: {
                labels: {
                    style: {
                        fontSize: '9px'
                    }
                }
            },
            legend: {
                fontSize: "9px",
                position: 'top',
                horizontalAlign: 'left'
            },
            fill: fill_bw,
            tooltip: {
                custom: function ({
                    series,
                    seriesIndex,
                    dataPointIndex,
                    w
                }) {
                    var data_act = w.globals.initialSeries[0].data[dataPointIndex];
                    var data_std = w.globals.initialSeries[1].data[dataPointIndex];
                    var data_ews = w.globals.initialSeries[2].data[dataPointIndex];
                    if (status_kandang_activity === 'rehat') {
                        var data_bw_panen = w.globals.initialSeries[3].data[dataPointIndex];
                        if (data_bw_panen.y) {
                            var output_panen = `
                            <div class="apexcharts-tooltip-series-group apexcharts-active" style="order: 2; display: flex;">
                            <div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                            <div class="apexcharts-tooltip-y-group">
                                <span class="apexcharts-tooltip-text-y-label">Rataan panen: </span>
                                <span class="apexcharts-tooltip-text-y-value">` + data_bw_panen.y + ` g</span>
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
                            <div class="apexcharts-tooltip-series-group apexcharts-active" style="order: 2; display: flex;">
                            <div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                            <div class="apexcharts-tooltip-y-group">
                                <span class="apexcharts-tooltip-text-y-label">Umur Panen: </span>
                                <span class="apexcharts-tooltip-text-y-value">` + data_bw_panen.umur + ` hari</span>
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
                            `;
                        } else {
                            var output_panen = ``;
                        }
                    } else {
                        var output_panen = ``;
                    }
                    if (data_ews.nilai != '-') {
                        var output_ews = `
                            <div class="apexcharts-tooltip-series-group apexcharts-active" style="order: 2; display: flex;">
                            <div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                            <div class="apexcharts-tooltip-y-group">
                                <span class="apexcharts-tooltip-text-y-label">EWS: </span>
                                <span class="apexcharts-tooltip-text-y-value">` + data_ews.nilai + ` hari</span>
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
                            `;
                    } else {
                        var output_ews = ``;
                    }


                    var output = `
                        <div class="apexcharts-tooltip-title" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">` + data_act.x + `</div>
                        <div class="apexcharts-tooltip-series-group apexcharts-active" style="order: 1; display: flex;">
                            <div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                            <div class="apexcharts-tooltip-y-group">
                                <span class="apexcharts-tooltip-text-y-label">Actual: </span>
                                <span class="apexcharts-tooltip-text-y-value">` + data_act.y + ` g</span>
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
                        <div class="apexcharts-tooltip-series-group apexcharts-active" style="order: 2; display: flex;">
                            <div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                            <div class="apexcharts-tooltip-y-group">
                                <span class="apexcharts-tooltip-text-y-label">Standard: </span>
                                <span class="apexcharts-tooltip-text-y-value">` + data_std.y + ` g</span>
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
                        ` + output_ews + `
                        ` + output_panen + `
                        `
                    return output;
                },
                style: {
                    fontSize: '8px',
                },
                theme: 'light'
            },
            legend: {
                fontSize: "9px",
                position: 'top',
                horizontalAlign: 'left'
            },
            markers: markers_bw,
        };
        var options_chart_fcr = {
            chart: {
                height: 300,
                width: '100%',
                type: 'area',
                stacked: false,
                toolbar: {
                    show: true,
                    tools: {
                        download: true,
                        selection: false,
                        zoom: false,
                        zoomin: false,
                        zoomout: false,
                        pan: false,
                        reset: false | '<img src="/static/icons/reset.png" width="20">',
                        customIcons: [],
                    },
                    export: {
                        svg: {
                            filename: undefined,
                        },
                        png: {
                            filename: undefined,
                        }
                    },
                },
                zoomType: 'x',
                scrollablePlotArea: {
                    minWidth: 600,
                    scrollPositionX: 1
                },
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 300
                    }
                }
            }],
            colors: ['#ff8303', '#C0C0C0'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 1
            },
            grid: {
                borderColor: "#45404a2e",
                padding: {
                    left: 0,
                    right: 0
                },
                strokeDashArray: 4,
            },
            markers: {
                size: 0,
                hover: {
                    size: 0
                }
            },
            series: [{
                name: 'Actual',
                data: act_fcr
            }, {
                name: 'Standard',
                data: std_fcr
            }],

            xaxis: {
                type: 'month',
                categories: bwxaxis,
                axisBorder: {
                    show: true,
                    color: '#45404a2e',
                },
                axisTicks: {
                    show: true,
                    color: '#45404a2e',
                },
                labels: {
                    style: {
                        fontSize: '7px'
                    },
                },
                tickAmount: 20
            },
            yaxis: {
                labels: {
                    style: {
                        fontSize: '9px'
                    }
                }
            },
            fill: {
                type: "solid",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.3,
                    stops: [0, 90, 100]
                },
                colors: ['transparent']
            },
            tooltip: {
                style: {
                    fontSize: '12px',
                },
                theme: 'light'
            },
            legend: {
                fontSize: "9px",
                position: 'top',
                horizontalAlign: 'left'
            },
        };
        var options_chart_adg = {
            chart: {
                height: 300,
                width: '100%',
                type: 'area',
                stacked: false,
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
                zoomType: 'x',
                scrollablePlotArea: {
                    minWidth: 600,
                    scrollPositionX: 1
                },
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 300
                    }
                }
            }],
            colors: ['#ff8303', '#C0C0C0'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 1
            },
            grid: {
                borderColor: "#45404a2e",
                padding: {
                    left: 0,
                    right: 0
                },
                strokeDashArray: 4,
            },
            markers: {
                size: 0,
                hover: {
                    size: 0
                }
            },
            series: [{
                name: 'Actual',
                data: act_adg
            }, {
                name: 'Standard',
                data: std_adg
            }],

            xaxis: {
                type: 'month',
                categories: bwxaxis,
                axisBorder: {
                    show: true,
                    color: '#45404a2e',
                },
                axisTicks: {
                    show: true,
                    color: '#45404a2e',
                },
                labels: {
                    style: {
                        fontSize: '7px'
                    },
                },
                tickAmount: 20
            },
            yaxis: {
                labels: {
                    style: {
                        fontSize: '9px'
                    }
                }
            },
            fill: {
                type: "solid",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.3,
                    stops: [0, 90, 100]
                },
                colors: ['transparent']
            },
            tooltip: {
                style: {
                    fontSize: '12px',
                },
                theme: 'light'
            },
            legend: {
                fontSize: "9px",
                position: 'top',
                horizontalAlign: 'left'
            },
        };
        var options_chart_feed_intake = {
            chart: {
                height: 300,
                width: '100%',
                type: 'area',
                stacked: false,
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
                zoomType: 'x',
                scrollablePlotArea: {
                    minWidth: 600,
                    scrollPositionX: 1
                },
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 300
                    }
                }
            }],
            colors: ['#ff8303', '#C0C0C0'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 1
            },
            grid: {
                borderColor: "#45404a2e",
                padding: {
                    left: 0,
                    right: 0
                },
                strokeDashArray: 4,
            },
            markers: {
                size: 0,
                hover: {
                    size: 0
                }
            },
            series: [{
                name: 'Actual',
                data: act_feed_intake
            }, {
                name: 'Standard',
                data: std_feed_intake
            }],

            xaxis: {
                type: 'month',
                categories: bwxaxis,
                axisBorder: {
                    show: true,
                    color: '#45404a2e',
                },
                axisTicks: {
                    show: true,
                    color: '#45404a2e',
                },
                labels: {
                    style: {
                        fontSize: '7px'
                    },
                },
                tickAmount: 20
            },
            yaxis: {
                labels: {
                    style: {
                        fontSize: '9px'
                    }
                }
            },
            fill: {
                type: "solid",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.3,
                    stops: [0, 90, 100]
                },
                colors: ['transparent']
            },
            tooltip: {
                style: {
                    fontSize: '12px',
                },
                theme: 'light'
            },
            legend: {
                fontSize: "9px",
                position: 'top',
                horizontalAlign: 'left'
            },
        };
        var options_chart_populasi = {
            chart: {
                height: 300,
                width: '100%',
                type: 'area',
                stacked: false,
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
                zoomType: 'x',
                scrollablePlotArea: {
                    minWidth: 600,
                    scrollPositionX: 1
                },
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 300
                    }
                }
            }],
            colors: ['#ff8303', '#ff4538'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 1
            },
            grid: {
                borderColor: "#45404a2e",
                padding: {
                    left: 0,
                    right: 0
                },
                strokeDashArray: 4,
            },
            markers: {
                size: 0,
                hover: {
                    size: 0
                }
            },
            series: [{
                name: 'Populasi',
                data: populasi
            }],

            xaxis: {
                type: 'month',
                categories: bwxaxis,
                axisBorder: {
                    show: true,
                    color: '#45404a2e',
                },
                axisTicks: {
                    show: true,
                    color: '#45404a2e',
                },
                labels: {
                    style: {
                        fontSize: '7px'
                    },
                },
                tickAmount: 20
            },
            yaxis: {
                labels: {
                    style: {
                        fontSize: '9px'
                    }
                }
            },
            fill: {
                type: "solid",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.3,
                    stops: [0, 90, 100]
                },
                colors: ['transparent']
            },
            tooltip: {
                style: {
                    fontSize: '12px',
                },
                theme: 'light'
            },
            legend: {
                fontSize: "9px",
                position: 'top',
                horizontalAlign: 'left'
            },
        };
        var options_chart_deplesi = {
            chart: {
                height: 300,
                width: '100%',
                type: 'area',
                stacked: false,
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
                zoomType: 'x',
                scrollablePlotArea: {
                    minWidth: 600,
                    scrollPositionX: 1
                },
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 300
                    }
                }
            }],
            colors: ['#ff5b03', '#9d53ff', '#fa1302'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 1
            },
            grid: {
                borderColor: "#45404a2e",
                padding: {
                    left: 0,
                    right: 0
                },
                strokeDashArray: 4,
            },
            // markers: {
            //     size: 0,
            //     hover: {
            //         size: 0
            //     }
            // },
            series: [{
                name: 'Mati',
                data: json_mati,
                type: 'area'
            }, {
                name: 'Culling',
                data: json_culling,
                type: 'area'
            }, {
                name: 'Ews',
                data: json_matiews,
                type: 'scatter'
            }],

            xaxis: {
                type: 'month',
                // categories: bwxaxis,
                axisBorder: {
                    show: true,
                    color: '#45404a2e',
                },
                axisTicks: {
                    show: true,
                    color: '#45404a2e',
                },
                labels: {
                    style: {
                        fontSize: '7px'
                    },
                },
                tickAmount: 20
            },
            yaxis: {
                labels: {
                    style: {
                        fontSize: '9px'
                    }
                }
            },
            fill: {
                type: ['solid', 'solid', 'image'],
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.3,
                    stops: [0, 90, 100]
                },
                image: {
                    src: ['solid', 'solid', base_url_ternak + 'assets/resource/icon/warning.svg'],
                    width: 20,
                    height: 20
                },
                colors: ['transparent', 'transparent', 'transparent']
            },
            tooltip: {
                custom: function ({
                    series,
                    seriesIndex,
                    dataPointIndex,
                    w
                }) {
                    var data_mati = w.globals.initialSeries[0].data[dataPointIndex];
                    var data_culling = w.globals.initialSeries[1].data[dataPointIndex];
                    var data_ews = w.globals.initialSeries[2].data[dataPointIndex];
                    if (data_ews.persen_deplesi > 0.3) {
                        var output_ews = `
                            <div class="apexcharts-tooltip-series-group apexcharts-active" style="order: 2; display: flex;">
                            <div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                            <div class="apexcharts-tooltip-y-group">
                                <span class="apexcharts-tooltip-text-y-label">Total Mati: </span>
                                <span class="apexcharts-tooltip-text-y-value">` + data_ews.persen_deplesi + ` %</span>
                                <span class="apexcharts-tooltip-text-y-value">` + data_ews.total_mati + ` ekor</span>
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
                            `;
                    } else {
                        var output_ews = ``;
                    }

                    var output = `
                        <div class="apexcharts-tooltip-title" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">` + data_mati.x + `</div>
                        <div class="apexcharts-tooltip-series-group apexcharts-active" style="order: 1; display: flex;">
                            <div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                            <div class="apexcharts-tooltip-y-group">
                                <span class="apexcharts-tooltip-text-y-label">Mati: </span>
                                <span class="apexcharts-tooltip-text-y-value">` + data_mati.y + ` ekor</span>
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
                        <div class="apexcharts-tooltip-series-group apexcharts-active" style="order: 2; display: flex;">
                            <div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                            <div class="apexcharts-tooltip-y-group">
                                <span class="apexcharts-tooltip-text-y-label">Culling: </span>
                                <span class="apexcharts-tooltip-text-y-value">` + data_culling.y + ` ekor</span>
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
                        ` + output_ews + `
                        `
                    return output;
                },
                style: {
                    fontSize: '12px',
                },
                theme: 'light'
            },
            legend: {
                fontSize: "9px",
                position: 'top',
                horizontalAlign: 'left'
            },
            markers: {
                size: [0, 0, 10],
                strokeWidth: 0,
                hover: {
                    sizeOffset: 0
                }
            },
        };

        bwchartload.html("");
        fcrchartload.html("");
        feedchartload.html("");
        deplesichartload.html("");
        populasichartload.html("");
        adgchartload.html("");
        var chartbw = new ApexCharts(bwchart, options_chart_bw);
        chartbw.render()
        var chartfcr = new ApexCharts(fcrchart, options_chart_fcr);
        chartfcr.render()
        var chartfeed = new ApexCharts(feedchart, options_chart_feed_intake);
        chartfeed.render()
        var chartdeplesi = new ApexCharts(deplesichart, options_chart_deplesi);
        chartdeplesi.render()
        var chartpopulasi = new ApexCharts(populasichart, options_chart_populasi);
        chartpopulasi.render()
        var chartadg = new ApexCharts(adgchart, options_chart_adg);
        chartadg.render()

        tablefcr = $('#tablefcr').DataTable({
            // "destroy": true,
            // filter: false,
            "info": true,
            "destroy": true,
            "lengthChange": true,
            // "order": [[ 0, "desc" ]],
            "paging": false,
            "pageLength": -1,
            "lengthMenu": [
                [7, 10, 25, 50, -1],
                [7, 10, 25, 50, "All"]
            ],
            "scrollCollapse": true,
            // "scrollY": "350px",
            // "scrollX": true,
            dom: '<"top"B>rt<"bottom"ilp><"clear">',
            buttons: [{
                extend: 'excel',
                footer: true,
                title: 'Tabel user'
            },
            {
                extend: 'pdf',
                footer: true,
                title: 'Tabel user'
            },
            {
                extend: 'print',
                footer: true,
                title: 'Tabel user'
            },
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
            "data": datanew1,
            "columns": [{
                'data': 'tanggal'
            },
            {
                'data': 'umur'
            },
            {
                'data': 'act_fcr'
            },
            {
                'data': 'std_fcr'
            },
            {
                "data": 'umur',
                "className": 'text-nowrap',
                "render": function (data, type, row) {
                    var act_fcr = parseFloat(row['act_fcr']);
                    var std_fcr = parseFloat(row['std_fcr']);
                    var diff_fcr = ((act_fcr / std_fcr - 1) * 100).toFixed(2);
                    if (act_fcr < std_fcr) {
                        var return_result = `<span class='badge badge-light-success fw-bolder px-4 py-3'> ` + diff_fcr + ` &nbsp<i class='fas fa-chevron-down'></i></span>`;
                    } else if (act_fcr > std_fcr) {
                        var return_result = `<span class='badge badge-light-danger fw-bolder px-4 py-3'> ` + diff_fcr + ` &nbsp<i class='fas fa-chevron-up'></i></span>`;
                    } else {
                        var return_result = `<span class='badge badge-light-primary fw-bolder px-4 py-3'><i class='fas fa-minus'></i></span>`;
                    }
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

        tablebw = $('#tablebw').DataTable({
            // "destroy": true,
            // filter: false,
            "info": true,
            "destroy": true,
            "lengthChange": true,
            // "order": [[ 0, "desc" ]],
            "paging": false,
            "pageLength": -1,
            "lengthMenu": [
                [7, 10, 25, 50, -1],
                [7, 10, 25, 50, "All"]
            ],
            "scrollCollapse": true,
            // "scrollY": "350px",
            // "scrollX": true,
            dom: '<"top"B>rt<"bottom"ilp><"clear">',
            buttons: [{
                extend: 'excel',
                footer: true,
                title: 'Tabel user'
            },
            {
                extend: 'pdf',
                footer: true,
                title: 'Tabel user'
            },
            {
                extend: 'print',
                footer: true,
                title: 'Tabel user'
            },
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
            "data": datanew1,
            "columns": [{
                'data': 'tanggal'
            },
            {
                'data': 'umur'
            },
            {
                'data': 'bw'
            },
            {
                'data': 'std_bw'
            },
            {
                "data": 'umur',
                "className": 'text-nowrap',
                "render": function (data, type, row) {
                    var act_bw = parseFloat(row['bw']);
                    var std_bw = parseFloat(row['std_bw']);
                    var diff_bw = act_bw - std_bw;
                    if (act_bw < std_bw) {
                        var return_result = `<span class='badge badge-light-danger fw-bolder px-4 py-3'> ` + diff_bw + ` &nbsp<i class='fas fa-chevron-down'></i></span>`;
                    } else if (act_bw > std_bw) {
                        var return_result = `<span class='badge badge-light-success fw-bolder px-4 py-3'> +` + diff_bw + ` &nbsp<i class='fas fa-chevron-up'></i></span>`;
                    } else {
                        var return_result = `<span class='badge badge-light-primary fw-bolder px-4 py-3'><i class='fas fa-minus'></i></span>`;
                    }
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

        tablefeed = $('#tablefeed').DataTable({
            // "destroy": true,
            // filter: false,
            "info": true,
            "destroy": true,
            "lengthChange": true,
            // "order": [[ 0, "desc" ]],
            "paging": false,
            "pageLength": -1,
            "lengthMenu": [
                [7, 10, 25, 50, -1],
                [7, 10, 25, 50, "All"]
            ],
            "scrollCollapse": true,
            // "scrollY": "350px",
            // "scrollX": true,
            "dom": '<"top"B>rt<"bottom"ilp><"clear">',
            "buttons": [{
                extend: 'excel',
                footer: true,
                title: 'Tabel user'
            },
            {
                extend: 'pdf',
                footer: true,
                title: 'Tabel user'
            },
            {
                extend: 'print',
                footer: true,
                title: 'Tabel user'
            },
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
            "data": datanew1,
            "columns": [{
                'data': 'tanggal'
            },
            {
                'data': 'umur'
            },
            {
                'data': 'act_feed_intake'
            },
            {
                'data': 'std_feed_intake'
            },
            {
                "data": 'umur',
                "className": 'text-nowrap',
                "render": function (data, type, row) {
                    var act_feed_intake = parseFloat(row['act_feed_intake']);
                    var std_feed_intake = parseFloat(row['std_feed_intake']);
                    var diff_feed_intake = (act_feed_intake - std_feed_intake).toFixed(3);
                    if (act_feed_intake < std_feed_intake) {
                        var return_result = `<span class='badge badge-light-danger fw-bolder px-4 py-3'> ` + diff_feed_intake + ` &nbsp<i class='fas fa-chevron-down'></i></span>`;
                    } else if (act_feed_intake > std_feed_intake) {
                        var return_result = `<span class='badge badge-light-success fw-bolder px-4 py-3'> +` + diff_feed_intake + ` &nbsp<i class='fas fa-chevron-up'></i></span>`;
                    } else {
                        var return_result = `<span class='badge badge-light-primary fw-bolder px-4 py-3'><i class='fas fa-minus'></i></span>`;
                    }
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

        tabledeplesi = $('#tabledeplesi').DataTable({
            // "destroy": true,
            // filter: false,
            "info": true,
            "destroy": true,
            "lengthChange": true,
            // "order": [[ 0, "desc" ]],
            "paging": false,
            "pageLength": -1,
            "lengthMenu": [
                [7, 10, 25, 50, -1],
                [7, 10, 25, 50, "All"]
            ],
            "scrollCollapse": true,
            // "scrollY": "350px",
            // "scrollX": true,
            "dom": '<"top"B>rt<"bottom"ilp><"clear">',
            "buttons": [{
                extend: 'excel',
                footer: true,
                title: 'Tabel user'
            },
            {
                extend: 'pdf',
                footer: true,
                title: 'Tabel user'
            },
            {
                extend: 'print',
                footer: true,
                title: 'Tabel user'
            },
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
            "data": datanew1,
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
                "data": 'persen_deplesi',
                "className": 'text-nowrap',
                "render": function (data, type, row) {

                    return data + ` %`;
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

        tablepopulasi = $('#tablepopulasi').DataTable({
            // "destroy": true,
            // filter: false,
            "info": true,
            "destroy": true,
            "lengthChange": true,
            // "order": [[ 0, "desc" ]],
            "paging": false,
            "pageLength": -1,
            "lengthMenu": [
                [7, 10, 25, 50, -1],
                [7, 10, 25, 50, "All"]
            ],
            "scrollCollapse": true,
            // "scrollY": "350px",
            // "scrollX": true,
            "dom": '<"top"B>rt<"bottom"ilp><"clear">',
            "buttons": [{
                extend: 'excel',
                footer: true,
                title: 'Tabel user'
            },
            {
                extend: 'pdf',
                footer: true,
                title: 'Tabel user'
            },
            {
                extend: 'print',
                footer: true,
                title: 'Tabel user'
            },
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
            "data": datanew1,
            "columns": [{
                'data': 'tanggal'
            },
            {
                'data': 'umur'
            },
            {
                'data': 'populasi'
            },
            ],
            "columnDefs": [{
                "targets": '_all',
                "defaultContent": '0'
            }],
            "order": [
                [0, 'desc']
            ],
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

        tableadg = $('#tableadg').DataTable({
            // "destroy": true,
            // filter: false,
            "info": true,
            "destroy": true,
            "lengthChange": true,
            // "order": [[ 0, "desc" ]],
            "paging": false,
            "pageLength": -1,
            "lengthMenu": [
                [7, 10, 25, 50, -1],
                [7, 10, 25, 50, "All"]
            ],
            "scrollCollapse": true,
            // "scrollY": "350px",
            // "scrollX": true,
            "dom": '<"top"B>rt<"bottom"ilp><"clear">',
            "buttons": [{
                extend: 'excel',
                footer: true,
                title: 'Tabel user'
            },
            {
                extend: 'pdf',
                footer: true,
                title: 'Tabel user'
            },
            {
                extend: 'print',
                footer: true,
                title: 'Tabel user'
            },
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
            "data": datanew1,
            "columns": [{
                'data': 'tanggal'
            },
            {
                'data': 'umur'
            },
            {
                'data': 'act_adg'
            },
            {
                'data': 'std_adg'
            },
            {
                "data": 'umur',
                "className": 'text-nowrap',
                "render": function (data, type, row) {
                    var act_adg = parseFloat(row['act_adg']);
                    var std_adg = parseFloat(row['std_adg']);
                    var diff_std_adg = (act_adg - std_adg).toFixed(3);
                    if (act_adg < std_adg) {
                        var return_result = `<span class='badge badge-light-danger fw-bolder px-4 py-3'> ` + diff_std_adg + ` &nbsp<i class='fas fa-chevron-down'></i></span>`;
                    } else if (act_adg > std_adg) {
                        var return_result = `<span class='badge badge-light-success fw-bolder px-4 py-3'> +` + diff_std_adg + ` &nbsp<i class='fas fa-chevron-up'></i></span>`;
                    } else {
                        var return_result = `<span class='badge badge-light-primary fw-bolder px-4 py-3'><i class='fas fa-minus'></i></span>`;
                    }
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

        var tpfbw = $('#tablebw2').DataTable({
            // filter: false,
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
            "scrollY": "300px",
            "scrollX": true,
            dom: '<"top">rt<"bottom"><"clear">',
            buttons: [{
                extend: 'excel',
                footer: true,
                title: 'Tabel BW'
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
            ],
            "data": datanew1,
            "columns": [{
                'data': 'tanggal'
            },
            {
                'data': 'umur'
            },
            {
                'data': 'bw'
            },
            {
                'data': 'std_bw'
            },
            {
                "data": 'umur',
                "className": 'dt-center',
                "render": function (data, type, row) {
                    var act_bw = parseFloat(row['bw']);
                    var std_bw = parseFloat(row['std_bw']);
                    var diff_bw = act_bw - std_bw;
                    if (act_bw < std_bw) {
                        var return_result = `<span class='badge badge-light-danger fw-bolder px-4 py-3'> ` + diff_bw + ` &nbsp<i class='fas fa-chevron-down'></i></span>`;
                    } else if (act_bw > std_bw) {
                        var return_result = `<span class='badge badge-light-success fw-bolder px-4 py-3'> +` + diff_bw + ` &nbsp<i class='fas fa-chevron-up'></i></span>`;
                    } else {
                        var return_result = `<span class='badge badge-light-primary fw-bolder px-4 py-3'><i class='fas fa-minus'></i></span>`;
                    }
                    return return_result;
                }
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
        var tpffcr = $('#tablefcr2').DataTable({
            // filter: false,
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
            "scrollY": "300px",
            "scrollX": true,
            dom: '<"top">rt<"bottom"><"clear">',
            buttons: [{
                extend: 'excel',
                footer: true,
                title: 'Tabel FCR'
            },
            {
                extend: 'pdf',
                footer: true,
                title: 'Tabel FCR'
            },
            {
                extend: 'print',
                footer: true,
                title: 'Tabel FCR'
            },
            ],
            "data": datanew1,
            "columns": [{
                'data': 'tanggal'
            },
            {
                'data': 'umur'
            },
            {
                'data': 'act_fcr'
            },
            {
                'data': 'std_fcr'
            },
            {
                "data": 'umur',
                "className": 'dt-center',
                "render": function (data, type, row) {
                    var act_fcr = parseFloat(row['act_fcr']);
                    var std_fcr = parseFloat(row['std_fcr']);
                    var diff_fcr = ((act_fcr / std_fcr - 1) * 100).toFixed(2);
                    if (act_fcr < std_fcr) {
                        var return_result = `<span class='badge badge-light-success fw-bolder px-4 py-3'> ` + diff_fcr + ` &nbsp<i class='fas fa-chevron-down'></i></span>`;
                    } else if (act_fcr > std_fcr) {
                        var return_result = `<span class='badge badge-light-danger fw-bolder px-4 py-3'> ` + diff_fcr + ` &nbsp<i class='fas fa-chevron-up'></i></span>`;
                    } else {
                        var return_result = `<span class='badge badge-light-primary fw-bolder px-4 py-3'><i class='fas fa-minus'></i></span>`;
                    }
                    return return_result;
                }
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
        var tpffeed = $('#tablefeed2').DataTable({
            // filter: false,
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
            "scrollY": "300px",
            "scrollX": true,
            dom: '<"top">rt<"bottom"><"clear">',
            buttons: [{
                extend: 'excel',
                footer: true,
                title: 'Tabel Feed'
            },
            {
                extend: 'pdf',
                footer: true,
                title: 'Tabel Feed'
            },
            {
                extend: 'print',
                footer: true,
                title: 'Tabel Feed'
            },
            ],
            "data": datanew1,
            "columns": [{
                'data': 'tanggal'
            },
            {
                'data': 'umur'
            },
            {
                'data': 'act_feed_intake'
            },
            {
                'data': 'std_feed_intake'
            },
            {
                "data": 'umur',
                "className": 'dt-center',
                "render": function (data, type, row) {
                    var act_feed_intake = parseFloat(row['act_feed_intake']);
                    var std_feed_intake = parseFloat(row['std_feed_intake']);
                    var diff_feed_intake = (act_feed_intake - std_feed_intake).toFixed(3);
                    if (act_feed_intake < std_feed_intake) {
                        var return_result = `<span class='badge badge-light-danger fw-bolder px-4 py-3'> ` + diff_feed_intake + ` &nbsp<i class='fas fa-chevron-down'></i></span>`;
                    } else if (act_feed_intake > std_feed_intake) {
                        var return_result = `<span class='badge badge-light-success fw-bolder px-4 py-3'> +` + diff_feed_intake + ` &nbsp<i class='fas fa-chevron-up'></i></span>`;
                    } else {
                        var return_result = `<span class='badge badge-light-primary fw-bolder px-4 py-3'><i class='fas fa-minus'></i></span>`;
                    }
                    return return_result;
                }
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
        var tpfdeplesi = $('#tabledeplesi2').DataTable({
            // filter: false,
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
            "scrollY": "300px",
            "scrollX": true,
            dom: '<"top">rt<"bottom"><"clear">',
            buttons: [{
                extend: 'excel',
                footer: true,
                title: 'Tabel Deplesi'
            },
            {
                extend: 'pdf',
                footer: true,
                title: 'Tabel Deplesi'
            },
            {
                extend: 'print',
                footer: true,
                title: 'Tabel Deplesi'
            },
            ],
            "data": datanew1,
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
                "data": 'persen_deplesi',
                "className": 'dt-center',
                "render": function (data, type, row) {

                    return data + ` %`;
                }
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
        var tpfpopulasi = $('#tablepopulasi2').DataTable({
            // filter: false,
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
            "scrollY": "300px",
            "scrollX": true,
            dom: '<"top">rt<"bottom"><"clear">',
            buttons: [{
                extend: 'excel',
                footer: true,
                title: 'Tabel Populasi'
            },
            {
                extend: 'pdf',
                footer: true,
                title: 'Tabel Populasi'
            },
            {
                extend: 'print',
                footer: true,
                title: 'Tabel Populasi'
            },
            ],
            "data": datanew1,
            "columns": [{
                'data': 'tanggal'
            },
            {
                'data': 'umur'
            },
            {
                'data': 'populasi'
            },
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
        var tpfadg = $('#tableadg2').DataTable({
            // filter: false,
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
            "scrollY": "300px",
            "scrollX": true,
            dom: '<"top">rt<"bottom"><"clear">',
            buttons: [{
                extend: 'excel',
                footer: true,
                title: 'Tabel Adg'
            },
            {
                extend: 'pdf',
                footer: true,
                title: 'Tabel Adg'
            },
            {
                extend: 'print',
                footer: true,
                title: 'Tabel Adg'
            },
            ],
            "data": datanew1,
            "columns": [{
                'data': 'tanggal'
            },
            {
                'data': 'umur'
            },
            {
                'data': 'act_adg'
            },
            {
                'data': 'std_adg'
            },
            {
                "data": 'umur',
                "className": 'dt-center',
                "render": function (data, type, row) {
                    var act_adg = parseFloat(row['act_adg']);
                    var std_adg = parseFloat(row['std_adg']);
                    var diff_std_adg = (act_adg - std_adg).toFixed(3);
                    if (act_adg < std_adg) {
                        var return_result = `<span class='badge badge-light-danger fw-bolder px-4 py-3'> ` + diff_std_adg + ` &nbsp<i class='fas fa-chevron-down'></i></span>`;
                    } else if (act_adg > std_adg) {
                        var return_result = `<span class='badge badge-light-success fw-bolder px-4 py-3'> +` + diff_std_adg + ` &nbsp<i class='fas fa-chevron-up'></i></span>`;
                    } else {
                        var return_result = `<span class='badge badge-light-primary fw-bolder px-4 py-3'><i class='fas fa-minus'></i></span>`;
                    }
                    return return_result;
                }
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

        var buttonsbw = new $.fn.dataTable.Buttons(tpfbw, {
            buttons: [{
                extend: 'excel',
                footer: true,
                title: 'Tabel BW'
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
        }).container().appendTo($('#buttonsmodaltabelbw'));
        var buttonsfcr = new $.fn.dataTable.Buttons(tpffcr, {
            buttons: [{
                extend: 'excel',
                footer: true,
                title: 'Tabel FCR'
            },
            {
                extend: 'pdf',
                footer: true,
                title: 'Tabel FCR'
            },
            {
                extend: 'print',
                footer: true,
                title: 'Tabel FCR'
            },
            ]
        }).container().appendTo($('#buttonsmodaltabelfcr'));
        var buttonsfeed = new $.fn.dataTable.Buttons(tpffeed, {
            buttons: [{
                extend: 'excel',
                footer: true,
                title: 'Tabel Feed'
            },
            {
                extend: 'pdf',
                footer: true,
                title: 'Tabel Feed'
            },
            {
                extend: 'print',
                footer: true,
                title: 'Tabel Feed'
            },
            ]
        }).container().appendTo($('#buttonsmodaltabelfeed'));
        var buttonsdeplesi = new $.fn.dataTable.Buttons(tpfdeplesi, {
            buttons: [{
                extend: 'excel',
                footer: true,
                title: 'Tabel Deplesi'
            },
            {
                extend: 'pdf',
                footer: true,
                title: 'Tabel Deplesi'
            },
            {
                extend: 'print',
                footer: true,
                title: 'Tabel Deplesi'
            },
            ]
        }).container().appendTo($('#buttonsmodaltabeldeplesi'));
        var buttonspopulasi = new $.fn.dataTable.Buttons(tpfpopulasi, {
            buttons: [{
                extend: 'excel',
                footer: true,
                title: 'Tabel populasi'
            },
            {
                extend: 'pdf',
                footer: true,
                title: 'Tabel populasi'
            },
            {
                extend: 'print',
                footer: true,
                title: 'Tabel populasi'
            },
            ]
        }).container().appendTo($('#buttonsmodaltabelpopulasi'));
        var buttonsadg = new $.fn.dataTable.Buttons(tpfadg, {
            buttons: [{
                extend: 'excel',
                footer: true,
                title: 'Tabel adg'
            },
            {
                extend: 'pdf',
                footer: true,
                title: 'Tabel adg'
            },
            {
                extend: 'print',
                footer: true,
                title: 'Tabel adg'
            },
            ]
        }).container().appendTo($('#buttonsmodaltabeladg'));
        // console.log(buttonsadg);




    });

}

function drawtabel(tabel) {
    // $('#' + tabel).DataTable().destroy();
    // $('#' + tabel).DataTable().draw();
    // $('#' + tabel).DataTable().draw();
    // $('#' + tabel).DataTable().ajax.reload();
    // tablefcr.destroy();
    // tablefeed.destroy();
    // tablebw.destroy();
    // tablefcr.draw();
    // tablefeed.draw();
    // tablebw.draw();
}
$('#modaltabelbw').on('shown.bs.modal', function (e) {
    $('#tablebw2').DataTable()
        .columns.adjust()
        .fixedColumns().relayout();
})
$('#modaltabelfcr').on('shown.bs.modal', function (e) {
    $('#tablefcr2').DataTable()
        .columns.adjust()
        .fixedColumns().relayout();
})
$('#modaltabelfeed').on('shown.bs.modal', function (e) {
    $('#tablefeed2').DataTable()
        .columns.adjust()
        .fixedColumns().relayout();
})
$('#modaltabeldeplesi').on('shown.bs.modal', function (e) {
    $('#tabledeplesi2').DataTable()
        .columns.adjust()
        .fixedColumns().relayout();
})
$('#modaltabelpopulasi').on('shown.bs.modal', function (e) {
    $('#tablepopulasi2').DataTable()
        .columns.adjust()
        .fixedColumns().relayout();
})
$('#modaltabeladg').on('shown.bs.modal', function (e) {
    $('#tableadg2').DataTable()
        .columns.adjust()
        .fixedColumns().relayout();
})