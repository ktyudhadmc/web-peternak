$("#input_range_tanggal").daterangepicker();
$("#add_kedatangan_general_tanggal").daterangepicker({
  singleDatePicker: true,
});
$("#edit_kedatangan_general_tanggal").daterangepicker({
  singleDatePicker: true,
});
$("#add_mutasi_general_tanggal").daterangepicker({
  singleDatePicker: true,
});
$("#edit_mutasi_general_tanggal").daterangepicker({
  singleDatePicker: true,
});
$("#add_kedatangan_pakan_tanggal").daterangepicker({
  singleDatePicker: true,
});
$("#edit_kedatangan_pakan_tanggal").daterangepicker({
  singleDatePicker: true,
});
$("#add_mutasi_pakan_tanggal").daterangepicker({
  singleDatePicker: true,
});
$("#edit_mutasi_pakan_tanggal").daterangepicker({
  singleDatePicker: true,
});
$("#add_kedatangan_ovk_tanggal").daterangepicker({
  singleDatePicker: true,
});
$("#edit_kedatangan_ovk_tanggal").daterangepicker({
  singleDatePicker: true,
});
$("#add_mutasi_ovk_tanggal").daterangepicker({
  singleDatePicker: true,
});
$("#edit_mutasi_ovk_tanggal").daterangepicker({
  singleDatePicker: true,
});
function rapitabel(idtable) {
  $("#" + idtable)
    .DataTable()
    .columns.adjust()
    .fixedColumns()
    .relayout();
}
function logout() {
  Swal.fire({
    title: "Apakah anda yakin ingin logout?",
    icon: "warning",
    iconColor: "#f05924",
    showCancelButton: true,
    confirmButtonText:
      '<div class="text-white needfontsize"><img src="' +
      base_url_ternak +
      'assets/resource/icon/check-white.svg" height=24 width=24>&nbsp;Iya </div>',
    cancelButtonText:
      '<div class="text-dark needfontsize"><img src="' +
      base_url_ternak +
      'assets/resource/icon/close.svg" height=24 width=24>&nbsp;Tidak </div>',
    confirmButtonClass: "btn btn-outline-primary",
    cancelButtonClass: "btn btn-outline-primary",
    width: 250,
    buttonsStyling: false,
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = base_url + "auth/logout";
    }
  });
}

function reformatDate(dateStr) {
  dArr = dateStr.split("-"); // ex input "2010-01-18"
  return dArr[1] + "/" + dArr[2] + "/" + dArr[0]; //ex out: "18/01/10"
}

function loading(status) {
  if ((status = "on")) {
    Swal.fire({
      title: "Please Wait !",
      allowEscapeKey: false,
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });
  } else {
    Swal.close();
  }
}

function notifalert(title, message, icon) {
  Swal.fire({
    title: title,
    text: message,
    icon: icon,
    iconColor: "#f05924",
    confirmButtonText:
      '<div class="text-white needfontsize"><img src="' +
      base_url_ternak +
      'assets/resource/icon/check-white.svg" height=24 width=24>&nbsp;Iya </div>',
    showCloseButton: true,
    width: 250,
    confirmButtonClass: "btn btn-outline-primary",
    cancelButtonClass: "btn btn-outline-primary",
    width: 250,
    buttonsStyling: false,
  });
}

function set_flashdata(icon, tittle) {
  Swal.fire({
    position: "top-end",
    icon: icon,
    title: tittle,
    showConfirmButton: false,
    timer: 1500,
  });
}

function return_set_flashdata(icon, tittle) {
  Swal.fire({
    position: "top-end",
    icon: icon,
    title: tittle,
    showConfirmButton: false,
    timer: 1500,
  });
  return false;
}

