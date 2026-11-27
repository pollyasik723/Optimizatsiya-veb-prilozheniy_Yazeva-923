<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$favoriteIds = [];
if (isCustomerLoggedIn()) {
    $favs = DB::fetchAll("SELECT product_id FROM favorites WHERE customer_id = ?", [getCustomerId()]);
    $favoriteIds = array_column($favs, 'product_id');
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>О нас — Хлебный домик</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="container">
            <div class="header-inner">
                <h1 class="site-logo"><a href="index.php" style="color:inherit;text-decoration:none">🍞 Хлебный домик</a></h1>
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

    <section class="page-hero about-hero">
        <div class="container">
            <h2>О нас</h2>
            <p>История, традиции и любовь к хлебопечению</p>
        </div>
    </section>

    <section class="about-section">
        <div class="container">
            <div class="about-grid">
                <div class="about-text">
                    <h2>Наша история</h2>
                    <p>Всё началось в 2015 году с маленькой домашней пекарни на окраине города. Основатель «Хлебного домика», Иван Петров, увлёкся выпечкой хлеба на закваске ещё в студенческие годы. Друзья и соседи первыми оценили его бородинский и ржаной хлеб — и стали просить испечь ещё.</p>
                    <p>К 2017 году стало ясно: домашняя печь не справляется с объёмом заказов. Так появилась наша первая профессиональная пекарня. Сегодня «Хлебный домик» — это уютное производство с собственным цехом, бережными рецептами и командой пекарей, которые встают затемно, чтобы к утру на полках лежала свежая выпечка.</p>
                    <p>Мы печём по классическим технологиям, без разрыхлителей и улучшителей. Наш хлеб живёт — он дышит, у него хрустящая корочка и мякиш, который не крошится. Мы сами выбираем муку, сами готовим закваски, сами лепим пирожки. Каждая партия — результат ручного труда и многолетнего опыта.</p>
                </div>
                <div class="about-image">
                    <span class="about-emoji">🥖</span>
                </div>
            </div>

            <div class="values">
                <h2>Наши ценности</h2>
                <div class="values-grid">
                    <div class="value-card">
                        <span class="value-icon">🌾</span>
                        <h3>Натуральные ингредиенты</h3>
                        <p>Только мука высшего сорта, сливочное масло, свежие яйца и никаких консервантов.</p>
                    </div>
                    <div class="value-card">
                        <span class="value-icon">👨‍🍳</span>
                        <h3>Ручная работа</h3>
                        <p>Каждое изделие формуется вручную. Мы не используем конвейер — только тепло рук наших пекарей.</p>
                    </div>
                    <div class="value-card">
                        <span class="value-icon">🚚</span>
                        <h3>Свежесть каждый день</h3>
                        <p>Печём каждое утро. Хлеб, который не был продан за день, не попадает на полку на следующий.</p>
                    </div>
                    <div class="value-card">
                        <span class="value-icon">❤️</span>
                        <h3>Забота о людях</h3>
                        <p>Мы поддерживаем местных фермеров и отдаём часть выпечки в благотворительные столовые.</p>
                    </div>
                </div>
            </div>

            <div class="team">
                <h2>Команда</h2>
                <div class="team-grid">
                    <div class="team-card">
                        <div class="team-photo">👨‍🍳</div>
                        <h3>Иван Петров</h3>
                        <p class="team-role">Основатель и главный технолог</p>
                        <p>Стоял у истоков, разрабатывает рецептуры и учит новичков.</p>
                    </div>
                    <div class="team-card">
                        <div class="team-photo">👩‍🍳</div>
                        <h3>Елена Смирнова</h3>
                        <p class="team-role">Шеф-пекарь</p>
                        <p>Отвечает за производство, следит за качеством каждой партии.</p>
                    </div>
                    <div class="team-card">
                        <div class="team-photo">🧁</div>
                        <h3>Дарья Волкова</h3>
                        <p class="team-role">Кондитер</p>
                        <p>Создаёт десерты: чизкейки, эклеры, корзиночки с нежным кремом.</p>
                    </div>
                </div>
            </div>

            <div class="contacts">
                <h2>Контакты</h2>
                <div class="contacts-grid">
                    <div class="contact-item">
                        <span class="contact-icon">📍</span>
                        <div>
                            <strong>Адрес</strong>
                            <p>г. Санкт-Петербург, ул. Пекарей, д. 15</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <span class="contact-icon">📞</span>
                        <div>
                            <strong>Телефон</strong>
                            <p>+7 (999) 123-45-67</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <span class="contact-icon">✉️</span>
                        <div>
                            <strong>Email</strong>
                            <p>info@hlebny-domik.ru</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <span class="contact-icon">🕐</span>
                        <div>
                            <strong>Режим работы</strong>
                            <p>Пн–Сб: 8:00 – 20:00<br>Вс: 9:00 – 18:00</p>
                        </div>
                    </div>
                </div>
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
                    <input type="tel" name="customer_phone" required pattern="[\d\s\+\-\(\)]{7,20}" title="От 7 до 20 цифр, можно +, -, пробелы, скобки">
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

    <!-- Модальное окно авторизации -->
    <div id="authModal" class="modal" style="display:none">
        <div class="modal-content" style="max-width:400px">
            <span class="modal-close" onclick="closeAuth()">&times;</span>
            <div id="authFormContainer"></div>
        </div>
    </div>

    <footer class="site-footer">
        <div class="container">
            <p>© 2026 Хлебный домик. Все права защищены.</p>
        </div>
    </footer>

    <script src="order_handler.js"></script>
    <script src="assets/js/auth.js"></script>
</body>
</html>
