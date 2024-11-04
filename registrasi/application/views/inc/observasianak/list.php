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
                                                    <th>Anak Ke-</th>
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
                                                        <td><?= strtoupper($row->anak_ke) ?></td>
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
                        <?php echo form_open_multipart($controller.'/update'); ?>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Update Data</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">
                                    <fieldset>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nama</label>
                                                    <input class="form-control" type="text" required id="nama" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                 <div class="form-group">
                                                    <label>Panggilan</label>
                                                    <input class="form-control" type="text" required id="nick" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tempat Lahir</label>
                                                    <input class="form-control" type="text" required id="tempat_lahir" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tanggal Lahir</label>
                                                    <input class="form-control" type="date" required id="tanggal_lahir" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Jenis Kelamin</label>
                                                    <select class="form-control" required id="jenis_kelamin" disabled>
                                                        <option>Pilih Jenis kelamin</option>
                                                        <option value="L">Laki-Laki</option>    
                                                        <option value="P">Perempuan</option>    
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label>Golongan Darah</label>
                                                        <select class="form-control" required id="golongan_darah" disabled>
                                                            <option>Pilih Golongan Darah</option>
                                                            <option value="A">A</option>    
                                                            <option value="B">B</option>    
                                                            <option value="AB">AB</option>    
                                                            <option value="O">O</option>    
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Anak Ke-</label>
                                                    <input class="form-control" type="number" required id="anak_ke" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Jumlah Saudara</label>
                                                    <input class="form-control" type="number" required id="jumlah_saudara" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Jenis Susu</label>
                                                    <select class="form-control" required name="jenis_susu" id="jenis_susu">
                                                        
                                                        <option value="A">ASI</option>    
                                                        <option value="S">Susu Formula</option>    
                                                        <option value="T">Tidak Minum SUSU</option>    
                                                        <option value="K">Kombinasi</option>    
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Kebiasaan Anak</label>
                                                    <textarea class="form-control" required name="kebiasaan" id="kebiasaan"></textarea> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Kesukaan Anak</label>
                                                    <textarea class="form-control" required name="kesukaan" id="kesukaan"></textarea> 
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Ketidaksukaan Anak</label>
                                                    <textarea class="form-control" required name="ketidaksukaan" id="ketidaksukaan"></textarea> 
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>                                    
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="id_anak" id="id_anak">
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
            var id_anak = $(this).data('id') ;
            $.ajax({
                url: url + '/edit/' + $(this).data('id'),
                type:'GET',
                dataType: 'json',
                success: function(data){
                    
                    $("#id_anak").val(id_anak);  
                    $("#nama").val(data['list_anak']['nama']);
                    $("#nick").val(data['list_anak']['nick']);
                    $("#tempat_lahir").val(data['list_anak']['tempat_lahir']);
                    $("#tanggal_lahir").val(data['list_anak']['tanggal_lahir']);                                    
                    $("#jenis_kelamin").val(data['list_anak']['jenis_kelamin']);
                    $("#golongan_darah").val(data['list_anak']['golongan_darah']);
                    $("#anak_ke").val(data['list_anak']['anak_ke']);
                    $("#jumlah_saudara").val(data['list_anak']['jumlah_saudara']);

                    if (data['list_edit']) {
                        $("#id").val(data['list_edit']['id']);
                        $("#jenis_susu").val(data['list_edit']['jenis_susu']);
                        $("#kebiasaan").text(data['list_edit']['kebiasaan']);
                        $("#kesukaan").text(data['list_edit']['kesukaan']);
                        $("#ketidaksukaan").text(data['list_edit']['ketidaksukaan']);
                    } else {
                        $("#jenis_susu").val(null);
                        $("#kebiasaan").text(null);
                        $("#kesukaan").text(null);
                        $("#ketidaksukaan").text(null);   
                    }

                    $("#updating-modal").modal('show');
                }                
            }); 
        })
    </script>
</html>