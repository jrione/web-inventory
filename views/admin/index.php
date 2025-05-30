<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Admin - JriOne's Inventory</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <style>
    .nav-tabs .nav-link.active {
      background-color: #0d6efd;
      color: white;
      border-radius: 0.5rem 0.5rem 0 0;
    }
    .card:hover {
      cursor: pointer;
      box-shadow: 0 0 10px rgba(0, 123, 255, 0.2);
    }
    .list-group-item:hover {
      background-color: #f8f9fa;
      cursor: pointer;
    }
    tbody tr:hover {
      background-color: #f8f9fa;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="container py-4 rounded shadow-sm bg-light" style="margin-top: 90px;">
    <h2 class="text-center mb-4 fw-bold text-primary">🎉 Selamat Datang, <?= $_SESSION['username'] ?> | <button class="btn btn-danger" id="logoutBtn"><i class="fa fa-sign-out"></i></button> </h2>

    <ul class="nav nav-tabs mb-3" id="inventoryTabs" role="tablist">
      <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#barangTersedia">Barang Tersedia</a></li>
      <li id="barangDipinjamMenu" class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#barangDipinjam">Barang Dipinjam</a></li>
      <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tambahBarang">Tambah Barang</a></li>
      <li id="listUserMenu" class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#listUser">Daftar User</a></li>
    </ul>

    <div class="tab-content">
      <div class="tab-pane fade show active" id="barangTersedia">
        <h5 class="mb-3">Barang yang Tersedia  <i onclick="window.location.reload()" class="fa fa-refresh" style="cursor: pointer"></i></h5>
        <div class="row row-cols-1 row-cols-md-3 g-3" id="barang-tersedia-list">
        <?php 
            for($i=0; $i < count($dataAllBarang); $i++){
        ?>
          <div class="col">
            <div class="card h-100" onclick="showBarangDetail(`<?= $dataAllBarang[$i]['kode_barang'] ?>`)">
              <div class="card-body">
                <h5 class="card-title"><?= $dataAllBarang[$i]['nama_barang']  ?></h5><p><?= $dataAllBarang[$i]['kode_barang'] ?></p> <!-- nama_barang | kode_barang -->
                <p class="card-text"><?= $dataAllBarang[$i]['jumlah_barang']." ".$dataAllBarang[$i]['satuan_barang'] ?></p> <!-- jumlah_barang -->
                <?php
                  if($dataAllBarang[$i]['jumlah_barang'] == 0 || $dataAllBarang[$i]['status_barang'] == false){
                    echo '<span class="badge bg-danger">Not Available</span>';
                  }
                  else{
                    echo '<span class="badge bg-primary">Available</span>';
                  }
                ?>
                  
              </div>
            </div>
          </div>
        <?php
            }
        ?>
        </div>
      </div>


      <!-- Tambah Barang -->
      <div class="tab-pane fade" id="tambahBarang">
        <h5 class="mb-3">Tambah Barang</h5>
        <div class="p-4 rounded shadow-sm bg-white">
          <div class="mb-3">
            <label for="namaBarang" class="form-label">Nama Barang</label>
            <input type="text" class="form-control" id="namaBarang" required />
          </div>
          <div class="mb-3">
            <label for="kodeBarang" class="form-label">Kode Barang</label>
            <input type="text" class="form-control" id="kodeBarang" required />
          </div>
          <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" class="form-control" id="jumlah" required />
          </div>
          <div class="mb-3">
            <label for="satuanBarang" class="form-label">Satuan Barang</label>
            <select class="form-control" id="satuanBarang" required>
              <option value="">-- Pilih Satuan --</option>
              <option value="pcs">pcs</option>
              <option value="meter">meter</option>
              <option value="kg">kg</option>
              <option value="liter">liter</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="hargaBarang" class="form-label">Harga Barang</label>
            <input type="text" class="form-control" id="hargaBarang" required />
          </div>
          <div class="mb-3">
            <label class="form-label">Status Barang</label><br>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="statusBarang" id="statusTrue" value="1" required>
              <label class="form-check-label" for="statusTrue">Tersedia</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="statusBarang" id="statusFalse" value="0">
              <label class="form-check-label" for="statusFalse">Tidak Tersedia</label>
            </div>
          </div>

          <button type="submit" id="btn_tambahBarang" class="btn btn-success">Tambah</button>
        </div>
      </div>

      <!-- Daftar User -->
      <div class="tab-pane fade" id="listUser">
        <h5 class="mb-3" id="daftarUserMenu">Daftar User</h5>
        <table class="table table-bordered table-hover bg-white">
          <thead>
            <tr>
              <th>Username</th>
              <th>Roles</th>
            </tr>
          </thead>
          <tbody id="showUser">
            <!-- Blank, Autofill -->
          </tbody>
        </table>
      </div>

      <div class="tab-pane fade" id="barangDipinjam">
        <h5 class="mb-3" id="barangDipinjamMenu">Daftar Peminjam</h5>
        <table class="table table-bordered table-hover bg-white">
          <thead>
            <tr>
              <th>Barang Pinjaman</th>
              <th>Peminjam</th>
            </tr>
          </thead>
          <tbody id="showDataBorrow">
            <!-- Blank, Autofill -->
          </tbody>
        </table>
      </div>
      
    </div>
  </div>

  <!-- Script -->
  <script>
  $("#listUserMenu").on("click",function(){
    $("#showUser").empty();
    $.ajax({
      url: '<?= BASE_URL ?>'+'api/user/listAll',
      method: 'POST',
      contentType: 'application/json',
      headers: {
          'Authorization': 'Basic ' + btoa('<?= $_SESSION["username"] ?>:<?= $_SESSION['password'] ?>')
      },
      success: function(response) {
        for(let i=0;i<response.length;i++){
          const userObj = encodeURIComponent(JSON.stringify(response[i]));
          $("#showUser").append(
            `<tr onclick="showUserDetail(JSON.parse(decodeURIComponent('${userObj}')))">
              <td>${response[i]['username']}</td>
              <td>${response[i]['roles']}</td>
            </tr>`
          );
        }
      }
    });
  })

  $("#barangDipinjamMenu").on("click",function(){
    $("#showDataBorrow").empty();
    $.ajax({
      url: '<?= BASE_URL ?>'+'api/user/borrow/listAll',
      method: 'POST',
      contentType: 'application/json',
      headers: {
          'Authorization': 'Basic ' + btoa('<?= $_SESSION["username"] ?>:<?= $_SESSION['password'] ?>')
      },
      success: function(response) {
        console.log(response)
        for(let i=0;i<response.length;i++){
          const userObj = encodeURIComponent(JSON.stringify(response[i]));
          $("#showDataBorrow").append(
            `<tr onclick="showBorrowDetail(JSON.parse(decodeURIComponent('${userObj}')))">
              <td>${response[i]['nama_barang']}</td>
              <td>${response[i]['nama_peminjam']}</td>
            </tr>`
          );
        }
      }
    });
  });

  function showBorrowDetail(data){
    Swal.fire({
      title: 'Detail Peminjam',
      html: `<table style="
                width: 80%; 
                max-width: 400px; 
                margin: 0 auto; 
                border-collapse: collapse; 
                font-family: Arial, sans-serif; 
                font-size: 14px;
                box-shadow: 0 0 5px rgba(0,0,0,0.1);
                " border="1" cellpadding="6" cellspacing="0">
                <thead style="background-color: #f0f0f0; color: #333;">
                    <tr>
                    <th align="left" style="padding: 8px;">Field</th>
                    <th align="left" style="padding: 8px;">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td style="padding: 6px;">Username</td>
                    <td style="padding: 6px;">${data.username_peminjam}</td>
                    </tr>
                    <tr>
                    <td style="padding: 6px;">Nama Lengkap</td>
                    <td style="padding: 6px;">${data.nama_peminjam}</td>
                    </tr>
                    <tr>
                    <td style="padding: 6px;">email</td>
                    <td style="padding: 6px;">${data.email_peminjam}</td>
                    </tr>
                    <tr>
                    <td style="padding: 6px;">Nomor HP</td>
                    <td style="padding: 6px;">${data.telepon_peminjam}</td>
                    </tr>
                    <tr>
                    <td style="padding: 6px;">Kode barang dipinjam</td>
                    <td style="padding: 6px;">${data.kode_barang}</td>
                    </tr>
                    <tr>
                    <td style="padding: 6px;">Nama barang dipinjam</td>
                    <td style="padding: 6px;">${data.nama_barang}</td>
                    </tr>
                    <tr>
                    <td style="padding: 6px;">Total barang dipinjam</td>
                    <td style="padding: 6px;">${data.total_qty_dipinjam}</td>
                    </tr>
                    <tr>
                    <td style="padding: 6px;">Pinjaman pertama</td>
                    <td style="padding: 6px;">${data.pinjaman_pertama}</td>
                    </tr>
                    <td style="padding: 6px;">Pinjaman terakhir</td>
                    <td style="padding: 6px;">${data.pinjaman_terakhir}</td>
                    </tr>
                </tbody>
              </table>`,
      icon: 'info'
    });
  }

  function showUserDetail(data) {
    Swal.fire({
      title: 'Detail User',
      html: `<table style="
                width: 80%; 
                max-width: 400px; 
                margin: 0 auto; 
                border-collapse: collapse; 
                font-family: Arial, sans-serif; 
                font-size: 14px;
                box-shadow: 0 0 5px rgba(0,0,0,0.1);
                " border="1" cellpadding="6" cellspacing="0">
                <thead style="background-color: #f0f0f0; color: #333;">
                    <tr>
                    <th align="left" style="padding: 8px;">Field</th>
                    <th align="left" style="padding: 8px;">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td style="padding: 6px;">Username</td>
                    <td style="padding: 6px;">${data.username}</td>
                    </tr>
                    <tr>
                    <td style="padding: 6px;">Nama Lengkap</td>
                    <td style="padding: 6px;">${data.full_name}</td>
                    </tr>
                    <tr>
                    <td style="padding: 6px;">email</td>
                    <td style="padding: 6px;">${data.email}</td>
                    </tr>
                    <tr>
                    <td style="padding: 6px;">Nomor HP</td>
                    <td style="padding: 6px;">${data.no_hp}</td>
                    </tr>
                    <tr>
                    <td style="padding: 6px;">Role</td>
                    <td style="padding: 6px;">${data.roles}</td>
                    </tr>
                    <tr>
                    <td style="padding: 6px;">Created</td>
                    <td style="padding: 6px;">${data.created_at}</td>
                    </tr>
                    <tr>
                    <td style="padding: 6px;">Updated</td>
                    <td style="padding: 6px;">${data.updated_at}</td>
                    </tr>
                </tbody>
              </table>`,
      iconHtml: `
         <img id="profilePhoto" src="<?= BASE_URL ?>public/assets/img/${data.img}" 
                  alt="Foto Profil" class="rounded-circle border" 
                  style="width: 120px; height: 120px; object-fit: cover;">
      `
    });
  }

  function showBarangDetail(data) {
    $.ajax({
        url: '<?= BASE_URL ?>'+'api/barang/list',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            kode_barang: data
        }),
        headers: {
            'Authorization': 'Basic ' + btoa('<?= $_SESSION["username"] ?>:<?= $_SESSION['password'] ?>')
        },
        success: function(response) {
            let isAvail = "" ;
            (response[0].status_barang == "1")
                ? isAvail="Available"
                : isAvail="Not Available"
            const swalWithBootstrapButtons = Swal.mixin({
              customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: "btn btn-info"
              },
              buttonsStyling: true
            });
            swalWithBootstrapButtons.fire({
                title: 'Detail Barang',
                html: `
                    <table style="
                    width: 80%; 
                    max-width: 400px; 
                    margin: 0 auto; 
                    border-collapse: collapse; 
                    font-family: Arial, sans-serif; 
                    font-size: 14px;
                    box-shadow: 0 0 5px rgba(0,0,0,0.1);
                    " border="1" cellpadding="6" cellspacing="0">
                    <thead style="background-color: #f0f0f0; color: #333;">
                        <tr>
                        <th align="left" style="padding: 8px;">Field</th>
                        <th align="left" style="padding: 8px;">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td style="padding: 6px;">Nama</td>
                        <td style="padding: 6px;">${response[0].nama_barang}</td>
                        </tr>
                        <tr>
                        <td style="padding: 6px;">Kode</td>
                        <td style="padding: 6px;">${response[0].kode_barang}</td>
                        </tr>
                        <tr>
                        <td style="padding: 6px;">Jumlah</td>
                        <td style="padding: 6px;">${response[0].jumlah_barang} ${response[0].satuan_barang}</td>
                        </tr>
                        <tr>
                        <td style="padding: 6px;">Harga</td>
                        <td style="padding: 6px;">${response[0].harga_beli}</td>
                        </tr>
                        <tr>
                        <td style="padding: 6px;">Status</td>
                        <td style="padding: 6px;">${isAvail}</td>
                        </tr>
                        <tr>
                        <td style="padding: 6px;">Created</td>
                        <td style="padding: 6px;">${response[0].created_at}</td>
                        </tr>
                        <tr>
                        <td style="padding: 6px;">Updated</td>
                        <td style="padding: 6px;">${response[0].updated_at}</td>
                        </tr>
                    </tbody>
                    </table>
                `,
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: "<i class='fa fa-trash'></i>",
                cancelButtonText: "<i class='fa fa-edit'></i>",
                reverseButtons: true,
                }).then((result) => {
                if (result.isConfirmed) {
                  swalWithBootstrapButtons.fire({
                    title: "Konfirmasi",
                    text: "Anda yakin ingin menghapusnya?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya",
                    cancelButtonText:"Tidak"
                  }).then(function(isConfirm) {
                      if (isConfirm.isConfirmed) {
                        $.ajax({
                          url: '<?= BASE_URL ?>'+'api/barang/delete',
                          type: 'DELETE',
                          data: JSON.stringify({
                            id_barang: response[0].id_barang
                          }),
                          headers: {
                              'Authorization': 'Basic ' + btoa('<?= $_SESSION["username"] ?>:<?= $_SESSION['password'] ?>')
                          },
                          contentType: 'application/json',
                          dataType: 'json',
                          success: function(response) {
                              Swal.fire({
                                title: 'Perhatian',
                                text: 'Data telah dihapus',
                                icon: 'info'
                              }).then(function(){
                                window.location.reload();
                              });
                          },
                          error: function(xhr, status, error) {
                              let errorMessage = 'Terjadi kesalahan pada server';
                              let errorDetails = '';
                              
                              try {
                                  const response = JSON.parse(xhr.responseText);
                                  console.log(response);
                                  if (response.message) {
                                      errorMessage = response.message;
                                  }
                                  if (response.errors) {
                                      errorDetails = '<ul class="text-start">';
                                      Object.keys(response.errors).forEach(key => {
                                          errorDetails += `<li>${response.errors[key]}</li>`;
                                      });
                                      errorDetails += '</ul>';
                                  }
                              } catch (e) {
                                  console.error('Error parsing JSON response:', e);
                              }
                              
                              Swal.fire({
                                  icon: 'error',
                                  title: 'Gagal Menghapus',
                                  html: errorMessage + (errorDetails ? errorDetails : ''),
                                  confirmButtonText: 'Coba Lagi'
                              });
                          }
                        });
                      } else {
                        console.log("batal")
                      }
                    });
                } else if (
                  result.dismiss === Swal.DismissReason.cancel
                ) {
                  swalWithBootstrapButtons.fire({
                    title: "Update Barang",
                    icon: "warning",
                    showCancelButton: true,
                    html: `
                      <div class="p-4 rounded shadow-sm bg-white">
                        <div class="mb-3">
                          <label for="namaBarangUpdate" class="form-label">Nama Barang</label>
                          <input type="text" class="form-control" id="namaBarangUpdate" value="${response[0].nama_barang}" required />
                        </div>
                        <div class="mb-3">
                          <label for="kodeBarangUpdate" class="form-label">Kode Barang</label>
                          <input type="text" class="form-control" id="kodeBarangUpdate" value="${response[0].kode_barang}" disabled required />
                        </div>
                        <div class="mb-3">
                          <label for="jumlahUpdate" class="form-label">Jumlah (Hanya menambah) </label>
                          <input type="number" class="form-control" id="jumlahUpdate" required />
                        </div>
                        <div class="mb-3">
                          <label for="hargaBarangUpdate"  class="form-label">Harga Barang</label>
                          <input type="text" class="form-control" id="hargaBarangUpdate" value="${parseInt(response[0].harga_beli)}"required />
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Status Barang</label><br>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" checked type="radio" name="statusBarangUpdate" id="statusTrue" value="1" required>
                            <label class="form-check-label" for="statusTrue">Tersedia</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="statusBarangUpdate" id="statusFalse" value="0">
                            <label class="form-check-label" for="statusFalse">Tidak Tersedia</label>
                          </div>
                        </div>
                      </div>
                  `
                  }).then(function(isOK){
                    if(isOK.isConfirmed){
                      let formDataUpdate = {
                        nama_barang: $("#namaBarangUpdate").val(),
                        harga_beli: $("#hargaBarangUpdate").val(),
                        jumlah_barang: $("#jumlahUpdate").val(),
                        status_barang: parseInt($('input[name="statusBarangUpdate"]:checked').val())
                      }
                      console.log(formDataUpdate)
                      console.log(response[0].id_barang)
                      $.ajax({
                        url: '<?= BASE_URL ?>'+'api/barang/update',
                        type: 'PATCH',
                        data: JSON.stringify({
                          where: {
                            id_barang: response[0].id_barang
                          },
                          dataUpdated: formDataUpdate
                        }),
                        headers: {
                            'Authorization': 'Basic ' + btoa('<?= $_SESSION["username"] ?>:<?= $_SESSION['password'] ?>')
                        },
                        contentType: 'application/json',
                        dataType: 'json',
                        success: function(response) {
                            Swal.fire({
                              title: 'Perhatian',
                              text: 'Data telah diupdate',
                              icon: 'info'
                            }).then(function(){
                              window.location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            let errorMessage = 'Terjadi kesalahan pada server';
                            let errorDetails = '';
                            
                            try {
                                const response = JSON.parse(xhr.responseText);
                                console.log(response);
                                if (response.message) {
                                    errorMessage = response.message;
                                }
                                if (response.errors) {
                                    errorDetails = '<ul class="text-start">';
                                    Object.keys(response.errors).forEach(key => {
                                        errorDetails += `<li>${response.errors[key]}</li>`;
                                    });
                                    errorDetails += '</ul>';
                                }
                            } catch (e) {
                                console.error('Error parsing JSON response:', e);
                            }
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Mengupdate barang',
                                html: errorMessage + (errorDetails ? errorDetails : ''),
                                confirmButtonText: 'Coba Lagi'
                            });
                        }
                      });
                    }
                  });
                }
              });
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
    
  }

  function showPinjamDetail(user, barang, tanggal) {
      Swal.fire({
      title: 'Detail Peminjaman',
      html: `
        <table style="
          width: 80%; 
          max-width: 400px; 
          margin: 0 auto; 
          border-collapse: collapse; 
          font-family: Arial, sans-serif; 
          font-size: 14px;
          box-shadow: 0 0 5px rgba(0,0,0,0.1);
        " border="1" cellpadding="6" cellspacing="0">
          <thead style="background-color: #f0f0f0; color: #333;">
            <tr>
              <th align="left" style="padding: 8px;">Field</th>
              <th align="left" style="padding: 8px;">Detail</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="padding: 6px;">Nama</td>
              <td style="padding: 6px;">${user}</td>
            </tr>
            <tr>
              <td style="padding: 6px;">Kode</td>
              <td style="padding: 6px;">${kode}</td>
            </tr>
            <tr>
              <td style="padding: 6px;">Jumlah</td>
              <td style="padding: 6px;">${jumlah}</td>
            </tr>
            <tr>
              <td style="padding: 6px;">Harga</td>
              <td style="padding: 6px;">${harga}</td>
            </tr>
            <tr>
              <td style="padding: 6px;">Status</td>
              <td style="padding: 6px;">${status}</td>
            </tr>
            <tr>
              <td style="padding: 6px;">Created</td>
              <td style="padding: 6px;">${created}</td>
            </tr>
            <tr>
              <td style="padding: 6px;">Updated</td>
              <td style="padding: 6px;">${updated}</td>
            </tr>
          </tbody>
        </table>
      `,
      icon: 'info'
    });
  }


  $('#logoutBtn').click(function(e) {
      e.preventDefault();
      
      Swal.fire({
        icon: 'warning',
        title: "Anda yakin ingin keluar?",
        showDenyButton: true,
        confirmButtonText: "Ya",
        denyButtonText: `Batal`
        }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "<?= BASE_URL ?>";
        } else if (result.isDenied) {
            return false;
        }
    });
  });

  $('#btn_tambahBarang').click(function(e){
    e.preventDefault();
    const formData = {
      kode_barang: $('#kodeBarang').val(),
      nama_barang: $('#namaBarang').val(),
      jumlah_barang: $('#jumlah').val(),
      satuan_barang: $('#satuanBarang').val(),
      harga_beli: $('#hargaBarang').val(),
      status_barang: parseInt($('input[name="statusBarang"]:checked').val())
    };
    console.log(formData);
    $.ajax({
      url: '<?= BASE_URL ?>'+'api/barang/create',
      method: 'POST',
      contentType: 'application/json',
      dataType: 'json',
      data: JSON.stringify(formData),
      headers: {
        'Authorization': 'Basic ' + btoa('<?= $_SESSION["username"] ?>:<?= $_SESSION['password'] ?>')
      },
      success: function(response) {
        console.log(response);
         Swal.fire({
              icon: 'success',
              title: 'Berhasil!',
              text: 'Barang Berhasil ditambah!',
          }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= BASE_URL ?>'+'admin/dashboard';
            };
          });
      },
      error: function(xhr,status,error){
        let errorDetails = '';
        let errorMessage = 'Terjadi kesalahan pada server';
         if (error.message) {
              errorMessage = error.message;
          }
        Swal.fire({
            icon: 'error',
            title: 'Gagal menambahkan barang',
            html: errorMessage + (errorDetails ? errorDetails : ''),
            confirmButtonText: 'Coba Lagi'
        });
      }
    });
  });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
