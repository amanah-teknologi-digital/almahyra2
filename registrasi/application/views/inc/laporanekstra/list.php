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
                                                    <label>Ekstrakulikuler</label>
                                                </td>
                                                <td>
                                                    <select class="form-control" id="ekstra" name="ekstra" onchange="getDataAnakDanTanggal(this)" required">
                                                        <option value="" selected disabled>-- Pilih Ekstrakulikuler --</option>
                                                        <?php foreach ($list_ekstra as $key => $value) { ?>
                                                            <option value="<?= $value->id_ekstra ?>" <?= $ekstra == $value->id_ekstra ? 'selected' : '' ?>><?= $value->nama ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label>Anak</label>
                                                </td>
                                                <td>
                                                    <select class="form-control" id="anak" name="anak" required onchange="getDataTanggal(this)">
                                                    <?php if (count($list_anak) > 0){ ?>
                                                        <option value="-1" selected>-- Semua --</option>
                                                        <?php foreach ($list_anak as $key => $value) { ?>
                                                            <option value="<?= $value->id ?>" <?= $anak == $value->id ? 'selected' : '' ?>><?= $value->nama_anak.' ('.$value->nama_kelas.')' ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label>Tanggal</label>
                                                </td>
                                                <td>
                                                    <select class="form-control" id="tanggal" name="tanggal" required">
                                                    <?php if (count($list_tanggal) > 0){ ?>
                                                        <option value="" selected disabled>-- Pilih Tanggal --</option>
                                                        <?php foreach ($list_tanggal as $key => $value) { ?>
                                                            <option value="<?= $value->tanggal ?>" <?= $tanggal == $value->tanggal ? 'selected' : '' ?>><?= format_date_indonesia($value->tanggal) . ', ' . $value->tanggal; ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" >
                                                    <button type="submit" class="btn btn-sm btn-primary mt-4">Tampilkan</button>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                    <hr>
                                    <?php if (!empty($tanggal)){ ?>
                                        <?php echo form_open_multipart($controller.'/cetaklaporanmengaji', 'target="blank"'); ?>
                                        <div class="row d-flex justify-content-center align-items-center">
                                            <div class="col-sm-10">
                                                <h5 class="card-title mb-1 d-flex align-content-center justify-content-between"><span class="float-left">Data Laporan Ekstrakulikuler <?= $nama_ekstra ?><span>&nbsp;Hari <?= format_date_indonesia($tanggal).', '.date('d-m-Y', strtotime($tanggal)) ?></span></span></h5>
                                            </div>
                                            <div class="col-sm-2">
                                                <button class="btn btn-sm btn-primary float-right"><span class="fas fa-print"></span>&nbsp;Cetak Laporan</button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="ekstra" value="<?= $ekstra ?>">
                                        <input type="hidden" name="anak" value="<?= $anak ?>">
                                        <input type="hidden" name="tanggal" value="<?= $tanggal ?>">
                                        </form>
                                        <br>
                                        <div class="table-responsive">
                                            <table class="display table table-sm table-bordered" id="tbl" style="font-size: 12px;">
                                                <thead>
                                                <tr>
                                                    <th style="width: 30%">Nama Anak</th>
                                                    <th style="width: 15%">Kelas Anak</th>
                                                    <th style="width: 20%">Pengampu</th>
                                                    <th style="width: 10%">Nilai</th>
                                                    <th style="width: 15%">Keterangan</th>
                                                    <th style="width: 10%">Aksi</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $no = 1; foreach ($hasil_ekstra as $key => $value) { ?>
                                                    <tr>
                                                        <td nowrap align="left"><?= $value->nama_anak ?></td>
                                                        <td nowrap align="center"><b><?= $value->nama_kelas ?></b></td>
                                                        <td nowrap align="center"><?= $value->nama_pengampu ?></td>
                                                        <td nowrap align="center" class="font-weight-bold"><span class="text-success"><?= $value->nilai ?></span></td>
                                                        <td nowrap align="left" class="text-muted font-italic text-small"><?= $value->keterangan ?></td>
                                                        <td nowrap align="center">
                                                            <span class="btn btn-sm btn-success btn-update" data-id="<?= $value->id_ekstracatatan ?>" data-nama="<?= $value->nama_anak ?>" data-nama_ekstra="<?= $nama_ekstra ?>"><span class="fas fa-file-alt"></span> Data Kegiatan</span>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php }else{ ?>
                                        <h5 class="card-title mb-1 d-flex align-content-center justify-content-center"><span class="text-danger font-weight-bold">Pilih Ekstrakulikuler dan Tanggalnya, kemudian klik tombol <span class="text-success">Tampilkan</span> untuk menampilkan data!</span></h5>
                                    <?php } ?>
                                    <p class="font-italic float-right"><span class="fas fa-info-circle"></span>&nbsp;<span class="text-muted" style="font-size: 11px">Laporan ekstrakulikuler anak.</span></p>
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
                                <h5 class="card-title mb-1 d-flex align-items-center justify-content-center">Data Kegiatan Ekstrakulikuler&nbsp;<span id="label_nama_ekstra"></span>&nbsp;a.n&nbsp;<span class="text-success font-weight-bold" id="label_nama_anak"></span></h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <fieldset id="data_form_ekstra">
                                </fieldset>
                                <br>
                                <h5><span class="fas fa-file"></span>&nbsp;Dokumentasi</h5>
                                <br>
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
        let id_role = <?= json_encode($id_role) ?>;

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
                nama_ekstra = $(this).data('nama_ekstra')

                $("#label_nama_anak").html(nama_anak);
                $("#label_nama_ekstra").html(nama_ekstra);
                $("#data_form_ekstra").html("");

                $.ajax({
                    url: url + '/getfile/' + $(this).data('id'),
                    type:'GET',
                    dataType: 'json',
                    success: function(data){
                        initialPreview = data['preview'];
                        initialPreviewConfig = data['config'];
                        htmlform = data['htmlform'];

                        $("#data_form_ekstra").html(htmlform);

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
            $('#anak').html('');
            $('#tanggal').html('');
        }

        function getDataAnakDanTanggal(dom){
            let ekstra = $(dom).val();
            resetInput();

            $.ajax({
                url: url+'/getDataAnakDanTanggal',
                type: 'POST',
                data: {ekstra: ekstra, id_role: id_role},
                success: function(data){
                    let data_anak = data['anak'];
                    let data_tanggal = data['tanggal'];

                    if (data_anak.length > 0){
                        $('#anak').append('<option value="-1" selected>-- Semua Anak --</option>');
                    }

                    $.each(data_anak, function(key, value){
                        $('#anak').append('<option value="'+value.id+'">'+ value.nama_anak + ' (' +value.nama_kelas + ')</option>');
                    });

                    if (data_tanggal.length > 0){
                        $('#tanggal').append('<option value="" selected disabled>-- Pilih Tanggal --</option>');
                    }
                    $.each(data_tanggal, function(key, value){
                        $('#tanggal').append('<option value="'+value.tanggal+'">'+ value.nama_hari + ', ' +value.tanggal + '</option>');
                    });
                }
            });
        }

        function getDataTanggal(dom){
            let id_anak = $(dom).val();
            let id_ekstra = $('#ekstra').val();

            $('#tanggal').html('');

            $.ajax({
                url: url+'/getDataTanggal',
                type: 'POST',
                data: {ekstra: id_ekstra, id_anak: id_anak},
                success: function(data){
                    let data_tanggal = data['tanggal'];

                    if (data_tanggal.length > 0){
                        $('#tanggal').append('<option value="" selected disabled>-- Pilih Tanggal --</option>');
                    }
                    $.each(data_tanggal, function(key, value){
                        $('#tanggal').append('<option value="'+value.tanggal+'">'+ value.nama_hari + ', ' +value.tanggal + '</option>');
                    });
                }
            });
        }
    </script>
</html>