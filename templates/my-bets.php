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
    <section class="rates container">
        <?php if ($_SESSION['user']['id'] === $user_id): ?>
            <h2>Мои ставки</h2>
            <table class="rates__list">
                <?php if (isset($my_bets)) {
                    foreach ($my_bets as $key => $bet): ?>
                        <tr class="rates__item">
                            <td class="rates__info">
                                <div class="rates__img">
                                    <img src="../<?= $bet['image']; ?>" width="54" height="40" alt="Сноуборд">
                                </div>
                                <div>
                                    <h3 class="rates__title"><a
                                                href="lot.php?id=<?= htmlspecialchars($bet['id']); ?>"><?= $bet['lot_name']; ?></a>
                                    </h3>
                                    <?php if ($bet['user_winner_id'] === $user_id): ?>
                                        <p><?= htmlspecialchars($bet['user_contacts']); ?></p>
                                    <?php endif ?>
                                </div>
                            </td>
                            <td class="rates__category">
                                <?= $bet['name']; ?>
                            </td>
                            <td class="rates__timer">
                                <?php if ($bet['user_winner_id'] === $user_id): ?>
                                    <div class="timer timer--win">
                                        Ставка выиграла
                                    </div>
                                <?php elseif (get_time_left($bet['end_date'])[0] < 0): ?>
                                    <div class="timer timer--end">
                                        Торги окончены
                                    </div>
                                <?php elseif (get_time_left($bet['end_date'])[0] < 1): ?>
                                    <div class="timer--finishing">
                                        <?= show_time_left(get_time_left($bet['end_date'])); ?>
                                    </div>
                                <?php else : ?>
                                    <div class="timer">
                                        <?= show_time_left(get_time_left($bet['end_date'])); ?>
                                    </div>
                                <?php endif ?>
                            </td>
                            <td class="rates__price">
                                <?= htmlspecialchars($bet['bet_price']); ?>
                            </td>
                            <td class="rates__time">
                                <?= get_creation_date($bet['creation_date']); ?>
                            </td>
                        </tr>
                    <?php endforeach;
                } ?>
            </table>
        <?php else : ?>
            <h2>403 Отказано в доступе</h2>
        <?php endif ?>
    </section>
</main>
