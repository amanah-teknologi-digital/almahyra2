<!DOCTYPE html>
<html lang="en" dir="/">

    <?php $this->load->view('layout/head') ?>

    <style type="text/css">
        .map {
          height: 200px;
          /* The height is 400 pixels */
          width: 100%;
          /* The width is the width of the web page */
        }

    </style>
    <body class="text-left">
        <div class="app-admin-wrap layout-sidebar-compact sidebar-dark-purple <?= $role != 5 ? 'sidenav-open':''; ?> clearfix">
            <?php $this->load->view('layout/navigation') ?>

            <!-- =============== Horizontal bar End ================-->
            <div class="main-content-wrap d-flex flex-column">
                <?php $this->load->view('layout/header') ?>
                <!-- ============ Body content start ============= -->
                <div class="main-content">
                    <div class="breadcrumb">
                        <ul>
                            <li><a href="#">Medical Checkup</a></li>
                            <li><?= $title ?></li>
                        </ul>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12 mb-4">
                            <div class="card text-left">
                                <div class="card-body">
                                    <h5 class="card-title mb-1 d-flex align-items-center justify-content-center">Hasil Medical Checkup Hari&nbsp;<span class="font-weight-bold"><?= format_date_indonesia(date('Y-m-d')).', '.date('d-m-Y'); ?></span></h5>
                                    <br>
                                    <div class="table-responsive">
                                        <table class="display table table-striped table-bordered table-sm" id="tbl-absensi" style="width:100%">
                                            <colgroup>
                                                <col style="width: 5%">
                                                <col style="width: 20%">
                                                <col style="width: 20%">
                                                <col style="width: 10%">
                                                <col style="width: 10%">
                                                <col style="width: 20%">
                                                <col style="width: 10%">
                                            </colgroup>
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Anak</th>
                                                    <th>Umur</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th>Status</th>
                                                    <th>Keterangan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                             <tbody>
                                                <?php $i = 1;
                                                foreach ($hasil_checkup as $key =>$row) { ?>
                                                    <tr>
                                                        <td align="center"><?= $i; ?></td>
                                                        <td><b><?= $row->nama_anak; ?></b>&nbsp;<span class="font-italic">(<?= $row->nama_kelas; ?>)</span></td>
                                                        <td align="center" class="text-muted font-italic"><?= hitung_usia($row->tanggal_lahir) ?></td>
                                                        <td align="center"><?= $row->jenis_kelamin == 'L'? 'Laki - Laki':'Perempuan' ?></td>
                                                        <td align="center"><?= empty($row->rinci) ? '<div class="badge badge-danger">Belum Chekup</div>':'<div class="badge badge-success">Sudah Chekup</div>' ?></td>
                                                        <td class="text-muted font-italic text-small"><?= empty($row->keterangan) ? '<center>-</center>':$row->keterangan ?></td>
                                                        <td align="center" nowrap>
                                                            <button class="btn btn-sm btn-icon btn-success edit" type="button" data-id="<?= $row->id; ?>"><span class="fas fa-eye-dropper"></span>&nbsp;Data Checkup</button>
                                                        </td>
                                                    </tr>

                                                <?php $i++; } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <p class="font-italic float-right"><span class="fas fa-info-circle"></span>&nbsp;<span class="text-muted" style="font-size: 11px">Pencatatan medical checkup anak <b>otomatis</b> akan tercatat pada hari dimana <b>data diinputkan</b> oleh medic</span></p>
                                </div>
                            </div>
                        </div>
                        <!-- end of col-->
                    </div>
                    <!-- end of main-content -->
                </div><!-- Footer Start -->
                <form action="<?= $controller.'/checkAktivitas' ?>" id="frm_lihatdetail" method="POST">
                    <input type="hidden" name="id_anak" id="id_anak">
                    <input type="hidden" name="tanggal" value="<?= date('Y-m-d'); ?>" >
                </form>
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
            $('.edit').click(function(){
                let id = $(this).data('id');

                $('#id_anak').val(id);
                $('#frm_lihatdetail').submit();
            });
        });
    </script>
</html>


                                                                
                                                                    
                                                                
                                                            