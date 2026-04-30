<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <base href="<?= base_url() ?>">
    <title>MAIN - <?= $title ?></title>
    <meta charset="utf-8" />
    <meta name="description" content="Solusi untuk kebutuhan ternak anda" />
    <meta name="keywords" content="peternak, peternak.id, ayam broiker, ayam, ternak, peternak indonesia, hobby ternak, ternak yuk, chickin, breeding, harga ternak, harga pasar, ayam petelur, ayam, ayam daging, ayam broiler" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="<?= $title ?>" />
    <meta property="og:url" content="<?= current_url() ?>" />
    <meta property="og:site_name" content="PETERNAK.ID - Main Dashboard" />
    <link rel="canonical" href="<?= base_url() ?>" />
    <!-- Favicon -->
    <link rel="icon" href="<?= $this->config->item('cdn_url') ?>favicon/favicon.ico">
    <link rel="apple-touch-icon" href="<?= $this->config->item('cdn_url') ?>favicon/apple-touch-icon.png">

    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="<?= base_url('assets/mobile/font-awesome/css/all.min.css') ?>" rel="stylesheet" type="text/css" />
    <!--end::Fonts-->
    <!--begin::Page Vendor Stylesheets(used by this page)-->
    <link href="<?= base_url('assets/main/') ?>plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/main/') ?>plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Page Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="<?= base_url('assets/main/') ?>plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/main/') ?>css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/main/') ?>resource/duallistbox/src/bootstrap-duallistbox.css">
    <!-- Placeholder -->
    <link rel="stylesheet" href="https://unpkg.com/placeholder-loading/dist/css/placeholder-loading.min.css">
    <script src="<?= base_url('assets/main/') ?>plugins/global/plugins.bundle.js"></script>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-Y6EV9MVZ31"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-Y6EV9MVZ31');
    </script>
</head>
<!--end::Head-->
<!-- Preloader -->
<div id="preloader">
    <img src="<?= $this->config->item('app_url') . 'assets/resource/LOGO2.png' ?>" width="100px" />
</div>
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">