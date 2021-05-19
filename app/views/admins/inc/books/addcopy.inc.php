<div class="card text-center card-borrower">
  <div class="card-header">
  <?= $language['books_add_header'] ?> <strong><?= $data['title'] ?? '' ?></strong> <?= $language['book'] ?> :
  </div>
  <div class="card-body">
    <form method="POST">
      <div class="row mb-3">
        <label for="inv" class="col-sm-2 col-form-label"><?= $language['inventory_number'] ?></label>
        <div class="col-sm-10">
          <input type="text" name="inv" class="form-control" id="inv" value="<?= $data['inv'] ?? '' ?>">
        </div>
      </div>
      <button type="submit" class="btn btn-outline-primary"><?= $language['btn_add'] ?></button>
    </form>
  </div>
</div>