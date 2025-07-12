<!DOCTYPE html>
<html lang="en" dir="/">

    <?php $this->load->view('layout/head') ?>
    <style>
        .callout {
            background-color: #fff;
            border: 1px solid #e4e7ea;
            border-left: 4px solid #c8ced3;
            border-radius: .25rem;
            margin: 1rem 0;
            padding: .75rem 1.25rem;
            position: relative;
        }

        .callout h4 {
            font-size: 1.3125rem;
            margin-top: 0;
            margin-bottom: .8rem
        }
        .callout p:last-child {
            margin-bottom: 0;
        }

        .callout-default {
            border-left-color: #777;
            background-color: #f4f4f4;
        }
        .callout-default h4 {
            color: #777;
        }

        .callout-primary {
            background-color: #d2eef7;
            border-color: #b8daff;
            border-left-color: #17a2b8;
        }
        .callout-primary h4 {
            color: #20a8d8;
        }

        .callout-success {
            background-color: #dff0d8;
            border-color: #d6e9c6;
            border-left-color: #28a745;
        }
        .callout-success h4 {
            color: #3c763d;
        }

        .callout-danger {
            background-color: #f2dede;
            border-color: #ebccd1;
            border-left-color: #d32535;
        }
        .callout-danger h4 {
            color: #a94442;
        }

        .callout-warning {
            background-color: #fcf8e3;
            border-color: #faebcc;
            border-left-color: #edb100;
        }
        .callout-warning h4 {
            color: #f0ad4e;
        }

        .callout-info {
            background-color: #d2eef7;
            border-color: #b8daff;
            border-left-color: #148ea1;
        }
        .callout-info h4 {
            color: #31708f;
        }

        .callout-dismissible .close {
            position: absolute;
            top: 0;
            right: 0;
            padding: .75rem 1.25rem;
            color: inherit;
        }

        .loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite; /* Safari */
            animation: spin 2s linear infinite;
        }

        /* Safari */
        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
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
                            <li><a href="#">Dashboard</a></li>
                        </ul>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card text-left">
                                <div class="card-body">
                                    <?php if (!empty($data_tema)){
                                        $now = date('Y-m-d'); ?>
                                        <span class="card-title mb-1"><span class="fas fa-calendar"></span>&nbsp;<b>Jadwal Hari</b>&nbsp;<span><?= format_date_indonesia($now).', '.date('d-m-Y'); ?></span>&nbsp;dengan Tema&nbsp;<span class="text-success"><?= $data_tema->nama_tema ?></span></span>
                                        <hr>
                                        <?php if (!empty($data_subtema)){ ?>
                                            <span class="text-muted font-italic text-small d-flex align-items-center justify-content-center font-weight-bold">Sub Tema <?= $data_subtema->nama_subtema ?></span>
                                            <br>
                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                <?php foreach ($data_kelas as $key => $kelas){ ?>
                                                    <li class="nav-item"><a class="nav-link <?= $key==0 ?'active':''; ?>" data-toggle="tab" href="#tab<?= $kelas->id_kelas ?>" role="tab"><?= $kelas->nama ?></a></li>
                                                <?php } ?>
                                            </ul>

                                            <div class="tab-content" id="myTabContent">
                                                <?php foreach ($data_kelas as $key => $kelas){ ?>
                                                    <div class="tab-pane fade show <?= $key==0 ?'active':''; ?>" id="tab<?= $kelas->id_kelas ?>" role="tabpanel">
                                                        <div class="card-body">
                                                            <?php echo form_open_multipart($controller.'/cetakjadwalharian', 'target="blank"'); ?>
                                                                <span class="card-title d-flex align-items-center justify-content-between">
                                                                    <button class="btn btn-sm btn-primary float-left"><span class="fas fa-print"></span>&nbsp;Cetak Jadwal <?= $kelas->nama ?></button>
                                                                </span>
                                                                <input type="hidden" name="id_rincianjadwal_mingguan" value="<?= $id_rincianjadwal_mingguan ?>">
                                                                <input type="hidden" name="id_kelas" value="<?= $kelas->id_kelas ?>">
                                                            </form>
                                                            <table class="display table table-sm table-striped table-bordered">
                                                                <thead style="background-color: #bfdfff">
                                                                <tr>
                                                                    <th align="center" style="width: 5%">No</th>
                                                                    <th align="center" style="width: 20%">Jam</th>
                                                                    <th align="center" style="width: 50%">Kegiatan</th>
                                                                    <th align="center" style="width: 25%">Keterangan</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php if (isset($data_jadwal_harian[$kelas->id_kelas])){
                                                                    foreach ($data_jadwal_harian[$kelas->id_kelas] as $key => $kegiatan){ ?>
                                                                        <tr>
                                                                            <td align="center"><?= $key+1; ?></td>
                                                                            <td align="center"><?= Date('H:i',strtotime($kegiatan->jam_mulai)).' - '.Date('H:i',strtotime($kegiatan->jam_selesai)) ?></td>
                                                                            <td><?= $kegiatan->uraian; ?></td>
                                                                            <td><span class="text-muted font-italic text-small"><?= $kegiatan->keterangan; ?></span></td>
                                                                        </tr>
                                                                    <?php }
                                                                }else{ ?>
                                                                    <tr>
                                                                        <td colspan="5" align="center"><span class="font-weight-bold text-danger text-small"><i>Data jadwal kosong!</i></span></td>
                                                                    </tr>
                                                                <?php } ?>
                                                                </tbody>
                                                            </table>
                                                            <br>
                                                            <h5 class="card-title"><b><i class="fas fa-lightbulb"></i> Data Stimulus</b></h5>
                                                            <?php if (isset($data_jadwal_stimulus[$kelas->id_kelas])){ ?>
                                                                <div class="callout callout-primary alert-dismissible fade show">
                                                                    <h4><i class="fas fa-fw fa-info-circle"></i> Fokus <?= $data_jadwal_stimulus[$kelas->id_kelas]->nama ?>&nbsp;<span class="text-muted">(<?= $kelas->nama ?>)</span></h4>
                                                                    <span><?= isset($data_jadwal_stimulus[$kelas->id_kelas])? $data_jadwal_stimulus[$kelas->id_kelas]->rincian_kegiatan:'';  ?></span>
                                                                    <span class="font-italic text-muted">Keterangan: <?= isset($data_jadwal_stimulus[$kelas->id_kelas])? $data_jadwal_stimulus[$kelas->id_kelas]->keterangan:'-';  ?></span>
                                                                </div>
                                                            <?php }else{ ?>
                                                                <span class="text-danger font-italic text-small d-flex align-items-center justify-content-center font-weight-bold">Data stimulus kosong!</span>
                                                            <?php } ?>
                                                            <br>
                                                            <h5 class="card-title"><b><i class="fas fa-hamburger"></i> Feeding Menu</b></h5>
                                                            <?php if (isset($data_feeding_menu[$kelas->id_kelas])){ ?>
                                                                <div class="callout callout-primary alert-dismissible fade show">
                                                                    <span><?= isset($data_feeding_menu[$kelas->id_kelas])? $data_feeding_menu[$kelas->id_kelas]->uraian:'';  ?></span>
                                                                    <span class="font-italic text-muted">Keterangan: <?= isset($data_feeding_menu[$kelas->id_kelas])? $data_feeding_menu[$kelas->id_kelas]->keterangan:'-';  ?></span>
                                                                </div>
                                                            <?php }else{ ?>
                                                                <span class="text-danger font-italic text-small d-flex align-items-center justify-content-center font-weight-bold">Data feeding menu kosong!</span>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        <?php }else{ ?>
                                            <span class="text-danger font-italic text-small d-flex align-items-center justify-content-center font-weight-bold">Sub Tema minggu ini belum ditentukan!</span>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <h5 class="card-title d-flex align-items-center justify-content-center">Jadwal Hari&nbsp;<span class="font-weight-bold"><?= format_date_indonesia(Date('Y-m-d:H:i:s')).', '.date('d-m-Y'); ?></span>&nbsp;<span class="text-danger">Tema Belum Ditentukan!</span></h5>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <!-- end of col-->
                    </div>
                    <!-- end of main-content -->
                </div><!-- Footer Start -->

                <?php $this->load->view('layout/footer') ?>
            </div>
        </div>
    </body>
    <?php $this->load->view('layout/custom') ?>
    <script src="<?= base_url().'dist-assets/'?>js/plugins/datatables.min.js"></script>
    <script src="<?= base_url().'dist-assets/'?>js/scripts/datatables.script.min.js"></script>
    <script src="<?= base_url().'dist-assets/'?>js/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        var url = "<?= base_url().$controller ?>";
        const arr_domctx = ['chart_bb', 'chart_tb', 'chart_lila', 'chart_lk'];
        let id_anak = <?= json_decode($id_anak)?>;
        const charts = {};

        $(document).ready(function() {
            $('#anak').select2();
            getDataPerkembanganAnak(id_anak);
        });

        function refreshGraph(dom){
            temp_id_anak = $(dom).val();
            getDataPerkembanganAnak(temp_id_anak);
        }

        function getDataPerkembanganAnak(id_anak){
            $('#loader').show();
            $('#ctx_graph').hide();

            $.ajax({
                url: url + '/getDataMedicalCheckup/' + id_anak,
                type:'GET',
                dataType: 'json',
                success: function(data){
                    if (data.length > 0){
                        $.each(data, function(index, value){
                            generateGraph(value['dom'], value, value['nama_form']);
                        });
                    }

                    $('#loader').hide();
                    $('#ctx_graph').show();
                },
                error: function(err){
                    $('#loader').hide();
                    $('#ctx_graph').show();
                }
            });
        }

        function generateGraph(ctx, data, title){
            let temp_ctx = document.getElementById(ctx);

            if (charts[ctx]) {
                charts[ctx].destroy(); // Destroy the chart instance
                charts[ctx] = null; // Remove the reference
            }

            let data_label = [];
            let data_value = [];
            $.each(data['data'], function(index, value){
                data_label.push(value['tanggal']);
                data_value.push(value['nilai']);
            });

            var options = {
                chart: {
                    type: 'line',
                    animations: { enabled: true },
                    toolbar: {
                        tools: {
                            zoom: true,
                            zoomin: false,
                            zoomout: false,
                            pan: false,  // ✅ aktifkan pan
                            reset: true
                        },
                        autoSelected: 'pan'  // ✅ set default jadi pan
                    }
                },
                title: {
                    text: title,
                    align: 'center',
                    margin: 10,
                    offsetX: 0,
                    offsetY: 0,
                    floating: false,
                    style: {
                        fontSize: '16px',
                        fontWeight: 'bold',
                        color: '#263238'
                    }
                },
                series: [{
                    name: title,
                    data: data_value
                }],
                xaxis: {
                    categories: data_label,
                },
                yaxis: {
                    labels: {
                        formatter: function (value) {
                            return value + ' cm'; // Ganti 'kg' dengan satuan yang diinginkan
                        }
                    }
                },
                tooltip: {
                    x: {
                        format: 'yyyy-MM-dd'
                    }
                },
                responsive: [{
                    breakpoint: 768, // Untuk ukuran layar mobile
                    options: {
                        chart: {
                            height: 250,  // Mengurangi tinggi chart di perangkat mobile
                            width: '100%',  // Responsif agar menyesuaikan dengan layar
                        },
                        xaxis: {
                            type: 'datetime',
                            labels: {
                                rotate: -45,  // Rotate label agar lebih mudah terbaca
                            }
                        },
                        grid: {
                            padding: {
                                left: 0,
                                right: 0
                            }
                        },
                        // Menonaktifkan animasi di perangkat mobile
                        animations: {
                            enabled: false  // Nonaktifkan animasi di layar kecil
                        }
                    }
                }]
            }

            var chart = new ApexCharts(document.querySelector("#"+ctx), options);

            chart.render();
            charts[ctx] = chart;
        }
    </script>
</html>