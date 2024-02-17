<?php
    $conn = odbc_connect('MS Access Database', '111', '111');

    if ($conn) {
        $year = intval($tahun);
        $month = intval($bulan);

        $sql1 = "SELECT CHECKINOUT.CHECKTIME, CHECKINOUT.USERID, 
             (SELECT NAME FROM USERINFO WHERE USERID = CHECKINOUT.USERID) AS UserName
                FROM CHECKINOUT 
                WHERE YEAR(CHECKINOUT.CHECKTIME) = $year AND MONTH(CHECKINOUT.CHECKTIME) = $month";

        $result1 = odbc_exec($conn, $sql1);

        if ($result1) {
            $data = [];

            while ($row1 = odbc_fetch_array($result1)) {
                $cleanedRow = array_map(function ($item) {
                    return mb_convert_encoding($item, 'UTF-8', 'UTF-8');
                }, $row1);

                $data[] = $cleanedRow;
            }

            odbc_close($conn);

            $json = json_encode($data, JSON_UNESCAPED_UNICODE);

            $url = 'http://127.0.0.1:8001/api/kirimdata/presensi';
            $postData = json_encode(['data1' => $json]);

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($postData),
            ]);

            $response = curl_exec($ch);
            curl_close($ch);

            // Proses respons sesuai kebutuhan Anda
            return $response;
        } else {
            odbc_close($conn);
            return 'Error executing query';
        }
    } else {
        return 'Failed to connect to MS Access Database';
    }

