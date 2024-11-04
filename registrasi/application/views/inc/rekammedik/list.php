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
                                                    <th>Informasi Penting</th>
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
                                                        <td><?= ucwords($row->informasi_penting) ?></td>
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
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nama Dokter</label>
                                                    <input class="form-control" type="text" required name="nama_dokter">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                 <div class="form-group">
                                                    <label>Alamat Dokter</label>
                                                    <input class="form-control" type="text" required name="alamat_dokter">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tinggi Lahir(cm)</label>
                                                    <input class="form-control" type="number" required name="tb_lahir">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Berat Lahir(kg)</label>
                                                    <input class="form-control" type="number" required name="bb_lahir">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Metode Melahirkan</label>
                                                    <select class="form-control" required name="metode_lahir">
                                                        <option>Pilih Metode</option>
                                                        <option value="Caesar">Caesar</option>    
                                                        <option value="Normal">Normal</option>    
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label>Golongan Darah</label>
                                                        <select class="form-control" required name="goldar">
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
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Imunisasi</label>
                                                    </div>
                                                </div>
                                            <?php foreach ($imunisasi as $key => $v): ?>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label class="checkbox checkbox-outline-success">
                                                                    <input type="checkbox" name=imunisasi[] 
                                                                    value="<?= $v->id ?>" id="<?= 'imunisasi_'.$v->id ?>">
                                                                    <span><?= $v->name ?></span><span class="checkmark"></span>
                                                                </label>
                                                            </div>
                                                            <!-- <div class="col-md-12">
                                                                jaga2 kalo pake tanggal, tinggal ubah md
                                                                <label class="checkbox checkbox-outline-success">
                                                                    <input class="form-control" type="date" name="tanggal_imunisasi[]" placeholder="Tanggal Imunisasi">
                                                                </label>
                                                            </div> -->
                                                        </div>                                                        
                                                    </div>
                                                </div>                                                
                                            <?php endforeach ?>
                                        </div>

                                        <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Penyakit</label>
                                                    </div>
                                                </div>
                                            <?php foreach ($penyakit as $key => $v): ?>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label class="checkbox checkbox-outline-info">
                                                                    <input type="checkbox" name=penyakit[] 
                                                                    value="<?= $v->id ?>"
                                                                    id="<?= 'penyakit_'.$v->id ?>">
                                                                    <span><?= $v->name ?></span><span class="checkmark"></span>
                                                                </label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input class="form-control" type="text" name="keterangan[<?= $v->id ?>]" placeholder="Keterangan Penyakit" id="<?= 'keterangan_'.$v->id ?>" >
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>                                                
                                            <?php endforeach ?>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Alergi Makanan</label>
                                                    <input class="form-control" type="text" required name="alergi_makanan" placeholder="pisahkan dengan ;">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Alergi Obat</label>
                                                    <input class="form-control" type="text" required name="alergi_obat" placeholder="pisahkan dengan ;">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Alergi Lainnya</label>
                                                    <input class="form-control" type="text" required name="alergi_lainnya" placeholder="pisahkan dengan ;">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Penyakit Khusus</label>
                                                    <input class="form-control" type="text" required name="penyakit_khusus" placeholder="pisahkan dengan ;">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Informasi Penting</label>
                                                    <input class="form-control" type="text" required name="informasi_penting">
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

        $('div.checkbox-group.required :checkbox:checked').length > 0
        
        $('.edit').click(function(){
            $.ajax({
                url: url + '/edit/' + $(this).data('id'),
                type:'GET',
                dataType: 'json',
                success: function(data){
                    $("#nama_anak").text('Anak '+data['list_anak']['nama'].toUpperCase()+' - '+data['list_anak']['nick'].toUpperCase());
                    $("#id_anak").val(data['list_anak']['id']);  

                    if (data['list_edit'] != null) {
                        var details = data['list_edit'];
                        
                        const exclude_col = ['date_created','date_updated','created_by','is_active','is_done'];
                        $.map( Object.keys(details), function( val, i ) {                          
                            if(!exclude_col.includes(val)) {
                                $("input[name='"+val+"']").val(details[val]);
                                $("select[name='"+val+"']").val(details[val]);
                            }
                        }); 
                    }

                    if (data['list_edit_imunisasi'] != null) {
                        var details = data['list_edit_imunisasi'];
                        
                        $.map( Object.keys(details), function( val, i ) {                          
                            $(`#imunisasi_${details[i].id_imunisasi}`).prop('checked', true);
                        }); 
                    }

                    if (data['list_edit_penyakit'] != null) {
                        var details = data['list_edit_penyakit'];
                        
                        $.map( Object.keys(details), function( val, i ) {                          
                            $(`#penyakit_${details[i].id_penyakit}`).prop('checked', true);
                            $(`#keterangan_${details[i].id_penyakit}`).val(details[i].keterangan);
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