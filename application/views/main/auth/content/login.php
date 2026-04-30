<!--begin::Body-->
<div class="d-flex flex-column flex-lg-row-fluid py-10">
  <!--begin::Content-->
  <div class="d-flex flex-center flex-column flex-column-fluid">
    <!--begin::Wrapper-->
    <div class="w-lg-500px p-10 p-lg-15 mx-auto">
      <!--begin::Form-->
      <form class="form w-100" novalidate="novalidate" method="POST" action="<?= current_url() ?>">
        <!--begin::Heading-->
        <div class="text-center mb-10">
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
          <!--begin::Logo-->
          <a href="<?= base_url() ?>" class="py-9 mb-5">
            <img alt="Logo" src="<?= $this->config->item('app_url') ?>assets/resource/favicon/android-chrome-512x512.png" class="h-60px" />
          </a>
          <!--end::Logo-->
          <!--begin::Title-->
          <!-- <h1 class="fw-bolder fs-2qx pb-5 pb-md-10 text-dark">Selamat datang di <br />Dashboard PETERNAK.ID</h1> -->
          <!--end::Title-->
          <!--begin::Description-->
          <p class="fw-bold fs-2 text-dark mb-8">Peternak.id</p>
          <!--end::Description-->
          <!--begin::Title-->
          <!-- <h1 class="text-dark mb-3">Masuk ke PETERNAK.ID</h1> -->
          <!--end::Title-->
        </div>
        <!--begin::Heading-->
        <!--begin::Input group-->
        <div class="fv-row mb-10">
          <!--begin::Label-->
          <label class="form-label fs-6 fw-bolder text-dark">No HP</label>
          <!--end::Label-->
          <!--begin::Input-->
          <input class="form-control form-control-lg form-control-solid" type="number" name="nomor" required autofocus />
          <!--end::Input-->
        </div>
        <!--end::Input group-->
        <!--begin::Actions-->
        <div class="text-center">
          <!--begin::Submit button-->
          <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
            <span class="indicator-label">Login</span>
            <span class="indicator-progress">Please wait...
              <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
          </button>
          <!--end::Submit button-->
          <!--begin::Separator-->
          <!-- <div class="text-center text-muted text-uppercase fw-bolder mb-5">or</div> -->
          <!--end::Separator-->
          <!--begin::Google link-->
          <!-- <a href="<?= $googleurl ?>" class="btn btn-flex flex-center btn-light btn-lg w-100 mb-5"> -->
          <!-- <img alt="Logo" src="<?= base_url('assets/main/') ?>media/svg/brand-logos/google-icon.svg" class="h-20px me-3"/>Continue with Google</a> -->
          <!--end::Google link-->
        </div>
        <!--end::Actions-->
      </form>
      <!--end::Form-->
    </div>
    <!--end::Wrapper-->
  </div>
  <!--end::Content-->
</div>
<!--end::Body-->