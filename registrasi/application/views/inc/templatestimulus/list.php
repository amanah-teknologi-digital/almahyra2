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
                            <li><?= $title ?></li>
                        </ul>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12 mb-4">
                            <div class="card text-left">
                                <div class="card-body">
                                    <button class="btn btn-info m-1 mb-4 add-button" type="button" data-toggle="modal" data-target="#adding-modal">Tambah</button>
                                    <div class="table-responsive">
                                        <table class="display table table-striped table-bordered" id="tbl" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <!-- <th>#</th> -->
                                                    <th style="width: 5%">No</th>
                                                    <th style="width: 20%">Nama Template Stimulus</th>
                                                    <th style="width: 25%">Nama Stimulus</th>
                                                    <th style="width: 35%">Timestamp</th>
                                                    <th style="width: 15%">Action</th>
                                                </tr>
                                            </thead>
                                             <tbody>
                                                <?php 
                                                $i = 1 ;
                                                foreach ($list as $key =>$row) { ?>
                                                    <tr>
                                                        <td align="center"><?= $key+1 ?></td>
                                                        <td><?= $row->nama_template ?></td>
                                                        <td><?= $row->nama ?></td>
                                                        <td>
                                                            <p><span class="text-muted"><i>terakhir update <?= empty($row->updated_at)? timeAgo($row->created_at):timeAgo($row->updated_at); ?> oleh <?= $row->nama_role.' ('.$row->nama_user.')' ?></i></span></p>
                                                        </td>
                                                        <td align="center">
                                                            <button class="btn btn-outline-warning btn-icon edit" type="button" data-id="<?= $row->id_templatestimulus; ?>">
                                                                    <span class="ul-btn__icon">
                                                                        <i class="i-Pen-3"></i>
                                                                    </span>
                                                            </button>
                                                            <button class="btn btn-outline-danger btn-icon delete" type="button" data-id="<?= $row->id_templatestimulus; ?>">
                                                                    <span class="ul-btn__icon">
                                                                        <i class="i-Close-Window"></i>
                                                                    </span>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <!-- <th>#</th> -->
                                                    <th>No</th>
                                                    <th>Nama Template Stimulus</th>
                                                    <th>Nama Stimulus</th>
                                                    <th>Timestamp</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <p class="font-italic float-right"><span class="fas fa-info-circle"></span>&nbsp;<span class="text-muted" style="font-size: 11px">Template Stimulasi bisa digunakan pada <b>semua kelas</b> dan <b>semua jadwal harian</b>.</span></p>
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
                        <?php echo form_open_multipart($controller.'/insert'); ?>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Penambahan Template Stimulus</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">                                   
                                    <fieldset>
                                        <div class="form-group">
                                            <label>Tahun</label>
                                            <input type="number" class="form-control" required name="tahun" id="tahun_tambah" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label>Uraian Tema</label>
                                            <input class="form-control" type="text" required name="name" id="name_tambah" autocomplete="off">
                                        </div>
                                    </fieldset>                                    
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                    <button class="btn btn-primary ml-2" type="submit">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="modal fade" id="updating-modal" tabindex="-1" role="dialog" aria-labelledby="updating" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <?php echo form_open_multipart($controller.'/update'); ?>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Perbaharuan Data</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">
                                    <fieldset>
                                        <div class="form-group">
                                            <label>Tahun</label>
                                            <p id="tahunedit" style="font-weight: bold"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Uraian Tema</label>
                                            <input class="form-control" type="text" required name="name" id="name_edit" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label>Status</label>
                                            <p id="statusedit" style="font-weight: bold"></p>
                                        </div>
                                        <input type="hidden" name="id" id="id">
                                    </fieldset>                                    
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                    <button class="btn btn-primary ml-2" type="submit">Simpan</button>
                                </div>
                            </div>
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

        $('.edit').click(function(){
            $.ajax({
                url: url + '/edit/' + $(this).data('id'),
                type:'GET',
                dataType: 'json',
                success: function(data){
                    
                    $("#id").val(data['list_edit']['tahun']);
                    $("#tahunedit").html(data['list_edit']['tahun']);
                    $("#name_edit").val(data['list_edit']['uraian']);
                    if (data['list_edit']['is_aktif'] === '1'){
                        $("#statusedit").html('<span class="badge badge-success">Aktif</span>');
                    }else{
                        $("#statusedit").html('<span class="badge badge-danger">Tidak Aktif</span>');
                    }

                    $("#updating-modal").modal('show');
                }                
            }); 
        })

        $('.delete').click(function () {
            var id = $(this).data('id') ;
            swal({
                title: 'Apakah yakin data ini ingin di hapus? ',
                showCancelButton: true,
                confirmButtonColor: '#4caf50',
                cancelButtonColor: '#f44336',
                confirmButtonText: 'Ya, Lanjutkan hapus!',
                cancelButtonText: 'Batal',
            }).then(function () {
                window.location = url + '/delete/' + id ;
            })
        });
    </script>
</html>