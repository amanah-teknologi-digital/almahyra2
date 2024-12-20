<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Laporan Rekam Medik</title>
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
<section class="sheet padding-10mm">
    <div class="container">
        <h1>Rekam Medic&nbsp;a.n&nbsp;<span class="text-success font-weight-bold"><?= $data_checkup->nama_anak ?></span><br>Usia:&nbsp;<span style="color: green"><?= hitung_usia($data_checkup->tanggal_lahir) ?> <span style="color: grey"><i>(<?= $data_checkup->nama_kelas ?>)</i></span></span></h1>
        <br>
        <table style="font-family: 'Open Sans', sans-serif; font-style: italic;margin-bottom: 5px; border-collapse: collapse" border="1">
            <colgroup>
                <col style="width: 20%">
                <col style="width: 80%">
            </colgroup>
            <tr>
                <th style="padding: 10px;">Deskripsi</th>
                <th style="padding: 10px;">Nilai</th>
            </tr>
            <?php foreach ($data_rinciancheckup as $row){ ?>
                <tr>
                    <td nowrap style="padding: 10px;"><?= $row->nama_kolom ?></td>
                    <td style="padding: 10px;">
                        <span style="font-weight: bold"><?= $row->nilai.' '.$row->satuan; ?></span>
                        <?php if(!empty($row->aksi)){ ?>
                            &nbsp;<span>Aksi: <?= !empty($row->aksi_medic)? $row->aksi_medic:''; ?></span>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</section>
<?php if (count($list_file) > 0) { ?>
    <?php $i = 0;
    $iter = 0;
    foreach ($list_file as $key => $value) { ?>
        <?php if ($iter == 0 or $iter % 12 == 0) { ?>
            <section class="sheet padding-10mm"><div class="container">
            <?php if ($iter == 0) { ?>
                <h5><b><i class="fas fa-fw fa-photo-film"></i> Dokumentasi Rekam Medik</b></h5>
            <?php }else{ ?>
                <br>
            <?php } ?>
            <table style="border-collapse:separate; border-spacing: 0 1em;">
            <tbody>
        <?php } ?>
        <?php if ($iter == 0 OR $iter % 3 == 0){ ?>
    <tr>
    <?php } ?>
        <td align="center">
            <img src="<?= base_url().$value->download_url ?>" border=1 height=180 width=180 />
        </td>
        <?php if ($iter == count($list_file) - 1 or $iter % 3 == 2){ ?>
    </tr>
    <?php } ?>
        <?php if ($iter == count($list_file) - 1 or $iter % 12 == 11) { ?>
            </tbody>
            </table>
            </div>
            </section>
        <?php } ?>
        <?php $iter++;
    } ?>
<?php }else{ ?>
    <section class="sheet padding-10mm">
        <div class="container">
            <h5><b><i class="fas fa-fw fa-photo-film"></i> Dokumentasi Rekam Medik</b></h5>
        </div>
    </section>
<?php } ?>
</body>
</html>