function viewtablerole() {
  var role = document.querySelector("#filter_role").value;
  $("#exampletablerole tfoot th").each(function () {
    var title = $(this).text();
    $(this).html(
      '<br><input class="form-control" type="text" placeholder="Search ' +
        title +
        '" />',
    );
  });
  //---------Tabel Point Feed----------//
  var tpf = $("#exampletablerole").DataTable({
    // filter: false,
    info: true,
    destroy: true,
    lengthChange: true,
    order: [[0, "desc"]],
    paging: true,
    pageLength: 7,
    lengthMenu: [
      [7, 10, 25, 50, -1],
      [7, 10, 25, 50, "All"],
    ],
    scrollCollapse: true,
    scrollY: "350px",
    scrollX: true,
    dom: '<"top"B>rt<"bottom"ilp><"clear">',
    buttons: [
      {
        extend: "excel",
        footer: true,
        title: "tabel role",
      },
      {
        extend: "pdf",
        footer: true,
        title: "tabel role",
      },
      {
        extend: "print",
        footer: true,
        title: "tabel role",
      },
      {
        extend: "copy",
        text: "Copy current page",
        exportOptions: {
          modifier: {
            page: "current",
          },
        },
      },
    ],
    ajax: {
      type: "POST",
      url: base_url + "user/get_data_table_role",
      data: {
        role: role,
      },
      dataSrc: "",
      beforeSend: function () {
        $("#button_viewtablerole").prop("disabled", true); // disable button
        document.querySelector("#button_viewtablerole").innerHTML =
          '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
      },
    },

    columns: [
      {
        data: "role_nm",
      },
      {
        data: "name_navbar",
      },
      {
        data: "is_master",
        className: "text-nowrap",
        render: function (data, type, row) {
          if (data == 1) {
            return `<i class="fas fa-check-circle text-sm fa-2x"></i>`;
          } else {
            return `<i class="fas fa-times-circle text-sm fa-2x"></i>`;
          }
        },
      },
      {
        data: "master",
      },
      {
        data: "status",
        className: "text-nowrap",
        render: function (data, type, row) {
          if (data == 1) {
            return (
              `<a href="javascript:void(0);"   onclick="update_role(` +
              row["id_role"] +
              `,` +
              data +
              `,` +
              row["id_navbar"] +
              `)" ><i class="fas fa-check-circle text-success fa-2x"></i></a>`
            );
          } else {
            return (
              `<a href="javascript:void(0);"   onclick="update_role(` +
              row["id_role"] +
              `,` +
              data +
              `,` +
              row["id_navbar"] +
              `)" ><i class="fas fa-times-circle text-danger fa-2x"></i></a>`
            );
          }
        },
      },
      {
        data: "is_developt",
        className: "text-nowrap",
        render: function (data, type, row) {
          if (data == 1) {
            return (
              `<a href="javascript:void(0);"   onclick="update_navbar(` +
              data +
              `,` +
              row["id_navbar"] +
              `,'role')" ><i class="fas fa-check-circle text-success fa-2x"></i></a>`
            );
          } else {
            return (
              `<a href="javascript:void(0);"   onclick="update_navbar(` +
              data +
              `,` +
              row["id_navbar"] +
              `,'role')" ><i class="fas fa-times-circle text-danger fa-2x"></i></a>`
            );
          }
        },
      },
    ],
    columnDefs: [
      {
        targets: "_all",
        defaultContent: "0",
      },
    ],
    order: [[0, "desc"]],

    initComplete: function () {
      this.api()
        .buttons()
        .container()
        .appendTo($(".col-md-6:eq(0)", this.api().table().container()));
      this.api()
        .columns()
        .every(function () {
          var that = this;

          $("input", this.footer()).on("keyup change clear", function () {
            if (that.search() !== this.value) {
              that.search(this.value).draw();
            }
          });
        });
      $("#button_viewtablerole").prop("disabled", false); // enable button
      document.querySelector("#button_viewtablerole").innerHTML = "Load";
    },
    footerCallback: function (row, data, start, end, display) {
      var api = this.api(),
        data;
      // Remove the formatting to get integer data for summation
      var intVal = function (i) {
        return typeof i === "string"
          ? i.replace(/[\$,]/g, "") * 1
          : typeof i === "number"
            ? i
            : 0;
      };

      var coltosum = [];
      for (c in coltosum) {
        // Total over all pages
        // console.log(api.column( coltosum[c] ).data())
        // total = api.column( coltosum[c] ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
        // Total over this page
        pageTotal = api
          .column(coltosum[c], {
            page: "current",
          })
          .data()
          .reduce(function (a, b) {
            return intVal(a) + intVal(b);
          }, 0);
        // Update footer
        $(api.column(coltosum[c]).footer()).html(pageTotal);
      }
    },
  });
  //---------End Tabel Point Feed----------//
}

