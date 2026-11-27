<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корпусные десерты заказать с доставкой в СПб | Хлебный домик</title>
    <meta name="description" content="Узнайте, что такое корпусные десерты и почему они украсят любой праздник. Свежие песочные корзиночки, тарты и чизкейки на заказ в СПб от пекарни «Хлебный домик».">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .article-section {
            flex: 1;
            padding: 3rem 0;
        }
        .article-card {
            max-width: 860px;
            margin: 0 auto;
            background: #fff;
            border-radius: 12px;
            padding: 2.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .article-card h2 {
            font-size: 1.5rem;
            color: #5d4037;
            margin-top: 2rem;
            margin-bottom: 0.8rem;
        }
        .article-card h2:first-of-type {
            margin-top: 1.5rem;
        }
        .article-card h3 {
            font-size: 1.15rem;
            color: #c0392b;
            margin-top: 1.3rem;
            margin-bottom: 0.6rem;
        }
        .article-card p {
            color: #555;
            line-height: 1.7;
            margin-bottom: 1rem;
            font-size: 1rem;
        }
        .article-card ul {
            margin: 1rem 0 1.5rem 1.5rem;
            color: #555;
        }
        .article-card li {
            margin-bottom: 0.6rem;
            line-height: 1.6;
        }
        .article-img {
            width: 100%;
            max-height: 360px;
            object-fit: cover;
            border-radius: 12px;
            margin: 1.2rem 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .article-table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5rem 0;
            font-size: 0.95rem;
        }
        .article-table th,
        .article-table td {
            border: 1px solid #eee;
            padding: 0.85rem 1rem;
            text-align: left;
        }
        .article-table th {
            background: #fdf6f0;
            color: #5d4037;
            font-weight: 600;
        }
        .article-link {
            color: #c0392b;
            font-weight: 600;
            text-decoration: underline;
        }
        .article-link:hover {
            color: #a93226;
        }
        .article-cta {
            background: #fdf6f0;
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 2rem;
            text-align: center;
        }
        .article-cta p {
            margin-bottom: 1rem;
        }
        @media (max-width: 768px) {
            .article-card {
                padding: 1.5rem;
            }
            .article-table {
                font-size: 0.85rem;
            }
        }
    </style>

    <!-- Микроразметка Schema.org типа Article (JSON-LD) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Article",
      "headline": "Корпусные десерты: что это такое и как заказать в Санкт-Петербурге",
      "description": "Узнайте, что такое корпусные десерты и почему они украсят любой праздник. Свежие песочные корзиночки, тарты и чизкейки на заказ в СПб от пекарни «Хлебный домик».",
      "image": [
        "https://unsplash.com",
        "https://unsplash.com"
      ],
      "author": {
        "@type": "Organization",
        "name": "Пекарня «Хлебный домик»"
      },
      "publisher": {
        "@type": "Organization",
        "name": "Пекарня «Хлебный домик»"
      },
      "datePublished": "2026-11-02",
      "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "https://myjino.ru"
      }
    }
    </script>
