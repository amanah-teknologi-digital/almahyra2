<!DOCTYPE html>
<html lang="en" dir="/">

    <?php $this->load->view('layout/head') ?>

    <body class="text-left">
        <div class="app-admin-wrap layout-sidebar-compact sidebar-dark-purple sidenav-open clearfix">
            <?php $this->load->view('layout/navigation') ?>     

            <!-- =============== Horizontal bar End ================-->
            <div class="main-content-wrap d-flex flex-column">
                <?php $this->load->view('layout/header') ?>
                <!-- ============ Body content start ============= -->
                <div class="main-content">
                    <div class="breadcrumb">
                        <ul>
                            <li><a href="#">Dashboard</a></li>
                            <li>Educator/Pengasuh</li>
                        </ul>
                    </div>
                    <?php if (!empty($detail_pengasuh)): ?>
                        <?php foreach ($detail_pengasuh as $key => $da): ?>
                            
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <?php if ($da->upload_foto_anak): ?>
                                        <img class="card-img" src="<?= base_url().'uploads/'.$da->upload_foto_anak?>" alt="Card image" />
                                    <?php endif ?>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card mb-4">
                                    <div class="card-body text-center">
                                        <h5 class="m-0"> <?= ucwords($da->nama) ?> </h5>
                                        <p class="mt-0"> <?= ucwords($da->nick) ?> </p>
                                        <p class="mb-0">
                                            <?= ucfirst($da->tempat_lahir)?>, 
                                            <?=date("d M Y", strtotime($da->tanggal_lahir)) ?>
                                        </p>
                                    </div>

                                    <div class="card-body pt-0">
                                        <table class="table no-border">
                                            <tr>
                                                <th>Umur</th>
                                                <td><?= $da->tahun ?> Tahun <?= $da->bulan ?> Bulan</td>
                                            </tr>
                                            <tr>
                                                <th>Zona</th>
                                                <td><em class="text-primary"><?= $da->zona ?></em></td>
                                            </tr>
                                            <tr>
                                                <th>Educator/Pengasuh</th>
                                                <td><em  class="text-primary"><?= $da->pengajar ?></em></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- end of col-->
                        </div>    
                        <?php endforeach ?>
                    <?php else: ?>
                        <p class="mt-0"> Silahkan melakukan registrasi educator</p>
                    <?php endif ?>
                    
                    <!-- end of main-content -->
                </div><!-- Footer Start -->

                <?php $this->load->view('layout/footer') ?>
            </div>
        </div>
    </body>
    <?php $this->load->view('layout/custom') ?>
    <script src="<?= base_url().'dist-assets/'?>js/plugins/datatables.min.js"></script>
    <script src="<?= base_url().'dist-assets/'?>js/scripts/datatables.script.min.js"></script>
</html>