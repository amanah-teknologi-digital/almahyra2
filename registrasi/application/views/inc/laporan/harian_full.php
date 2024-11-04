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
    <?php $this->load->view('inc/laporan/harian_biodata') ?>
    <?php $this->load->view('inc/laporan/harian_aktivitas') ?> 
    <?php $this->load->view('inc/laporan/harian_perlengkapan') ?>  
    <?php $this->load->view('inc/laporan/harian_pertumbuhan') ?>   
    <?php $this->load->view('inc/laporan/harian_perkembangan') ?>
    <?php $this->load->view('inc/laporan/harian_tandatangan') ?>
</body>
</html>