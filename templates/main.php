<main class="container">
    <section class="promo">
      <h2 class="promo__title">Нужен стафф для катки?</h2>
      <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
      <ul class="promo__list">
        <?php foreach($categories as $category): ?>
          <li class="promo__item promo__item--<?= $category['category_code']; ?>">
            <a class="promo__link" href="pages/all-lots.html"><?= htmlspecialchars($category['category']); ?></a>
          </li>
        <?php endforeach; ?>
      </ul>
    </section>
    <section class="lots">
      <div class="lots__header">
        <h2>Открытые лоты</h2>
      </div>
      <?php if (count($lots)): ?>
        <ul class="lots__list">
          <?php foreach($lots as $lot): ?>
            <li class="lots__item lot">
              <div class="lot__image">
                <img src="./<?= htmlspecialchars($lot['image']);  ?>" width="350" height="260" alt="<?= htmlspecialchars($lot['title']) ?>">
              </div>
              <div class="lot__info">
                <span class="lot__category"><?= $lot['category'] ?></span>
                <h3 class="lot__title"><a class="text-link" href="pages/lot.html"><?= htmlspecialchars($lot['title']) ?></a></h3>
                <div class="lot__state">
                  <div class="lot__rate">
                    <span class="lot__amount">Стартовая цена</span>
                    <span class="lot__cost"><?= format_num(htmlspecialchars($lot['price'])) ?> р.</span>
                  </div>
                    <?php $res = get_time_left(htmlspecialchars($lot['date_creation'])) ?>
                  <div class="lot__timer timer<?php if ($res[0] < 1): ?> timer--finishing'<?php endif; ?>">
                    <?= $res[0] ?>:<?= $res[1] ?>
                  </div>
                </div>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </section>
</main>