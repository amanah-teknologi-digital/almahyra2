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
                            <li><a href="#">Laporan</a></li>
                            <li><?= $title ?></li>
                        </ul>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12 mb-4">
                            <div class="card text-left">
<!--                                <div class="card-header">-->
<!--                                    <p class="card-title mb-0">Filter</p>-->
<!--                                </div>-->
                                <div class="card-body">
                                    <?php echo form_open_multipart($controller); ?>
                                        <table style="width: 100%;padding: 10px 10px;">
                                            <colgroup>
                                                <col style="width: 20%">
                                                <col style="width: 80%">
                                            </colgroup>
                                            <tr>
                                                <td>
                                                    <label>Tahun</label>
                                                </td>
                                                <td>
                                                    <select class="form-control" id="tahun" name="tahun" onchange="getDataTanggal(this)" required">
                                                    <?php foreach ($list_tahun as $key => $value) { ?>
                                                        <option value="<?= $value->tahun ?>" <?= $tahun == $value->tahun ? 'selected' : '' ?>><?= $value->tahun ?></option>
                                                    <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label>Tanggal Mengaji</label>
                                                </td>
                                                <td>
                                                    <select class="form-control" id="tanggal" name="tanggal" required">
                                                    <?php if (count($list_tanggal) > 0){ ?>
                                                        <option value="-1" selected>-- Semua --</option>
                                                        <?php foreach ($list_tanggal as $key => $value) { ?>
                                                            <option value="<?= $value->tanggal ?>" <?= $tanggal == $value->tanggal ? 'selected' : '' ?>><?= format_date_indonesia($value->tanggal) . ', ' . date('d-m-Y', strtotime($value->tanggal)); ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label>Sesi Mengaji</label>
                                                </td>
                                                <td>
                                                    <select class="form-control" id="sesi" name="sesi" required">
                                                    <option value="" selected>-- Semua --</option>
                                                    <?php foreach ($list_sesi as $key => $value) { ?>
                                                        <option value="<?= $value->id_sesi ?>" <?= $sesi == $value->id_sesi ? 'selected' : '' ?>><?= $value->nama ?></option>
                                                    <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label>Ustadzah</label>
                                                </td>
                                                <td>
                                                    <select class="form-control" id="id_ustadzah" name="id_ustadzah" required">
                                                    <?php if (count($list_ustadzah) > 1) { ?>
                                                        <option value="" selected>-- Semua --</option>
                                                    <?php } ?>
                                                    <?php foreach ($list_ustadzah as $key => $value) { ?>
                                                        <option value="<?= $value->id ?>" <?= $id_ustadzah == $value->id ? 'selected' : '' ?>><?= $value->name ?></option>
                                                    <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" >
                                                    <button class="btn btn-sm btn-primary mt-4">Tampilkan</button>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                    <hr>
                                    <?php echo form_open_multipart($controller.'/cetaklaporanmengaji', 'target="blank"'); ?>
                                        <div class="row d-flex justify-content-center align-items-center">
                                            <div class="col-sm-10">
                                                <h5 class="card-title mb-1 d-flex align-content-center justify-content-between"><span class="float-left">Data Laporan Mengaji Tahun <?= $tahun ?><span><?= $tanggal != -1 ? '&nbsp;Hari '. format_date_indonesia($tanggal).', '.date('d-m-Y', strtotime($tanggal)):''; ?></span>&nbsp;<span class="text-success font-weight-bold"><?= !empty($sesi)? 'Sesi '.$nama_sesi:''; ?></span>&nbsp;<span class="font-weight-bold"><?= !empty($id_ustadzah) ? 'Ustadzah: '.$nama_ustadzah:'' ?> </span></span></h5>
                                            </div>
                                            <div class="col-sm-2">
                                                <button class="btn btn-sm btn-primary float-right"><span class="fas fa-print"></span>&nbsp;Cetak Laporan</button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="tahun" value="<?= $tahun ?>">
                                        <input type="hidden" name="tanggal" value="<?= $tanggal ?>">
                                        <input type="hidden" name="sesi" value="<?= $sesi ?>">
                                        <input type="hidden" name="id_ustadzah" value="<?= $id_ustadzah ?>">
                                    </form>
                                    <br>
                                    <div class="table-responsive">
                                        <table class="display table table-sm table-bordered" id="tbl" style="font-size: 12px;">
                                            <thead>
                                            <tr>
                                                <th style="width: 15%">Tanggal</th>
                                                <th style="width: 20%">Nama Anak</th>
                                                <th style="width: 10%">Sesi</th>
                                                <th style="width: 10%">Jilid/Kelas</th>
                                                <th style="width: 5%">Halaman</th>
                                                <th style="width: 5%">Nilai</th>
                                                <th style="width: 20%">Ustadzah</th>
                                                <th style="width: 15%">Keterangan</th>
<!--                                                <th style="width: 10%">Aksi</th>-->
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $no = 1; foreach ($hasil_mengaji as $key => $value) { ?>
                                                <tr>
                                                    <td nowrap align="center" class="text-muted font-italic font-weight-bold"><?= format_date_indonesia($value->tanggal).', '.date('d-m-Y', strtotime($value->tanggal)) ?></td>
                                                    <td nowrap align="left"><?= $value->nama_anak ?></td>
                                                    <td nowrap align="center"><b><?= $value->nama_sesi ?></b></td>
                                                    <td nowrap align="center"><?= $value->nama_jilid ?></td>
                                                    <td nowrap align="center"><?= $value->halaman ?></td>
                                                    <td nowrap align="center" class="font-weight-bold"><?= !empty($value->nilai) ? '<span class="text-success">L</span>':'<span class="text-danger">L-</span>' ?></td>
                                                    <td nowrap align="center"><?= $value->nama_ustadzah ?></td>
                                                    <td nowrap align="left" class="text-muted font-italic text-small"><?= $value->keterangan ?></td>
<!--                                                    <td nowrap align="center">-->
<!--                                                        <span class="btn btn-sm btn-success btn-update" data-id="--><?php //= $value->id_catatan ?><!--" data-nama="--><?php //= $value->nama_anak ?><!--"><span class="fas fa-file-alt"></span> Foto Kegiatan</span>-->
<!--                                                    </td>-->
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <p class="font-italic float-right"><span class="fas fa-info-circle"></span>&nbsp;<span class="text-muted" style="font-size: 11px">Laporan mengaji anak.</span></p>
                                </div>
                            </div>
                        </div>
                        <!-- end of col-->
                    </div>
                    <!-- end of main-content -->
                </div><!-- Footer Start -->
                <!--  Modal -->
                <div class="modal fade" id="updating-indikator" tabindex="-1" role="dialog" aria-labelledby="updating" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="card-title mb-1 d-flex align-items-center justify-content-center">Foto Kegiatan a.n&nbsp;<span class="text-success font-weight-bold" id="label_nama_anak"></span></h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <div class="file-loading">
                                    <input id="file_dukung" name="file_dukung[]" type="file" accept="image/*" multiple>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $this->load->view('layout/footer') ?>
            </div>
        </div>
    </body>
    <?php $this->load->view('layout/custom') ?>
    <?php $this->load->view('layout/file_upload') ?>
    <script src="<?= base_url().'dist-assets/'?>js/plugins/datatables.min.js"></script>
    <script src="<?= base_url().'dist-assets/'?>js/scripts/datatables.script.min.js"></script>
    <script type="text/javascript">
        var url = "<?= base_url().$controller ?>";

        let initialPreview = [];
        let initialPreviewConfig = [];

        $(document).ready(function() {
            $('.select2').select2();
            let file_input = $('#file_dukung'), initPlugin = function() {
                file_input.fileinput({
                    uploadUrl: url + '/uploadfile',
                    minFileCount: 1,
                    maxFileCount: 5,
                    maxFileSize: 10000,
                    dropZoneTitle: 'File Pendukung Kosong!',
                    required: true,
                    showRemove: false,
                    showUpload: false,
                    showBrowse: false,
                    showClose: false,
                    showCaption: false,
                    allowedFileExtensions: ['jpg', 'jpeg', 'png', 'gif'],
                    previewFileType: 'image',
                    overwriteInitial: false,
                    initialPreview: initialPreview,
                    initialPreviewConfig: initialPreviewConfig,
                    initialPreviewAsData: true, // identify if you are sending preview data only and not the raw markup
                    initialPreviewFileType: 'image', // image is the default and can be overridden in config below
                    fileActionSettings: {
                        showDrag: false,
                        showRemove: false,
                        removeClass: 'd-none',
                    }
                });
            };

            initPlugin();

            $('#tbl').on('click', '.btn-update', function() {
                id_catatan = $(this).data('id')
                nama_anak = $(this).data('nama')

                $("#label_nama_anak").html(nama_anak);

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
        });

        function resetInput(){
            $('#tanggal').html('');
        }

        function getDataTanggal(dom){
            let tahun = $(dom).val();
            resetInput();

            $.ajax({
                url: url+'/getDataTanggal',
                type: 'POST',
                data: {tahun: tahun},
                success: function(data){
                    let data_tanggal = data['tanggal'];

                    if (data_tanggal.length > 0){
                        $('#tanggal').append('<option value="-1">-- Semua --</option>');
                    }
                    $.each(data_tanggal, function(key, value){
                        $('#tanggal').append('<option value="'+value.tanggal+'">'+ value.nama_hari + ' ' +value.tanggal + '</option>');
                    });
                }
            });
        }
    </script>
</html>