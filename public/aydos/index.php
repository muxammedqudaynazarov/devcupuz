<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sensor Paneli</title>
    <script src="https://cdn.jsdelivr.net/npm/canvas-gauges/gauge.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Mukta:wght@200;300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            background: #f2f6fc;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 40px;
            padding: 40px;
            font-family: "Kanit", sans-serif;
            height: 85vh;
        }

        .gauge-container {
            text-align: center;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            padding: 20px 15px;
            transition: transform 1s;
            width: 240px;
            height: 220px;
        }

        .gauge-container:hover {
            transform: translateY(-4px);
        }

        .gauge-label {
            margin-top: 10px;
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }

        .lamp {
            width: 24px;
            height: 24px;
            background-color: grey;
            border-radius: 50%;
            margin: 10px auto;
            transition: background-color 0.3s ease;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
        }

        .lamp.on {
            background-color: #00e676;
            box-shadow: 0 0 10px #00e676;
        }

        .toggle-btn {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 6px 12px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 5px;
        }

        .toggle-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="gauge-container">
    <canvas data-type="radial-gauge"
            data-width="200"
            data-height="200"
            data-units="°C"
            data-title="Havo harorati"
            data-min-value="-100"
            data-max-value="100"
            data-major-ticks="[-100,-80,-60,-40,-20,0,20,40,60,80,100]"
            data-minor-ticks="2"
            data-stroke-ticks="true"
            data-highlights='[ {"from": -100, "to": 0, "color": "rgba(0,0, 255, .7)"},{"from": 30, "to": 100, "color": "rgba(255, 0, 0, .7)"} ]'
            data-ticks-angle="225" id="tempGauge"
            data-start-angle="67.5"
            data-color-major-ticks="#ddd"
            data-color-minor-ticks="#ddd"
            data-color-title="#555"
            data-color-units="#222"
            data-color-numbers="#222"
            data-color-plate="#fff"
            data-border-shadow-width="0"
            data-borders="true"
            data-needle-type="arrow"
            data-needle-width="4"
            data-value-int="2"
            data-value-dec="1"
            data-needle-circle-size="2"
            data-needle-circle-outer="true"
            data-needle-circle-inner="false"
            data-animation-duration="500"
            data-animation-rule="linear"
            data-color-border-outer="#333"
            data-color-border-outer-end="#333"
            data-color-border-middle="#fff"
            data-color-border-middle-end="#fff"
            data-color-border-inner="#fff"
            data-color-border-inner-end="#fff"
            data-color-needle-shadow-down="#fff"
            data-color-needle-circle-outer="#fff"
            data-color-needle-circle-outer-end="#fff"
            data-color-needle-circle-inner="#fff"
            data-color-needle-circle-inner-end="#fff"
            data-value-box-border-radius="0"
            data-color-value-box-rect="#222"
            data-color-value-box-rect-end="#333"></canvas>
</div>
<div class="gauge-container">
    <canvas data-type="radial-gauge"
            data-title="Havo namligi"
            data-width="200"
            data-height="200"
            data-value-int="2"
            data-value-dec="1"
            data-units="%" id="humGauge"></canvas>
</div>
<div class="gauge-container">
    <div class="lamp" id="lamp-gas" style="display: none"></div>
    <img src="https://devcup.uz/aydos/off.png" alt="Lamp Image" id="img-gas" style="width: 170px; cursor: pointer;"
         onclick="toggleLamp('img-gas')">
</div>
<div class="gauge-container">
    <canvas data-type="radial-gauge"
            data-title="Zaharli gaz"
            data-width="200"
            data-value-int="2"
            data-value-dec="1"
            data-height="200"
            data-units="ppm"
            data-min-value="0"
            data-max-value="1000"
            data-major-ticks="0,100,200,300,400,500,600,700,800,900,1000"
            data-minor-ticks="2"
            data-stroke-ticks="true"
            data-highlights='[{"from": 500, "to": 1000, "color": "rgba(200, 50, 50, .75)"}]'
            data-color-plate="#fff"
            data-border-shadow-width="0"
            data-borders="false"
            data-needle-type="arrow"
            data-needle-width="2"
            data-needle-circle-size="7"
            data-needle-circle-outer="true"
            data-needle-circle-inner="false"
            data-animation-duration="1500"
            data-animation-rule="linear"
            id="gasGauge"></canvas>
</div>
<div class="gauge-container">
    <canvas data-type="radial-gauge"
            data-title="Tuproq namligi"
            data-width="200"
            data-height="200"
            data-value-int="2"
            data-value-dec="1"
            data-units="%" id="soilGauge"></canvas>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Rasmni ustiga bosganda chiroqni boshqarish
    function toggleLamp(imgId) {
        const lamp = document.getElementById("lamp-gas");
        const img = document.getElementById(imgId);
        lamp.classList.toggle('on');

        if (lamp.classList.contains('on')) {
            img.src = 'https://devcup.uz/aydos/on.png';
            $.ajax({
                url: 'https://devcup.uz/api/led/1/1/y/1',
                method: 'GET'
            });
        } else {
            img.src = 'https://devcup.uz/aydos/off.png';
            $.ajax({
                url: 'https://devcup.uz/api/led/1/1/y/0',
                method: 'GET'
            });
        }
    }

    // Serverdan chiroqning joriy holatini so'rash (Sinxronizatsiya)
    function checkLampStatus() {
        $.ajax({
            url: 'https://devcup.uz/api/led/1/1', // code: 1, led_no: 1
            method: 'GET',
            success: function (status) {
                const lamp = document.getElementById("lamp-gas");
                const img = document.getElementById("img-gas");

                // Agar server "on" qaytarsa
                if (status === 'on') {
                    lamp.classList.add('on');
                    img.src = 'https://devcup.uz/aydos/on.png';
                }
                // Agar server "off" qaytarsa
                else if (status === 'off') {
                    lamp.classList.remove('on');
                    img.src = 'https://devcup.uz/aydos/off.png';
                }
            }
        });
    }

    // Gauge (datchiklar) ma'lumotlarini o'qish
    function updateAllGauges() {
        $.getJSON("https://devcup.uz/api/sensordata?limit=1", function (data) {
            if (data.length > 0) {
                document.gauges.forEach(gauge => {
                    let value = 0;
                    if (gauge.canvas.element.id === "tempGauge") {
                        value = data[0].temperature;
                    } else if (gauge.canvas.element.id === "humGauge") {
                        value = data[0].humidity;
                    } else if (gauge.canvas.element.id === "gasGauge") {
                        value = data[0].gas;
                    } else if (gauge.canvas.element.id === "soilGauge") {
                        value = data[0].soil;
                    }
                    gauge.value = value;
                });
            }
        }).fail(function (jqxhr, textStatus, error) {
            console.error("Sensor data error:", error);
        });
    }

    // Sahifa yuklanganda va har 3 soniyada ma'lumotlarni yangilash
    $(document).ready(function () {
        checkLampStatus(); // Birinchi marta darhol tekshirish
        updateAllGauges();

        setInterval(function() {
            updateAllGauges();
            checkLampStatus(); // Har 3 soniyada chiroq holatini ham so'rash
        }, 3000);
    });
</script>
</body>
</html>
