<?php
header('Content-Type: application/json ; charset=utf-8');
require("../database.php");
$faculty_name = isset($_GET['faculty']) ? $_GET['faculty'] : '';

$query = "SELECT d.DEVICENAME, d.FAVORITE, d.IMAGE, da.DURATION, COUNT(d.ITEMSTATUSNAME) as TOTALAVAILABLE
            FROM `devices` as d 
            INNER JOIN `location_name` as ln 
            ON ln.SHORTNAME = d.LOCATIONINITIAL
            INNER JOIN `devices_on_app` as da
            ON d.DEVICENAME = da.DEVICENAME
            WHERE d.ITEMSTATUSNAME = 'Available' AND ln.THNAME = '" . $faculty_name . "' AND da.UNLOCKDEVICE = '1'
            GROUP BY d.DEVICENAME";

$result = $DATABASE->query($query);

$data = "";
while ($row = $result->fetch_assoc()) {
    $data .= '{
        "id": "' . $row['DEVICENAME'] . '",
        "image": "' . $row["IMAGE"] . '",
        "favorite": "' . $row["FAVORITE"] . '",
        "duration": "' . $row["DURATION"] . '",
        "totalAvailable": "' . $row["TOTALAVAILABLE"] . '"
    },';
}

echo '[' . substr($data, 0, -1) . ']';
