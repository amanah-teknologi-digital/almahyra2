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
                            <li><a href="#">Absensi</a></li>
                            <li><a href="#"><?= $title ?></a></li>
                            <li>Data Harian</li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="<?= base_url().$redirect ?>" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Kembali</a>
                            <div class="card text-left">
                                <div class="card-body">
                                    <h5 class="card-title mb-1 d-flex align-items-center justify-content-center">Hasil Belajar Aktivitas Harian&nbsp;<b><?= format_date_indonesia($data_subtema->tanggal).', '.date('d-m-Y', strtotime($data_subtema->tanggal)) ?></b>&nbsp;subtema&nbsp;<b><?= $data_subtema->nama_subtema ?></b></h5>
                                    <h5 class="card-title mb-1 d-flex align-items-center justify-content-center">a.n&nbsp;<span class="text-success font-weight-bold"><?= $data_anak->nama ?></span>&nbsp;Usia:&nbsp;<span class="text-info"><?= hitung_usia_histori($data_anak->tanggal_lahir, $data_anak->tanggal_aktivitas) ?> <span class="text-muted">(<?= $data_anak->nama_kelas ?>)</span></span></h5>
                                    <br>
                                    <?php echo form_open_multipart($controller.'/simpan', 'id="frm_simpan"'); ?>
                                        <div class="table-responsive">
                                            <table class="display table table-sm table-bordered" id="example">
                                                <thead style="background-color: #bfdfff">
                                                    <tr>
                                                        <th style="width: 5%">No</th>
                                                        <th style="width: 15%">Waktu</th>
                                                        <th style="width: 35%">Nama Kegiatan</th>
                                                        <th style="width: 20%">Status</th>
                                                        <th style="width: 25%">Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1; foreach ($list_kegiatan as $key => $value) { ?>
                                                        <tr>
                                                            <td align="center"><?= $no++ ?></td>
                                                            <td align="center"><?= Date('H:i',strtotime($value->jam_mulai)).' - '.Date('H:i',strtotime($value->jam_selesai)) ?></td>
                                                            <td><b class="text-muted"><?= $value->uraian ?></b></td>
                                                            <td align="center">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="status<?= $value->id_rincianjadwal_harian ?>" id="inlineRadio1<?= $value->id_rincianjadwal_harian ?>" value="1" <?= $value->status == 1 && !is_null($value->status)? 'checked':''; ?> >
                                                                    <label class="form-check-label" for="inlineRadio1">Ada</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="status<?= $value->id_rincianjadwal_harian ?>" id="inlineRadio2<?= $value->id_rincianjadwal_harian ?>" value="0" <?= $value->status != 1 && !is_null($value->status)? 'checked':''; ?>>
                                                                    <label class="form-check-label" for="inlineRadio2">Tidak</label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <textarea class="form-control" name="keterangan<?= $value->id_rincianjadwal_harian ?>" id="keterangan<?= $value->id_rincianjadwal_harian ?>" cols="10" rows="2"><?= $value->keterangan? $value->keterangan:''; ?></textarea>
                                                            </td>
                                                        </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <button type="submit" class="btn btn-sm btn-success "><span class="fas fa-save"></span>&nbsp;Simpan Data</button>
                                    </div>
                                    <input type="hidden" name="id_aktivitas" value="<?= $id_aktivitas ?>">
                                    </form>
                                    <br>
                                    <h5 class="card-title"><b>Data Stimulus</b></h5>
                                    <?php if (isset($data_stimulus)){ ?>
                                        <div class="callout callout-primary alert-dismissible fade show">
                                            <h4><i class="fas fa-fw fa-info-circle"></i> Fokus <?= $data_stimulus->nama ?>&nbsp;<span class="text-muted">(<?= $data_anak->nama_kelas ?>)</span></h4>
                                            <span><?= isset($data_stimulus)? $data_stimulus->rincian_kegiatan:'';  ?></span>
                                            <span class="font-italic text-muted">Keterangan: <?= isset($data_stimulus)? $data_stimulus->keterangan:'-';  ?></span>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h4 class="mt-3 text-warning font-weight-bold" style="text-shadow: 1px 1px 0 #000, -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000;"><i class="fas fa-fw fa-award"></i> Capaian Indikator</h4>
                                                <a href="#" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-plus"></i> Tambah Capaian</a>
                                            </div>
                                            <?php if (count($capaian_indikator) > 0){ ?>
                                                <ul>
                                                    <?php foreach ($capaian_indikator as $key => $value) { ?>
                                                        <li><?= $value->uraian ?></li>
                                                    <?php } ?>
                                                </ul>
                                            <?php }else{ ?>
                                                <span class="text-muted font-italic">Data Kosong!</span>
                                            <?php } ?>
                                        </div>
                                    <?php }else{ ?>
                                        <span class="text-danger font-italic text-small d-flex align-items-center justify-content-center font-weight-bold">Data stimulus kosong!</span>
                                    <?php } ?>
                                    <p class="font-italic float-right mt-5"><span class="fas fa-info-circle"></span>&nbsp;<span class="text-muted" style="font-size: 11px">Lengkapi data-data aktivitas sesuai jadwal kegiatan yang diberikan.</span></p>
                                </div>
                            </div>
                        </div>
                        <!-- end of col-->
                    </div>
                    <!-- end of main-content -->
                </div><!-- Footer Start -->
                <!--  Modal -->
                <?php $this->load->view('layout/footer') ?>
                <!--  Modal -->
            </div>
        </div>
    </body>
    <?php $this->load->view('layout/custom') ?>
    <script src="<?= base_url().'dist-assets/'?>js/plugins/datatables.min.js"></script>
    <script src="<?= base_url().'dist-assets/'?>js/scripts/datatables.script.min.js"></script>
    <script type="text/javascript">
        let url = "<?= base_url().$controller ?>";
        const list_kegiatan = <?= json_encode($list_kegiatan) ?>;
        $(document).ready(function() {
            let rules = {};
            let message = {};
            $.each(list_kegiatan, function(index, value){
                rules['status'+value.id_rincianjadwal_harian] = {
                    required: true
                };
                message['status'+value.id_rincianjadwal_harian] = {
                    required: "Status kegiatan harus diisi!"
                };
            });

            $("#frm_simpan").validate({
                rules: rules,
                messages: message,
                submitHandler: function(form) {
                    form.submit(); // Mengirimkan form jika validasi lolos
                }
            });
        });
    </script>
</html>