<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Laporan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
    <style>
        @page { size: A4 }

        @media print {
          /*.sheet {page-break-after: always;}*/
            * {
                -webkit-print-color-adjust: exact !important;   /* Chrome, Safari 6 – 15.3, Edge */
                color-adjust: exact !important;                 /* Firefox 48 – 96 */
                print-color-adjust: exact !important;           /* Firefox 97+, Safari 15.4+ */
            }
        }
      
        h1 {
            font-weight: bold;
            font-size: 16pt;
            text-align: center;
            font-family: sans-serif;
        }
      
        table {
            border-collapse: collapse;
            width: 100%;                        
            font-size: 12pt;
            font-family: sans-serif;
        }

        .table th {
            padding: 8px 8px;
            border:1px solid #000000;
            text-align: center;
        }
      
        .table td {
            padding: 3px 3px;
            border:1px solid #000000;
        }
      
        .text-center {
            text-align: center;
        }

        .sheet {
            background-image: url("<?= base_url().'dist-assets/'?>images/kop.png");
            /* Full height */
            height: 100%;
            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            /*overflow: visible;
            height: auto !important;*/
        }

        .container {
            padding-top: 80px;
            padding-left: 40px;
            padding-right: 40px;
        }

    </style>
</head>
<body class="A4">
    <?php 
        $last = 0 ; 
        $x = 0 ;
    ?>
    <?php for ($i=0; $i < $jumlah ; $i++) {  ?>
        <?php $last = $i ; ?>
        <section class="sheet padding-10mm">
            <div class="container">
                <h1>RENCANA PEMBELAJARAN TEMATIK TAHUNAN</h1>
                
                <table class="table anak" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr style="background: #2196f3; color: white;">
                            <!-- <th>#</th> -->
                            <th>Bulan</th>
                            <th>Tanggal</th>
                            <th>Tema/RPPB</th>
                            <th>Sub Tema/RPPM</th>
                            <th>SubSub Tema/RPPH</th>
                        </tr>
                    </thead>
                     <tbody>
                        <?php for ($j=$x; $j < $x+10 ; $j++) {  ?>
                            <tr>
                                <!-- <td><?= $i++ ?></td> -->
                                <td><?= date("M Y", strtotime($laporan[$j]->tanggal)) ?> </td>
                                <td><?= date("d", strtotime($laporan[$j]->tanggal)) ?> </td>
                                <td><?= ucwords($laporan[$j]->tema) ?></td>
                                <td><?= ucwords($laporan[$j]->subtema) ?></td>
                                <td><?= ucwords($laporan[$j]->subsubtema) ?></td>
                            </tr>

                            <?php $x = $j; ?>
                        <?php } ?>
                        
                    </tbody>
                </table>
            </div>
        </section>
    <?php } ?>
    
</body>
</html>
<!-- 
0 -> 0 - 10
1 -> 11- 20
2 -> 21 - 30
3 -->