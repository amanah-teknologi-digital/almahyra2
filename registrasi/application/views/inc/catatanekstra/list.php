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
                            <li><a href="#">Ekstrakulikuler</a></li>
                            <li><?= $title ?></li>
                        </ul>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12 mb-4">
                            <div class="card text-left">
                                <div class="card-body">
                                    <?php echo form_open_multipart($controller); ?>
                                        <table style="width: 100%;padding: 10px 10px;">
                                            <colgroup>
                                                <col style="width: 20%">
                                                <col style="width: 80%">
                                            </colgroup>
                                            <tr>
                                                <td>
                                                    <label>Tanggal Ekstrakulikuler</label>
                                                </td>
                                                <td>
                                                    <input type="date" class="form-control" name="tanggal" value="<?= $tanggal ?>" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label>List Ekstrakulikuler</label>
                                                </td>
                                                <td>
                                                    <select class="form-control" id="ekstra" name="ekstra" required">
                                                    <?php foreach ($list_ekstra as $key => $value) { ?>
                                                        <option value="<?= $value->id_ekstra ?>" <?= $ekstra == $value->id_ekstra ? 'selected' : '' ?>><?= $value->nama ?></option>
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
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h5 class="card-title text-center">Catatan Ekstrakulikuler <b><?= $nama_ekstra ?></b> Hari&nbsp;<span><?= format_date_indonesia($tanggal).', '.date('d-m-Y', strtotime($tanggal)); ?></span></h5>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="table-responsive">
                                        <table class="display table table-striped table-bordered table-sm" id="tbl-catat" style="width:100%">
                                            <colgroup>
                                                <col style="width: 5%">
                                                <col style="width: 20%">
                                                <col style="width: 15%">
                                                <col style="width: 10%">
                                                <col style="width: 10%">
                                                <col style="width: 10%">
                                                <col style="width: 15%">
                                                <col style="width: 10%">
                                            </colgroup>
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Anak</th>
                                                    <th>Umur</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th>Status</th>
                                                    <th>Nilai</th>
                                                    <th>Keterangan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                             <tbody>
                                             <?php if (!empty($ekstra)){ ?>
                                                 <?php $i = 1;
                                                 foreach ($hasil_catatan as $key =>$row) { ?>
                                                     <tr>
                                                         <td align="center"><?= $i; ?></td>
                                                         <td><b><?= $row->nama_anak; ?></b>&nbsp;<span class="font-italic">(<?= $row->nama_kelas; ?>)</span></td>
                                                         <td align="center" class="text-muted font-italic"><?= hitung_usia($row->tanggal_lahir) ?></td>
                                                         <td align="center"><?= $row->jenis_kelamin == 'L'? 'Laki - Laki':'Perempuan' ?></td>
                                                         <td align="center"><?= empty($row->is_catat) ? '<div class="badge badge-danger">Belum Dicatat</div>':'<div class="badge badge-success">Sudah Dicatat</div>' ?></td>
                                                         <td class="text-success font-weight-bold text-small text-center"><?= empty($row->is_catat) ? '<center class="text-black-50">-</center>':$row->nilai ?></td>
                                                         <td class="text-muted font-italic text-small"><?= empty($row->keterangan) ? '<center>-</center>':$row->keterangan ?></td>
                                                         <td align="center" nowrap>
                                                             <button class="btn btn-sm btn-icon btn-success edit" type="button" data-id="<?= $row->id; ?>"><span class="fas fa-eye-dropper"></span>&nbsp;Data Ekstra</button>
                                                         </td>
                                                     </tr>

                                                     <?php $i++; } ?>
                                             <?php }else{ ?>
                                                 <tr>
                                                        <td colspan="8" class="text-center text-muted font-italic">Tidak ada data catatan ekstra pada tanggal ini</td>
                                                 </tr>
                                             <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <p class="font-italic float-right"><span class="fas fa-info-circle"></span>&nbsp;<span class="text-muted" style="font-size: 11px">Guru Ekstra yang mencatat anak <b>otomatis</b> akan tercatat pada system</span></p>
                                </div>
                            </div>
                        </div>
                        <!-- end of col-->
                    </div>
                    <!-- end of main-content -->
                </div><!-- Footer Start -->
                <form action="<?= $controller.'/checkAktivitas' ?>" id="frm_lihatdetail" method="POST">
                    <input type="hidden" name="id_anak" id="id_anak">
                    <input type="hidden" name="tanggal" value="<?= $tanggal ?>" >
                    <input type="hidden" name="ekstra" value="<?= $ekstra ?>" >
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


                                                                
                                                                    
                                                                
                                                            