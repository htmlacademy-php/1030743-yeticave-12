<main class="container">
    <section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">
        <!--заполните этот список из массива категорий-->
        <?php foreach ($category_list as $key => $item): ?>
            <li class="promo__item promo__item--<?=$item['character_code'];?>">
                <a class="promo__link" href="category.php?id=<?=$item['id'];?>"><?=$item['name'];?></a>
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
        <?php foreach ($new_lots as $key => $item): ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?=$item['image'];?>" width="350" height="260" alt="">       
                </div>
                <div class="lot__info">
                        <span class="lot__category"><?=$item['name'];?></span>            
                    <h3 class="lot__title">
                        <a class="text-link" href="lot.php?id=<?=$item['id'];?>"><?=$item['lot_name'];?></a>                
                    </h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <?php if ($item['bet_price']): ?>
                                <span class="lot__amount"><?=$item['bet_count'];?> <?=get_noun_plural_form($item['bet_count'], 'ставка', 'ставки', 'ставок');?></span>
                                <span class="lot__cost"><?= bet_formatter($item['bet_price']) ?></span>  

                            <?php else: ?>
                                <span class="lot__amount">Стартовая цена</span>
                                <span class="lot__cost"><?= bet_formatter($item['start_price']) ?></span>    
                            <?php endif ?>             
                        </div>
                        <?php if (get_time_left($item['end_date'])[0] < 1): ?>
                            <div class="lot__timer timer timer--finishing">
                                <?= show_time_left(get_time_left($item['end_date'])); ?>
                            </div>
                        <?php else: ?>
                            <div class="lot__timer timer">
                                <?= show_time_left(get_time_left($item['end_date'])); ?>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </li>
        <?php endforeach; ?> 
    </ul>
    </section>
</main>
