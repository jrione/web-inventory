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
    <h2 class="text-center mb-4 fw-bold text-primary">🎉 Selamat Datang, <?= $dataUser->username ?> | <button class="btn btn-danger" id="logoutBtn"><i class="fa fa-sign-out"></i></button> </h2>

    <ul class="nav nav-tabs mb-3" id="inventoryTabs" role="tablist">
      <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#barangTersedia">Barang Tersedia</a></li>
      <li id="barangDipinjamMenu" class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#barangDipinjam">Barang Dipinjam</a></li>
      <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#userProfil">Profil</a></li>
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
      
      <div class="tab-pane fade" id="barangDipinjam">
        <h5 class="mb-3">Daftar Peminjam</h5>
        <table class="table table-bordered table-hover bg-white">
          <thead>
            <tr>
              <th>Barang Pinjaman</th>
              <th>Jumlah</th>
              <th>Pinjaman pertama</th>
              <th>Pinjaman terakhir</th>
            </tr>
          </thead>
          <tbody id="showDataBorrow">
            <!-- Blank, Autofill -->
          </tbody>
        </table>
      </div>

      <!-- User Profil -->
      <div class="tab-pane fade" id="userProfil">
        <h5 class="mb-3">Profil Pengguna</h5>
        <div class="p-4 rounded shadow-sm bg-white">
          <!-- Preview Foto Profil di bagian atas -->
          <div class="text-center mb-4">
            <div class="position-relative d-inline-block">
              <img id="profilePhoto" src="<?= BASE_URL ?>public/assets/img/<?= $dataUser->img ?>" 
                  alt="Foto Profil" class="rounded-circle border" 
                  style="width: 120px; height: 120px; object-fit: cover;">
              <div class="position-absolute bottom-0 end-0">
                <button type="button" class="btn btn-sm btn-primary rounded-circle" 
                        onclick="document.getElementById('fotoProfil').click()">
                  <i class="fas fa-camera"></i>
                </button>
              </div>
            </div>
            <div class="mt-2">
              <small class="text-muted">Klik tombol kamera untuk mengubah foto</small>
            </div>
          </div>
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" value="<?= $dataUser->username ?>" disabled />
          </div>
          <div class="mb-3">
            <label for="fullName" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="fullName" value="<?= $dataUser->full_name ?>" required />
          </div>
          <div class="mb-3">
            <label for="fullName" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" value="<?= $dataUser->email ?>" required />
          </div>
          <div class="mb-3">
            <label for="nomorHp" class="form-label">Nomor HP</label>
            <input type="tel" class="form-control" id="nomorHp" value="<?= $dataUser->no_hp ?>" required />
          </div>
          <div class="mb-3">
            <label for="fotoProfil" class="form-label">Foto Profil</label>
            <input type="file" class="form-control" id="fotoProfil" accept="image/*" onchange="previewPhoto(this)" />
            <div class="form-text">Format yang didukung: JPG, PNG, GIF (Maksimal 2MB)</div>
          </div>

          <button type="submit" id="btn_changeProfile" class="btn btn-success">Update Profil</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Script -->
  <script>
  function previewPhoto(input) {
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('profilePhoto').src = e.target.result;
      };
      reader.readAsDataURL(input.files[0]);
    }
  }


  $("#barangDipinjamMenu").on("click",function(){
    $("#showDataBorrow").empty();
    $.ajax({
      url: '<?= BASE_URL ?>'+'api/user/borrow/list',
      method: 'POST',
      contentType: 'application/json',
      data: JSON.stringify({
        user_id: parseInt('<?= $dataUser->user_id ?>')
      }),
      headers: {
          'Authorization': 'Basic ' + btoa('<?= $_SESSION["username"] ?>:<?= $_SESSION['password'] ?>')
      },
      success: function(response) {
        console.log(response)
        for(let i=0;i<response.length;i++){
          const userObj = encodeURIComponent(JSON.stringify(response[i]));
          $("#showDataBorrow").append(
            `<tr onclick="returnBorrowData(JSON.parse(decodeURIComponent('${userObj}')))">
              <td>${response[i]['nama_barang']}</td>
              <td>${response[i]['total_qty_dipinjam']}</td>
              <td>${response[i]['pinjaman_pertama']}</td>
              <td>${response[i]['pinjaman_terakhir']}</td>
            </tr>`
          );
        }
      }
    });
  });
  
  function returnBorrowData(data){
    Swal.fire({
        icon: 'warning',
        title: "Kembalikan barang?",
        showDenyButton: true,
        confirmButtonText: "Ya",
        denyButtonText: `Batal`
        }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '<?= BASE_URL ?>'+'api/user/borrow/return',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
              user_id: parseInt('<?= $dataUser->user_id ?>'),
              id_barang: parseInt(data.id_barang),
              total_item_borrowed: parseInt(data.total_qty_dipinjam),
            }),
            headers: {
              'Authorization': 'Basic ' + btoa('<?= $_SESSION["username"] ?>:<?= $_SESSION['password'] ?>')
            },
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
              console.error('Error:', error);
            }
          });
           
        } else if (result.isDenied) {
            return false;
        }
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
                confirmButtonText: "Pinjam",
                cancelButtonText: "Kembali",
                reverseButtons: false,
                customClass: {
                  confirmButton: 'btn-info'
                }
                }).then((result) => {
                if (result.isConfirmed) {
                  swalWithBootstrapButtons.fire({
                    title: "Peminjaman",
                    html: `
                    <div class="mb-3">
                      <label for="jumlah" class="form-label">Jumlah</label>
                      <input type="number" id="totalItemBorrowed" class="form-control" id="jumlah" required />
                    </div>
                    `,
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonText: "Confirm",
                    cancelButtonText:"Cancel"
                  }).then(function(isConfirm) {
                      if (isConfirm.isConfirmed) {
                        $.ajax({
                          url: '<?= BASE_URL ?>'+'api/user/borrow/add',
                          type: 'POST',
                          data: JSON.stringify({
                            total_item_borrowed: parseInt($("#totalItemBorrowed").val()),
                            id_barang: parseInt(response[0].id_barang),
                            user_id: parseInt('<?= $dataUser->user_id ?>'),
                          }),
                          headers: {
                              'Authorization': 'Basic ' + btoa('<?= $_SESSION["username"] ?>:<?= $_SESSION['password'] ?>')
                          },
                          contentType: 'application/json',
                          dataType: 'json',
                          success: function(response) {
                              Swal.fire({
                                title: 'Perhatian',
                                text: 'Barang berhasil dipinjam',
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
                                  console.log('Error parsing JSON response:', e);
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

  $('#btn_changeProfile').click(function(e){
    e.preventDefault();
    const formData = {
      username: $('#username').val(),
      full_name: $('#fullName').val(),
      email: $('#email').val(),
      no_hp: $('#nomorHp').val()
    };

    var dataFoto = new FormData();
    dataFoto.append('user_id','<?= $dataUser->user_id ?>')
    dataFoto.append('foto_profil',$("#fotoProfil")[0].files[0])
    
    $.ajax({
      url: '<?= BASE_URL ?>'+'api/user/update',
      method: 'PATCH',
      contentType: 'application/json',
      dataType: 'json',
      data: JSON.stringify({
        where: {
          user_id: '<?= $dataUser->user_id ?>'
        },
        dataUpdated: formData
      }),
      headers: {
        'Authorization': 'Basic ' + btoa('<?= $_SESSION["username"] ?>:<?= $_SESSION['password'] ?>')
      },
      success: function(response) {
        $.ajax({
            url: '<?= BASE_URL ?>'+'api/user/upload',
            method: 'POST',
            data: dataFoto,
            processData: false,
            contentType: false,
            headers: {
                'Authorization': 'Basic ' + btoa('<?= $_SESSION["username"] ?>:<?= $_SESSION['password'] ?>')
            },
            success: function(r) {
                console.log(r)
            },
            error: function(xhr,status,error){
                console.log(error)
            }
        });
         Swal.fire({
              icon: 'success',
              title: 'Update Berhasil!',
              text: 'Data Berhasil diubah!',
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
