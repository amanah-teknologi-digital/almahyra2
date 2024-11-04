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
                                                    <th>Time Schedule </th>
                                                    <th>Time Actual </th>
                                                    <th>Tema / Subtema / Sub Subtema</th>
                                                    <th>Usia, Zona</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                             <tbody>
                                                <?php 
                                                $i = 1 ;
                                                foreach ($list as $key =>$row) { ?>
                                                    <tr>
                                                        <!-- <td><?= $i++ ?></td> -->
                                                        <td><?= date("d M Y", strtotime($row->ts)) ?> </td>
                                                        <td><?= date("d M Y", strtotime($row->ta)) ?> </td>
                                                        <td><?= ucwords($row->tema) ?></td>
                                                        <td><?= ucwords($row->usia_zone) ?></td>
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
                                                            <button class="btn btn-outline-info btn-icon rpp" type="button" data-id="<?= $row->id; ?>">
                                                                <span class="ul-btn__icon">
                                                                    <i class="i-Eye"></i>
                                                                </span>
                                                            </button>  
                                                        
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <!-- <th>#</th> -->
                                                    <th>Time Schedule </th>
                                                    <th>Time Actual </th>
                                                    <th>Tema / Subtema / Sub Subtema</th>
                                                    <th>Usia, Zona</th>
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
                    <div class="modal-dialog modal-lg" role="document">
                        <?php echo form_open_multipart($controller.'/insert'); ?>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Penambahan Data</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">                                   
                                    <fieldset>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Time Schedule</label>
                                                    <input class="form-control" type="date" required name="ts">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Time Actual</label>
                                                    <input class="form-control" type="date" required name="ta">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tema / Subtema / Sub Subtema</label>
                                                    <textarea class="form-control" required name="tema" placeholder="Pisahkan dengan '/'"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Usia, Zona </label>
                                                    <textarea class="form-control" required name="usia_zone" placeholder="Pisahkan dengan ','"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>NAM </label>
                                                    <textarea class="form-control" required name="nam" placeholder="Pisahkan dengan ','"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>FM </label>
                                                    <textarea class="form-control" required name="fm" placeholder="Pisahkan dengan ','"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>KOG </label>
                                                    <textarea class="form-control" required name="kog" placeholder="Pisahkan dengan ','"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>BHS </label>
                                                    <textarea class="form-control" required name="bhs" placeholder="Pisahkan dengan ','"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Sosem </label>
                                                    <textarea class="form-control" required name="sosem" placeholder="Pisahkan dengan ','"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Seni </label>
                                                    <textarea class="form-control" required name="seni" placeholder="Pisahkan dengan ','"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Tujuan </label>
                                                    <textarea class="form-control" required name="tujuan" placeholder="Pisahkan dengan ';'"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Materi Kegiatan </label>
                                                    <textarea class="form-control" required name="materi" placeholder="Pisahkan dengan ';'"></textarea>
                                                </div>
                                            </div>
                                             <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Alat bahan </label>
                                                    <textarea class="form-control" required name="alat" placeholder="Pisahkan dengan ';'"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Kegiatan Pembuka </label>
                                                    <textarea class="form-control" required name="pembuka" placeholder="Pisahkan dengan ';'"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Kegiatan Inti </label>
                                                    <textarea class="form-control" required name="inti" placeholder="Pisahkan dengan ';'"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Kegiatan Penutup </label>
                                                    <textarea class="form-control" required name="penutup" placeholder="Pisahkan dengan ';'"></textarea>
                                                </div>
                                            </div>
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
                    <div class="modal-dialog modal-lg" role="document">
                        <?php echo form_open_multipart($controller.'/update'); ?>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Perbaharuan Data</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">
                                     <fieldset>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Time Schedule</label>
                                                    <input class="form-control" type="date" required name="ts" id="ts">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Time Actual</label>
                                                    <input class="form-control" type="date" required name="ta" id="ta">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tema / Subtema / Sub Subtema</label>
                                                    <textarea class="form-control" required name="tema" placeholder="Pisahkan dengan '/'" id="tema"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Usia, Zona </label>
                                                    <textarea class="form-control" required name="usia_zone" placeholder="Pisahkan dengan ','" id="usia_zone"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>NAM </label>
                                                    <textarea class="form-control" required name="nam" placeholder="Pisahkan dengan ','" id="nam"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>FM </label>
                                                    <textarea class="form-control" required name="fm" placeholder="Pisahkan dengan ','" id="fm"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>KOG </label>
                                                    <textarea class="form-control" required name="kog" placeholder="Pisahkan dengan ','" id="kog"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>BHS </label>
                                                    <textarea class="form-control" required name="bhs" placeholder="Pisahkan dengan ','" id="bhs"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Sosem </label>
                                                    <textarea class="form-control" required name="sosem" placeholder="Pisahkan dengan ','" id="sosem"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Seni </label>
                                                    <textarea class="form-control" required name="seni" placeholder="Pisahkan dengan ','" id="seni"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Tujuan </label>
                                                    <textarea class="form-control" required name="tujuan" placeholder="Pisahkan dengan ';'" id="tujuan"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Materi Kegiatan </label>
                                                    <textarea class="form-control" required name="materi" placeholder="Pisahkan dengan ';'" id="materi"></textarea>
                                                </div>
                                            </div>
                                             <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Alat bahan </label>
                                                    <textarea class="form-control" required name="alat" placeholder="Pisahkan dengan ';'" id="alat"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Kegiatan Pembuka </label>
                                                    <textarea class="form-control" required name="pembuka" placeholder="Pisahkan dengan ';'" id="pembuka"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Kegiatan Inti </label>
                                                    <textarea class="form-control" required name="inti" placeholder="Pisahkan dengan ';'" id="inti"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Kegiatan Penutup </label>
                                                    <textarea class="form-control" required name="penutup" placeholder="Pisahkan dengan ';'" id="penutup"></textarea>
                                                </div>
                                            </div>
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
                    $("#ts").val(data['list_edit']['ts']);    
                    $("#ta").val(data['list_edit']['ta']);    
                    
                    $("#tema").text(data['list_edit']['tema']);    
                    $("#usia_zone").text(data['list_edit']['usia_zone']);    
                    $("#nam").text(data['list_edit']['nam']); 
                    $("#fm").text(data['list_edit']['fm']); 

                    $("#kog").text(data['list_edit']['kog']);    
                    $("#bhs").text(data['list_edit']['bhs']);    
                    $("#sosem").text(data['list_edit']['sosem']); 
                    $("#seni").text(data['list_edit']['seni']); 

                    $("#tujuan").text(data['list_edit']['tujuan']);    
                    $("#materi").text(data['list_edit']['materi']);    
                    $("#alat").text(data['list_edit']['alat']); 
                    $("#pembuka").text(data['list_edit']['pembuka']); 

                    $("#inti").text(data['list_edit']['inti']); 
                    $("#penutup").text(data['list_edit']['penutup']); 

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

        $('.rpp').click(function () {
            var id = $(this).data('id') ;
            window.location = url + '/pelaksanaanrpp/' + id ;
        });

    </script>
</html>