function viewtablenavbar() {
  var role = document.querySelector("#filter_role").value;
  $("#exampletablenavbar tfoot th").each(function () {
    var title = $(this).text();
    $(this).html(
      '<br><input class="form-control" type="text" placeholder="Search ' +
        title +
        '" />',
    );
  });
  //---------Tabel Point Feed----------//
  var tpf = $("#exampletablenavbar").DataTable({
    // filter: false,
    info: true,
    destroy: true,
    lengthChange: true,
    order: [[0, "desc"]],
    paging: true,
    pageLength: 7,
    lengthMenu: [
      [7, 10, 25, 50, -1],
      [7, 10, 25, 50, "All"],
    ],
    scrollCollapse: true,
    scrollY: "350px",
    scrollX: true,
    dom: '<"top"B>rt<"bottom"ilp><"clear">',
    buttons: [
      {
        extend: "excel",
        footer: true,
        title: "tabel role",
      },
      {
        extend: "pdf",
        footer: true,
        title: "tabel role",
      },
      {
        extend: "print",
        footer: true,
        title: "tabel role",
      },
      {
        extend: "copy",
        text: "Copy current page",
        exportOptions: {
          modifier: {
            page: "current",
          },
        },
      },
    ],
    ajax: {
      type: "POST",
      url: base_url + "user/get_data_table_navbar",
      data: {
        role: role,
      },
      dataSrc: "",
      beforeSend: function () {
        $("#button_viewtablenavbar").prop("disabled", true); // disable button
        document.querySelector("#button_viewtablenavbar").innerHTML =
          '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
      },
    },

    columns: [
      {
        data: "is_main",
        className: "text-nowrap",
        render: function (data, type, row) {
          if (data == 1) {
            return `Main`;
          } else {
            return `App`;
          }
        },
      },
      {
        data: "name",
      },
      {
        data: "is_master",
        className: "text-nowrap",
        render: function (data, type, row) {
          if (data == 1) {
            return `<i class="fas fa-check-circle text-sm fa-2x"></i>`;
          } else {
            return `<i class="fas fa-times-circle text-sm fa-2x"></i>`;
          }
        },
      },
      {
        data: "master_id",
      },
      {
        data: "variable",
      },
      {
        data: "link",
      },
      {
        data: "icon",
      },
      {
        data: "is_developt",
        className: "text-nowrap",
        render: function (data, type, row) {
          if (data == 1) {
            return (
              `<a href="javascript:void(0);"   onclick="update_navbar(` +
              data +
              `,` +
              row["id"] +
              `,'navbar')" ><i class="fas fa-check-circle text-success fa-2x"></i></a>`
            );
          } else {
            return (
              `<a href="javascript:void(0);"   onclick="update_navbar(` +
              data +
              `,` +
              row["id"] +
              `,'navbar')" ><i class="fas fa-times-circle text-danger fa-2x"></i></a>`
            );
          }
        },
      },
      {
        data: "id",
        className: "text-nowrap",
        render: function (data, type, row) {
          // modal_edit_navbar(id,name,is_main,variable,link,icon,is_master,master_id,is_developt)
          return (
            `<a href="javascript:void(0);"  class="btn btn-primary btn-sm " onclick="modal_edit_navbar(` +
            data +
            `,'` +
            row["name"] +
            `',` +
            row["is_main"] +
            `,'` +
            row["variable"] +
            `','` +
            row["link"] +
            `','` +
            row["icon"] +
            `',` +
            row["is_master"] +
            `,` +
            row["master_id"] +
            `,` +
            row["is_developt"] +
            `)" ><i class="fas fa-pencil-alt"></i>&nbsp Edit</a>
  <a href="javascript:void(0);"  class="btn btn-danger btn-sm" onclick="modal_edit_navbar()"><i class="fa fa-trash"></i>&nbsp Delete</a>`
          );
        },
      },
    ],
    columnDefs: [
      {
        targets: "_all",
        defaultContent: "0",
      },
    ],
    order: [[0, "desc"]],

    initComplete: function () {
      this.api()
        .buttons()
        .container()
        .appendTo($(".col-md-6:eq(0)", this.api().table().container()));
      this.api()
        .columns()
        .every(function () {
          var that = this;

          $("input", this.footer()).on("keyup change clear", function () {
            if (that.search() !== this.value) {
              that.search(this.value).draw();
            }
          });
        });
      $("#button_viewtablenavbar").prop("disabled", false); // enable button
      document.querySelector("#button_viewtablenavbar").innerHTML = "Load";
    },
    footerCallback: function (row, data, start, end, display) {
      var api = this.api(),
        data;
      // Remove the formatting to get integer data for summation
      var intVal = function (i) {
        return typeof i === "string"
          ? i.replace(/[\$,]/g, "") * 1
          : typeof i === "number"
            ? i
            : 0;
      };

      var coltosum = [];
      for (c in coltosum) {
        // Total over all pages
        // console.log(api.column( coltosum[c] ).data())
        // total = api.column( coltosum[c] ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
        // Total over this page
        pageTotal = api
          .column(coltosum[c], {
            page: "current",
          })
          .data()
          .reduce(function (a, b) {
            return intVal(a) + intVal(b);
          }, 0);
        // Update footer
        $(api.column(coltosum[c]).footer()).html(pageTotal);
      }
    },
  });
  //---------End Tabel Point Feed----------//
}

