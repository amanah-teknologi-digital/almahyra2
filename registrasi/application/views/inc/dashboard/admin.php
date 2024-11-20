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
                            <li><a href="#">Dashboard Admin</a></li>
                            <li><?= $title ?></li>
                        </ul>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card text-left">
                                <div class="card-body">
                                    <?php if (!empty($data_tema)){ ?>
                                        <h5 class="card-title mb-1 d-flex align-items-center justify-content-center">Jadwal Hari&nbsp;<span class="font-weight-bold"><?= format_date_indonesia(Date('Y-m-d:H:i:s')).', '.date('d-m-Y'); ?></span>&nbsp;dengan Tema&nbsp;<span class="text-success"><?= $data_tema->nama_tema ?></span></h5>
                                        <?php if (!empty($data_subtema)){ ?>
                                            <span class="text-muted font-italic text-small d-flex align-items-center justify-content-center font-weight-bold">Sub Tema <?= $data_subtema->nama_subtema ?></span>
                                            <br>
                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                <?php foreach ($data_kelas as $key => $kelas){ ?>
                                                    <li class="nav-item"><a class="nav-link <?= $key==0 ?'active':''; ?>" data-toggle="tab" href="#tab<?= $kelas->id_kelas ?>" role="tab"><?= $kelas->nama ?></a></li>
                                                <?php } ?>
                                            </ul>

                                            <div class="tab-content" id="myTabContent">
                                                <?php foreach ($data_kelas as $key => $kelas){ ?>
                                                    <div class="tab-pane fade show <?= $key==0 ?'active':''; ?>" id="tab<?= $kelas->id_kelas ?>" role="tabpanel">
                                                        <div class="card-body shadow">
                                                            <h5 class="card-title"><b>Jadwal Harian</b></h5>
                                                            <table class="display table table-sm table-striped table-bordered">
                                                                <thead style="background-color: #bfdfff">
                                                                <tr>
                                                                    <th align="center" style="width: 5%">No</th>
                                                                    <th align="center" style="width: 20%">Jam</th>
                                                                    <th align="center" style="width: 50%">Kegiatan</th>
                                                                    <th align="center" style="width: 25%">Keterangan</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php if (isset($data_jadwal_harian[$kelas->id_kelas])){
                                                                    foreach ($data_jadwal_harian[$kelas->id_kelas] as $key => $kegiatan){ ?>
                                                                        <tr>
                                                                            <td align="center"><?= $key+1; ?></td>
                                                                            <td align="center"><?= Date('H:i',strtotime($kegiatan->jam_mulai)).' - '.Date('H:i',strtotime($kegiatan->jam_selesai)) ?></td>
                                                                            <td><?= $kegiatan->uraian; ?></td>
                                                                            <td><span class="text-muted font-italic text-small"><?= $kegiatan->keterangan; ?></span></td>
                                                                        </tr>
                                                                    <?php }
                                                                }else{ ?>
                                                                    <tr>
                                                                        <td colspan="5" align="center"><span class="font-weight-bold text-danger text-small"><i>Data Jadwal Kosong!</i></span></td>
                                                                    </tr>
                                                                <?php } ?>
                                                                </tbody>
                                                            </table>
                                                            <br>
                                                            <h5 class="card-title"><b>Data Stimulus</b></h5>
                                                            <?php if (isset($data_jadwal_stimulus[$kelas->id_kelas])){ ?>
                                                                <fieldset>
                                                                    <div class="form-group">
                                                                        <label>Nama Tema Stimulus</label>
                                                                        <input type="text" name="nama_tema_stimulus" id="nama_tema_stimulus<?= $kelas->id_kelas ?>" class="form-control" autocomplete="off" value="<?= isset($data_jadwal_stimulus[$kelas->id_kelas])? $data_jadwal_stimulus[$kelas->id_kelas]->nama:'';  ?>">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Uraian Kegiatan Stimulus</label>
                                                                        <div>
                                                                            <?= isset($data_jadwal_stimulus[$kelas->id_kelas])? $data_jadwal_stimulus[$kelas->id_kelas]->rincian_kegiatan:'';  ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Keterangan <i>(Optional)</i></label>
                                                                        <textarea class="form-control" name="keterangan" id="keterangan<?= $kelas->id_kelas ?>" cols="30" rows="5" autocomplete="off"><?= isset($data_jadwal_stimulus[$kelas->id_kelas])? $data_jadwal_stimulus[$kelas->id_kelas]->keterangan:'';  ?></textarea>
                                                                    </div>
                                                                </fieldset>
                                                            <?php }else{ ?>
                                                                <span class="text-danger font-italic text-small d-flex align-items-center justify-content-center font-weight-bold">Data stimulus kosong!</span>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        <?php }else{ ?>
                                            <span class="text-danger font-italic text-small d-flex align-items-center justify-content-center font-weight-bold">Sub Tema minggu ini belum ditentukan!</span>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <h5 class="card-title d-flex align-items-center justify-content-center">Jadwal Hari&nbsp;<span class="font-weight-bold"><?= format_date_indonesia(Date('Y-m-d:H:i:s')).', '.date('d-m-Y'); ?></span>&nbsp;<span class="text-danger">Tema Belum Ditentukan!</span></h5>
                                    <?php } ?>
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
</html>