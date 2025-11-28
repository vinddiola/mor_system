<?php
require 'config.php';
require 'header.php';
$rows = $pdo->query("SELECT p.*, e.first_name, e.last_name FROM payrolls p JOIN employees e ON p.employee_id = e.id ORDER BY p.id DESC")->fetchAll();
?>
<div class="d-flex justify-content-between align-items-center mb-3" style="margin-left: 280px; max-width: calc(100% - 280px);">
  <h2>Payroll</h2>
  <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPayrollModal">Add Payroll</a>
</div>

<table class="table table-bordered" style="margin-left: 280px; max-width: calc(100% - 280px);">
  <thead><tr><th>#</th><th>Employee</th><th>Period</th><th>Gross</th><th>Deductions</th><th>Net</th></tr></thead>
  <tbody>
    <?php foreach($rows as $r): ?>
      <tr>
        <td><?=$r['id']?></td>
        <td><?=htmlspecialchars($r['first_name'].' '.$r['last_name'])?></td>
        <td><?=htmlspecialchars($r['pay_period_start'].' to '.$r['pay_period_end'])?></td>
        <td><?=number_format($r['gross_amount'],2)?></td>
        <td><?=number_format($r['deductions'],2)?></td>
        <td><?=number_format($r['net_amount'],2)?></td>
      </tr>
    <?php endforeach;?>
  </tbody>
</table>

<?php require 'footer.php'; ?>
