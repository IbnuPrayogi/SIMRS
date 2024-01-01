<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Jadwal Kerja Karyawan</title>
    <style>
        /* Styles remain unchanged */

        .employee-name {
            /* Updated styling for employee name */
            text-align: left;
            font-weight: bold;
            background-color: #4CAF50;
            color: white;
            padding: 8px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Styles remain unchanged */
    </style>
</head>
<body>

<?php
    // Fungsi untuk mendapatkan nama hari dalam Bahasa Indonesia
    if (!function_exists('getDayName')) {
        function getDayName($dayNumber) {
            $dayNames = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
            return $dayNames[$dayNumber - 1];
        }
    }

    // Contoh data jadwal kerja karyawan (Dummy Data)
    $scheduleData = array(
        'Alice' => array('shift1', 'shift2', 'off', 'shift1', 'off', 'shift2', 'shift1', 'off', 'shift2', 'shift1', 'off', 'shift2', 'shift1', 'shift2', 'off', 'shift1', 'shift2', 'off', 'shift1', 'shift2', 'off', 'shift1', 'shift2', 'off', 'shift1', 'shift2', 'off', 'shift1', 'shift2', 'off'),
        'Bob' => array('shift2', 'shift1', 'off', 'shift2', 'shift1', 'off', 'shift2', 'shift1', 'off', 'shift2', 'shift1', 'off', 'shift2', 'shift1', 'off', 'shift2', 'shift1', 'off', 'shift2', 'shift1', 'off', 'shift2', 'shift1', 'off', 'shift2', 'shift1', 'off', 'shift2', 'shift1', 'off'),
        'Charlie' => array('off', 'shift1', 'shift2', 'off', 'shift1', 'shift2', 'off', 'shift1', 'shift2', 'off', 'shift1', 'shift2', 'off', 'shift1', 'shift2', 'off', 'shift1', 'shift2', 'off', 'shift1', 'shift2', 'off', 'shift1', 'shift2', 'off', 'shift1', 'shift2', 'off', 'shift1', 'shift2', 'off'),
    );

    // Fetch user data from the database
    $users = App\Models\User::all();

    // Fetch shift data from the database
    $shifts = App\Models\Shift::all();

    // Menampilkan kalender untuk setiap bulan dalam data
    echo "<h2>Jadwal Karyawan Bulan " . date('F') . "</h2>";

    echo "<table>";
    echo "<tr><th></th>"; // Cell kosong untuk header tanggal

    for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')); $day++) {
        echo "<th>" . getDayName(date('N', strtotime(date('Y-m') . "-$day"))) . " $day " . date('F') . "</th>";
    }

    echo "</tr>";

    foreach ($users as $user) {
        echo "<tr>";
        echo "<td class='employee-name'>" . $user->nama_karyawan . "</td>";

        for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')); $day++) {
            echo "<td class='calendar-cell'>";
            
            // Fetch shift for the current user and day from the scheduleData array
            $shift = isset($scheduleData[$user->nama_karyawan][$day - 1]) ? $scheduleData[$user->name][$day - 1] : '';

            echo "<div class='shift-dropdown'>";
            echo "<select class='shift' onchange='changeShift(this.value, \"$user->nama_karyawan\", $day)'>";

            // Populate dropdown options with shifts from the database
            foreach ($shifts as $shiftOption) {
                echo "<option value='{$shiftOption->id}' " . ($shift === $shiftOption->id ? 'selected' : '') . ">{$shiftOption->nama_shift}</option>";
            }

            echo "</select>";
            echo "</div>";

            echo "</td>";
        }

        echo "</tr>";
    }

    echo "</table>";

    echo "<script>
        function changeShift(shiftId, userName, day) {
            // Implement your logic here to handle the shift change
            console.log('Selected Shift:', shiftId, 'for', userName, 'on day ' + day + ':', shiftId);
        }
    </script>";
?>

</body>
</html>
