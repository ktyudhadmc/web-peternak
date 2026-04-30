<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
	<base href="<?= base_url() ?>">
	<title><?= $title ?></title>
	<meta charset="utf-8" />
	<meta name="description" content="The most advanced Bootstrap Admin Theme on Themeforest trusted by 94,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue &amp; Laravel versions. Grab your copy now and get life-time updates for free." />
	<meta name="google-signin-client_id" content="218328949136-vtbl71873krtblr075jqf3cpdleri88c.apps.googleusercontent.com">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="<?= $title ?>" />
	<meta property="og:url" content="https://keenthemes.com/metronic" />
	<meta property="og:site_name" content="Keenthemes | Metronic" />
	<!-- Favicon -->
	<link rel="icon" href="<?= $this->config->item('app_url') ?>assets/resource/favicon/favicon.ico">
	<link rel="apple-touch-icon" href="<?= $this->config->item('app_url') ?>assets/resource/favicon/apple-touch-icon.png">

	<!--begin::Fonts-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
	<!--end::Fonts-->
	<!--begin::Global Stylesheets Bundle(used by all pages)-->
	<link href="<?= base_url('assets/main/') ?>plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url('assets/main/') ?>css/style.bundle.css" rel="stylesheet" type="text/css" />
	<!--end::Global Stylesheets Bundle-->
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