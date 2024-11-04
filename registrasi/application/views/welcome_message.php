<!DOCTYPE html>
<html lang="en" dir="/">
    <?php $this->load->view('layout/head') ?>
    
    <body class="text-left">
        <div class="app-admin-wrap layout-sidebar-compact sidebar-dark-purple sidenav-open clearfix">
            <?php $this->load->view('layout/navigation') ?>
            <!--=============== Left side End ================-->
            <div class="main-content-wrap d-flex flex-column">
                <?php $this->load->view('layout/header') ?>
                
                <div class="main-content">
                    <div class="breadcrumb">
                        <ul>
                            <li><a href="#">Dashboard</a></li>
                        </ul>
                    </div>
                    <div class="separator-breadcrumb border-top"></div>

                    <div class="row">

                        <div class="col-md-6">
                        <!-- CARD ICON-->
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="card card-icon mb-4">
                                        <div class="card-body text-center"><i class="i-Bicycle"></i>
                                            <p class="text-muted mt-2 mb-2">Pengajuan Kendaraan</p>
                                            <p class="text-primary text-24 line-height-1 m-0 kendaraan"><?= $kendaraan['pengajuan'] ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="card card-icon mb-4">
                                        <div class="card-body text-center"><i class="i-Blackboard"></i>
                                            <p class="text-muted mt-2 mb-2">Pengajuan Ruangan</p>
                                            <p class="text-primary text-24 line-height-1 m-0 ruangan"><?= $ruangan['pengajuan'] ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="card card-icon mb-4">
                                        <div class="card-body text-center"><i class="i-Wireless"></i>
                                            <p class="text-muted mt-2 mb-2">Pengajuan Perangkat TI</p>
                                            <p class="text-primary text-24 line-height-1 m-0 perangkat"><?= $perangkat['pengajuan'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title m-0">Peminjaman Perangkat TI</div>
                                    <p class="text-small text-muted">Ringkasan Peminjaman Perangkat</p>
                                    <div class="row">
                                        
                                        <div class="col-lg-6 col-md-12 mb-4">
                                            <div class="p-4 border border-light rounded d-flex align-items-center"><i class="i-Big-Data text-32 mr-3"></i>
                                                <div>
                                                    <h4 class="text-18 mb-1">Pending</h4><span>Total: <?= $perangkat['pending'] ?> </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-4">
                                            <div class="p-4 border border-light rounded d-flex align-items-center"><i class="i-Data-Cloud text-32 mr-3"></i>
                                                <div>
                                                    <h4 class="text-18 mb-1">Tolak</h4><span>Total: <?= $perangkat['ditolak'] ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-4">
                                            <div class="p-4 border border-light rounded d-flex align-items-center"><i class="i-Data-Backup text-32 mr-3"></i>
                                                <div>
                                                    <h4 class="text-18 mb-1">Setujui</h4><span>Total: <?= $perangkat['disetujui'] ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-4">
                                            <div class="p-4 border border-light rounded d-flex align-items-center"><i class="i-Data-Download text-32 mr-3"></i>
                                                <div>
                                                    <h4 class="text-18 mb-1">Selesai</h4><span>Total: <?= $perangkat['selesai'] ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title m-0">Peminjaman Kendaraan</div>
                                    <p class="text-small text-muted">Ringkasan Peminjaman Kendaraan</p>
                                    <div class="row">
                                        
                                        <div class="col-lg-6 col-md-12 mb-4">
                                            <div class="p-4 border border-light rounded d-flex align-items-center"><i class="i-Big-Data text-32 mr-3"></i>
                                                <div>
                                                    <h4 class="text-18 mb-1">Pending</h4><span>Total: <?= $kendaraan['pending'] ?> </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-4">
                                            <div class="p-4 border border-light rounded d-flex align-items-center"><i class="i-Data-Cloud text-32 mr-3"></i>
                                                <div>
                                                    <h4 class="text-18 mb-1">Tolak</h4><span>Total: <?= $kendaraan['ditolak'] ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-4">
                                            <div class="p-4 border border-light rounded d-flex align-items-center"><i class="i-Data-Backup text-32 mr-3"></i>
                                                <div>
                                                    <h4 class="text-18 mb-1">Setujui</h4><span>Total: <?= $kendaraan['disetujui'] ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-4">
                                            <div class="p-4 border border-light rounded d-flex align-items-center"><i class="i-Data-Download text-32 mr-3"></i>
                                                <div>
                                                    <h4 class="text-18 mb-1">Selesai</h4><span>Total: <?= $kendaraan['selesai'] ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title m-0">Peminjaman Ruangan</div>
                                    <p class="text-small text-muted">Ringkasan Peminjaman Ruangan</p>
                                    <div class="row">
                                        
                                        <div class="col-lg-6 col-md-12 mb-4">
                                            <div class="p-4 border border-light rounded d-flex align-items-center"><i class="i-Big-Data text-32 mr-3"></i>
                                                <div>
                                                    <h4 class="text-18 mb-1">Pending</h4><span>Total: <?= $ruangan['pending'] ?> </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-4">
                                            <div class="p-4 border border-light rounded d-flex align-items-center"><i class="i-Data-Cloud text-32 mr-3"></i>
                                                <div>
                                                    <h4 class="text-18 mb-1">Tolak</h4><span>Total: <?= $ruangan['ditolak'] ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-4">
                                            <div class="p-4 border border-light rounded d-flex align-items-center"><i class="i-Data-Backup text-32 mr-3"></i>
                                                <div>
                                                    <h4 class="text-18 mb-1">Setujui</h4><span>Total: <?= $ruangan['disetujui'] ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-4">
                                            <div class="p-4 border border-light rounded d-flex align-items-center"><i class="i-Data-Download text-32 mr-3"></i>
                                                <div>
                                                    <h4 class="text-18 mb-1">Selesai</h4><span>Total: <?= $ruangan['selesai'] ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Footer Start -->
                    <div class="flex-grow-1"></div>
                    <?php $this->load->view('layout/footer') ?>
                    <!-- fotter end -->
                </div>
            </div>
        </div>
    </body>

    <?php $this->load->view('layout/custom') ?> 

    <script type="text/javascript">
        $(document).ready(function() {   
            fetchindex();
        });
        function fetchindex() {
            var url = "<?= site_url().'welcome/' ?>";
            $.ajax({
               type: 'post',
               url: url+ 'fetchindex',
               success: function(res) {
                if(res) {
                    console.log(res);
                    $('.kendaraan').text(res['kendaraan']);
                    $('.perangkat').text(res['perangkat']);
                    $('.ruangan').text(res['ruangan']);
                }
               },
               complete: function (res) {
                  setTimeout(function(){
                    fetchindex();
                  }, 2000);
               },
               error: function (res) {
                  swal("Gagal Fetching", "Internal Server Error", "error");
               },
            });
        }
    </script>

</html>