<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Jadwal Harian</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
    <link href="<?= base_url().'dist-assets/'?>css/plugins/fontawesome/css/all.min.css" rel="stylesheet" />
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

        body {
            font-family: Comic Sans MS, Comic Sans, cursive;
        }
      
        h1 {
            font-weight: bold;
            font-size: 16pt;
            text-align: center;
        }
      
        table {
            border-collapse: collapse;
            width: 100%;                        
            font-size: 12pt;
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
            background-image: url("<?= base_url().'dist-assets/'?>images/kop2.png");
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

    </style>
</head>
<body class="A4">
    <section class="sheet padding-10mm">
        <div class="container">
            <br>
            <h1>Jadwal Harian <?= $data_kelas->nama ?> <br><?= format_date_indonesia(Date('Y-m-d:H:i:s')).', '.date('d-m-Y'); ?></h1>
            <br>
            <table class="table anak"  cellspacing="0" cellpadding="0" style="border-collapse: collapse; border: 1px solid #dee2e6;" border="">
                <thead>
                    <tr style="background-color: #bfdfff">
                        <th align="center" style="width: 5%">No</th>
                        <th align="center" style="width: 20%">Jam</th>
                        <th align="center" style="width: 75%">Kegiatan</th>
<!--                        <th align="center" style="width: 25%">Keterangan</th>-->
                    </tr>
                </thead>
                <tbody>
                <?php if (isset($data_jadwal_harian[$id_kelas])){
                    foreach ($data_jadwal_harian[$id_kelas] as $key => $kegiatan){ ?>
                        <tr style="background-color: #d2eef7">
                            <td align="center"><?= $key+1; ?></td>
                            <td align="center"><?= Date('H:i',strtotime($kegiatan->jam_mulai)).' - '.Date('H:i',strtotime($kegiatan->jam_selesai)) ?></td>
                            <td><?= $kegiatan->uraian; ?></td>
<!--                            <td><span style="color: gray"><i>--><?php //= $kegiatan->keterangan; ?><!--</i></span></td>-->
                        </tr>
                    <?php }
                }else{ ?>
                    <tr>
                        <td colspan="4" align="center"><span class="font-weight-bold text-danger text-small"><i>Data Jadwal Kosong!</i></span></td>
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
                <div class="callout callout-primary alert-dismissible fade show">
                    <h4><i class="fas fa-fw fa-info-circle"></i> Tema <?= $data_jadwal_stimulus[$id_kelas]->nama ?>&nbsp;<span class="text-muted">(<?= $data_kelas->nama ?>)</span></h4>
                    <span><?= isset($data_jadwal_stimulus[$id_kelas])? $data_jadwal_stimulus[$id_kelas]->rincian_kegiatan:'';  ?></span>
                    <span style="font-style: italic;color: gray">Keterangan: <?= isset($data_jadwal_stimulus[$id_kelas])? $data_jadwal_stimulus[$id_kelas]->keterangan:'-';  ?></span>
                </div>
            <?php }else{ ?>
                <center><p style="color: red">Data stimulus kosong!</p></center>
            <?php } ?>
        </div>
    </section>
</body>
</html>