
<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul class="navigation-left">
            <li class="nav-item <?= $parent=='dashboard'?'active':'' ?>" data-item="dashboard">
                <a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Bar-Chart"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item <?= $parent=='register'?'active':'' ?>" data-item="registrasi">
                <a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Arrow-Loop"></i>
                    <span class="nav-text">Registrasi</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item <?= $parent=='absensi'?'active':'' ?>" data-item="absensi">
                <a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Teacher"></i>
                    <span class="nav-text">Absensi</span>
                </a>
                <div class="triangle"></div>
            </li>
            <!-- <li class="nav-item <?= $parent=='pengembalian'?'active':'' ?>" data-item="apps">
                <a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Arrow-Mix"></i>
                    <span class="nav-text">Observasi</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item <?= $parent=='pengembalian'?'active':'' ?>" data-item="apps">
                <a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Arrow-Mix"></i>
                    <span class="nav-text">Absensi</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item <?= $parent=='pengembalian'?'active':'' ?>" data-item="apps">
                <a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Arrow-Mix"></i>
                    <span class="nav-text">Tumbuh Kembang</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item <?= $parent=='pengembalian'?'active':'' ?>" data-item="apps">
                <a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Arrow-Mix"></i>
                    <span class="nav-text">Pembayaran</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item <?= $parent=='pengembalian'?'active':'' ?>" data-item="apps">
                <a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Arrow-Mix"></i>
                    <span class="nav-text">Laporan</span>
                </a>
                <div class="triangle"></div>
            </li> -->
             <li class="nav-item <?= $parent=='laporan'?'active':'' ?>" data-item="laporan">
                <a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Duplicate-Window"></i>
                    <span class="nav-text">Laporan</span>
                </a>
                <div class="triangle"></div>
            </li>
        </ul>
    </div>
    <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <header class="p-4">
            <div class="logos mb-2 text-center">
                <img src="<?= base_url().'dist-assets/'?>images/logo_namira.png" alt="">
            </div>
        </header>
        <!-- Submenu Dashboards -->
        <div class="submenu-area" data-parent="dashboard">
            <header>
                <h6>Dashboards</h6>
            </header>
            <ul class="childNav">
                <li class="nav-item">
                    <a href="<?= base_url().'dashboard'; ?>">
                        <i class="nav-icon i-Bar-Chart-2"></i>
                        <span class="item-name">Dashboard</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="submenu-area" data-parent="registrasi">
            <header>
                <h6>Registrasi</h6>
            </header>
            <ul class="childNav">
                <li class="nav-item">
                    <a href="<?= base_url().'register-pengasuh'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Educator / Pengasuh</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url().'register-berkas-pengasuh'; ?>"> 
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Upload Berkas</span>
                    </a>
                </li>
            </ul>
        </div>
        

        <div class="submenu-area" data-parent="absensi">
            <header>
                <h6>Absensi</h6>
            </header>
            <ul class="childNav">
                <li class="nav-item">
                    <a href="<?= base_url().'absensi-pengasuh'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Kehadiran</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="submenu-area" data-parent="laporan">
            <header>
                <h6>Laporan</h6>
            </header>
            <ul class="childNav">
                <li class="nav-item">
                    <a href="<?= base_url().'laporan-kegiatan'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Kegiatan</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>