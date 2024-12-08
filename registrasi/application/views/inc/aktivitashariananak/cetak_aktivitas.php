<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Aktivitas Harian</title>
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
        <h1>Aktivitas Harian&nbsp;a.n&nbsp;<span class="text-success font-weight-bold"><?= $data_anak->nama ?></span><br>Usia:&nbsp;<span style="color: green"><?= hitung_usia($data_anak->tanggal_lahir) ?> <span style="color: grey"><i>(<?= $data_anak->nama_kelas ?>)</i></span></span></h1>
        <span style="font-size: 12px;float: right;font-style: italic; margin-bottom: 5px;" ><?= format_date_indonesia($data_subtema->tanggal).', '.date('d-m-Y', strtotime($data_subtema->tanggal)) ?>&nbsp;subtema&nbsp;<b><?= $data_subtema->nama_subtema ?></b></span>
        <table class="table anak"  cellspacing="0" cellpadding="0" style="font-family: 'Open Sans', sans-serif; border-collapse: collapse; border: 1px solid #dee2e6;font-size: 12px" border="">
            <thead>
            <tr style="background-color: #bfdfff">
                <th style="width: 5%">No</th>
                <th style="width: 15%">Waktu</th>
                <th style="width: 45%">Nama Kegiatan</th>
                <th style="width: 10%">Status</th>
                <th style="width: 25%">Keterangan</th>
            </tr>
            </thead>
            <tbody>
            <?php $no = 1; foreach ($list_kegiatan as $key => $value) { ?>
                <tr>
                    <td align="center"><?= $no++ ?></td>
                    <td align="center"><?= Date('H:i',strtotime($value->jam_mulai)).' - '.Date('H:i',strtotime($value->jam_selesai)) ?></td>
                    <td><?= $value->uraian ?></td>
                    <td align="center">
                        <?php if ($value->status == 1 && !is_null($value->status)){ ?>
                            <span style="color: green">Ada</span>
                        <?php }else{ ?>
                            <span style="color: red">Tidak Ada</span>
                        <?php } ?>
                    </td>
                    <td>
                        <span style="color: grey; font-style: italic"><?= $value->keterangan? $value->keterangan:''; ?></span>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <br>
        <h5><b>Data Konklusi</b></h5>
        <table style="width: 100%; font-size: 12px;font-family: 'Open Sans', sans-serif;">
            <colgroup>
                <col style="width: 55%">
                <col style="width: 1%">
                <col style="width: 44%">
            </colgroup>
            <?php foreach ($konklusi as $cls) { ?>
                <tr style="border-bottom: 1px solid #c8c8c8">
                    <td>
                        <label>&bullet;&nbsp;<?= $cls->nama_konklusi ?>&nbsp;<?= empty($cls->flag)? '<b><i>(Optional)</i></b>':''; ?></label>
                    </td>
                    <td>:</td>
                    <td>
                        <?= !empty($cls->uraian)? $cls->uraian:''; ?>
                    </td>
                </tr>
                <?php if ($cls->jenis == 'select'){ ?>
                    <tr style="border-bottom: 1px solid #c8c8c8">
                        <td>
                            <label>&bullet;&nbsp;Keterangan Pilihan <b><i>(Optional)</i></b></label>
                        </td>
                        <td>:</td>
                        <td>
                            <?= !empty($cls->keterangan)? $cls->keterangan:''; ?>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </table>
    </div>
</section>
<section class="sheet padding-10mm">
    <div class="container">
        <?php if (isset($data_stimulus)){ ?>
            <h5><b><i class="fas fa-fw fa-award"></i> Capaian Indikator</b></h5>
            <?php if (count($capaian_indikator) > 0){ ?>
                <table class="table table-sm table-bordered" style="font-size: 12px;font-family: 'Open Sans', sans-serif;">
                    <tr style="background-color: burlywood;">
                        <td class="font-weight-bold border-gray-600" style="width: 5%" align="center">No</td>
                        <td class="font-weight-bold border-gray-600" style="width: 90%" align="center">Nama Indikator</td>
                    </tr>
                    <?php foreach ($capaian_indikator as $key => $value) { ?>
                        <tr>
                            <td class="border-gray-600" align="center"><?= $key+1 ?></td>
                            <td class="border-gray-600 font-italic nowrap text-muted font-weight-bold"><?= $value->nama_aspek.' - '. str_replace('?','', str_replace('ananda','', str_replace('Apakah','', $value->nama_indikator))).' <span class="text-success">('.$value->nama_usia.')</span>' ?></td>
                        </tr>
                    <?php } ?>
                </table>
            <?php }else{ ?>
                <span class="text-muted font-italic">Data Kosong!</span>
            <?php } ?>
        <?php }else{ ?>
            <span class="text-danger font-italic text-small d-flex align-items-center justify-content-center font-weight-bold">Data stimulus kosong!</span>
        <?php } ?>
    </div>
</section>
</body>
</html>