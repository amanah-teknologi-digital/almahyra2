<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
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
<body>
    <section class="sheet padding-10mm">
        <div class="container">
            <h1>LAPORAN HARIAN</h1>
            
            <div class="card">
                <?php if ($anak->upload_foto_anak): ?>
                    <img class="card-img" src="<?= base_url().'uploads/'.$anak->upload_foto_anak?>" alt="Card image" />
                <?php endif ?>
            </div>

            <table class="table anak"  cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <th colspan="3"><p>BIODATA</p></th>
                    </tr>
                </thead>                
                <tbody>
                    <tr>
                        <td width="30%">Nama</td>
                        <td width="2%">:</td>
                        <td><?= ucwords($anak->nama) ?></td>
                    </tr>
                    <tr>
                        <td>Tempat, Tanggal Lahir</td>
                        <td>:</td>
                        <td><?= ucwords($anak->tempat_lahir) ?>, <?= date("d M Y", strtotime($anak->tanggal_lahir)) ?> </td>
                    </tr>
                    <tr>
                        <td>Zona</td>
                        <td>:</td>
                        <td><?= ucwords($zona->zona) ?></td>
                    </tr>
                    <tr>
                        <td>Educator/Pengasuh</td>
                        <td>:</td>
                        <td><?= ucwords($zona->pengajar) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>