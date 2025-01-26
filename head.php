<?php include 'header.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
<header id="header" class="header fixed-top mb-3">

    <div class="topbar d-flex align-items-center">
        <div class="container d-flex justify-content-center justify-content-md-between">
            <div class="contact-info d-flex align-items-center">
                <i class="bi bi-envelope d-flex align-items-center"><a
                        href="mailto:kapcsolat@tankonyvrendeles.hu">kapcsolat@tankonyvrendeles.hu</a></i>
                <i class="bi bi-phone d-flex align-items-center ms-4"><span>+3612345678 </span></i>
            </div>

        </div>
    </div>
    <div class="branding d-flex align-items-cente">

        <div class="container position-relative d-flex align-items-center justify-content-between">
            <a href="index.php" class="logo d-flex align-items-center">
                <h1 class="sitename">Tankönyrendelés</h1>
                <span>.</span>
            </a>
            <!-- Oldalak nevei és azonosítói -->
            <?php include 'menubar.php'; ?>
        </div>
    </div>
</header>