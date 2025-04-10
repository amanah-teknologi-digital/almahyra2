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

if (!function_exists('hitung_usia')) {
    function hitung_usia($tanggal_lahir) {
        $tanggal_lahir = new DateTime($tanggal_lahir); // Mengonversi tanggal lahir menjadi objek DateTime
        $sekarang = new DateTime(); // Tanggal saat ini
        $diff = $sekarang->diff($tanggal_lahir); // Menghitung selisih waktu

        // Menyusun usia berdasarkan tahun, bulan, dan hari
        $usia = '';

        // Jika tahun > 0, tampilkan tahun
        if ($diff->y > 0) {
            $usia .= $diff->y . ' Tahun ';
        }

        // Jika bulan > 0 atau tahun > 0 (agar bulan tetap ditampilkan meskipun tahun 0)
        if ($diff->m > 0 || $diff->y > 0) {
            $usia .= $diff->m . ' Bulan ';
        }

        // Selalu tampilkan hari jika lebih dari 0
        if ($diff->d > 0) {
            $usia .= $diff->d . ' Hari';
        }

        return $usia ?: 'Usia Tidak Diketahui'; // Jika tidak ada usia, tampilkan default 'Usia Tidak Diketahui'
    }
}

if (!function_exists('hitung_usia_histori')) {
    function hitung_usia_histori($tanggal_lahir, $tanggal_histori) {
        $tanggal_lahir = new DateTime($tanggal_lahir); // Mengonversi tanggal lahir menjadi objek DateTime
        $sekarang = new DateTime($tanggal_histori); // Tanggal saat ini
        $diff = $sekarang->diff($tanggal_lahir); // Menghitung selisih waktu

        // Menyusun usia berdasarkan tahun, bulan, dan hari
        $usia = '';

        // Jika tahun > 0, tampilkan tahun
        if ($diff->y > 0) {
            $usia .= $diff->y . ' Tahun ';
        }

        // Jika bulan > 0 atau tahun > 0 (agar bulan tetap ditampilkan meskipun tahun 0)
        if ($diff->m > 0 || $diff->y > 0) {
            $usia .= $diff->m . ' Bulan ';
        }

        // Selalu tampilkan hari jika lebih dari 0
        if ($diff->d > 0) {
            $usia .= $diff->d . ' Hari';
        }

        return $usia ?: 'Usia Tidak Diketahui'; // Jika tidak ada usia, tampilkan default 'Usia Tidak Diketahui'
    }
}

if (!function_exists('hitung_durasi_waktu')) {
    function hitung_durasi_waktu($start_time_str, $end_time_str){
        // Create DateTime objects from the time strings
        $start_time = new DateTime($start_time_str);
        $end_time = new DateTime($end_time_str);

        // Calculate the difference between the two times
        $interval = $start_time->diff($end_time);

        // Ambil total durasi dalam hari, jam, menit, dan detik
        $days = $interval->d;
        $hours = $interval->h;
        $minutes = $interval->i;
        $seconds = $interval->s;

        // Tambahkan hari ke jam jika ingin dijadikan total jam (opsional)
        $total_hours = $days * 24 + $hours;

        // Display the result
        return $total_hours . " Jam, " . $minutes . " Menit, " . $seconds . " Detik";
    }
}

if (!function_exists('hitungDurasiDalamMenit')) {
    function hitungDurasiDalamMenit($waktuAwal, $waktuAkhir) {
        // Pastikan waktu diformat dalam format yang didukung, misalnya "H:i" (jam:menit)
        $awal = DateTime::createFromFormat('H:i:s', $waktuAwal);
        $akhir = DateTime::createFromFormat('H:i:s', $waktuAkhir);

        // Jika salah satu waktu tidak valid, kembalikan pesan error
        if (!$awal || !$akhir) {
            return "Format waktu tidak valid. Gunakan format 'HH:mm'.";
        }

        // Hitung selisih waktu
        $interval = $awal->diff($akhir);

        // Konversi durasi ke dalam menit
        $durasiDalamMenit = ($interval->h * 60) + $interval->i;

        return $durasiDalamMenit;
    }
}