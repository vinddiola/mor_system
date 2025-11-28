<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Students table columns
    $student_no  = $_POST['student_no'] ?? '';
    $first_name  = $_POST['first_name'] ?? '';
    $last_name   = $_POST['last_name'] ?? '';
    $dob         = $_POST['dob'] ?? '';
    $contact     = $_POST['contact'] ?? '';
    $address     = $_POST['address'] ?? '';

    // Student medical columns
    $allergies        = $_POST['allergies'] ?? '';
    $immunizations    = $_POST['immunizations'] ?? '';
    $emergency_action = $_POST['emergency_action'] ?? '';

    try {
        $pdo->beginTransaction();

        // Insert into students table
        $stmt = $pdo->prepare("
            INSERT INTO students (student_no, first_name, last_name, dob, contact, address)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$student_no, $first_name, $last_name, $dob, $contact, $address]);

        $student_id = $pdo->lastInsertId();

        // Insert into student_medical table
        $stmtMedical = $pdo->prepare("
            INSERT INTO student_medical (student_id, allergies, immunizations, emergency_action)
            VALUES (?, ?, ?, ?)
        ");
        $stmtMedical->execute([$student_id, $allergies, $immunizations, $emergency_action]);

        $pdo->commit();

        // Redirect after saving
        header("Location: students.php?success=1");
        exit;

    } catch (Exception $e) {
        $pdo->rollBack();
        echo "ERROR: " . $e->getMessage();
    }
}
?>
