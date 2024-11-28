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
                            <li><a href="#">Absensi</a></li>
                            <li><?= $title ?></li>
                        </ul>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12 mb-4">
                            <div class="card text-left">
<!--                                <div class="card-header">-->
<!--                                    <p class="card-title mb-0">Filter</p>-->
<!--                                </div>-->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <?php echo form_open_multipart($controller); ?>
                                            <table style="width: 100%;padding: 10px 10px;">
                                                <colgroup>
                                                    <col style="width: 20%">
                                                    <col style="width: 80%">
                                                </colgroup>
                                                <tr>
                                                    <td>
                                                        <label>Tahun</label>
                                                    </td>
                                                    <td>
                                                        <select class="form-control" id="tahun" name="tahun" required onchange="getDataTanggal(this)">
                                                            <?php foreach ($tahun as $key => $value) { ?>
                                                                <option value="<?= $value->tahun ?>" <?= $tahun_selected == $value->tahun ? 'selected' : '' ?>><?= $value->tahun ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label>Tanggal</label>
                                                    </td>
                                                    <td>
                                                        <select class="form-control" id="id_rincianjadwal_mingguan" name="id_rincianjadwal_mingguan" required onchange="getDataKelas(this)">
                                                            <?php foreach ($tanggal as $key => $value) { ?>
                                                                <option value="<?= $value->id_rincianjadwal_mingguan ?>" <?= $id_rincianjadwal_mingguan == $value->id_rincianjadwal_mingguan ? 'selected' : '' ?>><?= 'Tema: '.$value->nama_tema.', '.format_date_indonesia($value->tanggal).' '.date('d-m-Y', strtotime($value->tanggal)).' ('.$value->nama_subtema.')' ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label>Kelas</label>
                                                    </td>
                                                    <td>
                                                        <select class="form-control" id="id_jadwalharian" name="id_jadwalharian" required>
                                                            <?php foreach ($kelas as $key => $value) { ?>
                                                                <option value="<?= $value->id_jadwalharian ?>" <?= $id_jadwalharian == $value->id_jadwalharian ? 'selected' : '' ?>><?= $value->nama_kelas ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" >
                                                        <button class="btn btn-sm btn-primary mt-4">Tampilkan</button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                        <hr>
                                        <div class="table-responsive">
                                            <table class="display table table-striped table-bordered" id="tbl" style="width:100%">
                                                <thead>
                                                <tr>
                                                    <!-- <th>#</th> -->
                                                    <th style="width: 5%">No</th>
                                                    <th style="width: 45%">Nama Anak</th>
                                                    <th style="width: 15%">Usia</th>
                                                    <th style="width: 10%">Kelamin</th>
                                                    <th style="width: 15%">Status</th>
                                                    <th style="width: 10%">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                               <?php
                                                $i = 1 ;
                                                foreach ($aktivitas as $key =>$row) { ?>
                                                    <tr>
                                                        <td align="center"><?= $i++ ?></td>
                                                        <td><b><?= $row->nama ?></b></td>
                                                        <td nowrap><span class="text-muted font-italic" style="font-size: 12px;"><?= hitung_usia($row->tanggal_lahir); ?></span></td>
                                                        <td align="center"><?= $row->jenis_kelamin == 'L'? 'Laki - Laki':'Perempuan'; ?></td>
                                                        <td align="center" nowrap>
                                                            <?= $row->progres_aktivitas.' / '.$jumlah_kegiatan ?><br>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width: <?= round(($row->progres_aktivitas/$jumlah_kegiatan)*100) ?>%;"><?= round(($row->progres_aktivitas/$jumlah_kegiatan)*100) ?>%</div>
                                                            </div>
                                                        </td>
                                                        <td align="center">
                                                            <button class="btn btn-sm btn-icon btn-success edit" type="button" data-id="<?= $row->id; ?>"><span class="fas fa-eye"></span>&nbsp;lihat data</button>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Anak</th>
                                                    <th>Usia</th>
                                                    <th>Kelamin</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <p class="font-italic float-right"><span class="fas fa-info-circle"></span>&nbsp;<span class="text-muted" style="font-size: 11px">List anak yang muncul adalah anak yang statusnya masih aktif.</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end of col-->
                    </div>
                    <!-- end of main-content -->
                </div><!-- Footer Start -->
                <form action="<?= $controller.'/checkAktivitas' ?>" id="frm_lihatdetail" method="POST">
                    <input type="hidden" name="id_anak" id="id_anak">
                    <input type="hidden" name="id_jadwalharian" value="<?= $id_jadwalharian; ?>" >
                </form>
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
            let id = $(this).data('id');

            $('#id_anak').val(id);
            $('#frm_lihatdetail').submit();
        });

        function resetInput(){
            $('#id_rincianjadwal_mingguan').html('');
            $('#id_jadwalharian').html('');
        }

        function getDataTanggal(dom){
            let tahun = $(dom).val();
            resetInput();

            $.ajax({
                url: url+'/getDataTanggal',
                type: 'POST',
                data: {tahun: tahun},
                success: function(data){
                    let data_tanggal = data['tanggal'];
                    let data_kelas = data['kelas'];

                    $.each(data_tanggal, function(key, value){
                        $('#id_rincianjadwal_mingguan').append('<option value="'+value.id_rincianjadwal_mingguan+'">Tema: '+value.nama_tema+', '+ value.nama_hari + ' ' +value.tanggal+' ('+value.nama_subtema+')</option>');
                    });

                    $.each(data_kelas, function(key, value){
                        $('#id_jadwalharian').append('<option value="'+value.id_jadwalharian+'">'+value.nama_kelas+'</option>');
                    });
                }
            });
        }

        function getDataKelas(dom){
            let id_rincianjadwal_mingguan = $(dom).val();
            $('#id_jadwalharian').html('');

            $.ajax({
                url: url+'/getDataKelas',
                type: 'POST',
                data: {id_rincianjadwal_mingguan: id_rincianjadwal_mingguan},
                success: function(data){
                    let data_kelas = data['kelas'];

                    $.each(data_kelas, function(key, value){
                        $('#id_jadwalharian').append('<option value="'+value.id_jadwalharian+'">'+value.nama_kelas+'</option>');
                    });
                }
            });
        }
    </script>
</html>