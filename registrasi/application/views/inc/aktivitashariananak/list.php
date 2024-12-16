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
                                    <div class="table-responsive">
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
                                                        <select class="form-control" id="tahun" name="tahun" required onchange="getDataTanggal(this)">
                                                            <?php foreach ($tahun as $key => $value) { ?>
                                                                <option value="<?= $value->tahun ?>" <?= $tahun_selected == $value->tahun ? 'selected' : '' ?>><?= $value->tahun ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label>Tanggal</label>
                                                    </td>
                                                    <td>
                                                        <select class="form-control select2" id="id_rincianjadwal_mingguan" name="id_rincianjadwal_mingguan" required>
                                                            <?php foreach ($tanggal as $key => $value) { ?>
                                                                <option value="<?= $value->id_rincianjadwal_mingguan ?>" <?= $id_rincianjadwal_mingguan == $value->id_rincianjadwal_mingguan ? 'selected' : '' ?>><?= 'Tema: '.$value->nama_tema.', '.format_date_indonesia($value->tanggal).' '.date('d-m-Y', strtotime($value->tanggal)).' ('.$value->nama_subtema.')' ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label>Nama Anak</label>
                                                    </td>
                                                    <td>
                                                        <select class="form-control select2" id="id_anak" name="id_anak" required>
                                                            <option value="">-- Pilih Anak --</option>
                                                            <?php foreach ($list_anak as $key => $value) { ?>
                                                                <option value="<?= $value->id ?>" <?= $id_anak == $value->id ? 'selected' : '' ?>><?= $value->nama_anak.' ('.hitung_usia($value->tanggal_lahir).')' ?>&nbsp;<?= $value->is_active ? 'aktif':'tidak aktif' ?></option>
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
                                        <?php if (!empty($data_anak)){ ?>
                                            <?php echo form_open_multipart($controller.'/cetakaktivitas', 'target="blank"'); ?>
                                                <h5 class="card-title mb-1 d-flex align-content-center justify-content-between"><span class="float-left">Data Aktifitas Harian&nbsp;a.n&nbsp;<span class="text-success font-weight-bold"><?= $data_anak->nama_anak ?></span>&nbsp;Usia:&nbsp;<span class="text-info"><?= hitung_usia($data_anak->tanggal_lahir) ?> <span class="text-muted">(<?= $data_anak->nama_kelas ?>)</span></span></span>
                                                    <?php if (!empty($id_aktivitas)){ ?>
                                                        <button class="btn btn-sm btn-primary float-right"><span class="fas fa-print"></span>&nbsp;Cetak Aktivitas</button>
                                                    <?php } ?>
                                                </h5>
                                                <input type="hidden" name="id_aktivitas" value="<?= $id_aktivitas ?>">
                                            </form>
                                        <?php }else{ ?>
                                            <h5 class="card-title mb-1 d-flex align-content-center justify-content-center"><span class="text-danger font-weight-bold">Pilih Anak terlebih dahulu, kemudian klik tombol <span class="text-success">Tampilkan</span> untuk menampilkan data!</span></h5>
                                        <?php } ?>
                                        <br>
                                        <?php if (!empty($id_aktivitas)){ ?>
                                            <h5 class="card-title mb-1 d-flex align-items-center justify-content-center"><b><?= format_date_indonesia($data_subtema->tanggal).', '.date('d-m-Y', strtotime($data_subtema->tanggal)) ?></b>&nbsp;subtema&nbsp;<b><?= $data_subtema->nama_subtema ?></b></h5>
                                            <br>
                                            <table style="font-size: 12px; font-style: italic">
                                                <tr>
                                                    <td nowrap>Educator</td>
                                                    <td>:</td>
                                                    <td>
                                                        <span class="text-muted font-weight-bold"><?= $data_subtema->nama_educator ?></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td nowrap>Terakhir Update</td>
                                                    <td>:</td>
                                                    <td>
                                                        <span class="text-muted"><?= empty($data_subtema->updated_at)? timeAgo($data_subtema->created_at):timeAgo($data_subtema->updated_at); ?></span>
                                                    </td>
                                                </tr>
                                            </table>
                                            <div class="table-responsive">
                                                <table class="display table table-sm table-bordered" id="example" style="font-size: 12px;">
                                                    <thead style="background-color: #bfdfff">
                                                    <tr>
                                                        <th style="width: 5%">No</th>
                                                        <th style="width: 15%">Waktu</th>
                                                        <th style="width: 45%">Nama Kegiatan</th>
                                                        <th style="width: 10%">Status</th>
                                                        <th style="width: 25%">Keterangan</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php $no = 1; foreach ($list_kegiatan as $key => $value) { ?>
                                                        <tr>
                                                            <td align="center"><?= $no++ ?></td>
                                                            <td nowrap align="center"><?= Date('H:i',strtotime($value->jam_mulai)).' - '.Date('H:i',strtotime($value->jam_selesai)) ?></td>
                                                            <td nowrap><b class="text-muted font-italic"><?= $value->uraian ?></b></td>
                                                            <td align="center" nowrap>
                                                                <?php if (!empty($value->status)){ ?>
                                                                    <span class="text-muted"><?= $value->status ?></span>
                                                                <?php }else{ ?>
                                                                    <span style="color: red">data kosong!</span>
                                                                <?php } ?>
                                                            </td>
                                                            <td>
                                                                <span class="text-muted font-italic"><?= $value->keterangan? $value->keterangan:''; ?></span>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <br>
                                            <h5><b><i class="fas fa-fw fa-note-sticky"></i> Data Konklusi</b></h5>
                                            <div class="table-responsive">
                                                <table style="width: 100%; font-size: 12px;">
                                                    <colgroup>
                                                        <col style="width: 50%">
                                                        <col style="width: 1%">
                                                        <col style="width: 49%">
                                                    </colgroup>
                                                    <?php foreach ($konklusi as $cls) { ?>
                                                        <tr style="border-bottom: 1px solid #c8c8c8">
                                                            <td>
                                                                <label>&bullet;&nbsp;<?= $cls->nama_konklusi ?>&nbsp;<?= empty($cls->flag)? '<b><i>(Optional)</i></b>':''; ?></label>
                                                            </td>
                                                            <td>:</td>
                                                            <td>
                                                                <?= !empty($cls->uraian)? $cls->uraian:''; ?>
                                                            </td>
                                                        </tr>
                                                        <?php if ($cls->jenis == 'select'){ ?>
                                                            <tr style="border-bottom: 1px solid #c8c8c8">
                                                                <td>
                                                                    <label>&bullet;&nbsp;Keterangan Pilihan <b><i>(Optional)</i></b></label>
                                                                </td>
                                                                <td>:</td>
                                                                <td>
                                                                    <?= !empty($cls->keterangan)? $cls->keterangan:''; ?>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </table>
                                            </div>
                                            <br>
                                            <?php if (isset($data_stimulus)){ ?>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <h4 class="text-warning font-weight-bold" style="text-shadow: 1px 1px 0 #000, -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000;"><i class="fas fa-fw fa-award"></i> Capaian Indikator</h4>
                                                </div>
                                                <?php if (count($capaian_indikator) > 0){ ?>
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-bordered" style="font-size: 12px;">
                                                            <tr style="background-color: burlywood;">
                                                                <td class="font-weight-bold border-gray-600" style="width: 5%" align="center">No</td>
                                                                <td class="font-weight-bold border-gray-600" style="width: 80%" align="center">Nama Indikator</td>
                                                                <td class="font-weight-bold border-gray-600" style="width: 15%" align="center">Aksi</td>
                                                            </tr>
                                                            <?php foreach ($capaian_indikator as $key => $value) { ?>
                                                                <tr>
                                                                    <td class="border-gray-600" align="center"><?= $key+1 ?></td>
                                                                    <td class="border-gray-600 font-italic nowrap text-muted font-weight-bold"><?= $value->nama_aspek.' - '. str_replace('?','', str_replace('ananda','', str_replace('Apakah','', $value->nama_indikator))).' <span class="text-success">('.$value->nama_usia.')</span>' ?></td>
                                                                    <td class="border-gray-600" align="center">
                                                                        <div class="d-flex align-items-center justify-content-center">
                                                                            <span class="btn btn-sm btn-success btn-update" data-id="<?= $value->id_capaianindikator ?>" data-nama="<?= str_replace('?','', str_replace('ananda','', str_replace('Apakah','', $value->nama_indikator))) ?>"><span class="fas fa-eye"></span> Data Dukung</span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </table>
                                                    </div>
                                                <?php }else{ ?>
                                                    <span class="text-muted font-italic">Data Kosong!</span>
                                                <?php } ?>
                                            <?php }else{ ?>
                                                <span class="text-danger font-italic text-small d-flex align-items-center justify-content-center font-weight-bold">Data stimulus kosong!</span>
                                            <?php } ?>
                                            <br>
                                            <h5><b><i class="fas fa-fw fa-photo-film"></i> Dokumentasi Aktivitas</b></h5>
                                            <div class="file-loading">
                                                <input id="file_dukungall" name="file_dukungall[]" type="file" accept="image/*,video/*" multiple>
                                            </div>
                                        <?php }else{ ?>
                                            <?php if (!empty($data_anak)){ ?>
                                                <h5 class="card-title mb-1 d-flex align-content-center justify-content-center"><span class="text-danger font-weight-bold">Data aktivitas untuk hari ini kosong/belum diinputkan oleh educator!</span></h5>
                                            <?php } ?>
                                        <?php } ?>
                                        <p class="font-italic float-right"><span class="fas fa-info-circle"></span>&nbsp;<span class="text-muted" style="font-size: 11px">Laporan aktivitas harian anak.</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end of col-->
                    </div>
                    <!-- end of main-content -->
                </div><!-- Footer Start -->
                <!--  Modal -->
                <?php $this->load->view('layout/footer') ?>
                <div class="modal fade" id="updating-indikator" tabindex="-1" role="dialog" aria-labelledby="updating" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="card-title mb-1 d-flex align-items-center justify-content-center">Capaian Indikator&nbsp;a.n&nbsp;<span class="text-success font-weight-bold"><?= $data_anak->nama_anak ?></span>&nbsp;Usia:&nbsp;<span class="text-info"><?= hitung_usia($data_anak->tanggal_lahir) ?> <span class="text-muted">(<?= $data_anak->nama_kelas ?>)</span></span></h5>
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
                            </div>
                        </div>
                    </div>
                </div>
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
        let initialPreview_all = <?= isset($dokumentasi_file['preview']) ? json_encode($dokumentasi_file['preview']):'0' ?>;
        let initialPreviewConfig_all = <?= isset($dokumentasi_file['config']) ? json_encode($dokumentasi_file['config']):'0' ?>;

        $(document).ready(function() {
            $('.select2').select2();

            let file_input = $('#file_dukung'), initPlugin = function() {
                file_input.fileinput({
                    uploadUrl: url+'/uploadfile',
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

            let file_input_all = $('#file_dukungall'), initPluginAll = function() {
                file_input_all.fileinput({
                    uploadUrl: url+'/uploadfile',
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
                    initialPreview: initialPreview_all,
                    initialPreviewConfig: initialPreviewConfig_all,
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
            initPluginAll();

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
        });

        function resetInput(){
            $('#id_rincianjadwal_mingguan').html('');
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

                    $.each(data_tanggal, function(key, value){
                        $('#id_rincianjadwal_mingguan').append('<option value="'+value.id_rincianjadwal_mingguan+'">Tema: '+value.nama_tema+', '+ value.nama_hari + ' ' +value.tanggal+' ('+value.nama_subtema+')</option>');
                    });
                }
            });
        }
    </script>
</html>