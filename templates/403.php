<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php if (isset($category)) {
                foreach ($category as $key => $item): ?>
                    <li class="nav__item">
                        <a href="category.php?id=<?= $item['id']; ?>"><?= $item['name']; ?></a>
                    </li>
                <?php endforeach;
            } ?>
        </ul>
    </nav>
    <section class="lot-item container">
        <h2>403 Отказано в доступе</h2>
        <p>Для добавления нового лота необходимо <a href="register.php">зарегистрироваться</a>, если у вас уже есть
            аккаунт надо <a href="login.php">залогиниться</a>.</p>
    </section>
</main>
