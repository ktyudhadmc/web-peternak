<!--begin::Body-->
<div class="d-flex flex-column flex-lg-row-fluid py-10">
  <!--begin::Content-->
  <div class="d-flex flex-center flex-column flex-column-fluid">
    <!--begin::Wrapper-->
    <div class="w-lg-600px p-10 p-lg-15 mx-auto">
      <!--begin::Form-->
      <form class="form w-100 mb-10" novalidate="novalidate" method="POST" action="<?= base_url('auth/verifikasi') ?>" id="kt_sing_in_two_steps_form">
        <?php
        // exit;
        $arr = $this->session->flashdata();
        if (!empty($arr['flash_message'])) {
          $html = '<div class="container" style="margin-top: 10px;">';
          $html .= '<div class="alert alert-warning alert-dismissible" role="alert">';
          $html .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
          $html .= $arr['flash_message'];
          $html .= '</div>';
          $html .= '</div>';
          echo $html;
        } else if (!empty($arr['success_message'])) {
          $html = "<!--begin::Alert-->
          <div class='alert alert-dismissible bg-danger d-flex flex-column flex-sm-row p-5 mb-10'>
          <!--begin::Icon-->
          <span class='svg-icon svg-icon-2hx svg-icon-light me-4 mb-5 mb-sm-0'>...</span>
          <!--end::Icon-->

          <!--begin::Wrapper-->
          <div class='d-flex flex-column text-light pe-0 pe-sm-10'>
          <!--begin::Title-->
          <h4 class='mb-2 light'>Danger</h4>
          <!--end::Title-->

          <!--begin::Content-->
          <span>{$arr['success_message']}</span>
          <!--end::Content-->
          </div>
          <!--end::Wrapper-->
          </div>";
          echo $html;
        } else if (!empty($arr['danger_message'])) {
          $html = "<!--begin::Alert-->
          <div class='alert alert-dismissible bg-danger d-flex flex-column flex-sm-row p-5 mb-10'>
          <!--begin::Wrapper-->
          <div class='d-flex flex-column text-light pe-0 pe-sm-10'>
          <!--begin::Title-->
          <h4 class='mb-2 light'>Danger</h4>
          <!--end::Title-->

          <!--begin::Content-->
          <span>{$arr['danger_message']}</span>
          <!--end::Content-->
          </div>
          <!--end::Wrapper-->
          </div>";
          echo $html;
        }
        ?>
        <!--begin::Icon-->
        <div class="text-center mb-10">
          <img alt="Logo" class="mh-125px" src="<?= base_url('assets/main/media/svg/misc/smartphone.svg') ?>" />
        </div>
        <!--end::Icon-->
        <!--begin::Heading-->
        <div class="text-center mb-10">
          <!--begin::Title-->
          <h1 class="text-dark mb-3">Kode Verifikasi</h1>
          <!--end::Title-->
          <!--begin::Sub-title-->
          <div class="text-muted fw-bold fs-5 mb-5">Masukkan kode verifikasi yang kami kirim melalui whatsapp di nomor</div>
          <!--end::Sub-title-->
          <!--begin::Mobile no-->
          <div class="fw-bolder text-dark fs-3">*********<?= $lastnumber ?></div>
          <!--end::Mobile no-->
        </div>
        <!--end::Heading-->
        <!--begin::Section-->
        <div class="mb-10 px-md-10">
          <!--begin::Label-->
          <div class="fw-bolder text-start text-dark fs-6 mb-1 ms-1">Input kode OTP 4 digit</div>
          <!--end::Label-->
          <!--begin::Input group-->
          <div class="d-flex flex-wrap flex-stack">
            <input type="text" name="otp[]" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="otp-input form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2" value="" autofocus />
            <input type="text" name="otp[]" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="otp-input form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2" value="" required />
            <input type="text" name="otp[]" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="otp-input form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2" value="" required />
            <input type="text" name="otp[]" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="otp-input form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2" value="" required />
          </div>
          <input type='hidden' value="<?= $token ?>" name="token">
          <!--begin::Input group-->
        </div>
        <!--end::Section-->
        <!--begin::Submit-->
        <div class="d-flex flex-center">
          <button type="submit" id="kt_sing_in_two_steps_submit" class="btn btn-lg btn-primary fw-bolder">
            <span class="indicator-label">Submit</span>
            <span class="indicator-progress">Please wait...
              <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
          </button>
        </div>
        <!--end::Submit-->
      </form>
      <!--end::Form-->
      <!--begin::Notice-->
      <div class="text-center fw-bold fs-5">
        <span class="text-muted me-1">Anda tidak menerima kode OTP?</span>
        <a href="<?= base_url("auth/again/{$nomor}/?mode=resend") ?>" class="link-primary fw-bolder fs-5 me-1">Kirim ulang</a>
        <!-- <span class="text-muted me-1">or</span> -->
        <!-- <a href="https://wa.me/6281132048697?text=Hallo%20admin%20%2C%20saya%20kesulitan%20login%20di%20nomor%20wa%20<?= $nomor ?>" class="link-primary fw-bolder fs-5">Call Us</a> -->
      </div>
      <!--end::Notice-->
    </div>
    <!--end::Wrapper-->
  </div>
  <!--end::Content-->
</div>
<!--end::Body-->