
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
            <li class="nav-item <?= $parent=='referensi'?'active':'' ?>" data-item="uikits">
                <a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Library"></i>
                    <span class="nav-text">Referensi</span>
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
            <li class="nav-item <?= $parent=='observasi'?'active':'' ?>" data-item="observasi">
                <a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Arrow-Mix"></i>
                    <span class="nav-text">Observasi</span>
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
            <li class="nav-item <?= $parent=='pembayaran'?'active':'' ?>" data-item="pembayaran">
                <a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Dollar-Sign"></i>
                    <span class="nav-text">Pembayaran</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item <?= $parent=='laporan'?'active':'' ?>" data-item="laporan">
                <a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Duplicate-Window"></i>
                    <span class="nav-text">Laporan</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item <?= $parent=='rencana'?'active':'' ?>" data-item="rencana">
                <a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Split-Four-Square-Window"></i>
                    <span class="nav-text">Rencana</span>
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
                    <a href="#">
                        <i class="nav-icon i-Bar-Chart-2"></i>
                        <span class="item-name">Dashboard</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="submenu-area" data-parent="uikits">
            <header>
                <h6>Referensi</h6>
            </header>
            <ul class="childNav">
                <li class="nav-item">
                    <a href="<?= base_url().'role'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Role</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url().'pengguna'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Pengguna</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url().'imunisasi'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Imunisasi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url().'penyakit'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Penyakit</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url().'kelas'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Zona</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url().'usia'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Kategori Usia</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url().'aspek'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Aspek Perkembangan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url().'kembang-anak'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Perkembangan Anak</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url().'uraian'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Uraian Tagihan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url().'uraian-tagihan'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Tagihan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url().'items'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Items</span>
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
                    <a href="<?= base_url().'register-anak'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Anak</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url().'register-orangtua'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Orang Tua / Wali</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url().'register-rekam-medik'; ?>"> 
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Rekam Medik Anak</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url().'register-berkas'; ?>"> 
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Upload Berkas</span>
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="submenu-area" data-parent="observasi">
            <header>
                <h6>Observasi</h6>
            </header>
            <ul class="childNav">
                <li class="nav-item">
                    <a href="<?= base_url().'observasi-anak'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Observasi Informasi Tentang Anak</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url().'observasi-pertumbuhan'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Observasi Pertumbuhan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url().'observasi-perkembangan'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Observasi Perkembangan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url().'observasi-hasil'; ?>"> 
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Hasil Observasi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url().'penentuan-zona'; ?>"> 
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Penentuan Zona</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="submenu-area" data-parent="pembayaran">
            <header>
                <h6>Pembayaran</h6>
            </header>
            <ul class="childNav">
                <li class="nav-item">
                    <a href="<?= base_url().'pembayaran-tagihan'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Tagihan</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="submenu-area" data-parent="absensi">
            <header>
                <h6>Item</h6>
            </header>
            <ul class="childNav">
                <li class="nav-item">
                    <a href="<?= base_url().'absensi-anak'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Kehadiran</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url().'absensi-items'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Absensi Barang</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url().'aktivitas-anak'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Aktivitas Anak</span>
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
                    <a href="<?= base_url().'laporan-tumbuh-kembang'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Tumbuh Kembang</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url().'laporan-pembayaran'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Pembayaran</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url().'laporan-harian'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Laporan Harian</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="submenu-area" data-parent="rencana">
            <header>
                <h6>Rencana Belajar</h6>
            </header>
            <ul class="childNav">
                <li class="nav-item">
                    <a href="<?= base_url().'rencana-belajar'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Tematik Tahunan</span>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a href="<?= base_url().'laporan-rencana-belajar'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Laporan Tematik Tahunan</span>
                    </a>
                </li> -->
                <li class="nav-item">
                    <a href="<?= base_url().'rencana-pelaksanaan'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Pelaksanaan Belajar</span>
                    </a>
                </li>               
            </ul>
        </div>
    </div>
</div>