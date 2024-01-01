<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Jadwal Kerja Karyawan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .calendar-cell {
            position: relative;
        }

        .employee-name {
            text-align: left;
            font-weight: bold;
            background-color: #4CAF50;
            color: white;
            padding: 3px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .shift-dropdown {
            width: 100%;
            padding: 5px;
        }

        .shift {
            font-weight: bold;
        }

        .shift-off {
            color: #888;
        }

        .shift1 {
            color: #2196F3;
        }

        .shift2 {
            color: #f44336;
        }
    </style>
</head>
<body>

<?php
    // Fungsi untuk mendapatkan nama hari dalam Bahasa Indonesia
    if (!function_exists('getDayName')) {
        function getDayName($dayNumber) {
            $dayNames = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
            return $dayNames[$dayNumber];
        }
    }

    // Fungsi untuk mendapatkan nama bulan dalam Bahasa Indonesia
    if (!function_exists('getMonthName')) {
        function getMonthName($monthNumber) {
            $monthNames = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
            return $monthNames[$monthNumber];
        }
    }

    // Contoh data jadwal kerja karyawan (Dummy Data)
    $scheduleData = array(
        'Alice' => array('shift1', 'shift2', 'off', 'shift1', 'off', 'shift2', 'shift1', 'off', 'shift2', 'shift1', 'off', 'shift2', 'shift1', 'shift2', 'off', 'shift1', 'shift2', 'off', 'shift1', 'shift2', 'off', 'shift1', 'shift2', 'off', 'shift1', 'shift2', 'off', 'shift1', 'shift2', 'off'),
        'Bob' => array('shift2', 'shift1', 'off', 'shift2', 'shift1', 'off', 'shift2', 'shift1', 'off', 'shift2', 'shift1', 'off', 'shift2', 'shift1', 'off', 'shift2', 'shift1', 'off', 'shift2', 'shift1', 'off', 'shift2', 'shift1', 'off', 'shift2', 'shift1', 'off', 'shift2', 'shift1', 'off'),
        'Charlie' => array('off', 'shift1', 'shift2', 'off', 'shift1', 'shift2', 'off', 'shift1', 'shift2', 'off', 'shift1', 'shift2', 'off', 'shift1', 'shift2', 'off', 'shift1', 'shift2', 'off', 'shift1', 'shift2', 'off', 'shift1', 'shift2', 'off', 'shift1', 'shift2', 'off', 'shift1', 'shift2', 'off'),
    );

    // Menampilkan kalender untuk setiap bulan dalam data
    echo "<h2>Jadwal Karyawan Bulan " . getMonthName(1) . "</h2>";

    echo "<table>";
    echo "<tr><th></th>"; // Cell kosong untuk header karyawan
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, 1, 2024);
    for ($day = 1; $day <= $daysInMonth; $day++) {
        echo "<th>$day " . getMonthName(1) . "</th>";
    }
    echo "</tr>";

    foreach ($scheduleData as $employee => $schedule) {
        echo "<tr>";
        echo "<td class='employee-name'>$employee</td>";

        for ($day = 1; $day <= $daysInMonth; $day++) {
            echo "<td class='calendar-cell'>";
            
            $shift = isset($schedule[$day - 1]) ? $schedule[$day - 1] : '';
            echo "<div class='shift-dropdown'>";
            echo "<select class='shift' onchange='changeShift(this.value)'>";
            echo "<option value='off' " . ($shift === 'off' ? 'selected' : '') . ">Off</option>";
            echo "<option value='shift1' " . ($shift === 'shift1' ? 'selected' : '') . ">Shift 1</option>";
            echo "<option value='shift2' " . ($shift === 'shift2' ? 'selected' : '') . ">Shift 2</option>";
            echo "</select>";
            echo "</div>";

            echo "</td>";
        }

        echo "</tr>";
    }

    echo "</table>";

    echo "<script>
        function changeShift(value) {
            // Implement your logic here to handle the shift change
            console.log('Selected Shift:', value);
        }
    </script>";
?>

</body>
</html>
