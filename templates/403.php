<main>
  <nav class="nav">
    <ul class="nav__list container">
      <?php foreach ($category as $key => $item): ?>
        <li class="nav__item">
          <a href="all-lots.html"><?=$item['name'];?></a>
        </li>
      <?php endforeach; ?>
    </ul>
  </nav>
  <section class="lot-item container">
    <h2>403 Отказано в доступе</h2>
    <p>Для добавления нового лота необходимо зарегистрироваться, если у вас уже есть аккаунт надо залогиниться.</p>
  </section>
</main>