function modal_lokasi(id_combo_box, value = "0", label = "Pilih Lokasi") {
  var temp = "";
  var parsedata;
  $.ajax({
    method: "POST",
    url: base_url + "main2/get_data_lokasi",
    cache: false,
    data: {},
    success: function (response) {
      parsedata = JSON.parse(response);
      temp += `<option value='` + value + `'>` + label + `</option>`;
      for (var i = 0; i < parsedata.length; i++) {
        temp +=
          `<option value='` +
          parsedata[i].id +
          `'>` +
          parsedata[i].first_name +
          `</option>`;
      }
      $(id_combo_box).html(temp);
      // $("#add_mutasi_pakan_brand").html(temp);
    },
  });
}

function select_role(id_combo_box, value = "0", label = "Pilih Role") {
  var temp = "";
  var parsedata;
  $.ajax({
    method: "POST",
    url: base_url + "user/get_data_role",
    cache: false,
    data: {},
    success: function (response) {
      parsedata = JSON.parse(response);
      temp += `<option value='` + value + `'>` + label + `</option>`;
      for (var i = 0; i < parsedata.length; i++) {
        temp +=
          `<option value='` +
          parsedata[i].id +
          `'>` +
          parsedata[i].role_nm +
          `</option>`;
      }
      $(id_combo_box).html(temp);
      // $("#add_mutasi_pakan_brand").html(temp);
    },
  });
}

function update_role(id_role, fitur, id_navbar) {
  if (fitur == "1") {
    title = "Nonaktif fitur ini?";
    var fitur_func = "delete";
  } else {
    title = "Aktifkan fitur ini?";
    var fitur_func = "aktif";
  }
  Swal.fire({
    title: title,
    text: "Data ini akan diupdate, pastikan kembali anda tidak salah pencet",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Update",
    cancelButtonText: "Tidak",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: base_url + "user/update_role",
        data: {
          id: id_role,
          fitur: fitur_func,
          id_navbar: id_navbar,
        },
        cache: false,
        beforeSend: function () {
          loading("on");
        },
        success: function (data) {
          // loading("off");
          var parsedata = JSON.parse(data);
          console.log(parsedata);
          if (parsedata.status == "success") {
            set_flashdata(parsedata.status, parsedata.comment);
          } else {
            set_flashdata(parsedata.status, parsedata.comment);
          }
          viewtablerole();
        },
        complete: function () {},
      });
    }
  });
}

function update_navbar(fitur, id_navbar, tabel) {
  if (fitur == "1") {
    title = "Nonaktif fitur ini?";
    var fitur_func = "aktif";
  } else {
    title = "Aktifkan fitur ini?";
    var fitur_func = "delete";
  }
  Swal.fire({
    title: title,
    text: "Data ini akan diupdate, pastikan kembali anda tidak salah pencet",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Update",
    cancelButtonText: "Tidak",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: base_url + "user/update_navbar",
        data: {
          fitur: fitur_func,
          id_navbar: id_navbar,
        },
        cache: false,
        beforeSend: function () {
          loading("on");
        },
        success: function (data) {
          // loading("off");
          var parsedata = JSON.parse(data);
          console.log(parsedata);
          if (parsedata.status == "success") {
            set_flashdata(parsedata.status, parsedata.comment);
          } else {
            set_flashdata(parsedata.status, parsedata.comment);
          }
          if (tabel == "role") {
            viewtablerole();
          } else if (tabel == "navbar") {
            viewtablenavbar();
          }
        },
        complete: function () {},
      });
    }
  });
}

