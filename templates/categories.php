<main>
    <nav class="nav">
      <ul class="nav__list container">
        <?php foreach ($category as $key => $item): ?>
          <li class="nav__item <?=$item['name'] === $category_name ? "nav__item--current" : "";?>">
            <a href="category.php?id=<?=htmlspecialchars($item['id']);?>"><?=$item['name'];?></a>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>
    <div class="container">
      <?php if ($lots): ?>
        <section class="lots">
          
          <h2>Все лоты в категории «<span><?=$category_name;?></span>»</h2>
          <ul class="lots__list">
            <?php foreach ($lots as $key => $lot): ?>
              <li class="lots__item lot">
                <div class="lot__image">
                  <img src="../<?=$lot['image'];?>" width="350" height="260" alt="<?=$lot['lot_description'];?>">
                </div>
                <div class="lot__info">
                  <span class="lot__category"><?=$lot['name'];?></span>
                  <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?=htmlspecialchars($lot['id']);?>"><?=$lot['lot_name'];?></a></h3>
                  <div class="lot__state">
                    <div class="lot__rate">
                      <span class="lot__amount">Стартовая цена</span>
                      <span class="lot__cost"><?=$lot['start_price'];?><b class="rub">р</b></span>
                    </div>
                      <?php if (get_time_left($lot['end_date'])[0] < 1): ?>
                        <div class="lot__timer timer timer--finishing">
                            <?= show_time_left(get_time_left($lot['end_date'])); ?>
                        </div>
                      <?php else: ?>
                        <div class="lot__timer timer">
                            <?= show_time_left(get_time_left($lot['end_date'])); ?>
                        </div>
                      <?php endif ?>
                  </div>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        </section>
        <?php if ($pages_count > 1): ?>
          <ul class="pagination-list">
            <?php if ($cur_page > 1): ?>
              <li class="pagination-item pagination-item-prev"><a href="category.php?id=<?=htmlspecialchars(strval($_GET['id'])); ?>&page=<?=$cur_page - 1;?>">Назад</a></li>
            <?php else: ?>
              <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
            <?php endif ?>
              <?php foreach ($pages as $page): ?>
                <?php if ($page === $cur_page): ?>
                  <li class="pagination-item pagination-item-active"><a><?=$page;?></a></li>
                <?php else: ?>
                  <li class="pagination-item"><a href="category.php?id=<?=htmlspecialchars(strval($_GET['id'])); ?>&page=<?=$page;?>"><?=$page;?></a></li>
                <?php endif ?>
              <?php endforeach; ?>
            <?php if ($pages_count > $cur_page): ?>
              <li class="pagination-item pagination-item-next"><a href="category.php?id=<?=htmlspecialchars(strval($_GET['id'])); ?>&page=<?=$cur_page + 1;?>">Вперед</a></li>
            <?php else: ?>
              <li class="pagination-item pagination-item-next"><a>Вперед</a></li>
            <?php endif ?>
          </ul>
        <?php endif ?>
        <?php else: ?>
          <section class="lots">
            <h2>В данной категории нет активных лотов</h2>
        <?php endif ?>
    </div>
 
  </main>