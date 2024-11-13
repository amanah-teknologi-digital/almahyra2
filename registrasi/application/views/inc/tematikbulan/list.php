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
                            <li><?= $title ?></li>
                        </ul>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12 mb-4">
                            <div class="card text-left">
                                <div class="card-body">
                                    <div class="alert alert-info" role="alert">
                                        Memanajemen tema per bulan beserta sub tema dari bulan tersebut sesuai tematik tahunanya!. ini juga akan menentukan jadwal harianya nanti.
                                    </div>

                                    <div class="table-responsive">
                                        <table class="display table table-striped table-bordered" id="tbl" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <!-- <th>#</th> -->
                                                    <th style="width: 10%">Tahun</th>
                                                    <th style="width: 55%">Uraian Tema</th>
                                                    <th style="width: 5%">Status</th>
                                                    <th style="width: 15%">Status Tematik Bulanan</th>
                                                    <th style="width: 15%">Action</th>
                                                </tr>
                                            </thead>
                                             <tbody>
                                                <?php 
                                                $i = 1 ;
                                                foreach ($list as $key =>$row) { ?>
                                                    <tr>
                                                        <!-- <td><?= $i++ ?></td> -->
                                                        <td align="center"><?= $row->tahun ?></td>
                                                        <td><?= $row->uraian ?></td>
                                                        <td align="center"><?= $row->is_aktif? '<span class="badge badge-success">aktif</span>':'<span class="badge badge-danger">tidak aktif</span>'; ?></td>
                                                        <td align="center">
                                                            <?= $row->jml_tematikbulanan.' / '.$row->jml_bulan ?><br>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width: <?= ((int) ($row->jml_tematikbulanan/$row->jml_bulan))*100 ?>%;"><?= ((int) ($row->jml_tematikbulanan/$row->jml_bulan))*100 ?>%</div>
                                                            </div>
                                                        </td>
                                                        <td align="center">
                                                            <a href="<?= base_url().$redirect.'/'.$row->tahun ?>" class="btn btn-sm btn-success"><span class="fas fa-eye"></span> Lihat Data</a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <!-- <th>#</th> -->
                                                    <th>Tahun</th>
                                                    <th>Uraian Tema</th>
                                                    <th>Status</th>
                                                    <th>Timestamp</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
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
</html>