function edit_user_table(
  id,
  first_name,
  number,
  role_nm,
  role,
  member,
  banned_users,
  status,
) {
  select_role(`#edit_user_role`, role, role_nm);
  $("#edit_user_id_user").val(id);
  $("#edit_user_first_name").val(first_name);
  $("#edit_user_number").val(number);
  $("#edit_user_member").val(member).change();
  $("#edit_user_banned").val(banned_users).change();
  $("#edit_user_status").val(status).change();
  $("#modal_edit_user").modal("show");
}

function add_user() {
  console.log("=== add_user() dipanggil ===");

  $.ajax({
    type: "POST",
    url: base_url + "user/add_user",
    dataType: "json", // ← tambah ini
    data: {
      first_name: document.querySelector("#add_user_first_name").value,
      number: document.querySelector("#add_user_number").value,
      role: document.querySelector("#add_user_role").value,
      email: document.querySelector("#add_user_email").value,
      alamat: document.querySelector("#add_user_alamat").value,
    },
    cache: false,
    beforeSend: function () {
      $("#add_user_button").prop("disabled", true);
      document.querySelector("#add_user_label").innerHTML =
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
    },
    success: function (data) {
      // data sudah object, tidak perlu JSON.parse lagi
      if (data.status == "success") {
        set_flashdata(data.status, data.comment);
        // Reset form
        document.querySelector("#add_user_first_name").value = "";
        document.querySelector("#add_user_number").value = "";
        document.querySelector("#add_user_email").value = "";
        document.querySelector("#add_user_alamat").value = "";

        // Tutup modal + paksa hapus backdrop
        $("#modal_add_user").modal("hide");
        $("body").removeClass("modal-open");
        $(".modal-backdrop").remove();

        // Reload table setelah modal tertutup
        $("#modal_add_user").one("hidden.bs.modal", function () {
          viewtablelistuser();
        });
      } else {
        set_flashdata(data.status, data.comment);
      }
    },
    error: function (xhr) {
      console.error("AJAX error:", xhr.responseText);
      set_flashdata("error", "Gagal menghubungi server");
    },
    complete: function () {
      $("#add_user_button").prop("disabled", false);
      document.querySelector("#add_user_label").innerHTML = "Save";
    },
  });
}

function edit_user() {
  // var id_user = document.querySelector('#filter_lokasi').value;
  // console.log($('#edit_kedatangan_pakan_tanggal').data('daterangepicker').startDate.format('YYYY-MM-DD'));
  $.ajax({
    type: "POST",
    url: base_url + "user/edit_user",
    data: {
      id: document.querySelector("#edit_user_id_user").value,
      first_name: document.querySelector("#edit_user_first_name").value,
      number: document.querySelector("#edit_user_number").value,
      role: document.querySelector("#edit_user_role").value,
      user_member: document.querySelector("#edit_user_member").value,
      banned_users: document.querySelector("#edit_user_banned").value,
      status: document.querySelector("#edit_user_status").value,
    },
    cache: false,
    beforeSend: function () {
      $("#edit_user_button").prop("disabled", true); // disable button
      document.querySelector("#edit_user_label").innerHTML =
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
    },
    success: function (data) {
      var parsedata = JSON.parse(data);
      console.log(parsedata);
      if (parsedata.status == "success") {
        set_flashdata(parsedata.status, parsedata.comment);
        viewtablelistuser();
        $("#modal_edit_user").modal("hide");
      } else {
        set_flashdata(parsedata.status, parsedata.comment);
      }
    },
    complete: function () {
      $("#edit_user_button").prop("disabled", false); // enable button
      document.querySelector("#edit_user_label").innerHTML = "Save";
    },
  });
}

function delete_user(id_delete, fitur) {
  // var id_user = document.querySelector('#filter_lokasi').value;
  // console.log(id_delete);
  Swal.fire({
    title: "Hapus data ini ?",
    text: "Data ini akan dihapus dari sistem, pastikan kembali anda tidak salah pencet",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Hapus",
    cancelButtonText: "Tidak",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: base_url + "user/" + fitur,
        data: {
          id: id_delete,
        },
        cache: false,
        beforeSend: function () {
          loading("on");
        },
        success: function (data) {
          // loading("off");
          var parsedata = JSON.parse(data);
          console.log(parsedata);
          if (parsedata.status == "success") {
            set_flashdata("success", "Berhasil Delete Data");
            if (fitur == "delete_user") {
              viewtablelistuser();
            }
          } else {
            set_flashdata("error", "Input Data Gagal");
          }
        },
        complete: function () {},
      });
    }
  });
}

