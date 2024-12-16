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
                                        <?php echo form_open_multipart($controller); ?>
                                            <table style="width: 100%;padding: 10px 10px;">
                                                <colgroup>
                                                    <col style="width: 20%">
                                                    <col style="width: 80%">
                                                </colgroup>
                                                <tr>
                                                    <td>
                                                        <label>Tahun</label>
                                                    </td>
                                                    <td>
                                                        <select class="form-control" id="tahun" name="tahun" required">
                                                            <?php foreach ($tahun as $key => $value) { ?>
                                                                <option value="<?= $value->tahun ?>" <?= $tahun_selected == $value->tahun ? 'selected' : '' ?>><?= $value->tahun ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label>Nama Anak</label>
                                                    </td>
                                                    <td>
                                                        <select class="form-control select2" id="id_anak" name="id_anak" required>
                                                            <option value="">-- Pilih Anak --</option>
                                                            <?php foreach ($list_anak as $key => $value) { ?>
                                                                <option value="<?= $value->id ?>" <?= $id_anak == $value->id ? 'selected' : '' ?>><?= $value->nama_anak.' ('.hitung_usia($value->tanggal_lahir).')' ?>&nbsp;<?= $value->is_active ? 'aktif':'tidak aktif' ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" >
                                                        <button class="btn btn-sm btn-primary mt-4">Tampilkan</button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                        <hr>
                                        <?php if (!empty($data_anak)){ ?>
                                            <?php echo form_open_multipart($controller.'/cetakabsensianak', 'target="blank"'); ?>
                                                <h5 class="card-title mb-1 d-flex align-content-center justify-content-between"><span class="float-left">Data Absensi Anak&nbsp;a.n&nbsp;<span class="text-success font-weight-bold"><?= $data_anak->nama_anak ?></span>&nbsp;Usia:&nbsp;<span class="text-info"><?= hitung_usia($data_anak->tanggal_lahir) ?> <span class="text-muted">(<?= $data_anak->nama_kelas ?>)</span></span></span>
                                                    <button class="btn btn-sm btn-primary float-right"><span class="fas fa-print"></span>&nbsp;Cetak Absensi</button>
                                                </h5>
                                                <input type="hidden" name="id_anak" value="<?= $id_anak ?>">
                                                <input type="hidden" name="tahun" value="<?= $tahun_selected ?>">
                                            </form>
                                            <br>
                                            <div class="table-responsive">
                                                <table class="display table table-sm table-bordered" id="tbl" style="font-size: 12px;">
                                                    <thead>
                                                    <tr>
                                                        <th style="width: 15%">Tanggal</th>
                                                        <th style="width: 20%">Waktu Masuk</th>
                                                        <th style="width: 20%">Waktu Pulang</th>
                                                        <th style="width: 20%">Status</th>
                                                        <th style="width: 25%">Keterangan</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php $no = 1; foreach ($data_absensi as $key => $value) { ?>
                                                        <tr>
                                                            <td nowrap align="center" class="text-muted font-italic font-weight-bold"><?= format_date_indonesia($value->tanggal).', '.date('d-m-Y', strtotime($value->tanggal)) ?></td>
                                                            <td nowrap align="center"><?= $value->waktu_checkin ?></td>
                                                            <td nowrap align="center"><?= $value->waktu_checkout ?></td>
                                                            <td align="center" nowrap style="font-size: 11px">
                                                                <?php if (empty($value->id_absensi)) { ?>
                                                                    <span class="badge badge-danger">Belum Absen</span>
                                                                <?php } else { ?>
                                                                    <?php if (!empty($value->waktu_checkout)){ ?>
                                                                        <span class="text-info font-italic font-weight-bold">Durasi : <?= hitung_durasi_waktu($value->waktu_checkin, $value->waktu_checkout); ?></span>
                                                                    <?php }else{ ?>
                                                                        <span class="badge badge-warning">Belum Absen Pulang</span>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </td>
                                                            <td nowrap>
                                                                <?php if (!empty($value->id_absensi)) { ?>
                                                                    &bullet;&nbsp;<span class="text-muted font-italic" style="font-size: 11px">
                                                                        Suhu Tubuh: <b><?= $value->suhu ?> °C</b>, Kondisi: <b><?= $value->kondisi == 1 ? 'Sehat':'Kurang Sehat' ?></b>
                                                                    </span>
                                                                    <?php if (!empty($value->waktu_checkout)){ ?>
                                                                        <br>
                                                                        &bullet;&nbsp;<span class="text-muted font-italic" style="font-size: 11px">
                                                                        Suhu Tubuh Pulang: <b><?= $value->suhu_checkout ?> °C</b>, Kondisi Pulang: <b><?= $value->kondisi_checkout == 1 ? 'Sehat':'Kurang Sehat' ?></b>
                                                                    </span>
                                                                    <?php } ?>
                                                                <?php } else { ?>
                                                                    <center>-</center>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php }else{ ?>
                                            <h5 class="card-title mb-1 d-flex align-content-center justify-content-center"><span class="text-danger font-weight-bold">Pilih Anak terlebih dahulu, kemudian klik tombol <span class="text-success">Tampilkan</span> untuk menampilkan data!</span></h5>
                                        <?php } ?>
                                        <p class="font-italic float-right"><span class="fas fa-info-circle"></span>&nbsp;<span class="text-muted" style="font-size: 11px">Laporan absensi harian anak.</span></p>
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
            $('.select2').select2();
        });
    </script>
</html>