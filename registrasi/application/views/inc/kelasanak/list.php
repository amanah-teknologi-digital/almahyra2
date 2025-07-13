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
                                        <table class="display table table-sm table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <!-- <th>#</th> -->
                                                    <th>Nama</th>
                                                    <th>Tempat/Tanggal Lahir</th>
                                                    <th>Tgl.Pendaftaran</th>
                                                    <th>Gol.Darah</th>
                                                    <th>Keterangan</th>
                                                    <th>Status</th>
                                                    <th>Kelas</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                             <tbody>
                                                <?php 
                                                $i = 1 ;
                                                foreach ($list as $key =>$row) { ?>
                                                    <tr>
                                                        <!-- <td><?= $i++ ?></td> -->
                                                        <td><?= ucwords($row->nama) ?><br>
                                                            <span class="text-muted text-small font-italic">Panggilan: <?= ucwords($row->nick) ?></span>
                                                        </td>
                                                        <td><?= ucwords($row->tempat_lahir) ?>, <?= date("d M Y", strtotime($row->tanggal_lahir)) ?> </td>
                                                        
                                                        <td><?= date("d M Y h:m", strtotime($row->date_created)) ?> </td>
                                                        <td align="center"><?= strtoupper($row->golongan_darah) ?></td>
                                                        <td>Anak ke <?= $row->anak_ke ?> dari <?= $row->jumlah_saudara ?> Bersaudara</td>
                                                        <td align="center" nowrap>
                                                            <span class="text-info font-weight-bold">Aktif</span>
                                                        </td>
                                                        <td align="center" nowrap><b><?= $row->nama_kelas; ?></b></td>
                                                        <td align="center" nowrap>
                                                            <?php if (empty($row->id_usia)) { ?>
                                                                <span class="text-success text-small font-italic font-weight-bold">Ubah ke kelas KB / TK ?</span>
                                                                <select class="form-control" required onchange="ubahKelasAnak(this, '<?= $row->id ?>')">
                                                                    <option value="" disabled selected>-- Pilih Kelas --</option>
                                                                    <?php foreach ($listkelasnonalmahyra as $kel){ ?>
                                                                        <option value="<?= $kel->id_usia ?>"><?= $kel->nama ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            <?php }else{ ?>
                                                                <button class="btn btn-sm btn-icon btn-primary kembalikealmahyra" type="button" data-id="<?= $row->id; ?>"><span class="fas fa-rotate-back"></span>&nbsp;Ubah ke Kelas Almahyra</button>
                                                                <br>
                                                                <span class="text-muted text-small font-italic">atau <span class="text-danger font-weight-bold">Ubah kelas KB / TK ?</span></span>
                                                                <select class="form-control" required onchange="ubahKelasAnak(this, '<?= $row->id ?>')">
                                                                    <option value="" disabled selected>-- Pilih Kelas --</option>
                                                                    <?php foreach ($listkelasnonalmahyra as $kel){ ?>
                                                                        <option value="<?= $kel->id_usia ?>" <?= $row->id_usia == $kel->id_usia ? 'selected':'' ?> ><?= $kel->nama ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            <?php } ?>
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
                <?php echo form_open_multipart($controller.'/updatestatus', 'id="frm_ubahstatus"'); ?>
                    <input type="hidden" name="id_anak" id="id_anak" required>
                    <input type="hidden" name="id_usia" id="id_usia" required>
                </form>
                <?php echo form_open_multipart($controller.'/updatekeAlmahyra', 'id="frm_ubahstatuskembali"'); ?>
                    <input type="hidden" name="id_anak" id="id_anakkembali" required>
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

        $(document).ready(function() {
            $('.select2').select2();

            $('.kembalikealmahyra').click(function(){
                if(confirm('Apakah anda yakin untuk kembali ke kelas Almahyra?')) {
                    let id = $(this).data('id');

                    $('#id_anakkembali').val(id);
                    $('#frm_ubahstatuskembali').submit();
                }
            });
        });

        function ubahKelasAnak(dom, id_anak){
            if(confirm('Apakah anda yakin untuk mengubah kelas anak ini? data akan berpindah kelas baru')){
                let id_usia = $(dom).val();

                $('#id_anak').val(id_anak);
                $('#id_usia').val(id_usia);
                $('#frm_ubahstatus').submit();
            }
        }
    </script>
</html>