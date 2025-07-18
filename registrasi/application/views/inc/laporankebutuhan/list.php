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
                                                    <label>Anak</label>
                                                </td>
                                                <td>
                                                    <select class="form-control" id="id_anak" name="id_anak" required">
                                                    <?php foreach ($list_anak as $key => $value) { ?>
                                                        <option value="<?= $value->id ?>" <?= $id_anak == $value->id ? 'selected' : '' ?>><?= $value->nama_anak ?></option>
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
                                    <?php echo form_open_multipart($controller.'/cetakkebutuhananak', 'target="blank"'); ?>
                                        <div class="row d-flex justify-content-center align-items-center">
                                            <div class="col-sm-10">
                                                <h5 class="card-title mb-1 d-flex align-content-center justify-content-between"><span class="float-left">Data Kebutuhan Anak&nbsp;<?= !empty($id_anak)? 'a.n&nbsp;<span class="text-success font-weight-bold">'. $data_anak->nama_anak.'</span>':''?></span></h5>
                                            </div>
                                            <div class="col-sm-2">
                                                <button class="btn btn-sm btn-primary float-right"><span class="fas fa-print"></span>&nbsp;Cetak Data</button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="id_anak" value="<?= $id_anak ?>">
                                    </form>
                                    <br>
                                    <div class="table-responsive">
                                        <table class="display table table-sm table-bordered" id="tbl" style="font-size: 12px;">
                                            <thead>
                                            <tr>
                                                <th style="width: 15%">Tanggal</th>
                                                <th style="width: 20%">Jenis Kebutuhan</th>
                                                <th style="width: 20%">Penginput</th>
                                                <th style="width: 20%">Status</th>
                                                <th style="width: 25%">Keterangan</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $no = 1; foreach ($data_kebutuhan as $key => $value) { ?>
                                                <tr>
                                                    <td nowrap align="center" class="text-muted font-italic font-weight-bold"><?= format_date_indonesia($value->tanggal).', '.date('d-m-Y', strtotime($value->tanggal)) ?></td>
                                                    <td nowrap align="center"><?= $value->nama_jeniskebutuhan ?></td>
                                                    <td nowrap><b><?= $value->nama_educator; ?></b>&nbsp;pada&nbsp;<span class="font-italic text-small"><?= $value->created_at; ?></span></td>
                                                    <td align="center" nowrap>
                                                        <?php if (empty($value->is_valid)) { ?>
                                                            <span class="badge badge-danger">Tidak Valid</span>
                                                        <?php } else { ?>
                                                            <span class="badge badge-success">Valid</span>
                                                        <?php } ?>
                                                    </td>
                                                    <td nowrap>
                                                        <span class="text-muted font-italic" style="font-size: 11px"><?= $value->keterangan ?></span>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <p class="font-italic float-right"><span class="fas fa-info-circle"></span>&nbsp;<span class="text-muted" style="font-size: 11px">Laporan kebutuhan anak.</span></p>
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
            $('#id_anak').select2();
        });
    </script>
</html>