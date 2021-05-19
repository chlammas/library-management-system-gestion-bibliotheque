<?php require_once APPROOT . '/views/inc/header.php'; ?>
<div class="carsd login-caard">
  <div class="row no-gutters">
    <div class="col-md-6">
      <img src="<?php echo URLROOT ?>/img/<?=$data['type'] === 'admin' ? 'admin-login' : 'library' ?>.jpg" alt="login" class="login-card-img">

    </div>
    <div class="col-md-6">

      <div class="card-body card-body-login card-borrower">
        <p class="login-card-description"><?=$language['login_card_description']?></p>

        <form action="<?php echo URLROOT . ($data['type'] === 'admin' ? '/admins/login' : '/borrowers/login') ?>" method="POST" class="row g-3">
          <div class="form-group">
            <input type="text" required name="barcode" placeholder="<?=$language['login_placeholder']?>" class="form-control form-control-lg <?php echo (!empty($data['barcode_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['barcode']; ?>">
            <span class="invalid-feedback"><?php echo $data['barcode_err']; ?></span>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-outline-primary  mb-3"><?=$language['btn_login']?></button>
          </div>
        </form>

      </div>

      <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary btn-type-login hidden" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
      </button>

      <!-- Modal -->
      <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel"><?=$language['login_as']?></h5>
            </div>
            <div class="modal-body">
            <?=$language['login_as_msg']?>
            </div>
            <div class="modal-footer">
              <a href="<?= URLROOT . '/borrower' ?>" class="btn btn-outline-primary"><?=$language['login_as_btn_borrower']?> <i class="fas fa-user"></i></a>
              <a href="<?= URLROOT . '/admin' ?>" class="btn btn-outline-primary"><?=$language['login_as_btn_admin']?> <i class="fas fa-user-cog"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>
<script>
  <?php if ($data['type'] !== 'borrower' && $data['type'] !== 'admin') : ?>
    window.onload = () => document.querySelector('.btn-type-login').click()
  <?php endif ?>
</script>