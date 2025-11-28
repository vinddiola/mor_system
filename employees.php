<?php
require 'config.php';
require 'header.php';
$emps = $pdo->query("SELECT * FROM employees ORDER BY id DESC")->fetchAll();
?>
<div class="d-flex justify-content-between align-items-center mb-3" style="margin-left: 280px; max-width: calc(100% - 280px);">
  <h2>Employee Management</h2>
</div>
<table class="table table-bordered" style="margin-left: 280px; max-width: calc(100% - 280px);">
  <thead><tr><th>#</th><th>Employee No.</th><th>Name</th><th>Position</th><th>Contact</th></tr></thead>
  <tbody>
    <?php foreach($emps as $e): ?>
      <tr>
        <td><?= $e['id'] ?></td>
        <td><?= htmlspecialchars($e['emp_no']) ?></td>
        <td><?= htmlspecialchars($e['first_name'].' '.$e['last_name']) ?></td>
        <td><?= htmlspecialchars($e['position']) ?></td>
        <td><?= htmlspecialchars($e['contact']) ?></td>
      </tr>
    <?php endforeach;?>
  </tbody>
</table>
<?php require 'footer.php'; ?>