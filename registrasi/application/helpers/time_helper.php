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

if (!function_exists('format_date_indonesia')) {
    function format_date_indonesia($date) {
        $days_in_indonesian = array(
            '0' => 'Minggu',
            '1' => 'Senin',
            '2' => 'Selasa',
            '3' => 'Rabu',
            '4' => 'Kamis',
            '5' => 'Jumat',
            '6' => 'Sabtu'
        );

        $timestamp = strtotime($date);
        $day_number = date('w', $timestamp);

        return $days_in_indonesian[$day_number];
    }
}