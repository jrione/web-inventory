<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JriOne's Inventory - Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
        }
        
        .sidebar {
            background-color: #343a40;
            min-height: 100vh;
            color: white;
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            border-radius: 0;
            padding: 0.75rem 1rem;
            transition: 0.3s;
        }
        
        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .sidebar .nav-link.active {
            background-color: #0d6efd;
            color: white;
        }
        
        .sidebar .nav-link i {
            margin-right: 0.5rem;
        }
        
        .content-header {
            background-color: white;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .content-body {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .brand {
            padding: 1rem;
            font-size: 1.25rem;
            font-weight: bold;
            background-color: #2c3136;
            text-align: center;
        }
        
        .btn-add {
            background-color: #28a745;
            color: white;
        }
        
        .btn-add:hover {
            background-color: #218838;
            color: white;
        }
        
        .btn-delete {
            background-color: #dc3545;
            color: white;
        }
        
        .btn-delete:hover {
            background-color: #c82333;
            color: white;
        }
        
        .btn-edit {
            background-color: #ffc107;
        }
        
        .btn-edit:hover {
            background-color: #e0a800;
        }
        
        .card-stats .card-body {
            padding: 1rem;
        }
        
        .card-stats i {
            font-size: 2rem;
            opacity: 0.7;
        }
        
        .icon-shape {
            width: 48px;
            height: 48px;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .item-status {
            font-size: 0.75rem;
            padding: 0.2rem 0.5rem;
            border-radius: 1rem;
        }
        
        .bg-success-soft {
            background-color: rgba(40, 167, 69, 0.15);
            color: #28a745;
        }
        
        .bg-danger-soft {
            background-color: rgba(220, 53, 69, 0.15);
            color: #dc3545;
        }
        
        .mobile-toggle {
            display: none;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: -250px;
                width: 250px;
                z-index: 1000;
                transition: 0.3s;
            }
            
            .sidebar.show {
                left: 0;
            }
            
            .mobile-toggle {
                display: block;
                position: fixed;
                top: 1rem;
                left: 1rem;
                z-index: 999;
                background-color: #343a40;
                color: white;
                border: none;
                border-radius: 0.25rem;
                padding: 0.5rem;
            }
            
            .content {
                margin-top: 4rem;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 px-0 sidebar" id="sidebar">
                <div class="brand">
                    <i class="bi bi-box-seam me-2"></i>JriOne's Inventory
                </div>
                <div class="d-flex flex-column">
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="#dashboard" class="nav-link active" data-bs-toggle="pill">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#itemsList" class="nav-link" data-bs-toggle="pill">
                                <i class="bi bi-box"></i> List Barang
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#usersList" class="nav-link" data-bs-toggle="pill">
                                <i class="bi bi-people"></i> List User
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#borrowedItems" class="nav-link" data-bs-toggle="pill">
                                <i class="bi bi-clipboard-check"></i> Barang Dipinjam
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#addItem" class="nav-link" data-bs-toggle="pill">
                                <i class="bi bi-plus-circle"></i> Tambah Barang
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#profile" class="nav-link" data-bs-toggle="pill">
                                <i class="bi bi-person-circle"></i> Profile
                            </a>
                        </li>
                        <li class="nav-item mt-3">
                            <a href="#" class="nav-link text-danger" id="logoutBtn">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <button class="mobile-toggle" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 ms-sm-auto px-md-4 content">
                <!-- Tab Content -->
                <div class="tab-content">
                    <!-- Dashboard Tab -->
                    <div class="tab-pane fade show active" id="dashboard">
                        <div class="content-header">
                            <h4 class="mb-0">Dashboard</h4>
                        </div>

                        <!-- Stats Cards -->
                        <div class="row">
                            <div class="col-md-3 mb-4">
                                <div class="card card-stats">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title text-muted mb-0">Total Barang</h5>
                                                <span class="h2 font-weight-bold mb-0">350</span>
                                            </div>
                                            <div class="col-auto">
                                                <div class="icon-shape bg-primary text-white">
                                                    <i class="bi bi-box"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="card card-stats">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title text-muted mb-0">Tersedia</h5>
                                                <span class="h2 font-weight-bold mb-0">245</span>
                                            </div>
                                            <div class="col-auto">
                                                <div class="icon-shape bg-success text-white">
                                                    <i class="bi bi-check-circle"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="card card-stats">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title text-muted mb-0">Dipinjam</h5>
                                                <span class="h2 font-weight-bold mb-0">105</span>
                                            </div>
                                            <div class="col-auto">
                                                <div class="icon-shape bg-warning text-white">
                                                    <i class="bi bi-clipboard-data"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="card card-stats">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title text-muted mb-0">Pengguna</h5>
                                                <span class="h2 font-weight-bold mb-0">24</span>
                                            </div>
                                            <div class="col-auto">
                                                <div class="icon-shape bg-info text-white">
                                                    <i class="bi bi-people"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Activities -->
                        <div class="content-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="mb-0">Aktivitas Terbaru</h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Pengguna</th>
                                            <th>Barang</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Budi Santoso</td>
                                            <td>Laptop HP Pavilion</td>
                                            <td>18 Mei 2025</td>
                                            <td><span class="item-status bg-success-soft">Dikembalikan</span></td>
                                        </tr>
                                        <tr>
                                            <td>Anita Wijaya</td>
                                            <td>Proyektor Epson</td>
                                            <td>17 Mei 2025</td>
                                            <td><span class="item-status bg-danger-soft">Dipinjam</span></td>
                                        </tr>
                                        <tr>
                                            <td>Dimas Prayogo</td>
                                            <td>Kamera Canon EOS</td>
                                            <td>16 Mei 2025</td>
                                            <td><span class="item-status bg-danger-soft">Dipinjam</span></td>
                                        </tr>
                                        <tr>
                                            <td>Siti Rahayu</td>
                                            <td>iPad Pro 12.9</td>
                                            <td>15 Mei 2025</td>
                                            <td><span class="item-status bg-success-soft">Dikembalikan</span></td>
                                        </tr>
                                        <tr>
                                            <td>Rudi Hermawan</td>
                                            <td>Speaker Bluetooth JBL</td>
                                            <td>15 Mei 2025</td>
                                            <td><span class="item-status bg-danger-soft">Dipinjam</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- List Barang Tab -->
                    <div class="tab-pane fade" id="itemsList">
                        <div class="content-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">List Barang</h4>
                            <button class="btn btn-add" id="btnAddItemQuick">
                                <i class="bi bi-plus-circle me-1"></i> Tambah Barang
                            </button>
                        </div>

                        <div class="content-body">
                            <div class="mb-3">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Cari barang..." id="searchItems">
                                    <button class="btn btn-primary" type="button">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover" id="itemsTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama Barang</th>
                                            <th>Kategori</th>
                                            <th>Stok</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>IT001</td>
                                            <td>Laptop Dell XPS 13</td>
                                            <td>Komputer</td>
                                            <td>5</td>
                                            <td><span class="badge bg-success">Tersedia</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-edit" data-id="IT001">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-delete" data-id="IT001">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>IT002</td>
                                            <td>Proyektor Epson EB-X41</td>
                                            <td>Elektronik</td>
                                            <td>2</td>
                                            <td><span class="badge bg-success">Tersedia</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-edit" data-id="IT002">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-delete" data-id="IT002">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>IT003</td>
                                            <td>iPad Pro 12.9</td>
                                            <td>Tablet</td>
                                            <td>0</td>
                                            <td><span class="badge bg-secondary">Kosong</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-edit" data-id="IT003">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-delete" data-id="IT003">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>IT004</td>
                                            <td>Canon EOS 800D</td>
                                            <td>Kamera</td>
                                            <td>3</td>
                                            <td><span class="badge bg-warning text-dark">Sebagian Dipinjam</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-edit" data-id="IT004">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-delete" data-id="IT004">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>IT005</td>
                                            <td>Headphone Sony WH-1000XM4</td>
                                            <td>Audio</td>
                                            <td>4</td>
                                            <td><span class="badge bg-success">Tersedia</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-edit" data-id="IT005">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-delete" data-id="IT005">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <nav>
                                <ul class="pagination justify-content-center">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <!-- List User Tab -->
                    <div class="tab-pane fade" id="usersList">
                        <div class="content-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">List User</h4>
                            <button class="btn btn-add" id="btnAddUser">
                                <i class="bi bi-person-plus me-1"></i> Tambah User
                            </button>
                        </div>

                        <div class="content-body">
                            <div class="mb-3">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Cari user..." id="searchUsers">
                                    <button class="btn btn-primary" type="button">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover" id="usersTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Departemen</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>U001</td>
                                            <td>Budi Santoso</td>
                                            <td>budi.santoso@example.com</td>
                                            <td>IT</td>
                                            <td>Admin</td>
                                            <td><span class="badge bg-success">Aktif</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-edit" data-id="U001">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-delete" data-id="U001">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>U002</td>
                                            <td>Anita Wijaya</td>
                                            <td>anita.wijaya@example.com</td>
                                            <td>Marketing</td>
                                            <td>User</td>
                                            <td><span class="badge bg-success">Aktif</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-edit" data-id="U002">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-delete" data-id="U002">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>U003</td>
                                            <td>Rudi Hermawan</td>
                                            <td>rudi.hermawan@example.com</td>
                                            <td>Keuangan</td>
                                            <td>User</td>
                                            <td><span class="badge bg-success">Aktif</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-edit" data-id="U003">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-delete" data-id="U003">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>U004</td>
                                            <td>Siti Rahayu</td>
                                            <td>siti.rahayu@example.com</td>
                                            <td>HR</td>
                                            <td>User</td>
                                            <td><span class="badge bg-danger">Nonaktif</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-edit" data-id="U004">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-delete" data-id="U004">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>U005</td>
                                            <td>Dimas Prayogo</td>
                                            <td>dimas.prayogo@example.com</td>
                                            <td>Produksi</td>
                                            <td>User</td>
                                            <td><span class="badge bg-success">Aktif</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-edit" data-id="U005">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-delete" data-id="U005">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <nav>
                                <ul class="pagination justify-content-center">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <!-- Barang Dipinjam Tab -->
                    <div class="tab-pane fade" id="borrowedItems">
                        <div class="content-header">
                            <h4 class="mb-0">Barang Dipinjam</h4>
                        </div>

                        <div class="content-body">
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Cari barang atau peminjam..." id="searchBorrowed">
                                        <button class="btn btn-primary" type="button">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-select" id="filterByUser">
                                        <option selected>Filter berdasarkan User</option>
                                        <option value="all">Semua User</option>
                                        <option value="U001">Budi Santoso</option>
                                        <option value="U002">Anita Wijaya</option>
                                        <option value="U003">Rudi Hermawan</option>
                                        <option value="U004">Siti Rahayu</option>
                                        <option value="U005">Dimas Prayogo</option>
                                    </select>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover" id="borrowedTable">
                                    <thead>
                                        <tr>
                                            <th>ID Peminjaman</th>
                                            <th>Nama Barang</th>
                                            <th>Peminjam</th>
                                            <th>Tanggal Pinjam</th>
                                            <th>Tenggat Kembali</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>BRW001</td>
                                            <td>Laptop Dell XPS 13</td>
                                            <td>Anita Wijaya</td>
                                            <td>15 Mei 2025</td>
                                            <td>22 Mei 2025</td>
                                            <td><span class="badge bg-warning text-dark">Dipinjam</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-success" data-id="BRW003">
                                                    <i class="bi bi-check-circle"></i> Kembalikan
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>BRW004</td>
                                            <td>iPad Pro 12.9</td>
                                            <td>Siti Rahayu</td>
                                            <td>17 Mei 2025</td>
                                            <td>24 Mei 2025</td>
                                            <td><span class="badge bg-danger">Terlambat</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-success" data-id="BRW004">
                                                    <i class="bi bi-check-circle"></i> Kembalikan
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>BRW005</td>
                                            <td>Headphone Sony WH-1000XM4</td>
                                            <td>Budi Santoso</td>
                                            <td>10 Mei 2025</td>
                                            <td>17 Mei 2025</td>
                                            <td><span class="badge bg-danger">Terlambat</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-success" data-id="BRW005">
                                                    <i class="bi bi-check-circle"></i> Kembalikan
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <nav>
                                <ul class="pagination justify-content-center">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <!-- Tambah Barang Tab -->
                    <div class="tab-pane fade" id="addItem">
                        <div class="content-header">
                            <h4 class="mb-0">Tambah Barang</h4>
                        </div>

                        <div class="content-body">
                            <form id="addItemForm">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="itemName" class="form-label">Nama Barang</label>
                                        <input type="text" class="form-control" id="itemName" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="itemCategory" class="form-label">Kategori</label>
                                        <select class="form-select" id="itemCategory" required>
                                            <option value="" selected disabled>Pilih kategori</option>
                                            <option value="Komputer">Komputer</option>
                                            <option value="Elektronik">Elektronik</option>
                                            <option value="Tablet">Tablet</option>
                                            <option value="Kamera">Kamera</option>
                                            <option value="Audio">Audio</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="itemQuantity" class="form-label">Jumlah</label>
                                        <input type="number" class="form-control" id="itemQuantity" min="1" value="1" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="itemCondition" class="form-label">Kondisi</label>
                                        <select class="form-select" id="itemCondition" required>
                                            <option value="" selected disabled>Pilih kondisi</option>
                                            <option value="Baru">Baru</option>
                                            <option value="Sangat Baik">Sangat Baik</option>
                                            <option value="Baik">Baik</option>
                                            <option value="Cukup">Cukup</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="itemDescription" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" id="itemDescription" rows="3"></textarea>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="itemLocation" class="form-label">Lokasi Penyimpanan</label>
                                        <input type="text" class="form-control" id="itemLocation">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="itemImage" class="form-label">Foto Barang</label>
                                        <input class="form-control" type="file" id="itemImage">
                                    </div>
                                </div>
                                
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="availableForBorrowing" checked>
                                    <label class="form-check-label" for="availableForBorrowing">Tersedia untuk dipinjam</label>
                                </div>
                                
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="reset" class="btn btn-secondary me-md-2">Reset</button>
                                    <button type="submit" class="btn btn-primary" id="submitAddItem">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Profile Tab -->
                    <div class="tab-pane fade" id="profile">
                        <div class="content-header">
                            <h4 class="mb-0">Profile</h4>
                        </div>

                        <div class="content-body">
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <div class="mb-3">
                                                <img src="https://via.placeholder.com/150" class="rounded-circle img-thumbnail" alt="Profile Picture">
                                            </div>
                                            <h5 class="card-title">Budi Santoso</h5>
                                            <p class="card-text text-muted">Administrator</p>
                                            <p class="card-text">IT Department</p>
                                            <button class="btn btn-primary btn-sm mt-2">
                                                <i class="bi bi-camera me-1"></i> Update Foto
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title mb-4">Informasi Akun</h5>
                                            <form id="profileForm">
                                                <div class="mb-3 row">
                                                    <label for="profileName" class="col-sm-3 col-form-label">Nama Lengkap</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="profileName" value="Budi Santoso">
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="profileEmail" class="col-sm-3 col-form-label">Email</label> 
                                                    <div class="col-sm-9">
                                                        <input type="email" class="form-control" id="profileEmail" value="budi.santoso@example.com">
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="profileDept" class="col-sm-3 col-form-label">Departemen</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="profileDept" value="IT" readonly>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="profilePhone" class="col-sm-3 col-form-label">No. Telepon</label>
                                                    <div class="col-sm-9">
                                                        <input type="tel" class="form-control" id="profilePhone" value="081234567890">
                                                    </div>
                                                </div>
                                                
                                                <hr>
                                                <h5 class="mb-4">Update Password</h5>
                                                
                                                <div class="mb-3 row">
                                                    <label for="currentPassword" class="col-sm-3 col-form-label">Password Saat Ini</label>
                                                    <div class="col-sm-9">
                                                        <input type="password" class="form-control" id="currentPassword">
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="newPassword" class="col-sm-3 col-form-label">Password Baru</label>
                                                    <div class="col-sm-9">
                                                        <input type="password" class="form-control" id="newPassword">
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="confirmPassword" class="col-sm-3 col-form-label">Konfirmasi Password</label>
                                                    <div class="col-sm-9">
                                                        <input type="password" class="form-control" id="confirmPassword">
                                                    </div>
                                                </div>
                                                
                                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                    <button type="submit" class="btn btn-primary" id="saveProfileBtn">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editItemModal" tabindex="-1" aria-labelledby="editItemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editItemModalLabel">Edit Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editItemForm">
                        <input type="hidden" id="editItemId">
                        <div class="mb-3">
                            <label for="editItemName" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="editItemName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editItemCategory" class="form-label">Kategori</label>
                            <select class="form-select" id="editItemCategory" required>
                                <option value="Komputer">Komputer</option>
                                <option value="Elektronik">Elektronik</option>
                                <option value="Tablet">Tablet</option>
                                <option value="Kamera">Kamera</option>
                                <option value="Audio">Audio</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editItemQuantity" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="editItemQuantity" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="editItemDescription" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="editItemDescription" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveEditItemBtn">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="mb-3">
                            <label for="addUserName" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="addUserName" required>
                        </div>
                        <div class="mb-3">
                            <label for="addUserEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="addUserEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="addUserDept" class="form-label">Departemen</label>
                            <select class="form-select" id="addUserDept" required>
                                <option value="" selected disabled>Pilih departemen</option>
                                <option value="IT">IT</option>
                                <option value="Marketing">Marketing</option>
                                <option value="Keuangan">Keuangan</option>
                                <option value="HR">HR</option>
                                <option value="Produksi">Produksi</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="addUserRole" class="form-label">Role</label>
                            <select class="form-select" id="addUserRole" required>
                                <option value="" selected disabled>Pilih role</option>
                                <option value="Admin">Admin</option>
                                <option value="User">User</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="addUserPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="addUserPassword" required>
                        </div>
                        <div class="mb-3">
                            <label for="addUserConfirmPassword" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="addUserConfirmPassword" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveAddUserBtn">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationTitle">Konfirmasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="confirmationBody">
                    Apakah Anda yakin ingin melakukan tindakan ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmActionBtn">Ya, Lanjutkan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- SweetAlert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script>
        $(document).ready(function() {
            // Mobile sidebar toggle
            $('#sidebarToggle').click(function() {
                $('#sidebar').toggleClass('show');
            });

            // Close sidebar when clicking outside on mobile
            $(document).click(function(event) {
                if (!$(event.target).closest('#sidebar').length && !$(event.target).closest('#sidebarToggle').length && $('#sidebar').hasClass('show')) {
                    $('#sidebar').removeClass('show');
                }
            });

            // Quick add item button
            $('#btnAddItemQuick').click(function() {
                $('a[href="#addItem"]').tab('show');
            });

            // Add user button
            $('#btnAddUser').click(function() {
                $('#addUserModal').modal('show');
            });

            // Edit item buttons
            $('.btn-edit').click(function() {
                const itemId = $(this).data('id');
                
                // In a real app, you would fetch the item data from server
                // For demo, we'll just populate with placeholder data
                if (itemId === 'IT001') {
                    $('#editItemId').val('IT001');
                    $('#editItemName').val('Laptop Dell XPS 13');
                    $('#editItemCategory').val('Komputer');
                    $('#editItemQuantity').val('5');
                    $('#editItemDescription').val('Laptop Dell XPS 13 dengan Intel Core i7, 16GB RAM, 512GB SSD');
                }
                
                $('#editItemModal').modal('show');
            });

            // Delete item buttons
            $('.btn-delete').click(function() {
                const itemId = $(this).data('id');
                
                $('#confirmationTitle').text('Hapus Barang');
                $('#confirmationBody').text(`Apakah Anda yakin ingin menghapus barang dengan ID ${itemId}?`);
                
                $('#confirmActionBtn').off('click').on('click', function() {
                    // In a real app, you would send a request to delete the item
                    // For demo, we'll just show a success message
                    $('#confirmationModal').modal('hide');
                    
                    swal({
                        title: "Berhasil!",
                        text: `Barang dengan ID ${itemId} telah dihapus.`,
                        icon: "success",
                        button: "OK",
                    });
                });
                
                $('#confirmationModal').modal('show');
            });

            // Return item buttons
            $('.btn-success').click(function() {
                const borrowId = $(this).data('id');
                
                swal({
                    title: "Konfirmasi Pengembalian",
                    text: `Apakah barang dengan ID peminjaman ${borrowId} sudah dikembalikan?`,
                    icon: "warning",
                    buttons: ["Batal", "Ya, Sudah Dikembalikan"],
                    dangerMode: true,
                })
                .then((willReturn) => {
                    if (willReturn) {
                        // In a real app, you would send a request to update the status
                        swal("Berhasil!", "Barang telah berhasil dikembalikan.", "success");
                    }
                });
            });

            // Form submissions
            $('#addItemForm').submit(function(e) {
                e.preventDefault();
                
                swal({
                    title: "Berhasil!",
                    text: "Barang baru telah berhasil ditambahkan.",
                    icon: "success",
                    button: "OK",
                });
            });

            $('#saveAddUserBtn').click(function() {
                if($('#addUserPassword').val() !== $('#addUserConfirmPassword').val()) {
                    swal({
                        title: "Error!",
                        text: "Password dan konfirmasi password tidak cocok!",
                        icon: "error",
                        button: "OK",
                    });
                    return;
                }
                
                $('#addUserModal').modal('hide');
                
                swal({
                    title: "Berhasil!",
                    text: "User baru telah berhasil ditambahkan.",
                    icon: "success",
                    button: "OK",
                });
            });

            $('#saveEditItemBtn').click(function() {
                $('#editItemModal').modal('hide');
                
                swal({
                    title: "Berhasil!",
                    text: "Data barang telah berhasil diperbarui.",
                    icon: "success",
                    button: "OK",
                });
            });

            $('#saveProfileBtn').click(function(e) {
                e.preventDefault();
                
                if($('#newPassword').val() !== $('#confirmPassword').val() && $('#newPassword').val() !== '') {
                    swal({
                        title: "Error!",
                        text: "Password baru dan konfirmasi password tidak cocok!",
                        icon: "error",
                        button: "OK",
                    });
                    return;
                }
                
                swal({
                    title: "Berhasil!",
                    text: "Profil berhasil diperbarui.",
                    icon: "success",
                    button: "OK",
                });
            });

            $('#logoutBtn').click(function(e) {
                e.preventDefault();
                
                swal({
                    title: "Konfirmasi Logout",
                    text: "Apakah Anda yakin ingin keluar?",
                    icon: "warning",
                    buttons: ["Batal", "Ya, Logout"],
                    dangerMode: true,
                })
                .then((willLogout) => {
                    if (willLogout) {
                        window.location.href = "<?= BASE_URL ?>auth/logout";
                    }
                });
            });
        });
    </script>
</body>
</html>