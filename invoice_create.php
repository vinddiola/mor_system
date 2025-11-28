<?php
require 'config.php';
require 'header.php';


function generate_invoice_no($pdo) {
    
    $today = date('Y-m-d');
    $datePart = date('Ymd');
   
    $stmt = $pdo->prepare("SELECT COUNT(*) AS c FROM invoices WHERE invoice_date = ?");
    $stmt->execute([$today]);
    $count = $stmt->fetchColumn();
    $seq = $count + 1;
    return 'INV' . $datePart . str_pad($seq, 4, '0', STR_PAD_LEFT);
}

$students = $pdo->query("SELECT id, student_no, first_name, last_name FROM students ORDER BY first_name")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $invno = $_POST['invoice_no'];
    $pdo->prepare("INSERT INTO invoices (invoice_no, student_id, invoice_date, amount, status) VALUES (?,?,?,?,?)")
        ->execute([$invno, $_POST['student_id'] ?: null, $_POST['invoice_date'], $_POST['amount'], 'Unpaid']);
    header("Location: invoices.php");
    exit;
}

$invoice_no = generate_invoice_no($pdo);
?>
<h2>Create Invoice</h2>
<form method="post">
  <div class="mb-3" style="margin-left: 280px; max-width: calc(100% - 280px);">
    <label>Invoice No</label>
    <input name="invoice_no" class="form-control" value="<?=htmlspecialchars($invoice_no)?>" readonly>
  </div>
  <div class="mb-3"style="margin-left: 280px; max-width: calc(100% - 280px);">
    <label>Student (optional)</label>
    <select name="student_id" class="form-control">
      <option value="">-- Unassigned --</option>
      <?php foreach($students as $s): ?>
        <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['student_no'].' - '.$s['first_name'].' '.$s['last_name'])?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3"style="margin-left: 280px; max-width: calc(100% - 280px);">
    <label>Invoice Date</label>
    <input type="date" name="invoice_date" class="form-control" value="<?=date('Y-m-d')?>">
  </div>
  <div class="mb-3"style="margin-left: 280px; max-width: calc(100% - 280px);">
    <label>Amount</label>
    <input type="number" step="0.01" name="amount" class="form-control" required>
  </div>
  <button class="btn btn-primary">Create</button>
  <a href="invoices.php" class="btn btn-secondary">Cancel</a>
</form>
<?php require 'footer.php'; ?>