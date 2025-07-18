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
                            <li><a href="#">Kebutuhan Anak</a></li>
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
                                                <label>Tanggal</label>
                                            </td>
                                            <td>
                                                <input type="date" class="form-control" name="tanggal" value="<?= $tanggal ?>" onchange="this.form.submit()" required>
                                            </td>
                                        </tr>
                                    </table>
                                    </form>
                                    <br><br>
                                    <div class="row mb-3 align-items-center">
                                        <div class="col-6">
                                            <h5 class="mb-0">Catatan Kebutuhan Anak Hari&nbsp;<span><?= format_date_indonesia($tanggal).', '.date('d-m-Y', strtotime($tanggal)); ?></span></h5>
                                        </div>
                                        <div class="col-6  text-right">
                                            <button class="btn btn-info m-1 mb-4 add-button" type="button" data-toggle="modal" data-target="#adding-modal"><span class="fa fa-add"></span>&nbsp;Catat Kebutuhan</button>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="display table table-sm table-striped table-bordered">
                                            <colgroup>
                                                <col style="width: 5%">
                                                <col style="width: 20%">
                                                <col style="width: 15%">
                                                <col style="width: 15%">
                                                <col style="width: 15%">
                                                <col style="width: 15%">
                                                <col style="width: 10%">
                                            </colgroup>
                                            <thead style="background-color: #bfdfff">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Anak</th>
                                                    <th>Umur</th>
                                                    <th>Jenis Kebutuhan</th>
                                                    <th>Pencatat</th>
                                                    <th>Keterangan</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                             <tbody>
                                             <?php if (count($tambahan_makanan) > 0){ ?>
                                                <?php $i = 1;
                                                foreach ($tambahan_makanan as $key =>$row) { ?>
                                                    <tr>
                                                        <td align="center"><?= $i; ?></td>
                                                        <td><b><?= $row->nama_anak; ?></b>&nbsp;<span class="font-italic">(<?= $row->nama_kelas; ?>)</span></td>
                                                        <td align="center" class="text-muted font-italic"><?= hitung_usia($row->tanggal_lahir) ?></td>
                                                        <td align="center"><?= $row->nama_jeniskebutuhan ?></td>
                                                        <td><b><?= $row->nama_educator; ?></b>&nbsp;<span class="font-italic">(<?= $row->created_at; ?>)</span></td>
                                                        <td class="text-muted font-italic text-small"><?= empty($row->keterangan) ? '<center>-</center>':$row->keterangan ?></td>
                                                        <td align="center" nowrap>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="status<?= $row->id_kebutuhan ?>" onchange="ubahStatus('<?= $row->id_kebutuhan ?>', 1)" id="inlineRadio1<?= $row->id_kebutuhan ?>" value="1" <?= $row->is_valid == 1 && !is_null($row->is_valid)? 'checked':''; ?> >
                                                                <label class="form-check-label" for="inlineRadio1">Valid</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="status<?= $row->id_kebutuhan ?>" onchange="ubahStatus('<?= $row->id_kebutuhan ?>', 0)" id="inlineRadio2<?= $row->id_kebutuhan ?>" value="0" <?= $row->is_valid != 1 && !is_null($row->is_valid)? 'checked':''; ?>>
                                                                <label class="form-check-label" for="inlineRadio2">Tidak Valid</label>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                <?php $i++; } ?>
                                             <?php }else{ ?>
                                                 <tr>
                                                     <td align="center" colspan="7">Data Kosong!</td>
                                                 </tr>
                                             <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <p class="font-italic float-right"><span class="fas fa-info-circle"></span>&nbsp;<span class="text-muted" style="font-size: 11px">Pengasuh bisa mengubah <b>status</b> valid atau tidak datanya</span></p>
                                </div>
                            </div>
                        </div>
                        <!-- end of col-->
                    </div>
                    <!-- end of main-content -->
                </div><!-- Footer Start -->
                <!--  Modal -->
                <?php $this->load->view('layout/footer') ?>

                <div class="modal fade" id="adding-modal" tabindex="-1" role="dialog" aria-labelledby="adding" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <?php echo form_open_multipart($controller.'/simpancatatan','id="frm_tambahtemplate"'); ?>
                        <input type="hidden" name="tanggal" required value="<?= $tanggal ?>">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Catat Kebutuhan Anak</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <fieldset>
                                    <div class="form-group">
                                        <label>Pilih Anak</label>
                                        <select name="anak" id="anak" class="form-control" required>
                                            <option value="" selected disabled>-- Pilih Anak --</option>
                                            <?php foreach ($list_anak as $anak){ ?>
                                                <option value="<?= $anak->id ?>"><?= $anak->nama ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Pilih Jenis Kebutuhan</label>
                                        <select name="jenis_kebutuhan" id="jenis_kebutuhan" class="form-control" required>
                                            <option value="" selected disabled>-- Pilih Jenis Kebutuhan --</option>
                                            <?php foreach ($list_jeniskebutuhan as $anak){ ?>
                                                <option value="<?= $anak->id_jeniskebutuhan ?>"><?= $anak->nama ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Keterangan</label>
                                        <textarea name="keterangan" id="keterangan" cols="30" rows="10" class="form-control" required></textarea>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                <button class="btn btn-primary ml-2" type="submit">Simpan</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>

    <?php echo form_open_multipart($controller.'/updatestatus', 'id="frm_ubahstatus"'); ?>
    <input type="hidden" name="id_kebutuhan" id="id_kebutuhan" required>
    <input type="hidden" name="status" id="status" required>
    </form>

    <?php $this->load->view('layout/custom') ?>
    <script src="<?= base_url().'dist-assets/'?>js/plugins/datatables.min.js"></script>
    <script src="<?= base_url().'dist-assets/'?>js/scripts/datatables.script.min.js"></script>
    <script type="text/javascript">
        var url = "<?= base_url().$controller ?>";

        $(document).ready(function() {
            $('#anak').select2();
        });

        function ubahStatus(id, status){
            $('#id_kebutuhan').val(id);
            $('#status').val(status);
            $('#frm_ubahstatus').submit();
        }
    </script>
</html>


                                                                
                                                                    
                                                                
                                                            