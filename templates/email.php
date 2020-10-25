<h1>Поздравляем с победой</h1>
<p>Здравствуйте, <?= isset($winner['name']) ? $winner['name'] : ""; ?></p>
<p>Ваша ставка для лота <a
            href="http://<?= isset($host) ? $host : ""; ?>/lot.php?id=<?= isset($winner['lot_id']) ? $winner['lot_id'] : ""; ?>"><?= isset($winner['lot_name']) ? $winner['lot_name'] : ""; ?></a> победила.
</p>
<p>Перейдите по ссылке <a href="http://<?= isset($host) ? $host : ""; ?>/user-bets.php?id=<?= isset($winner['user_id']) ? $winner['user_id'] : ""; ?>">мои ставки</a>,
    чтобы связаться с автором объявления</p>
<small>Интернет Аукцион "YetiCave"</small>