</head>
<body>
    <header class="site-header">
        <div class="container">
            <div class="header-inner">
                <div class="site-logo"><a href="index.php" style="color:inherit;text-decoration:none;font-weight:700;">🍞 Хлебный домик</a></div>
                <nav>
                    <a href="about.php">О нас</a>
                    <a href="article.php" style="color:#c0392b;">Блог</a>
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

    <section class="page-hero">
        <div class="container">
            <h1 style="font-size: 2rem; color: #5d4037; margin-bottom: 0.5rem;">Корпусные десерты: что это такое и как заказать в Санкт-Петербурге</h1>
            <p>Кондитерский гид от ремесленной пекарни «Хлебный домик»</p>
        </div>
    </section>

    <section class="article-section">
        <div class="container">
            <article class="article-card">
                <p>Организация детского дня рождения, свадьбы или фуршета упирается в выбор сладкого стола. Целый торт сложно разрезать в офисе без крошек, а кремовые бисквиты быстро теряют вид при перевозке. Главными героями фуршетных столов стали корпусные десерты — кондитерский тренд, покоривший гостей аккуратным видом и контрастной текстурой. Разберёмся, как устроены такие сладости, почему они звонко хрустят и как корпусные десерты заказать СПб с доставкой к празднику.</p>

                <img src="assets/img/desser-1.jpeg" alt="Набро корпусных десертов в упаковке" class="article-img" loading="lazy">

                <h2>Что такое корпусные десерты и почему они в тренде</h2>
                <p>Корпусный десерт — порционное пирожное с плотной внешней оболочкой и нежной начинкой внутри. В классических бисквитах слои промазаны кремом, а здесь контраст текстур дарит главный восторг: при укусе тонкая стенка звонко хрустит, а следом раскрывается воздушный мусс или ягодная прослойка. Прочная основа сохраняет геометрию и не даёт сладостям растечься даже через три-четыре часа на праздничном столе.</p>

                <h3>Из чего состоит хрустящая основа и начинка</h3>
                <p>Чтобы добиться звонкого хруста, кондитеры используют песочное тесто сабле, заварное тесто (как в эклерах), вафельные корзинки или слой темперированного шоколада. Внутрь помещают лёгкие муссы, заварной крем, фруктовое пюре, карамель или белковый крем. В пекарне <a href="about.php" class="article-link">«Хлебный домик»</a> такие изделия готовят вручную из сливочного масла и свежих ягод без растительных сливок и заморозки.</p>

                <h2>Почему корпусные пирожные идеально подходят для праздника</h2>
                <p>Порционные изделия в хрустящей оболочке стали хитом для семейных торжеств по пяти причинам:</p>
                <ul>
                    <li><strong>Подача без приборов.</strong> Гостям не нужны тарелки и ножи — корзиночку легко взять руками.</li>
                    <li><strong>Аккуратный вид для фото и праздничного стола.</strong> Ровная геометрия выглядит как витрина авторской кондитерской до конца вечера.</li>
                    <li><strong>Разнообразие вкусов в одном заказе.</strong> Легко собрать набор десертов с доставкой, где каждый выберет любимую начинку: шоколадную, ягодную или сливочную.</li>
                    <li><strong>Точный расчёт порций.</strong> Легко рассчитать нужное количество сладостей по числу гостей (в среднем берут 2–3 штуки на человека).</li>
                    <li><strong>Безопасный состав для детей.</strong> Песочная основа и лёгкий белковый крем подходят для детских праздников.</li>
                </ul>

                <h2>Сравнение корпусных и классических десертов для фуршета</h2>
                <table class="article-table">
                    <thead>
                        <tr>
                            <th>Критерий сравнения</th>
                            <th>Корпусные десерты</th>
                            <th>Классические бисквитные пирожные</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Сочетание текстур</td>
                            <td>Хрустящий корпус и нежная начинка</td>
                            <td>Мягкая однородная структура</td>
                        </tr>
                        <tr>
                            <td>Устойчивость при перевозке</td>
                            <td>Стенки держат геометрию при доставке</td>
                            <td>Крем смазывается о стенки коробки</td>
                        </tr>
                        <tr>
                            <td>Подача на мероприятии</td>
                            <td>Не требует нарезки и приборов</td>
                            <td>Нужны тарелки и вилки</td>
                        </tr>
                        <tr>
                            <td>Вариативность вкусов</td>
                            <td>Легко собрать ассорти в коробке</td>
                            <td>Чаще заказывают 1–2 вида</td>

                        </tr>
                    </tbody>
                </table>
                                <h2>Как выбрать набор десертов с доставкой в СПб</h2>
                <p>Если вы хотите корпусные десерты купить с доставкой для семейного чаепития или офиса, проверьте три параметра. Во-первых, уточните срок изготовления: главная особенность таких сладостей — свежий хруст, поэтому пирожные стоит заказывать в день выпечки. Во-вторых, изучите состав — в нём не должно быть маргарина и ароматизаторов. В-третьих, заранее выберите точный интервал курьерской службы, чтобы угощение приехало свежим к началу праздника.</p>

                <img src="assets/img/desser-2.jpeg" alt="Свейжий корпусный десерт Вишенка в разрезе от пекарни Хлебный Домик" class="article-img" loading="lazy">

                <h2>Где заказать свежие десерты в Санкт-Петербурге</h2>
                <p>В ремесленной пекарне «Хлебный домик» мы выпекаем продукцию утром в день отправки, чтобы каждый кусочек радовал свежим хрустом и ароматом домашней выпечки. Мы готовим песочные корзиночки с белковым кремом, чизкейк Нью-Йорк, шоколадные эклеры и хрустящие яблочные штрудели. Оформите десерты на заказ с доставкой на дом или в офис на сайте: перейдите в <a href="index.php#catalog" class="article-link">каталог пекарни</a>, выберите нужные позиции в разделе «Десерты» и укажите дату получения в корзине.</p>
            </article>
        </div>
    </section>

    <footer class="site-footer">
        <div class="container">
            <p>© 2026 Хлебный домик. Все права защищены.</p>
        </div>
    </footer>
</body>
</html>

