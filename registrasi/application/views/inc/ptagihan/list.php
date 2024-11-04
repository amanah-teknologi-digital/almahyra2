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
                            <li><a href="#">Pembayaran</a></li>
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
                                                    <th>Tempat Tanggal Lahir</th>
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
                                    <fieldset>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Tanggal Tagihan</label>
                                                    <input class="form-control" type="date" name="tanggal_tagihan" required value="<?= date('Y-m-d'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Jenis Tagihan</label>
                                                    </div>
                                                </div>
                                            <?php foreach ($tagihan as $key => $v): ?>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label class="checkbox checkbox-outline-success">
                                                                    <input type="checkbox" name=tagihan[] 
                                                                    value="<?= $v->id ?>" id="<?= 'tagihan'.$v->id ?>">
                                                                    <span><?= $v->name.' - Rp'.number_format($v->harga) ?></span><span class="checkmark"></span>
                                                                </label>
                                                            </div>
                                                            <div class="col-md-12">
                                                                jaga2 kalo pake tanggal, tinggal ubah md
                                                                <label class="checkbox checkbox-outline-success">
                                                                    <input class="form-control" type="date" name="tanggal_imunisasi[]" placeholder="Tanggal Imunisasi">
                                                                </label>
                                                            </div>
                                                        </div>                                                        
                                                    </div>
                                                </div>                                                
                                            <?php endforeach ?>
                                        </div> -->

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Jenis Tagihan</label>
                                                    <select class="form-control select-tagihan" required multiple="multiple" name=tagihan[]>
                                                        <?php foreach ($tagihan as $key => $v): ?>
                                                            <option value="<?= $v->id ?>" > <?= $v->name.' - Rp'.number_format($v->harga) ?> </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>  

                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                            <?php if ($this->session->userdata['auth']->id_role != 4): ?>
                                            <button class="btn btn-primary ml-2" type="submit">Simpan</button>    
                                            <?php endif ?>
                                        </div>
                                    </div>
                                    
                                    
                                    <hr>
                                    <div class="table-responsive">
                                        <table class="display table table-striped table-bordered" id="tbl" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <!-- <th>#</th> -->
                                                    <!-- <th>Kategori</th> -->
                                                    <th>Jenis Tagihan</th>
                                                    <th>Jumlah Tagihan</th>
                                                    <th>Tanggal Tagihan</th>                                                    
                                                    <th>Status</th>
                                                    <th width="20%">Action</th>
                                                </tr>
                                            </thead>
                                             <tbody>
                                            </tbody>
                                        </table>
                                    </div>                                  
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="id_anak" id="id_anak">                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="modal fade" id="payment-modal" tabindex="-1" role="dialog" aria-labelledby="payment" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <?php echo form_open_multipart($controller.'/bayar'); ?>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Pembayaran</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">
                                    <h5>Silahkan melakukan transfer ke no rekening <b>BCA 5123001221</b> (Zainul Arifin)</h5>
                                    <fieldset>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Upload Bukti</label>
                                                    <input class="form-control" type="file" name="bukti" required>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>  
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="id" id="id_bayar">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                    <button class="btn btn-primary ml-2" type="submit">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="modal fade" id="validasi-modal" tabindex="-1" role="dialog" aria-labelledby="validasi" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <?php echo form_open_multipart($controller.'/update'); ?>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Pembayaran</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">
                                    
                                    <fieldset>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label> Bukti Bayar</label>
                                                    <span><a href="#" id="bukti_bayar">(Download Bukti) </a></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" id="validasi">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Status Pembayaran</label>
                                                    <select class="form-control" name="status" required id="status">
                                                        <option value="1">Belum Bayar</option>
                                                        <option value="2">Lunas</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>  
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="id" id="id_validasi">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                    <button class="btn btn-primary ml-2 submit-validasi" type="submit">Simpan</button>
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
        var role = "<?= $this->session->userdata['auth']->id_role ?>";
        var base = "<?= base_url() ?>";

        $('.edit').click(function(){
            var id_anak = $(this).data('id') ;
            $("#tbl > tbody").empty();

            $.ajax({
                url: url + '/edit/' + $(this).data('id'),
                type:'GET',
                dataType: 'json',
                success: function(data){
                    
                    $("#id_anak").val(id_anak);  

                    if (data['list_tagihan'].length > 0) {
                        $("#id").val(data['list_edit']['id']);

                        $.each(data['list_tagihan'], function( index, row ) {
                            if (role == 4) {
                                if (row.status == 1) {
                                    $("#tbl > tbody").append(
                                        "<tr>"+
                                            // "<td>"+row.uraian+"</td>"+
                                            // "<td>"+row.name+"/"+row.satuan+"</td>"+
                                            "<td>"+row.name+"</td>"+
                                            "<td>"+numberWithCommas(row.harga)+"</td>"+
                                            "<td>"+row.tanggal_tagihan+"</td>"+
                                            "<td>"+ (row.status == 1 ? 'Belum Bayar' : 'Lunas')+"</td>"+
                                            "<td align='center'>"+ 
                                                '<button class="btn btn-outline-success btn-icon" type="button" onclick="bayar('+ row.id +')">' + 
                                                    '<span class="ul-btn__icon">' +
                                                        'Bayar' +
                                                    '</span>' +
                                                '</button>' +
                                            "</td>"+
                                        "</tr>"
                                    );
                                } else {
                                    $("#tbl > tbody").append(
                                        "<tr>"+
                                            // "<td>"+row.uraian+"</td>"+
                                            // "<td>"+row.name+"/"+row.satuan+"</td>"+
                                            "<td>"+row.name+"</td>"+
                                            "<td>"+numberWithCommas(row.harga)+"</td>"+
                                            "<td>"+row.tanggal_tagihan+"</td>"+
                                            "<td>"+ (row.status == 1 ? 'Belum Bayar' : 'Lunas')+"</td>"+
                                            "<td align='center'>"+ 
                                                '<button class="btn btn-outline-success btn-icon" type="button">' + 
                                                    '<span class="ul-btn__icon">' +
                                                        'Lunas' +
                                                    '</span>' +
                                                '</button>' +
                                            "</td>"+
                                        "</tr>"
                                    );
                                }
                                
                            } else {
                                if (row.bukti != null) {
                                    if (row.status == 1) {
                                        $("#tbl > tbody").append(
                                            "<tr>"+
                                                // "<td>"+row.uraian+"</td>"+
                                                // "<td>"+row.name+"/"+row.satuan+"</td>"+
                                                "<td>"+row.name+"</td>"+
                                                "<td>"+numberWithCommas(row.harga)+"</td>"+
                                                "<td>"+row.tanggal_tagihan+"</td>"+
                                                "<td>"+ (row.status == 1 ? 'Belum Bayar' : 'Lunas')+"</td>"+
                                                "<td align='center'>"+ 
                                                    '<button class="btn btn-outline-info btn-icon" type="button" onclick="validasi('+ row.id +')">' + 
                                                        '<span class="ul-btn__icon">' +
                                                            'Validasi' +
                                                        '</span>' +
                                                    '</button>' +
                                                "</td>"+
                                            "</tr>"
                                        );
                                    } else {
                                        $("#tbl > tbody").append(
                                            "<tr>"+
                                                // "<td>"+row.uraian+"</td>"+
                                                // "<td>"+row.name+"/"+row.satuan+"</td>"+
                                                "<td>"+row.name+"</td>"+
                                                "<td>"+numberWithCommas(row.harga)+"</td>"+
                                                "<td>"+row.tanggal_tagihan+"</td>"+
                                                "<td>"+ (row.status == 1 ? 'Belum Bayar' : 'Lunas')+"</td>"+
                                                "<td align='center'>"+ 
                                                    '<button class="btn btn-outline-success btn-icon" type="button"' + 
                                                        '<span class="ul-btn__icon">' +
                                                            'Lunas' +
                                                        '</span>' +
                                                    '</button>' +
                                                "</td>"+
                                            "</tr>"
                                        );
                                    }

                                } else {
                                    $("#tbl > tbody").append(

                                        "<tr>"+
                                            // "<td>"+row.uraian+"</td>"+
                                            // "<td>"+row.name+"/"+row.satuan+"</td>"+
                                            "<td>"+row.name+"</td>"+
                                            "<td>"+numberWithCommas(row.harga)+"</td>"+
                                            "<td>"+row.tanggal_tagihan+"</td>"+
                                            "<td>"+ (row.status == 1 ? 'Belum Bayar' : 'Lunas')+"</td>"+
                                            "<td align='center'>"+ 
                                                '<button class="btn btn-outline-danger btn-icon" type="button" onclick="deleteList('+ row.id +')">' + 
                                                    '<span class="ul-btn__icon">' +
                                                        'Hapus' +
                                                    '</span>' +
                                                '</button>' +
                                            "</td>"+
                                        "</tr>"
                                    );
                                }
                                
                            }
                            
                        });
                        
                    } 

                    $("#updating-modal").modal('show');
                }                
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

        function bayar(id) {
            $("#updating-modal").modal('hide');
            $("#id_bayar").val(id);
            $("#payment-modal").modal('show');
        }

        function validasi(id) {
            $("#updating-modal").modal('hide');

            $.ajax({
                url: url + '/validasi/' + id,
                type:'GET',
                dataType: 'json',
                success: function(data){
                    console.log(data,data['list_edit']['bukti']);
                    $("#id_validasi").val(id); 
                    
                    if (data['list_edit']['bukti'] != null) {
                        $("#bukti_bayar").attr("href", base+'uploads/'+data['list_edit']['bukti']);
                    } else {
                        $("#bukti_bayar").attr("href", '#');
                        $('a#bukti_bayar').text('Belum ada bukti');
                        $("#validasi").empty();
                        $(".submit-validasi").hide();
                         
                    }
                }                
            }); 

            $("#validasi-modal").modal('show');
        }

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        
        if ('.select-tagihan') {
            $('.select-tagihan').select2({
                multiple: true,
            });  
          }
    </script>
</html>


                                                                
                                                                    
                                                                
                                                            