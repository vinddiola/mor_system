<?php
require 'config.php';
require 'header.php';
$items = $pdo->query("SELECT * FROM inventory ORDER BY id DESC")->fetchAll();
?>
<div class="d-flex justify-content-between align-items-center mb-3" style="margin-left: 280px; max-width: calc(100% - 280px);">
  <h2>Inventory</h2>
  <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addItemModal">Add Item</a>
</div>

<table class="table table-striped" style="margin-left: 280px; max-width: calc(100% - 280px);">
  <thead><tr><th>#</th><th>Item Code</th><th>Name</th><th>Qty</th><th>Condition</th></tr></thead>
  <tbody>
    <?php foreach($items as $it): ?>
      <tr>
        <td><?= $it['id'] ?></td>
        <td><?= htmlspecialchars($it['item_code']) ?></td>
        <td><?= htmlspecialchars($it['name']) ?></td>
        <td><?= $it['quantity'] ?></td>
        <td><?= $it['condition'] ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<!-- Modal for Add Item (simple) -->
<div class="modal fade" id="addItemModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" action="inventory_add.php" class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Add Inventory Item</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <div class="mb-3"><label>Item Code</label><input name="item_code" class="form-control" required></div>
        <div class="mb-3"><label>Name</label><input name="name" class="form-control" required></div>
        <div class="mb-3"><label>Quantity</label><input type="number" name="quantity" class="form-control" value="1"></div>
        <div class="mb-3"><label>Condition</label>
          <select name="condition" class="form-control">
            <option>Good</option><option>Poor</option><option>Needs Replacement</option>
          </select>
        </div>
      </div>
      <div class="modal-footer"><button class="btn btn-primary">Add</button><button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button></div>
    </form>
  </div>
</div>

<?php require 'footer.php'; ?>