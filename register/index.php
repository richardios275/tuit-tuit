<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register | Tuit Tuit</title>
  <link rel="stylesheet" href="../public/css/tuituit.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="d-flex justify-content-center align-items-center py-4">
  <main class="tuittuit-bg mb-2">
    <form action="../actions/register_action.php" method="post" class="mx-4">
      <div class="pb-5">
        <h1 class="tuittuit-title">
          tuit tuit</h1>
      </div>
      <h1>Create your account</h1>
      <?php
      if (isset($_SESSION["regist_errors"])) {
        $errormessage = "";
        for ($i = 0; $i < count($_SESSION["regist_errors"]); $i++ ) {
          $errormessage .= $_SESSION["regist_errors"][$i] ."; ";
        }
        echo "<div class=\"alert alert-danger text-wrap\" role=\"alert\">". "An error occured: " . $errormessage ."</div>";
        unset($_SESSION['regist_errors']);
      }
      ?>

      <div class="form-floating mb-2">
        <input type="text" class="form-control" id="usernameInput" name="username" placeholder="johnsmith7" required>
        <label for="usernameInput" class="form-label">Username</label>
      </div>
      <div class="form-floating mb-2">
        <input type="password" class="form-control" id="passwordInput" name="password" placeholder="Password" required>
        <label for="passwordInput" class="form-label">Password</label>
      </div>
      <div class="mb-4">
        <label>Date of birth (Optional)</label><br>
        <small>We do not store this information at all, this is just for formalities</small>
        <div class="row">
          <div class="col">
            <select name="day" id="daySelect" class="form-select" aria-label="Day">
              <?php for ($i = 1; $i <= 31; $i++) { echo "<option value=\"$i\">$i</option>"; } ?>
            </select>
          </div>
          <div class="col">
            <select name="month" id="monthSelect" class="form-select" aria-label="Month">
              <option value="1">January</option>
              <option value="2">February</option>
              <option value="3">March</option>
              <option value="4">April</option>
              <option value="5">May</option>
              <option value="6">June</option>
              <option value="7">July</option>
              <option value="8">August</option>
              <option value="9">September</option>
              <option value="10">October</option>
              <option value="11">November</option>
              <option value="12">December</option>
            </select>
          </div>
          <div class="col">
            <select name="year" id="yearSelect" class="form-select" aria-label="Year">
              <?php for ($i = 2026; $i > 1900; $i--) { echo "<option value=\"$i\">$i</option>"; } ?>
            </select>
          </div>
        </div>
      </div>
      <div class="mb-2 form-check">
        <input type="checkbox" class="form-check-input" id="agreeCheckBox" required>
        <label class="form-check-label" for="agreeCheckBox">By signing up, you agree to the <a target="_blank" href="#"
            data-bs-toggle="modal" data-bs-target="#termsModal">Terms of Service</a> and <a target="_blank" href="#"
            data-bs-toggle="modal" data-bs-target="#privacyModal">Privacy Policy</a></label>
      </div>
      <button id="submitButton" type="submit" class="btn btn-primary w-100 py-2 mb-4" disabled>Register</button>
      <div class="d-flex justify-content-center">
        <div>
          Already have an account? <a href="../login">Login</a>
        </div>
      </div>
    </form>
  </main>
  <div id="termsModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Terms of Service</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <?php include '../includes/tos.php' ?>
        </div>
      </div>
    </div>
  </div>
  <div id="privacyModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Privacy Policy</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <?php include '../includes/privacy.php' ?>
        </div>
      </div>
    </div>
  </div>


  <script src="register.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
</body>

</html>