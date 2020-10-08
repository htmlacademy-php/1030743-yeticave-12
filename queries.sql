-- добавляет данные в "лот"

INSERT INTO lot (id, creation_date, lot_name, lot_description, image, start_price, end_date, bet_step, user_lot_add_id, user_winner_id, category_id) VALUES
  (1, NOW(), '2014 Rossignol District Snowboard', 'Сноуборд сноубордический №1', 'img/lot-1.jpg', '10000', NOW() + INTERVAL 10 DAY, 500, 2, 2, 1),
  (2, NOW(), 'DC Ply Mens 2016/2017 Snowboard', 'Сноуборд для сноубординга №2', 'img/lot-2.jpg', '15000', NOW() + INTERVAL 15 DAY, 500, 1, 1, 1),
  (3, NOW(), 'Крепления Union Contact Pro 2015 года размер L/XL','крепление которое крепко крепит крепеж', 'img/lot-3.jpg', '8000', NOW() + INTERVAL 20 DAY, 500, 2, 2, 2),
  (4, NOW(), 'Ботинки для сноуборда DC Mutiny Charocal','Ботинки сноубордические угольные ога', 'img/lot-4.jpg', '6700', NOW() + INTERVAL 25 DAY, 500, 1, 1, 3),
  (5, NOW(), 'Куртка для сноуборда DC Mutiny Charocal','Куртка для сноубординга теплая не промакаемая', 'img/lot-5.jpg', '7500', NOW() + INTERVAL 30 DAY, 500, 2, 2, 4),
  (6, NOW(), 'Маска Oakley Canopy', 'Маска для лица головы на шее', 'img/lot-6.jpg', '5400', NOW() + INTERVAL 35 DAY, 500, 1, 1, 6);

-- добавляет данные в "категрории"

INSERT INTO category (id, name, character_code) VALUES
  (1, 'Доски и лыжи', 'boards'),
  (2, 'Крепления', 'attachment'),
  (3, 'Ботинки', 'boots'),
  (4, 'Одежда', 'clothing'),
  (5, 'Инструменты', 'tools'),
  (6, 'Разное', 'other');

-- добавляет данные в "пользователи"

INSERT INTO users (id, email, name, password, user_contacts, lot_id, bet_id) VALUES
  (1, 'vasyaNagibator11@mail.ru', 'Вася', 'vasya2010', '89642589741', 1, 1),
  (2, 'petyaBFG9000@mail.ru', 'Петя', 'iddqd', '89824778548', 2, 2),
  (3, 'vasyaNag211ibator11@mail.ru', 'Петя', 'v23423410', '89596969741', 3, 3);

-- добавляет данные в "ставку"

INSERT INTO bet (id, creation_date, bet_price, user_id, lot_id) VALUES
  (1, NOW(), '1000', 1, 3),
  (2, NOW(), '1500', 3, 2),
  (3, NOW(), '800', 2, 5);

-- получить все категории;

SELECT * FROM category;

-- получить самые новые, открытые лоты. Каждый лот должен включать название, 
-- стартовую цену, ссылку на изображение, текущую цену, название категории

SELECT lot.id, lot_name, start_price, end_date, category_id, category.name, bet.bet_price, image FROM lot 
JOIN category ON lot.category_id = category.id 
JOIN bet ON bet.id = lot.id;

-- показать лот по его id. Получите также название категории, к которой принадлежит лот

SELECT lot.id, category.name FROM lot
JOIN category ON lot.category_id = category.id;

-- обновить название лота по его идентификатору

UPDATE lot SET lot_name = 'new name' WHERE id = 3;

-- получить список ставок для лота по его идентификатору с сортировкой по дате
-- сортировкой по дате

SELECT * FROM bet WHERE lot_id = 3 ORDER BY creation_date ASC;