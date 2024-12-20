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
                                            <?php echo form_open_multipart($controller.'/cetakmedicalcheckup', 'target="blank"'); ?>
                                                <h5 class="card-title mb-1 d-flex align-content-center justify-content-between"><span class="float-left">Data Medical Chekup&nbsp;a.n&nbsp;<span class="text-success font-weight-bold"><?= $data_anak->nama_anak ?></span>&nbsp;Usia:&nbsp;<span class="text-info"><?= hitung_usia($data_anak->tanggal_lahir) ?> <span class="text-muted">(<?= $data_anak->nama_kelas ?>)</span></span></span>
                                                    <button class="btn btn-sm btn-primary float-right"><span class="fas fa-print"></span>&nbsp;Cetak Data Checkup</button>
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
                                                        <th style="width: 10%">Berat Badan</th>
                                                        <th style="width: 10%">Tinggi Badan</th>
                                                        <th style="width: 10%">Lingkar Lengan</th>
                                                        <th style="width: 10%">Lingkar Kepala</th>
                                                        <th style="width: 30%">Keterangan</th>
                                                        <th style="width: 15%">Aksi</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php $no = 1; foreach ($data_medical_checkup as $key => $value) { ?>
                                                        <tr>
                                                            <td nowrap align="center" class="text-muted font-italic font-weight-bold"><?= format_date_indonesia($value['tanggal']).', '.date('d-m-Y', strtotime($value['tanggal'])) ?></td>
                                                            <td nowrap align="center"><?= $value['berat_badan'].' '.$value['satuanberat_badan']; ?></td>
                                                            <td nowrap align="center"><?= $value['tinggi_badan'].' '.$value['satuantinggi_badan']; ?></td>
                                                            <td nowrap align="center"><?= $value['lingkar_lengan'].' '.$value['satuanlingkar_lengan']; ?></td>
                                                            <td nowrap align="center"><?= $value['lingkar_kepala'].' '.$value['satuanlingkar_kepala']; ?></td>
                                                            <td><span class="text-muted text-small font-italic"><?= $value['keterangan']; ?></span></td>
                                                            <td align="center">
                                                                <a href="<?= base_url().$redirect.'/lihat-data/'.$value['id_checkup'] ?>" class="btn btn-sm btn-icon btn-success" data-id="<?= $value['id_checkup']; ?>"><span class="fas fa-eye-dropper"></span>&nbsp;Data Checkup</a>
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