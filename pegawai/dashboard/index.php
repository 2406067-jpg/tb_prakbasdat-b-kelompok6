<?php
require '../koneksi.php';
/** @var mysqli $koneksi */

// Nama PT diubah sesuai request lu bro!
$pageTitle = 'HERETIC 666 — Core Mainframe';
require 'navbar.php';

$total_pegawai = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as t FROM pegawai"))['t'];
$total_aktif   = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as t FROM pegawai WHERE status='aktif'"))['t'];
$total_dept    = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as t FROM departemen"))['t'];

$total_gaji    = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT SUM(gaji) as t FROM pegawai WHERE status='aktif'"))['t'];

$pegawai_baru  = mysqli_query($koneksi,
    "SELECT * FROM v_pegawai ORDER BY id DESC LIMIT 5");

$per_dept      = mysqli_query($koneksi,
    "SELECT * FROM v_statistik_dept ORDER BY total_pegawai DESC");
?>

<style>
    body {
        background-color: #060608 !important;
        color: #a1a1aa !important;
        font-family: 'Courier New', Courier, monospace !important;
    }
    .cyber-title {
        color: #ffffff;
        text-transform: uppercase;
        letter-spacing: 3px;
        text-shadow: 0 0 10px rgba(255, 62, 62, 0.6);
    }
    .stat-card {
        background: #0f0f13 !important;
        border: 1px solid #ff3e3e !important; /* Border merah neon */
        box-shadow: 0 0 8px rgba(255, 62, 62, 0.1);
        border-radius: 2px;
        padding: 20px;
        color: #ffffff !important;
    }
    .card {
        background-color: #0f0f13 !important;
        border: 1px solid #2d2d39 !important;
        color: #a1a1aa !important;
        border-radius: 2px;
    }
    .card-header {
        background-color: #16161f !important;
        border-bottom: 1px solid #2d2d39 !important;
        color: #ffffff !important;
    }
    .table {
        color: #a1a1aa !important;
    }
    .table-hover tbody tr:hover {
        background-color: #16161f !important;
        color: #ffffff !important;
    }
    .table-light {
        background-color: #16161f !important;
        color: #ffffff !important;
        border-bottom: 2px solid #2d2d39;
    }
    .progress {
        background-color: #16161f !important;
        border: 1px solid #2d2d39;
        border-radius: 0px;
    }
    .progress-bar {
        background-color: #ff3e3e !important; /* Bar progress jadi merah heretic */
        box-shadow: 0 0 8px #ff3e3e;
    }
    .btn-cyber {
        background: transparent;
        color: #ff3e3e;
        border: 1px solid #ff3e3e;
        border-radius: 0px;
        font-size: 0.8rem;
    }
    .btn-cyber:hover {
        background: #ff3e3e;
        color: #000000;
        font-weight: bold;
        box-shadow: 0 0 10px #ff3e3e;
    }
    .text-muted {
        color: #52525b !important;
    }
    .badge-aktif, .badge-Aktif {
        background-color: rgba(25, 135, 84, 0.2) !important;
        color: #198754 !important;
        border: 1px solid #198754;
    }
    .badge-tidak-aktif, .badge-Tidak-Aktif {
        background-color: rgba(220, 53, 69, 0.2) !important;
        color: #dc3545 !important;
        border: 1px solid #dc3545;
    }
</style>

<div class="container mt-4">
    
    <div class="mb-4 border-bottom border-secondary pb-3">
        <h4 class="fw-bold mb-1 cyber-title">💀 PT HERETIC 666</h4>
        <p class="text-muted small mb-0">> Mainframe Status: ONLINE // Core System Connected...</p>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div style="font-size:2rem;">👥</div>
                <div style="font-size:1.8rem; font-weight:700; color:#ffffff;"><?= $total_pegawai ?></div>
                <div class="small text-muted">Total Personnel</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div style="font-size:2rem;">👁️‍🗨️</div>
                <div style="font-size:1.8rem; font-weight:700; color:#ff3e3e;"><?= $total_aktif ?></div>
                <div class="small text-muted">Active Operatives</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div style="font-size:2rem;">⛓️</div>
                <div style="font-size:1.8rem; font-weight:700; color:#ffffff;"><?= $total_dept ?></div>
                <div class="small text-muted">Sectors Managed</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div style="font-size:2rem;">💳</div>
                <div style="font-size:1.1rem; font-weight:700; color:#ff3e3e;"><?= rupiah($total_gaji ?? 0) ?></div>
                <div class="small text-muted">Monthly Burn-Rate</div>
            </div>
        </div>
    </div>

    <div class="row g-4">

        <div class="col-md-5">
            <div class="card h-100">
                <div class="card-header fw-semibold">
                    🎛️ Sector Allocation Data
                    <small class="text-muted d-block fw-normal" style="font-size:0.75rem;">
                        SELECT nama, COUNT(*) FROM v_statistik_dept GROUP BY nama
                    </small>
                </div>
                <div class="card-body">
                    <?php
                    $rows = [];
                    $maxTotal = 1;
                    while ($r = mysqli_fetch_assoc($per_dept)) {
                        $rows[] = $r;
                        if ($r['total_pegawai'] > $maxTotal) $maxTotal = $r['total_pegawai'];
                    }
                    foreach ($rows as $r):
                        $pct = round(($r['total_pegawai'] / $maxTotal) * 100);
                    ?>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="small fw-semibold text-white"><?= htmlspecialchars($r['nama']) ?></span>
                            <span class="small text-muted"><?= $r['total_pegawai'] ?> units</span>
                        </div>
                        <div class="progress" style="height:6px;">
                            <div class="progress-bar" style="width:<?= $pct ?>%"></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <span class="fw-semibold">📟 Recent Identity Logs</span>
                        <small class="text-muted d-block fw-normal" style="font-size:0.75rem;">
                            SELECT * FROM v_pegawai ORDER BY id DESC LIMIT 5
                        </small>
                    </div>
                    <a href="../pegawai/index.php" class="btn btn-cyber btn-sm">Access Database</a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr style="background: #16161f;">
                                <th class="border-0 text-white">Identity</th>
                                <th class="border-0 text-white">Sector</th>
                                <th class="border-0 text-white">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($r = mysqli_fetch_assoc($pegawai_baru)): ?>
                            <tr class="border-secondary" style="background: transparent;">
                                <td>
                                    <div class="fw-semibold small text-white"><?= htmlspecialchars($r['nama']) ?></div>
                                    <div class="text-muted" style="font-size:0.75rem;"><?= $r['jabatan'] ?></div>
                                </td>
                                <td><span class="badge bg-dark text-danger border border-danger"><?= $r['kode_dept'] ?></span></td>
                                <td>
                                    <span class="badge badge-<?= $r['status'] ?> px-2 py-1">
                                        <?= strtoupper($r['status']) ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require 'footer.php'; ?>