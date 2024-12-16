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
                                    <h5 class="card-title mb-1 d-flex align-items-center justify-content-center">Absensi Educator Hari&nbsp;<span class="font-weight-bold"><?= format_date_indonesia(date('Y-m-d')).', '.date('d-m-Y'); ?></span></h5>
                                    <br>
                                    <div class="table-responsive">
                                        <?php echo form_open_multipart($controller, 'id="frm_filter"'); ?>
                                        <table style="width: 100%;padding: 10px 10px;">
                                            <colgroup>
                                                <col style="width: 20%">
                                                <col style="width: 80%">
                                            </colgroup>
                                            <tr>
                                                <td>
                                                    <label>Nama Educator</label>
                                                </td>
                                                <td>
                                                    <select class="form-control select2" id="educator" name="educator" onchange="submitForm()">
                                                        <?php if (count($list_educator) > 1){ ?>
                                                            <option value="" selected>-- Pilih Educator --</option>
                                                        <?php } ?>
                                                        <?php foreach ($list_educator as $key => $value) { ?>
                                                            <option value="<?= $value->id ?>" <?= $educator == $value->id ? 'selected' : '' ?>><?= $value->name ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                        </form>
                                        <hr>
                                        <?php if (!empty($educator)){ ?>
                                            <h5 class="mb-3 d-flex justify-content-between align-items-center">
                                                <button class="btn btn-success" type="button" data-toggle="modal" data-target="#absen-masuk" <?= !empty($status_absen)? 'disabled':''; ?>>
                                                    <span class="fas fa-plus"></span>&nbsp;Absen
                                                </button>
                                            </h5>
                                            <table class="display table table-striped table-bordered table-sm" style="width:100%">
                                                <colgroup>
                                                    <col style="width: 15%">
                                                    <col style="width: 15%">
                                                    <col style="width: 15%">
                                                    <col style="width: 20%">
                                                    <col style="width: 25%">
                                                    <col style="width: 10%">
                                                </colgroup>
                                                <thead>
                                                    <tr>
                                                        <th>Jenis Absensi</th>
                                                        <th>Waktu Masuk</th>
                                                        <th>Waktu Pulang</th>
                                                        <th>Status</th>
                                                        <th>Keterangan</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                 <tbody>
                                                    <?php $i = 1;
                                                    foreach ($absensi as $key =>$row) { ?>
                                                        <tr>
                                                            <td align="center" nowrap><b><?= $row->jenis_absen; ?></b>
                                                            <?php if (!empty($row->id_jenislembur)){ ?>
                                                                <br>
                                                                <span class="badge badge-primary">Lembur</span>
                                                            <?php } ?>
                                                            </td>
                                                            <td align="center" nowrap class="text-muted"><b><?= $row->waktu_checkin ?></b></td>
                                                            <td align="center" nowrap class="text-muted"><b><?= !empty($row->waktu_checkout)? $row->waktu_checkout:'-'; ?></b></td>
                                                            <td nowrap align="center">
                                                                <?php if (!empty($row->waktu_checkout)){ ?>
                                                                    <span class="text-info text-small font-italic font-weight-bold">Durasi : <?= hitungDurasiDalamMenit($row->waktu_checkin, $row->waktu_checkout); ?> Menit</span>
                                                                <?php }else{ ?>
                                                                    <span class="badge badge-warning">Belum Absen Pulang</span>
                                                                <?php } ?>
                                                            </td>
                                                            <td style="font-size: 11px;">
                                                                <?php if (!empty($row->id_jenislembur)){ ?>
                                                                    <i>Jenis Lembur : </i><b><?= $row->jenis_lembur; ?></b>
                                                                    <br>
                                                                    <i>Ket: </i>
                                                                    <span class="text-muted font-italic" style="font-size: 11px;"><?= !empty($row->keterangan)? $row->keterangan:'-'; ?></span>
                                                                <?php } ?>
                                                            </td>
                                                            <td align="center">
                                                                <button class="btn <?= !empty($row->waktu_checkout) ? 'btn-outline-success':'btn-outline-danger' ?> btn-sm btn-icon edit" type="button" data-id="<?= $row->id_absensi; ?>" >
                                                                    <?php if (!empty($row->waktu_checkout)){ ?>
                                                                        <span class="fas fa-eye"></span>&nbsp;Data Absen
                                                                    <?php }else{ ?>
                                                                        <span class="fas fa-right-from-bracket"></span>&nbsp;Absen Pulang
                                                                    <?php } ?>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php $i++; } ?>
                                                 <?php if($i == 1){ ?>
                                                     <tr>
                                                        <td colspan="6" align="center">Data kosong</td>
                                                     </tr>
                                                 <?php } ?>
                                                </tbody>
                                            </table>
                                        <?php }else{ ?>
                                            <div class="alert alert-warning" role="alert">
                                                <span class="fas fa-exclamation-triangle"></span>&nbsp;Silahkan pilih educator terlebih dahulu!
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <p class="font-italic float-right"><span class="fas fa-info-circle"></span>&nbsp;<span class="text-muted" style="font-size: 11px">Tombol absen masuk <b>tersedia</b> jika tidak ada absen yang statusnya <b>belum absen pulang</b></span></p>
                                </div>
                            </div>
                        </div>
                        <!-- end of col-->
                    </div>
                    <!-- end of main-content -->
                </div><!-- Footer Start -->

                <!--  Modal -->
                <div class="modal fade" id="absen-masuk" tabindex="-1" role="dialog" aria-labelledby="updating" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Absensi Hari <span class="font-weight-bold"><?= format_date_indonesia(date('Y-m-d')).', '.date('d-m-Y'); ?></span>&nbsp;a.n.&nbsp;<b class="text-success"><?= $data_educator->nama_educator ?></b></h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <?php echo form_open_multipart($controller.'/absenmasuk','id="frm_absenmasuk"'); ?>
                                <h5 class="text-success"><span class="fas fa-right-to-bracket"></span>&nbsp;Absen Masuk</h5>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kondisi</label>
                                                <select class="form-control" name="kondisi" id="kondisi_masuk" required>
                                                    <option value="1">Sehat</option>
                                                    <option value="2">Kurang Sehat</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Shift</label>
                                                <select class="form-control" name="jenis_absen" id="jenis_absen" required>
                                                    <option value="">-- Pilih Shift --</option>
                                                    <?php foreach ($list_jenisabsensi as $key => $value) { ?>
                                                        <option value="<?= $value->id_jenisabsen ?>"><?= $value->nama ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Apakah Lembur ?</label>
                                                <select class="form-control" id="is_lembur" onchange="showLembur(this)">
                                                    <option value="0">Tidak</option>
                                                    <option value="1">Iya</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group lembur" style="display: none">
                                                <label>Jenis Lembur</label>
                                                <select class="form-control" name="jenis_lembur" id="jenis_lembur" required>
                                                    <option value="">-- Pilih Jenis Lembur --</option>
                                                    <?php foreach ($list_jenislembur as $key => $value) { ?>
                                                        <option value="<?= $value->id_jenislembur ?>"><?= $value->nama ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group lembur" style="display: none">
                                                <label>Keterangan <i>(Optional)</i></label>
                                                <textarea name="keterangan" id="keterangan" cols="30" rows="4" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <br>
                                <button class="btn btn-sm btn-success" id="btn_absenmasuk" type="submit"><span class="fas fa-save"></span>&nbsp;Absen Masuk</button>
                                <input type="hidden" name="educator" value="<?= $educator; ?>">
                                </form>
                                <div class="modal-footer mt-3">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="updating-modal" tabindex="-1" role="dialog" aria-labelledby="updating" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Absensi Hari <span class="font-weight-bold"><?= format_date_indonesia(date('Y-m-d')).', '.date('d-m-Y'); ?></span>&nbsp;a.n.&nbsp;<b class="text-success"><?= $data_educator->nama_educator ?></b></h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <h5 class="text-success"><span class="fas fa-right-to-bracket"></span>&nbsp;Absen Masuk</h5>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kondisi</label>
                                                <select class="form-control" id="kondisi_masukedit" disabled>
                                                    <option value="1">Sehat</option>
                                                    <option value="2">Kurang Sehat</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Shift</label>
                                                <select class="form-control" id="jenis_absenedit" disabled>
                                                    <option value="">-- Pilih Shift --</option>
                                                    <?php foreach ($list_jenisabsensi as $key => $value) { ?>
                                                        <option value="<?= $value->id_jenisabsen ?>"><?= $value->nama ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Apakah Lembur ?</label>
                                                <select class="form-control" id="is_lemburedit" disabled>
                                                    <option value="0">Tidak</option>
                                                    <option value="1">Iya</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group lemburedit" style="display: none">
                                                <label>Jenis Lembur</label>
                                                <select class="form-control" id="jenis_lemburedit" disabled>
                                                    <option value="">-- Pilih Jenis Lembur --</option>
                                                    <?php foreach ($list_jenislembur as $key => $value) { ?>
                                                        <option value="<?= $value->id_jenislembur ?>"><?= $value->nama ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group lemburedit" style="display: none">
                                                <label>Keterangan <i>(Optional)</i></label>
                                                <textarea id="keteranganedit" cols="30" rows="4" class="form-control" disabled></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <?php echo form_open_multipart($controller.'/absenpulang', 'id="frm_absenpulang"'); ?>
                                    <div id="form_absen_pulang">
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
                                            </div>
                                        </fieldset>
                                        <br>
                                        <button class="btn btn-sm btn-danger" id="btn_absenpulang" type="submit"><span class="fas fa-save"></span>&nbsp;Absen Pulang</button>
                                    </div>
                                <input type="hidden" name="id_absensi" id="id_absensi" required>
                                </form>
                                <div class="modal-footer mt-3">
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
            $('.select2').select2();
            resetAbsenMasuk();

            $('#absen-masuk').on('shown.bs.modal', function () {
                resetAbsenMasuk();
                clearFormStatus('#frm_absenmasuk');
            });

            $("#frm_absenmasuk").validate({
                rules: {
                    kondisi: {
                        required: true
                    },
                    jenis_absen: {
                        required: true
                    },
                    jenis_lembur: {
                        required: true
                    }
                },
                messages: {
                    kondisi: {
                        required: "Kondisi harus dipilih!"
                    },
                    jenis_absen: {
                        required: "Shift harus dipilih!"
                    },
                    jenis_lembur: {
                        required: "Jenis lembur harus dipilih!"
                    }
                },
                submitHandler: function(form) {
                    form.submit(); // Mengirimkan form jika validasi lolos
                }
            });

            $("#frm_absenpulang").validate({
                rules: {
                    kondisi: {
                        required: true
                    }
                },
                messages: {
                    kondisi: {
                        required: "Kondisi harus diisi!"
                    }
                },
                submitHandler: function(form) {
                    form.submit(); // Mengirimkan form jika validasi lolos
                }
            });

            $('.edit').click(function(){
                clearFormStatus('#frm_absenpulang');

                var id_absensi = $(this).data('id') ;
                $('#id_absensi').val(id_absensi);

                $.ajax({
                    url: url + '/edit/' + $(this).data('id'),
                    type:'GET',
                    dataType: 'json',
                    success: function(data){
                        resetAbsenPulang();

                        $('#kondisi_masukedit').val(data.kondisi);
                        $('#jenis_absenedit').val(data.id_jenisabsen);
                        if (data.id_jenislembur != null) {
                            $('#is_lemburedit').val(1);
                            $('#jenis_lemburedit').val(data.id_jenislembur);
                            $('#keteranganedit').val(data.keterangan);
                            $('.lemburedit').show();
                        }
                        if (data.waktu_checkout != null) {
                            $('#kondisi_pulang').val(data.kondisi_checkout);
                            $('#kondisi_pulang').prop('disabled', true);
                            $('#btn_absenpulang').hide();
                        } else {
                            $('#kondisi_pulang').prop('disabled', false);
                        }

                        $("#updating-modal").modal('show');
                    }
                });
            })
        });

        function resetAbsenMasuk(){
            $('#kondisi_masuk').val(1);
            $('#jenis_absen').val('');
            $('#is_lembur').val(0);
            $('#jenis_lembur').val('');
            $('#keterangan').val('');
            $('.lembur').hide();
        }

        function resetAbsenPulang(){
            $('#kondisi_masukedit').val(1);
            $('#jenis_absenedit').val('');
            $('#is_lemburedit').val(0);
            $('#jenis_lemburedit').val('');
            $('#keteranganedit').val('');
            $('.lemburedit').hide();
            $('#btn_absenpulang').show();
            $('#kondisi_pulang').val(1);
            $('#kondisi_pulang').prop('disabled', false);
        }

        function clearFormStatus(formId) {
            // Reset the form values
            $(formId)[0].reset();

            // Clear validation messages and error/success classes
            $(formId).find('.valid').removeClass('valid'); // Remove valid class
            $(formId).find('label.error').remove(); // Remove error messages
            $(formId).find('.error').removeClass('error'); // Remove error class
        }

        function submitForm(){
            $('#frm_filter').submit();
        }

        function showLembur(dom){
            if ($(dom).val() == 1) {
                $('.lembur').show();
            }else{
                $('.lembur').hide();
            }
        }
    </script>
</html>


                                                                
                                                                    
                                                                
                                                            