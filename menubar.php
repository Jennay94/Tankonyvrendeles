<?php
// Adatbázis kapcsolat betöltése
include('db.php');


// Felhasználó rangjának lekérdezése (alapértelmezett 101 - vendég)
$userRang = isset($_SESSION['user_rang']) ? $_SESSION['user_rang'] : 101;

// Menüelemek lekérdezése rang alapján
$query = "SELECT * FROM pages WHERE rang <= :userRang ORDER BY parent_id, id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':userRang', $userRang, PDO::PARAM_INT);
$stmt->execute();
$menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Rekurzív menüépítő függvény
function renderMenu($menuItems, $parentId = null)
{
    $html = '';

    foreach ($menuItems as $item) {
        if ($item['parent_id'] == $parentId) {
            // Ellenőrizzük, van-e gyermek elem
            $children = renderMenu($menuItems, $item['id']);

            // Menüelem hozzáadása
            if ($children) {
                // Ha van gyermek, dropdown menü
                $html .= '<li class="dropdown">';
                $html .= '<a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><span>' . htmlspecialchars($item['name']) . '</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>';
                $html .= '<ul class="dropdown-menu">' . $children . '</ul>';
                $html .= '</li>';
            } else {
                // Ha nincs gyermek, sima link
                $html .= '<li><a href="' . $item['url'] . '">' . htmlspecialchars($item['name']) . '</a></li>';
            }
        }
    }

    return $html;
}
?>

<body>
    <nav id="navmenu" class="navmenu">
        <ul>
            <?= renderMenu($menuItems); ?>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>

    <!-- Bootstrap JS és Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>