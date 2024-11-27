<!DOCTYPE html>
<html lang="en" dir="/">

    <?php $this->load->view('layout/head') ?>
    <style>
        .callout {
            background-color: #fff;
            border: 1px solid #e4e7ea;
            border-left: 4px solid #c8ced3;
            border-radius: .25rem;
            margin: 1rem 0;
            padding: .75rem 1.25rem;
            position: relative;
        }

        .callout h4 {
            font-size: 1.3125rem;
            margin-top: 0;
            margin-bottom: .8rem
        }
        .callout p:last-child {
            margin-bottom: 0;
        }

        .callout-default {
            border-left-color: #777;
            background-color: #f4f4f4;
        }
        .callout-default h4 {
            color: #777;
        }

        .callout-primary {
            background-color: #d2eef7;
            border-color: #b8daff;
            border-left-color: #17a2b8;
        }
        .callout-primary h4 {
            color: #20a8d8;
        }

        .callout-success {
            background-color: #dff0d8;
            border-color: #d6e9c6;
            border-left-color: #28a745;
        }
        .callout-success h4 {
            color: #3c763d;
        }

        .callout-danger {
            background-color: #f2dede;
            border-color: #ebccd1;
            border-left-color: #d32535;
        }
        .callout-danger h4 {
            color: #a94442;
        }

        .callout-warning {
            background-color: #fcf8e3;
            border-color: #faebcc;
            border-left-color: #edb100;
        }
        .callout-warning h4 {
            color: #f0ad4e;
        }

        .callout-info {
            background-color: #d2eef7;
            border-color: #b8daff;
            border-left-color: #148ea1;
        }
        .callout-info h4 {
            color: #31708f;
        }

        .callout-dismissible .close {
            position: absolute;
            top: 0;
            right: 0;
            padding: .75rem 1.25rem;
            color: inherit;
        }
    </style>
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
                                    <h5 class="card-title mb-1 d-flex align-items-center justify-content-center">Hasil Belajar Aktivitas Harian&nbsp;<b><?= format_date_indonesia($data_subtema->tanggal).', '.date('d-m-Y', strtotime($data_subtema->tanggal)) ?></b>&nbsp;subtema&nbsp;<b><?= $data_subtema->nama_subtema ?></b></h5>
                                    <h5 class="card-title mb-1 d-flex align-items-center justify-content-center">a.n&nbsp;<span class="text-success font-weight-bold"><?= $data_anak->nama ?></span>&nbsp;Usia:&nbsp;<span class="text-info"><?= hitung_usia_histori($data_anak->tanggal_lahir, $data_anak->tanggal_aktivitas) ?> <span class="text-muted">(<?= $data_anak->nama_kelas ?>)</span></span></h5>
                                    <br>
                                    <?php echo form_open_multipart($controller.'/simpan', 'id="frm_simpan"'); ?>
                                        <div class="table-responsive">
                                            <table class="display table table-sm table-bordered" id="example">
                                                <thead style="background-color: #bfdfff">
                                                    <tr>
                                                        <th style="width: 5%">No</th>
                                                        <th style="width: 15%">Waktu</th>
                                                        <th style="width: 35%">Nama Kegiatan</th>
                                                        <th style="width: 20%">Status</th>
                                                        <th style="width: 25%">Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1; foreach ($list_kegiatan as $key => $value) { ?>
                                                        <tr>
                                                            <td align="center"><?= $no++ ?></td>
                                                            <td align="center"><?= Date('H:i',strtotime($value->jam_mulai)).' - '.Date('H:i',strtotime($value->jam_selesai)) ?></td>
                                                            <td><b class="text-muted"><?= $value->uraian ?></b></td>
                                                            <td align="center">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="status<?= $value->id_rincianjadwal_harian ?>" id="inlineRadio1<?= $value->id_rincianjadwal_harian ?>" value="1" <?= $value->status == 1 && !is_null($value->status)? 'checked':''; ?> >
                                                                    <label class="form-check-label" for="inlineRadio1">Ada</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="status<?= $value->id_rincianjadwal_harian ?>" id="inlineRadio2<?= $value->id_rincianjadwal_harian ?>" value="0" <?= $value->status != 1 && !is_null($value->status)? 'checked':''; ?>>
                                                                    <label class="form-check-label" for="inlineRadio2">Tidak</label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <textarea class="form-control" name="keterangan<?= $value->id_rincianjadwal_harian ?>" id="keterangan<?= $value->id_rincianjadwal_harian ?>" cols="10" rows="2"><?= $value->keterangan? $value->keterangan:''; ?></textarea>
                                                            </td>
                                                        </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <br>
                                    <h5 class="card-title"><b>Data Konklusi</b></h5>
                                    <fieldset>
                                        <?php foreach ($konklusi as $cls) { ?>
                                            <div class="form-group">
                                                <label><?= $cls->nama_konklusi ?>&nbsp;<?= empty($cls->flag)? '<b><i>(Optional)</i></b>':''; ?></label>
                                                <?php if ($cls->jenis == 'select'){ $temp_nilai = json_decode($cls->nilai,true); ?>
                                                    <select class="form-control" name="<?= $cls->kolom ?>" id="<?= $cls->kolom ?>" <?= !empty($cls->flag)? $cls->flag:''; ?>>
                                                        <option value="">-- Pilih Salah Satu --</option>
                                                        <?php foreach ($temp_nilai as $nilai){ ?>
                                                            <option value="<?= $nilai ?>" <?= $nilai == $cls->uraian? 'selected':'' ?>><?= $nilai ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <br>
                                                    <textarea class="form-control" name="keterangan_konklusi<?= $cls->id_konklusi_input ?>" id="keterangan_konklusi<?= $cls->id_konklusi_input ?>" placeholder="Keterangan Pilihan (Optional)" cols="30" rows="5" autocomplete="off"><?= !empty($cls->keterangan)? $cls->keterangan:''; ?></textarea>
                                                <?php }elseif ($cls->jenis == 'textarea'){ ?>
                                                    <textarea class="form-control" name="<?= $cls->kolom ?>" id="<?= $cls->kolom ?>" cols="30" rows="5" <?= !empty($cls->flag)? $cls->flag:''; ?> autocomplete="off"><?= !empty($cls->uraian)? $cls->uraian:''; ?></textarea>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    </fieldset>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <button type="submit" class="btn btn-sm btn-success "><span class="fas fa-save"></span>&nbsp;Simpan Data</button>
                                    </div>
                                    <input type="hidden" name="id_aktivitas" value="<?= $id_aktivitas ?>">
                                    </form>
                                    <br>
                                    <h5 class="card-title"><b>Data Stimulus</b></h5>
                                    <?php if (isset($data_stimulus)){ ?>
                                        <div class="callout callout-primary alert-dismissible fade show">
                                            <h4><i class="fas fa-fw fa-info-circle"></i> Fokus <?= $data_stimulus->nama ?>&nbsp;<span class="text-muted">(<?= $data_anak->nama_kelas ?>)</span></h4>
                                            <span><?= isset($data_stimulus)? $data_stimulus->rincian_kegiatan:'';  ?></span>
                                            <span class="font-italic text-muted">Keterangan: <?= isset($data_stimulus)? $data_stimulus->keterangan:'-';  ?></span>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h4 class="mt-3 text-warning font-weight-bold" style="text-shadow: 1px 1px 0 #000, -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000;"><i class="fas fa-fw fa-award"></i> Capaian Indikator</h4>
                                                <a href="#" class="btn btn-sm btn-primary tambahindikator"><i class="fas fa-fw fa-plus"></i> Tambah Capaian Indikator</a>
                                            </div>
                                            <?php if (count($capaian_indikator) > 0){ ?>
                                                <table class="table table-sm table-bordered" style="font-size: 11px;">
                                                    <tr style="background-color: burlywood;">
                                                        <td class="font-weight-bold border-gray-600" style="width: 5%" align="center">No</td>
                                                        <td class="font-weight-bold border-gray-600" style="width: 80%" align="center">Nama Indikator</td>
                                                        <td class="font-weight-bold border-gray-600" style="width: 15%" align="center">Aksi</td>
                                                    </tr>
                                                    <?php foreach ($capaian_indikator as $key => $value) { ?>
                                                        <tr>
                                                            <td class="border-gray-600" align="center"><?= $key+1 ?></td>
                                                            <td class="border-gray-600 font-italic nowrap text-muted font-weight-bold"><?= str_replace('?','', str_replace('ananda','', str_replace('Apakah','', $value->nama_indikator))) ?></td>
                                                            <td class="border-gray-600" align="center">
                                                                <div class="d-flex align-items-center justify-content-center">
                                                                    <span class="btn btn-sm btn-success btn-update" data-id="<?= $value->id_capaianindikator ?>" data-nama="<?= str_replace('?','', str_replace('ananda','', str_replace('Apakah','', $value->nama_indikator))) ?>"><span class="fas fa-eye"></span> Data</span>
                                                                    &nbsp;<span class="btn btn-sm btn-danger" onclick="deleteList('<?= $value->id_capaianindikator ?>')"><span class="fas fa-close"></span> Hapus</span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </table>
                                            <?php }else{ ?>
                                                <span class="text-muted font-italic">Data Kosong!</span>
                                            <?php } ?>
                                        </div>
                                    <?php }else{ ?>
                                        <span class="text-danger font-italic text-small d-flex align-items-center justify-content-center font-weight-bold">Data stimulus kosong!</span>
                                    <?php } ?>
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
                <div class="modal fade" id="updating-modal" tabindex="-1" role="dialog" aria-labelledby="updating" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <?php echo form_open_multipart($controller.'/tambahcapaian'); ?>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Capaian Indikator a.n&nbsp;<span class="text-success font-weight-bold"><?= $data_anak->nama ?></span>&nbsp;Usia:&nbsp;<span class="text-info"><?= hitung_usia_histori($data_anak->tanggal_lahir, $data_anak->tanggal_aktivitas) ?> <span class="text-muted">(<?= $data_anak->nama_kelas ?>)</span></span></h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <fieldset>
                                    <div class="row q">
                                        <div class="col-md-12">
                                            <table class="display table table-bordered" id="tblq" style="width:100%">
                                                <thead>
                                                <tr>
                                                    <th>Aspek</th>
                                                    <th>Pertanyaan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $id_usian=0; foreach ($indikator as $indktr){ $temp_id_usia = $indktr->id_usia; ?>
                                                    <?php if ($id_usian != $temp_id_usia){ ?>
                                                        <tr style="background-color: antiquewhite">
                                                            <td align="center" colspan="3"><b><?= $indktr->nama_usia; ?></b></td>
                                                        </tr>
                                                    <?php $id_usian = $temp_id_usia; } ?>
                                                    <tr>
                                                        <td align="center"><b><?= $indktr->nama_aspek ?></b></td>
                                                        <td><?= $indktr->name ?></td>
                                                        <td align="center">
                                                            <input class="form-check" type="checkbox" name="indikators[]" value="<?= $indktr->id ?>">
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="id_aktivitas" value="<?= $id_aktivitas ?>">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                <button class="btn btn-primary ml-2" type="submit">Tambah</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <div class="modal fade" id="updating-indikator" tabindex="-1" role="dialog" aria-labelledby="updating" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Capaian Indikator a.n&nbsp;<span class="text-success font-weight-bold"><?= $data_anak->nama ?></span>&nbsp;Usia:&nbsp;<span class="text-info"><?= hitung_usia_histori($data_anak->tanggal_lahir, $data_anak->tanggal_aktivitas) ?> <span class="text-muted">(<?= $data_anak->nama_kelas ?>)</span></span></h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <h5><b>Nama Indikator</b></h5>
                                <p class="text-muted font-italic" id="label_nama_indikator"></p>
                                <br>
                                <h5><b>Data Dokumentasi</b></h5>
                                <div class="file-loading">
                                    <input id="file_dukung" name="file_dukung[]" type="file" accept="image/*" multiple>
                                </div>
                                <div class="text-center mt-3">
                                    <button type="button" class="btn btn-success btn-upload-4"><i class="fa fa-upload"></i> Upload File</button>
                                    <button type="button" class="btn btn-secondary btn-reset-4"><i class="fa fa-ban"></i> Clear</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo form_open_multipart($controller.'/hapusindikator', 'id="frm_hapusindikator"'); ?>
                    <input type="hidden" name="id_capaianindikator" id="id_capaianindikator_hps">
                    <input type="hidden" name="id_aktivitas" value="<?= $id_aktivitas ?>">
                </form>
            </div>
        </div>
    </body>
    <?php $this->load->view('layout/custom') ?>
    <?php $this->load->view('layout/file_upload') ?>
    <script src="<?= base_url().'dist-assets/'?>js/plugins/datatables.min.js"></script>
    <script src="<?= base_url().'dist-assets/'?>js/scripts/datatables.script.min.js"></script>
    <script type="text/javascript">
        let url = "<?= base_url().$controller ?>";
        const list_kegiatan = <?= json_encode($list_kegiatan) ?>;
        let initialPreview = [];
        let initialPreviewConfig = [];
        let id_capaianindikator = 0;

        $(document).ready(function() {
            let rules = {};
            let message = {};
            let file_input = $('#file_dukung'), initPlugin = function() {
                file_input.fileinput({
                    uploadUrl: url+'/uploadfile',
                    minFileCount: 1,
                    maxFileCount: 5,
                    required: true,
                    showRemove: false,
                    showUpload: false,
                    allowedFileExtensions: ['jpg', 'jpeg', 'png', 'gif'],
                    previewFileType: 'image',
                    overwriteInitial: false,
                    initialPreview: initialPreview,
                    initialPreviewConfig: initialPreviewConfig,
                    initialPreviewAsData: true, // identify if you are sending preview data only and not the raw markup
                    initialPreviewFileType: 'image', // image is the default and can be overridden in config below
                    uploadExtraData: function() {
                        return { 'id_capaianindikator': id_capaianindikator };
                    }
                });
            };

            initPlugin();

            $.each(list_kegiatan, function(index, value){
                rules['status'+value.id_rincianjadwal_harian] = {
                    required: true
                };
                message['status'+value.id_rincianjadwal_harian] = {
                    required: "Status kegiatan harus diisi!"
                };
            });

            $("#frm_simpan").validate({
                rules: rules,
                messages: message,
                submitHandler: function(form) {
                    form.submit(); // Mengirimkan form jika validasi lolos
                }
            });

            $('.tambahindikator').click(function() {
                $("#updating-modal").modal('show');
            });

            $('.btn-update').click(function(){
                let nama_indikator = $(this).data('nama')
                id_capaianindikator = $(this).data('id')

                $("#label_nama_indikator").html(nama_indikator);

                $.ajax({
                    url: url + '/getfile/' + $(this).data('id'),
                    type:'GET',
                    dataType: 'json',
                    success: function(data){
                        initialPreview = data['preview'];
                        initialPreviewConfig = data['config'];

                        if (file_input.data('fileinput')) {
                            file_input.fileinput('destroy');
                        }

                        initPlugin();

                        $("#updating-indikator").modal('show');
                    }
                });
            });

            $(".btn-upload-4").on("click", function() {
                file_input.fileinput('upload');
            });
            $(".btn-reset-4").on("click", function() {
                file_input.fileinput('clear');
            });
        });

        function deleteList(id) {
            swal({
                title: 'Apakah yakin menghapus indikator? ',
                text: "Progress dan dokumentasi indikator akan dihapus!",
                showCancelButton: true,
                confirmButtonColor: '#4caf50',
                cancelButtonColor: '#f44336',
                confirmButtonText: 'Ya, Lanjutkan hapus!',
                cancelButtonText: 'Batal',
                width: '600px'
            }).then(function () {
                $('#id_capaianindikator_hps').val(id);
                $('#frm_hapusindikator').submit();
            })
        }
    </script>
</html>