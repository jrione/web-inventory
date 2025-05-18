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
        
        .login-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
        }
        
        .login-header {
            background-color: #0d6efd;
            color: white;
            padding: 20px;
            text-align: center;
        }
        
        .login-body {
            padding: 30px;
        }
        
        .form-control {
            padding: 12px;
            border-radius: 5px;
        }
        
        .btn-login {
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
            <div class="col-lg-5 col-md-8">
                <div class="login-card">
                    <div class="login-header">
                        <h3 class="m-0">Masuk ke Akun Anda</h3>
                    </div>
                    <div class="login-body">
                        <div class="mb-3">
                            <label for="email" class="form-label">Username</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" id="username" placeholder="Masukkan email Anda" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Kata Sandi</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="password" placeholder="Masukkan kata sandi" required>
                            </div>
                        </div>
                        <button type="submit" id="btn_login" class="btn btn-primary btn-login">
                            <i class="fas fa-sign-in-alt me-2"></i>Masuk
                        </button>
                        
                        <div class="divider">
                        </div>
                        
                        <div class="back-link">
                            <p>Belum punya akun? <a href="<?= BASE_URL ?>register">Daftar</a></p>
                            <a href="<?= BASE_URL ?>"><i class="fas fa-home me-1"></i>Kembali ke Beranda</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.21.1/dist/sweetalert2.all.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>

$(document).ready(function(){
    $("#btn_login").on("click",function(e){
        e.preventDefault;

        const formData = {
            username: $('#username').val(),
            password: $('#password').val()
        };
        
        Swal.fire({
            title: 'Loading...',
            text: '',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        $.ajax({
            url: '<?= BASE_URL ?>'+'auth/login',
            type: 'POST',
            data: JSON.stringify(formData),
            contentType: 'application/json',
            xhrFields: {
                withCredentials: true
            },
            dataType: 'json',
            success: function(response) {
                window.location.href = '<?= BASE_URL ?>'+'admin/dashboard';
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
                    title: 'Login Gagal',
                    html: errorMessage + (errorDetails ? errorDetails : ''),
                    confirmButtonText: 'Coba Lagi'
                });
            }
        });
    });
});

</script>