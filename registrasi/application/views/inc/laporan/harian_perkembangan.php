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

        .aktivitas {
            font-family: sans-serif;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <section class="sheet padding-10mm">
        <div class="container">
            <h1>LAPORAN PENGGUNAAN PERLENGKAPAN ANAK</h1>
            
            <table class="table aktivitas">
                <thead>
                    <tr>
                        <th>Lingkup Perkembangan</th>
                        <th>Tingkat Pencapaian Perkembangan </th>
                        <th>Observasi Orang Tua</th>
                        <th>Progress</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>    
                <tbody>
                    <?php 
                    $i = 1 ;
                    foreach ($list_kembang as $key =>$row) { ?>
                        <tr <?= $row->answer == '2' ? 'style=" color:red"':''; ?> >
                            <td><?= ucwords($row->aspek) ?></td>
                            <td><?= $row->name ?></td>
                            <td><?= $row->answer == '1' ? 'Sudah' : 'Belum'?></td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                    <?php } ?>       
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>