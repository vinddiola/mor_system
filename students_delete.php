<?php
require 'config.php';

if(!isset($_GET['id'])) {
    header("Location: students.php");
    exit;
}

$id = $_GET['id'];

try {
    $stmt = $pdo->prepare("DELETE FROM students WHERE id=?");
    $stmt->execute([$id]);
    header("Location: students.php?deleted=1");
    exit;
} catch (Exception $e) {
    echo "ERROR: ".$e->getMessage();
}
