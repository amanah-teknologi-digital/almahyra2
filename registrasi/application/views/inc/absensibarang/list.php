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
                            <li><a href="#">Absensi</a></li>
                            <li><?= $title ?></li>
                        </ul>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12 mb-4">
                            <div class="card text-left">
                                <div class="card-body">
                                    <h5 class="card-title mb-1 d-flex align-items-center justify-content-center">Absensi Barang Hari&nbsp;<span class="font-weight-bold"><?= format_date_indonesia(date('Y-m-d')).', '.date('d-m-Y'); ?></span></h5>
                                    <br>
                                    <div class="table-responsive">
                                        <table class="display table table-striped table-bordered" id="tbl-absensi" style="width:100%">
                                            <colgroup>
                                                <col style="width: 5%">
                                                <col style="width: 40%">
                                                <col style="width: 15%">
                                                <col style="width: 30%">
                                                <col style="width: 10%">
                                            </colgroup>
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama</th>
                                                    <th>Asal</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                             <tbody>
                                                <?php $i = 1;
                                                foreach ($list as $key =>$row) { ?>
                                                    <tr>
                                                        <td align="center"><?= $i; ?></td>
                                                        <td nowrap><b><?= ucwords($row->nama_anak) ?></b>&nbsp;<span class="text-muted font-italic">(<?= $row->nama_kelas ?>)</span><br>
                                                            <span class="text-small font-italic text-success font-weight-bold"><?= hitung_usia($row->tanggal_lahir) ?></span>
                                                        </td>
                                                        <td align="center"><?= ucwords($row->tempat_lahir) ?></td>
                                                        <td nowrap>
                                                            <?php if (empty($row->is_input)) { ?>
                                                                <div align="center">
                                                                    <span class="badge badge-danger">Belum Input</span>
                                                                </div>
                                                            <?php } else { ?>
                                                                <?php if (empty($row->is_aprove)){ ?>
                                                                    <div align="center">
                                                                        <span class="badge badge-warning">Belum Disetujui</span>
                                                                    </div>
                                                                <?php }else{ ?>
                                                                    <div align="center">
                                                                        <span class="badge badge-warning">Belum Disetujui</span>
                                                                    </div>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </td>
                                                        <td align="center">
                                                            <button class="btn btn-outline-success btn-sm btn-icon edit" type="button" data-id="<?= $row->id; ?>" data-nama="<?= $row->nama_anak ?>" data-kelas="<?= $row->nama_kelas ?>" >
                                                                <span class="fas fa-eye-dropper"></span>&nbsp;Catat Barang
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php $i++; } ?>
                                            </tbody>
                                        </table>
                                    </div>
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
        var role = "<?= $this->session->userdata['auth']->id_role ?>";

        $(document).ready(function() {
            $('#tbl-absensi').dataTable({
                "ordering": false,
                "searching": true,
                "paging": false
            });

            $('.edit').click(function(){
                let id = $(this).data('id');

                $('#id_anak').val(id);
                $('#frm_lihatdetail').submit();
            });
        });
    </script>
</html>


                                                                
                                                                    
                                                                
                                                            