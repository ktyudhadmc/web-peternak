</div>
<!--end::Authentication - Sign-in-->
</div>
<!--end::Root-->
<!--end::Main-->
<!--begin::Javascript-->
<script>
    var hostUrl = "<?= base_url('assets/main/') ?>";
    // Mendapatkan semua elemen input OTP
    const otpInputs = document.querySelectorAll('.otp-input');

    otpInputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            // Mengambil nilai dari input saat ini
            const currentValue = e.target.value;

            // Jika pengguna memasukkan satu angka
            if (/^\d$/.test(currentValue)) {
                // Pindah ke input berikutnya jika tersedia
                if (index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
            }
        });

        // Handle backspace untuk kembali ke input sebelumnya
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && index > 0) {
                otpInputs[index - 1].focus();
            }
        });
    });
</script>


<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="<?= base_url('assets/main/') ?>plugins/global/plugins.bundle.js"></script>
<script src="<?= base_url('assets/main/') ?>js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Page Custom Javascript(used by this page)-->
<script src="<?= base_url('assets/main/') ?>js/custom/authentication/sign-in/general.js"></script>
<!--end::Page Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->

</html>