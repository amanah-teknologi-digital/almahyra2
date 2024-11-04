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
                                    <button class="btn btn-info m-1 mb-4 add-button" type="button" data-toggle="modal" data-target="#adding-modal">Tambah</button>

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
                                                    <th>Tanggal</th>
                                                    <th>Peminjaman</th>
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
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Tanggal Mulai</label>
                                                    <input class="form-control date_start" type="date" name="tanggal_peminjaman_mulai" required>
                                                    <label class="checkbox checkbox-outline-success mt-4">
                                                        <input type="checkbox" name="is_temporary" class="is_temporary" value="0">
                                                        <span>Peminjaman Sementara ?</span><span class="checkmark"></span>
                                                    </label>
                                                </div>
                                                <div class="col-md-6 end-date">
                                                    <label>Tanggal Selesai</label>
                                                    <input class="form-control end-date-input" type="date" name="tanggal_peminjaman_selesai">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Keperluan</label>
                                            <textarea class="form-control" type="text" name="keperluan" required> </textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Dokumen Pendukung</label>
                                            <input class="form-control nota" type="file" name="nota" accept=".pdf,.jpeg,.jpg,.png"> 
                                            <p class="text-small text-info m-0">.pdf .jpeg .jpg .png Max 10MB</p>
                                        </div>  
                                        <div class="form-group">
                                            <label>Catatan</label>
                                            <input class="form-control catatan" type="text" name="catatan">
                                            <p class="text-small text-info m-0">Mohon isi apabila tidak ada nota dinas</p>
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
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Tanggal Mulai</label>
                                                    <input class="form-control date_start_update" type="text" required id="tanggal_peminjaman_mulai" disabled>
                                                    <label class="checkbox checkbox-outline-success mt-4">
                                                        <input type="checkbox" id="is_temporary" disabled="true">
                                                        <span class="text-primary">Peminjaman Sementara ?</span><span class="checkmark"></span>
                                                    </label>
                                                </div>
                                                <div class="col-md-6 end-date-edit">
                                                    <label>Tanggal Selesai</label>
                                                    <input class="form-control" type="text" id="tanggal_peminjaman_selesai" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Keperluan</label>
                                            <textarea class="form-control" type="text" name="keperluan" required id="keperluan"> </textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>Dokumen Pendukung</label>
                                            <input class="form-control" type="file" name="nota" id="nota" accept=".pdf,.jpeg,.jpg,.png">
                                            <p class="text-small text-info m-0">.pdf .jpeg .jpg .png Max 10MB</p>
                                        </div>  

                                        <div class="form-group">
                                            <label>Catatan</label>
                                            <input class="form-control" type="text" name="catatan" id="catatan"> 
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
                                            <label>Keterangan Pending/Tolak</label>
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
                    if(status == 3 || status == 2) {
                        $('.keterangan').show();
                        $('#keterangan').attr('required',true);
                    } else {
                        $('.keterangan').hide();
                        $('#keterangan').attr('required',false);
                    }

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

        $('.detail').click(function(){
            const target = urldetail + 'detail/peminjaman-perangkat-it/' + $(this).data('id');
            window.location.replace(target);
        })

        $(".is_temporary").change(function() {
            if(this.checked) {
                $('.end-date').show();
                $('.end-date-input').attr('required',true);
                $('.is_temporary').val(1);
            } else {
                $('.end-date').hide();
                $('.end-date-input').attr('required',false);
                $('.end-date-input').val(0);
                $('.is_temporary').val(0);
            }
        });

        $("#is_temporary").change(function() {
            if(this.checked) {
                $('.end-date-edit').show();
                $('#tanggal_peminjaman_selesai').attr('required',true);
                $('#is_temporary').val(1);
            } else {
                $('.end-date-edit').hide();
                $('#tanggal_peminjaman_selesai').attr('required',false);
                $('#tanggal_peminjaman_selesai').val(null);
                $('#is_temporary').val(0);
            }
        });

        $(document).ready(function() {
            $( ".end-date").hide();
            $( ".end-date-edit").hide();

            // set min date insert
            $('.date_start').change(function() {
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

            // set min date update
            $('#tanggal_peminjaman_mulai').change(function() {
                var date = $(this).val();
                let [year, month, day] = date.split("-");
                
                const todate = new Date(`${year}-${month}-${day}`);
                todate.setDate(todate.getDate() + 1);

                $('#tanggal_peminjaman_selesai').prop('min', function(){
                    $('#tanggal_peminjaman_selesai').val(null);
                    const month = ("0" + (todate.getMonth() + 1)).slice(-2)
                    const day = ("0" + (todate.getDate())).slice(-2)
                    return `${todate.getFullYear()}-${month}-${day}`;
                });
            });

            // set catatan required
            $('.catatan').prop("required",true);
            $('.nota').change(function() {
                if($('.nota')) {
                    $('.catatan').prop("required",false);
                } else {
                    $('.catatan').prop("required",true);
                }
            });

            setmindate();
        });

        function setmindate() {
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1; //January is 0 so need to add 1 to make it 1!
            var yyyy = today.getFullYear();
            if( dd<10 ){ dd='0'+dd } 
            if(mm<10){ mm='0'+mm } 

            today = yyyy+'-'+mm+'-'+dd;
            
            $( ".date_start").prop('min',today);
            $( ".end-date-input").prop('min',today);
        }

        function setmindateupdate() {
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1; //January is 0 so need to add 1 to make it 1!
            var yyyy = today.getFullYear();
            if( dd<10 ){ dd='0'+dd } 
            if(mm<10){ mm='0'+mm } 

            today = yyyy+'-'+mm+'-'+dd;
            
            $( "#tanggal_peminjaman_mulai").prop('min',today);
            $( "#tanggal_peminjaman_selesai").prop('min',today);
        }
    </script>
</html>