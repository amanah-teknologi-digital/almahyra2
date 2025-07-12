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
                                    <?php echo form_open_multipart($controller); ?>
                                        <table style="width: 100%;padding: 10px 10px;">
                                            <colgroup>
                                                <col style="width: 20%">
                                                <col style="width: 80%">
                                            </colgroup>
                                            <tr>
                                                <td>
                                                    <label>Tanggal Mengaji</label>
                                                </td>
                                                <td>
                                                    <input type="date" class="form-control" name="tanggal" value="<?= $tanggal ?>" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label>Sesi Mengaji</label>
                                                </td>
                                                <td>
                                                    <select class="form-control" id="sesi" name="sesi" required">
                                                    <option value="" selected>-- Semua --</option>
                                                    <?php foreach ($list_sesi as $key => $value) { ?>
                                                        <option value="<?= $value->id_sesi ?>" <?= $sesi == $value->id_sesi ? 'selected' : '' ?>><?= $value->nama ?></option>
                                                    <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label>Ustadzah</label>
                                                </td>
                                                <td>
                                                    <select class="form-control" id="id_ustadzah" name="id_ustadzah" required">
                                                    <option value="" selected>-- Semua --</option>
                                                    <?php foreach ($list_ustadzah as $key => $value) { ?>
                                                        <option value="<?= $value->id ?>" <?= $id_ustadzah == $value->id ? 'selected' : '' ?>><?= $value->name ?></option>
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
                                    <?php echo form_open_multipart($controller.'/cetaklaporanmengaji', 'target="blank"'); ?>
                                        <div class="row d-flex justify-content-center align-items-center">
                                            <div class="col-sm-10">
                                                <h5 class="card-title mb-1 d-flex align-content-center justify-content-between"><span class="float-left">Data Laporan Mengaji Hari&nbsp;<span><?= format_date_indonesia($tanggal).', '.date('d-m-Y', strtotime($tanggal)); ?></span>&nbsp;<span class="text-success font-weight-bold"><?= !empty($sesi)? 'Sesi '.$nama_sesi:''; ?></span>&nbsp;<span class="font-weight-bold"><?= !empty($id_ustadzah) ? 'Ustadzah: '.$nama_ustadzah:'' ?> </span></span></h5>
                                            </div>
                                            <div class="col-sm-2">
                                                <button class="btn btn-sm btn-primary float-right"><span class="fas fa-print"></span>&nbsp;Cetak Laporan</button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="tanggal" value="<?= $tanggal ?>">
                                        <input type="hidden" name="sesi" value="<?= $sesi ?>">
                                        <input type="hidden" name="id_ustadzah" value="<?= $id_ustadzah ?>">
                                    </form>
                                    <br>
                                    <div class="table-responsive">
                                        <table class="display table table-sm table-bordered" id="tbl" style="font-size: 12px;">
                                            <thead>
                                            <tr>
                                                <th style="width: 15%">Tanggal</th>
                                                <th style="width: 20%">Nama Anak</th>
                                                <th style="width: 10%">Sesi</th>
                                                <th style="width: 10%">Jilid/Kelas</th>
                                                <th style="width: 5%">Halaman</th>
                                                <th style="width: 5%">Nilai</th>
                                                <th style="width: 20%">Ustadzah</th>
                                                <th style="width: 15%">Keterangan</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $no = 1; foreach ($hasil_mengaji as $key => $value) { ?>
                                                <tr>
                                                    <td nowrap align="center" class="text-muted font-italic font-weight-bold"><?= format_date_indonesia($value->tanggal).', '.date('d-m-Y', strtotime($value->tanggal)) ?></td>
                                                    <td nowrap align="left"><?= $value->nama_anak ?></td>
                                                    <td nowrap align="center"><b><?= $value->nama_sesi ?></b></td>
                                                    <td nowrap align="center"><?= $value->nama_jilid ?></td>
                                                    <td nowrap align="center"><?= $value->halaman ?></td>
                                                    <td nowrap align="center" class="font-weight-bold"><?= !empty($value->nilai) ? '<span class="text-success">L</span>':'<span class="text-danger">-L</span>' ?></td>
                                                    <td nowrap align="center"><?= $value->nama_ustadzah ?></td>
                                                    <td nowrap align="left" class="text-muted font-italic text-small"><?= $value->keterangan ?></td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <p class="font-italic float-right"><span class="fas fa-info-circle"></span>&nbsp;<span class="text-muted" style="font-size: 11px">Laporan mengaji anak.</span></p>
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