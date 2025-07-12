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
                            <li><a href="#">Qiro'ati</a></li>
                            <li><a href="#"><?= $title ?></a></li>
                            <li>Detail Catatan Mengaji</li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="<?= base_url().$redirect ?>" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Kembali</a>
                            <div class="card text-left">
                                <div class="card-body">
                                    <div class="row text-center d-flex align-items-center justify-content-center">
                                        <div class="col-sm-12">
                                            <h5 class="card-title mb-1">Catatan Mengaji Hari&nbsp;<b><?= format_date_indonesia($data_mengaji->tanggal).', '.date('d-m-Y', strtotime($data_mengaji->tanggal)) ?></b></h5>
                                            <h5 class="card-title mb-1">a.n&nbsp;<span class="text-success font-weight-bold"><?= $data_mengaji->nama_anak ?></span>&nbsp;Usia:&nbsp;<span class="text-info"><?= hitung_usia($data_mengaji->tanggal_lahir) ?> <span class="text-muted">(<?= $data_mengaji->nama_kelas ?>)</span></span></h5>
                                        </div>
                                    </div>
                                    <hr>
                                    <p><span class="text-muted" style="font-size: smaller"><i>terakhir update <?= empty($data_mengaji->updated_at)? timeAgo($data_mengaji->created_at):timeAgo($data_mengaji->updated_at); ?> </i></span></p>
                                    <?php echo form_open_multipart($controller.'/simpancatatanmengaji', 'id="frm_simpan" enctype="multipart/form-data"'); ?>
                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label><b>Pilih Jilid</b></label>
                                                        <select class="form-control" name="jilid" id="jilid" required>
                                                            <option value="">-- Pilih Jilid --</option>
                                                            <?php foreach ($list_jilid as $pil){ ?>
                                                                <option value="<?= $pil->id_jilidmengaji ?>" <?= $pil->id_jilidmengaji == $data_mengaji->id_jilidmengaji? 'selected':''; ?>><?= $pil->nama ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label><b>Input Halaman</b></label>
                                                        <input type="number" class="form-control" name="halaman" id="halaman" value="<?= (!empty($data_mengaji->halaman))? $data_mengaji->halaman:'' ?>" required placeholder="(Masukan Halaman Terakhir)" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label><b>Nilai</b></label>
                                                        <select class="form-control" name="nilai" id="nilai" required>
                                                            <option value="0" <?= $data_mengaji->nilai == 0 ? 'selected':''; ?>>-L</option>
                                                            <option value="1" <?= $data_mengaji->nilai == 1 ? 'selected':''; ?>>L</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label><b>Keterangan</b> <i>(Optional)</i></label>
                                                        <textarea class="form-control" name="keterangan" id="keterangan" cols="30" rows="5"><?= !empty($data_mengaji->keterangan)? $data_mengaji->keterangan:''; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <br>
                                        <h5><span class="fas fa-file"></span>&nbsp;Dokumentasi</h5>
                                        <br>
                                        <div class="file-loading">
                                            <input id="file_dukung" name="file_dukung[]" type="file" accept="image/*" multiple>
                                        </div>
                                        <br>
                                        <center><button class="btn btn-success" id="btn_simpan" type="submit"><span class="fas fa-save"></span>&nbsp;Simpan Catatan</button></center>
                                        <input type="hidden" name="id_catatan" value="<?= $data_mengaji->id_catatan ?>">
                                    </form>
                                    <p class="font-italic float-right mt-5"><span class="fas fa-info-circle"></span>&nbsp;<span class="text-muted" style="font-size: 11px">Lengkapi data catatan mengaji sesuai uraian yang diberikan!.</span></p>
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
            </div>
        </div>
    </body>
    <?php $this->load->view('layout/custom') ?>
    <?php $this->load->view('layout/file_upload') ?>
    <script src="<?= base_url().'dist-assets/'?>js/plugins/datatables.min.js"></script>
    <script src="<?= base_url().'dist-assets/'?>js/scripts/datatables.script.min.js"></script>
    <script type="text/javascript">
        let url = "<?= base_url().$controller ?>";
        let initialPreview = <?= json_encode($dokumentasi_file['preview'])?>;
        let initialPreviewConfig = <?= json_encode($dokumentasi_file['config'])?>;
        const list_form = <?= json_encode(['jilid', 'halaman']) ?>;

        $(document).ready(function() {
            $.validator.addMethod("decimal", function(value, element) {
                // Regular expression for decimal values (including optional negative sign)
                return this.optional(element) || /^-?\d+(\.\d+)?$/.test(value);
            }, "Please enter a valid decimal number.");

            $.validator.addMethod("filesize", function(value, element, param) {
                var files = element.files;
                for (var i = 0; i < files.length; i++) {
                    if (files[i].size > param) {
                        return false; // If any file is too large, return false
                    }
                }
                return true; // All files are within size limit
            }, "File is too large.");

            let file_input = $('#file_dukung'), initPlugin = function () {
                file_input.fileinput({
                    maxFileSize: 20000,
                    dropZoneTitle: 'File Pendukung Kosong!',
                    previewThumbnail: true,
                    showRemove: false,
                    showUpload: false,
                    required: true,
                    validateInitialCount: true,
                    previewFileType: ['image'], // Preview type is automatically handled (both images and videos)
                    allowedFileExtensions: ['jpg', 'jpeg', 'png', 'gif'], // Allowed image/video extensions
                    allowedPreviewTypes: ['image'],
                    initialPreview: initialPreview,
                    initialPreviewConfig: initialPreviewConfig,
                    initialPreviewAsData: true,
                    overwriteInitial: false
                });
            };

            initPlugin();

            let temp_rules, temp_message, rules = {}, message = {};
            $.each(list_form, function(index, value){
                temp_rules = {}; temp_message = {};
                if (value['jenis_kolom'] === 'number'){
                    temp_rules = {
                        required: true,
                        decimal: true
                    };

                    temp_message = {
                        required: value['nama_kolom']+" harus diisi!",
                        decimal: value['nama_kolom']+" harus berupa angka!"
                    };

                }else{
                    temp_rules = {
                        required: true
                    };

                    temp_message = {
                        required: value['nama_kolom']+" harus diisi!",
                    };
                }

                rules[value['kolom']] = temp_rules;
                message[value['kolom']] = temp_message

                if (value['action'] !== null){
                    rules['action_'+value['kolom']] = {
                        required: true
                    };

                    message['action_'+value['kolom']] = {
                        required: "Action "+value['nama_kolom']+" harus dipilih!"
                    };
                }
            });

            file_input.on("filepredelete", function(jqXHR) {
                var abort = true;
                if (confirm("Apakah yakin menghapus file?")) {
                    abort = false;
                }
                return abort; // you can also send any data/object that you can receive on `filecustomerror` event
            });

            file_input.on('change', function(event) {
                $("#frm_simpan").valid();
            });

            $("#frm_simpan").validate({
                rules: rules,
                messages: message
            });
        });
    </script>
</html>