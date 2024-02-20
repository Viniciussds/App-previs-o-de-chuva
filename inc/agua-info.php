<div class="card my-2 p-3">
    <div>
        <?= $agua_info['info'] ?>
    </div>
    <div class="d-flex align-items-center">
        <div class="me-5">
            <img class="img-fluid d-block" src="<?= $agua_info['condition-icon'] ?>" alt="">
        </div>
        <?php if (!empty($agua_info['temperature'])): ?>
            <div class="me-5">
                <h3 class="">
                    <?= $agua_info['temperature'] ?>
                    &deg;
                </h3>
            </div>
        <?php endif ?>

        <div class="me-5">
            <?= $agua_info['condition'] ?>
        </div>
        <?php
        if (!empty($agua_info['max_temp'])): ?>

            <div class="me-5">
                dia:
                <?= $agua_info['date_format']; ?>
            </div>
            <div class="me-5">
                Temperatura maxíma:
                <?= $agua_info['max_temp']; ?>&deg;
            </div>
            <div class="me-5">
                Temperatura mínima:
                <?= $agua_info['min_temp']; ?>&deg;
            </div>
        <?php endif ?>
    </div>
</div>