<!DOCTYPE html>
<html lang="en" dir="/">

    <?php $this->load->view('layout/head') ?>
    <style>
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
                            <li><a href="#">Dashboard Medic</a></li>
                            <li><?= $title ?></li>
                        </ul>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card text-left">
                                <div class="card-body">
                                    <span class="card-title mb-1"><span class="fas fa-chart-line"></span>&nbsp;<b>Perkembangan Anak</b></span>
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
                                                <div class="chart-container" style="position: relative; height:25vh;">
                                                    <canvas id="chart_bb"></canvas>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 mb-4">
                                                <div class="chart-container" style="position: relative; height:25vh;">
                                                    <canvas id="chart_tb"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6 mb-4">
                                                <div class="chart-container" style="position: relative; height:25vh;">
                                                    <canvas id="chart_lila"></canvas>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 mb-4">
                                                <div class="chart-container" style="position: relative; height:25vh;">
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