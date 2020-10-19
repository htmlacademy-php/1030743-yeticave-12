<?php
require_once('helpers.php');
require_once('functions.php');
require_once('vendor/autoload.php');

$connection = connect_to_db();

$sql_winners = 'SELECT lot.id, lot_name, user_winner_id, end_date, bet.lot_id, max_bet_price, 
user_id, bets.user_id, email, name FROM lot 
JOIN (SELECT MAX(bet_price) as max_bet_price, lot_id FROM bet GROUP BY lot_id) bet
ON bet.lot_id = lot.id
JOIN bet as bets
ON bets.lot_id = lot.id AND max_bet_price = bet_price
JOIN users 
ON users.id = bets.user_id
WHERE end_date <= NOW() AND user_winner_id IS NULL';

$result_sql_winners = mysqli_query($connection, $sql_winners);
$winners = mysqli_fetch_all($result_sql_winners, MYSQLI_ASSOC);

$host = $_SERVER['HTTP_HOST'];

if ($winners) {
    foreach ($winners as $winner) {

        $sql_set_winners = 'UPDATE lot SET user_winner_id = ' . $winner['user_id'] .
            ' WHERE id = ' . $winner['lot_id'];

        $result_set_winners = mysqli_query($connection, $sql_set_winners);

        if ($result_set_winners) {
            $message_body = include_template('email.php', [
                'winner' => $winner,
                'host' => $host
            ]);

            $transport = new Swift_SmtpTransport("phpdemo.ru", 25);
            $transport->setUserName("keks@phpdemo.ru");
            $transport->setPassword("htmlacademy");

            $message = new Swift_Message();
            $message->setSubject("Ваша ставка победила");
            $message->setTo([$winner['email'] => $winner['name']]);
            $message->setBody($message_body, 'text/html');
            $message->setFrom(['keks@phpdemo.ru' => 'YetiCave']);

            $mailer = new Swift_Mailer($transport);
            $result = $mailer->send($message);
        } else {
            print(mysqli_error($connection));
        }
    };
}

