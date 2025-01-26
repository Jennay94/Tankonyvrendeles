<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<body>
    <div id="login" class="py-5">
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-lg-8 col-md-10 col-sm-12">
                    <div id="login-box" class="col-12 p-5 border rounded bg-light shadow-lg">
                        <form id="login-form" class="form" action="login_action.php" method="post">
                            <h3 class="text-center text-info display-4">Bejelentkezés</h3>
                            <div class="form-group">
                                <label for="username" class="text-info h5">Felhasználónév:</label><br>
                                <input type="text" name="username" id="username" class="form-control form-control-xl"
                                    style="font-size: 1.5rem; padding: 1rem;">
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info h5">Jelszó:</label><br>
                                <input type="password" name="password" id="password"
                                    class="form-control form-control-xl" style="font-size: 1.5rem; padding: 1rem;">
                            </div>
                            <div class="form-group">
                                <label for="remember-me" class="text-info h5"><span>Emlékezz rám</span> <span><input
                                            id="remember-me" name="remember-me" type="checkbox"
                                            style="transform: scale(1.5);"></span></label><br>
                                <input type="submit" name="submit" class="btn btn-info btn-lg btn-block"
                                    style="font-size: 1.5rem; padding: 1rem;" value="Bejelentkezés">
                            </div>
                            <div id="register-link" class="text-right">
                                <a href="register.php" class="text-info h5">Regisztrálj itt</a>
                            </div>
                        </form>
                        <div class="text-center mt-5">
                            <a href="index.php" class="btn btn-primary btn-lg"
                                style="font-size: 1.5rem; padding: 1rem;">Vissza a főoldalra</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>