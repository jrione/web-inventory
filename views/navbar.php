<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#"><?= $title ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://about.jri.one">Tentang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://about.jri.one">Kontak</a>
                </li>
            </ul>
            <div class="auth-buttons ms-lg-3">
                <a href="<?= BASE_URL ?>login" class="btn btn-outline-light">Masuk</a>
                <a href="<?= BASE_URL ?>register" class="btn btn-primary">Daftar</a>
            </div>
        </div>
    </div>
</nav>