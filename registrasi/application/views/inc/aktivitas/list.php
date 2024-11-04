<!DOCTYPE html>
<html lang="en" dir="/">

    <?php $this->load->view('layout/head') ?>

    <style type="text/css">
        .map {
          height: 200px;
          /* The height is 400 pixels */
          width: 100%;
          /* The width is the width of the web page */
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
                                                    <th>TTL</th>
                                                    <th>JK</th>
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
                                                        <td align="center">
                                                            <button class="btn btn-outline-warning btn-icon edit" type="button" data-id="<?= $row->id; ?>">
                                                                <span class="ul-btn__icon">
                                                                    <i class="i-Pen-3"></i>
                                                                </span>
                                                            </button>                                   
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <!-- <th>#</th> -->
                                                    <th>Nama</th>
                                                    <th>Panggilan</th>
                                                    <th>TTL</th>
                                                    <th>JK</th>
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
                <div class="modal fade" id="updating-modal" tabindex="-1" role="dialog" aria-labelledby="updating" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <!-- <?php echo form_open_multipart($controller.'/insert'); ?> -->
                        <form id="kegiatan" enctype="multipart/form-data">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Penambahan Data</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">
                                    <fieldset>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Tanggal</label>
                                                    <input class="form-control" type="date" name="tanggal" value="<?= date('Y-m-d') ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Waktu Mulai</label>
                                                    <input class="form-control" type="time" name="waktu_awal">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Waktu Selesai</label>
                                                    <input class="form-control" type="time" name="waktu_akhir">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Kegiatan</label>
                                                    <textarea class="form-control" type="text" name="kegiatan"> </textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Pelaksanaan</label>
                                                    <textarea class="form-control" type="text" name="pelaksanaan"> </textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Foto Kegiatan</label>
                                                    <input class="form-control" type="file" name="foto" id="file"> 
                                                </div>
                                            </div>
                                        </div>

                                    </fieldset>  

                                    <div class="modal-footer">
                                        <input type="hidden" name="id_anak" id="id_anak">                                 
                                        <p class="btn btn-primary ml-2" id="submit">Simpan</p>
                                    </div>

                                    <hr>
                                    <div class="table-responsive">
                                        <h5 id="tanggal_absen"></h5>
                                        <table class="display table table-striped table-bordered" id="tblx" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <!-- <th>#</th> -->
                                                    <th>Tanggal</th>
                                                    <th>Waktu Mulai</th>
                                                    <th>Waktu Selesai</th>
                                                    <th>Kegiatan</th>
                                                    <th>Pelaksanaan</th>
                                                    <th>Foto</th>
                                                    <th>#</th>
                                                </tr>
                                            </thead>
                                             <tbody>
                                            </tbody>
                                        </table>
                                    </div>                                  
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

        var id_anak = null ;

        var filename = null ;

        $('#tblx').dataTable({
            "ordering": false,
            "searching": false,
            "lengthChange": false,
            "paging":false,
            "bInfo" : false
        });

        $('.edit').click(function(){
            id_anak = $(this).data('id') ;

            console.log(id_anak)
            
            initlist(id_anak)

            $("#updating-modal").modal('show');
        })

         function doUpload() {

            var fd = new FormData();
         
            var files = $('#file')[0].files[0];
                     
            fd.append('file', files);
   
            $.ajax({
                url: url + '/do_upload/',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                async: false,
                success: function(response){
                    
                    filename = response;    
                },
                done: function(msg){ 
                    filename = response;    
                }
            });

        }

        $('#submit').on('click',function(){
            

            var data = $("#kegiatan").serialize();

            

            if( $('#file').val().length === 0 ) {
                swal({
                    title: 'Info',
                    text : 'Tidak ada foto',
                    type : 'warning',
                    confirmButtonColor: '#4fa7f3'
                });

                return false ;
            }

            doUpload();

            data = data+'&foto='+filename

            filename = null;
            
            $.ajax({
                type : "POST",
                url: url + '/insert/',
                dataType : "JSON",
                data : data,
                success: function(res){
                    console.log(data,'xxxx')
                    swal({
                        title: 'Berhasil',
                        text : 'Berhasil Menambah Aktivitas',
                        type : 'success',
                        confirmButtonColor: '#4fa7f3'
                    });
                    // $('#ModalaAdd').modal('hide');
                    initlist(id_anak);
                },
                error: function (request, status, error) {
                    console.log(request.responseText);
                    swal({
                        title: 'Gagal',
                        text : 'Gagal Menambah Aktifitas',
                        type : 'error',
                        confirmButtonColor: '#d57171'
                    });
                }
            });
            // return false;
        });

       

        $("#tblx > tbody").on('click', '#deleteact', function () {
            
            var id = $(this).data('req') ;
            // console.log(id, id_anak)
            $.ajax({
                type : "delete",
                url: url + '/delete/' + id,
                dataType : "JSON",
                success: function(res){
                    swal({
                        title: 'Berhasil',
                        text : 'Berhasil Hapus Aktivitas',
                        type : 'success',
                        confirmButtonColor: '#4fa7f3'
                    });
                    // $('#ModalaAdd').modal('hide');
                    initlist(id_anak);
                },
                error: function (request, status, error) {
                    console.log(request.responseText);
                    swal({
                        title: 'Gagal',
                        text : 'Gagal Hapus Aktifitas',
                        type : 'error',
                        confirmButtonColor: '#d57171'
                    });
                }
            });
            // return false;
        });

        function initlist(id_anak){
            $.ajax({
                type  : 'GET',
                url: url + '/edit/' + id_anak,
                async : true,
                dataType : 'json',
                success : function(data){
                    
                    $("#id_anak").val(id_anak);  
                    
                    $("#tblx > tbody").empty();

                    if (data['list_hasil'].length > 0) {
                        $("#id").val(data['list_edit']['id']);
                        
                        $.each(data['list_hasil'], function( index, row ) {
                            console.log(row);
                            
                            $("#tblx > tbody").append(
                                "<tr>"+
                                    "<td align='center'>"+row.tanggal+"</td>"+
                                    "<td align='center'>"+row.waktu_awal+"</td>"+
                                    "<td align='center'>"+row.waktu_akhir+"</td>"+
                                    "<td align='center'>"+row.kegiatan+"</td>"+
                                    "<td align='center'>"+row.pelaksanaan +"</td>"+
                                    "<td align='center' onclick=toAsset('"+row.foto+"')>"+ (row.foto !== null ? row.foto : "Tidak ada foto") +"</td>"+
                                    "<td align='center'>"+
                                      '<button class="btn btn-outline-danger btn-icon" id="deleteact" type="button" data-req="'+ row.id +'">'+
                                            '<span class="ul-btn__icon">'+
                                                '<i class="i-Close-Window"></i>'+
                                            '</span>'+
                                        '</button>'+
                                    "</td>"+
                                "</tr>"
                            );
                        });
                        
                    } 
                }
 
            });
        }

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

        function toAsset(file) {
            var url = "<?= base_url().'uploads/aktivitas/' ?>"+ file;
            console.log(file)
            if(file !== 'null') {
                window.location = url;    
            } else {
                 swal({
                    title: 'Info',
                    text : 'Tidak ada foto',
                    type : 'warning',
                    confirmButtonColor: '#4fa7f3'
                });

            }
        }
         
    </script>
        
</html>


                                                                
                                                                    
                                                                
                                                            