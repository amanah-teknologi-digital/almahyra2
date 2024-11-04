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
       <section class="sheet padding-10mm">
            <div class="container">
                <h1>RRENCANA PELAKSANAAN PEMBELAJARAN HARIAN</h1>
                
                <table class="table anak" cellspacing="0" cellpadding="0" style="text-align:left!important;">
                    
                        <tr>
                            <!-- <th>#</th> -->
                            <th width="30%" align="left">Time Schedule</th>
                            <td><?= date("D, d M Y", strtotime($list_edit->ts))?></td>
                        </tr>
                        <tr>
                            <!-- <th>#</th> -->
                            <th width="30%">Time Actual </th>
                            <td><?= date("D, d M Y", strtotime($list_edit->ta))?></td>
                        </tr>
                        <tr>
                            <!-- <th>#</th> -->
                            <th width="30%">Tema / Subtema / Sub Subtema </th>
                            <td><?= $list_edit->tema ?></td>
                        </tr>
                        <tr>
                            <!-- <th>#</th> -->
                            <th width="30%">Usia, Zona </th>
                            <td><?= $list_edit->usia_zone ?></td>
                        </tr>
                        <tr>
                            <!-- <th>#</th> -->
                            <th colspan="2">Kompetensi Dasar </th>
                        </tr>
                        <tr>
                            <!-- <th>#</th> -->
                            <th width="30%">NAM: </th>
                            <td><?= $list_edit->nam ?></td>
                        </tr>
                        <tr>
                            <!-- <th>#</th> -->
                            <th width="30%">FM: </th>
                            <td><?= $list_edit->fm ?></td>
                        </tr>
                        <tr>
                            <!-- <th>#</th> -->
                            <th width="30%">KOG: </th>
                            <td><?= $list_edit->kog ?></td>
                        </tr>
                        <tr>
                            <!-- <th>#</th> -->
                            <th width="30%">BHS: </th>
                            <td><?= $list_edit->bhs ?></td>
                        </tr>
                        <tr>
                            <!-- <th>#</th> -->
                            <th width="30%">SOSEM: </th>
                            <td><?= $list_edit->sosem ?></td>
                        </tr>
                        <tr>
                            <!-- <th>#</th> -->
                            <th width="30%">SENI: </th>
                            <td><?= $list_edit->seni ?></td>
                        </tr>
                     
                </table>
            </div>
        </section>

        <section class="sheet padding-10mm">
            <div class="container">
                <h1>RRENCANA PELAKSANAAN PEMBELAJARAN HARIAN</h1>
                
                <table class="table anak" cellspacing="0" cellpadding="0" style="text-align:left!important;">
                    
                        <tr>
                            <!-- <th>#</th> -->
                            <th width="30%">Tujuan</th>
                            <td><?= str_replace(';', '<br>', $list_edit->tujuan) ?></td>
                        </tr>
                     
                </table>
            </div>
        </section>

         <section class="sheet padding-10mm">
            <div class="container">
                <h1>RRENCANA PELAKSANAAN PEMBELAJARAN HARIAN</h1>
                
                <table class="table anak" cellspacing="0" cellpadding="0" style="text-align:left!important;">
                    
                        <tr>
                            <!-- <th>#</th> -->
                            <th width="30%">Materi Kegiatan </th>
                            <td><?= str_replace(';', '<br>', $list_edit->materi) ?></td>
                        </tr>
                     
                </table>
            </div>
        </section>

        <section class="sheet padding-10mm">
            <div class="container">
                <h1>RRENCANA PELAKSANAAN PEMBELAJARAN HARIAN</h1>
                
                <table class="table anak" cellspacing="0" cellpadding="0" style="text-align:left!important;">
                    
                        <tr>
                            <!-- <th>#</th> -->
                            <th width="30%">Alat Bahan </th>
                            <td><?= str_replace(';', '<br>', $list_edit->alat) ?></td>
                        </tr>
                     
                </table>
            </div>
        </section>
        <section class="sheet padding-10mm">
            <div class="container">
                <h1>RRENCANA PELAKSANAAN PEMBELAJARAN HARIAN</h1>
                
                <table class="table anak" cellspacing="0" cellpadding="0" style="text-align:left!important;">
                    
                        <tr>
                            <!-- <th>#</th> -->
                            <th width="30%">Kegiatan Pembuka </th>
                            <td><?= str_replace(';', '<br>', $list_edit->pembuka) ?></td>
                        </tr>
                     
                </table>
            </div>
        </section>

         <section class="sheet padding-10mm">
            <div class="container">
                <h1>RRENCANA PELAKSANAAN PEMBELAJARAN HARIAN</h1>
                
                <table class="table anak" cellspacing="0" cellpadding="0" style="text-align:left!important;">
                    
                        <tr>
                            <!-- <th>#</th> -->
                            <th width="30%">Kegiatan Inti </th>
                            <td><?= str_replace(';', '<br>', $list_edit->inti) ?></td>
                        </tr>
                     
                </table>
            </div>
        </section>
        <section class="sheet padding-10mm">
            <div class="container">
                <h1>RRENCANA PELAKSANAAN PEMBELAJARAN HARIAN</h1>
                
                <table class="table anak" cellspacing="0" cellpadding="0" style="text-align:left!important;">
                    
                        <tr>
                            <!-- <th>#</th> -->
                            <th width="30%">Kegiatan Penutup </th>
                            <td><?= str_replace(';', '<br>', $list_edit->penutup) ?></td>
                        </tr>
                     
                </table>
            </div>
        </section>
    
</body>
</html>
<!-- 
0 -> 0 - 10
1 -> 11- 20
2 -> 21 - 30
3 -->