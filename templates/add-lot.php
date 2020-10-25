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
    <form class="form form--add-lot container <?= isset($errors) ? "form--invalid" : ""; ?>" action="add.php"
          method="post" enctype="multipart/form-data"> <!-- form--invalid -->
        <h2>Добавление лота</h2>
        <div class="form__container-two">
            <div class="form__item <?= isset($errors['lot-name']) ? "form__item--invalid" : ""; ?> ">
                <!-- form__item--invalid -->
                <label for="lot-name">Наименование <sup>*</sup></label>
                <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота"
                       value="<?= isset($form_data['lot-name']) ? htmlspecialchars($form_data['lot-name']) : "" ?>">
                <span class="form__error"><?= isset($errors['lot-name']) ? $errors['lot-name']  : "" ?></span>
            </div>
            <div class="form__item <?= isset($errors['category']) ? "form__item--invalid" : ""; ?> ">
                <label for="category">Категория <sup>*</sup></label>
                <select id="category" name="category">
                    <option name='choose-category'>Выберите категорию</option>
                    <?php if (isset($category)): ?>
                        <?php foreach ($category as $key => $item): ?>
                            <?php if (isset($form_data['category'])): ?>
                                <?php if ($item['id'] === $form_data['category']): ?>
                                    <option value='<?= $item['id']; ?>' <?= "selected" ?>><?= htmlspecialchars($item['name']); ?></option>
                                <?php else: ?>
                                    <option value='<?= $item['id']; ?>'><?= htmlspecialchars($item['name']); ?></option>
                                <?php endif ?>
                            <?php else: ?>
                                <option value='<?= $item['id']; ?>'><?= htmlspecialchars($item['name']); ?></option>
                            <?php endif ?>
                        <?php endforeach; ?>
                    <?php endif ?>
                </select>
                <span class="form__error"><?=isset($errors['category']) ? $errors['category'] : "" ?></span>
            </div>
        </div>
        <div class="form__item form__item--wide <?= isset($errors['message']) ? "form__item--invalid" : ""; ?> ">
            <label for="message">Описание <sup>*</sup></label>
            <textarea id="message" name="message"
                      placeholder="Напишите описание лота"><?= isset($form_data['message']) ? htmlspecialchars($form_data['message']) : "" ?></textarea>
            <span class="form__error"><?= isset($errors['message']) ? htmlspecialchars($errors['message']) : ""  ?></span>
        </div>
        <div class="form__item form__item--file <?= isset($errors['picture']) ? "form__item--invalid" : ""; ?>">
            <label>Изображение <sup>*</sup></label>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" id="lot-img" value="" name="picture">
                <label for="lot-img">
                    Добавить
                </label>
                <span class="form__error"><?= isset($errors['picture']) ? $errors['picture'] : "" ?></span>
            </div>
        </div>
        <div class="form__container-three">
            <div class="form__item form__item--small <?= isset($errors['lot-rate']) ? "form__item--invalid" : ""; ?>">
                <label for="lot-rate">Начальная цена <sup>*</sup></label>
                <input id="lot-rate" type="text" name="lot-rate" placeholder="0"
                       value="<?= isset($form_data['lot-rate']) ? htmlspecialchars($form_data['lot-rate']) : "" ?>">
                <span class="form__error"><?= isset($errors['lot-rate']) ? $errors['lot-rate'] : "" ?></span>
            </div>
            <div class="form__item form__item--small <?= isset($errors['lot-step']) ? "form__item--invalid" : ""; ?>">
                <label for="lot-step">Шаг ставки <sup>*</sup></label>
                <input id="lot-step" type="text" name="lot-step" placeholder="0"
                       value="<?= isset($form_data['lot-step']) ? htmlspecialchars($form_data['lot-step']) : "" ?>">
                <span class="form__error"><?= isset($errors['lot-step']) ? $errors['lot-step'] : "" ?></span>
            </div>
            <div class="form__item <?= isset($errors['lot-date']) ? "form__item--invalid" : ""; ?>">
                <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
                <input class="form__input-date" id="lot-date" type="text" name="lot-date"
                       placeholder="Введите дату в формате ГГГГ-ММ-ДД"
                       value="<?= isset($form_data['lot-date']) ? htmlspecialchars($form_data['lot-date']) : "" ?>">
                <span class="form__error"><?= isset($errors['lot-date']) ? $errors['lot-date'] : "" ?></span>
            </div>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Добавить лот</button>
    </form>
</main>
