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
                                                        <select class="form-control select2" id="id_rincianjadwal_mingguan" name="id_rincianjadwal_mingguan" required>
                                                            <?php foreach ($tanggal as $key => $value) { ?>
                                                                <option value="<?= $value->id_rincianjadwal_mingguan ?>" <?= $id_rincianjadwal_mingguan == $value->id_rincianjadwal_mingguan ? 'selected' : '' ?>><?= 'Tema: '.$value->nama_tema.', '.format_date_indonesia($value->tanggal).' '.date('d-m-Y', strtotime($value->tanggal)).' ('.$value->nama_subtema.')' ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label>Nama Anak</label>
                                                    </td>
                                                    <td>
                                                        <select class="form-control select2" id="id_anak" name="id_anak" required>
                                                            <option value="">-- Pilih Anak --</option>
                                                            <?php foreach ($list_anak as $key => $value) { ?>
                                                                <option value="<?= $value->id ?>" <?= $id_anak == $value->id ? 'selected' : '' ?>><?= $value->nama_anak.' ('.hitung_usia($value->tanggal_lahir).')' ?>&nbsp;<?= $value->is_active ? 'aktif':'tidak aktif' ?></option>
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
                                        <?php if (!empty($data_anak)){ ?>
                                            <h5 class="card-title mb-1 d-flex align-content-center justify-content-between"><span class="float-left">Data Aktifitas Harian&nbsp;a.n&nbsp;<span class="text-success font-weight-bold"><?= $data_anak->nama_anak ?></span>&nbsp;Usia:&nbsp;<span class="text-info"><?= hitung_usia($data_anak->tanggal_lahir) ?> <span class="text-muted">(<?= $data_anak->nama_kelas ?>)</span></span></span>
                                                <button class="btn btn-sm btn-primary float-right"><span class="fas fa-print"></span>&nbsp;Cetak Capaian</button>
                                            </h5>
                                        <?php }else{ ?>
                                            <h5 class="card-title mb-1 d-flex align-content-center justify-content-center"><span class="text-danger font-weight-bold">Pilih Anak terlebih dahulu, kemudian klik tombol <span class="text-success">Tampilkan</span> untuk menampilkan data!</span></h5>
                                        <?php } ?>
                                        <br>
                                        <?php if (!empty($data_aktivitas)){ ?>
                                            <div class="table-responsive">
                                                <table class="display table table-sm table-bordered" id="example">
                                                    <thead style="background-color: #bfdfff">
                                                    <tr>
                                                        <th style="width: 5%">No</th>
                                                        <th style="width: 15%">Waktu</th>
                                                        <th style="width: 35%">Nama Kegiatan</th>
                                                        <th style="width: 20%">Status</th>
                                                        <th style="width: 25%">Keterangan</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php $no = 1; foreach ($list_kegiatan as $key => $value) { ?>
                                                        <tr>
                                                            <td align="center"><?= $no++ ?></td>
                                                            <td align="center"><?= Date('H:i',strtotime($value->jam_mulai)).' - '.Date('H:i',strtotime($value->jam_selesai)) ?></td>
                                                            <td><b class="text-muted"><?= $value->uraian ?></b></td>
                                                            <td align="center">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="status<?= $value->id_rincianjadwal_harian ?>" id="inlineRadio1<?= $value->id_rincianjadwal_harian ?>" value="1" <?= $value->status == 1 && !is_null($value->status)? 'checked':''; ?> >
                                                                    <label class="form-check-label" for="inlineRadio1">Ada</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="status<?= $value->id_rincianjadwal_harian ?>" id="inlineRadio2<?= $value->id_rincianjadwal_harian ?>" value="0" <?= $value->status != 1 && !is_null($value->status)? 'checked':''; ?>>
                                                                    <label class="form-check-label" for="inlineRadio2">Tidak</label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <textarea class="form-control" name="keterangan<?= $value->id_rincianjadwal_harian ?>" id="keterangan<?= $value->id_rincianjadwal_harian ?>" cols="10" rows="2"><?= $value->keterangan? $value->keterangan:''; ?></textarea>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <br>
                                            <h5 class="card-title"><b>Data Konklusi</b></h5>
                                            <fieldset>
                                                <?php foreach ($konklusi as $cls) { ?>
                                                    <div class="form-group">
                                                        <label><?= $cls->nama_konklusi ?>&nbsp;<?= empty($cls->flag)? '<b><i>(Optional)</i></b>':''; ?></label>
                                                        <?php if ($cls->jenis == 'select'){ $temp_nilai = json_decode($cls->nilai,true); ?>
                                                            <select class="form-control" name="<?= $cls->kolom ?>" id="<?= $cls->kolom ?>" <?= !empty($cls->flag)? $cls->flag:''; ?>>
                                                                <option value="">-- Pilih Salah Satu --</option>
                                                                <?php foreach ($temp_nilai as $nilai){ ?>
                                                                    <option value="<?= $nilai ?>" <?= $nilai == $cls->uraian? 'selected':'' ?>><?= $nilai ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <br>
                                                            <textarea class="form-control" name="keterangan_konklusi<?= $cls->id_konklusi_input ?>" id="keterangan_konklusi<?= $cls->id_konklusi_input ?>" placeholder="Keterangan Pilihan (Optional)" cols="30" rows="5" autocomplete="off"><?= !empty($cls->keterangan)? $cls->keterangan:''; ?></textarea>
                                                        <?php }elseif ($cls->jenis == 'textarea'){ ?>
                                                            <textarea class="form-control" name="<?= $cls->kolom ?>" id="<?= $cls->kolom ?>" cols="30" rows="5" <?= !empty($cls->flag)? $cls->flag:''; ?> autocomplete="off"><?= !empty($cls->uraian)? $cls->uraian:''; ?></textarea>
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>
                                            </fieldset>
                                            <div class="d-flex align-items-center justify-content-center">
                                                <button type="submit" class="btn btn-sm btn-success "><span class="fas fa-save"></span>&nbsp;Simpan Data</button>
                                            </div>
                                            <input type="hidden" name="id_aktivitas" value="<?= $id_aktivitas ?>">
                                            <br>
                                            <h5 class="card-title"><b>Data Stimulus</b></h5>
                                            <?php if (isset($data_stimulus)){ ?>
                                                <div class="callout callout-primary alert-dismissible fade show">
                                                    <h4><i class="fas fa-fw fa-info-circle"></i> Fokus <?= $data_stimulus->nama ?>&nbsp;<span class="text-muted">(<?= $data_anak->nama_kelas ?>)</span></h4>
                                                    <span><?= isset($data_stimulus)? $data_stimulus->rincian_kegiatan:'';  ?></span>
                                                    <span class="font-italic text-muted">Keterangan: <?= isset($data_stimulus)? $data_stimulus->keterangan:'-';  ?></span>
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <h4 class="mt-3 text-warning font-weight-bold" style="text-shadow: 1px 1px 0 #000, -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000;"><i class="fas fa-fw fa-award"></i> Capaian Indikator</h4>
                                                        <a href="#" class="btn btn-sm btn-primary tambahindikator"><i class="fas fa-fw fa-plus"></i> Tambah Capaian Indikator</a>
                                                    </div>
                                                    <?php if (count($capaian_indikator) > 0){ ?>
                                                        <table class="table table-sm table-bordered" style="font-size: 11px;">
                                                            <tr style="background-color: burlywood;">
                                                                <td class="font-weight-bold border-gray-600" style="width: 5%" align="center">No</td>
                                                                <td class="font-weight-bold border-gray-600" style="width: 80%" align="center">Nama Indikator</td>
                                                                <td class="font-weight-bold border-gray-600" style="width: 15%" align="center">Aksi</td>
                                                            </tr>
                                                            <?php foreach ($capaian_indikator as $key => $value) { ?>
                                                                <tr>
                                                                    <td class="border-gray-600" align="center"><?= $key+1 ?></td>
                                                                    <td class="border-gray-600 font-italic nowrap text-muted font-weight-bold"><?= $value->nama_aspek.' - '. str_replace('?','', str_replace('ananda','', str_replace('Apakah','', $value->nama_indikator))).' <span class="text-success">('.$value->nama_usia.')</span>' ?></td>
                                                                    <td class="border-gray-600" align="center">
                                                                        <div class="d-flex align-items-center justify-content-center">
                                                                            <span class="btn btn-sm btn-success btn-update" data-id="<?= $value->id_capaianindikator ?>" data-nama="<?= str_replace('?','', str_replace('ananda','', str_replace('Apakah','', $value->nama_indikator))) ?>"><span class="fas fa-eye"></span> Data</span>
                                                                            &nbsp;<span class="btn btn-sm btn-danger" onclick="deleteList('<?= $value->id_capaianindikator ?>')"><span class="fas fa-close"></span> Hapus</span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </table>
                                                    <?php }else{ ?>
                                                        <span class="text-muted font-italic">Data Kosong!</span>
                                                    <?php } ?>
                                                </div>
                                            <?php }else{ ?>
                                                <span class="text-danger font-italic text-small d-flex align-items-center justify-content-center font-weight-bold">Data stimulus kosong!</span>
                                            <?php } ?>
                                        <?php }else{ ?>
                                            <h5 class="card-title mb-1 d-flex align-content-center justify-content-center"><span class="text-danger font-weight-bold">Data aktivitas untuk hari ini kosong/belum diinputkan oleh educator!</span></h5>
                                        <?php } ?>
                                        <p class="font-italic float-right"><span class="fas fa-info-circle"></span>&nbsp;<span class="text-muted" style="font-size: 11px">Laporan aktivitas harian anak.</span></p>
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
    <script src="<?= base_url().'dist-assets/'?>js/plugins/datatables.min.js"></script>
    <script src="<?= base_url().'dist-assets/'?>js/scripts/datatables.script.min.js"></script>
    <script type="text/javascript">
        var url = "<?= base_url().$controller ?>";

        $(document).ready(function() {
            $('.select2').select2();
        });

        function resetInput(){
            $('#id_rincianjadwal_mingguan').html('');
        }

        function getDataTanggal(dom){
            let tahun = $(dom).val();
            resetInput();

            $.ajax({
                url: url+'/getDataTanggal',
                type: 'POST',
                data: {tahun: tahun},
                success: function(data){
                    console.log(data);
                    let data_tanggal = data['tanggal'];

                    $.each(data_tanggal, function(key, value){
                        $('#id_rincianjadwal_mingguan').append('<option value="'+value.id_rincianjadwal_mingguan+'">Tema: '+value.nama_tema+', '+ value.nama_hari + ' ' +value.tanggal+' ('+value.nama_subtema+')</option>');
                    });
                }
            });
        }
    </script>
</html>