function view_modal_add_navbar() {
  is_master("#add_navbar_is_master");
  select_master_navbar("#add_navbar_master_id");
}

function is_master(select) {
  if (select == "#add_navbar_is_master") {
    var case_master = document.querySelector("#add_navbar_is_master").value;
    console.log(case_master);
    if (case_master == 1) {
      $("#add_navbar_master_id").prop("disabled", true); // enable button
      $("#add_navbar_link").prop("disabled", true); // enable button
      $("#add_navbar_link").val("#");
      $("#add_navbar_master_id").val("0").change();
    } else {
      $("#add_navbar_master_id").prop("disabled", false); // enable button
      $("#add_navbar_link").prop("disabled", false); // enable button
      $("#add_navbar_link").val("");
    }
  } else {
    var case_master = document.querySelector("#edit_navbar_is_master").value;
    console.log(case_master);
    if (case_master == 1) {
      $("#edit_navbar_master_id").prop("disabled", true); // enable button
      $("#edit_navbar_link").prop("disabled", true); // enable button
      $("#edit_navbar_link").val("#");
      $("#edit_navbar_master_id").val("0").change();
    } else {
      $("#edit_navbar_master_id").prop("disabled", false); // enable button
      $("#edit_navbar_link").prop("disabled", false); // enable button
      $("#edit_navbar_link").val("");
    }
  }
}

function select_master_navbar(id_combo_box, value = "0", label = "-") {
  if (id_combo_box == "#add_navbar_master_id") {
    var case_master = document.querySelector("#add_navbar_is_main").value;
  } else {
    var case_master = document.querySelector("#edit_navbar_is_main").value;
  }
  var temp = "";
  var parsedata;
  $.ajax({
    method: "POST",
    url: base_url + "user/select_master_navbar",
    cache: false,
    data: {
      case_master: case_master,
    },
    success: function (response) {
      parsedata = JSON.parse(response);
      temp += `<option value='` + value + `'>` + label + `</option>`;
      for (var i = 0; i < parsedata.length; i++) {
        temp +=
          `<option value='` +
          parsedata[i].id +
          `'>` +
          parsedata[i].name +
          `</option>`;
      }
      $(id_combo_box).html(temp);
      // $("#add_mutasi_pakan_brand").html(temp);
    },
  });
}

function modal_edit_navbar(
  id,
  name,
  is_main,
  variable,
  link,
  icon,
  is_master_val,
  master_id,
  is_developt,
) {
  $("#edit_navbar_is_master").prop("disabled", false);
  $("#edit_navbar_name").val(name);
  $("#edit_navbar_is_main").val(is_main).change();
  $("#edit_navbar_variable").val(variable);
  $("#edit_navbar_link").val(link);
  $("#edit_navbar_icon").val(icon);
  $("#edit_navbar_is_master").val(is_master_val).change();
  $("#edit_navbar_master_id").val(master_id).change();
  $("#edit_navbar_is_developt").val(is_developt).change();
  $("#edit_navbar_id").val(id);
  select_master_navbar(`#edit_navbar_master_id`);
  is_master("#edit_navbar_is_master");
  if (is_master_val != 1) {
    $("#edit_navbar_is_main").prop("disabled", true); // enable button
  } else {
    $("#edit_navbar_is_main").prop("disabled", false); // enable button
  }
  $("#edit_navbar_is_master").prop("disabled", true);
  $("#modal_edit_navbar").modal("show");
}

