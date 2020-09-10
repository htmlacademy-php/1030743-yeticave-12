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
    <form class="form container <?=isset($errors) ? "form--invalid" : ""; ?>" action="login.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
      <h2>Вход</h2>
      <div class="form__item <?=isset($errors['email']) ? "form__item--invalid" : ""; ?>"> <!-- form__item--invalid -->
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=$form_data['email']?>">
        <span class="form__error"><?=$errors['email']?></span>
      </div>
      <div class="form__item form__item--last <?=isset($errors['password']) ? "form__item--invalid" : ""; ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль">
        <span class="form__error"><?=$errors['password']?></span>
      </div>
      <button type="submit" class="button">Войти</button>
    </form>
  </main>