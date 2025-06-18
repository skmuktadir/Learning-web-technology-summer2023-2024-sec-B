<?php
require_once('db.php');

function getAllStaff() {
    $conn = getConnection();
    $sql = "SELECT * FROM staff_schedule";
    $result = mysqli_query($conn, $sql);
    $staff = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $staff[] = $row;
    }

    return $staff;
}

function addStaff($data) {
    $conn = getConnection();
    $sql = "INSERT INTO staff_schedule (staff_name, role, shift_day, shift_time, availability, cost_estimate)
            VALUES ('{$data['name']}', '{$data['role']}', '{$data['day']}', '{$data['time']}', '{$data['availability']}', '{$data['cost']}')";
    return mysqli_query($conn, $sql);
}

function deleteStaff($id) {
    $conn = getConnection();
    $sql = "DELETE FROM staff_schedule WHERE id=$id";
    return mysqli_query($conn, $sql);
}

function getStaffById($id) {
    $conn = getConnection();
    $sql = "SELECT * FROM staff_schedule WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function updateStaff($data) {
    $conn = getConnection();
    $sql = "UPDATE staff_schedule SET staff_name='{$data['name']}', role='{$data['role']}', shift_day='{$data['day']}', 
            shift_time='{$data['time']}', availability='{$data['availability']}', cost_estimate='{$data['cost']}'
            WHERE id={$data['id']}";
    return mysqli_query($conn, $sql);
}
?>
