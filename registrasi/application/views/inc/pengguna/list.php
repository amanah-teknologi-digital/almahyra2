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
                                                    <th width="15%">Nama</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Role</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                             <tbody>
                                                <?php 
                                                $i = 1 ;
                                                foreach ($list as $key =>$row) { ?>
                                                    <tr>
                                                        <!-- <td><?= $i++ ?></td> -->
                                                        <td><?= ucwords($row->name) ?></td>
                                                        <td align="center"><?= $row->email ?></td>
                                                        <td align="center"><?= $row->phone ?></td>
                                                        <td align="center"><?= $row->role ?></td>
                                                        <td align="center">
                                                            <?php
                                                                if ($row->status == 0) {
                                                                    echo 'Pending';
                                                                } elseif ($row->status == 1) {
                                                                    echo 'Approved';
                                                                } else {
                                                                    echo 'Rejected';
                                                                }
                                                            ?>    
                                                        </td>
                                                        <td align="center">
                                                            <button class="btn btn-sm btn-outline-warning btn-icon edit" type="button" data-id="<?= $row->id; ?>">
                                                                <span class="ul-btn__icon">
                                                                    <i class="i-Pen-3"></i>
                                                                </span>
                                                            </button>   
                                                            <button class="btn btn-sm btn-outline-danger btn-icon delete" type="button" data-id="<?= $row->id; ?>">
                                                                <span class="ul-btn__icon">
                                                                    <i class="i-Close-Window"></i>
                                                                </span>
                                                            </button>   
                                                            <button class="btn btn-sm btn-outline-info btn-icon details" type="button" data-id="<?= $row->id; ?>">
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
                                                    <th width="15%">Nama</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Role</th>
                                                    <th>Status</th>
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

                    <div class="row" style="display:none!important;">
                        <div class="col-md-12">
                            <!--  SmartWizard html -->
                            <div id="smartwizard">
                                <ul>
                                    <li><a href="#step-1">Step 1<br /><small>This is step description</small></a></li>
                                    <li><a href="#step-2">Step 2<br /><small>This is step description</small></a></li>
                                    <li><a href="#step-3">Step 3<br /><small>This is step description</small></a></li>
                                    <li><a href="#step-4">Step 4<br /><small>This is step description</small></a></li>
                                </ul>
                                <div>
                                    <div id="step-1">
                                        <h3 class="border-bottom border-gray pb-2">Step 1 Content</h3>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                                    </div>
                                    <div id="step-2">
                                        <h3 class="border-bottom border-gray pb-2">Step 2 Content</h3>
                                        <div>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</div>
                                    </div>
                                    <div id="step-3">
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.

                                    </div>
                                    <div id="step-4">
                                        <h3 class="border-bottom border-gray pb-2">Step 4 Content</h3>
                                        <div class="card o-hidden">
                                            <div class="card-header">My Details</div>
                                            <div class="card-block p-0">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <th>Name:</th>
                                                            <td>Tim Smith</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Email:</th>
                                                            <td>example@example.com</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                            <label>Nama</label>
                                            <input class="form-control" type="text" required name="name">
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input class="form-control" type="text" required name="email">
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input class="form-control" type="password" required name="password">
                                        </div>
                                        <div class="form-group">
                                            <label>Role</label>
                                            <select class="form-control" required name="id_role">
                                                <option>Pilih Role</option>
                                                <?php foreach ($role as $key => $d): ?>
                                                    <option value="<?= $d->id ?>" > <?= $d->name ?> </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>No. Whatsapp</label>
                                            <input class="form-control" type="text" required name="phone">
                                        </div>
                                        <div class="form-group">
                                            <label>Tujuan Mendaftar</label>
                                            <textarea class="form-control" type="text" required name="purpose"></textarea>
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
                                            <label>Nama</label>
                                            <input class="form-control" type="text" required name="name" id="name">
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input class="form-control" type="text" required name="email" id="email">
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input class="form-control" type="password" name="password" id="email">
                                        </div>
                                        <div class="form-group">
                                            <label>Role</label>
                                            <select class="form-control" required name="id_role" id="id_role">
                                                <option>Pilih Role</option>
                                                <?php foreach ($role as $key => $d): ?>
                                                    <option value="<?= $d->id ?>" > <?= $d->name ?> </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>No. Whatsapp</label>
                                            <input class="form-control" type="text" required name="phone" id="phone">
                                        </div>
                                        <div class="form-group">
                                            <label>Tujuan Mendaftar</label>
                                            <textarea class="form-control" type="text" required name="purpose" id="purpose"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" required name="status" id="status">
                                                <option value="0">Pending</option>
                                                <option value="1">Approved</option>
                                                <option value="2">Rejected</option>
                                            </select>
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

                <div class="modal fade" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="details" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Data</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <fieldset>
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input class="form-control" type="text" required id="dname" disabled="true">
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input class="form-control" type="text" required id="demail" disabled="true">
                                    </div>
                                    <div class="form-group">
                                        <label>Role</label>
                                        <select class="form-control" required id="did_role" disabled="true">
                                            <option>Pilih Role</option>
                                            <?php foreach ($role as $key => $d): ?>
                                                <option value="<?= $d->id ?>" > <?= $d->name ?> </option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>No. Whatsapp</label>
                                        <input class="form-control" type="text" required id="dphone" disabled="true">
                                    </div>
                                    <div class="form-group">
                                        <label>Purpose</label>
                                        <input class="form-control" type="text" required id="dpurpose" disabled="true">
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" required id="dstatus" disabled="true">
                                            <option value="0">Pending</option>
                                            <option value="1">Approved</option>
                                            <option value="2">Rejected</option>
                                        </select>
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
                    $("#id_role").val(data['list_edit']['id_role']);
                    $("#name").val(data['list_edit']['name']);  
                    $("#email").val(data['list_edit']['email']);
                    // $("#password").val(data['list_edit']['password']);                                    
                    $("#purpose").text(data['list_edit']['purpose']);  
                    $("#phone").val(data['list_edit']['phone']);
                    $("#status").val(data['list_edit']['status']);  
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

        $('.details').click(function(){
            $.ajax({
                url: url + '/edit/' + $(this).data('id'),
                type:'GET',
                dataType: 'json',
                success: function(data){
                    $("#did_role").val(data['list_edit']['id_role']);                                    
                    $("#dname").val(data['list_edit']['name']);  
                    $("#demail").val(data['list_edit']['email']);  
                    $("#dpurpose").val(data['list_edit']['purpose']);
                    $("#dphone").val(data['list_edit']['phone']);  
                    $("#dstatus").val(data['list_edit']['status']);  
                    $("#details-modal").modal('show');
                }                
            }); 
        })

        $('.resets').click(function () {
            var id = $(this).data('id') ;
            swal({
                title: 'Apakah yakin melakukan approve data ini ?',
                icon: 'swal2-icon-warning',
                confirmButtonColor: '#4caf50',
                cancelButtonColor: '#f44336',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: 'Ya, Lanjutkan approve!',
                cancelButtonText: 'Batal',
                html:
                'Approve akan mengubah privillage pengguna menjadi bentuk approved akun',
            }).then(function (e) {
                console.log(e);
                if(e) {
                    $.ajax({
                        url: url + '/resets/',
                        type:'POST',
                        dataType: 'json',
                        data: {"id" : id}, 
                        success: function(data){
                            swal({
                                title: 'Berhasil',
                                text : 'Berhasil Mereset Password',
                                type : 'success',
                                confirmButtonColor: '#4fa7f3'
                            });
                        }                
                    }); 
                }
            });
        });
    </script>
</html>