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
                                                        <label>Nama Educator</label>
                                                    </td>
                                                    <td>
                                                        <select class="form-control select2" id="id_user" name="id_user" required>
                                                            <?php if (count($list_educator) > 1) { ?>
                                                                <option value="">-- Pilih Educator --</option>
                                                            <?php } ?>
                                                            <?php foreach ($list_educator as $key => $value) { ?>
                                                                <option value="<?= $value->id ?>" <?= $id_user == $value->id ? 'selected' : '' ?>><?= $value->nama_educator ?></option>
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
                                        <?php if (!empty($data_educator)){ ?>
                                            <?php echo form_open_multipart($controller.'/cetakabsensieducator', 'target="blank"'); ?>
                                                <h5 class="card-title mb-1 d-flex align-content-center justify-content-between"><span class="float-left">Data Absensi Educator&nbsp;a.n&nbsp;<span class="text-success font-weight-bold"><?= $data_educator->nama_educator ?></span></span>
                                                    <button class="btn btn-sm btn-primary float-right"><span class="fas fa-print"></span>&nbsp;Cetak Absensi</button>
                                                </h5>
                                                <input type="hidden" name="id_user" value="<?= $id_user ?>">
                                                <input type="hidden" name="tahun" value="<?= $tahun_selected ?>">
                                            </form>
                                            <br>
                                            <div class="table-responsive">
                                                <table class="display table table-sm table-bordered" id="tbl" style="font-size: 12px;">
                                                    <colgroup>
                                                        <col style="width: 10%">
                                                        <col style="width: 15%">
                                                        <col style="width: 15%">
                                                        <col style="width: 15%">
                                                        <col style="width: 20%">
                                                        <col style="width: 25%">
                                                    </colgroup>
                                                    <thead>
                                                    <tr>
                                                        <th>Tanggal</th>
                                                        <th>Jenis Absensi</th>
                                                        <th>Waktu Masuk</th>
                                                        <th>Waktu Pulang</th>
                                                        <th>Status</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php $i = 1;
                                                    foreach ($data_absensi as $key =>$row) { ?>
                                                        <tr>
                                                            <td nowrap align="center"><b><?= format_date_indonesia($row->tanggal).', '.date('d-m-Y', strtotime($row->tanggal)) ?></b>
                                                            <td align="center" nowrap class="text-muted"><b><?= $row->jenis_absen; ?></b>
                                                                <?php if (!empty($row->id_jenislembur)){ ?>
                                                                    <br>
                                                                    <span class="badge badge-primary">Lembur</span>
                                                                <?php } ?>
                                                            </td>
                                                            <td align="center" nowrap class="text-muted"><b><?= $row->waktu_checkin ?></b></td>
                                                            <td align="center" nowrap class="text-muted"><b><?= !empty($row->waktu_checkout)? $row->waktu_checkout:'-'; ?></b></td>
                                                            <td nowrap align="center">
                                                                <?php if (!empty($row->waktu_checkout)){ ?>
                                                                    <span class="text-info text-small font-italic font-weight-bold">Durasi : <?= hitungDurasiDalamMenit($row->waktu_checkin, $row->waktu_checkout); ?> Menit</span>
                                                                <?php }else{ ?>
                                                                    <span class="badge badge-warning">Belum Absen Pulang</span>
                                                                <?php } ?>
                                                            </td>
                                                            <td style="font-size: 11px;">
                                                                <?php if (!empty($row->id_jenislembur)){ ?>
                                                                    <i>Jenis Lembur : </i><b><?= $row->jenis_lembur; ?></b>
                                                                    <br>
                                                                    <i>Ket: </i>
                                                                    <span class="text-muted font-italic" style="font-size: 11px;"><?= !empty($row->keterangan)? $row->keterangan:'-'; ?></span>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                        <?php $i++; } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php }else{ ?>
                                            <h5 class="card-title mb-1 d-flex align-content-center justify-content-center"><span class="text-danger font-weight-bold">Pilih Educator terlebih dahulu, kemudian klik tombol <span class="text-success">Tampilkan</span> untuk menampilkan data!</span></h5>
                                        <?php } ?>
                                        <p class="font-italic float-right"><span class="fas fa-info-circle"></span>&nbsp;<span class="text-muted" style="font-size: 11px">Laporan absensi harian educator.</span></p>
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