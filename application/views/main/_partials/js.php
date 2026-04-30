<script>
    var cookied = document.cookie;
    var cookiea = cookied.split(";");
    var user_idjs = "<?= getcookienya('user_data', 'user_id') ?>";
    var hostUrl = "<?= base_url('assets/main/') ?>";
    var base_url = "<?= base_url() ?>";
    // var api_url = "<?= $this->config->item('api_url') ?>";
    var api_url = "<?= base_url() ?>";
    var base_url_ternak = "<?= $this->config->item('app_url') ?>";
    var tokenfinal = "<?= getcookienya('user_data','token') ?>";
    var current_url = "<?= $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>";
</script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="<?= base_url('assets/main/') ?>plugins/global/plugins.bundle.js"></script>
<script src="<?= base_url('assets/main/') ?>js/scripts.bundle.js"></script>
<script src="<?= base_url('assets/main/') ?>plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
<script src="<?= base_url('assets/main/') ?>plugins/custom/datatables/datatables.bundle.js"></script>
<script src="<?= base_url('assets/main/') ?>js/widgets.bundle.js"></script>
<script src="<?= base_url('assets/main/') ?>js/custom/widgets.js"></script>
<script src="<?= base_url('assets/main/') ?>js/custom/apps/chat/chat.js"></script>
<script src="<?= base_url('assets/main/') ?>js/custom/apps/projects/list/list.js"></script>
<script src="<?= base_url('assets/main/') ?>js/custom/utilities/modals/upgrade-plan.js"></script>
<script src="<?= base_url('assets/main/') ?>js/custom/utilities/modals/create-app.js"></script>
<script src="<?= base_url('assets/main/') ?>js/custom/utilities/modals/users-search.js"></script>
<script src="<?= base_url('assets/main/') ?>js/custom/loader.js"></script>
<script src="<?= base_url('assets/main/') ?>js/custom/custom.js"></script>
<?= $this->uri->segment('1') == NULL || ($this->uri->segment('1') == "main" && $this->uri->segment('2') == NULL)  ? "<script src='" . base_url('assets/main/js/pages/index.js') . "'></script>\n" : "<script src='" . base_url("assets/main/js/pages/{$this->uri->segment(2)}.js") . "'></script>\n" ?>
<?php
if ($this->uri->segment('2') == "ternak") {
    echo "<script src='" . base_url('assets/main/js/pages/temperature.js') . "'></script>\n";
    echo "<script src='" . base_url('assets/main/js/pages/water.js') . "'></script>\n";
    echo "<script src='" . base_url('assets/main/js/pages/weighing.js') . "'></script>\n";
    echo "<script src='" . base_url('assets/main/js/pages/realtime.js') . "'></script>\n";
    echo '<script>
    // var id_kandangnih = $("#filter_kandang_sensor").val();
    // if(id_kandangnih){
    //     setInterval(function() {
    //         getdata($("#filter_kandang_sensor").val());
    //     }, 3000);
    // }
    </script>';
    echo "<script src='" . base_url('assets/main/js/pages/ternak_chart.js') . "'></script>\n";
    echo "<script src='" . base_url('assets/main/js/child/resume.js') . "'></script>\n";
    echo "<script src='" . base_url('assets/main/js/child/sapronak.js') . "'></script>\n";
    echo "<script src='" . base_url('assets/main/js/child/dataharian.js') . "'></script>\n";
    echo "<script src='" . base_url('assets/main/js/child/nekropsi.js') . "'></script>\n";
    echo "<script src='" . base_url('assets/main/js/child/logrh.js') . "'></script>\n";
    echo "<script src='" . base_url('assets/main/js/child/ews.js') . "'></script>\n";
    echo "<script src='" . base_url('assets/main/js/child/bop.js') . "'></script>\n";
    echo "<script src='" . base_url('assets/main/js/child/penjualan.js') . "'></script>\n";
    echo "<script src='" . base_url('assets/main/js/child/pendapatan.js') . "'></script>\n";
}
?>

</body>

</html>