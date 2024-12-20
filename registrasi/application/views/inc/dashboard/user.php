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
                            <li>Orang Tua/Wali</li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card text-left">
                                <div class="card-body">
                                    <span class="card-title mb-1"><span class="fas fa-chart-line"></span>&nbsp;<b>Pertumbuhan Anak</b></span>
                                    <hr>
                                    <div class="form-group row">
                                        <label for="anak" class="col-sm-2 col-form-label">Pilih Anak</label>
                                        <div class="col-sm-10">
                                            <select name="anak" id="anak" class="form-control" onchange="refreshGraph(this)">
                                                <?php foreach ($list_anak as $anak){ ?>
                                                    <option value="<?= $anak->id ?>" <?= $anak->id == $id_anak ? 'selected':'' ?>><?= $anak->nama_anak ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="ctx_graph">
                                        <div class="row">
                                            <div class="col-sm-6 mb-4">
                                                <div class="chart-container">
                                                    <canvas id="chart_bb"></canvas>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 mb-4">
                                                <div class="chart-container">
                                                    <canvas id="chart_tb"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6 mb-4">
                                                <div class="chart-container">
                                                    <canvas id="chart_lila"></canvas>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 mb-4">
                                                <div class="chart-container">
                                                    <canvas id="chart_lk"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="loader" style="display: none">
                                        <div class="col-sm-12">
                                            <div class="d-flex justify-content-center">
                                                <div class="loader"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="card text-left">
                                <?php if (!empty($data_anak)): $now = date('Y-m-d'); ?>
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <?php foreach ($data_anak as $key => $anak){ ?>
                                            <li class="nav-item"><a class="nav-link <?= $key==0 ?'active':''; ?>" data-toggle="tab" href="#tab<?= $anak->id ?>" role="tab"><?= $anak->nama ?>&nbsp;<span class="text-muted">(<?= $anak->nama_kelas ?>)</span></a></li>
                                        <?php } ?>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <?php foreach ($data_anak as $key => $anak){ ?>
                                            <div class="tab-pane fade show <?= $key==0 ?'active':''; ?>" id="tab<?= $anak->id ?>" role="tabpanel">
                                                <div class="card-body">
                                                    <?php echo form_open_multipart($controller.'/cetakjadwalharian', 'target="blank"'); ?>
                                                    <span class="card-title d-flex align-items-center justify-content-between"><span class="float-left"><i class="fas fa-calendar"></i> Jadwal Hari <span class="font-weight-bold"><?= format_date_indonesia($now).', '.date('d-m-Y'); ?></span> a.n <span class="text-success font-weight-bold"><?= $anak->nama ?></span>&nbsp;Usia:&nbsp;<span class="text-info"><?= hitung_usia($anak->tanggal_lahir) ?></span></span>
                                                        <button class="btn btn-sm btn-primary float-right"><span class="fas fa-print"></span>&nbsp;Cetak Jadwal</button>
                                                    </span>
                                                    <input type="hidden" name="id_rincianjadwal_mingguan" value="<?= $id_rincianjadwal_mingguan ?>">
                                                    <input type="hidden" name="id_kelas" value="<?= $anak->id_kelas ?>">
                                                    </form>
                                                    <?php if (!empty($data_subtema)): ?>
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
                                                            <?php if (isset($data_jadwal_harian[$anak->id_kelas])){
                                                                foreach ($data_jadwal_harian[$anak->id_kelas] as $key => $kegiatan){ ?>
                                                                    <tr>
                                                                        <td align="center"><?= $key+1; ?></td>
                                                                        <td align="center"><?= Date('H:i',strtotime($kegiatan->jam_mulai)).' - '.Date('H:i',strtotime($kegiatan->jam_selesai)) ?></td>
                                                                        <td><?= $kegiatan->uraian; ?></td>
                                                                        <td><span class="text-muted font-italic text-small"><?= $kegiatan->keterangan; ?></span></td>
                                                                    </tr>
                                                                <?php }
                                                            }else{ ?>
                                                                <tr>
                                                                    <td colspan="5" align="center"><span class="font-weight-bold text-danger text-small"><i>Data Jadwal Kosong!</i></span></td>
                                                                </tr>
                                                            <?php } ?>
                                                            </tbody>
                                                        </table>
                                                        <br>
                                                        <h5 class="card-title"><b><i class="fas fa-lightbulb"></i> Data Stimulus</b></h5>
                                                        <?php if (isset($data_jadwal_stimulus[$anak->id_kelas])){ ?>
                                                            <div class="callout callout-primary alert-dismissible fade show">
                                                                <h4><i class="fas fa-fw fa-info-circle"></i> Fokus <?= $data_jadwal_stimulus[$anak->id_kelas]->nama ?>&nbsp;<span class="text-muted">(<?= $anak->nama_kelas ?>)</span></h4>
                                                                <span><?= isset($data_jadwal_stimulus[$anak->id_kelas])? $data_jadwal_stimulus[$anak->id_kelas]->rincian_kegiatan:'';  ?></span>
                                                                <span class="font-italic text-muted">Keterangan: <?= isset($data_jadwal_stimulus[$anak->id_kelas])? $data_jadwal_stimulus[$anak->id_kelas]->keterangan:'-';  ?></span>
                                                            </div>
                                                        <?php }else{ ?>
                                                            <span class="text-danger font-italic text-small d-flex align-items-center justify-content-center font-weight-bold">Data stimulus kosong!</span>
                                                        <?php } ?>
                                                        <br>
                                                        <h5 class="card-title"><b><i class="fas fa-hamburger"></i> Feeding Menu</b></h5>
                                                        <?php if (isset($data_feeding_menu[$anak->id_kelas])){ ?>
                                                            <div class="callout callout-primary alert-dismissible fade show">
                                                                <span><?= isset($data_feeding_menu[$anak->id_kelas])? $data_feeding_menu[$anak->id_kelas]->uraian:'';  ?></span>
                                                                <span class="font-italic text-muted">Keterangan: <?= isset($data_feeding_menu[$anak->id_kelas])? $data_feeding_menu[$anak->id_kelas]->keterangan:'-';  ?></span>
                                                            </div>
                                                        <?php }else{ ?>
                                                            <span class="text-danger font-italic text-small d-flex align-items-center justify-content-center font-weight-bold">Data feeding menu kosong!</span>
                                                        <?php } ?>
                                                    <?php else: ?>
                                                        <span class="text-danger font-italic text-small d-flex align-items-center justify-content-center font-weight-bold">Data jadwal kosong!</span>
                                                    <?php endif ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php else: ?>
                                    <p class="mt-0"> Silahkan melakukan registrasi anak </p>
                                <?php endif ?>
                            </div>
                        </div>
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
                            generateGraph(value['dom'], value);
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

        function generateGraph(ctx, data){
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

            const chart = new Chart(temp_ctx, {
                type: 'line',
                data: {
                    labels: data_label,
                    datasets: [{
                        data: data_value,
                        borderWidth: 1,
                        borderColor: data['color'],
                        pointStyle: 'circle',
                        pointBackgroundColor: 'blue'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value + ' ' + data['satuan']; // Adding "kg" unit to the Y-axis values
                                }
                            }
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: data['nama_form']
                        },
                        legend: {
                            display: false
                        }
                    }
                }
            });

            charts[ctx] = chart;
        }
    </script>
</html>