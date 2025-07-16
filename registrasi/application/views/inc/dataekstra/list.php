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
                            <li><a href="#">Ekstrakulikuler</a></li>
                            <li><?= $title ?></li>
                        </ul>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12 mb-4">
                            <div class="card text-left">
                                <div class="card-body">
                                    <button class="btn btn-info m-1 mb-4 add-button" type="button" data-toggle="modal" data-target="#adding-modal">Tambah</button>
                                    <div class="table-responsive">
                                        <table class="display table table-striped table-bordered" id="tbl" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <!-- <th>#</th> -->
                                                    <th style="width: 5%">No</th>
                                                    <th style="width: 45%">Nama Ekstrakulikuler</th>
                                                    <th style="width: 20%">Pengampu</th>
                                                    <th style="width: 20%">Keterangan</th>
                                                    <th style="width: 10%">Action</th>
                                                </tr>
                                            </thead>
                                             <tbody>
                                                <?php 
                                                $i = 1 ;
                                                foreach ($list_ekstra as $key =>$row) { ?>
                                                    <tr>
                                                        <td align="center"><?= $key+1 ?></td>
                                                        <td style="vertical-align: middle">
                                                            <b><?= $row->nama ?></b>
                                                        </td>
                                                        <td align="center">
                                                            <select class="form-control" onchange="ubahPengampu(this, '<?= $row->id_ekstra ?>')">
                                                                <option value="0" <?= empty($row->pengampu)? 'selected':''; ?> >Tidak ada pengampu</option>
                                                                <?php foreach ($list_pengampu as $kel){ ?>
                                                                    <option value="<?= $kel->id ?>" <?= $row->pengampu == $kel->id? 'selected':''; ?>><?= $kel->name ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <span class="font-italic text-muted text-small"><?= $row->keterangan ?></span>
                                                        </td>
                                                        <td align="center">
                                                            <div class="d-flex align-items-center justify-content-center">
                                                                <a href="<?= base_url().$redirect.'/edit/'.$row->id_ekstra ?>" class="btn btn-sm btn-success"><span class="fas fa-eye"></span> Lihat Data</a>
                                                                &nbsp;
                                                                <button class="btn btn-outline-danger btn-sm btn-icon delete" type="button" data-id="<?= $row->id_ekstra; ?>">
                                                                        <span class="ul-btn__icon">
                                                                            <i class="i-Close-Window"></i>
                                                                        </span>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <p class="font-italic float-right"><span class="fas fa-info-circle"></span>&nbsp;<span class="text-muted" style="font-size: 11px">Ekstrakulikuler bisa digunakan pada <b>kelas KB/TK</b> dan <b>hanya guru ekstra saja</b> yang bisa mencatat sesuai pengampu ekstra.</span></p>
                                </div>
                            </div>
                        </div>
                        <!-- end of col-->
                    </div>
                    <!-- end of main-content -->
                </div><!-- Footer Start -->

                <!--  Modal -->
                <div class="modal fade" id="adding-modal" tabindex="-1" role="dialog" aria-labelledby="adding" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <?php echo form_open_multipart($controller.'/insert','id="frm_tambahtemplate"'); ?>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Penambahan Data Ekstrakulikuler</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">                                   
                                    <fieldset>
                                        <div class="form-group">
                                            <label>Nama Ekstrakulikuler</label>
                                            <input type="text" class="form-control" required name="nama_ekstra" id="nama_ekstra" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label>Keterangan</label>
                                            <textarea name="keterangan" id="keterangan" cols="30" rows="10" class="form-control"></textarea>
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
                <!--  Modal -->
                <?php echo form_open_multipart($controller.'/updatepengampu', 'id="frm_ubahstatus"'); ?>
                    <input type="hidden" name="id_ekstra" id="id_ekstra" required>
                    <input type="hidden" name="id_pengampu" id="id_pengampu" required>
                </form>
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
            $("#frm_tambahtemplate").validate({
                rules: {
                    nama_ekstra: {
                        required: true
                    }
                },
                messages: {
                    nama_ekstra: {
                        required: "Nama Ekstrakulikuler harus diisi!"
                    }
                },
                submitHandler: function (form) {
                    form.submit(); // Mengirimkan form jika validasi lolos
                }
            });

            $('.delete').click(function () {
                var id = $(this).data('id') ;
                swal({
                    title: 'Apakah yakin data ini ingin di hapus? ',
                    showCancelButton: true,
                    confirmButtonColor: '#4caf50',
                    cancelButtonColor: '#f44336',
                    confirmButtonText: 'Ya, Lanjutkan hapus!',
                    cancelButtonText: 'Batal',
                }).then(function () {
                    window.location = url + '/delete/' + id ;
                })
            });
        });

        function ubahPengampu(dom, id_ekstra){
            if(confirm('Apakah anda yakin untuk mengubah pengampu ekstra ini?')){
                let id_pengampu = $(dom).val();

                $('#id_ekstra').val(id_ekstra);
                $('#id_pengampu').val(id_pengampu);
                $('#frm_ubahstatus').submit();
            }
        }
    </script>
</html>