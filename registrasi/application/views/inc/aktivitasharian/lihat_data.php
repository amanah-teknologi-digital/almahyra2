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
                            <li><a href="#">Absensi</a></li>
                            <li><a href="#"><?= $title ?></a></li>
                            <li>Data Harian</li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="<?= base_url().$redirect ?>" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Kembali</a>
                            <div class="card text-left">
                                <div class="card-body">
                                    <h5 class="card-title mb-1 d-flex align-items-center justify-content-center">Hasil Belajar Aktivitas Harian ananda&nbsp;<span class="text-success font-weight-bold"><?= $data_anak->nama ?></span></h5>
                                    <span class="d-flex align-items-center justify-content-center text-muted font-italic font-weight-bold">Usia:&nbsp;<span class="text-info"><?= hitung_usia_histori($data_anak->tanggal_lahir, $data_anak->tanggal_aktivitas) ?> <span class="text-muted">(<?= $data_anak->nama_kelas ?>)</span></span></span>
                                    <p class="font-italic float-right mt-5"><span class="fas fa-info-circle"></span>&nbsp;<span class="text-muted" style="font-size: 11px">Lengkapi data-data aktivitas sesuai jadwal kegiatan yang diberikan.</span></p>
                                </div>
                            </div>
                        </div>
                        <!-- end of col-->
                    </div>
                    <!-- end of main-content -->
                </div><!-- Footer Start -->
                <!--  Modal -->
                <?php $this->load->view('layout/footer') ?>
                <!--  Modal -->
                <div class="modal fade" id="adding-modal" tabindex="-1" role="dialog" aria-labelledby="adding" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <?php echo form_open_multipart($controller.'/insert', 'id="frm_tambah"'); ?>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Penentuan Tema Bulan <span class="text-success" id="label_nama_bulan"></span></h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <fieldset>
                                    <div class="form-group">
                                        <label>Uraian Tema</label>
                                        <input class="form-control" type="text" required name="nama_tema" id="nama_tema_penentuan" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label>Keterangan <i>(Optional)</i></label>
                                        <textarea class="form-control" name="keterangan" id="keterangan_penentuan" cols="30" rows="5" autocomplete="off"></textarea>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                <button class="btn btn-primary ml-2" type="submit">Simpan</button>
                            </div>
                        </div>
                        <input type="hidden" name="bulan_penentuan" id="bulan_penentuan">
                        <input type="hidden" name="tahun_penentuan" id="tahun_penentuan" value="<?= $tahun_tematik ?>">
                        </form>
                    </div>
                </div>

                <div class="modal fade" id="updating-modal" tabindex="-1" role="dialog" aria-labelledby="updating" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <?php echo form_open_multipart($controller.'/update', 'id="frm_update"'); ?>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Pembaharuan Penentuan Tema Bulan <span class="text-success" id="label_nama_bulan_update"></span></h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <fieldset>
                                    <div class="form-group">
                                        <label>Uraian Tema</label>
                                        <input class="form-control" type="text" required name="nama_tema" id="nama_tema_update" autocomplete="off">
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
                        <input type="hidden" name="id_temabulanan" id="id_temabulanan" required>
                        <input type="hidden" name="tahun_penentuan" id="tahun_update" value="<?= $tahun_tematik ?>">
                        </form>
                    </div>
                </div>

                <div class="modal fade" id="tambah-subtema" tabindex="-1" role="dialog" aria-labelledby="adding" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <?php echo form_open_multipart($controller.'/insertsubtema', 'id="frm_tambahsubtema"'); ?>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Sub Tema Bulan <span class="text-success" id="label_nama_bulansubtema"></span></h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <fieldset>
                                    <div class="form-group">
                                        <label>Tema</label>
                                        <p><b id="label_nama_tema"></b></p>
                                    </div>
                                    <div class="form-group">
                                        <label>Sub Tema</label>
                                        <input class="form-control" type="text" required name="nama_subtema" id="nama_subtema" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label>Keterangan <i>(Optional)</i></label>
                                        <textarea class="form-control" name="keterangan" id="keterangan_subtema" cols="30" rows="5" autocomplete="off"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Pelaksanaan</label>
                                        <input type="text" name="tanggal_pelaksanaan" id="tanggal_pelaksanaan" class="form-control" required autocomplete="off">
                                    </div>

                                </fieldset>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                <button class="btn btn-primary ml-2" type="submit">Simpan</button>
                            </div>
                        </div>
                        <input type="hidden" name="id_temabulanan" id="id_temabulanan_subtema">
                        <input type="hidden" name="tahun_penentuan" value="<?= $tahun_tematik ?>">
                        </form>
                    </div>
                </div>
                <div class="modal fade" id="edit-subtema" tabindex="-1" role="dialog" aria-labelledby="adding" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <?php echo form_open_multipart($controller.'/updatesubtema', 'id="frm_updatesubtema"'); ?>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Pembaharuan Sub Tema Bulan <span class="text-success" id="label_nama_bulansubtema_update"></span></h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <fieldset>
                                    <div class="form-group">
                                        <label>Tema</label>
                                        <p><b id="label_nama_tema_update"></b></p>
                                    </div>
                                    <div class="form-group">
                                        <label>Sub Tema</label>
                                        <input class="form-control" type="text" required name="nama_subtema" id="nama_subtema_update" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label>Keterangan <i>(Optional)</i></label>
                                        <textarea class="form-control" name="keterangan" id="keterangan_subtema_update" cols="30" rows="5" autocomplete="off"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Pelaksanaan</label>
                                        <input type="text" name="tanggal_pelaksanaan" id="tanggal_pelaksanaan_update" class="form-control" required autocomplete="off">
                                    </div>

                                </fieldset>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                <button class="btn btn-primary ml-2" type="submit">Simpan</button>
                            </div>
                        </div>
                        <input type="hidden" name="id_jadwalmingguan" id="id_jadwalmingguan">
                        <input type="hidden" name="tahun_penentuan" value="<?= $tahun_tematik ?>">
                        </form>
                    </div>
                </div>
                <div class="modal fade" id="hapus-subtema" tabindex="-1" role="dialog" aria-labelledby="adding" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <?php echo form_open_multipart($controller.'/hapussubtema', 'id="frm_hapussubtema"'); ?>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Hapus Sub Tema Bulan <span class="text-success" id="label_nama_bulansubtema_hapus"></span></h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <p>Apakah yakin menghapus sub tema <span class="font-weight-bold" id="label_nama_tema_hapus"></span> beserta detail data tanggal? </p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                <button class="btn btn-danger ml-2" type="submit">Hapus</button>
                            </div>
                        </div>
                        <input type="hidden" name="id_jadwalmingguan" id="id_jadwalmingguan_hapus">
                        <input type="hidden" name="tahun_penentuan" value="<?= $tahun_tematik ?>">
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
        let tanggal_selected = <?= json_encode($data_tanggal_disabled); ?>;
        let bulan_active_accordion = <?= $active_accordion_bulan; ?>;
        let arr_tanggal_noneditable = [];

        $(document).ready(function() {
            $('#accordion-item-icon-right-'+bulan_active_accordion).addClass('show'); // Make the first item expand

            $('#tanggal_pelaksanaan').datepicker(
                {
                    format: 'yyyy-mm-dd',
                    multidate: true, // This enables multiple date selection,
                    datesDisabled: tanggal_selected
                }
            );

            $('#tanggal_pelaksanaan_update').datepicker(
                {
                    format: 'yyyy-mm-dd',
                    multidate: true, // This enables multiple date selection,
                }
            );

            $('#tanggal_pelaksanaan_update').datepicker().on('changeDate', function(e) {
                selectedDates = $('#tanggal_pelaksanaan_update').data('datepicker').getFormattedDate('yyyy-mm-dd');
                let selected = selectedDates.split(',');
                let result = arr_tanggal_noneditable.filter(item => !selected.includes(item));

                if (result.length > 0) {
                    e.preventDefault(); // Prevent unselecting the date if it's already selected
                    alert('Tanggal sudah diinput jadwal harian.');
                    selected = $.merge(selected, arr_tanggal_noneditable);
                    $('#tanggal_pelaksanaan_update').datepicker('setDates', selected);
                }
            });

            $("#frm_tambah").validate({
                rules: {
                    nama_tema: {
                        required: true
                    }
                },
                messages: {
                    nama_tema: {
                        required: "Uraian tema harus diisi!"
                    }
                },
                submitHandler: function(form) {
                    form.submit(); // Mengirimkan form jika validasi lolos
                }
            });

            $("#frm_update").validate({
                rules: {
                    nama_tema: {
                        required: true
                    }
                },
                messages: {
                    nama_tema: {
                        required: "Uraian tema harus diisi!"
                    }
                },
                submitHandler: function(form) {
                    form.submit(); // Mengirimkan form jika validasi lolos
                }
            });

            $.validator.addMethod('dateCount', function(value, element) {
                return value.split(',').length > 0; // Ensures at least one date is selected
            }, 'Please select at least one date.');

            $("#frm_tambahsubtema").validate({
                rules: {
                    nama_subtema: {
                        required: true
                    },
                    tanggal_pelaksanaan: {
                        required: true,
                        dateCount: true     // Ensure that at least one date is selected
                    }
                },
                messages: {
                    nama_subtema: {
                        required: "Sub tema harus diisi!"
                    },
                    tanggal_pelaksanaan: {
                        required: "Tanggal pelaksanaan harus diisi!",
                        dateCount: "Pilih minimal satu tanggal!"
                    }
                },
                submitHandler: function(form) {
                    form.submit(); // Mengirimkan form jika validasi lolos
                }
            });

            $("#frm_updatesubtema").validate({
                rules: {
                    nama_subtema_update: {
                        required: true
                    },
                    tanggal_pelaksanaan_update: {
                        required: true,
                        dateCount: true     // Ensure that at least one date is selected
                    }
                },
                messages: {
                    nama_subtema_update: {
                        required: "Sub tema harus diisi!"
                    },
                    tanggal_pelaksanaan_update: {
                        required: "Tanggal pelaksanaan harus diisi!",
                        dateCount: "Pilih minimal satu tanggal!"
                    }
                },
                submitHandler: function(form) {
                    form.submit(); // Mengirimkan form jika validasi lolos
                }
            });
        });

        $('.tentukan_tema').click(function(){
            clearFormStatus("#frm_tambah");

            let bulan = $(this).data('id')
            let nama_bulan = $(this).data('nama')

            $("#label_nama_bulan").html(nama_bulan);
            $("#bulan_penentuan").val(bulan);
            $("#adding-modal").modal('show');
        });

        $('.btn-tambahsubtema').click(function(){
            clearFormStatus("#frm_tambahsubtema");
            $('#tanggal_pelaksanaan').datepicker('update', '');

            let id_temabulanan = $(this).data('id')
            let nama_bulan = $(this).data('nama')
            let nama_tema = $(this).data('namatema')

            $("#label_nama_bulansubtema").html(nama_bulan);
            $("#id_temabulanan_subtema").val(id_temabulanan);
            $("#label_nama_tema").html(nama_tema);

            $("#tambah-subtema").modal('show');
        });

        $('.hapus_subtema').click(function(){
            clearFormStatus("#frm_hapussubtema");

            let id_jadwalmingguan = $(this).data('id')
            let nama_bulan = $(this).data('nama')
            let nama_tema = $(this).data('namatema')

            $("#label_nama_bulansubtema_hapus").html(nama_bulan);
            $("#id_jadwalmingguan_hapus").val(id_jadwalmingguan);
            $("#label_nama_tema_hapus").html(nama_tema);

            $("#hapus-subtema").modal('show');
        });

        $('.edit_tema').click(function(){
            clearFormStatus('#frm_update')

            let nama_bulan = $(this).data('nama')
            $("#label_nama_bulan_update").html(nama_bulan);
            $.ajax({
                url: url + '/edit/' + $(this).data('id'),
                type:'GET',
                dataType: 'json',
                success: function(data){

                    $("#id_temabulanan").val(data['list_edit']['id_temabulanan']);
                    $("#nama_tema_update").val(data['list_edit']['nama']);
                    $("#keterangan_update").val(data['list_edit']['deskripsi']);

                    $("#updating-modal").modal('show');
                }
            });
        })

        $('.edit_subtema').click(function(){
            clearFormStatus('#frm_updatesubtema')
            $('#tanggal_pelaksanaan_update').datepicker('update', '');
            arr_tanggal_noneditable = [];

            let id_jadwalmingguan = $(this).data('id')
            let nama_bulan = $(this).data('nama')
            let nama_tema = $(this).data('namatema')

            $("#label_nama_bulansubtema_update").html(nama_bulan);
            $("#label_nama_tema_update").html(nama_tema);
            $("#id_jadwalmingguan").val(id_jadwalmingguan);

            $.ajax({
                url: url + '/editsubtema/' + $(this).data('id'),
                type:'GET',
                dataType: 'json',
                success: function(data){
                    let data_jadwal_disabled = data['data_tanggal_disabled'];
                    let list_jadwal_editable = data['list_jadwal_editable'];
                    let list_jadwal_noneditable = data['list_jadwal_noneditable'];
                    list_jadwal_editable = $.merge(list_jadwal_editable, list_jadwal_noneditable);

                    arr_tanggal_noneditable = list_jadwal_noneditable;

                    $("#nama_subtema_update").val(data['list_edit']['nama']);
                    $("#keterangan_subtema_update").val(data['list_edit']['keterangan']);

                    $('#tanggal_pelaksanaan_update').datepicker('setDatesDisabled', data_jadwal_disabled);
                    $('#tanggal_pelaksanaan_update').datepicker('setDates', list_jadwal_editable);

                    $("#edit-subtema").modal('show');
                }
            });
        })

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