<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'HERETIC 666 — Core' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body { 
            background: #060608 !important; 
            color: #a1a1aa !important;
            font-family: 'Courier New', Courier, monospace !important;
        }
        .navbar {
            background-color: #0b0b0f !important;
            border-bottom: 2px solid #ff3e3e !important; /* Garis merah neon di bawah navbar */
            box-shadow: 0 0 15px rgba(255, 62, 62, 0.2) !important;
        }
        .navbar-brand { 
            font-weight: 700; 
            color: #ffffff !important;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 0 0 8px rgba(255, 62, 62, 0.6);
        }
        .nav-link {
            color: #a1a1aa !important;
            letter-spacing: 1px;
        }
        .nav-link:hover {
            color: #ff3e3e !important;
            text-shadow: 0 0 5px #ff3e3e;
        }
        .nav-link.active { 
            background: rgba(255, 62, 62, 0.15) !important; 
            color: #ff3e3e !important;
            border: 1px solid #ff3e3e;
            border-radius: 2px; 
            font-weight: bold;
        }
        /* Override Alert Bawaan Biar Masuk Tema Gelap */
        .alert-success {
            background-color: rgba(25, 135, 84, 0.1) !important;
            border: 1px solid #198754 !important;
            color: #198754 !important;
        }
        .alert-info {
            background-color: rgba(13, 110, 253, 0.1) !important;
            border: 1px solid #0d6efd !important;
            color: #0d6efd !important;
        }
        .alert-warning {
            background-color: rgba(255, 62, 62, 0.1) !important;
            border: 1px solid #ff3e3e !important;
            color: #ff3e3e !important;
        }
        .btn-close {
            filter: invert(1); /* Tombol silang alert jadi putih/terang */
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <?php 
        $hitungFolder = substr_count($_SERVER['PHP_SELF'], '/') - 2;
        $base = str_repeat('../', max(0, $hitungFolder));
        $current = $_SERVER['PHP_SELF'];

        $menus = [
            ['url' => 'dashboard/index.php',  'folder' => 'dashboard', 'label' => '🎛️ Dashboard'],
            ['url' => 'pegawai/index.php',    'folder' => 'pegawai',   'label' => '👁️‍🗨️ Personnel'],
        ];
        ?>

        <a class="navbar-brand" href="<?= $base ?>dashboard/index.php">
            💀 PT HERETIC 666
        </a>
        
        <button class="navbar-toggler border-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto">
                <?php foreach ($menus as $m): 
                    $active = strpos($current, '/' . $m['folder'] . '/') !== false; 
                ?>
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        <a class="nav-link <?= $active ? 'active' : '' ?>" href="<?= $base . $m['url'] ?>">
                            <?= $m['label'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>

<?php if (isset($_GET['pesan'])): ?>
    <?php 
    $pesanMap = [
        'tambah' => ['teks' => 'DATABASE_UPDATE: Personnel successfully registered.', 'tipe' => 'success'],
        'edit'   => ['teks' => 'DATABASE_UPDATE: Security credentials modified.', 'tipe' => 'info'],
        'hapus'  => ['teks' => 'DATABASE_UPDATE: Target terminated from memory.', 'tipe' => 'warning'],
    ];
    $p = $pesanMap[$_GET['pesan']] ?? null;
    ?>
    <?php if ($p): ?>
        <div class="container mt-3">
            <div class="alert alert-<?= $p['tipe'] ?> alert-dismissible fade show py-2" role="alert">
                <?= $p['tipe'] == 'success' ? '⚡' : ($p['tipe'] == 'warning' ? '❌' : '💾') ?> 
                <strong><?= $p['teks'] ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>