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
                                    <h5 class="card-title" id="nama_anak"></h5>

                                    <fieldset>
                                        <div class="accordion" id="accordionRightIcon">
                                            <div class="card">
                                                <div class="card-header header-elements-inline">
                                                    <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                                        <a class="text-default collapsed" data-toggle="collapse" href="#accordion-item-icon-right-1" aria-expanded="false">Ayah</a>
                                                    </h6>
                                                </div>
                                                <div class="collapse" id="accordion-item-icon-right-1" data-parent="#accordionRightIcon">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Nama</label>
                                                                    <input class="form-control" type="text" name="nama[]" id="nama1">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                 <div class="form-group">
                                                                    <label>Pekerjaan</label>
                                                                    <input class="form-control" type="text" name="pekerjaan[]" id="pekerjaan1">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Hubungan Darah</label>
                                                                    <select class="form-control" name="status[]" id="hubungan1">
                                                                        <option>Pilih Hubungan</option>
                                                                        <option value="Kandung">Kandung</option>    
                                                                        <option value="Bukan Kandung">Bukan Kandung</option>    
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <div class="form-group">
                                                                        <label>Status</label>
                                                                        <select class="form-control" name="riwayat[]" id="status1">
                                                                            <option>Pilih Status</option>
                                                                            <option value="Hidup">Hidup</option>    
                                                                            <option value="Mati">Mati</option> 
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Nama Perusahaan</label>
                                                                    <input class="form-control" type="text" name="perusahaan[]" id="perusahaan1">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                 <div class="form-group">
                                                                    <label>Alamat Perusahaan</label>
                                                                    <input class="form-control" type="text" name="alamat_kantor[]" id="alamat_kantor1">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Jam Kerja</label>
                                                                    <input class="form-control" type="text" name="jam_kerja[]" id="jam_kerja1">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                 <div class="form-group">
                                                                    <label>Telp.Perusahaan</label>
                                                                    <input class="form-control" type="text" name="telp_kantor[]" id="telp_kantor1">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Pendidikan</label>
                                                                    <select class="form-control" name="pendidikan[]" id="pendidikan1">
                                                                        <option>Pilih Pendidikan</option>
                                                                        <option value="SD">SD</option> 
                                                                        <option value="SMP">SMP</option>    
                                                                        <option value="SMA">SMA</option>    
                                                                        <option value="D3">D3</option>    
                                                                        <option value="S1">S1</option>    
                                                                        <option value="S2">S2</option>    
                                                                        <option value="S3">S3</option>    
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <div class="form-group">
                                                                        <label>Pendapatan</label>
                                                                        <select class="form-control" name="pendapatan[]" id="pendapatan1">
                                                                            <option>Pilih Pendapatan</option>
                                                                            <option value="1">< Rp 5.000.000</option>    
                                                                            <option value="2">> Rp 5.000.000</option> 
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Alamat Rumah</label>
                                                                    <input class="form-control" type="text" name="alamat_rumah[]" id="alamat_rumah1">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Telp/No. HP</label>
                                                                    <input class="form-control" type="text" name="telp_rumah[]" id="telp_rumah1">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <input class="form-control" type="hidden" name="hubungan[]" value="A">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header header-elements-inline">
                                                    <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0"><a class="text-default collapsed" data-toggle="collapse" href="#accordion-item-icon-right-2">Ibu</a></h6>
                                                </div>
                                                <div class="collapse" id="accordion-item-icon-right-2" data-parent="#accordionRightIcon">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Nama</label>
                                                                    <input class="form-control" type="text" name="nama[]" id="nama2">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                 <div class="form-group">
                                                                    <label>Pekerjaan</label>
                                                                    <input class="form-control" type="text" name="pekerjaan[]" id="pekerjaan2">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Hubungan Darah</label>
                                                                    <select class="form-control" name="status[]" id="hubungan2">
                                                                        <option>Pilih Hubungan Darah</option>
                                                                        <option value="Kandung">Kandung</option>    
                                                                        <option value="Bukan Kandung">Bukan Kandung</option>    
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <div class="form-group">
                                                                        <label>Status</label>
                                                                        <select class="form-control" name="riwayat[]" id="status2">
                                                                            <option>Pilih Status</option>
                                                                            <option value="Hidup">Hidup</option>    
                                                                            <option value="Mati">Mati</option> 
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Nama Perusahaan</label>
                                                                    <input class="form-control" type="text" name="perusahaan[]" id="perusahaan2">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                 <div class="form-group">
                                                                    <label>Alamat Perusahaan</label>
                                                                    <input class="form-control" type="text" name="alamat_kantor[]" id="alamat_kantor2">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Jam Kerja</label>
                                                                    <input class="form-control" type="text" name="jam_kerja[]" id="jam_kerja2">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                 <div class="form-group">
                                                                    <label>Telp Perusahaan</label>
                                                                    <input class="form-control" type="text" name="telp_kantor[]" id="telp_kantor2">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Pendidikan</label>
                                                                    <select class="form-control" name="pendidikan[]" id="pendidikan2">
                                                                        <option>Pilih Pendidikan</option>
                                                                        <option value="SD">SD</option> 
                                                                        <option value="SMP">SMP</option>    
                                                                        <option value="SMA">SMA</option>    
                                                                        <option value="D3">D3</option>    
                                                                        <option value="S1">S1</option>    
                                                                        <option value="S2">S2</option>    
                                                                        <option value="S3">S3</option>    
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <div class="form-group">
                                                                        <label>Pendapatan</label>
                                                                        <select class="form-control" name="pendapatan[]" id="pendapatan2">
                                                                            <option>Pilih Pendapatan</option>
                                                                            <option value="1">< Rp 5.000.000</option>    
                                                                            <option value="2">> Rp 5.000.000</option> 
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Alamat Rumah</label>
                                                                    <input class="form-control" type="text" name="alamat_rumah[]" id="alamat_rumah2">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Telp/No.HP</label>
                                                                    <input class="form-control" type="text" name="telp_rumah[]" id="telp_rumah2">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <input class="form-control" type="hidden" name="hubungan[]" value="I">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header header-elements-inline">
                                                    <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0"><a class="text-default collapsed" data-toggle="collapse" href="#accordion-item-icon-right-3">Wali</a></h6>
                                                </div>
                                                <div class="collapse" id="accordion-item-icon-right-3" data-parent="#accordionRightIcon">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Nama</label>
                                                                    <input class="form-control" type="text"  name="nama[]" id="nama3">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                 <div class="form-group">
                                                                    <label>Pekerjaan</label>
                                                                    <input class="form-control" type="text"  name="pekerjaan[]" id="pekerjaan3">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Hubungan Darah</label>
                                                                    <select class="form-control"  name="status[]" id="hubungan3">
                                                                        <option value="Wali">Wali</option>       
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <div class="form-group">
                                                                        <label>Status</label>
                                                                        <select class="form-control"  name="riwayat[]" id="status3">
                                                                            <option>Pilih Status</option>
                                                                            <option value="Hidup">Hidup</option>    
                                                                            <option value="Mati">Mati</option> 
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Nama Perusahaan</label>
                                                                    <input class="form-control" type="text"  name="perusahaan[]" id="perusahaan3">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                 <div class="form-group">
                                                                    <label>Alamat Perusahaan</label>
                                                                    <input class="form-control" type="text"  name="alamat_kantor[]" id="alamat_kantor3">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Jam Kerja</label>
                                                                    <input class="form-control" type="text"  name="jam_kerja[]" id="jam_kerja3">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                 <div class="form-group">
                                                                    <label>Telp Perusahaan</label>
                                                                    <input class="form-control" type="text"  name="telp_kantor[]" id="telp_kantor3">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Pendidikan</label>
                                                                    <select class="form-control"  name="pendidikan[]" id="pendidikan3">
                                                                        <option>Pilih Pendidikan</option>
                                                                        <option value="SD">SD</option> 
                                                                        <option value="SMP">SMP</option>    
                                                                        <option value="SMA">SMA</option>    
                                                                        <option value="D3">D3</option>    
                                                                        <option value="S1">S1</option>    
                                                                        <option value="S2">S2</option>    
                                                                        <option value="S3">S3</option>    
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <div class="form-group">
                                                                        <label>Pendapatan</label>
                                                                        <select class="form-control"  name="pendapatan[]" id="pendapatan3">
                                                                            <option>Pilih Pendapatan</option>
                                                                            <option value="1">< Rp 5.000.000</option>    
                                                                            <option value="2">> Rp 5.000.000</option> 
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Alamat Rumah</label>
                                                                    <input class="form-control" type="text"  name="alamat_rumah[]" id="alamat_rumah3">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Telp/No.HP</label>
                                                                    <input class="form-control" type="text"  name="telp_rumah[]" id="telp_rumah3">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Hubungan dengan Orang Tua</label>
                                                                    <input class="form-control" type="text"  name="hubungan_orang_tua" id="hubungan_orang_tua">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <input class="form-control" type="hidden" name="hubungan[]" value="W">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        
                                    </fieldset>                                    
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
            $.ajax({
                url: url + '/edit/' + $(this).data('id'),
                type:'GET',
                dataType: 'json',
                success: function(data){
                    $("#nama_anak").text('Anak '+data['list_anak']['nama'].toUpperCase()+' - '+data['list_anak']['nick'].toUpperCase());

                    $("#id_anak").val(data['list_anak']['id']);  
                    if (data['list_edit'] != null) {
                        var details = data['list_edit']
                       
                        $.map( details, function( val, i ) {
                          $(`#nama${i+1}`).val(val.nama);
                          $(`#alamat_kantor${i+1}`).val(val.alamat_kantor);
                          $(`#alamat_rumah${i+1}`).val(val.alamat_rumah);
                          $(`#jam_kerja${i+1}`).val(val.jam_kerja);
                          $(`#pekerjaan${i+1}`).val(val.pekerjaan);
                          $(`#pendapatan${i+1}`).val(val.pendapatan);
                          $(`#pendidikan${i+1}`).val(val.pendidikan);
                          $(`#perusahaan${i+1}`).val(val.perusahaan);
                          $(`#status${i+1}`).val(val.riwayat);
                          $(`#hubungan${i+1}`).val(val.status);
                          $(`#telp_kantor${i+1}`).val(val.telp_kantor);
                          $(`#telp_rumah${i+1}`).val(val.telp_rumah);
                          $(`#nama${i+1}`).val(val.nama);
                          $(`#hubungan_orang_tua`).val(val.hubungan_orang_tua);
                        }); 
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
    </script>
</html>