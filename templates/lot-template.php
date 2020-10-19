<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php if (isset($category)) {
                foreach ($category as $key => $item): ?>
                    <li class="nav__item">
                        <a href="category.php?id=<?= htmlspecialchars($item['id']); ?>"><?= $item['name']; ?></a>
                    </li>
                <?php endforeach;
            } ?>
        </ul>
    </nav>
    <section class="lot-item container">
        <?php if (isset($lot)): ?>
            <h2><?= htmlspecialchars($lot['lot_name']); ?></h2>
            <div class="lot-item__content">
                <div class="lot-item__left">
                    <div class="lot-item__image">
                        <img src="../<?= $lot['image']; ?>" width="730" height="548" alt="Сноуборд">
                    </div>
                    <p class="lot-item__category">Категория: <span><?= $lot['name']; ?></span></p>
                    <p class="lot-item__description"><?= htmlspecialchars($lot['lot_description']); ?></p>
                </div>
                <div class="lot-item__right">
                    <?php if (isset($_SESSION['user']) && ($_SESSION['user']['name'] !== $user_name_lot_add)
                        && ($current_time < $lot_end_date) && ($_SESSION['user']['name'] !== $bets[0]['name'])): ?>
                        <div class="lot-item__state">
                            <?php if (get_time_left($lot['end_date'])[0] < 1): ?>
                                <div class="lot-item__timer timer timer--finishing">
                                    <?= show_time_left(get_time_left($lot['end_date'])); ?>
                                </div>
                            <?php else: ?>
                                <div class="lot-item__timer timer">
                                    <?= show_time_left(get_time_left($lot['end_date'])); ?>
                                </div>
                            <?php endif ?>
                            <div class="lot-item__cost-state">
                                <div class="lot-item__rate">
                                    <span class="lot-item__amount">Текущая цена</span>
                                    <span class="lot-item__cost"><?= htmlspecialchars($lot_price); ?></span>
                                </div>
                                <div class="lot-item__min-cost">
                                    Мин. ставка <span><?= htmlspecialchars($min_bet); ?></span>
                                </div>
                            </div>
                            <form class="lot-item__form <?= isset($error) ? "form__item--invalid" : ""; ?>"
                                  action="lot.php" method="post" autocomplete="off">
                                <p class="lot-item__form-item form__item ">
                                    <label for="cost">Ваша ставка</label>
                                    <input id="cost" type="text" name="cost"
                                           placeholder="<?= htmlspecialchars($min_bet); ?>">
                                    <input id="id" type="hidden" name="id" value="<?= htmlspecialchars($lot_id); ?>">
                                    <span class="form__error"><?= $error; ?></span>
                                </p>
                                <button type="submit" class="button">Сделать ставку</button>
                            </form>
                        </div>
                    <?php endif ?>
                    <?php if ($lot['bet_count'] > 0): ?>
                        <div class="history">
                            <h3>История ставок (<span><?= $lot['bet_count']; ?></span>)</h3>
                            <table class="history__list">
                                <?php foreach ($bets as $key => $item): ?>
                                    <tr class="history__item">
                                        <td class="history__name"><?= htmlspecialchars($item['name']); ?></td>
                                        <td class="history__price"><?= htmlspecialchars($item['bet_price']); ?> р</td>
                                        <td class="history__time"><?= get_creation_date($item['creation_date']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="history">
                            <h3>Ставок пока не было</h3>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        <?php endif ?>
    </section>
</main>
