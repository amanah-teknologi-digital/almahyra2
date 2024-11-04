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
            <h1 style="text-align:left;">CATATAN LAIN:</h1>
            
            <div style="margin-top:20px">&nbsp;</div>
            <hr>
            <div style="margin-top:20px">&nbsp;</div>
            <hr>

            <div style="margin-top:80px">&nbsp;</div>
            <table>
                <tr>
                    <td style="" width="45%">&nbsp;</td>
                    <td style="" width="10%">&nbsp;</td>
                    <td style="text-align: center;" width="45%">Sidoarjo, <?= date('d M Y') ?></td>
                </tr>

                <tr>
                    <td style="text-align: center;" width="45%">Mengetahui,</td>
                    <td style="" width="10%">&nbsp;</td>
                    <td style="text-align: center;" width="45%">&nbsp;</td>
                </tr>

                <tr>
                    <td style="text-align: center;" width="45%">Kepala Sekolah</td>
                    <td style="" width="10%">&nbsp;</td>
                    <td style="text-align: center;" width="45%">Educator/Pengasuh Anak</td>
                </tr>
                <tr>
                    <td colspan="3" height="100"></td>
                </tr>

                <tr>
                    <td style="text-align: center;" width="45%"><?= ucwords($kepala_sekolah->name) ?></td>
                    <td style="" width="10%">&nbsp;</td>
                    <td style="text-align: center;" width="45%"><?= ucwords($zona->pengajar) ?></td>
                </tr>
            </table>
        </div>
    </section>
</body>
</html>