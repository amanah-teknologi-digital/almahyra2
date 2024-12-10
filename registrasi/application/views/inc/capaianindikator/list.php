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
                            <li><a href="#">Laporan</a></li>
                            <li><?= $title ?></li>
                        </ul>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12 mb-4">
                            <div class="card text-left">
<!--                                <div class="card-header">-->
<!--                                    <p class="card-title mb-0">Filter</p>-->
<!--                                </div>-->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="display table table-striped table-bordered" id="tbl" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th style="width: 5%">No</th>
                                                <th style="width: 45%">Nama Anak</th>
                                                <th style="width: 15%">Usia</th>
                                                <th style="width: 10%">Kelamin</th>
                                                <th style="width: 15%">Progress Indikator</th>
                                                <th style="width: 10%">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $no = 1; foreach ($list_siswa_indikator as $key => $value) { ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td nowrap><b><?= $value->nama_anak ?></b> <span class="font-italic text-muted">(<?= $value->nama_kelas ?>)</span>
                                                        <?= $value->is_active ? '<span class="badge badge-success">aktif</span>':'<span class="badge badge-danger">tidak aktif</span>' ?>
                                                    </td>
                                                    <td nowrap><span class="text-muted font-italic" style="font-size: 12px;"><?= hitung_usia($value->tanggal_lahir); ?></span></td>
                                                    <td align="center"><?= $value->jenis_kelamin == 'L'? 'Laki - Laki':'Perempuan'; ?></td>
                                                    <td align="center" nowrap>
                                                        <?= $value->jml_capaian.' / '.$value->jml_indikator ?><br>
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width: <?= round(($value->jml_capaian/$value->jml_indikator)*100) ?>%;"><?= round(($value->jml_capaian/$value->jml_indikator)*100) ?>%</div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="<?= base_url().$redirect.'/detail/'.$value->id ?>" class="btn btn-success btn-sm"><span class="fas fa-eye"></span> Detail</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
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
    <script type="text/javascript">
        var url = "<?= base_url().$controller ?>";

        $(document).ready(function() {

        });
    </script>
</html>