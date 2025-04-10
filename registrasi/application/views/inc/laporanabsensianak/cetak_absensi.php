<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Laporan Absensi Anak</title>
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
            page-break-before: always;
        }

        .container {
            padding-top: 80px;
            padding-left: 40px;
            padding-right: 40px;
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
<?php $i = 0; $iter = 0;
foreach ($data_absensi as $key => $value){ ?>
    <?php if ($iter == 0 OR $iter % 26 == 0){ ?>
        <section class="sheet padding-10mm"><div class="container">
        <?php if ($iter == 0){ ?>
            <br>
            <h1>Laporan Absensi Anak&nbsp;a.n&nbsp;<span class="text-success font-weight-bold"><?= $data_anak->nama_anak ?></span>&nbsp;Tahun <?= $tahun_selected?><br>Usia:&nbsp;<span style="color: green"><?= hitung_usia($data_anak->tanggal_lahir) ?> <span style="color: grey"><i>(<?= $data_anak->nama_kelas ?>)</i></span></span></h1>
        <?php } ?>
        <br>
        <table class="table anak"  cellspacing="0" cellpadding="0" style="font-family: 'Open Sans', sans-serif; border-collapse: collapse; border: 1px solid #dee2e6;font-size: 12px" border="">
        <thead>
        <tr style="background-color: #bfdfff">
            <th style="width: 15%">Tanggal</th>
            <th style="width: 20%">Waktu Masuk</th>
            <th style="width: 20%">Waktu Pulang</th>
            <th style="width: 20%">Status</th>
            <th style="width: 25%">Keterangan</th>
        </tr>
        </thead>
        <tbody>
    <?php } ?>
    <tr>
        <td nowrap align="center" style="font-weight: bold ;font-style: italic; color: grey"><?= format_date_indonesia($value->tanggal).', '.date('d-m-Y', strtotime($value->tanggal)) ?></td>
        <td nowrap align="center"><?= $value->waktu_checkin ?></td>
        <td align="center"><?= format_date_indonesia(date($value->tanggal_checkout)).', '.date('d-m-Y', strtotime($value->tanggal_checkout)).' jam '.$value->waktu_checkout ?></td>
        <td align="center" nowrap style="font-size: 10px">
            <?php if (empty($value->id_absensi)) { ?>
                <span style="color: red">Belum Absen</span>
            <?php } else { ?>
                <?php if (!empty($value->waktu_checkout)){ ?>
                    <span style="font-style: italic; font-weight: bold">Durasi : <?= hitung_durasi_waktu(date('Y-m-d', strtotime($value->tanggal)).' '.$value->waktu_checkin, date('Y-m-d', strtotime($value->tanggal_checkout)).' '.$value->waktu_checkout); ?></span>
                <?php }else{ ?>
                    <span style="color: orangered">Belum Absen Pulang</span>
                <?php } ?>
            <?php } ?>
        </td>
        <td>
            <?php if (!empty($value->id_absensi)) { ?>
                &bullet;&nbsp;<span class="text-muted font-italic" style="font-size: 10px; color: grey; font-style: italic">Suhu Tubuh Masuk: <b><?= $value->suhu ?> °C</b>, Kondisi Masuk: <b><?= $value->kondisi == 1 ? 'Sehat':'Kurang Sehat' ?></b></span>
                <?php if (!empty($value->waktu_checkout)){ ?>
                    <br>
                    &bullet;&nbsp;<span style="font-size: 10px; color: grey; font-style: italic">Suhu Tubuh Pulang: <b><?= $value->suhu_checkout ?> °C</b>, Kondisi Pulang: <b><?= $value->kondisi_checkout == 1 ? 'Sehat':'Kurang Sehat' ?></b></span>
                <?php } ?>
            <?php } else { ?>
                <center>-</center>
            <?php } ?>
        </td>
    </tr>
    <?php if ($iter == count($data_absensi)-1 OR $iter % 26 == 25){ ?>
        </tbody>
        </table>
        </div>
        </section>
    <?php } ?>
    <?php $iter++; } ?>
</body>
</html>