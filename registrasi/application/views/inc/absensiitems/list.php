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
                                                    <th>TTL</th>
                                                    <th>JK</th>
                                                    <th>Golongan Darah</th>
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
                                            <tfoot>
                                                <tr>
                                                    <!-- <th>#</th> -->
                                                    <th>Nama</th>
                                                    <th>Panggilan</th>
                                                    <th>TTL</th>
                                                    <th>JK</th>
                                                    <th>Golongan Darah</th>
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
                        <?php echo form_open_multipart($controller.'/insert'); ?>
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
                                                    <label>Tanggal Input</label>
                                                    <input class="form-control" type="date" name="tanggal" required value="<?= date('Y-m-d'); ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Bawaan</label>
                                                    <select class="form-control select-item">
                                                        <option></option>
                                                        <?php foreach ($items as $key => $p): ?>
                                                        <option value="<?= $p->id ?>"><?= $p->name ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row q">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <table class="display table table-striped table-bordered" id="tbl-item" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Nama Barang</th>
                                                                <th>Jumlah</th>
                                                            </tr>
                                                        </thead>
                                                         <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>  
                                    <button class="btn btn-primary ml-2" type="submit">Simpan</button>
                                    <hr>
                                    <div class="table-responsive">
                                        <table class="display table table-striped table-bordered" id="tbls" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>Nama Barang</th>
                                                    <th>Jumlah (In)</th>
                                                    <th>Jumlah (Out)</th>
                                                    <th>Ket</th>
                                                    <th>Simpan</th>
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
        var items = [];

        $('.edit').click(function(){
            var id_anak = $(this).data('id') ;
            
            $("#tbl-item > tbody").empty();

            $.ajax({
                url: url + '/edit/' + $(this).data('id'),
                type:'GET',
                dataType: 'json',
                success: function(data){
                    
                    $("#id_anak").val(id_anak);  
                    
                    $("#tbls > tbody").empty();

                    if (data['list_items']) {
                        
                        $.each(data['list_items'], function( index, row ) {
                            $("#tbls > tbody").append(
                                "<tr>"+
                                    "<td>"+data['list_absensi'].tanggal+"</td>"+
                                    "<td>"+row.item+"</td>"+
                                    "<td>"+row.jumlah+"</td>"+
                                    "<td width='20%'>"+
                                        "<input class='form-control' type='number' required id='sisa_"+row.id+"' value='"+ (row.sisa ? row.sisa : 0) +"'>"+
                                    "</td>"+
                                    "<td width='40%'>"+
                                        "<input class='form-control' type='text' required id='keterangan_"+row.id+"' value='"+ (row.keterangan ? row.keterangan : '-') +"'>"+
                                    "</td>"+
                                    "<td>"+
                                        "<p class='btn btn-outline-info btn-icon' data-id='"+row.id+"' onclick='simpan("+ row.id +")'>"+
                                            "<span class='ul-btn__icon'>"+
                                                "Simpan"+
                                            "</span>"+
                                        "</p>"+                                     
                                    "</td>"+                                    
                                "</tr>"
                            ); 
                        });  
                    } 
                }                
            }).done(function(data){
                $("#updating-modal").modal('show');
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
            
            $('.select-item').on('select2:select', function (e) {
                var selected = e.params.data;
                
                if (items.some(item => item.id === selected.id)) {
                    console.log("exists")
                } else {
                    items.push({
                        'id':selected.id, 
                        'text':selected.text
                    });

                    var id = 'jumlah_'+selected.id;
                    $("#tbl-item > tbody").append(
                        "<tr>"+
                            "<td width='60%'>"+selected.text+"</td>"+
                            "<td width='20%'> <input class='form-control' type='number' name='"+id+"' min='0'>  </td>"+
                        "</tr>"
                    );
                }

            });
        });

        function simpan(id) {
            console.log(id);
            const sisa = $("#sisa_"+id).val();
            const keterangan = $("#keterangan_"+id).val();
            console.log(sisa, keterangan)

             $.ajax({
                url: url + '/update/' + id,
                type: "post",
                data: {sisa, keterangan , id} ,
                success: function (response) {
                    swal({
                        title: 'Berhasil Simpan',
                        text : 'Data Berhasil Disimpan',
                        type : 'success',
                        confirmButtonColor: '#d57171'
                    });
                   // You will get response from your PHP page (what you echo or print)
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    swal({
                        title: 'Gagal Simpan',
                        text : 'Data Gagal Disimpan',
                        type : 'error',
                        confirmButtonColor: '#d57171'
                    });
                   console.log(textStatus, errorThrown);
                }
            });
        }

    </script>
</html>


                                                                
                                                                    
                                                                
                                                        