<?php
require 'config.php';
require 'header.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO inventory (item_code, name, quantity, condition) VALUES ( ?, ?, ?, ?)");
    $stmt->execute([$_POST['item_code'], $_POST['name'], '', (int)$_POST['quantity'], $_POST['condition'],]);
}
header("Location: inventory.php");