function add_navbar() {
  // var id_user = document.querySelector('#filter_lokasi').value;
  // console.log($('#edit_kedatangan_pakan_tanggal').data('daterangepicker').startDate.format('YYYY-MM-DD'));
  $.ajax({
    type: "POST",
    url: base_url + "user/add_navbar",
    data: {
      name: document.querySelector("#add_navbar_name").value,
      is_main: document.querySelector("#add_navbar_is_main").value,
      variable: document.querySelector("#add_navbar_variable").value,
      link: document.querySelector("#add_navbar_link").value,
      icon: document.querySelector("#add_navbar_icon").value,
      is_master: document.querySelector("#add_navbar_is_master").value,
      master_id: document.querySelector("#add_navbar_master_id").value,
      is_developt: document.querySelector("#add_navbar_is_developt").value,
    },
    cache: false,
    beforeSend: function () {
      $("#add_navbar_button").prop("disabled", true); // disable button
      document.querySelector("#add_navbar_label").innerHTML =
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
    },
    success: function (data) {
      var parsedata = JSON.parse(data);
      console.log(parsedata);
      if (parsedata.status == "success") {
        set_flashdata(parsedata.status, parsedata.comment);
        $("#modal_add_navbar").modal("hide");
        document.querySelector("#add_navbar_name").value = "";
        document.querySelector("#add_navbar_variable").value = "";
        document.querySelector("#add_navbar_link").value = "";
        document.querySelector("#add_navbar_icon").value = "";
        viewtablenavbar();
      } else {
        set_flashdata(parsedata.status, parsedata.comment);
      }
    },
    complete: function () {
      $("#add_navbar_button").prop("disabled", false); // enable button
      document.querySelector("#add_navbar_label").innerHTML = "Save";
    },
  });
}

function edit_navbar() {
  // var id_user = document.querySelector('#filter_lokasi').value;
  // console.log($('#edit_kedatangan_pakan_tanggal').data('daterangepicker').startDate.format('YYYY-MM-DD'));
  $.ajax({
    type: "POST",
    url: base_url + "user/edit_navbar",
    data: {
      id: document.querySelector("#edit_navbar_id").value,
      name: document.querySelector("#edit_navbar_name").value,
      is_main: document.querySelector("#edit_navbar_is_main").value,
      variable: document.querySelector("#edit_navbar_variable").value,
      link: document.querySelector("#edit_navbar_link").value,
      icon: document.querySelector("#edit_navbar_icon").value,
      is_master: document.querySelector("#edit_navbar_is_master").value,
      master_id: document.querySelector("#edit_navbar_master_id").value,
      is_developt: document.querySelector("#edit_navbar_is_developt").value,
    },
    cache: false,
    beforeSend: function () {
      $("#edit_navbar_button").prop("disabled", true); // disable button
      document.querySelector("#edit_navbar_label").innerHTML =
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...';
    },
    success: function (data) {
      var parsedata = JSON.parse(data);
      console.log(parsedata);
      if (parsedata.status == "success") {
        set_flashdata(parsedata.status, parsedata.comment);
        $("#modal_edit_navbar").modal("hide");
        document.querySelector("#edit_navbar_name").value = "";
        document.querySelector("#edit_navbar_variable").value = "";
        document.querySelector("#edit_navbar_link").value = "";
        document.querySelector("#edit_navbar_icon").value = "";
        viewtablenavbar();
      } else {
        set_flashdata(parsedata.status, parsedata.comment);
      }
    },
    complete: function () {
      $("#edit_navbar_button").prop("disabled", false); // enable button
      document.querySelector("#edit_navbar_label").innerHTML = "Save";
    },
  });
}

// $('#modal_edit_mutasi_pakan').on('hidden.bs.modal', function () {
//   alert('close');
//   $('#edit_mutasi_pakan_brand').val(0);
//   $('#edit_mutasi_pakan_lokasi_tujuan').val(0);
// })
function clearvalue(id) {
  var getid = document.getElementById(id);
  getid.value = "";
}

var preloader = document.getElementById("preloader");

if (preloader) {
  window.addEventListener("load", function () {
    var fadeOut = setInterval(function () {
      if (!preloader.style.opacity) {
        preloader.style.opacity = 1;
      }
      if (preloader.style.opacity > 0) {
        preloader.style.opacity -= 0.1;
      } else {
        clearInterval(fadeOut);
        preloader.remove();
      }
    }, 20);
  });
}
var geturlglobal = document.getElementById("waitingcard");
if (geturlglobal) {
  if (current_url.indexOf("=") > -1) {
    var dataraw = current_url.split("=");
    let countd = dataraw.length - 1;
    window.location.href = base_url + dataraw[countd];
  } else {
    window.location.href = base_url + "home";
  }
}

function dowaiting(obj) {
  var url = obj.getAttribute("href");
  var dataraw = url.split(base_url);
  window.location.href = base_url + "waiting?loadto=" + dataraw[1];
  return false;
}

