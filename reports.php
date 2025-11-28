<?php
require 'config.php';
require 'header.php';
$totalIncome = $pdo->query("SELECT IFNULL(SUM(amount),0) FROM reports WHERE type='Income'")->fetchColumn();
$totalExpense = $pdo->query("SELECT IFNULL(SUM(amount),0) FROM reports WHERE type='Expense'")->fetchColumn();
$balance = $totalIncome - $totalExpense;
?>
<h2>Finance Summary</h2>
<div class="row" style="margin-left: 280px; max-width: calc(100% - 280px);">
  <div class="col-md-4"><div class="card p-3"><h5>Income</h5><p class="lead"><?=number_format($totalIncome,2)?></p></div></div>
  <div class="col-md-4"><div class="card p-3"><h5>Expense</h5><p class="lead"><?=number_format($totalExpense,2)?></p></div></div>
  <div class="col-md-4"><div class="card p-3"><h5>Net</h5><p class="lead"><?=number_format($balance,2)?></p></div></div>
</div>
<hr>
<h4>Recent Finance Entries</h4>
<table class="table table-sm" style="margin-left: 280px; max-width: calc(100% - 280px);">
  <thead><tr><th>Date</th><th>Type</th><th>Category</th><th>Amount</th><th>Description</th></tr></thead>
  <tbody>
  <?php
    $stmt = $pdo->query("SELECT * FROM reports ORDER BY entry_date DESC LIMIT 20");
    foreach($stmt->fetchAll() as $f){
      echo "<tr><td>{$f['entry_date']}</td><td>{$f['type']}</td><td>".htmlspecialchars($f['category'])."</td><td>".number_format($f['amount'],2)."</td><td>".htmlspecialchars($f['description'])."</td></tr>";
    }
  ?>
  </tbody>
</table>
<?php require 'footer.php'; ?>