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
                            <li><a href="#">Rencana Belajar</a></li>
                            <li><a href="#"><?= $title ?></a></li>
                            <li>Data Template Harian</li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="<?= base_url().$redirect ?>" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Kembali</a>
                            <div class="card text-left">
                                <div class="card-body">
                                    <h5 class="card-title d-flex align-items-center justify-content-center">Data Template Jadwal Harian&nbsp;<span class="text-success font-weight-bold"><?= $data_template->nama ?></span></h5>
                                    <div class="row mb-3 d-flex align-items-center justify-content-center">
                                        <div class="col-sm-12">
                                            <button class="btn btn-sm btn-primary btn-tambahkegiatan float-right" ><span class="fas fa-plus"></span>&nbsp;Tambah Jadwal</button>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="display table table-sm table-striped table-bordered">
                                            <thead style="background-color: #bfdfff">
                                            <tr>
                                                <th align="center">No</th>
                                                <th align="center">Jam</th>
                                                <th align="center">Kegiatan</th>
                                                <th align="center">Keterangan</th>
                                                <th align="center" style="width: 20%">Aksi</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php if (count($data_jadwal_template) > 0){
                                                foreach ($data_jadwal_template as $key => $kegiatan){ ?>
                                                    <tr>
                                                        <td align="center"><?= $key+1; ?></td>
                                                        <td align="center"><?= Date('H:i',strtotime($kegiatan->jam_mulai)).' - '.Date('H:i',strtotime($kegiatan->jam_selesai)) ?></td>
                                                        <td><?= $kegiatan->uraian; ?></td>
                                                        <td><span class="text-muted font-italic text-small"><?= $kegiatan->keterangan; ?></span></td>
                                                        <td align="center">
                                                            <span class="btn btn-sm btn-warning edit_kegiatan" data-id="<?= $kegiatan->id_kegiatan ?>" data-nama="<?= $kegiatan->uraian  ?>"><span class="fas fa-edit"></span>&nbsp;Update</span>
                                                            <span class="btn btn-sm btn-danger hapus_kegiatan" data-id="<?= $kegiatan->id_kegiatan ?>" data-nama="<?= $kegiatan->uraian  ?>"><span class="fas fa-times"></span>&nbsp;Hapus</span>
                                                        </td>
                                                    </tr>
                                                <?php }
                                            }else{ ?>
                                                <tr>
                                                    <td colspan="6" align="center"><span class="font-weight-bold text-danger text-small"><i>Data Jadwal Kosong!</i></span></td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <p class="font-italic float-right mt-5"><span class="fas fa-info-circle"></span>&nbsp;<span class="text-muted" style="font-size: 11px">Template bisa <b>diubah</b> sesuai kebutuhan yang nantinya bisa dipasangkan ke <b>jadwal harian</b> masing - masing kelas.</span></p>
                                </div>
                            </div>
                        </div>
                        <!-- end of col-->
                    </div>
                    <!-- end of main-content -->
                </div><!-- Footer Start -->
                <?php $this->load->view('layout/footer') ?>
                <!--  Modal -->
                <div class="modal fade" id="tambah-kegitan" tabindex="-1" role="dialog" aria-labelledby="adding" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <?php echo form_open_multipart($controller.'/insertkegiatan', 'id="frm_tambahkegiatan"'); ?>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Jadwal Kegiatan</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <fieldset>
                                    <div class="form-group">
                                        <label>Jam Mulai</label>
                                        <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label>Jam Selesai</label>
                                        <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Kegiatan</label>
                                        <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label>Keterangan <i>(Optional)</i></label>
                                        <textarea class="form-control" name="keterangan" id="keterangan" cols="30" rows="5" autocomplete="off"></textarea>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                <button class="btn btn-primary ml-2" type="submit">Simpan</button>
                            </div>
                        </div>
                        <input type="hidden" name="id_templatejadwal" value="<?= $id_templatejadwal ?>">
                        </form>
                    </div>
                </div>
                <div class="modal fade" id="update-kegitan" tabindex="-1" role="dialog" aria-labelledby="adding" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <?php echo form_open_multipart($controller.'/updatekegiatan', 'id="frm_updatekegiatan"'); ?>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Pembaharuan Jadwal Kegiatan</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <fieldset>
                                    <div class="form-group">
                                        <label>Jam Mulai</label>
                                        <input type="time" name="jam_mulai" id="jam_mulai_update" class="form-control" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label>Jam Selesai</label>
                                        <input type="time" name="jam_selesai" id="jam_selesai_update" class="form-control" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Kegiatan</label>
                                        <input type="text" name="nama_kegiatan" id="nama_kegiatan_update" class="form-control" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label>Keterangan <i>(Optional)</i></label>
                                        <textarea class="form-control" name="keterangan" id="keterangan_update" cols="30" rows="5" autocomplete="off"></textarea>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                <button class="btn btn-primary ml-2" type="submit">Simpan</button>
                            </div>
                        </div>
                        <input type="hidden" name="id_kegiatan" id="id_kegiatan">
                        <input type="hidden" name="id_templatejadwal" value="<?= $id_templatejadwal ?>">
                        </form>
                    </div>
                </div>
                <div class="modal fade" id="hapus-kegiatan" tabindex="-1" role="dialog" aria-labelledby="adding" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <?php echo form_open_multipart($controller.'/hapuskegiatan', 'id="frm_hapuskegiatan"'); ?>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Hapus Jadwal Kegiatan</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <p>Apakah yakin menghapus kegiatan <span class="font-weight-bold" id="label_nama_kegiatan_hapus"></span>? </p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                <button class="btn btn-danger ml-2" type="submit">Hapus</button>
                            </div>
                        </div>
                        <input type="hidden" name="id_kegiatan" id="id_kegiatan_hapus">
                        <input type="hidden" name="id_templatejadwal" value="<?= $id_templatejadwal ?>">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <?php $this->load->view('layout/custom') ?>
    <script src="<?= base_url().'dist-assets/'?>js/plugins/datatables.min.js"></script>
    <script src="<?= base_url().'dist-assets/'?>js/scripts/datatables.script.min.js"></script>
    <script type="text/javascript">
        let url = "<?= base_url().$controller ?>";

        $(document).ready(function() {
            $('.btn-tambahkegiatan').click(function(){
                clearFormStatus("#frm_tambahkegiatan");

                let nama_kelas = $(this).data('nama')
                let nama_tema = $(this).data('namatema')
                let id_kelas = $(this).data('idkelas')

                $("#label_nama_subtema_tambah").html(nama_tema);
                $("#label_namakelas_tambah").html(nama_kelas);
                $("#id_kelas_tambah").val(id_kelas);

                $("#tambah-kegitan").modal('show');
            });

            $('.edit_kegiatan').click(function(){
                clearFormStatus('#frm_updatekegiatan')

                let id_kegiatan = $(this).data('id')

                $("#id_kegiatan").val(id_kegiatan);

                $.ajax({
                    url: url + '/editkegiatan/' + $(this).data('id'),
                    type:'GET',
                    dataType: 'json',
                    success: function(data){
                        let data_kegiatan = data['list_edit'];

                        $("#jam_mulai_update").val(data_kegiatan['jam_mulai']);
                        $("#jam_selesai_update").val(data_kegiatan['jam_selesai']);
                        $("#nama_kegiatan_update").val(data_kegiatan['uraian']);
                        $("#keterangan_update").val(data_kegiatan['keterangan']);

                        $("#update-kegitan").modal('show');
                    }
                });
            });

            $('.hapus_kegiatan').click(function(){
                clearFormStatus("#frm_hapuskegiatan");

                let nama_kegiatan = $(this).data('nama')
                let id_kegiatan = $(this).data('id')

                $("#label_nama_kegiatan_hapus").html(nama_kegiatan);
                $("#id_kegiatan_hapus").val(id_kegiatan);

                $("#hapus-kegiatan").modal('show');
            });

            $("#frm_tambahkegiatan").validate({
                rules: {
                    jam_mulai: {
                        required: true
                    },
                    jam_selesai: {
                        required: true
                    },
                    nama_kegiatan: {
                        required: true
                    }
                },
                messages: {
                    jam_mulai: {
                        required: "Jam mulai harus diisi!"
                    },
                    jam_selesai: {
                        required: "Jam selesai harus diisi!"
                    },
                    nama_kegiatan: {
                        required: "Nama Kegiatan harus diisi!"
                    }
                },
                submitHandler: function(form) {
                    form.submit(); // Mengirimkan form jika validasi lolos
                }
            });

            $("#frm_updatekegiatan").validate({
                rules: {
                    jam_mulai: {
                        required: true
                    },
                    jam_selesai: {
                        required: true
                    },
                    nama_kegiatan: {
                        required: true
                    }
                },
                messages: {
                    jam_mulai: {
                        required: "Jam mulai harus diisi!"
                    },
                    jam_selesai: {
                        required: "Jam selesai harus diisi!"
                    },
                    nama_kegiatan: {
                        required: "Nama Kegiatan harus diisi!"
                    }
                },
                submitHandler: function(form) {
                    form.submit(); // Mengirimkan form jika validasi lolos
                }
            });
        });

        function clearFormStatus(formId) {
            // Reset the form values
            $(formId)[0].reset();

            // Clear validation messages and error/success classes
            $(formId).find('.valid').removeClass('valid'); // Remove valid class
            $(formId).find('label.error').remove(); // Remove error messages
            $(formId).find('.error').removeClass('error'); // Remove error class
        }
    </script>
</html>