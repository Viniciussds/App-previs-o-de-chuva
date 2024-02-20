<?php

require_once 'inc/config.php';
require_once 'inc/api.php';

$cidade = 'Lisbon';
if (isset($_GET['cidade'])) {
    $cidade = $_GET['cidade'];
}
$dias = 5;

$resultado = Api::get($cidade, $dias);

if ($resultado['status'] == "error") {
    echo $resultado['message'];
    exit;
}
// array associativo

$data = json_decode($resultado['data'], true);

// locais
$location = [];
$location['name'] = $data['location']['name'];
$location['region'] = $data['location']['region'];
$location['country'] = $data['location']['country'];
$location['localtime'] = $data['location']['localtime'];

// data da chuva
$current = [];
$current['info'] = 'Neste momento:';
$current['temperature'] = $data['current']['temp_c'];
$current['condition'] = $data['current']['condition']['text'];
$current['condition-icon'] = $data['current']['condition']['icon'];
$current['wind_speed'] = $data['current']['wind_kph'];

$forecast = [];
foreach ($data['forecast']['forecastday'] as $day) {
    $forecast_day = [];
    $forecast_day['info'] = null;
    $forecast_day['date'] = date_create($day['date']);
    $forecast_day['date_format'] = date_format($forecast_day['date'], 'd/m/Y');
    $forecast_day['condition'] = $day['day']['condition']['text'];
    $forecast_day['condition-icon'] = $day['day']['condition']['icon'];
    $forecast_day['max_temp'] = $day['day']['maxtemp_c'];
    $forecast_day['min_temp'] = $day['day']['mintemp_c'];
    $forecast[] = $forecast_day;

}

function city_selected($cidade, $selected_city)
{
    if ($cidade === $selected_city) {
        return 'selected';
    }
    return '';
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-transparent text-white">
    <div class="container-fluid mt-5">
        <div class="row justify-content-center mt-5">
            <div class="col-10 p-5 bg-light shadow text-black">

                <div class="row">
                    <div class="col-9">
                        <h3>tempo para a cidade <Strong>
                                <?= $location['name'] ?>
                            </Strong></h3>
                        <p class="my-2">Região:
                            <?= $location['region'] ?> |
                            <?= $location['country'] ?> |
                            <?= $location['localtime'] ?> | Previsão para <strong>
                                <?= $dias ?>
                            </strong> dias
                        </p>
                    </div>
                </div>
                <div class="col-3 text-end">
                    <select class="form-select">
                        <option value="Lisbon" <?= city_selected('Lisbon', $cidade) ?>>Lisbon</option>
                        <option value="Madrid" <?= city_selected('Madrid', $cidade) ?>>Madrid</option>
                        <option value="Paris" <?= city_selected('Paris', $cidade) ?>>Paris</option>
                        <option value="London" <?= city_selected('London', $cidade) ?>>London</option>
                        <option value="Berlin" <?= city_selected('Berlin', $cidade) ?>>Berlin</option>
                        <option value="Brasilia" <?= city_selected('Brasilia', $cidade) ?>>Brasília</option>
                        <option value="Uruguaiana" <?= city_selected('Uruguaiana', $cidade) ?>>Uruguaiana</option>
                    </select>
                </div>
                <div id="loadingIndicator" class="text-center mt-3" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <hr>
                <!-- Current !-->
                <?php
                $agua_info = $current;
                include 'inc/agua-info.php';
                ?>
                <!-- Forecast !-->
                <?php foreach ($forecast as $day): ?>
                    <?php
                    $agua_info = $day;
                    include 'inc/agua-info.php';
                    ?>
                <?php endforeach ?>
            </div>
        </div>
    </div>
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script>
        const select = document.querySelector('select');
        const loadingIndicator = document.getElementById('loadingIndicator');

        select.addEventListener('change', function () {
            const cidade = this.value;
            loadingIndicator.style.display = 'block'; // Exibe o indicador de carregamento
            window.location.href = `index.php?cidade=${cidade}`;
        });
    </script>
</body>

</html>