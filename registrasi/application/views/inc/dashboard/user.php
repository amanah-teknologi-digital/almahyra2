<!DOCTYPE html>
<html lang="en" dir="/">

    <?php $this->load->view('layout/head') ?>
    <style>
        .callout {
            background-color: #fff;
            border: 1px solid #e4e7ea;
            border-left: 4px solid #c8ced3;
            border-radius: .25rem;
            margin: 1rem 0;
            padding: .75rem 1.25rem;
            position: relative;
        }

        .callout h4 {
            font-size: 1.3125rem;
            margin-top: 0;
            margin-bottom: .8rem
        }
        .callout p:last-child {
            margin-bottom: 0;
        }

        .callout-default {
            border-left-color: #777;
            background-color: #f4f4f4;
        }
        .callout-default h4 {
            color: #777;
        }

        .callout-primary {
            background-color: #d2eef7;
            border-color: #b8daff;
            border-left-color: #17a2b8;
        }
        .callout-primary h4 {
            color: #20a8d8;
        }

        .callout-success {
            background-color: #dff0d8;
            border-color: #d6e9c6;
            border-left-color: #28a745;
        }
        .callout-success h4 {
            color: #3c763d;
        }

        .callout-danger {
            background-color: #f2dede;
            border-color: #ebccd1;
            border-left-color: #d32535;
        }
        .callout-danger h4 {
            color: #a94442;
        }

        .callout-warning {
            background-color: #fcf8e3;
            border-color: #faebcc;
            border-left-color: #edb100;
        }
        .callout-warning h4 {
            color: #f0ad4e;
        }

        .callout-info {
            background-color: #d2eef7;
            border-color: #b8daff;
            border-left-color: #148ea1;
        }
        .callout-info h4 {
            color: #31708f;
        }

        .callout-dismissible .close {
            position: absolute;
            top: 0;
            right: 0;
            padding: .75rem 1.25rem;
            color: inherit;
        }
    </style>
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
                            <li>Orang Tua/Wali</li>
                        </ul>
                    </div>
                    <?php if (!empty($data_anak)): $now = date('Y-m-d'); ?>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <?php foreach ($data_anak as $key => $anak){ ?>
                            <li class="nav-item"><a class="nav-link <?= $key==0 ?'active':''; ?>" data-toggle="tab" href="#tab<?= $anak->id ?>" role="tab"><?= $anak->nama ?></a></li>
                        <?php } ?>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <?php foreach ($data_anak as $key => $anak){ ?>
                            <div class="tab-pane fade show <?= $key==0 ?'active':''; ?>" id="tab<?= $anak->id ?>" role="tabpanel">
                                <div class="card-body">
                                    <?php echo form_open_multipart($controller.'/cetakjadwalharian', 'target="blank"'); ?>
                                    <h5 class="card-title d-flex align-items-center justify-content-between"><span class="float-left"><i class="fas fa-calendar"></i> Jadwal Harian <span class="font-weight-bold"><?= format_date_indonesia($now).', '.date('d-m-Y'); ?></span> a.n <span class="text-success font-weight-bold"><?= $anak->nama ?></span>&nbsp; anak ke <?= $anak->anak_ke; ?>&nbsp;Usia:&nbsp;<span class="text-info"><?= hitung_usia($anak->tanggal_lahir) ?> <span class="text-muted">(<?= $anak->nama_kelas ?>)</span></span></span>
                                        <button class="btn btn-sm btn-primary float-right"><span class="fas fa-print"></span>&nbsp;Cetak Jadwal</button>
                                    </h5>
                                    <input type="hidden" name="id_rincianjadwal_mingguan" value="<?= $id_rincianjadwal_mingguan ?>">
                                    <input type="hidden" name="id_kelas" value="<?= $anak->id_kelas ?>">
                                    </form>
                                    <?php if (!empty($data_subtema)): ?>
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
                                            <?php if (isset($data_jadwal_harian[$anak->id_kelas])){
                                                foreach ($data_jadwal_harian[$anak->id_kelas] as $key => $kegiatan){ ?>
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
                                        <h5 class="card-title"><b><i class="fas fa-lightbulb"></i> Data Stimulus</b></h5>
                                        <?php if (isset($data_jadwal_stimulus[$anak->id_kelas])){ ?>
                                            <div class="callout callout-primary alert-dismissible fade show">
                                                <h4><i class="fas fa-fw fa-info-circle"></i> Fokus <?= $data_jadwal_stimulus[$anak->id_kelas]->nama ?>&nbsp;<span class="text-muted">(<?= $anak->nama_kelas ?>)</span></h4>
                                                <span><?= isset($data_jadwal_stimulus[$anak->id_kelas])? $data_jadwal_stimulus[$anak->id_kelas]->rincian_kegiatan:'';  ?></span>
                                                <span class="font-italic text-muted">Keterangan: <?= isset($data_jadwal_stimulus[$anak->id_kelas])? $data_jadwal_stimulus[$anak->id_kelas]->keterangan:'-';  ?></span>
                                            </div>
                                        <?php }else{ ?>
                                            <span class="text-danger font-italic text-small d-flex align-items-center justify-content-center font-weight-bold">Data stimulus kosong!</span>
                                        <?php } ?>
                                    <?php else: ?>
                                        <span class="text-danger font-italic text-small d-flex align-items-center justify-content-center font-weight-bold">Data jadwal kosong!</span>
                                    <?php endif ?>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    <?php else: ?>
                        <p class="mt-0"> Silahkan melakukan registrasi anak </p>
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