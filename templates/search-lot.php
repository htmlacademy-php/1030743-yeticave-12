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
    <div class="container">
      <?php if ($lots): ?>
        <section class="lots">
          
          <h2>Результаты поиска по запросу «<span><?=$search_headers;?></span>»</h2>
          <ul class="lots__list">
            <?php foreach ($lots as $key => $lot): ?>
              <li class="lots__item lot">
                <div class="lot__image">
                  <img src="../<?=$lot['image'];?>" width="350" height="260" alt="<?=$lot['lot_description'];?>">
                </div>
                <div class="lot__info">
                  <span class="lot__category"><?=$lot['name'];?></span>
                  <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?=$lot['id'] + 1;?>"><?=$lot['lot_name'];?></a></h3>
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
        <ul class="pagination-list">
          <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
          <li class="pagination-item pagination-item-active"><a>1</a></li>
          <li class="pagination-item"><a href="#">2</a></li>
          <li class="pagination-item"><a href="#">3</a></li>
          <li class="pagination-item"><a href="#">4</a></li>
          <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
        </ul>
        <?php else: ?>
          <section class="lots">
            <h2>По вашему запросу «<span><?=$search_headers;?></span>» ничего не найдено</h2>
        <?php endif ?>
    </div>
 
  </main>