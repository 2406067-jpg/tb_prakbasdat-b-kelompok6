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
            border-bottom: 2px solid #ff3e3e !important;
            box-shadow: 0 0 15px rgba(255, 62, 62, 0.2) !important;
        }
        .navbar-brand { 
            font-weight: 700; 
            color: #ffffff !important;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 0 0 8px rgba(255, 62, 62, 0.6);
            text-decoration: none;
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
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <?php 
        // Mengambil path url saat ini
        $current_script = $_SERVER['PHP_SELF'];
        
        // Cek secara spesifik apakah user sedang membuka file di dalam folder dashboard
        $is_in_dashboard = (strpos($current_script, '/dashboard/') !== false);

        if ($is_in_dashboard) {
            // Jika user di dalam folder dashboard
            $link_dashboard = 'index.php';
            $link_personnel = '../index.php';
        } else {
            // Jika user di luar folder dashboard (folder pegawai)
            $link_dashboard = 'dashboard/index.php';
            $link_personnel = 'index.php';
        }
        ?>

        <a class="navbar-brand" href="<?= $link_dashboard ?>">
            💀 PT HERETIC 666
        </a>
        
        <button class="navbar-toggler border-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item ms-lg-2">
                    <a class="nav-link <?= $is_in_dashboard ? 'active' : '' ?>" href="<?= $link_dashboard ?>">
                        🎛️ Dashboard
                    </a>
                </li>
                <li class="nav-item ms-lg-2">
                    <a class="nav-link <?= !$is_in_dashboard ? 'active' : '' ?>" href="<?= $link_personnel ?>">
                        👁️‍🗨️ Personnel
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>