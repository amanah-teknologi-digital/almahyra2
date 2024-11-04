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
                        <th>Uraian</th>
                        <th>Observasi Orang Tua </th>
                        <th>Progress</th>
                    </tr>
                </thead>    
                <tbody>
                <?php if (!empty($observasi)) { ?>
                    <tr><td colspan="3"> <?= $observasi->tanggal ?></td></tr>
                    <tr>
                        <td>Tinggi Badan(cm)</td>
                        <td><?= $observasi->tb ?></td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Berat Badan(kg)</td>
                        <td><?= $observasi->bb ?></td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Lingkar Kepala (cm)</td>
                        <td><?= $observasi->lk ?></td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Bentuk Tubuh (Normal/Tidak Normal) </td>
                        <td><?= $observasi->bt == '1' ? 'Normal' : 'Tidak Normal' ?></td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Kebersihan (Bersih/Tidak Bersih) </td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Rambut </td>
                        <td><?= $observasi->rambut == '1' ? 'Normal' : 'Tidak Normal' ?></td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Mata </td>
                        <td><?= $observasi->mata == '1' ? 'Normal' : 'Tidak Normal' ?></td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Telinga </td>
                        <td><?= $observasi->telinga == '1' ? 'Normal' : 'Tidak Normal' ?></td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Hidung </td>
                        <td><?= $observasi->hidung == '1' ? 'Normal' : 'Tidak Normal' ?></td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Mulut </td>
                        <td><?= $observasi->mulut == '1' ? 'Normal' : 'Tidak Normal' ?></td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Gigi </td>
                        <td><?= $observasi->gigi == '1' ? 'Normal' : 'Tidak Normal' ?></td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Kulit </td>
                        <td><?= $observasi->kulit == '1' ? 'Normal' : 'Tidak Normal' ?></td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Kuku </td>
                        <td><?= $observasi->kuku == '1' ? 'Normal' : 'Tidak Normal' ?></td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Tangan </td>
                        <td><?= $observasi->tangan == '1' ? 'Normal' : 'Tidak Normal' ?></td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Kaki </td>
                        <td><?= $observasi->kaki == '1' ? 'Normal' : 'Tidak Normal' ?></td>
                        <td>-</td>
                    </tr>
                
                <?php } else { ?>
                    <tr>
                        <td colspan="3"> Tidak Ada Data</td>
                    </tr>
                <?php } ?>            
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>