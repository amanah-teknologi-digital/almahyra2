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
                            <li><a href="#">Data Tematik</a></li>
                            <li>Jadwal Harian</li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="<?= base_url().$redirect.'/'.$tahun_tematik ?>" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Kembali</a>
                            <div class="card text-left">
                                <div class="card-body">
                                    <h5 class="card-title d-flex align-items-center justify-content-center">Data Jadwal Harian untuk Sub Tema&nbsp;<span class="text-success"><?= $data_subtema->nama ?></span>&nbsp;pada Hari&nbsp;<span class="font-weight-bold"><?= format_date_indonesia($data_rincianjadwal_mingguan->tanggal).', '.date('d-m-Y', strtotime($data_rincianjadwal_mingguan->tanggal)); ?></span></h5>
                                    <br>
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <?php foreach ($data_kelas as $key => $kelas){
                                            if ($key == 0){
                                                if (empty($active_tab_kelas)) {
                                                    $active_tab_kelas = $kelas->id_kelas;
                                                }
                                            } ?>
                                            <li class="nav-item"><a class="nav-link <?= $active_tab_kelas==$kelas->id_kelas ?'active':''; ?>" data-toggle="tab" href="#tab<?= $kelas->id_kelas ?>" role="tab"><?= $kelas->nama ?></a></li>
                                        <?php } ?>
                                    </ul>

                                    <div class="tab-content" id="myTabContent">
                                        <?php foreach ($data_kelas as $key => $kelas){ ?>
                                            <div class="tab-pane fade show <?= $active_tab_kelas==$kelas->id_kelas ?'active':''; ?>" id="tab<?= $kelas->id_kelas ?>" role="tabpanel">
                                                <div class="card-body shadow">
                                                    <h5 class="card-title"><b>Jadwal Harian</b></h5>
                                                    <?php echo form_open_multipart('', 'id="frm_gettemplate_jadwal'.$kelas->id_kelas.'"'); ?>
                                                        <div class="row mb-3 d-flex align-items-center justify-content-center">
                                                            <div class="col-sm-4">
                                                                <select name="template_jadwal" class="form-control">
                                                                    <option value="">-- Pilih Template Jadwal --</option>
                                                                    <?php foreach ($data_template_jadwal as $template){ ?>
                                                                        <option value="<?= $template->id_templatejadwal ?>"><?= $template->nama ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <button class="btn btn-sm btn-warning btn-tambahbytemplate" data-idkelas="<?= $kelas->id_kelas ?>"><span class="fas fa-plus"></span>&nbsp;Ambil dari Template Jadwal</button>
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <span class="btn btn-sm btn-primary btn-tambahkegiatan float-right" data-namatema="<?= $data_subtema->nama ?>" data-nama="<?= $kelas->nama  ?>" data-idkelas="<?= $kelas->id_kelas ?>"><span class="fas fa-plus"></span>&nbsp;Tambah Jadwal</span>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <div class="table-responsive" id="zero_configuration_table<?= $kelas->id_kelas ?>">
                                                        <i class="text-muted" style="font-size: 11px"><b>note:</b> <span>* Jika tambah dari template, jadwal yang sudah ada akan dihapus!</span></i>
                                                        <table class="display table table-sm table-striped table-bordered">
                                                            <thead style="background-color: #bfdfff">
                                                                <tr>
                                                                    <th align="center">No</th>
                                                                    <th align="center">Jam</th>
                                                                    <th align="center">Kegiatan</th>
                                                                    <th align="center">Keterangan</th>
                                                                    <th align="center">Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php if (isset($data_jadwal_harian[$kelas->id_kelas])){
                                                                    foreach ($data_jadwal_harian[$kelas->id_kelas] as $key => $kegiatan){ ?>
                                                                        <tr>
                                                                            <td align="center"><?= $key+1; ?></td>
                                                                            <td align="center"><?= Date('H:i',strtotime($kegiatan->jam_mulai)).' - '.Date('H:i',strtotime($kegiatan->jam_selesai)) ?></td>
                                                                            <td><?= $kegiatan->uraian; ?></td>
                                                                            <td><span class="text-muted font-italic text-small"><?= $kegiatan->keterangan; ?></span></td>
                                                                            <td align="center">
                                                                                <span class="btn btn-sm btn-warning edit_kegiatan" data-idkelas="<?= $kelas->id_kelas ?>" data-id="<?= $kegiatan->id_rincianjadwal_harian ?>" data-namatema="<?= $data_subtema->nama ?>" data-nama="<?= $kelas->nama  ?>"><span class="fas fa-edit"></span>&nbsp;Update</span>
                                                                                <span class="btn btn-sm btn-danger hapus_kegiatan" data-idkelas="<?= $kelas->id_kelas ?>" data-id="<?= $kegiatan->id_rincianjadwal_harian ?>" data-namatema="<?= $data_subtema->nama ?>" data-nama="<?= $kelas->nama  ?>" data-namakegiatan="<?= $kegiatan->uraian ?>"><span class="fas fa-times"></span>&nbsp;Hapus</span>
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
                                                    <div class="table-responsive d-none"  id="preview_fromtemplate<?= $kelas->id_kelas ?>">

                                                    </div>
                                                </div>
                                                <br>
                                                <div class="card-body shadow">
                                                    <h5 class="card-title"><b>Data Stimulus</b></h5>
                                                    <?php echo form_open_multipart('', 'id="frm_gettemplate_stimulus'.$kelas->id_kelas.'"'); ?>
                                                        <div class="row mb-3 d-flex align-items-center justify-content-center">
                                                            <div class="col-sm-4">
                                                                <select name="template_stimulus" class="form-control">
                                                                    <option value="">-- Pilih Template Stimulus --</option>
                                                                    <?php foreach ($data_template_stimulus as $template){ ?>
                                                                        <option value="<?= $template->id_templatestimulus ?>"><?= $template->nama_template ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <button class="btn btn-sm btn-warning btn-tambahbytemplate_stimulus"><span class="fas fa-plus"></span>&nbsp;Ambil Template Stimulus</button>
                                                            </div>
                                                            <div class="col-sm-5"></div>
                                                        </div>
                                                    </form>
                                                    <i class="text-muted" style="font-size: 11px"><b>note:</b> <span>* Jika tambah dari template, data stimulus yang sudah ada akan direplace!</span></i>
                                                    <?php echo form_open_multipart($controller.'/simpanstimulus', 'id="frm_simpanstimulus'.$kelas->id_kelas.'"'); ?>
                                                        <fieldset>
                                                            <div class="form-group">
                                                                <label>Nama Tema Stimulus</label>
                                                                <input type="text" name="nama_tema_stimulus" id="nama_tema_stimulus<?= $kelas->id_kelas ?>" class="form-control" autocomplete="off" value="<?= isset($data_jadwal_stimulus[$kelas->id_kelas])? $data_jadwal_stimulus[$kelas->id_kelas]->nama:'';  ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Uraian Kegiatan Stimulus</label>
                                                                <div id="editor<?= $kelas->id_kelas ?>" style="height: 200px;">
                                                                    <?= isset($data_jadwal_stimulus[$kelas->id_kelas])? $data_jadwal_stimulus[$kelas->id_kelas]->rincian_kegiatan:'';  ?>
                                                                </div>
                                                                <input type="hidden" name="editorContent" id="editorContent<?= $kelas->id_kelas ?>" data-editor-index="<?= $kelas->id_kelas ?>" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Keterangan <i>(Optional)</i></label>
                                                                <textarea class="form-control" name="keterangan" id="keterangan<?= $kelas->id_kelas ?>" cols="30" rows="5" autocomplete="off"><?= isset($data_jadwal_stimulus[$kelas->id_kelas])? $data_jadwal_stimulus[$kelas->id_kelas]->keterangan:'';  ?></textarea>
                                                            </div>
                                                        </fieldset>
                                                        <button class="btn btn-sm btn-success"><span class="fas fa-save"></span>&nbsp;Simpan Data Stimulus</button>
                                                        <input type="hidden" name="id_kelas" value="<?= $kelas->id_kelas; ?>">
                                                        <input type="hidden" name="id_rincianjadwal_mingguan" value="<?= $id_rincianjadwal_mingguan ?>">
                                                        <input type="hidden" name="tahun_penentuan" value="<?= $tahun_tematik ?>">
                                                    </form>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <p class="font-italic float-right mt-5"><span class="fas fa-info-circle"></span>&nbsp;<span class="text-muted" style="font-size: 11px">Jadwal harian dan stimulus bisa ditambahkan secara <b>manual</b> atau <b>otomatis dari template harian</b> untuk <b>masing-masing kelas</b>.</span></p>
                                </div>
                            </div>
                        </div>
                        <!-- end of col-->
                    </div>
                    <!-- end of main-content -->
                </div><!-- Footer Start -->

                <div class="modal fade" id="tambah-kegitan" tabindex="-1" role="dialog" aria-labelledby="adding" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <?php echo form_open_multipart($controller.'/insertkegiatan', 'id="frm_tambahkegiatan"'); ?>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Jadwal Kegiatan Sub Tema <span class="text-success" id="label_nama_subtema_tambah"></span></h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <fieldset>
                                    <div class="form-group">
                                        <label>Nama Kelas</label>
                                        <p class="font-weight-bold" id="label_namakelas_tambah"></p>
                                    </div>
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
                        <input type="hidden" name="id_kelas" id="id_kelas_tambah">
                        <input type="hidden" name="id_rincianjadwal_mingguan" value="<?= $id_rincianjadwal_mingguan ?>">
                        <input type="hidden" name="tahun_penentuan" value="<?= $tahun_tematik ?>">
                        </form>
                    </div>
                </div>
                <div class="modal fade" id="update-kegitan" tabindex="-1" role="dialog" aria-labelledby="adding" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <?php echo form_open_multipart($controller.'/updatekegiatan', 'id="frm_updatekegiatan"'); ?>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Pembaharuan Jadwal Kegiatan Sub Tema <span class="text-success" id="label_nama_subtema_update"></span></h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <fieldset>
                                    <div class="form-group">
                                        <label>Nama Kelas</label>
                                        <p class="font-weight-bold" id="label_namakelas_update"></p>
                                    </div>
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
                        <input type="hidden" name="id_kelas" id="id_kelas_update">
                        <input type="hidden" name="id_rincianjadwal_harian" id="id_rincianjadwal_harian">
                        <input type="hidden" name="id_rincianjadwal_mingguan" value="<?= $id_rincianjadwal_mingguan ?>">
                        <input type="hidden" name="tahun_penentuan" value="<?= $tahun_tematik ?>">
                        </form>
                    </div>
                </div>
                <div class="modal fade" id="hapus-kegiatan" tabindex="-1" role="dialog" aria-labelledby="adding" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <?php echo form_open_multipart($controller.'/hapuskegiatan', 'id="frm_hapuskegiatan"'); ?>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Hapus Jadwal Kegiatan Sub Tema <span class="text-success" id="label_nama_subtema_hapus"></span></h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <p>Apakah yakin menghapus kegiatan <span class="font-weight-bold" id="label_nama_kegiatan_hapus"></span> pada kelas <span class="font-weight-bold" id="label_nama_kelas_hapus"></span>? </p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                <button class="btn btn-danger ml-2" type="submit">Hapus</button>
                            </div>
                        </div>
                        <input type="hidden" name="id_kelas" id="id_kelas_hapus">
                        <input type="hidden" name="id_rincianjadwal_harian" id="id_rincianjadwal_harian_hapus">
                        <input type="hidden" name="id_rincianjadwal_mingguan" value="<?= $id_rincianjadwal_mingguan ?>">
                        <input type="hidden" name="tahun_penentuan" value="<?= $tahun_tematik ?>">
                        </form>
                    </div>
                </div>
                <!--  Modal -->
                <?php $this->load->view('layout/footer') ?>
            </div>
        </div>
    </body>
    <?php $this->load->view('layout/custom') ?>
    <script src="<?= base_url().'dist-assets/'?>js/plugins/datatables.min.js"></script>
    <script src="<?= base_url().'dist-assets/'?>js/scripts/datatables.script.min.js"></script>
    <script type="text/javascript">
        let url = "<?= base_url().$controller ?>";
        let lis_kelas = <?= json_encode($data_kelas) ?>;
        let quill = [];
        $(document).ready(function() {
            $.each(lis_kelas, function(index, value){
                quill[value.id_kelas] =
                    new Quill('#editor'+value.id_kelas, {
                        theme: 'snow',  // You can also choose 'bubble'
                        modules: {
                            toolbar: [
                                [{ 'header': '1'}, {'header': '2'}, { 'font': [] }],
                                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                ['bold', 'italic', 'underline'],
                                [{ 'align': [] }],
                                ['link'],
                                ['image'],
                                ['blockquote']
                            ]
                        }
                    });
            });

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

                let nama_kelas = $(this).data('nama')
                let nama_tema = $(this).data('namatema')
                let id_rincianjadwal_harian = $(this).data('id')
                let id_kelas = $(this).data('idkelas')

                $("#label_nama_subtema_update").html(nama_tema);
                $("#label_namakelas_update").html(nama_kelas);
                $("#id_rincianjadwal_harian").val(id_rincianjadwal_harian);
                $("#id_kelas_update").val(id_kelas);

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

                let nama_kelas = $(this).data('nama')
                let nama_kegiatan = $(this).data('namakegiatan')
                let nama_tema = $(this).data('namatema')
                let id_rincianjadwal_harian = $(this).data('id')
                let id_kelas = $(this).data('idkelas')

                $("#label_nama_subtema_hapus").html(nama_tema);
                $("#label_nama_kegiatan_hapus").html(nama_kegiatan);
                $("#label_nama_kelas_hapus").html(nama_kelas);
                $("#id_rincianjadwal_harian_hapus").val(id_rincianjadwal_harian);
                $("#id_kelas_hapus").val(id_kelas);

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

            $.each(lis_kelas, function(index, value){
                $("#frm_simpanstimulus"+value.id_kelas).validate({
                    rules: {
                        nama_tema_stimulus:{
                            required: true
                        }
                    },
                    messages: {
                        nama_tema_stimulus: {
                            required: "Nama Tema Stimulus harus diisi!"
                        }
                    },
                    submitHandler: function(form, event) {
                        let content = quill[value.id_kelas].getText().trim();
                        let htmlcontent = quill[value.id_kelas].root.innerHTML;

                        if (htmlcontent === "<p><br></p>" || content === ""){
                            alert('Uraian Kegiatan Stimulus harus diisi!');
                            event.preventDefault();  // Prevent form submission
                            return false;  // Prevent default action
                        }

                        $('#editorContent'+value.id_kelas).val(htmlcontent);
                        form.submit(); // Mengirimkan form jika validasi lolos
                    }
                });
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

            $.each(lis_kelas, function(index, value){
                $("#frm_gettemplate_jadwal"+value.id_kelas).validate({
                    rules: {
                        template_jadwal: {
                            required: true
                        }
                    },
                    messages: {
                        template_jadwal: {
                            required: "Template jadwal harian harus dipilih!"
                        }
                    },
                    submitHandler: function(form) {
                        console.log(value.id_kelas);
                        //form.submit(); // Mengirimkan form jika validasi lolos
                    }
                });
            });

            $.each(lis_kelas, function(index, value){
                $("#frm_gettemplate_stimulus"+value.id_kelas).validate({
                    rules: {
                        template_stimulus: {
                            required: true
                        }
                    },
                    messages: {
                        template_stimulus: {
                            required: "Template stimulus harus dipilih!"
                        }
                    },
                    submitHandler: function(form) {
                        console.log(value.id_kelas);
                        //form.submit(); // Mengirimkan form jika validasi lolos
                    }
                });
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