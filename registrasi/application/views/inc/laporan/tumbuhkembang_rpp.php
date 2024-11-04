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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card text-left">
                                <div class="card-body">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab1" role="tab">Data Anak</a></li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab2" role="tab">Berat Badan</a></li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab3" role="tab" >Tinggi Badan</a></li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab4" role="tab" >Lingkar Kepala</a></li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab5" role="tab" >Bagian Kepala</a></li>
                                    </ul>

                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                                            <fieldset>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <h6>Nama</h6>
                                                            <input class="form-control" type="text" required disabled value="<?= $anak->nama ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                         <div class="form-group">
                                                            <h6>Panggilan</h6>
                                                            <input class="form-control" type="text" required disabled value="<?= $anak->nick ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <h6>Usia</h6>
                                                            <input class="form-control" type="text" required disabled value="<?= $tahun.' Tahun' ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                         <div class="form-group">
                                                            <h6>&nbsp;</h6>
                                                            <input class="form-control" type="text" required disabled value="<?= $bulan.' Bulan' ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <h6>Tempat Lahir</h6>
                                                            <input class="form-control" type="text" required disabled value="<?= $anak->tempat_lahir ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <h6>Tanggal Lahir</h6>
                                                            <input class="form-control" type="date" required disabled value="<?= $anak->tanggal_lahir ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <h6>Jenis Kelamin</h6>
                                                            <input class="form-control" type="text" required disabled value="<?= $anak->jenis_kelamin ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <div class="form-group">
                                                                <h6>Golongan Darah</h6>
                                                                <input class="form-control" type="text" required disabled value="<?= $anak->golongan_darah ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <h6>Anak Ke-</h6>
                                                            <input class="form-control" type="number" required disabled value="<?= $anak->anak_ke ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <h6>Jumlah Saudara</h6>
                                                            <input class="form-control" type="number" required disabled value="<?= $anak->jumlah_saudara ?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <h6>Zona</h6>
                                                            <input class="form-control" type="text" required disabled value="<?= $zona->zona ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <h6>Pengasuh</h6>
                                                            <input class="form-control" type="text" required disabled value="<?= $zona->pengajar ?>">
                                                        </div>
                                                    </div>
                                                </div>

                                            </fieldset>    
                                        </div>
                                        <div class="tab-pane fade" id="tab2" role="tabpanel">
                                            <table class="display table table-striped table-bordered tabeldata" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Tanggal</th>
                                                        <th>Berat Badan (Kg)</th>
                                                    </tr>
                                                </thead>
                                                 <tbody>
                                                    <?php 
                                                    $i = 1 ;
                                                    foreach ($observasi as $key =>$row) { ?>
                                                        <tr>
                                                            <td><?= $i++ ?></td>
                                                            <td> <?= date("d M Y", strtotime($row->tanggal)) ?></td>
                                                            <td> <?= $row->bb ?> </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Tanggal</th>
                                                        <th>Berat Badan (Kg)</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="tab3" role="tabpanel">
                                            <table class="display table table-striped table-bordered tabeldata" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Tanggal</th>
                                                        <th>Tinggi Badan (Kg)</th>
                                                    </tr>
                                                </thead>
                                                 <tbody>
                                                    <?php 
                                                    $i = 1 ;
                                                    foreach ($observasi as $key =>$row) { ?>
                                                        <tr>
                                                            <td><?= $i++ ?></td>
                                                            <td> <?= date("d M Y", strtotime($row->tanggal)) ?></td>
                                                            <td> <?= $row->tb ?> </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Tanggal</th>
                                                        <th>Tinggi Badan (Kg)</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="tab4" role="tabpanel">
                                            <table class="display table table-striped table-bordered tabeldata" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Tanggal</th>
                                                        <th>Lingkar Kepala</th>
                                                    </tr>
                                                </thead>
                                                 <tbody>
                                                    <?php 
                                                    $i = 1 ;
                                                    foreach ($observasi as $key =>$row) { ?>
                                                        <tr>
                                                            <td><?= $i++ ?></td>
                                                            <td> <?= date("d M Y", strtotime($row->tanggal)) ?></td>
                                                            <td> <?= $row->lk ?> </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Tanggal</th>
                                                        <th>Lingkar Kepala</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="tab5" role="tabpanel">
                                            <table class="display table table-striped table-bordered tabeldata" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Tanggal</th>
                                                        <th>Rambut</th>
                                                        <th>Mata</th>
                                                        <th>Telinga</th>
                                                        <th>Hidung</th>
                                                        <th>Mulut</th>
                                                        <th>Gigi</th>
                                                        <th>Kulit</th>
                                                        <th>Kuku</th>
                                                        <th>Kaki</th>
                                                    </tr>
                                                </thead>
                                                 <tbody>
                                                    <?php 
                                                    $i = 1 ;
                                                    foreach ($observasi as $key =>$row) { ?>
                                                        <tr>
                                                            <td><?= $i++ ?></td>
                                                            <td> <?= date("d M Y", strtotime($row->tanggal)) ?></td>
                                                            <td> <?= $row->rambut == '1' ? 'Bersih' : 'Tidak Bersih' ?> </td>
                                                            <td> <?= $row->mata == '1' ? 'Bersih' : 'Tidak Bersih' ?> </td>
                                                            <td> <?= $row->telinga == '1' ? 'Bersih' : 'Tidak Bersih' ?> </td>
                                                            <td> <?= $row->hidung == '1' ? 'Bersih' : 'Tidak Bersih' ?> </td>
                                                            <td> <?= $row->mulut == '1' ? 'Bersih' : 'Tidak Bersih' ?> </td>
                                                            <td> <?= $row->gigi == '1' ? 'Bersih' : 'Tidak Bersih' ?> </td>
                                                            <td> <?= $row->kulit == '1' ? 'Bersih' : 'Tidak Bersih' ?> </td>
                                                            <td> <?= $row->kuku == '1' ? 'Bersih' : 'Tidak Bersih' ?> </td>
                                                            <td> <?= $row->kaki == '1' ? 'Bersih' : 'Tidak Bersih' ?> </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Tanggal</th>
                                                        <th>Rambut</th>
                                                        <th>Mata</th>
                                                        <th>Telinga</th>
                                                        <th>Hidung</th>
                                                        <th>Mulut</th>
                                                        <th>Gigi</th>
                                                        <th>Kulit</th>
                                                        <th>Kuku</th>
                                                        <th>Kaki</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end of col-->
                    </div>
                    <!-- end of main-content -->
                </div><!-- Footer Start -->

                <?php $this->load->view('layout/footer') ?>
            </div>
        </div>
    </body>
    <?php $this->load->view('layout/custom') ?>
    <script src="<?= base_url().'dist-assets/'?>js/plugins/datatables.min.js"></script>
    <script src="<?= base_url().'dist-assets/'?>js/scripts/datatables.script.min.js"></script>

    <script type="text/javascript">
        if ('.tabeldata') {
            $('.tabeldata').dataTable({
                "ordering": false,
                "searching": false,
                "lengthChange": false
            });
        } 
    </script>
</html>


                                                                
                                                                    
                                                                
                                                            