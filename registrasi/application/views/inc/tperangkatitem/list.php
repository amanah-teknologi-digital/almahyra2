<!DOCTYPE html>
<html lang="en" dir="/">

    <?php $this->load->view('layout/head') ?>

    <body class="text-left">
        <div class="app-admin-wrap layout-sidebar-compact sidebar-dark-purple sidenav-open clearfix">
            <?php $this->load->view('layout/navigation') ?>

            <div class="main-content-wrap d-flex flex-column">
                <?php $this->load->view('layout/header') ?>
                <!-- ============ Body content start ============= -->
                <div class="main-content">
                    <div class="breadcrumb">
                        <ul>
                            <li><a href="#">Peminjaman</a></li>
                            <li><?= $title ?></li>
                        </ul>
                    </div>
                     <div class="row mb-4">
                        <div class="col-md-12 mb-4">
                            <div class="card text-left">
                                <div class="card-body">
                                    <h5> Detail Item Peminjaman</h5>
                                    <div class="table-responsive">
                                       <table class="table no-border">
                                            <tr>
                                               <th>Nama Peminjam</th>
                                               <td><?= $detail->peminjam ?></td>
                                               <th>Status Peminjaman</th>
                                               <td>
                                                   <?php
                                                        switch ($detail->status) {
                                                            case 1:
                                                                echo '<span class="badge badge-pill p-2 m-1 badge-primary">
                                                                    pengajuan
                                                                </span>';
                                                                break;
                                                            case 2:
                                                                echo '<span class="badge badge-pill p-2 m-1 badge-info">
                                                                    pending
                                                                </span>';
                                                            break;

                                                            case 3:
                                                                echo '<span class="badge badge-pill p-2 m-1 badge-danger">
                                                                    ditolak
                                                                </span>';
                                                            break;

                                                            case 4:
                                                                echo '<span class="badge badge-pill p-2 m-1 badge-success">
                                                                    disetujui
                                                                </span>';
                                                            break;
                                                            
                                                            default:
                                                                echo '<span class="badge badge-pill p-2 m-1 badge-dark  ">
                                                                    selesai
                                                                </span>';
                                                                break;
                                                        }
                                                    ?>
                                               </td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Peminjaman</th>
                                                <td><?= date("d M Y", strtotime($detail->tanggal_peminjaman_mulai)) ?></td>
                                                <th>Tanggal Peminjaman Selesai</th>

                                                <?php if ($detail->is_temporary == 1) { ?>
                                                
                                                <td><?= date("d M Y", strtotime($detail->tanggal_peminjaman_selesai)) ?></td>
                                                
                                                <?php } else { ?>
                                                
                                                <td> 
                                                    <span class="badge badge-pill badge-outline-primary p-2 m-1"> Jangka Panjang</span> 
                                                </td>
                                                
                                                <?php } ?>
                                            </tr>
                                            <tr>
                                               <th>Keperluan</th>
                                               <td><?= $detail->keperluan ?></td>
                                               <th>Nota Dinas</th>
                                               <td>
                                                    <a href="<?= base_url().'uploads/'.$detail->nota?>"> <?= $detail->nota ?></a>
                                               </td>
                                            </tr>
                                       
                                            <tr>
                                               <th>Catatan Peminjam</th>
                                               <td colspan="3"><?= $detail->catatan ?></td>      
                                            </tr>

                                            <tr>
                                               <th>Keterangan Petugas</th>
                                               <td colspan="3"><?= $detail->keterangan ? $detail->keterangan: '-' ?></td>
                                            </tr>
                                       </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end of col-->
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12 mb-4">
                            <div class="card text-left">
                                <div class="card-body">

                                    <?php if (($detail->status == 1 || $detail->status == 2) && $this->session->userdata('auth')->id_role != '2'): ?>
                                        <button class="btn btn-info m-1 mb-4 add-button" type="button" data-toggle="modal" data-target="#adding-modal">Tambah</button>    
                                    <?php endif ?>                                    

                                    <div class="table-responsive">
                                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <!-- <th>#</th> -->
                                                    <th>Jenis Perangkat</th>
                                                    <th>Merk</th>
                                                    <th>BMN</th>
                                                    <th>Jumlah</th>
                                                    <?php if (($detail->status == 1 || $detail->status == 2) && $this->session->userdata('auth')->id_role != '2'): ?>
                                                    <th>Action</th>
                                                    <?php endif ?>  
                                                </tr>
                                            </thead>
                                             <tbody>
                                                <?php 
                                                $i = 1 ;
                                                foreach ($list as $key =>$row) { ?>
                                                    <tr align="center">
                                                        <td align="left"><?= ucwords($row->perangkat) ?></td>
                                                        <td><?= $row->merk ?></td>
                                                        <td align="left">
                                                            <?php  
                                                                $arr_bmn = explode(";",$row->bmn);
                                                                foreach ($arr_bmn as $key => $v) {
                                                                    if(!empty($v)) {
                                                                        echo "#".$v."<br>";    
                                                                    }                                                                    
                                                                }
                                                            ?>
                                                        </td>
                                                        <td><?= $row->jumlah ?></td>                                                      
                                                        
                                                        <?php if (($detail->status == 1 || $detail->status == 2) && $this->session->userdata('auth')->id_role != '2'): ?>                                                            
                                                        <td align="center">
                                                            <button class="btn btn-warning btn-icon edit mb-1" type="button" data-id="<?= $row->id; ?>">
                                                                <span class="ul-btn__icon">
                                                                    <i class="i-Pen-3"></i>
                                                                </span>
                                                            </button>   
                                                            <button class="btn btn-danger btn-icon delete mb-1" type="button" data-id="<?= $row->id; ?>">
                                                                <span class="ul-btn__icon">
                                                                    <i class="i-Close-Window"></i>
                                                                </span>
                                                            </button>  
                                                        </td>
                                                        <?php endif ?>  
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Jenis Perangkat</th>
                                                    <th>Merk</th>
                                                    <th>BMN</th>
                                                    <th>Jumlah</th>
                                                     <?php if (($detail->status == 1 || $detail->status == 2) && $this->session->userdata('auth')->id_role != '2'): ?>
                                                    <th>Action</th>
                                                    <?php endif ?>  
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
                        <?php echo form_open_multipart($controller.'/insert/'.$detail->id); ?>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Penambahan Data</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">                                                                  
                                    <fieldset>
                                        <div class="form-group">
                                            <label>Jenis</label>
                                            <select class="form-control" required name="id_perangkat">
                                                <?php foreach ($perangkat as $key => $d): ?>
                                                    <option value="<?= $d->id ?>" > <?= ucwords($d->name) ?> </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Merk</label>
                                            <input class="form-control" type="text" name="merk" required>
                                        </div>
                                        <div class="form-group">
                                            <label>No BMN</label>
                                            <input class="form-control" type="text" name="bmn" required placeholder='item dengan bmn sama, pisahkan dengan tanda ";"'>
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
                        <?php echo form_open_multipart($controller.'/update/'.$detail->id); ?>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Perbaharuan Data</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">
                                    <fieldset>
                                        <div class="form-group">
                                            <label>Jenis</label>
                                            <select class="form-control" required name="id_perangkat" id="id_perangkat">
                                                <?php foreach ($perangkat as $key => $d): ?>
                                                    <option value="<?= $d->id ?>" > <?= ucwords($d->name) ?> </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Merk</label>
                                            <input class="form-control" type="text" name="merk" required id="merk">
                                        </div>
                                        <div class="form-group">
                                            <label>No BMN</label>
                                            <input class="form-control" type="text" name="bmn" required id="bmn" placeholder='item dengan bmn sama, pisahkan dengan tanda ";"'>
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
        const id_peminjaman = "<?= $detail->id ?>"

        $('.edit').click(function(){
            $.ajax({
                url: url + '/edit/' + $(this).data('id'),
                type:'GET',
                dataType: 'json',
                success: function(data){
                    
                    $("#id").val(data['list_edit']['id']);  
                    $("#id_perangkat").val(data['list_edit']['id_perangkat']);      
                    $("#bmn").val(data['list_edit']['bmn']);      
                    $("#merk").val(data['list_edit']['merk']);       
                    
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
                $.ajax({
                    url: url + '/delete/',
                    type:'POST',
                    dataType: 'json',
                    data: {"id" : id, "id_peminjaman": id_peminjaman }, 
                    success: function(data){
                        swal({
                            title: 'Berhasil',
                            text : 'Berhasil Menghapus Data',
                            type : 'success',
                            confirmButtonColor: '#4fa7f3'
                        });

                        setTimeout(function() { 
                            location.reload();
                        }, 1000);
                    }                
                }); 
            })
        });

    </script>
</html>