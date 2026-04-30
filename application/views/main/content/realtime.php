<style>
    .loader {
        border: 8px solid #f0592417;
        border-radius: 50%;
        border-top: 8px solid #f05924;
        width: 90px;
        height: 90px;
        -webkit-animation: spin 2s linear infinite;
        /* Safari */
        animation: spin 2s linear infinite;
    }

    /* Safari */
    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
<div class="col-xxl-12">
    <div class="card card-flush" id="chartviewsensor_realtime">
        <div class="card-header mt-4" style="min-height: 50px;">
            <div class="card-title flex-column">
                <div class="d-flex align-items-center mb-1">
                    <h3 class="fw-bolder mb-0">Real Time</h3>
                </div>
                <div class="d-flex flex-wrap fw-bold mb-4 fs-5 text-gray-400" id="realtimeiddata">
                    Realtime data
                </div>
            </div>
            <div class="card-toolbar" style="margin-top: -20px;">
                <!-- <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#asd"><i class="fas fa-search white-true"></i>&nbsp;asd </a> -->
            </div>
        </div>
        <!--begin::Card body-->
        <div class="card-body" id="getrealtime">
            <!--begin::Chart-->
            <div class="row">
                <div class="col-3 mb-4">
                    <div class="card card-rounded-bottom shadow-sm">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h2>Temp | Set Temp</h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 text-end">
                                    <p style="font-size:12px;display: flex; justify-content: center; align-items: center; height: 100%;" id="temp_text"><b> - </b></p>
                                </div>
                                <div class="col-6">
                                    <img src="<?= base_url('assets/resource/icons/temperature.png') ?>" style="max-width: 100%; height: 75px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="card card-rounded-bottom shadow-sm">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h2>Humidity</h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 text-end">
                                    <p style="font-size:12px;display: flex; justify-content: center; align-items: center; height: 100%;" id="humidity_text"> - </p>
                                </div>
                                <div class="col-6">
                                    <img src="<?= base_url('assets/resource/icons/humidity.png') ?>" style="max-width: 100%; height: 75px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="card card-rounded-bottom shadow-sm">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h2>Water</h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 text-end">
                                    <p style="font-size:12px;display: flex; justify-content: center; align-items: center; height: 100%;" id="water_text"> - </p>
                                </div>
                                <div class="col-6">
                                    <img src="<?= base_url('assets/resource/icons/water.png') ?>" style="max-width: 100%; height: 75px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3 mb-4">
                    <div class="card card-rounded-bottom shadow-sm">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h2>Weighing</h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 text-end">
                                    <p style="font-size:12px;display: flex; justify-content: center; align-items: center; height: 100%;" id="weighingbw_text"> - </p>
                                </div>
                                <div class="col-6">
                                    <img src="<?= base_url('assets/resource/icons/weighing.png') ?>" style="max-width: 100%; height: 75px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>