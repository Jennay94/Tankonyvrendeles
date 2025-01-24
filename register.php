<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

<body>
  <div id="register" class="py-5">
    <div class="container">
      <div id="register-row" class="row justify-content-center align-items-center">
        <div id="register-column" class="col-lg-8 col-md-10 col-sm-12">
          <div id="register-box" class="col-12 p-5 border rounded bg-light shadow-lg">
            <form id="register-form" class="form" action="registration_admin.php" method="post">
              <h3 class="text-center text-info display-4">Tanár fiók regisztráció</h3>
              <div class="form-group row">
                <div class="col-md-6">
                  <label for="last_name" class="text-info h5">Vezetéknév:</label>
                  <input required type="text" name="last_name" id="last_name" class="form-control form-control-xl"
                    style="font-size: 1.5rem; padding: 1rem;" />
                </div>
                <div class="col-md-6">
                  <label for="first_name" class="text-info h5">Keresztnév:</label>
                  <input required type="text" name="first_name" id="first_name" class="form-control form-control-xl"
                    style="font-size: 1.5rem; padding: 1rem;" />
                </div>
              </div>
              <div class="form-group">
                <label for="email" class="text-info h5">Email cím:</label><br />
                <input required type="email" name="email" id="email" class="form-control form-control-xl"
                  style="font-size: 1.5rem; padding: 1rem;" />
              </div>
              <div class="form-group">
                <label for="user_name" class="text-info h5">Felhasználónév:</label><br />
                <input required type="text" name="user_name" id="user_name" class="form-control form-control-xl"
                  style="font-size: 1.5rem; padding: 1rem;" />
              </div>
              <div class="form-group">
                <label for="password" class="text-info h5">Jelszó:</label><br />
                <input required type="password" name="password" id="password" class="form-control form-control-xl"
                  style="font-size: 1.5rem; padding: 1rem;" />
              </div>
              <div class="form-group">
                <label for="remember-me" class="text-info h5"><span>Emlékezz rám</span><span><input id="remember-me"
                      name="remember-me" type="checkbox" style="transform: scale(1.5);" /></span></label><br />
                <input type="submit" name="submit" class="btn btn-info btn-lg btn-block"
                  style="font-size: 1.5rem; padding: 1rem;" value="Regisztráció" />
              </div>
              <div id="register-link" class="text-right">
                <a href="login.php" class="text-info h5">Van már fiókod? Bejelentkezés</a>
              </div>
            </form>
            <div class="text-center mt-5">
              <a href="index.php" class="btn btn-primary btn-lg" style="font-size: 1.5rem; padding: 1rem;">Vissza a
                főoldalra</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="responseModal" tabindex="-1" role="dialog" aria-labelledby="responseModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="responseModalLabel">Regisztráció</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modalMessage">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Bezárás</button>
        </div>
      </div>
    </div>
  </div>

  <script>

    $(document).ready(function () {
      const message = "<?php echo isset($message) ? $message : ''; ?>";
      if (message) {
        $("#modalMessage").text(message);
        $('#responseModal').modal('show');
      }
    });
  </script>
</body>