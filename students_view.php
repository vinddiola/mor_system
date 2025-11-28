<?php
require 'config.php';
require 'header.php';

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<div style='margin-left:280px;'><p class='text-danger'>No student ID provided.</p></div>";
    require 'footer.php';
    exit;
}

$student_id = $_GET['id'];

try {
    // Fetch student info with medical info
    $stmt = $pdo->prepare("
        SELECT s.*, sm.allergies, sm.immunizations, sm.blood_type
        FROM students s
        LEFT JOIN student_medical sm ON s.id = sm.student_id
        WHERE s.id = ?
        LIMIT 1
    ");
    $stmt->execute([$student_id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        echo "<div style='margin-left:280px;'><p class='text-danger'>Student not found.</p></div>";
        require 'footer.php';
        exit;
    }

} catch (PDOException $e) {
    echo "<div style='margin-left:280px;'><p class='text-danger'>Error fetching student: " . $e->getMessage() . "</p></div>";
    require 'footer.php';
    exit;
}
?>

<div class="container" style="margin-left:280px; max-width: calc(100% - 280px);">
    <h2>Student Details</h2>
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?></h5>
        </div>
        <div class="card-body">
            <p><strong>Student No:</strong> <?= htmlspecialchars($student['student_no']) ?></p>
            <p><strong>Contact:</strong> <?= htmlspecialchars($student['contact'] ?? 'N/A') ?></p>
            <p><strong>Address:</strong> <?= htmlspecialchars($student['address'] ?? 'N/A') ?></p>
            <p><strong>Grade Level:</strong> <?= htmlspecialchars($student['grade_level'] ?? 'N/A') ?></p>
            <p><strong>Enrollment Date:</strong> <?= htmlspecialchars($student['enrollment_date'] ?? 'N/A') ?></p>

            <h5 class="mt-4">Medical Information</h5>
            <p>
                <strong>Allergies:</strong> <?= htmlspecialchars($student['allergies'] ?? 'None') ?><br>
                <strong>Immunizations:</strong> <?= htmlspecialchars($student['immunizations'] ?? 'None') ?><br>
                <strong>Blood Type:</strong> <?= htmlspecialchars($student['blood_type'] ?? 'N/A') ?>
            </p>

            <a href="students.php" class="btn btn-secondary">Back to List</a>
            <a href="students_delete.php?id=<?= $student['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
        </div>
    </div>
</div>

<?php require 'footer.php'; ?>
