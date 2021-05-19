<div class="card text-center card-borrower">
  <div class="card-header">
  <?=isset($data['edit_book']) ? 'Update the <b>' . $data['title'] . '</b> book' ?? '' : 'Add a new book' ?>
  </div>
  <div class="card-body">
    <form method="POST">
      <div class="row mb-3">
        <label for="isbn" class="col-sm-2 col-form-label"><?= $language['table_isbn'] ?></label>
        <div class="col-sm-10">
          <input type="text" name="isbn" class="form-control" id="isbn" value="<?= $data['isbn'] ?? '' ?>">
        </div>
      </div>
      <div class="row mb-3">
        <label for="title" class="col-sm-2 col-form-label"><?= $language['table_title'] ?></label>
        <div class="col-sm-10">
          <input type="text" name="title" class="form-control" id="title" value="<?= $data['title'] ?? '' ?>">
        </div>
      </div>
      <div class="row mb-3">
        <label for="type" class="col-sm-2 col-form-label"><?= $language['table_type'] ?></label>
        <div class="col-sm-10">
          <input type="text" name="type" class="form-control" id="type" value="<?= $data['type'] ?? '' ?>">
        </div>
      </div>
      <div class="row mb-3">
        <label for="category" class="col-sm-2 col-form-label"><?= $language['table_category'] ?></label>
        <div class="col-sm-10">
          <input type="text" name="category" class="form-control" id="category" value="<?= $data['category'] ?? '' ?>">
        </div>
      </div>
      <div class="row mb-3">
        <label for="edition" class="col-sm-2 col-form-label"><?= $language['table_edition'] ?></label>
        <div class="col-sm-10">
          <input type="text" name="edition" class="form-control" id="edition" value="<?= $data['edition'] ?? '' ?>">
        </div>
      </div>
      <div class="row mb-3">
        <label for="rack" class="col-sm-2 col-form-label"><?= $language['table_rack'] ?></label>
        <div class="col-sm-10">
          <input type="text" name="rack" class="form-control" id="rack" value="<?= $data['rack'] ?? '' ?>">
        </div>
      </div>
      <div class="row mb-3">
        <label for="author" class="col-sm-2 col-form-label"><?= $language['table_author'] ?></label>
        <div class="col-sm-10">
          <input type="text" name="author" class="form-control" id="author" value="<?= $data['author'] ?? '' ?>">
        </div>
      </div>

      <button type="submit" class="btn btn-outline-primary"><?=isset($data['add_book']) ? $language['btn_add'] : $language['btn_update'] ?></button>
    </form>
  </div>
</div>