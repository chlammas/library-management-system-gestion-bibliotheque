<?php require_once APPROOT . '/views/inc/header.php'; ?>
<div class="carsd login-caard">
  <div class="row no-gutters">
    <div class="col-md-6">
      <img src="<?php echo URLROOT ?>/img/library.jpg" alt="login" class="login-card-img">
      
    </div>
    <div class="col-md-6">
      
      <div class="card-body card-body-login card-borrower">
        <p class="login-card-description">Use your library card's code to sign into your account</p>

        <form action="<?php echo URLROOT . ($data['type'] === 'admin' ? '/admins/login' : '/borrowers/login')?>" method="POST" class="row g-3">
          <div class="form-group">
            <input type="text" required name="barcode" placeholder="Enter your card code..." class="form-control form-control-lg <?php echo (!empty($data['barcode_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['barcode']; ?>">
            <span class="invalid-feedback"><?php echo $data['barcode_err']; ?></span>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-outline-primary  mb-3">Login</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>