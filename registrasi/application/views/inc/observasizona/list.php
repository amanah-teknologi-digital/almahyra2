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
                            <li><a href="#">Observasi</a></li>
                            <li><?= $title ?></li>
                        </ul>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12 mb-4">
                            <div class="card text-left">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <!-- <th>#</th> -->
                                                    <th>Nama</th>
                                                    <th>Panggilan</th>
                                                    <th>Tempat/Tanggal Lahir</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                             <tbody>
                                                <?php 
                                                $i = 1 ;
                                                foreach ($list as $key =>$row) { ?>
                                                    <tr>
                                                        <!-- <td><?= $i++ ?></td> -->
                                                        <td><?= ucwords($row->nama) ?></td>
                                                        <td><?= ucwords($row->nick) ?></td>
                                                        <td><?= ucwords($row->tempat_lahir) ?>, <?= date("d M Y", strtotime($row->tanggal_lahir)) ?> </td>
                                                        <td><?= strtoupper($row->jenis_kelamin) ?></td>
                                                        <?php if ($this->session->userdata['auth']->id_role == 4): ?>
                                                        <td align="center">
                                                            <button class="btn btn-outline-warning btn-icon orangtua" type="button" data-id="<?= $row->id; ?>">
                                                                <span class="ul-btn__icon">
                                                                    <i class="i-Pen-3"></i>
                                                                </span>
                                                            </button>                                         
                                                        </td>
                                                        <?php else: ?>
                                                        <td align="center">
                                                            <button class="btn btn-outline-warning btn-icon edit" type="button" data-id="<?= $row->id; ?>">
                                                                <span class="ul-btn__icon">
                                                                    <i class="i-Pen-3"></i>
                                                                </span>
                                                            </button>                                         
                                                        </td>
                                                        <?php endif ?>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                            
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
                <div class="modal fade" id="updating-modal" tabindex="-1" role="dialog" aria-labelledby="updating" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <?php echo form_open_multipart($controller.'/insert'); ?>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Update Data</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">
                                    <fieldset>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Tanggal Input</label>
                                                    <input class="form-control" type="date" name="tanggal" required value="<?= date('Y-m-d'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <div class="row">
                                            <!-- <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Pengajar</label>
                                                    <select class="form-control" name="id_pengajar" required>
                                                        <?php foreach ($pengajar as $key => $p): ?>
                                                        <option value="<?= $p->id ?>"><?= $p->name ?></option>    
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div> -->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Zona</label>
                                                    <select class="form-control" name="id_zona" required>
                                                        <?php foreach ($zona as $key => $p): ?>
                                                        <option value="<?= $p->id ?>"><?= $p->name .' | '. $p->usia.' | '.$p->pengasuh ?> <?= $p->status == 1 ? '(ABK)':'(Non ABK)' ?></option>    
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>  

                                    <hr>
                                    <div class="table-responsive">
                                        <table class="display table table-striped table-bordered" id="tbl" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <!-- <th>#</th> -->
                                                    <th>Tanggal</th>
                                                    <th>Educator</th>
                                                    <th>Zona</th>
                                                    <th>Status</th>
                                                    <th>Hapus</th>
                                                </tr>
                                            </thead>
                                             <tbody>
                                            </tbody>
                                        </table>
                                    </div>                                  
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="id_anak" id="id_anak">                                    
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                    <button class="btn btn-primary ml-2" type="submit">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="modal fade" id="orang-tua-modal" tabindex="-1" role="dialog" aria-labelledby="orangtua" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <?php echo form_open_multipart($controller.'/insert'); ?>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Update Data</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">
                                    <div class="table-responsive">
                                        <table class="display table table-striped table-bordered" id="tblot" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <!-- <th>#</th> -->
                                                    <th>Tanggal</th>
                                                    <th>Educator</th>
                                                    <th>Zona</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                             <tbody>
                                            </tbody>
                                        </table>
                                    </div>                                  
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
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

        var role = "<?= $this->session->userdata['auth']->id_role ?>";

        $('.edit').click(function(){
            var id_anak = $(this).data('id') ;
            $("#tbl > tbody").empty();

            $.ajax({
                url: url + '/edit/' + $(this).data('id'),
                type:'GET',
                dataType: 'json',
                success: function(data){
                    
                    $("#id_anak").val(id_anak);  

                    if (data['list_zona'].length > 0) {
                        $("#id").val(data['list_edit']['id']);

                        $.each(data['list_zona'], function( index, row ) {
                            
                            $("#tbl > tbody").append(
                                "<tr>"+
                                    "<td align='center'>"+row.tanggal+"</td>"+
                                    "<td align='center'>"+row.pengajar+"</td>"+
                                    "<td align='center'>"+row.zona+"</td>"+
                                    "<td align='center'>"+(row.status == 1 ? 'ABK' : 'Non ABK')+"</td>"+
                                    "<td align='center'>"+ 
                                        '<button class="btn btn-outline-danger btn-icon" type="button" onclick="deleteList('+ row.id +')">' + 
                                            '<span class="ul-btn__icon">' +
                                                '<i class="i-Close-Window"></i>' +
                                            '</span>' +
                                        '</button>' +
                                    "</td>"+
                                "</tr>"
                            );                          
                            
                        });
                        
                    } 

                    $("#updating-modal").modal('show');
                }                
            }); 
        })

        $('.orangtua').click(function(){
            var id_anak = $(this).data('id') ;
            $("#tblot > tbody").empty();

            $.ajax({
                url: url + '/edit/' + $(this).data('id'),
                type:'GET',
                dataType: 'json',
                success: function(data){
                    
                    $("#id_anak").val(id_anak);  

                    if (data['list_zona'].length > 0) {
                        $("#id").val(data['list_edit']['id']);

                        $.each(data['list_zona'], function( index, row ) {
                            if (role == 4) {
                                $("#tblot > tbody").append(
                                    "<tr>"+
                                        "<td align='center'>"+row.tanggal+"</td>"+
                                        "<td align='center'>"+row.pengajar+"</td>"+
                                        "<td align='center'>"+row.zona+"</td>"+
                                        "<td align='center'>"+(row.status == 1 ? 'ABK' : 'Non ABK')+"</td>"+
                                    "</tr>"
                                );
                            }                           
                        });
                        
                    } 

                    $("#orang-tua-modal").modal('show');
                }                
            }); 
        })

        function deleteList(id) {
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
        }
    </script>
</html>


                                                                
                                                                    
                                                                
                                                            