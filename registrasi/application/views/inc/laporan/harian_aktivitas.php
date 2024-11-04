<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        .aktivitas th {
            color: white;
            background: #4F3BD9;
        }
    </style>
</head>
<body>
    <section class="sheet padding-10mm">
        <div class="container">
            <h1>LAPORAN AKTIVITAS HARIAN</h1>
            
            <table class="table aktivitas">
                <thead>
                    <tr>
                        <th width="20%">JADWAL</th>
                        <th width="40%">KEGIATAN</th>
                        <th width="40%">PELAKSANAAN</th>
                    </tr>
                </thead>                
                <tbody>
                    <?php 
                    $i = 1 ;
                    foreach ($aktivitas as $key =>$row) { ?>
                        <tr>
                            <td><?= date("H:i", strtotime($row->waktu_awal)) ?> - <?= date("H:i", strtotime($row->waktu_akhir)) ?></td>
                            <td><?= $row->kegiatan ?></td>
                            <td><?= $row->pelaksanaan ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>