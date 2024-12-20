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
                            <li><a href="#">Dashboard</a></li>
                            <li><a href="#"><?= $title ?></a></li>
                            <li>Detail Capaian Indikator</li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="<?= base_url().$redirect ?>" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Kembali</a>
                            <div class="card text-left">
                                <div class="card-body">
                                    <?php echo form_open_multipart($controller.'/cetakcapaian', 'target="blank"'); ?>
                                    <div class="row d-flex justify-content-center align-items-center">
                                        <div class="col-sm-10">
                                            <h5 class="card-title mb-1 d-flex align-content-center justify-content-between"><span class="float-left">Capaian Indikator&nbsp;a.n&nbsp;<span class="text-success font-weight-bold"><?= $data_anak->nama ?></span>&nbsp;Usia:&nbsp;<span class="text-info"><?= hitung_usia($data_anak->tanggal_lahir) ?> <span class="text-muted">(<?= $data_anak->nama_kelas ?>)</span></span></span></h5>
                                        </div>
                                        <div class="col-sm-2">
                                            <button class="btn btn-sm btn-primary float-right"><span class="fas fa-print"></span>&nbsp;Cetak Capaian</button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="id_anak" value="<?= $data_anak->id ?>">
                                    </form>
                                    <br>
                                        <div class="table-responsive">
                                            <table class="display table table-sm table-bordered" id="example">
                                                <thead style="background-color: #bfdfff">
                                                    <tr>
                                                        <th style="width: 5%">No</th>
                                                        <th style="width: 15%">Nama Aspek</th>
                                                        <th style="width: 50%">Nama Indikator</th>
                                                        <th style="width: 15%">Status</th>
                                                        <th style="width: 15%">Data Pendukung</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 0; $id_usian=0; foreach ($capaian_indikator as $indktr){ $temp_id_usia = $indktr->id_usia; ?>
                                                        <?php if ($id_usian != $temp_id_usia){ $i = 0; ?>
                                                            <tr style="background-color: antiquewhite">
                                                                <td align="center" colspan="5" ><b><?= $indktr->nama_usia; ?></b></td>
                                                            </tr>
                                                            <?php $id_usian = $temp_id_usia; $i++; } ?>
                                                        <tr>
                                                            <td align="center"><?= $i++; ?></td>
                                                            <td align="center" nowrap><b><?= $indktr->nama_aspek ?></b></td>
                                                            <td><span class="font-italic text-muted"><?= str_replace('?','', str_replace('ananda','', str_replace('Apakah','', $indktr->nama_indikator))) ?></span></td>
                                                            <td align="center">
                                                                <?= !empty($indktr->is_capai)? '<span class="badge badge-success">tercapai</span>':'<span class="badge badge-danger">belum tercapai</span>' ?>
                                                            </td>
                                                            <td align="center" nowrap>
                                                                <?php if(!empty($indktr->is_capai)){ ?>
                                                                    <span class="btn btn-sm btn-info btn-icon" onclick="goDetailAktivitas('<?= $data_anak->id ?>', '<?= $indktr->tahun ?>', '<?= $indktr->id_rincianjadwal_mingguan ?>')"><span class="fas fa-running"></span>&nbsp; Aktivitas</span>
                                                                    <span class="btn btn-sm btn-success btn-update" data-id="<?= $indktr->is_capai ?>" data-nama="<?= str_replace('?','', str_replace('ananda','', str_replace('Apakah','', $indktr->nama_indikator))) ?>"><span class="fas fa-eye"></span> Data Dukung</span>
                                                                <?php }else{ ?>
                                                                    -
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <p class="font-italic float-right mt-5"><span class="fas fa-info-circle"></span>&nbsp;<span class="text-muted" style="font-size: 11px">Capaian Indikator yang <b>ditampilkan</b> adalah sesuai <b>usia anak</b> tersebut.</span></p>
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
                <div class="modal fade" id="updating-indikator" tabindex="-1" role="dialog" aria-labelledby="updating" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="card-title mb-1 d-flex align-items-center justify-content-center">Capaian Indikator&nbsp;a.n&nbsp;<span class="text-success font-weight-bold"><?= $data_anak->nama ?></span>&nbsp;Usia:&nbsp;<span class="text-info"><?= hitung_usia($data_anak->tanggal_lahir) ?> <span class="text-muted">(<?= $data_anak->nama_kelas ?>)</span></span></h5>
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
                <?php echo form_open_multipart('caktivitashariananak', 'id="frm_lihatdetail" target="_blank"' ); ?>
                    <input type="hidden" name="tahun" id="tahun">
                    <input type="hidden" name="id_rincianjadwal_mingguan" id="id_rincianjadwal_mingguan">
                    <input type="hidden" name="id_anak" id="id_anak">
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

        let initialPreview = [];
        let initialPreviewConfig = [];

        $(document).ready(function() {
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

            initPlugin();

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

        function goDetailAktivitas(id_anak, tahun, id_rincianjadwal_mingguan){
            $('#tahun').val(tahun);
            $('#id_rincianjadwal_mingguan').val(id_rincianjadwal_mingguan);
            $('#id_anak').val(id_anak);

            $('#frm_lihatdetail').submit();
        }
    </script>
</html>