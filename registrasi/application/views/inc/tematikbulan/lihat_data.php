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
                            <li>Data Tematik</li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="<?= base_url().$redirect ?>" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Kembali</a>
                            <div class="card text-left">
                                <div class="card-body">
                                    <h5 class="card-title d-flex align-items-center justify-content-center">Rencana Belajar Bulanan untuk Tematik Tahun <?= $tahun_tematik ?>&nbsp;dengan Tema&nbsp;<span class="text-success font-weight-bold"><?= $tema_tahun->uraian ?></span></h5>
                                    <fieldset>
                                        <div class="accordion" id="accordionRightIcon">
                                            <?php foreach ($list_bulan as $bulan){
                                                if (empty($bulan->id_temabulanan)){
                                                    $temp_uraian = '<span style="color: black">'.$bulan->nama_bulan.'</span>&nbsp;&nbsp;&nbsp;<span class="text-danger text-small">( tema belum ditentukan! )</span>';
                                                    $btn_bulan = '&nbsp;<span class="btn btn-sm btn-success tentukan_tema" data-id="'.$bulan->bulan.'" data-nama="'.$bulan->nama_bulan.'"><span class="fas fa-plus"></span>&nbsp;Tentukan</span>';
                                                }else{
                                                    $temp_uraian = '<span style="color: black">'.$bulan->nama_bulan.'</span>&nbsp;&nbsp;&nbsp;<span class="text-success text-small">( Tema: <b>'.$bulan->nama_temabulanan.'</b> )</span>';
                                                    $temp_uraian .= '&nbsp;<span class="text-muted text-small"><i>terakhir update ';
                                                    if (empty($bulan->updated_at)){
                                                        $temp_uraian .= timeAgo($bulan->created_at);
                                                    }else{
                                                        $temp_uraian .= timeAgo($bulan->updated_at);
                                                    }
                                                    $temp_uraian .= ' oleh '.$bulan->nama_role.' ('.$bulan->nama_user.')</i></span>';
                                                    $btn_bulan = '&nbsp;<span class="btn btn-sm btn-warning edit_tema" data-id="'.$bulan->id_temabulanan.'" data-nama="'.$bulan->nama_bulan.'"><span class="fas fa-edit"></span>&nbsp;Update</span>';
                                                } ?>
                                                <div class="card">
                                                    <div class="card-header header-elements-inline" style="background-color: rgb(231 240 255) !important;">
                                                        <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                                            <a class="text-default collapsed" data-toggle="collapse" href="#accordion-item-icon-right-<?= $bulan->bulan ?>" aria-expanded="false"><?= $temp_uraian; ?></a><?= $btn_bulan ?>
                                                        </h6>
                                                    </div>
                                                    <div class="collapse" id="accordion-item-icon-right-<?= $bulan->bulan ?>" data-parent="#accordionRightIcon">
                                                        <div class="card-body ">
                                                            <?php if (!empty($bulan->id_temabulanan)){ ?>
                                                                <h5 class="card-title d-flex align-items-center justify-content-center">Tematik Bulan&nbsp;<b><?= $bulan->nama_bulan ?></b>&nbsp;dengan Tema&nbsp;<span class="text-success font-weight-bold"><?= $bulan->nama_temabulanan ?></span></h5>
                                                                <br>
                                                                <div class="mb-3 d-flex justify-content-between align-items-center">
                                                                    <span class="text-muted font-italic text-small">
                                                                    <?php if (!empty($bulan->deskripsi)){ ?>
                                                                        <b>Keterangan:&nbsp;</b><?= $bulan->deskripsi ?>
                                                                    <?php } ?>
                                                                    </span>
                                                                    <button class="btn btn-sm btn-primary"><span class="fas fa-plus"></span>&nbsp;Tambah Sub Tema</button>
                                                                </div>
                                                                <div class="table-responsive">
                                                                    <table class="display table table-bordered table-sm" >
                                                                        <tr class="bg-gray-300">
                                                                            <th class="font-weight-bold">Periode</th>
                                                                            <th class="font-weight-bold">Nama Sub Tema</th>
                                                                            <th class="font-weight-bold">Tanggal Pelaksanaan</th>
                                                                            <th class="font-weight-bold">Aksi</th>
                                                                        </tr>
                                                                        <?php if (isset($data_subtema[$bulan->id_temabulanan]) && count($data_subtema[$bulan->id_temabulanan]) > 0){
                                                                            foreach ($data_subtema[$bulan->id_temabulanan] as $key => $subtema){
                                                                                $iter = 0;
                                                                                foreach ($data_mingguan[$subtema['id_jadwalmingguan']] as $mingguan){ ?>
                                                                                    <tr>
                                                                                        <?php if ($iter == 0){ ?>
                                                                                            <td align="center" rowspan="<?= count($data_mingguan[$subtema['id_jadwalmingguan']]) ?>"><span class="font-italic font-weight-bold">Minggu ke <?= ($key+1) ?></span></td>
                                                                                            <td rowspan="<?= count($data_mingguan[$subtema['id_jadwalmingguan']]) ?>"><?= $subtema['nama_subtema'] ?></td>
                                                                                        <?php } ?>
                                                                                        <td><?= $mingguan['tanggal'] ?></td>
                                                                                        <td></td>
                                                                                    </tr>
                                                                            <?php $iter++; }
                                                                            }
                                                                        }else{ ?>
                                                                            <tr>
                                                                                <td colspan="4" align="center"><i class="text-small text-danger font-weight-bold">Data sub tema kosong!</i></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                    </table>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </fieldset>
                                    <p class="font-italic float-right mt-5"><span class="fas fa-info-circle"></span>&nbsp;<span class="text-muted">Setiap bulan memiliki <b>tema dan sub tema</b> untuk mingguan, per sub tema akan ditentukan <b>tanggal mingguanya</b>.</span></p>
                                </div>
                            </div>
                        </div>
                        <!-- end of col-->
                    </div>
                    <!-- end of main-content -->
                </div><!-- Footer Start -->

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

        $(document).ready(function() {
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
        });

        $('.tentukan_tema').click(function(){
            clearFormStatus("#frm_tambah");

            let bulan = $(this).data('id')
            let nama_bulan = $(this).data('nama')

            $("#label_nama_bulan").html(nama_bulan);
            $("#bulan_penentuan").val(bulan);
            $("#adding-modal").modal('show');
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