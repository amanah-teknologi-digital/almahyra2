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
                            <li><a href="#">Rencana Belajar</a></li>
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
                                                        <select class="form-control" id="tahun" name="tahun" required>
                                                            <?php foreach ($tahun as $key => $value) { ?>
                                                                <option value="<?= $value->tahun ?>" <?= $tahun_selected == $value->tahun ? 'selected' : '' ?>><?= $value->tahun ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label>Bulan</label>
                                                    </td>
                                                    <td>
                                                        <select class="form-control" id="bulan" name="bulan" required>
                                                            <?php foreach ($bulan as $key => $value) { ?>
                                                                <option value="<?= $value->bulan ?>" <?= $bulan_selected == $value->bulan ? 'selected' : '' ?>><?= $value->nama ?></option>
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
                                        <?php
                                        if (empty($data_bulan->id_temabulanan)){
                                            $temp_uraian = '<span style="color: black">'.$data_bulan->nama_bulan.'</span>&nbsp;&nbsp;&nbsp;<span class="text-danger text-small">( tema belum ditentukan! )</span>';
                                            $btn_bulan = '&nbsp;<span class="btn btn-sm btn-success tentukan_tema" data-id="'.$data_bulan->bulan.'" data-nama="'.$data_bulan->nama_bulan.'"><span class="fas fa-plus"></span>&nbsp;Tentukan</span>';
                                        }else{
                                            $temp_uraian = '<span style="color: black">'.$data_bulan->nama_bulan.'</span>&nbsp;&nbsp;&nbsp;<span class="text-success text-small">( Tema: <b>'.$data_bulan->nama_temabulanan.'</b> )</span>';
                                            $temp_uraian .= '&nbsp;<span class="text-muted text-small"><i>terakhir update ';
                                            if (empty($data_bulan->updated_at)){
                                                $temp_uraian .= timeAgo($data_bulan->created_at);
                                            }else{
                                                $temp_uraian .= timeAgo($data_bulan->updated_at);
                                            }
                                            $temp_uraian .= ' oleh '.$data_bulan->nama_role.' ('.$data_bulan->nama_user.')</i></span>';
                                            $btn_bulan = '&nbsp;<span class="btn btn-sm btn-warning edit_tema" data-id="'.$data_bulan->id_temabulanan.'" data-nama="'.$data_bulan->nama_bulan.'"><span class="fas fa-edit"></span>&nbsp;Update</span>';
                                        } ?>

                                        <?php if (!empty($data_bulan->id_temabulanan)){ ?>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h5 class="card-title text-center">Tematik Bulan&nbsp;<b><?= $data_bulan->nama_bulan ?></b>&nbsp;dengan Tema&nbsp;<span class="text-success font-weight-bold"><?= $data_bulan->nama_temabulanan ?></span></h5>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="mb-3 d-flex justify-content-between align-items-center"><span class="text-muted font-italic text-small">
                                                <?php if (!empty($data_bulan->deskripsi)){ ?>
                                                    <b>Keterangan:&nbsp;</b><?= $data_bulan->deskripsi ?>
                                                <?php } ?>
                                                </span>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="display table table-bordered table-sm" >
                                                    <colgroup>
                                                        <col style="width: 10%">
                                                        <col style="width: 40%">
                                                        <col style="width: 20%">
                                                        <col style="width: 30%">
                                                    </colgroup>
                                                    <tr style="background-color: #bfdfff">
                                                        <th class="font-weight-bold">Periode</th>
                                                        <th class="font-weight-bold">Nama Sub Tema</th>
                                                        <th class="font-weight-bold">Tanggal</th>
                                                        <th class="font-weight-bold">Status Jadwal</th>
                                                    </tr>
                                                    <?php if (isset($data_subtema[$data_bulan->id_temabulanan]) && count($data_subtema[$data_bulan->id_temabulanan]) > 0){
                                                        foreach ($data_subtema[$data_bulan->id_temabulanan] as $key => $subtema){
                                                            $iter = 0;
                                                            foreach ($data_mingguan[$subtema['id_jadwalmingguan']] as $mingguan){ ?>
                                                                <tr>
                                                                    <?php if ($iter == 0){ ?>
                                                                        <td nowrap align="center" rowspan="<?= count($data_mingguan[$subtema['id_jadwalmingguan']]) ?>"><span class="font-italic font-weight-bold">Minggu ke <?= ($key+1) ?></span></td>
                                                                        <td nowrap rowspan="<?= count($data_mingguan[$subtema['id_jadwalmingguan']]) ?>"><?= $subtema['nama_subtema'] ?>
                                                                            <br>
                                                                            <i style="font-size: smaller">keterangan: <span class="text-muted"><?= $subtema['keterangan'] ?></span></i>
                                                                        </td>
                                                                    <?php } ?>
                                                                    <td nowrap align="center" class="text-muted "><i><?= format_date_indonesia($mingguan['tanggal']).', '. date('d-m-Y', strtotime($mingguan['tanggal'])) ?></i></td>
                                                                    <td nowrap align="center">
                                                                        <?php if (is_null($mingguan['is_inputjadwalharian'])){ ?>
                                                                            <span class="badge badge-danger">Belum diinput</span>
                                                                        <?php }else{ ?>
                                                                            <span class="badge badge-success">Sudah diinput</span>
                                                                        <?php } ?>
                                                                        &nbsp;<a href="<?= base_url().$redirect.'/'.$tahun_selected.'/jadwalharian/'.$mingguan['id_rincianjadwal_mingguan'] ?>" class="btn btn-sm btn-success"><span class="fas fa-eye"></span>&nbsp; Jadwal Harian</a>
                                                                    </td>
                                                                </tr>
                                                                <?php $iter++;
                                                            }
                                                        }
                                                    }else{ ?>
                                                        <tr>
                                                            <td colspan="5" align="center"><i class="text-small text-danger font-weight-bold">Data sub tema kosong!</i></td>
                                                        </tr>
                                                    <?php } ?>
                                                </table>
                                            </div>
                                        <?php }else{ ?>
                                            <h5 class="card-title d-flex align-items-center justify-content-center">Tematik Bulan&nbsp;<b><?= $data_bulan->nama_bulan ?></b>&nbsp;<span class="text-danger font-weight-bold">Tema belum ditentukan</span></h5>
                                        <?php } ?>

                                        <p class="font-italic float-right"><span class="fas fa-info-circle"></span>&nbsp;<span class="text-muted" style="font-size: 11px">Penentuan kegiatan dan stimulus anak sesuai masing - masing program kelas.</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end of col-->
                    </div>
                    <!-- end of main-content -->
                </div><!-- Footer Start -->
                <!--  Modal -->
                <?php $this->load->view('layout/footer') ?>
            </div>
        </div>
    </body>
    <?php $this->load->view('layout/custom') ?>
    <?php $this->load->view('layout/file_upload') ?>
    <script src="<?= base_url().'dist-assets/'?>js/plugins/datatables.min.js"></script>
    <script src="<?= base_url().'dist-assets/'?>js/scripts/datatables.script.min.js"></script>
    <script type="text/javascript">
        var url = "<?= base_url().$controller ?>";

        $(document).ready(function() {

        });
    </script>
</html>