
<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul class="navigation-left">
            <li class="nav-item <?= $parent=='mengaji'?'active':'' ?>" data-item="mengaji">
                <a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Doctor"></i>
                    <span class="nav-text">Mengaji Qiro'ati</span>
                </a>
                <div class="triangle"></div>
            </li>
        </ul>
    </div>
    <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <header class="p-4">
            <div class="logos mb-2 text-center">
                <img src="<?= base_url().'dist-assets/'?>images/logo_almahyra_panjang.png" alt="" style="width: 170px; height: 65px">
            </div>
        </header>
        <!-- Submenu Dashboards -->

        <div class="submenu-area" data-parent="mengaji">
            <header>
                <h6>Qiro'ati</h6>
            </header>
            <ul class="childNav">
                <li class="nav-item">
                    <a href="<?= base_url().'dashboard'; ?>">
                        <i class="nav-icon i-Bar-Chart-2"></i>
                        <span class="item-name">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url().'catatan-mengaji'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Catatan Mengaji</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url().'laporan-mengaji'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Laporan Mengaji</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url().'laporan-ustadzah'; ?>">
                        <i class="nav-icon i-Duplicate-Window"></i>
                        <span class="item-name">Laporan Ustadzah</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>