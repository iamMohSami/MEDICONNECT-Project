<?php
session_start();

if (!isset($_SESSION['user'])) {
    // User is not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

// User is logged in, proceed with the consultation process
$speciality = $_GET['speciality'];

// Include the helper file
require_once 'helper.php';

// Include the database connection file
require_once 'connection.php';

// Assuming you have a 'specialties' table with an 'id' column for specialty IDs
$specialityId = getSpecialityIdFromName($speciality, $database);


if ($specialityId !== null) {
    // Specialty found, proceed with displaying the doctor list
    include 'connection.php'; // Include your database connection file

    $sqlmain = "SELECT * FROM doctor WHERE specialties = '$specialityId' ORDER BY docid DESC";
    $result = $database->query($sqlmain);

    if ($result->num_rows > 0) {
        // Display the filtered list of doctors
        echo '<table>';
        echo '<thead><tr><th>Doctor Name</th><th>Email</th><th>Specialties</th><th>Actions</th></tr></thead>';
        echo '<tbody>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['docname'] . '</td>';
            echo '<td>' . $row['docemail'] . '</td>';

            // Fetch the specialty name
            $specialtyName = getSpecialityNameFromId($row['specialties'], $database);

            echo '<td>' . $specialtyName . '</td>';

            // Add any desired actions or links here
            echo '<td><a href="appointment.php?docid=' . $row['docid'] . '">Book Appointment</a></td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo 'No doctors found for the selected specialty.';
    }
} else {
    echo 'Invalid specialty selected.';
}