<!DOCTYPE html>
<html lang="en" dir="/">
    <head>
        <link href="<?= base_url().'dist-assets/'?>css/themes/lite-purple.min.css" rel="stylesheet" />
        
        <style type="text/css">
            body {
                background-color: rgb(82, 86, 89);
            }

            .container {
                position: relative; 
            }

            .box {
                width: 24cm;
                min-height: 29.7cm;
                padding: 1cm 1.45cm;
                margin: 0cm auto;
                border-radius: 5px;
                background: white;
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
                text-align: center;
            }
            
            table { border-collapse: collapse; font-family: helvetica }

            td, th {
                border:  1px solid;
                padding: 5px;
                /*min-width: 100px;*/
                background: white;
                box-sizing: border-box;
                text-align: center;
            }

            .no-border {
                text-align: left!important;
                border: none!important;
            }

            @media print {
              .box {
                margin: 0;
                padding: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
              }
            }

            @media print{@page {size: portrait;}}

            @media screen {
              div.footer {
                display: none;
              }
            }
            
            @media print {
              div.footer {
                position: fixed;
                bottom: 0;
              }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="box">
                <h3>Laporan Tumbuh Kembang</h3>
                <br>
                <table class="table-striped table-bordered">
                    <tbody>
                        <tr>
                            <th>Nama</th>
                            <th>:</th>
                            <th><?= $anak->nama ?></th>
                        </tr>
                        <tr>
                            <th>Umur</th>
                            <th>:</th>
                            <th><?= $tahun ?> Tahun <?= $bulan ?> Bulan</th>
                        </tr>
                        <tr>
                            <th>Zona</th>
                            <th>:</th>
                            <th><?= $zona->zona ?></th>
                        </tr>
                    </tbody>
                </table>  
                
                <hr>
                <h5 align="left">Bentuk Badan</h5>
                <table class="display table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Tinggi Badan</th>
                            <th>Lingkar Kepala</th>
                            <th>Berat Badan</th>
                            <th>Bentuk Tubuh</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1 ;
                        foreach ($observasi as $key =>$row) { ?>
                        <tr>
                            <td> <?= $i ?></td>
                            <td> <?= $row->tanggal ?></td>
                            <td> <?= $row->tb ?></td>
                            <td> <?= $row->lk ?></td>
                            <td> <?= $row->bb ?></td>
                            <td> <?= $row->bt ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table> 

                <hr>
                <h5 align="left">Kondisi Fisik</h5>
                <table class="display table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Rambut</th>
                            <th>Mata</th>
                            <th>Telinga</th>
                            <th>Hidung</th>
                            <th>Mulut</th>
                            <th>Gigi</th>
                            <th>Kulit</th>
                            <th>Kuku</th>
                            <th>Tangan</th>
                            <th>Kaki</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1 ;
                        foreach ($observasi as $key =>$row) { ?>
                        <tr>
                            <td> <?= $row->tanggal ?></td>
                            <td> <?= $row->rambut == 1 ? 'Bersih' : 'Tidak Bersih' ?></td>
                            <td> <?= $row->mata == 1 ? 'Bersih' : 'Tidak Bersih' ?></td>
                            <td> <?= $row->telinga == 1 ? 'Bersih' : 'Tidak Bersih' ?></td>
                            <td> <?= $row->hidung == 1 ? 'Bersih' : 'Tidak Bersih' ?></td>
                            <td> <?= $row->mulut == 1 ? 'Bersih' : 'Tidak Bersih' ?></td>
                            <td> <?= $row->gigi == 1 ? 'Bersih' : 'Tidak Bersih' ?></td>
                            <td> <?= $row->kulit == 1 ? 'Bersih' : 'Tidak Bersih' ?></td>
                            <td> <?= $row->kuku == 1 ? 'Bersih' : 'Tidak Bersih' ?></td>
                            <td> <?= $row->tangan == 1 ? 'Bersih' : 'Tidak Bersih' ?></td>
                            <td> <?= $row->kaki == 1 ? 'Bersih' : 'Tidak Bersih' ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table> 
            </div>
        </div>
        <div class="footer"> <i>SIUTI Persediaan - Report</i> </div>
    </body>
</html>