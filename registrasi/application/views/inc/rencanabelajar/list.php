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
                                        <table class="display table table-striped table-bordered" id="zero_configuration_table_rencana" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <!-- <th>#</th> -->
                                                    <th>Bulan</th>
                                                    <th>Tanggal</th>
                                                    <th>Tema/RPPB</th>
                                                    <th>Sub Tema/RPPM</th>
                                                    <th>Sub Sub Tema/RPPH</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                             <tbody>
                                                <?php 
                                                $i = 1 ;
                                                foreach ($list as $key =>$row) { ?>
                                                    <tr>
                                                        <!-- <td><?= $i++ ?></td> -->
                                                        <td><?= date("M Y", strtotime($row->tanggal)) ?> </td>
                                                        <td><?= date("d", strtotime($row->tanggal)) ?> </td>
                                                        <td><?= ucwords($row->tema) ?></td>
                                                        <td><?= ucwords($row->subtema) ?></td>
                                                        <td><?= ucwords($row->subsubtema) ?></td>
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
                                                    <th>Bulan</th>
                                                    <th>Tanggal</th>
                                                    <th>Tema/RPPB</th>
                                                    <th>Sub Tema/RPPM</th>
                                                    <th>Sub Sub Tema/RPPH</th>
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
                                            <label>Kalender</label>
                                            <input class="form-control" type="date" required name="tanggal">
                                        </div>
                                        <div class="form-group">
                                            <label>Tema/RPPB</label>
                                            <input class="form-control" type="text" required name="tema">
                                        </div>
                                        <div class="form-group">
                                            <label>Sub Tema/RPPM</label>
                                            <input class="form-control" type="text" required name="subtema">
                                        </div>
                                        <div class="form-group">
                                            <label>Sub Sub Tema/RPPH</label>
                                            <input class="form-control" type="text" required name="subsubtema">
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
                                            <label>Kalender</label>
                                            <input class="form-control" type="date" required name="tanggal" id="tanggal">
                                        </div>
                                        <div class="form-group">
                                            <label>Tema/RPPB</label>
                                            <input class="form-control" type="text" required name="tema" id="tema">
                                        </div>
                                        <div class="form-group">
                                            <label>Sub Tema/RPPM</label>
                                            <input class="form-control" type="text" required name="subtema" id="subtema">
                                        </div>
                                        <div class="form-group">
                                            <label>Sub Sub Tema/RPPH</label>
                                            <input class="form-control" type="text" required name="subsubtema" id="subsubtema">
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
                    $("#tema").val(data['list_edit']['tema']);    
                    $("#tanggal").val(data['list_edit']['tanggal']);    
                    $("#subtema").val(data['list_edit']['subtema']);    
                    $("#subsubtema").val(data['list_edit']['subsubtema']);                                    
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

        if ('#zero_configuration_table_rencana') {
            $('#zero_configuration_table_rencana').dataTable({
                "ordering": false,
                "searching": false,
                "lengthChange": false,
                'dom': 'Bfrtip',
                'buttons': [
                    'excel'
                ]
            });
        }  
    </script>
</html>