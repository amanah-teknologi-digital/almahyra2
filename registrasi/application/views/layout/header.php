<div class="main-header">
    <div class="logo">
        <img src="<?= base_url().'dist-assets/'?>images/logo.png" alt="">
    </div>
    <div class="menu-toggle">
        <div></div>
        <div></div>
        <div></div>
    </div>
    <div style="margin: auto"></div>
    <div class="header-part-right">
        <!-- User avatar dropdown -->
        <div class="dropdown">
            <div class="user col align-self-end">
                <div class="profileImage-small" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?= strtoupper(substr($this->session->userdata('auth')->name, 0,2)) ?>
                </div>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <div class="dropdown-header">
                        <i class="i-Lock-User mr-1"></i> <?= ucwords($this->session->userdata('auth')->name) ?>
                    </div>
                    <a class="dropdown-item" href="#">Account settings</a>
                    <a class="dropdown-item" href="<?= base_url().'logout'; ?>">Sign out</a>
                </div>
            </div>
        </div>
    </div>
</div>