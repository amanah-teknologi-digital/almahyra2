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
                                    <h5 class="card-title mb-1 d-flex align-items-center justify-content-center">Absensi Anak Hari&nbsp;<span class="font-weight-bold"><?= format_date_indonesia(date('Y-m-d')).', '.date('d-m-Y'); ?></span></h5>
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
                                                            <?php if (empty($row->id_absennow) OR !empty($row->waktu_checkoutnow)) { ?>
                                                                <?php if (!empty($row->waktu_checkoutnow) && date('Y-m-d', strtotime($row->tanggal_checkoutnow)) == date('Y-m-d')) { ?>
                                                                    <div class="font-italic" style="font-size: 12px;">
                                                                        Absen masuk pada tgl <?= format_date_indonesia(date($row->tanggal_now)).', '.date('d-m-Y', strtotime($row->tanggal_now)); ?> jam <b><?= $row->waktu_checkinnow ?></b>
                                                                        , Absen pulang pada tgl <?= format_date_indonesia(date($row->tanggal_checkoutnow)).', '.date('d-m-Y', strtotime($row->tanggal_checkoutnow)); ?> jam <b><?= $row->waktu_checkoutnow ?></b>
                                                                        <br>
                                                                        <center><span class="text-info font-italic font-weight-bold">Durasi : <?= hitung_durasi_waktu(date('Y-m-d', strtotime($row->tanggal_now)).' '.$row->waktu_checkinnow, date('Y-m-d', strtotime($row->tanggal_checkoutnow)).' '.$row->waktu_checkoutnow); ?></span></center>
                                                                    </div>
                                                                    <hr>
                                                                <?php } ?>
                                                                <?php if (empty($row->id_absensi)) { ?>
                                                                    <div align="center">
                                                                        <span class="badge badge-danger">Belum Absen</span>
                                                                    </div>
                                                                <?php } else { ?>
                                                                    <div class="font-italic" style="font-size: 12px;">
                                                                        Absen masuk pada <b><?= $row->waktu_checkin ?></b>
                                                                        <?php if (!empty($row->waktu_checkout)){ ?>
                                                                            , Absen pulang pada <b><?= $row->waktu_checkout ?></b>
                                                                            <br>
                                                                            <center><span class="text-info font-italic font-weight-bold">Durasi : <?= hitung_durasi_waktu($row->waktu_checkin, $row->waktu_checkout); ?></span></center>
                                                                        <?php }else{ ?>
                                                                            <br>
                                                                            <center><span align="center" class="badge badge-warning">Belum Absen Pulang</span></center>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } ?>
                                                            <?php }else{ ?>
                                                                <div class="font-italic" style="font-size: 12px;">
                                                                    Absen masuk pada tgl <?= format_date_indonesia(date($row->tanggal_now)).', '.date('d-m-Y', strtotime($row->tanggal_now)); ?> jam <b><?= $row->waktu_checkinnow ?></b>
                                                                    <br>
                                                                    <center><span align="center" class="badge badge-warning">Belum Absen Pulang</span></center>
                                                                </div>
                                                            <?php } ?>
                                                        </td>
                                                        <td align="center" nowrap>
                                                            <?php if (empty($row->id_absennow) OR !empty($row->waktu_checkoutnow)) { ?>
                                                                <button class="btn btn-outline-success btn-sm btn-icon edit" type="button" data-id="<?= $row->id; ?>" data-nama="<?= $row->nama_anak ?>" data-kelas="<?= $row->nama_kelas ?>" >
                                                                    <span class="fas fa-eye-dropper"></span>&nbsp;Absen
                                                                </button>
                                                            <?php }else{ ?>
                                                                <button class="btn btn-outline-success btn-sm btn-icon edit" type="button" data-id="<?= $row->id; ?>" data-nama="<?= $row->nama_anak ?>" data-kelas="<?= $row->nama_kelas ?>" data-idabsennow="<?= $row->id_absennow ?>">
                                                                    <span class="fas fa-eye-dropper"></span>&nbsp;Absen
                                                                </button>
                                                            <?php } ?>
                                                            <?php if (!empty($row->waktu_checkin) && empty($row->waktu_checkout) && $this->session->userdata['auth']->id_role == 1){ ?>
                                                                <button class="btn btn-outline-danger btn-sm btn-icon resetmasuk" type="button" data-id="<?= $row->id; ?>" data-nama="<?= $row->nama_anak ?>" data-kelas="<?= $row->nama_kelas ?>" >
                                                                    <span class="fas fa-window-close"></span>&nbsp;Reset Masuk
                                                                </button>
                                                            <?php } ?>
                                                            <?php if (!empty($row->waktu_checkout) && $this->session->userdata['auth']->id_role == 1){ ?>
                                                            <button class="btn btn-outline-danger btn-sm btn-icon resetpulang" type="button" data-id="<?= $row->id; ?>" data-nama="<?= $row->nama_anak ?>" data-kelas="<?= $row->nama_kelas ?>" >
                                                                <span class="fas fa-window-close"></span>&nbsp;Reset Pulang
                                                            </button>
                                                            <?php } ?>
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

                <!--  Modal -->
                <div class="modal fade" id="updating-modal" tabindex="-1" role="dialog" aria-labelledby="updating" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Absensi Hari <span class="font-weight-bold" id="label_hari_absen"><?= format_date_indonesia(date('Y-m-d')).', '.date('d-m-Y'); ?></span>&nbsp;a.n.&nbsp;<b class="text-success" id="label_namaanak"></b>&nbsp;<span id="label_namakelas" class="text-muted font-italic"></span></h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <?php echo form_open_multipart($controller.'/absenmasuk','id="frm_absenmasuk"'); ?>
                                    <h5 class="text-success"><span class="fas fa-right-to-bracket"></span>&nbsp;Absen Masuk</h5>
                                    <fieldset>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Kondisi Masuk</label>
                                                    <select class="form-control" name="kondisi" id="kodisi_masuk" required>
                                                        <option value="1">Sehat</option>
                                                        <option value="2">Kurang Sehat</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Suhu Masuk</label>
                                                    <input class="form-control" type="text" name="suhu" id="suhu_masuk" autocomplete="off" placeholder="36.5 (Gunakan titik untuk koma)">
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div id="info_absen_masuk"></div>
                                    <button class="btn btn-sm btn-success" id="btn_absenmasuk" type="submit"><span class="fas fa-save"></span>&nbsp;Absen Masuk</button>
                                <input type="hidden" name="id_anak" id="id_anakmasuk">
                                </form>
                                <?php echo form_open_multipart($controller.'/absenpulang', 'id="frm_absenpulang"'); ?>
                                    <div id="form_absen_pulang" style="display: none;">
                                        <input type="hidden" name="id_absennow" id="id_absennow">
                                        <hr>
                                        <h5 class="text-danger"><span class="fas fa-right-from-bracket"></span>&nbsp;Absen Pulang</h5>
                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Kondisi Pulang</label>
                                                        <select class="form-control" name="kondisi" id="kondisi_pulang" required>
                                                            <option value="1">Sehat</option>
                                                            <option value="2">Kurang Sehat</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Suhu Pulang</label>
                                                        <input class="form-control" type="text" name="suhu" id="suhu_pulang" autocomplete="off" placeholder="36.5 (Gunakan titik untuk koma)">
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <div id="info_absen_pulang"></div>
                                        <button class="btn btn-sm btn-danger" id="btn_absenpulang" type="submit"><span class="fas fa-save"></span>&nbsp;Absen Pulang</button>
                                    </div>
                                <input type="hidden" name="id_anak" id="id_anakpulang">
                                </form>
                                <div class="modal-footer mt-5">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="reset-modal" tabindex="-1" role="dialog" aria-labelledby="updating" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Absensi Hari <span class="font-weight-bold"><?= format_date_indonesia(date('Y-m-d')).', '.date('d-m-Y'); ?></span>&nbsp;a.n.&nbsp;<b class="text-success" id="label_namaanak_reset"></b>&nbsp;<span id="label_namakelas_reset" class="text-muted font-italic"></span></h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <?php echo form_open_multipart($controller.'/resetpulang','id="frm_resetpulang"'); ?>
                                <p class="text-muted">Apakah yakin reset jam pulang anak ini?</p>

                                <input type="hidden" name="id_anak" id="id_anakreset">
                                <button class="btn btn-sm btn-danger" type="submit"><span class="fas fa-window-close"></span>&nbsp;Reset Absen Pulang</button>
                                </form>
                                <div class="modal-footer mt-5">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="reset-modalmasuk" tabindex="-1" role="dialog" aria-labelledby="updating" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Absensi Hari <span class="font-weight-bold"><?= format_date_indonesia(date('Y-m-d')).', '.date('d-m-Y'); ?></span>&nbsp;a.n.&nbsp;<b class="text-success" id="label_namaanak_resetmasuk"></b>&nbsp;<span id="label_namakelas_resetmasuk" class="text-muted font-italic"></span></h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <?php echo form_open_multipart($controller.'/resetmasuk','id="frm_resetmasuk"'); ?>
                                <p class="text-muted">Apakah yakin reset jam masuk anak ini?</p>

                                <input type="hidden" name="id_anak" id="id_anakresetmasuk">
                                <button class="btn btn-sm btn-danger" type="submit"><span class="fas fa-window-close"></span>&nbsp;Reset Absen Masuk</button>
                                </form>
                                <div class="modal-footer mt-5">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </div>
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
        var url = "<?= base_url().$controller ?>";
        var role = "<?= $this->session->userdata['auth']->id_role ?>";

        $(document).ready(function() {
            $('#tbl-absensi').dataTable({
                "ordering": false,
                "searching": true,
                "paging": false
            });

            $.validator.addMethod("decimal", function(value, element) {
                // Regular expression for decimal values (including optional negative sign)
                return this.optional(element) || /^-?\d+(\.\d+)?$/.test(value);
            }, "Please enter a valid decimal number.");

            $("#frm_absenmasuk").validate({
                rules: {
                    suhu: {
                        required: true,
                        decimal: true
                    }
                },
                messages: {
                    suhu: {
                        required: "Suhu anak harus diisi!",
                        decimal: "Suhu harus berupa desimal!"
                    }
                },
                submitHandler: function(form) {
                    form.submit(); // Mengirimkan form jika validasi lolos
                }
            });

            $("#frm_absenpulang").validate({
                rules: {
                    suhu: {
                        required: true,
                        decimal: true
                    }
                },
                messages: {
                    suhu: {
                        required: "Suhu anak harus diisi!",
                        decimal: "Suhu harus berupa desimal!"
                    }
                },
                submitHandler: function(form) {
                    form.submit(); // Mengirimkan form jika validasi lolos
                }
            });

            $('.edit').click(function(){
                clearFormStatus('#frm_absenmasuk');
                clearFormStatus('#frm_absenpulang');

                var id_anak = $(this).data('id') ;
                var nama_anak = $(this).data('nama') ;
                var nama_kelas = $(this).data('kelas') ;
                var id_absennow = $(this).data('idabsennow') ;

                if (id_absennow === undefined) {
                    $("#id_absennow").val('');
                    $.ajax({
                        url: url + '/edit/' + $(this).data('id'),
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            resetForm();
                            $("#id_anak").val(id_anak);
                            $("#label_namaanak").html(nama_anak);
                            $("#label_namakelas").html('(' + nama_kelas + ')');
                            $("#label_hari_absen").html(data['tgl_absen']);

                            $("#id_anakmasuk").val(id_anak);
                            $("#id_anakpulang").val(id_anak);

                            if (data.id_absensi == null) {
                                $('#form_absen_pulang').hide();
                                $('#kodisi_masuk').prop('disabled', false);
                                $('#suhu_masuk').prop('disabled', false);
                                $('#kondisi_pulang').prop('disabled', true);
                                $('#suhu_pulang').prop('disabled', true);
                                $('#btn_absenmasuk').show();
                                $('#btn_absenpulang').hide();
                            } else {
                                $('#kodisi_masuk').val(data.kondisi);
                                $('#suhu_masuk').val(data.suhu);
                                $('#btn_absenmasuk').hide();
                                $('#kodisi_masuk').prop('disabled', true);
                                $('#suhu_masuk').prop('disabled', true);
                                $('#form_absen_pulang').show();
                                $('#info_absen_masuk').html('<div class="text-small font-italic"><span class="fas fa-circle-info"></span>&nbsp;Anak sudah absen <b>masuk</b> pada <b>' + data.waktu_checkin + '</b>' + ' oleh ' + '<i>' + data.nama_user + ' (' + data.nama_role + ')' + '</i>' + '</div>');

                                if (data.waktu_checkout != null) {
                                    $('#kondisi_pulang').val(data.kondisi_checkout);
                                    $('#suhu_pulang').val(data.suhu_checkout);
                                    $('#info_absen_pulang').html('<div class="text-small font-italic"><span class="fas fa-circle-info"></span>&nbsp;Anak sudah absen <b>pulang</b> pada <b>' + data.waktu_checkout + '</b>' + ' oleh ' + '<i>' + data.nama_user2 + ' (' + data.nama_role2 + ')' + '</i>' + '</div>');
                                    $('#suhu_pulang').prop('disabled', true);
                                    $('#btn_absenpulang').hide();
                                } else {
                                    $('#kondisi_pulang').prop('disabled', false);
                                    $('#suhu_pulang').prop('disabled', false);
                                    $('#btn_absenpulang').show();
                                }
                            }

                            $("#updating-modal").modal('show');
                        }
                    });
                }else{
                    $("#id_absennow").val(id_absennow);
                    $.ajax({
                        url: url + '/editAbsenLama/' + id_absennow,
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            resetForm();
                            $("#id_anak").val(id_anak);
                            $("#label_namaanak").html(nama_anak);
                            $("#label_namakelas").html('(' + nama_kelas + ')');
                            $("#label_hari_absen").html(data['tgl_absen']);

                            $("#id_anakmasuk").val(id_anak);
                            $("#id_anakpulang").val(id_anak);

                            $('#kodisi_masuk').val(data.kondisi);
                            $('#suhu_masuk').val(data.suhu);
                            $('#btn_absenmasuk').hide();
                            $('#kodisi_masuk').prop('disabled', true);
                            $('#suhu_masuk').prop('disabled', true);
                            $('#form_absen_pulang').show();
                            $('#info_absen_masuk').html('<div class="text-small font-italic"><span class="fas fa-circle-info"></span>&nbsp;Anak sudah absen <b>masuk</b> pada <b>' + data.waktu_checkin + '</b>' + ' oleh ' + '<i>' + data.nama_user + ' (' + data.nama_role + ')' + '</i>' + '</div>');
                            $('#kondisi_pulang').prop('disabled', false);
                            $('#suhu_pulang').prop('disabled', false);
                            $('#btn_absenpulang').show();

                            $("#updating-modal").modal('show');
                        }
                    });
                }
            });

            $('.resetpulang').click(function(){
                var id_anak = $(this).data('id') ;
                var nama_anak = $(this).data('nama') ;
                var nama_kelas = $(this).data('kelas') ;

                $("#id_anakreset").val(id_anak);
                $("#label_namaanak_reset").html(nama_anak);
                $("#label_namakelas_reset").html('('+nama_kelas+')');

                $("#reset-modal").modal('show');
            })

            $('.resetmasuk').click(function(){
                var id_anak = $(this).data('id') ;
                var nama_anak = $(this).data('nama') ;
                var nama_kelas = $(this).data('kelas') ;

                $("#id_anakresetmasuk").val(id_anak);
                $("#label_namaanak_resetmasuk").html(nama_anak);
                $("#label_namakelas_resetmasuk").html('('+nama_kelas+')');

                $("#reset-modalmasuk").modal('show');
            })
        });

        function resetForm(){
            $('#kodisi_masuk').val(1);
            $('#kondisi_pulang').val(1);
            $('#suhu_masuk').val('');
            $('#suhu_pulang').val('');
            $('#id_anakmasuk').val('');
            $('#id_anakpulang').val('');
            $('#form_absen_pulang').hide();
            $('#info_absen_masuk').html('');
            $('#info_absen_pulang').html('');
            $('#btn_absenmasuk').hide();
            $('#btn_absenpulang').hide();

            $('#kodisi_masuk').prop('disabled', false);
            $('#suhu_masuk').prop('disabled', false);
            $('#kondisi_pulang').prop('disabled', true);
            $('#suhu_pulang').prop('disabled', true);
        }

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


                                                                
                                                                    
                                                                
                                                            