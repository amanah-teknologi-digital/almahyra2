
<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul class="navigation-left">
            <li class="nav-item <?= $parent=='absensi'?'active':'' ?>" data-item="absensi">
                <a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Teacher"></i>
                    <span class="nav-text">Absensi</span>
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

        <div class="submenu-area" data-parent="absensi">
            <header>
                <h6>Absensi</h6>
            </header>
            <ul class="childNav">
                <li class="nav-item">
                    <a href="<?= base_url().'absensi-anak'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Absensi Anak</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url().'laporan-absensianak'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Laporan Absensi Anak</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>