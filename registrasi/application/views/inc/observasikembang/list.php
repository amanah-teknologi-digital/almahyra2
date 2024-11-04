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
                                                    <th>Gol.Darah</th>
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
                                                        <td><?= strtoupper($row->golongan_darah) ?></td>
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
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Usia</label>
                                                    <select class="form-control" name="usia">
                                                        <option>Pilih Usia</option>
                                                        <?php foreach ($usia as $key => $p): ?>
                                                        <option value="<?= $p->id ?>"><?= $p->name ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row q">
                                            <!-- <?php foreach ($pertanyaan as $key => $p): ?>
                                            <div class="col-md-12">
                                                <div class="form-group mb-2">
                                                    <label><?= ($key+1).'. '.$p->name ?></label>
                                                    <select class="form-control" name="answer[]" required>
                                                        <option value="<?= $p->id.'_1' ?>">Sudah</option>
                                                        <option value="<?= $p->id.'_2' ?>">Belum</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php endforeach ?> -->

                                            <div class="col-md-12">
                                                <table class="display table table-striped table-bordered" id="tblq" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Aspek</th>
                                                            <th>Pertanyaan</th>
                                                            <th>Jawaban</th>
                                                        </tr>
                                                    </thead>
                                                     <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </fieldset>  

                                    <hr>
                                    <div class="table-responsive">
                                        <table class="display table table-striped table-bordered" id="tbls" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Aspek</th>
                                                    <th>Pertanyaan</th>
                                                    <th>Jawaban</th>
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
            var id_anak = $(this).data('id') ;
            $("#tbl > tbody").empty();

            $.ajax({
                url: url + '/edit/' + $(this).data('id'),
                type:'GET',
                dataType: 'json',
                success: function(data){
                    
                    $("#id_anak").val(id_anak);  

                    if (data['list_kembang'].length > 0) {
                        var tgl = null ;
                        $.each(data['list_kembang'], function( index, row ) {
                                                        
                            if (row.tanggal == tgl) {
                                $("#tbls > tbody").append(
                                    "<tr>"+
                                        "<td width='20%'>"+row.aspek+"</td>"+
                                        "<td width='70%'>"+row.name+"</td>"+
                                        "<td>"+ (row.answer == 1 ? 'Sudah' : 'Belum')+"</td>"+
                                    "</tr>"
                                );
                            } else {
                                $("#tbls > tbody").append(
                                    "<tr>"+
                                        "<td colspan='3' align='center'><b>"+row.tanggal+"</b></td>"+
                                    "</tr>"+
                                    "<tr>"+
                                        "<td width='20%'>"+row.aspek+"</td>"+
                                        "<td width='70%'>"+row.name+"</td>"+
                                        "<td>"+ (row.answer == 1 ? 'Sudah' : 'Belum')+"</td>"+
                                    "</tr>"
                                ); 
                                tgl = row.tanggal;
                            }
                          
                        });
                        
                    } 

                    $("#updating-modal").modal('show');
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

        $( document ).ready(function() {
            $("#tblq > tbody").empty();
        });

        
        $("select[name='usia']").on('change', function() {
          var usia = this.value;

          if (this.value == 'Pilih Usia') {
            alert('Silahkan Memilih Kategori Usia');
            $("#tblq > tbody").empty();
          }

          $.ajax({
                url: url + '/pertanyaan/' + usia,
                type:'GET',
                dataType: 'json',
                success: function(data){
                    console.log()
                    if (data['pertanyaan'].length > 0) {
                        $.each(data['pertanyaan'], function( index, row ) {
                                                        
                            $("#tblq > tbody").append(
                                "<tr>"+
                                    "<td align='center'><b>"+row.aspek+"</b></td>"+
                                    "<td width=50%>"+row.name+"</td>"+
                                    "<td>"+ 
                                        '<select class="form-control" name="answer[]" required>'+
                                            "<option>-- Pilih --</option>"+
                                            "<option value="+row.id+'_1'+">Sudah</option>"+
                                            "<option value="+row.id+'_2'+">Belum</option>"+
                                        '</select>'+
                                    "</td>"+
                                "</tr>"
                            ); 
                          
                        });
                    } else {
                        $("#tblq > tbody").empty();
                        alert('Observasi pada kategori usia ini belum tersedia.')
                    }                    
                }                
            }); 

        });
    </script>
</html>


                                                                
                                                                    
                                                                
                                                            