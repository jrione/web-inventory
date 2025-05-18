<!DOCTYPE html>
<html lang="id">
<head>
    <style>
        body {
            background: linear-gradient(rgba(0, 123, 255, 0.7), rgba(0, 123, 255, 0.9));
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .register-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 500px;
            width: 100%;
            margin: 30px 0;
        }
        
        .register-header {
            background-color: #0d6efd;
            color: white;
            padding: 20px;
            text-align: center;
        }
        
        .register-body {
            padding: 30px;
        }
        
        .form-control {
            padding: 12px;
            border-radius: 5px;
        }
        
        .btn-register {
            padding: 12px;
            font-weight: 600;
            width: 100%;
            border-radius: 5px;
            margin-top: 10px;
        }
        
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 25px 0;
        }
        
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #ced4da;
        }
        
        .divider span {
            padding: 0 10px;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .back-link {
            margin-top: 15px;
            text-align: center;
        }
        
        .back-link a {
            color: #0d6efd;
            text-decoration: none;
            font-weight: 500;
        }
        
        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-6">
                <div class="register-card ml-6">
                    <div class="register-header">
                        <h3 class="m-0">Buat Akun Baru</h3>
                    </div>
                    <div class="register-body">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" id="username" placeholder="Masukkan Username Anda" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="full_name" class="form-label">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" id="full_name" placeholder="Masukkan Nama Lengkap Anda" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" id="email" placeholder="Masukkan email Anda" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Kata Sandi</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="password" placeholder="Buat kata sandi" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Konfirmasi Kata Sandi</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="confirmPassword" placeholder="Konfirmasi kata sandi" required>
                            </div>
                        </div>
                        
                        <button type="submit" id="btn_register" class="btn btn-primary btn-register">
                            <i class="fas fa-user-plus me-2"></i>Daftar
                        </button>
                        
                        <div class="divider">
                        </div>
                        
                        <div class="back-link">
                            <p>Sudah punya akun? <a href="<?= BASE_URL ?>login">Masuk</a></p>
                            <a href="/"><i class="fas fa-home me-1"></i>Kembali ke Beranda</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.21.1/dist/sweetalert2.all.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>

$(document).ready(function(){
    $("#btn_register").on("click",function(e){
        e.preventDefault;

        if ($('#password').val() !== $('#confirmPassword').val()) {
            Swal.fire({
                icon: 'warning',
                title: 'Kata Sandi Tidak Cocok',
                text: 'Pastikan konfirmasi kata sandi sama dengan kata sandi Anda'
            });
        }
        else{
            const formData = {
                username: $('#username').val(),
                full_name: $('#full_name').val(),
                email: $('#email').val(),
                password: $('#password').val()
            };
            console.log(formData);
            
            Swal.fire({
                title: 'Loading...',
                text: 'Sedang memproses pendaftaran Anda',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            $.ajax({
                url: '<?= BASE_URL ?>'+'auth/register',
                type: 'POST',
                data: JSON.stringify(formData),
                contentType: 'application/json',
                dataType: 'json',
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Pendaftaran Berhasil!',
                        text: 'Akun Anda berhasil dibuat. Silakan login untuk melanjutkan.',
                        confirmButtonText: 'Login Sekarang'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '<?= BASE_URL ?>'+'login';
                        }
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
                        title: 'Pendaftaran Gagal',
                        html: errorMessage + (errorDetails ? errorDetails : ''),
                        confirmButtonText: 'Coba Lagi'
                    });
                }
            });
        }
        
        
    });
});

</script>