function senddata(url, value, method, cb) {
  var xhttp;
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if (typeof cb === "function") cb(this.responseText);
    }
  };

  xhttp.open(method, url, true);
  xhttp.send(value);
}

function loadingnih() {
  var html = ` 
    <div class="ph-item">
        <div class="ph-col-12">
            <div class="ph-row">
                <div class="ph-col-12"></div>
                <div class="ph-col-12"></div>
            </div>
            <div class="ph-picture"></div>
        </div>
    </div>`;
  return html;
}

function getcookienih(value) {
  var search = new RegExp(value + "=", "i"); // prepare a regex object
  let outputraw = cookiea.filter((item) => search.test(item));
  var outputfinal = outputraw[0].split("=")[1]; //
  return outputfinal;
}

function loadScript(url, callback) {
  // Adding the script tag to the head as suggested before
  var head = document.head;
  var script = document.createElement("script");
  script.type = "text/javascript";
  script.src = url;

  // Then bind the event to the callback function.
  // There are several events for cross browser compatibility.
  script.onreadystatechange = callback;
  script.onload = callback;

  // Fire the loading
  head.appendChild(script);
}

// Form Input kandang
function modaltambahternakshow() {
  $("#modaltambahternak").modal("show");
  $.ajax({
    method: "POST",
    url: api_url + "kandang/typekandang",
    data: {
      token: tokenfinal,
    },
    success: function (response) {
      dataraw = JSON.parse(response);
      var r;
      for (let i = 0; i < dataraw.length; i++) {
        r +=
          `<option value="` +
          dataraw[i].id +
          `">` +
          dataraw[i].nama_kandang_type +
          `</option>`;
      }
      $("#selecttypekandang").html(r);
    },
  });
}

function inputkandang() {
  var dataformnya = new FormData();
  var nama =
    $("#inputkandangnama").val() == ""
      ? return_set_flashdata("error", "Nama tidak boleh kosong")
      : $("#inputkandangnama").val();
  var alamat =
    $("#inputkandangalamat").val() == ""
      ? return_set_flashdata("error", "Alamat tidak boleh kosong")
      : $("#inputkandangalamat").val();
  var kapasitas =
    $("#inputkandangkapasitas").val() == ""
      ? return_set_flashdata("error", "Kapasitas tidak boleh kosong")
      : $("#inputkandangkapasitas").val();
  var files = $("#fotokandang")[0].files;
  if (nama !== false) {
    dataformnya.append("nama", nama);
  } else {
    return;
  }
  if (alamat !== false) {
    dataformnya.append("alamat", alamat);
  } else {
    return;
  }
  if (kapasitas !== false) {
    dataformnya.append("kapasitas", kapasitas);
  } else {
    return;
  }
  dataformnya.append("type_kandang", $("#selecttypekandang").val());
  dataformnya.append("user_id", user_idjs);
  if (files.length > 0) {
    dataformnya.append("foto", files[0]);
  }
  dataformnya.append("token", tokenfinal);
  // data.arraypush('token', tokenfinal);
  $.ajax({
    type: "POST",
    url: api_url + "kandang/inputkandang",
    data: dataformnya,
    cache: false,
    contentType: false,
    processData: false,
    success: function (response) {
      outputjson = JSON.parse(response);
      if (outputjson.status == true) {
        set_flashdata("success", outputjson.message);
      }
      $("#inputkandangnama").val("");
      $("#inputkandangalamat").val("");
      $("#inputkandangkapasitas").val("");
    },
  });
}

function ucwords(str) {
  return (str + "").replace(/^([a-z])|\s+([a-z])/g, function ($1) {
    return $1.toUpperCase();
  });
}

function formatDate(date) {
  var d = new Date(date),
    month = "" + (d.getMonth() + 1),
    day = "" + d.getDate(),
    year = d.getFullYear();

  if (month.length < 2) month = "0" + month;
  if (day.length < 2) day = "0" + day;

  return [year, month, day].join("-");
}

function selectall(id) {
  $("#" + id + " > option").prop("selected", true);
  $("#" + id).trigger("change");
}

function imgError(id) {
  var url = $("#" + id).attr("src");
  let domain = new URL(url);
  let newpath = domain.pathname;
  $("#" + id).attr("src", "http://sek.my.id:4001/peternak" + newpath);
}
