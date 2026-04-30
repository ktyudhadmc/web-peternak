       <!--begin::Header-->
       <div id="kt_header" style="" class="header align-items-stretch">
           <!--begin::Container-->
           <div class="container-fluid d-flex align-items-stretch justify-content-between">
               <!--begin::Aside mobile toggle-->
               <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show aside menu">
                   <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" id="kt_aside_mobile_toggle">
                       <!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
                       <span class="svg-icon svg-icon-1">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                               <path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="currentColor" />
                               <path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="currentColor" />
                           </svg>
                       </span>
                       <!--end::Svg Icon-->
                   </div>
               </div>
               <!--end::Aside mobile toggle-->
               <!--begin::Mobile logo-->
               <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
                   <a href="<?= base_url('main') ?>" class="d-lg-none">
                       <img alt="Logo" src="<?= $this->config->item('app_url') ?>assets/resource/favicon/apple-touch-icon.png" class="h-30px logo" /> &nbsp;
                   </a>
               </div>
               <!--end::Mobile logo-->
               <!--begin::Wrapper-->
               <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
                   <!--begin::Navbar-->
                   <div class="d-flex align-items-stretch" id="kt_header_nav">
                       <!--begin::Menu wrapper-->
                       <div class="header-menu align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">

                       </div>
                       <!--end::Menu wrapper-->
                   </div>
                   <!--end::Navbar-->
                   <!--begin::Toolbar wrapper-->
                   <div class="d-flex align-items-stretch flex-shrink-0">
                       <!--begin::Search-->
                       <!-- <div class="d-flex align-items-stretch ms-1 ms-lg-3">
                           <div id="kt_header_search" class="header-search d-flex align-items-stretch" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="menu" data-kt-menu-trigger="auto" data-kt-menu-overflow="false" data-kt-menu-permanent="true" data-kt-menu-placement="bottom-end">
                               <div class="d-flex align-items-center" data-kt-search-element="toggle" id="kt_header_search_toggle">
                                   <div class="btn btn-icon btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px">
                                       <span class="svg-icon svg-icon-1">
                                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                               <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                               <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                           </svg>
                                       </span>
                                   </div>
                               </div>
                               <div data-kt-search-element="content" class="menu menu-sub menu-sub-dropdown p-7 w-325px w-md-375px">
                                   <div data-kt-search-element="wrapper">
                                       <form data-kt-search-element="form" class="w-100 position-relative mb-3" autocomplete="off">
                                           <span class="svg-icon svg-icon-2 svg-icon-lg-1 svg-icon-gray-500 position-absolute top-50 translate-middle-y ms-0">
                                               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                   <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                                   <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                               </svg>
                                           </span>
                                           <input type="text" onkeyup="" class="search-input form-control form-control-flush ps-10" name="search" value="" placeholder="Search..." data-kt-search-element="input" />
                                           <span class="position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-1" data-kt-search-element="spinner">
                                               <span class="spinner-border h-15px w-15px align-middle text-gray-400"></span>
                                           </span>
                                           <span class="btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 d-none" data-kt-search-element="clear">
                                               <span class="svg-icon svg-icon-2 svg-icon-lg-1 me-0">
                                                   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                       <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                                       <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                                   </svg>
                                               </span>
                                           </span>
                                           <div class="position-absolute top-50 end-0 translate-middle-y" data-kt-search-element="toolbar">
                                               <div data-kt-search-element="preferences-show" class="btn btn-icon w-20px btn-sm btn-active-color-primary me-1" data-bs-toggle="tooltip" title="Show search preferences">
                                                   <span class="svg-icon svg-icon-1">
                                                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                           <path opacity="0.3" d="M22.1 11.5V12.6C22.1 13.2 21.7 13.6 21.2 13.7L19.9 13.9C19.7 14.7 19.4 15.5 18.9 16.2L19.7 17.2999C20 17.6999 20 18.3999 19.6 18.7999L18.8 19.6C18.4 20 17.8 20 17.3 19.7L16.2 18.9C15.5 19.3 14.7 19.7 13.9 19.9L13.7 21.2C13.6 21.7 13.1 22.1 12.6 22.1H11.5C10.9 22.1 10.5 21.7 10.4 21.2L10.2 19.9C9.4 19.7 8.6 19.4 7.9 18.9L6.8 19.7C6.4 20 5.7 20 5.3 19.6L4.5 18.7999C4.1 18.3999 4.1 17.7999 4.4 17.2999L5.2 16.2C4.8 15.5 4.4 14.7 4.2 13.9L2.9 13.7C2.4 13.6 2 13.1 2 12.6V11.5C2 10.9 2.4 10.5 2.9 10.4L4.2 10.2C4.4 9.39995 4.7 8.60002 5.2 7.90002L4.4 6.79993C4.1 6.39993 4.1 5.69993 4.5 5.29993L5.3 4.5C5.7 4.1 6.3 4.10002 6.8 4.40002L7.9 5.19995C8.6 4.79995 9.4 4.39995 10.2 4.19995L10.4 2.90002C10.5 2.40002 11 2 11.5 2H12.6C13.2 2 13.6 2.40002 13.7 2.90002L13.9 4.19995C14.7 4.39995 15.5 4.69995 16.2 5.19995L17.3 4.40002C17.7 4.10002 18.4 4.1 18.8 4.5L19.6 5.29993C20 5.69993 20 6.29993 19.7 6.79993L18.9 7.90002C19.3 8.60002 19.7 9.39995 19.9 10.2L21.2 10.4C21.7 10.5 22.1 11 22.1 11.5ZM12.1 8.59998C10.2 8.59998 8.6 10.2 8.6 12.1C8.6 14 10.2 15.6 12.1 15.6C14 15.6 15.6 14 15.6 12.1C15.6 10.2 14 8.59998 12.1 8.59998Z" fill="currentColor" />
                                                           <path d="M17.1 12.1C17.1 14.9 14.9 17.1 12.1 17.1C9.30001 17.1 7.10001 14.9 7.10001 12.1C7.10001 9.29998 9.30001 7.09998 12.1 7.09998C14.9 7.09998 17.1 9.29998 17.1 12.1ZM12.1 10.1C11 10.1 10.1 11 10.1 12.1C10.1 13.2 11 14.1 12.1 14.1C13.2 14.1 14.1 13.2 14.1 12.1C14.1 11 13.2 10.1 12.1 10.1Z" fill="currentColor" />
                                                       </svg>
                                                   </span>
                                               </div>
                                           </div>
                                       </form>
                                       <div class="separator border-gray-200 mb-6"></div>
                                       <div data-kt-search-element="results" class="d-none">
                                           <div class="scroll-y mh-200px mh-lg-350px">
                                               <h3 class="fs-5 text-muted m-0 pb-5" data-kt-search-element="category-title">Users</h3>
                                               <a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                   <div class="symbol symbol-40px me-4">
                                                       <img src="<?= base_url('assets/main/') ?>media/avatars/300-6.jpg" alt="" />
                                                   </div>
                                                   <div class="d-flex flex-column justify-content-start fw-bold">
                                                       <span class="fs-6 fw-bold">Karina Clark</span>
                                                       <span class="fs-7 fw-bold text-muted">Marketing Manager</span>
                                                   </div>
                                               </a>
                                               <a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                   <div class="symbol symbol-40px me-4">
                                                       <img src="<?= base_url('assets/main/') ?>media/avatars/300-2.jpg" alt="" />
                                                   </div>
                                                   <div class="d-flex flex-column justify-content-start fw-bold">
                                                       <span class="fs-6 fw-bold">Olivia Bold</span>
                                                       <span class="fs-7 fw-bold text-muted">Software Engineer</span>
                                                   </div>
                                               </a>
                                               <a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                   <div class="symbol symbol-40px me-4">
                                                       <img src="<?= base_url('assets/main/') ?>media/avatars/300-9.jpg" alt="" />
                                                   </div>
                                                   <div class="d-flex flex-column justify-content-start fw-bold">
                                                       <span class="fs-6 fw-bold">Ana Clark</span>
                                                       <span class="fs-7 fw-bold text-muted">UI/UX Designer</span>
                                                   </div>
                                               </a>
                                               <a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                   <div class="symbol symbol-40px me-4">
                                                       <img src="<?= base_url('assets/main/') ?>media/avatars/300-14.jpg" alt="" />
                                                   </div>
                                                   <div class="d-flex flex-column justify-content-start fw-bold">
                                                       <span class="fs-6 fw-bold">Nick Pitola</span>
                                                       <span class="fs-7 fw-bold text-muted">Art Director</span>
                                                   </div>
                                               </a>
                                               <a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                   <div class="symbol symbol-40px me-4">
                                                       <img src="<?= base_url('assets/main/') ?>media/avatars/300-11.jpg" alt="" />
                                                   </div>
                                                   <div class="d-flex flex-column justify-content-start fw-bold">
                                                       <span class="fs-6 fw-bold">Edward Kulnic</span>
                                                       <span class="fs-7 fw-bold text-muted">System Administrator</span>
                                                   </div>
                                               </a>
                                               <h3 class="fs-5 text-muted m-0 pt-5 pb-5" data-kt-search-element="category-title">Customers</h3>
                                               <a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                   <div class="symbol symbol-40px me-4">
                                                       <span class="symbol-label bg-light">
                                                           <img class="w-20px h-20px" src="<?= base_url('assets/main/') ?>media/svg/brand-logos/volicity-9.svg" alt="" />
                                                       </span>
                                                   </div>
                                                   <div class="d-flex flex-column justify-content-start fw-bold">
                                                       <span class="fs-6 fw-bold">Company Rbranding</span>
                                                       <span class="fs-7 fw-bold text-muted">UI Design</span>
                                                   </div>
                                               </a>
                                               <a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                   <div class="symbol symbol-40px me-4">
                                                       <span class="symbol-label bg-light">
                                                           <img class="w-20px h-20px" src="<?= base_url('assets/main/') ?>media/svg/brand-logos/tvit.svg" alt="" />
                                                       </span>
                                                   </div>
                                                   <div class="d-flex flex-column justify-content-start fw-bold">
                                                       <span class="fs-6 fw-bold">Company Re-branding</span>
                                                       <span class="fs-7 fw-bold text-muted">Web Development</span>
                                                   </div>
                                               </a>
                                               <a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                   <div class="symbol symbol-40px me-4">
                                                       <span class="symbol-label bg-light">
                                                           <img class="w-20px h-20px" src="<?= base_url('assets/main/') ?>media/svg/misc/infography.svg" alt="" />
                                                       </span>
                                                   </div>
                                                   <div class="d-flex flex-column justify-content-start fw-bold">
                                                       <span class="fs-6 fw-bold">Business Analytics App</span>
                                                       <span class="fs-7 fw-bold text-muted">Administration</span>
                                                   </div>
                                               </a>
                                               <h3 class="fs-5 text-muted m-0 pt-5 pb-5" data-kt-search-element="category-title">Projects</h3>
                                               <a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                   <div class="symbol symbol-40px me-4">
                                                       <span class="symbol-label bg-light">
                                                           <span class="svg-icon svg-icon-2 svg-icon-primary">
                                                               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                   <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM12.5 18C12.5 17.4 12.6 17.5 12 17.5H8.5C7.9 17.5 8 17.4 8 18C8 18.6 7.9 18.5 8.5 18.5L12 18C12.6 18 12.5 18.6 12.5 18ZM16.5 13C16.5 12.4 16.6 12.5 16 12.5H8.5C7.9 12.5 8 12.4 8 13C8 13.6 7.9 13.5 8.5 13.5H15.5C16.1 13.5 16.5 13.6 16.5 13ZM12.5 8C12.5 7.4 12.6 7.5 12 7.5H8C7.4 7.5 7.5 7.4 7.5 8C7.5 8.6 7.4 8.5 8 8.5H12C12.6 8.5 12.5 8.6 12.5 8Z" fill="currentColor" />
                                                                   <rect x="7" y="17" width="6" height="2" rx="1" fill="currentColor" />
                                                                   <rect x="7" y="12" width="10" height="2" rx="1" fill="currentColor" />
                                                                   <rect x="7" y="7" width="6" height="2" rx="1" fill="currentColor" />
                                                                   <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor" />
                                                               </svg>
                                                           </span>
                                                       </span>
                                                   </div>
                                                   <div class="d-flex flex-column">
                                                       <span class="fs-6 fw-bold">Si-Fi Project by AU Themes</span>
                                                       <span class="fs-7 fw-bold text-muted">#45670</span>
                                                   </div>
                                               </a>
                                               <a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                   <div class="symbol symbol-40px me-4">
                                                       <span class="symbol-label bg-light">
                                                           <span class="svg-icon svg-icon-2 svg-icon-primary">
                                                               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                   <rect x="8" y="9" width="3" height="10" rx="1.5" fill="currentColor" />
                                                                   <rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5" fill="currentColor" />
                                                                   <rect x="18" y="11" width="3" height="8" rx="1.5" fill="currentColor" />
                                                                   <rect x="3" y="13" width="3" height="6" rx="1.5" fill="currentColor" />
                                                               </svg>
                                                           </span>
                                                       </span>
                                                   </div>
                                                   <div class="d-flex flex-column">
                                                       <span class="fs-6 fw-bold">Shopix Mobile App Planning</span>
                                                       <span class="fs-7 fw-bold text-muted">#45690</span>
                                                   </div>
                                               </a>
                                               <a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                   <div class="symbol symbol-40px me-4">
                                                       <span class="symbol-label bg-light">
                                                           <span class="svg-icon svg-icon-2 svg-icon-primary">
                                                               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                   <path opacity="0.3" d="M20 3H4C2.89543 3 2 3.89543 2 5V16C2 17.1046 2.89543 18 4 18H4.5C5.05228 18 5.5 18.4477 5.5 19V21.5052C5.5 22.1441 6.21212 22.5253 6.74376 22.1708L11.4885 19.0077C12.4741 18.3506 13.6321 18 14.8167 18H20C21.1046 18 22 17.1046 22 16V5C22 3.89543 21.1046 3 20 3Z" fill="currentColor" />
                                                                   <rect x="6" y="12" width="7" height="2" rx="1" fill="currentColor" />
                                                                   <rect x="6" y="7" width="12" height="2" rx="1" fill="currentColor" />
                                                               </svg>
                                                           </span>
                                                       </span>
                                                   </div>
                                                   <div class="d-flex flex-column">
                                                       <span class="fs-6 fw-bold">Finance Monitoring SAAS Discussion</span>
                                                       <span class="fs-7 fw-bold text-muted">#21090</span>
                                                   </div>
                                               </a>
                                               <a href="#" class="d-flex text-dark text-hover-primary align-items-center mb-5">
                                                   <div class="symbol symbol-40px me-4">
                                                       <span class="symbol-label bg-light">
                                                           <span class="svg-icon svg-icon-2 svg-icon-primary">
                                                               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                   <path opacity="0.3" d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM12 7C10.3 7 9 8.3 9 10C9 11.7 10.3 13 12 13C13.7 13 15 11.7 15 10C15 8.3 13.7 7 12 7Z" fill="currentColor" />
                                                                   <path d="M12 22C14.6 22 17 21 18.7 19.4C17.9 16.9 15.2 15 12 15C8.8 15 6.09999 16.9 5.29999 19.4C6.99999 21 9.4 22 12 22Z" fill="currentColor" />
                                                               </svg>
                                                           </span>
                                                       </span>
                                                   </div>
                                                   <div class="d-flex flex-column">
                                                       <span class="fs-6 fw-bold">Dashboard Analitics Launch</span>
                                                       <span class="fs-7 fw-bold text-muted">#34560</span>
                                                   </div>
                                               </a>
                                           </div>
                                       </div>
                                       <div class="mb-5" data-kt-search-element="main">
                                           <div class="d-flex flex-stack fw-bold mb-4">
                                               <span class="text-muted fs-6 me-2">Recently Searched:</span>
                                           </div>
                                           <div class="scroll-y mh-200px mh-lg-325px">
                                               <div class="d-flex align-items-center mb-5">
                                                   <div class="symbol symbol-40px me-4">
                                                       <span class="symbol-label bg-light">
                                                           <span class="svg-icon svg-icon-2 svg-icon-primary">
                                                               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                   <path d="M2 16C2 16.6 2.4 17 3 17H21C21.6 17 22 16.6 22 16V15H2V16Z" fill="currentColor" />
                                                                   <path opacity="0.3" d="M21 3H3C2.4 3 2 3.4 2 4V15H22V4C22 3.4 21.6 3 21 3Z" fill="currentColor" />
                                                                   <path opacity="0.3" d="M15 17H9V20H15V17Z" fill="currentColor" />
                                                               </svg>
                                                           </span>
                                                       </span>
                                                   </div>
                                                   <div class="d-flex flex-column">
                                                       <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">BoomApp by Keenthemes</a>
                                                       <span class="fs-7 text-muted fw-bold">#45789</span>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                       <div data-kt-search-element="empty" class="text-center d-none">
                                           <div class="pt-10 pb-10">
                                               <span class="svg-icon svg-icon-4x opacity-50">
                                                   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                       <path opacity="0.3" d="M14 2H6C4.89543 2 4 2.89543 4 4V20C4 21.1046 4.89543 22 6 22H18C19.1046 22 20 21.1046 20 20V8L14 2Z" fill="currentColor" />
                                                       <path d="M20 8L14 2V6C14 7.10457 14.8954 8 16 8H20Z" fill="currentColor" />
                                                       <rect x="13.6993" y="13.6656" width="4.42828" height="1.73089" rx="0.865447" transform="rotate(45 13.6993 13.6656)" fill="currentColor" />
                                                       <path d="M15 12C15 14.2 13.2 16 11 16C8.8 16 7 14.2 7 12C7 9.8 8.8 8 11 8C13.2 8 15 9.8 15 12ZM11 9.6C9.68 9.6 8.6 10.68 8.6 12C8.6 13.32 9.68 14.4 11 14.4C12.32 14.4 13.4 13.32 13.4 12C13.4 10.68 12.32 9.6 11 9.6Z" fill="currentColor" />
                                                   </svg>
                                               </span>
                                           </div>
                                           <div class="pb-15 fw-bold">
                                               <h3 class="text-gray-600 fs-5 mb-2">No result found</h3>
                                               <div class="text-muted fs-7">Please try again with a different query</div>
                                           </div>
                                       </div>
                                   </div>
                                   <form data-kt-search-element="preferences" class="pt-1 d-none">
                                       <h3 class="fw-bold text-dark mb-7">Type Pencarian</h3>
                                       <div class="pb-4 border-bottom">
                                           <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
                                               <span class="form-check-label text-gray-700 fs-6 fw-bold ms-0 me-2">Kandang</span>
                                               <input class="form-check-input" type="checkbox" value="kandang" checked="checked" />
                                           </label>
                                       </div>
                                       <div class="py-4 border-bottom">
                                           <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
                                               <span class="form-check-label text-gray-700 fs-6 fw-bold ms-0 me-2">Users</span>
                                               <input class="form-check-input" type="checkbox" value="user" />
                                           </label>
                                       </div>
                                       <div class="d-flex justify-content-end pt-7">
                                           <button type="reset" class="btn btn-sm btn-light fw-bolder btn-active-light-primary me-2" data-kt-search-element="preferences-dismiss">Cancel</button>
                                       </div>
                                   </form>
                               </div>
                           </div>
                       </div> -->
                       <!--begin::Activities-->
                       <!-- <div class="d-flex align-items-center ms-1 ms-lg-3">
                           <div class="btn btn-icon btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px" id="kt_activities_toggle">
                               <span class="svg-icon svg-icon-1">
                                   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                       <rect x="8" y="9" width="3" height="10" rx="1.5" fill="currentColor" />
                                       <rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5" fill="currentColor" />
                                       <rect x="18" y="11" width="3" height="8" rx="1.5" fill="currentColor" />
                                       <rect x="3" y="13" width="3" height="6" rx="1.5" fill="currentColor" />
                                   </svg>
                               </span>
                           </div>
                       </div> -->
                       <!--end::Activities-->
                       <!--begin::Chat-->
                       <!-- <div class="d-flex align-items-center ms-1 ms-lg-3">
                           <div class="btn btn-icon btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px position-relative" id="kt_drawer_chat_toggle">
                               <span class="svg-icon svg-icon-1">
                                   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                       <path opacity="0.3" d="M20 3H4C2.89543 3 2 3.89543 2 5V16C2 17.1046 2.89543 18 4 18H4.5C5.05228 18 5.5 18.4477 5.5 19V21.5052C5.5 22.1441 6.21212 22.5253 6.74376 22.1708L11.4885 19.0077C12.4741 18.3506 13.6321 18 14.8167 18H20C21.1046 18 22 17.1046 22 16V5C22 3.89543 21.1046 3 20 3Z" fill="currentColor" />
                                       <rect x="6" y="12" width="7" height="2" rx="1" fill="currentColor" />
                                       <rect x="6" y="7" width="12" height="2" rx="1" fill="currentColor" />
                                   </svg>
                               </span>
                               <span class="bullet bullet-dot bg-success h-6px w-6px position-absolute translate-middle top-0 start-50 animation-blink"></span>
                           </div>
                       </div> -->
                       <!--end::Chat-->
                       <!--begin::User menu-->
                       <div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
                           <!--begin::Menu wrapper-->
                           <div class="cursor-pointer" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                               <img src="<?= $this->config->item('app_url') . $this->session->userdata('foto') ?>" alt="user" width="25" />
                           </div>
                           <!--begin::User account menu-->
                           <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px" data-kt-menu="true">
                               <!--begin::Menu item-->
                               <div class="menu-item px-3">
                                   <div class="menu-content d-flex align-items-center px-3">
                                       <div class="me-5">
                                           <img alt="Logo" src="<?= $this->config->item('app_url') . $this->session->userdata('foto') ?>" width="60" />
                                       </div>
                                       <div class="d-flex flex-column">
                                           <div class="fw-bolder d-flex align-items-center fs-5"><?= $this->session->userdata('first_name') ?>
                                               <span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2"><?= $this->session->userdata('role_nm') ?></span>
                                           </div>
                                           <a href="#" class="fw-bold text-muted text-hover-primary fs-7"><?= $this->session->userdata('number') ?></a>
                                       </div>
                                   </div>
                               </div>
                               <!--end::Menu item-->

                               <!-- <div class="separator my-2"></div> -->

                               <div class="menu-item px-5">
                                   <a href="<?= base_url('main/profile') ?>" class="menu-link px-5">My Profile</a>
                               </div>

                               <!-- <div class="menu-item px-5">
                                   <a href="../../demo1/dist/apps/projects/list.html" class="menu-link px-5">
                                       <span class="menu-text">My Projects</span>
                                       <span class="menu-badge">
                                           <span class="badge badge-light-danger badge-circle fw-bolder fs-7">3</span>
                                       </span>
                                   </a>
                               </div>
                               
                               <div class="menu-item px-5" data-kt-menu-trigger="hover" data-kt-menu-placement="left-start">
                                   <a href="#" class="menu-link px-5">
                                       <span class="menu-title">My Subscription</span>
                                       <span class="menu-arrow"></span>
                                   </a>
                                   
                                   <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                       
                                       <div class="menu-item px-3">
                                           <a href="../../demo1/dist/account/referrals.html" class="menu-link px-5">Referrals</a>
                                       </div>
                                       
                                       <div class="menu-item px-3">
                                           <a href="../../demo1/dist/account/billing.html" class="menu-link px-5">Billing</a>
                                       </div>
                                       
                                       <div class="menu-item px-3">
                                           <a href="../../demo1/dist/account/statements.html" class="menu-link px-5">Payments</a>
                                       </div>
                                       
                                       <div class="menu-item px-3">
                                           <a href="../../demo1/dist/account/statements.html" class="menu-link d-flex flex-stack px-5">Statements
                                               <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="View your statements"></i></a>
                                       </div>
                                       
                                       <div class="separator my-2"></div>
                                       
                                       <div class="menu-item px-3">
                                           <div class="menu-content px-3">
                                               <label class="form-check form-switch form-check-custom form-check-solid">
                                                   <input class="form-check-input w-30px h-20px" type="checkbox" value="1" checked="checked" name="notifications" />
                                                   <span class="form-check-label text-muted fs-7">Notifications</span>
                                               </label>
                                           </div>
                                       </div>
                                       
                                   </div>
                                   
                               </div>
                               
                               <div class="menu-item px-5">
                                   <a href="../../demo1/dist/account/statements.html" class="menu-link px-5">My Statements</a>
                               </div>
                               
                               <div class="separator my-2"></div>
                               
                               <div class="menu-item px-5" data-kt-menu-trigger="hover" data-kt-menu-placement="left-start">
                                   <a href="#" class="menu-link px-5">
                                       <span class="menu-title position-relative">Language
                                           <span class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">English
                                               <img class="w-15px h-15px rounded-1 ms-2" src="<?= base_url('assets/main/') ?>media/flags/united-states.svg" alt="" /></span></span>
                                   </a>
                                   
                                   <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                       <
                                       <div class="menu-item px-3">
                                           <a href="../../demo1/dist/account/settings.html" class="menu-link d-flex px-5 active">
                                               <span class="symbol symbol-20px me-4">
                                                   <img class="rounded-1" src="<?= base_url('assets/main/') ?>media/flags/united-states.svg" alt="" />
                                               </span>English</a>
                                       </div>
                                       
                                       <div class="menu-item px-3">
                                           <a href="../../demo1/dist/account/settings.html" class="menu-link d-flex px-5">
                                               <span class="symbol symbol-20px me-4">
                                                   <img class="rounded-1" src="<?= base_url('assets/main/') ?>media/flags/spain.svg" alt="" />
                                               </span>Spanish</a>
                                       </div>
                                       
                                       <div class="menu-item px-3">
                                           <a href="../../demo1/dist/account/settings.html" class="menu-link d-flex px-5">
                                               <span class="symbol symbol-20px me-4">
                                                   <img class="rounded-1" src="<?= base_url('assets/main/') ?>media/flags/germany.svg" alt="" />
                                               </span>German</a>
                                       </div>
                                       
                                       <div class="menu-item px-3">
                                           <a href="../../demo1/dist/account/settings.html" class="menu-link d-flex px-5">
                                               <span class="symbol symbol-20px me-4">
                                                   <img class="rounded-1" src="<?= base_url('assets/main/') ?>media/flags/japan.svg" alt="" />
                                               </span>Japanese</a>
                                       </div>
                                       
                                       <div class="menu-item px-3">
                                           <a href="../../demo1/dist/account/settings.html" class="menu-link d-flex px-5">
                                               <span class="symbol symbol-20px me-4">
                                                   <img class="rounded-1" src="<?= base_url('assets/main/') ?>media/flags/france.svg" alt="" />
                                               </span>French</a>
                                       </div>
                                       
                                   </div>
                                   
                               </div>
                               
                               <div class="menu-item px-5 my-1">
                                   <a href="../../demo1/dist/account/settings.html" class="menu-link px-5">Account Settings</a>
                               </div>
                                -->
                               <div class="menu-item px-5">
                                   <a onclick="logout();" class="menu-link px-5">Sign Out</a>
                               </div>

                               <!-- <div class="separator my-2"></div>
                               
                               <div class="menu-item px-5">
                                   <div class="menu-content px-5">
                                       <label class="form-check form-switch form-check-custom form-check-solid pulse pulse-success" for="kt_user_menu_dark_mode_toggle">
                                           <input class="form-check-input w-30px h-20px" type="checkbox" value="1" name="mode" id="kt_user_menu_dark_mode_toggle" data-kt-url="../../demo1/dist/index.html" />
                                           <span class="pulse-ring ms-n1"></span>
                                           <span class="form-check-label text-gray-600 fs-7">Dark Mode</span>
                                       </label>
                                   </div>
                               </div> -->
                               <!--end::Menu item-->
                           </div>
                           <!--end::User account menu-->
                           <!--end::Menu wrapper-->
                       </div>
                       <!--end::User menu-->
                   </div>
                   <!--end::Toolbar wrapper-->
               </div>
               <!--end::Wrapper-->
           </div>
           <!--end::Container-->
       </div>

       <!--end::Header-->