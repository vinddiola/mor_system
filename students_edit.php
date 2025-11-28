<?php
require 'config.php';

// Handle POST first to avoid "headers already sent" issues
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id           = $_POST['id'];
    $student_no   = $_POST['student_no'];
    $first_name   = $_POST['first_name'];
    $last_name    = $_POST['last_name'];
    $contact      = $_POST['contact'];
    $address      = $_POST['address'];
    $grade_level  = $_POST['grade_level'];

    $allergies     = $_POST['allergies'];
    $immunizations = $_POST['immunizations'];

    try {
        $pdo->beginTransaction();

        // Update students table
        $stmtUpdate = $pdo->prepare("UPDATE students 
                                     SET student_no=?, first_name=?, last_name=?, contact=?, address=?, grade_level=? 
                                     WHERE id=?");
        $stmtUpdate->execute([$student_no, $first_name, $last_name, $contact, $address, $grade_level, $id]);

        // Update student_medical table
        $stmtMed = $pdo->prepare("UPDATE student_medical 
                                  SET allergies=?, immunizations=? 
                                  WHERE student_id=?");
        $stmtMed->execute([$allergies, $immunizations, $id]);

        $pdo->commit();

        // Redirect immediately after POST
        header("Location: students.php?success=1");
        exit;

    } catch (Exception $e) {
        $pdo->rollBack();
        die("ERROR: " . $e->getMessage());
    }
}

// Include header AFTER handling POST redirect
require 'header.php';

// Check GET parameter
if (!isset($_GET['id'])) {
    die("No student ID provided.");
}

$id = $_GET['id'];

// Fetch student data
$stmt = $pdo->prepare("SELECT s.*, sm.allergies, sm.immunizations
                       FROM students s 
                       LEFT JOIN student_medical sm ON s.id = sm.student_id 
                       WHERE s.id=?");
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    die("Student not found.");
}
?>

<h2 style="margin-left:280px;">Edit Student</h2>
<form method="post" style="margin-left: 280px; max-width: calc(100% - 300px);">
    <input type="hidden" name="id" value="<?= htmlspecialchars($student['id']) ?>">

    <div class="mb-3">
        <label>Student No</label>
        <input name="student_no" class="form-control" value="<?= htmlspecialchars($student['student_no']) ?>" required>
    </div>
    <div class="mb-3">
        <label>First Name</label>
        <input name="first_name" class="form-control" value="<?= htmlspecialchars($student['first_name']) ?>" required>
    </div>
    <div class="mb-3">
        <label>Last Name</label>
        <input name="last_name" class="form-control" value="<?= htmlspecialchars($student['last_name']) ?>" required>
    </div>
    <div class="mb-3">
        <label>Contact</label>
        <input name="contact" class="form-control" value="<?= htmlspecialchars($student['contact']) ?>">
    </div>
    <div class="mb-3">
        <label>Address</label>
        <input name="address" class="form-control" value="<?= htmlspecialchars($student['address']) ?>">
    </div>
    

    <h5>Medical Information</h5>
    <div class="mb-3">
        <label>Allergies</label>
        <textarea name="allergies" class="form-control"><?= htmlspecialchars($student['allergies']) ?></textarea>
    </div>
    <div class="mb-3">
        <label>Immunizations</label>
        <textarea name="immunizations" class="form-control"><?= htmlspecialchars($student['immunizations']) ?></textarea>
    </div>

    <button type="submit" class="btn btn-success">Update Student</button>
    <a href="students.php" class="btn btn-danger">Cancel</a>
</form>

<?php require 'footer.php'; ?>
