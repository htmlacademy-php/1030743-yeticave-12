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
  <form class="form form--add-lot container <?=isset($errors) ? "form--invalid" : ""; ?>" action="add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
    <h2>Добавление лота</h2>
    <div class="form__container-two">
      <div class="form__item <?=isset($errors['lot-name']) ? "form__item--invalid" : ""; ?> "> <!-- form__item--invalid -->
        <label for="lot-name">Наименование <sup>*</sup></label>
        <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" value="<?=$form_data['lot-name']?>">
        <span class="form__error"><?=$errors['lot-name']?></span>
      </div>
      <div class="form__item <?=isset($errors['category']) ? "form__item--invalid" : ""; ?> ">
        <label for="category">Категория <sup>*</sup></label>
        <select id="category" name="category">
          <option name='choose-category'>Выберите категорию</option>
          <?php foreach ($category as $key => $item): ?>
            <?php if ($item['id'] === $form_data['category']): ?>
              <option value = '<?=$item['id'];?>' <?="selected"?>><?=$item['name'];?></option>
            <?php else: ?>
              <option value = '<?=$item['id'];?>'><?=$item['name'];?></option>
            <?php endif ?>
          <?php endforeach; ?> 
        </select>
        <span class="form__error"><?=$errors['category']?></span>
      </div>
    </div>
    <div class="form__item form__item--wide <?=isset($errors['message']) ? "form__item--invalid" : ""; ?> ">
      <label for="message">Описание <sup>*</sup></label>
      <textarea id="message" name="message" placeholder="Напишите описание лота"><?=$form_data['message']?></textarea>
      <span class="form__error"><?=$errors['message']?></span>
    </div>
    <div class="form__item form__item--file <?=isset($errors['picture']) ? "form__item--invalid" : ""; ?>">
      <label>Изображение <sup>*</sup></label>
      <div class="form__input-file">
        <input class="visually-hidden" type="file" id="lot-img" value="" name ="picture">
        <label for="lot-img">
          Добавить
        </label>
        <span class="form__error"><?=$errors['picture']?></span>
      </div>
    </div>
    <div class="form__container-three">
      <div class="form__item form__item--small <?=isset($errors['lot-rate']) ? "form__item--invalid" : ""; ?>">
        <label for="lot-rate">Начальная цена <sup>*</sup></label>
        <input id="lot-rate" type="text" name="lot-rate" placeholder="0" value="<?=$form_data['lot-rate']?>">
        <span class="form__error"><?=$errors['lot-rate']?></span>
      </div>
      <div class="form__item form__item--small <?=isset($errors['lot-step']) ? "form__item--invalid" : ""; ?>">
        <label for="lot-step">Шаг ставки <sup>*</sup></label>
        <input id="lot-step" type="text" name="lot-step" placeholder="0" value="<?=$form_data['lot-step']?>">
        <span class="form__error"><?=$errors['lot-step']?></span>
      </div>
      <div class="form__item <?=isset($errors['lot-date']) ? "form__item--invalid" : ""; ?>">
        <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
        <input class="form__input-date" id="lot-date" type="text" name="lot-date" placeholder="Введите дату в формате ГГГГ-ММ-ДД" value="<?=$form_data['lot-date']?>">
        <span class="form__error"><?=$errors['lot-date']?></span>
      </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Добавить лот</button>
  </form>
</main>
