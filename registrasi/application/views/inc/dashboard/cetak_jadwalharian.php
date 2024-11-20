<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Jadwal Harian</title>
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

        .anak th {
            border:0px solid #000000;
        }

        .anak td {
            border:0px solid #000000;
            height: 35px;
        }

        img {
            max-width: 100%;
            /*max-height: 100%;*/
            max-height: 360px;!important;
            min-height: 360px;!important;
        }

        .portrait {
            height: 80px;
            width: 30px;
        }

        .card {
            margin:auto;
            text-align:center
        }

    </style>
</head>
<body class="A4">
    <section class="sheet padding-10mm">
        <div class="container">
            <br>
            <h1>Jadwal Harian Kelas <?= $data_kelas->nama ?> <br><?= format_date_indonesia(Date('Y-m-d:H:i:s')).', '.date('d-m-Y'); ?></h1>
            <br>
            <table class="table anak"  cellspacing="0" cellpadding="0" style="border-collapse: collapse; border: 1px solid #dee2e6; font-size: 12px;" border="">
                <thead>
                    <tr style="background-color: #bfdfff">
                        <th align="center" style="width: 5%">No</th>
                        <th align="center" style="width: 20%">Jam</th>
                        <th align="center" style="width: 50%">Kegiatan</th>
                        <th align="center" style="width: 25%">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (isset($data_jadwal_harian[$id_kelas])){
                    foreach ($data_jadwal_harian[$id_kelas] as $key => $kegiatan){ ?>
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
        </div>
    </section>
    <section class="sheet padding-10mm">
        <div class="container">
            <br>
            <h1>Kegiatan Stimulus</h1>
            <br>
            <?php if (isset($data_jadwal_stimulus[$id_kelas])){ ?>
                <table class="table anak" style="width: 100%;font-size: 12px;">
                    <tr>
                        <td nowrap style="width:20%;background-color: #bfdfff;border: 1px solid #dee2e6;"><b>Nama Tema Stimulus</b></td>
                        <td style="background-color: rgba(0, 0, 0, 0.05);">
                            <span><b><?= $data_jadwal_stimulus[$id_kelas]->nama ?></b></span>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap style="width:20%;background-color: #bfdfff;border: 1px solid #dee2e6"><b>Uraian Kegiatan Stimulus</b></td>
                        <td style="background-color: rgba(0, 0, 0, 0.05);">
                            <?= isset($data_jadwal_stimulus[$id_kelas])? $data_jadwal_stimulus[$id_kelas]->rincian_kegiatan:'';  ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap style="width:20%;background-color: #bfdfff;border: 1px solid #dee2e6"><b>Keterangan</b></td>
                        <td style="background-color: rgba(0, 0, 0, 0.05);">
                            <span style="font-style: italic;color: gray"><?= isset($data_jadwal_stimulus[$id_kelas])? $data_jadwal_stimulus[$id_kelas]->keterangan:'';  ?></span>
                        </td>
                    </tr>
                </table>
            <?php }else{ ?>
                <center><p style="color: red">Data stimulus kosong!</p></center>
            <?php } ?>
        </div>
    </section>
</body>
</html>