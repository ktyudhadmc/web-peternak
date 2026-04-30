    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error 404</title>
        <link rel="stylesheet" href="<?= base_url('assets/errors/css/style.css') ?>">
        <!-- Icon -->
        <link rel="icon" href="<?= $this->config->item('cdn_url') ?>favicon/favicon.ico">
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    </head>

    <body class="bg-purple">

        <div class="stars">
            <div class="central-body">
                <img class="image-404" src="<?= base_url('assets/errors/img/404.svg') ?>" width="300px">
                <a href="<?= base_url() ?>" class="btn-go-home">GO BACK HOME</a>
            </div>
            <div class="objects">
                <img class="object_rocket" src="<?= base_url('assets/errors/img/rocket.svg') ?>" width="40px">
                <div class="earth-moon">
                    <img class="object_earth" src="<?= base_url('assets/errors/img/earth.svg') ?>" width="100px">
                    <img class="object_moon" src="<?= base_url('assets/errors/img/moon.svg') ?>" width="80px">
                </div>
                <div class="box_astronaut">
                    <img class="object_astronaut" src="<?= base_url('assets/errors/img/astronaut.svg') ?>" width="140px">
                </div>
            </div>
            <div class="glowing_stars">
                <div class="star"></div>
                <div class="star"></div>
                <div class="star"></div>
                <div class="star"></div>
                <div class="star"></div>

            </div>

        </div>

    </body>

    </html>