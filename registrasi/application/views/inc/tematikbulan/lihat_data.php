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
                            <li><a href="#">Rencana Belajar</a></li>
                            <li><a href="#"><?= $title ?></a></li>
                            <li>Data Tematik</li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="<?= base_url().$redirect ?>" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Kembali</a>
                            <div class="card text-left">
                                <div class="card-body">
                                    <h5 class="card-title d-flex align-items-center justify-content-center">Rencana Belajar Bulanan untuk Tematik Tahun <?= $tahun_tematik ?>&nbsp;dengan Tema&nbsp;<span class="text-success font-weight-bold"><?= $tema_tahun->uraian ?></span></h5>
                                    <fieldset>
                                        <div class="accordion" id="accordionRightIcon">
                                            <?php foreach ($list_bulan as $bulan){
                                                if (empty($bulan->id_temabulanan)){
                                                    $temp_uraian = $bulan->nama_bulan.'&nbsp;<span class="text-danger text-small">( tema belum ditentukan! )</span>';
                                                }else{
                                                    $temp_uraian = $bulan->nama_bulan.'&nbsp;<span class="text-success text-small">( Sub Tema: <b>'.$bulan->nama_temabulanan.'</b> )</span>';
                                                    $temp_uraian .= '&nbsp;<span class="text-muted text-small"><i>terakhir update ';
                                                    if (empty($row->updated_at)){
                                                        $temp_uraian .= timeAgo($bulan->created_at);
                                                    }else{
                                                        $temp_uraian .= timeAgo($bulan->updated_at);
                                                    }
                                                    $temp_uraian .= ' oleh '.$bulan->nama_role.' ('.$bulan->nama_user.')</i></span>';
                                                 
                                                }
                                                ?>
                                                <div class="card">
                                                    <div class="card-header header-elements-inline">
                                                        <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                                            <a class="text-default collapsed" data-toggle="collapse" href="#accordion-item-icon-right-<?= $bulan->bulan ?>" aria-expanded="false"><?= $temp_uraian; ?></a>
                                                        </h6>
                                                    </div>
                                                    <div class="collapse" id="accordion-item-icon-right-<?= $bulan->bulan ?>" data-parent="#accordionRightIcon">
                                                        <div class="card-body">
                                                            <?php if (empty($bulan->id_temabulanan)){ ?>
                                                                <span class="text-danger text-small d-flex align-items-center justify-content-center font-weight-bold">Silahkan menentukan tema bulan <?= $bulan->nama_bulan ?> terlebih dahulu!</span>
                                                            <?php }else{ ?>

                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </fieldset>
                                    <p class="font-italic float-right mt-5"><span class="fas fa-info-circle"></span>&nbsp;<span class="text-muted">Setiap bulan memiliki <b>tema dan sub tema</b> untuk mingguan, per sub tema akan ditentukan <b>tanggal mingguanya</b>.</span></p>
                                </div>
                            </div>
                        </div>
                        <!-- end of col-->
                    </div>
                    <!-- end of main-content -->
                </div><!-- Footer Start -->

                <!--  Modal -->
                <?php $this->load->view('layout/footer') ?>
            </div>
        </div>
    </body>
    <?php $this->load->view('layout/custom') ?>
    <script src="<?= base_url().'dist-assets/'?>js/plugins/datatables.min.js"></script>
    <script src="<?= base_url().'dist-assets/'?>js/scripts/datatables.script.min.js"></script>
</html>