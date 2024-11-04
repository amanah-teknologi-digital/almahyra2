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
                            <li><a href="#">Pengembalian</a></li>
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
                                                    <th>Peminjam</th>
                                                    <th>Tanggal</th>
                                                    <th>Peminjaman</th>
                                                    <th>Keperluan</th>
                                                    <th>Status</th>
                                                    <th>Nota</th>
                                                    <th>Formulir</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                             <tbody>
                                                <?php 
                                                $i = 1 ;
                                                foreach ($list as $key =>$row) { ?>

                                                    <tr>
                                                        <!-- <td><?= $i++ ?></td> -->
                                                        <td><?= ucwords($row->peminjam) ?></td>
                                                       
                                                        <?php if ($row->is_temporary == 0) { ?>
                                                            <td align="center">
                                                                <?= date("d M Y", strtotime($row->tanggal_peminjaman_mulai)) ?>
                                                            </td>
                                                        <?php } else { ?>
                                                            <td align="center">
                                                                <?= date("d", strtotime($row->tanggal_peminjaman_mulai)) ?> - 
                                                                <?= date("d M Y", strtotime($row->tanggal_peminjaman_selesai)) ?>
                                                            </td>
                                                        <?php } ?>

                                                        <td align="center"> <?= $row->is_temporary ? 'Sementara' : 'Berkelanjutan' ?></td>
                                                        <td><?= ucwords($row->keperluan) ?></td>
                                                        <td align="center"> 
                                                            <?php
                                                                switch ($row->status) {
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
                                                        <td align="center">
                                                            <?php if ($row->nota) { ?>
                                                                <a href="<?= base_url().'uploads/'.$row->nota?>" target="_blank">
                                                                    <span class="ul-btn__icon">
                                                                        <i class="i-Folder-Open"></i>
                                                                    </span>
                                                                </a>
                                                            <?php } else { ?>
                                                                -
                                                            <?php } ?>                                                            
                                                        </td>

                                                        <td align="center"> 
                                                            <?php if ($row->status == 4) { ?> 
                                                                
                                                                <?php if ($row->tanggal_peminjaman_selesai == '0000-00-00 00:00:00') { ?>
                                                                    <a href="<?= base_url().'uploads/bast/'.$row->id.'.pdf'?>" target="_blank">
                                                                        bast
                                                                    </a> <br>
                                                                <?php } else { ?>
                                                                    <a href="<?= base_url().'uploads/peminjaman/'.$row->id.'.pdf'?>" target="_blank">
                                                                        peminjaman
                                                                    </a>
                                                                <?php } ?>

                                                            <?php } else if($row->status == 5) { ?> 
                                                                <a href="<?= base_url().'uploads/pengembalian/'.$row->id.'.pdf'?>" target="_blank">
                                                                    pengembalian
                                                                </a>
                                                            <?php } else { ?> 
                                                                    echo '-';
                                                            <?php } ?> 
                                                        </td>
                                                        
                                                        <td align="center">
                                                            <?php if ($this->session->userdata('auth')->id_role !=2) { ?>
                                                                <?php if ($row->status == 4) { ?>
                                                                     <button class="btn btn-warning btn-icon edit mb-1" type="button" data-id="<?= $row->id; ?>">
                                                                        <span class="ul-btn__icon">
                                                                            <i class="i-Pen-3"></i>
                                                                        </span>
                                                                    </button>  
                                                                    <button class="btn btn-info btn-icon detail mb-1" type="button" data-id="<?= $row->id; ?>">
                                                                        <span class="ul-btn__icon">
                                                                            <i class="i-Inbox-Out"></i>
                                                                        </span>
                                                                    </button> 
                                                                <?php } else { ?>
                                                                    <button class="btn btn-info btn-icon detail mb-1" type="button" data-id="<?= $row->id; ?>">
                                                                        <span class="ul-btn__icon">
                                                                            <i class="i-Inbox-Out"></i>
                                                                        </span>
                                                                    </button> 
                                                                <?php } ?>
                                                            <?php } else { ?>
                                                               <button class="btn btn-info btn-icon detail mb-1" type="button" data-id="<?= $row->id; ?>">
                                                                        <span class="ul-btn__icon">
                                                                        <i class="i-Inbox-Out"></i>
                                                                    </span>
                                                                </button>  
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <!-- <th>#</th> -->
                                                    <th>Peminjam</th>
                                                    <th>Tanggal</th>
                                                    <th>Peminjaman</th>
                                                    <th>Keperluan</th>
                                                    <th>Status</th>
                                                    <th>Nota</th>
                                                    <th>Formulir</th>
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


                <div class="modal fade" id="updating-modal" tabindex="-1" role="dialog" aria-labelledby="updating" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <?php echo form_open_multipart($controller.'/update_pengembalian'); ?>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Perbaharuan Data</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">
                                    <fieldset>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Tanggal Mulai</label>
                                                    <input class="form-control date_start_update" type="date" id="tanggal_peminjaman_mulai" disabled="true">
                                                    <label class="checkbox checkbox-outline-success mt-4">
                                                        <input type="checkbox" id="is_temporary" disabled="true">
                                                        <span>Peminjaman Sementara ?</span><span class="checkmark"></span>
                                                    </label>
                                                </div>
                                                <div class="col-md-6 end-date-edit">
                                                    <label>Tanggal Selesai</label>
                                                    <input class="form-control" type="date" id="tanggal_peminjaman_selesai" disabled="true">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Keperluan</label>
                                            <textarea class="form-control" type="text" required id="keperluan" disabled="true"> </textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>Catatan Peminjaman</label>
                                            <input class="form-control" type="text" id="catatan" disabled="true"> 
                                        </div>

                                        <?php if ($this->session->userdata('auth')->id_role != 2) { ?>
                                        
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" required name="status" id="status">
                                                <option value="4"> Disetujui </option>
                                                <option value="5"> Selesai </option>
                                            </select>
                                        </div>

                                        <div class="form-group keterangan">
                                            <label>Keterangan Pengembalian</label>
                                            <textarea class="form-control" type="text" name="keterangan" id="keterangan"> </textarea>
                                        </div>

                                        <?php } ?>

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
        const urldetail = "<?= base_url() ?>";

        $('.edit').click(function(){
            $.ajax({
                url: url + '/edit/' + $(this).data('id'),
                type:'GET',
                dataType: 'json',
                success: function(data){
                    
                    $("#id").val(data['list_edit']['id']);  
                    $("#tanggal_peminjaman_mulai").val(data['list_edit']['tanggal_peminjaman_mulai']);      
                    $("#keperluan").val(data['list_edit']['keperluan']);    
                    $("#catatan").val(data['list_edit']['catatan']);    

                    const status = data['list_edit']['status'];
                    $("#status").val(data['list_edit']['status']); 
                    $("#keterangan").val(data['list_edit']['keterangan']);    
                    $('.keterangan').show();
                    $('#keterangan').attr('required',true);

                    const is_temporary = data['list_edit']['is_temporary'] > 0 ? true : false;
                    $('#is_temporary').prop('checked', is_temporary);
                    $('#is_temporary').val(data['list_edit']['is_temporary']);
                    
                    if(is_temporary) {
                        $('.end-date-edit').show();
                        $('#tanggal_peminjaman_selesai').attr('required',true);
                        $("#tanggal_peminjaman_selesai").val(data['list_edit']['tanggal_peminjaman_selesai']);       
                    } else {
                        $('.end-date-edit').hide();
                        $("#tanggal_peminjaman_selesai").val(null);  
                        $('#tanggal_peminjaman_selesai').attr('required',false);
                    }
                    

                    $("#updating-modal").modal('show');
                }                
            }); 
        })

      
        $('.detail').click(function(){
            const target = urldetail + 'detail/peminjaman-perangkat-it/' + $(this).data('id');
            window.location.replace(target);
        })
    </script>
</html>