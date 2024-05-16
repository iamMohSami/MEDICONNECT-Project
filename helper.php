<?php

function getSpecialityIdFromName($specialityName, $database) {
    // Prepare the SQL statement
    $stmt = $database->prepare("SELECT id FROM specialties WHERE sname = ?");
    $stmt->bind_param("s", $specialityName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['id'];
    }

    return null; // If no matching specialty is found
}

function getSpecialityNameFromId($specialityId, $database) {
    $stmt = $database->prepare("SELECT sname FROM specialties WHERE id = ?");
    $stmt->bind_param("i", $specialityId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['sname'];
    }

    return null;
}

?>