<?php
function timeAgo($timestamp) {
    $timeDifference = time() - strtotime($timestamp);

    if ($timeDifference < 1) {
        return 'baru saja';
    }

    $timeUnits = [
        31536000 => 'tahun',
        2592000  => 'bulan',
        604800   => 'minggu',
        86400    => 'hari',
        3600     => 'jam',
        60       => 'menit',
        1        => 'detik'
    ];

    foreach ($timeUnits as $unitSeconds => $unitName) {
        $unitValue = floor($timeDifference / $unitSeconds);

        if ($unitValue >= 1) {
            return $unitValue . ' ' . $unitName . ($unitValue > 1 ? '' : '') . ' yang lalu';
        }
    }
}