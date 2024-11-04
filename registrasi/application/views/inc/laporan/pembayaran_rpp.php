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
                            <li><a href="#">Laporan</a></li>
                            <li><?= $title ?></li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card text-left">
                                <div class="card-body">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab0" role="tab">Data Anak</a></li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab1" role="tab">Rincian Pembayaran</a></li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab2" role="tab">Riwayat Pembayaran</a></li>
                                    </ul>

                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="tab0" role="tabpanel">
                                            <fieldset>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <h6>Nama</h6>
                                                            <input class="form-control" type="text" required disabled value="<?= $anak->nama ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                         <div class="form-group">
                                                            <h6>Panggilan</h6>
                                                            <input class="form-control" type="text" required disabled value="<?= $anak->nick ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                               <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <h6>Tempat Lahir</h6>
                                                            <input class="form-control" type="text" required disabled value="<?= $anak->tempat_lahir ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <h6>Tanggal Lahir</h6>
                                                            <input class="form-control" type="date" required disabled value="<?= $anak->tanggal_lahir ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <h6>Jenis Kelamin</h6>
                                                            <input class="form-control" type="text" required disabled value="<?= $anak->jenis_kelamin ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <div class="form-group">
                                                                <h6>Golongan Darah</h6>
                                                                <input class="form-control" type="text" required disabled value="<?= $anak->golongan_darah ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <h6>Anak Ke-</h6>
                                                            <input class="form-control" type="number" required disabled value="<?= $anak->anak_ke ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <h6>Jumlah Saudara</h6>
                                                            <input class="form-control" type="number" required disabled value="<?= $anak->jumlah_saudara ?>">
                                                        </div>
                                                    </div>
                                                </div>

                                            </fieldset>    
                                        </div>
                                        <div class="tab-pane fade show" id="tab1" role="tabpanel">
                                            <table class="display table table-striped table-bordered tabeldata" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Bulan</th>
                                                        <th>Tagihan</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                 <tbody>
                                                    <?php 
                                                    $i = 1 ;
                                                    foreach ($rincian as $key =>$row) { ?>
                                                        <tr>
                                                            <td><?= $i++ ?></td>
                                                            <td> <?= date("M Y", strtotime($row->tanggal_tagihan)) ?></td>
                                                            <td> Rp. <?= number_format($row->harga) ?> </td>
                                                            <td align="center">
                                                                <button class="btn btn-outline-info btn-icon detail" type="button" data-date='<?= date("m-Y", strtotime($row->tanggal_tagihan)) ?>' data-id="<?= $id ?>">
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
                                                        <th>#</th>
                                                        <th>Bulan</th>
                                                        <th>Tagihan</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </tfoot>
                                            </table>                                       
                                        </div>
                                        <div class="tab-pane fade" id="tab2" role="tabpanel">
                                            <table class="display table table-striped table-bordered tabeldata" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Tanggal</th>
                                                        <th>Kategori</th>
                                                        <th>Uraian</th>
                                                        <th>Harga</th>
                                                        <th>Satuan</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                 <tbody>
                                                    <?php 
                                                    $i = 1 ;
                                                    foreach ($riwayat as $key =>$row) { ?>
                                                        <tr>
                                                            <td><?= $i++ ?></td>
                                                            <td> <?= date("d M Y", strtotime($row->tanggal_tagihan)) ?></td>
                                                            <td><?= ucwords($row->uraian) ?></td>
                                                            <td><?= ucwords($row->name) ?></td>
                                                            <td><?= number_format($row->harga) ?></td>
                                                            <td><?= ucwords($row->satuan) ?></td>
                                                            <td><?= ucwords($row->status == 1 ? 'Sukses' : 'Belum Bayar') ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Tanggal</th>
                                                            <th>Kategori</th>
                                                            <th>Uraian</th>
                                                            <th>Harga</th>
                                                            <th>Satuan</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end of col-->
                    </div>
                    <!-- end of main-content -->
                </div><!-- Footer Start -->

                <div class="modal fade" id="updating-modal" tabindex="-1" role="dialog" aria-labelledby="updating" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Tagihan</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table class="display table table-striped table-bordered" id="tblx" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Tanggal Tagihan</th> 
                                                <th>Jenis Tagihan</th>
                                                <th>Jumlah Tagihan</th>                            
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                         <tbody>
                                        </tbody>
                                    </table>
                                </div>                                  
                            </div>
                        </div>
                    </div>
                </div>

                <?php $this->load->view('layout/footer') ?>
            </div>
        </div>
    </body>
    <?php $this->load->view('layout/custom') ?>
    <script src="<?= base_url().'dist-assets/'?>js/plugins/datatables.min.js"></script>
    <script src="<?= base_url().'dist-assets/'?>js/scripts/datatables.script.min.js"></script>

    <script type="text/javascript">
        var url = "<?= base_url().$controller ?>";

        if ('.tabeldata') {
            $('.tabeldata').dataTable({
                "ordering": false,
                "searching": false,
                "lengthChange": false
            });
        } 

        $('.detail').click(function(){
            $("#tbl > tbody").empty();

            const id_anak = $(this).data('id') ;
            
            $.ajax({
                url: url + '/pembayaranrincian/' + id_anak,
                type:'POST',
                dataType: 'json',
                data: { 
                    id_anak,
                    'tanggal': $(this).data('date') 
                },
                success: function(data){
                    
                    if (data['list_tagihan'].length > 0) {
                        
                        $.each(data['list_tagihan'], function( index, row ) {
                            $("#tblx > tbody").append(
                                "<tr>"+
                                    "<td>"+row.tanggal_tagihan+"</td>"+
                                    "<td>"+row.name+"</td>"+
                                    "<td>"+numberWithCommas(row.harga)+"</td>"+
                                    "<td>"+ (row.status == 1 ? 'Belum Bayar' : 'Lunas')+"</td>"+
                                "</tr>"
                            );
                            
                        });
                        
                    } 

                    $("#updating-modal").modal('show');
                }                
            }); 
        })

        function getSearchParams(k){
            const url = $(location).attr('href').split("/");
            return url[6];
        }

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>
</html>


                                                                
                                                                    
                                                                
                                                            