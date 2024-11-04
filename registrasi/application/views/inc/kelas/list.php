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
                            <li><a href="#">Referensi</a></li>
                            <li><?= $title ?></li>
                        </ul>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12 mb-4">
                            <div class="card text-left">
                                <div class="card-body">
                                    <button class="btn btn-info m-1 mb-4 add-button" type="button" data-toggle="modal" data-target="#adding-modal">Tambah</button>

                                    <div class="table-responsive">
                                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <!-- <th>#</th> -->
                                                    <th>Nama <?= $title ?></th>
                                                    <th>Status</th>
                                                    <th>Usia</th>
                                                    <th>Pengasuh</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                             <tbody>
                                                <?php 
                                                $i = 1 ;
                                                foreach ($list as $key =>$row) { ?>
                                                    <tr>
                                                        <!-- <td><?= $i++ ?></td> -->
                                                        <td><?= ucwords($row->name) ?></td>
                                                        <td><?= $row->status == 1 ? 'ABK':'Non ABK'; ?></td>
                                                        <td><?= ($row->usia) ?></td>
                                                        <td><?= ucwords($row->pengasuh) ?></td>
                                                        <td align="center">
                                                            <button class="btn btn-outline-warning btn-icon edit" type="button" data-id="<?= $row->id; ?>">
                                                                <span class="ul-btn__icon">
                                                                    <i class="i-Pen-3"></i>
                                                                </span>
                                                            </button>   
                                                            <button class="btn btn-outline-danger btn-icon delete" type="button" data-id="<?= $row->id; ?>">
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
                                                    <th>Nama <?= $title ?></th>
                                                    <th>Status</th>
                                                    <th>Usia</th>
                                                    <th>Pengasuh</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
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
                                    <h5 class="modal-title">Penambahan Data</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">                                   
                                    <fieldset>
                                        <div class="form-group">
                                            <label>Nama <?= $title ?></label>
                                            <input class="form-control" type="text" required name="name">
                                        </div>
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" required name="status">
                                                <option>Pilih Status</option>
                                                <option value="1">ABK</option>
                                                <option value="2">Non ABK</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Usia</label>
                                            <select class="form-control" required name="id_usia">
                                                <option>Pilih Usia</option>
                                                <?php foreach ($usia as $key => $d): ?>
                                                    <option value="<?= $d->id ?>" > <?= $d->name ?> </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Pengasuh</label>
                                            <select class="form-control" required name="id_pengasuh">
                                                <option>Pilih Pengasuh</option>
                                                <?php foreach ($pengasuh as $key => $d): ?>
                                                    <option value="<?= $d->id ?>" > <?= $d->name ?> </option>
                                                <?php endforeach ?>
                                            </select>
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
                                            <label>Nama <?= $title ?></label>
                                            <input class="form-control" type="text" required name="name" id="name">
                                        </div>
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" required name="status" id="status"> 
                                                <option>Pilih Status</option>
                                                <option value="1">ABK</option>
                                                <option value="2">Non ABK</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Usia</label>
                                            <select class="form-control" required name="id_usia" id="id_usia">
                                                <option>Pilih Usia</option>
                                                <?php foreach ($usia as $key => $d): ?>
                                                    <option value="<?= $d->id ?>" > <?= $d->name ?> </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Pengasuh</label>
                                            <select class="form-control" required name="id_pengasuh" id="id_pengasuh">
                                                <option>Pilih Pengasuh</option>
                                                <?php foreach ($pengasuh as $key => $d): ?>
                                                    <option value="<?= $d->id ?>" > <?= $d->name ?> </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        
                                    </fieldset>                                    
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="id" id="id">
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
                    
                    $("#id").val(data['list_edit']['id']);  
                    $("#name").val(data['list_edit']['name']);  
                    $("#status").val(data['list_edit']['status']);  
                    $("#id_usia").val(data['list_edit']['id_usia']);  
                    $("#id_pengasuh").val(data['list_edit']['id_pengasuh']);                                    
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