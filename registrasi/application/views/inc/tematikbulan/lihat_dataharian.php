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
                                                <div class="card-body">
                                                    <h5 class="card-title"><b>Jadwal Harian</b></h5>
                                                    <div class="table-responsive" id="zero_configuration_table<?= $kelas->id_kelas ?>">
                                                        <div class="mb-3 d-flex justify-content-between align-items-center">
                                                            <button class="btn btn-sm btn-warning btn-tambahbytemplate" data-nama="<?= $kelas->nama  ?>" data-idkelas="<?= $kelas->id_kelas ?>"><span class="fas fa-plus"></span>&nbsp;Tambah dari Template</button>
                                                            <button class="btn btn-sm btn-primary btn-tambahkegiatan" data-namatema="<?= $data_subtema->nama ?>" data-nama="<?= $kelas->nama  ?>" data-idkelas="<?= $kelas->id_kelas ?>"><span class="fas fa-plus"></span>&nbsp;Tambah Jadwal</button>
                                                        </div>
                                                        <i class="text-muted" style="font-size: 11px"><b>note:</b> <span class="text-danger font-weight-bold">* Jika tambah dari template, jadwal yang sudah ada akan dihapus!</span></i>
                                                        <table class="display table table-sm table-striped table-bordered">
                                                            <thead style="background-color: #bfdfff">
                                                                <tr>
                                                                    <th align="center">No</th>
                                                                    <th align="center">Jam</th>
                                                                    <th align="center">Kegiatan</th>
                                                                    <th align="center">Keterangan</th>
                                                                    <th align="center">Urutan</th>
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
                                                                            <td align="center"><?= $kegiatan->urutan; ?></td>
                                                                            <td align="center"></td>
                                                                        </tr>
                                                                <?php }
                                                                }else{ ?>
                                                                    <tr>
                                                                        <td colspan="7" align="center"><span class="font-weight-bold text-danger text-small"><i>Data Jadwal Kosong!</i></span></td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="table-responsive d-none"  id="preview_fromtemplate<?= $kelas->id_kelas ?>">

                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title"><b>Data Stimulus</b></h5>
                                                    <?php if (isset($data_jadwal_harian[$kelas->id_kelas])){ ?>
                                                    <?php }else{ ?>
                                                        <span class="font-weight-bold text-danger text-small"><i>Data Stimulus Kosong!</i></span>
                                                    <?php }?>
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