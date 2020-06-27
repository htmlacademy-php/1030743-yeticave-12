<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">
        <!--заполните этот список из массива категорий-->
        <?php foreach ($categories as $item): ?>
            <li class="promo__item promo__item--boards">
                <a class="promo__link" href="pages/all-lots.html"><?=$item;?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">
    <!--заполните этот список из массива с товарами-->
        <?php foreach ($announcements as $key => $item): ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <?php if ($item['picture-url']): ?>
                        <img src="<?=$item['picture-url'];?>" width="350" height="260" alt="">
                    <?php endif ?>
                </div>
                <div class="lot__info">
                        <?php if ($item['category']): ?>
                            <span class="lot__category"><?=$item['category'];?></span>
                        <?php endif ?>
                    <h3 class="lot__title">
                        <?php if ($item['title']): ?>
                            <a class="text-link" href="pages/lot.html"><?=$item['title'];?></a>
                        <?php endif ?>
                    </h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <?php if ($item['price']): ?>
                                <span class="lot__cost"><?= bet_formatter($item['price']) ?></span>
                            <?php endif ?>
                        </div>
                        <div class="lot__timer timer">
                            12:23
                        </div>
                    </div>
                </div>
            </li>
        <?php endforeach; ?> 
    </ul>
</section>