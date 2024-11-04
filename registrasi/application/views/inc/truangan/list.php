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
                                    <button class="btn btn-info m-1 mb-4 add-button" type="button" data-toggle="modal" data-target="#adding-modal">Tambah</button>

                                    <div class="table-responsive">
                                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <!-- <th>#</th> -->
                                                    <th>Peminjam</th>
                                                    <th>Ruangan</th>
                                                    <th>Waktu</th>
                                                    <th>Tanggal</th>
                                                    <th>Keperluan</th>
                                                    <th>Status</th>
                                                    <th>Nota</th>
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
                                                        <td><?= ucwords($row->ruangan) ?></td>
                                                        <td>
                                                            <?= date("H:i", strtotime($row->waktu_peminjaman_mulai)) ?> - 
                                                            <?= date("H:i", strtotime($row->waktu_peminjaman_selesai)) ?>
                                                        </td>

                                                        <td>
                                                            <?= date("d", strtotime($row->tanggal_peminjaman_mulai)) ?> - 
                                                            <?= date("d M Y", strtotime($row->tanggal_peminjaman_selesai)) ?>
                                                        </td>
                                                        <td><?= $row->keperluan ?></td>

                                                        <td align="center"> 
                                                            <?php
                                                                switch ($row->status) {
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
                                                        <td align="center">
                                                            <?php if (!empty($row->nota)) { ?>
                                                                <a href="<?= base_url().'uploads/'.$row->nota?>" target="_blank">
                                                                    <span class="ul-btn__icon">
                                                                        <i class="i-Folder-Open"></i>
                                                                    </span>
                                                                </a>
                                                            <?php } else { 
                                                                    echo '-';
                                                            } ?>
                                                            
                                                        </td>

                                                        <td align="center">
                                                            <?php if ($this->session->userdata('auth')->id_role != 2) { ?>
                                                                <?php if ($row->status == 1 || $row->status == 2 || $row->status == 4) { ?>
                                                                     <button class="btn btn-info btn-icon detail mb-1" type="button" data-id="<?= $row->id; ?>">
                                                                        <span class="ul-btn__icon">
                                                                            <i class="i-Inbox-Out"></i>
                                                                        </span>
                                                                    </button>  
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
                                                                <?php } else { ?>
                                                                    <button class="btn btn-info btn-icon detail mb-1" type="button" data-id="<?= $row->id; ?>">
                                                                        <span class="ul-btn__icon">
                                                                            <i class="i-Inbox-Out"></i>
                                                                        </span>
                                                                    </button>  
                                                                <?php } ?>
                                                            <?php } else { ?>
                                                                <?php if ($row->status == 1) { ?>
                                                                    <button class="btn btn-info btn-icon detail mb-1" type="button" data-id="<?= $row->id; ?>">
                                                                        <span class="ul-btn__icon">
                                                                            <i class="i-Inbox-Out"></i>
                                                                        </span>
                                                                    </button>  
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
                                                                <?php } else { ?>
                                                                    <button class="btn btn-info btn-icon detail mb-1" type="button" data-id="<?= $row->id; ?>">
                                                                        <span class="ul-btn__icon">
                                                                            <i class="i-Inbox-Out"></i>
                                                                        </span>
                                                                    </button>  
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <!-- <th>#</th> -->
                                                    <th>Peminjam</th>
                                                    <th>Ruangan</th>
                                                    <th>Waktu</th>
                                                    <th>Tanggal</th>
                                                    <th>Keperluan</th>
                                                    <th>Status</th>
                                                    <th>Nota</th>
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
                                            <label>Ruangan</label>
                                            <select class="form-control" required name="id_ruangan">
                                                <?php foreach ($available as $key => $d): ?>
                                                    <option value="<?= $d->id ?>" > <?= ucwords($d->name) ?> </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Tanggal Mulai</label>
                                                    <input class="form-control date-start" type="date" name="tanggal_peminjaman_mulai" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Tanggal Selesai</label>
                                                    <input class="form-control end-date-input" type="date" name="tanggal_peminjaman_selesai" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Waktu Mulai</label>
                                                    <input class="form-control" type="time" name="waktu_peminjaman_mulai" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Waktu Selesai</label>
                                                    <input class="form-control" type="time" name="waktu_peminjaman_selesai" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Keperluan</label>
                                            <textarea class="form-control" type="text" name="keperluan" required> </textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Dokumen Pendukung</label>
                                            <input class="form-control" type="file" name="nota">
                                            <p class="text-small text-info m-0">Max 10MB</p>
                                        </div> 

                                        <div class="form-group">
                                            <label>Catatan</label>
                                            <textarea class="form-control" type="text" name="catatan"> </textarea>
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
                                            <label>Ruangan</label>
                                            <select class="form-control" required name="id_ruangan" id="id_ruangan">
                                                <?php foreach ($ruangan as $key => $d): ?>
                                                    <option value="<?= $d->id ?>" > <?= ucwords($d->name) ?> </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Tanggal Mulai</label>
                                                    <input class="form-control" type="text" required id="tanggal_peminjaman_mulai" disabled="true">
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Tanggal Selesai</label>
                                                    <input class="form-control" type="text" required id="tanggal_peminjaman_selesai" disabled="true">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Waktu Mulai</label>
                                                    <input class="form-control" type="time" name="waktu_peminjaman_mulai" required id="waktu_peminjaman_mulai">
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Waktu Selesai</label>
                                                    <input class="form-control" type="time" name="waktu_peminjaman_selesai" required id="waktu_peminjaman_selesai">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Keperluan</label>
                                            <textarea class="form-control" type="text" name="keperluan" required id="keperluan"> </textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Dokumen Pendukung</label>
                                            <input class="form-control" type="file" name="nota" id="nota">
                                            <p class="text-small text-info m-0">Max 10MB</p>
                                        </div>  

                                        <div class="form-group">
                                            <label>Catatan</label>
                                            <textarea class="form-control" type="text" name="catatan" id="nota"> </textarea>
                                        </div> 

                                        <?php if ($this->session->userdata('auth')->id_role != 2) { ?>
                                        
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" required name="status" id="status">
                                                <option value="2"> Pending </option>
                                                <option value="3"> Ditolak </option>
                                                <option value="4"> Disetujui </option>
                                            </select>
                                        </div>

                                        <div class="form-group keterangan">
                                            <label>Keterangan</label>
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

                <div class="modal fade" id="detail-modal" tabindex="-1" role="dialog" aria-labelledby="updating" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detail Peminjaman</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">
                                    <fieldset>
                                        <div class="form-group">
                                            <label>Ruangan</label>
                                            <p class="id_ruangan"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Peminjam</label>
                                            <p class="peminjam"></p>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Tanggal Mulai</label>
                                                    <p class="tanggal_peminjaman_mulai"></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Tanggal Selesai</label>
                                                    <p class="tanggal_peminjaman_selesai"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Waktu Mulai</label>
                                                    <p class="waktu_peminjaman_mulai"></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Waktu Selesai</label>
                                                    <p class="waktu_peminjaman_selesai"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Keperluan</label>
                                            <p class="keperluan">
                                        </div> 

                                        <div class="form-group">
                                            <label>Status</label>
                                            <p class="status">
                                        </div>

                                        <div class="form-group">
                                            <label>Keterangan</label>
                                            <p class="detail-keterangan">
                                        </div>

                                        <div class="form-group">
                                            <label>Catatan</label>
                                            <p class="detail-catatan">
                                        </div>

                                    </fieldset>                                     
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
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
                    $("#id_ruangan").val(data['list_edit']['id_ruangan']);      
                    $("#tanggal_peminjaman_mulai").val(data['list_edit']['tanggal_peminjaman_mulai']);      
                    $("#tanggal_peminjaman_selesai").val(data['list_edit']['tanggal_peminjaman_selesai']);      
                    $("#waktu_peminjaman_mulai").val(data['list_edit']['waktu_peminjaman_mulai']);      
                    $("#waktu_peminjaman_selesai").val(data['list_edit']['waktu_peminjaman_selesai']);      
                    $("#keperluan").val(data['list_edit']['keperluan']);    
                    $("#catatan").val(data['list_edit']['catatan']);    

                    const status = data['list_edit']['status'];
                    $("#status").val(data['list_edit']['status']); 
                    $("#keterangan").val(data['list_edit']['keterangan']);    
                    if(status == 3 || status == 2) {
                        $('.keterangan').show();
                        $('#keterangan').attr('required',true);
                    } else {
                        $('.keterangan').hide();
                        $('#keterangan').attr('required',false);
                    }

                    $("#updating-modal").modal('show');
                }                
            }); 
        })

        $('.detail').click(function(){
            $.ajax({
                url: url + '/edit/' + $(this).data('id'),
                type:'GET',
                dataType: 'json',
                success: function(data){
                    
                    $(".id_ruangan").text(data['list_edit']['ruangan']);
                    $(".peminjam").text(data['list_edit']['peminjam']);        
                    $(".tanggal_peminjaman_mulai").text(data['list_edit']['tanggal_peminjaman_mulai']);      
                    $(".tanggal_peminjaman_selesai").text(data['list_edit']['tanggal_peminjaman_selesai']);      
                    $(".waktu_peminjaman_mulai").text(data['list_edit']['waktu_peminjaman_mulai']);      
                    $(".waktu_peminjaman_selesai").text(data['list_edit']['waktu_peminjaman_selesai']);      
                    $(".keperluan").text(data['list_edit']['keperluan']);  
                    $(".detail-keterangan").text(data['list_edit']['keterangan'] ? data['list_edit']['keterangan'] : '-');   
                    $(".detail-catatan").text(data['list_edit']['catatan'] ? data['list_edit']['catatan'] : '-');   

                    var status = 'pengajuan'
                    
                    switch(data['list_edit']['status']) {
                      case "1":
                        status = 'pengajuan';
                        break;
                      case "2":
                        status = 'pending';
                        break;
                      case "3":
                        status = 'ditolak';
                        break;
                      case "4":
                        status = 'disetujui';
                        break;
                      default:
                        status = 'selesai';
                    }

                    $(".status").text(status);  

                    $("#detail-modal").modal('show');
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

        $('#status').on('change', function() {
            const status = this.value;
            if(status == 3 || status == 2) {
                $('.keterangan').show();
                $('#keterangan').attr('required',true);
            } else {
                $('.keterangan').hide();
                $('#keterangan').attr('required',false);
            }
        });
        function setmindate() {
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1; //January is 0 so need to add 1 to make it 1!
            var yyyy = today.getFullYear();
            if( dd<10 ){ dd='0'+dd } 
            if(mm<10){ mm='0'+mm } 

            today = yyyy+'-'+mm+'-'+dd;
            
            $( ".date-start").prop('min',today);
            $( ".end-date-input").prop('min',today);
        }

        $(document).ready(function() {
            setmindate();

            $('.date-start').change(function() {
                var date = $(this).val();
                let [year, month, day] = date.split("-");
               
                const todate = new Date(`${year}-${month}-${day}`);
                todate.setDate(todate.getDate() + 1);

                $('.end-date-input').prop('min', function(){
                    $('.end-date-input').val(null);
                    const month = ("0" + (todate.getMonth() + 1)).slice(-2)
                    const day = ("0" + (todate.getDate())).slice(-2)
                    return `${todate.getFullYear()}-${month}-${day}`;
                });
            });
        });
    </script>
</html>