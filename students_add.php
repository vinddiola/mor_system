<?php
require 'header.php'; 

echo <<<HTML
<!DOCTYPE html>
<html>
<body>
  <link rel="stylesheet" href="style.css">

<div class="form-card" style="margin-left: 280px; max-width: calc(100% - 280px);">

    <div class="form-card-header">Add Student</div>

    <div class="form-card-body" >
        <form action="students_save.php" method="post" enctype="multipart/form-data">

            <label class="form-label">Student No</label>
            <input name="student_no" class="form-control" required>

            <div class="row" >
                <div class="col">
                    <label class="form-label">First Name</label>
                    <input name="first_name" class="form-control" required>
                </div>

                <div class="col" >
                    <label class="form-label">Last Name</label>
                    <input name="last_name" class="form-control" required>
                </div>
            </div>

            <label class="form-label">Student Photo</label>
            <input type="file" name="profile_image" class="form-control" accept="image/*">

            <label class="form-label">Grade Level</label>
            <textarea name="immunizations" class="form-control"></textarea>

            <label class="form-label">Contact</label>
            <input name="contact" class="form-control">

            <label class="form-label">Address</label>
            <input name="address" class="form-control">

            <h5>Medical Information</h5>

            <label class="form-label">Allergies</label>
            <textarea name="allergies" class="form-control"></textarea>

            <label class="form-label">Contact of Guardian/Parent</label>
            <textarea name="guardian_contact" class="form-control"></textarea>

            <label class="form-label">If condition triggered - What to do?</label>
            <textarea name="emergency_action" class="form-control"></textarea>

            <button type="submit" class="btn btn-save">Save Student</button>
            <a href="students.php" class="btn btn-cancel">Cancel</a>

        </form>
    </div>
</div>

</body>
</html>
HTML;
?>
