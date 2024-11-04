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
                            <li><a href="#">Register</a></li>
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
                                                    <th>Foto Akta Lahir</th>
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
                                                        <td><?= ucwords($row->upload_akta) ?></td>
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
                                    <h5 class="card-title" id="nama_anak"></h5>                                
                                    <fieldset>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label> Upload Foto Pengasuh</label>
                                                    <input class="form-control" type="file" name="upload_foto_anak">
                                                    <span> <a href="#" id="upload_foto_anak"></a></span>
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-12">
                                                 <div class="form-group">
                                                    <label> Upload Surat Pernyataan 
                                                        <a href="<?= base_url().'uploads/template/surat_pernyataan.pdf' ?>">(Download)</a>
                                                        <a href="<?php echo base_url().'uploads/template/surat_pernyataan.pdf' ?>">Surat Pernyataan</a>
                                                    </label>
                                                    <input class="form-control" type="file" name="upload_surat_pernyataan">
                                                    <span> <a href="#" id="upload_surat_pernyataan"></a></span>
                                                </div>
                                            </div>-->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label> Upload KTP Pengasuh</label>
                                                    <input class="form-control" type="file" name="upload_akta">
                                                    <span> <a href="#" id="upload_akta"></a></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                 <div class="form-group">
                                                    <label> Upload KK</label>
                                                    <input class="form-control" type="file" name="upload_kk">
                                                    <span> <a href="#" id="upload_kk"></a></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label> Upload BPJS/NPWP</label>
                                                    <input class="form-control" type="file" name="upload_ktp_ayah">
                                                    <span> <a href="#" id="upload_ktp_ayah"></a></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                 <div class="form-group">
                                                    <label> Upload CV</label>
                                                    <input class="form-control" type="file" name="upload_ktp_ibu">
                                                    <span> <a href="#" id="upload_ktp_ibu"></a></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label> Upload Lampiran</label>
                                                    <input class="form-control" type="file" name="upload_kartu_sehat">
                                                    <span> <a href="#" id="upload_kartu_sehat"></a></span>
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
        var base = "<?= base_url() ?>";

        $('.edit').click(function(){
            $.ajax({
                url: url + '/edit/' + $(this).data('id'),
                type:'GET',
                dataType: 'json',
                success: function(data){
                    $("#nama_anak").text('Pengasuh '+data['list_anak']['nama'].toUpperCase()+' - '+data['list_anak']['nick'].toUpperCase());
                    
                    $("#id_anak").val(data['list_anak']['id']);  

                    if (data['list_edit'] != null) {
                        var details = data['list_edit'];

                        $("#id").val(details['id']);
                        
                        const exclude_col = ['date_created','date_updated','created_by','is_active','is_done'];
                        $.map( Object.keys(details), function( val, i ) {                          
                            if(!exclude_col.includes(val)) {
                                $("#"+val).text(details[val]);
                                $("#"+val).attr("href", base+'uploads/'+details[val]);
                            }
                        }); 
                    }

                    $("#updating-modal").modal('show');
                }                
            }); 
        })

        $('.delete').click(function () {
            var id = $(this).data('id') ;
            swal({
                title: 'Apakah yakin data ini ingin dihapus? ',
                showCancelButton: true,
                confirmButtonColor: '#4caf50',
                cancelButtonColor: '#f44336',
                confirmButtonText: 'Ya, Lanjutkan Hapus!',
                cancelButtonText: 'Batal',
            }).then(function () {
                window.location = url + '/delete/' + id ;
            })
        });
    </script>
</html>