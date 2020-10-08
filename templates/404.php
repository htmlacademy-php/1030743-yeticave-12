<main>
  <nav class="nav">
    <ul class="nav__list container">
      <?php foreach ($category as $key => $item): ?>
        <li class="nav__item">
          <a href="category.php?id=<?=$item['id'];?>"><?=$item['name'];?></a>
        </li>
      <?php endforeach; ?>
    </ul>
  </nav>
  <section class="lot-item container">
    <h2>404 Страница не найдена</h2>
    <p>Данной страницы не существует на сайте.</p>
  </section>
</main>