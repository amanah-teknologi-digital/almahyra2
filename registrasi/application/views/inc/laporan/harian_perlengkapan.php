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
                        <th>ITEM</th>
                        <th>IN</th>
                        <th>OUT</th>
                        <th>SATUAN</th>
                    </tr>
                </thead>                
                <tbody>
                    <?php 
                    $i = 1 ;
                    foreach ($list_items as $key =>$row) { ?>
                        <tr>
                            <td><?= ucwords($row->item) ?></td>
                            <td align="center"><?= $row->jumlah ?></td>
                            <td align="center"><?= $row->jumlah-$row->sisa ?></td>
                            <td><?= $row->satuan ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>