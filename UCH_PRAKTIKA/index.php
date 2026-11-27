<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$products = DB::fetchAll(
    "SELECT p.*, (i.quantity - i.reserved) AS available
     FROM products p
     LEFT JOIN inventory i ON i.product_id = p.id
     WHERE (i.quantity - i.reserved) > 0
     ORDER BY p.category, p.name"
);
$categories = DB::fetchAll(
    "SELECT DISTINCT p.category FROM products p
     LEFT JOIN inventory i ON i.product_id = p.id
     WHERE (i.quantity - i.reserved) > 0 AND p.category IS NOT NULL
     ORDER BY p.category"
);

$favoriteIds = [];
if (isCustomerLoggedIn()) {
    $favs = DB::fetchAll("SELECT product_id FROM favorites WHERE customer_id = ?", [getCustomerId()]);
    $favoriteIds = array_column($favs, 'product_id');
}

$emojiMap = ['Хлеб' => '🍞', 'Выпечка' => '🥐', 'Пирожки' => '🥟', 'Десерты' => '🍰'];
echo "<script>console.log('Пик памяти PHP (Джино): " . round(memory_get_peak_usage() / 1024 / 1024, 2) . " МБ');</script>";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Хлебный домик — свежая выпечка</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function(m,e,t,r,i,k,a){
        m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();
        for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
        k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)
    })(window, document,'script','https://mc.yandex.ru/metrika/tag.js?id=114394414', 'ym');

    ym(114394414, 'init', {ssr:true, webvisor:true, clickmap:true, ecommerce:"dataLayer", referrer: document.referrer, url: location.href, accurateTrackBounce:true, trackLinks:true});
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/114394414" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</head>
<body>
    <header class="site-header">
        <div class="container">
            <div class="header-inner">
                <h1 class="site-logo">🍞 Хлебный домик</h1>
                <nav>
                    <a href="about.php">О нас</a>
                    <a href="article.php">Блог</a>
                    <span id="authLinks">
                        <?php if (isCustomerLoggedIn()): ?>
                            <a href="cabinet.php">Личный кабинет</a>
                            <a href="favorites.php">Избранное</a>
                            <a href="javascript:void(0)" onclick="logout()">Выйти</a>
                        <?php else: ?>
                            <a href="javascript:void(0)" onclick="showAuth('login')">Вход</a>
                            <a href="javascript:void(0)" onclick="showAuth('register')">Регистрация</a>
                        <?php endif; ?>
                    </span>
                    <a href="javascript:void(0)" id="cartBtn" onclick="toggleCart()">Корзина (<span id="cartCount">0</span>)</a>
                </nav>
            </div>
        </div>
    </header>

    <section class="hero">
        <div class="container">
            <h2>Свежая выпечка каждый день</h2>
            <p>Натуральные ингредиенты, ручная работа, тепло домашнего очага</p>
        </div>
    </section>

    <section id="catalog" class="catalog">
        <div class="container">
            <h2>Каталог</h2>

            <?php if (!empty($categories)): ?>
                <div class="category-filters">
                    <button class="filter-btn active" data-category="all">Всё</button>
                    <?php foreach ($categories as $cat): ?>
                        <button class="filter-btn" data-category="<?= htmlspecialchars($cat['category']) ?>">
                            <?= htmlspecialchars($cat['category']) ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="products-grid" id="productsGrid">
                <?php foreach ($products as $p):
                    $isFav = in_array($p['id'], $favoriteIds);
                ?>
                    <div class="product-card" data-category="<?= htmlspecialchars($p['category'] ?? '') ?>">
                        <div class="product-image">
                            <?php if (!empty($p['image']) && strpos($p['image'], 'unsplash') === false): ?>
                                <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" loading="lazy">
                            <?php else: ?>
                                <span class="emoji"><?= $emojiMap[$p['category']] ?? '🥖' ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="product-info">
                            <h3><?= htmlspecialchars($p['name']) ?></h3>
                            <p class="product-desc"><?= htmlspecialchars($p['description']) ?></p>
                            <div class="product-bottom">
                                <span class="product-price"><?= number_format($p['price'], 2) ?> ₽</span>
                                <button class="btn-add" onclick="addToCart(<?= $p['id'] ?>, '<?= htmlspecialchars(addslashes($p['name'])) ?>', <?= $p['price'] ?>)">В корзину</button>
                            </div>
                            <div class="product-fav">
                                <button class="btn-fav <?= $isFav ? 'active' : '' ?>" onclick="toggleFav(<?= $p['id'] ?>, this)" title="В избранное">♥</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Корзина -->
    <div id="cartModal" class="modal" style="display:none">
        <div class="modal-content">
            <span class="modal-close" onclick="toggleCart()">&times;</span>
            <h2>Корзина</h2>
            <div id="cartItems"></div>
            <div id="cartTotal" class="cart-total"></div>
            <button class="btn btn-primary w-100 mt-2" onclick="checkout()" id="checkoutBtn" style="display:none">Оформить заказ</button>
        </div>
    </div>

    <!-- Форма оформления -->
    <div id="checkoutModal" class="modal" style="display:none">
        <div class="modal-content" style="max-width:500px">
            <span class="modal-close" onclick="closeCheckout()">&times;</span>
            <h2>Оформление заказа</h2>
            <form id="orderForm" onsubmit="submitOrder(event)">
                <div class="form-group">
                    <label>Имя *</label>
                    <input type="text" name="customer_name" required>
                    <div class="error-text"></div>
                </div>
<div class="form-group">
    <label>Телефон *</label>
    <input type="tel" name="customer_phone" required pattern="(7|8)\d{10}" title="11 цифр, начинается с 7 или 8">
    <div class="error-text"></div>
</div>
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="customer_email" required pattern="[^\s@]+@[^\s@]+\.[^\s@]+" title="Введите корректный email (например, user@example.com)">
                    <div class="error-text"></div>
                </div>
                <div class="form-group">
                    <label>Адрес доставки *</label>
                    <input type="text" name="delivery_address" required>
                    <div class="error-text"></div>
                </div>
                <div class="form-group">
                    <label>Дата доставки *</label>
                    <input type="date" name="delivery_date" required>
                    <div class="error-text"></div>
                </div>
                <div class="form-group">
                    <label>Комментарий</label>
                    <textarea name="comment" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Отправить заказ</button>
            </form>
        </div>
    </div>

    <footer class="site-footer">
        <div class="container">
            <p>© 2026 Хлебный домик. Все права защищены.</p>
        </div>
    </footer>

    <!-- Модальное окно авторизации -->
    <div id="authModal" class="modal" style="display:none">
        <div class="modal-content" style="max-width:400px">
            <span class="modal-close" onclick="closeAuth()">&times;</span>
            <div id="authFormContainer"></div>
        </div>
    </div>

    <script src="order_handler.js"></script>
    <script src="assets/js/auth.js"></script>
</body>
</html>
