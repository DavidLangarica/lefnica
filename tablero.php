<?php
    $host = "localhost";
    $user = "root";
    $password = "root";
    $db = "lefnica";

    $con = mysqli_connect($host, $user, $password, $db);

    $sql = "SELECT * FROM `alimento`";
    $all_categories = mysqli_query($con, $sql);

                                    
    $id_selected = $_SESSION['id_select'];
    $name_selected = $_SESSION['name_select'];

    $sql_type = "SELECT * FROM `alimento` WHERE Id_alimento = '".$id_selected."' ;";
    $result_type = mysqli_query($con,$sql_type);

    $category_type = mysqli_fetch_array($result_type,MYSQLI_ASSOC);

    $_SESSION['cat_type'] = $category_type;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="initial-scale=1, width=device-width"/>
    <title>Tablero</title>
    <meta name="description" content=""/>

    <link rel="icon" type="image/x-icon" href="lef_logo.png">

    <link rel="stylesheet" href="./global.css" />
    <link rel="stylesheet" href="./info-alimento.css"/>
    <link rel="stylesheet" href="./dashboard.css"/>
    <link rel="stylesheet" href="./team.css"/>

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Modak:wght@400&display=swap"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&display=swap"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Helvetica:wght@700&display=swap"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap"/>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet"/>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css"/>

    <script type="text/javascript">

        function addLoadEvent(func) { 
            var oldonload = window.onload; 
            if (typeof window.onload != 'function') { 
                window.onload = func; 
            } else { 
                window.onload = function() { 
                if (oldonload) { 
                    oldonload(); 
                } 
                func(); 
                } 
            } 
        }          

        function display_date() {

            const month = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];

            n = new Date();
            y = n.getFullYear();
            let m = month[n.getMonth()];
            d = n.getDate();
            h = String(n.getHours()).padStart(2, '0');
            min = String(n.getMinutes()).padStart(2, '0');


            document.getElementById("date").innerHTML = d + " de " + m + " de " + y;
            document.getElementById("hour").innerHTML = h + ":" + min;
            setTimeout(display_date, 1000);

            if (h >= 0 && h < 12) {
                document.getElementById("saludo").innerHTML = "¡Buenos días!";
            } else if (h >= 12 && h < 19) {
                document.getElementById("saludo").innerHTML = "¡Buenas tardes!";
            } else if (h >= 19 && h <= 23) {
                document.getElementById("saludo").innerHTML = "¡Buenas noches!";
            }

            refresh();

        }

        function refresh() {
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        }

        function graph_temperatura() {
        var chart = new CanvasJS.Chart("t_chart",{
            axisY: {
                title: "Temperatura",
                titleFontFamily: "Tahoma",
            },
            axisX: {
                title: "Tiempo",
                titleFontFamily: "Tahoma",
            },
            data: [{
                lineColor: "orange",
                color: "orange",
                type: "line",
                dataPoints : [],
            }]
        });
            
        $.getJSON("temperatura.php", function(data) {  
            $.each((data), function(key, value){
                chart.options.data[0].dataPoints.push({label: value[0], y: parseInt(value[1])});		
            });
            chart.render();
            updateChart();
        });

        function updateChart() {
            $.getJSON("temperatura.php", function(data) {		
                chart.options.data[0].dataPoints = [];
                $.each((data), function(key, value){
                    chart.options.data[0].dataPoints.push({label: value[0], y: parseInt(value[1])});		
                });
                
                chart.render();
            });
        }
        
        setInterval(function(){updateChart()}, 1000);
    }

    function graph_humedad() {
        var chart = new CanvasJS.Chart("hum_chart",{
            axisY: {
                title: "Humedad",
                titleFontFamily: "Tahoma",
            },
            axisX: {
                title: "Tiempo",
                titleFontFamily: "Tahoma",
            },
            data: [{
                lineColor: "orange",
                color: "orange",
                type: "line",
                dataPoints : [],
            }]
        });
            
        $.getJSON("humedad.php", function(data) {  
            $.each((data), function(key, value){
                chart.options.data[0].dataPoints.push({label: value[0], y: parseInt(value[1])});		
            });
            chart.render();
            updateChart();
        });

        function updateChart() {
            $.getJSON("humedad.php", function(data) {		
                chart.options.data[0].dataPoints = [];
                $.each((data), function(key, value){
                    chart.options.data[0].dataPoints.push({label: value[0], y: parseInt(value[1])});		
                });
                
                chart.render();
            });
        }
        
        setInterval(function(){updateChart()}, 1000);
    }

        function data_table(){
            var temp_len = 0;

            var table = $('#data_table').DataTable( {
                paging: false,
                searching: false,
                'responsive': true,
                order: [[0, 'desc']],
                columns: [
                    { data: 'Tiempo' },
                    { data: 'Temperatura' },
                    { data: 'Humedad' }
                ],
            });

            get_table();

            function get_table(){

                $.getJSON("size_db.php", function(data){

                    $('#tableh, #tableh1, #tableh2').css({
                        "position": "sticky",
                        "background-color" : "#dedede"
                    });
                    
                    $.getJSON("table.php", function(max){
                        
                        if(temp_len == data){
                            return;
                        }
                        else{

                            var last_time = max[temp_len]["Tiempo"];
                            var last_temp = Math.floor(max[temp_len]["Temperatura"]);
                            var last_hum = Math.floor(max[temp_len]["Humedad"]);

                            change_state(last_temp,last_hum);

                            table.row.add( { 
                                "Tiempo":       last_time,
                                "Temperatura":   last_temp,
                                "Humedad":     last_hum,
                            }).draw();
    
                            $('#temp_actual').html(last_temp + "°C");
                            $('#hum_actual').html(last_hum + "%");
    
                            temp_len++; 
                        }
                    });
                });
            }
            setInterval(function(){get_table()}, 1000);
        }

        function change_state(last_temp,last_hum){
            var status_hum = 0;
            var status_temp = 0;

            $.getJSON("range.php", function(ranges){
                var temp_may = Math.floor(ranges["Tmay"]);
                var temp_min = Math.floor(ranges["Tmin"]);

                var hum_may = Math.floor(ranges["Hmay"]);
                var hum_min = Math.floor(ranges["Hmin"]);

                if((last_temp <= temp_may && last_temp >= temp_min)){
                    $('#st_temp').html("check_circle");
                    $('#st_temp').css("color","green");

                    status_temp = 1;
                }else{
                    $('#st_temp').html("cancel");
                    $('#st_temp').css("color","red");

                    status_temp = 0;
                }

                if((last_hum <= hum_may && last_hum >= hum_min)){
                    $('#st_hum').html("check_circle");
                    $('#st_hum').css("color","green");

                    status_hum = 1;
                }else{
                    $('#st_hum').html("cancel");
                    $('#st_hum').css("color","red");

                    status_hum = 0;
                }

                if(status_temp === 1 && status_hum === 1){
                    $('#state_sym').html("check_circle");
                    $('#state_sym').css("color","green");
                    $('#state_desc').html("¡Excelente! Tu alimento se encuentra en un ambiente óptimo para su conservación.");
                } else{
                    $('#state_sym').html("cancel");
                    $('#state_sym').css("color","red");
                    $('#state_desc').html("Tu alimento <strong>NO</strong> se encuentra en un ambiente óptimo para su conservación, te sugerimos cambiarlo de lugar para asegurar su calidad.");
                }

            });
            
        }
    
    
    addLoadEvent(display_date);
    addLoadEvent(graph_temperatura);
    addLoadEvent(graph_humedad);
    addLoadEvent(data_table);

    </script>

<script>
        $(function () {
            $(".nav-pill-wrap1").on("click", function () {
                $(this).addClass("pill1");
                $(".nav-pill-wrap2").removeClass("pill2");
                $(".nav-pill-wrap3").removeClass("pill3");

                $(".nav-txt1").css({"display": "inline"});
                $(".nav-txt2").css({"display": "none"});
                $(".nav-txt3").css({"display": "none"});

                $(".dash-info-wrap").css({"display": "inline"});
                $(".informacion-wrap").css({"display": "none"});
                $(".about-wrap").css({"display": "none"});
            });
        });

        $(function () {
            $(".nav-pill-wrap2").on("click", function () {
                $(this).addClass("pill2");
                $(".nav-pill-wrap1").removeClass("pill1");
                $(".nav-pill-wrap3").removeClass("pill3");

                $(".nav-txt2").css({"display": "inline"});
                $(".nav-txt1").css({"display": "none"});
                $(".nav-txt3").css({"display": "none"});

                $(".dash-info-wrap").css({"display": "none"});
                $(".informacion-wrap").css({"display": "inline"});
                $(".about-wrap").css({"display": "none"});
            });
        });

        $(function () {
            $(".nav-pill-wrap3").on("click", function () {
                $(this).addClass("pill3");
                $(".nav-pill-wrap2").removeClass("pill2");
                $(".nav-pill-wrap1").removeClass("pill1");

                $(".nav-txt3").css({"display": "inline"});
                $(".nav-txt2").css({"display": "none"});
                $(".nav-txt1").css({"display": "none"});

                $(".dash-info-wrap").css({"display": "none"});
                $(".informacion-wrap").css({"display": "none"});
                $(".about-wrap").css({"display": "inline"});
            });
        });

    </script>

</head>

<body style="background-color: var(--color-orange-200);">
<div class="general">

    <div class="nav-wrapp">

        <div class="lefnica-div1">lefnica.</div>

        <div class="links-wrap">
            <ul class="nav" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <div class="nav-pill-wrap1 pill1"><span class="material-symbols-sharp">database</span>
                        <div class="nav-txt1" style="display: inline;">Tablero</div>
                    </div>
                </li>
                <li class="dummy-li"></li>
                <li class="nav-item">
                    <div class="nav-pill-wrap2"><span class="material-symbols-sharp">info</span>
                        <div class="nav-txt2">Información</div>
                    </div>
                </li>
                <li class="dummy-li"></li>
                <li class="nav-item">
                    <div class="nav-pill-wrap3"><span class="material-symbols-sharp">group</span>
                        <div class="nav-txt3">Quiénes somos</div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="menulog" id="menu_log" style="opacity: 0;">
        <form action="" method="POST">
            <button class="logout sub-item" type="submit" name="log_out">
                <span class='material-icons-outlined'> logout </span><p class='sub-item'>Cerrar sesión</p>
            </button>
        </form>
    </div>

    <div class="center">
        <div class="rectangle-div3">
            <div class="tab1-head-wrapp">

                <div class="info-static">
                    <b id="saludo">¡Hola!</b>
                    <span class="de-noviembre-de-2022" id="date"></span>
                    <span class="de-noviembre-de-2022" id="hour"></span>
                </div>

            </div>

            <div class="dash-info-wrap">
        
                <div id="dashboard" style="display: flex;">
                    <div class="main-title">Tablero</div>
        
                    <div class="grid-dashboard">
        
                        <div class="dash-first-col">
                            <div class="dash-card-wrap">
                                <h2 class="cards-title" style="margin-top:0px">Datos del alimento</h2>

                                <div class="food-type-wrap">

                                </div>
        
                                <div class="info-desc-wrap">
                                    <div class="oneinfo-desc" style="text-align: left;">
                                        <h3 class="desc-subtitle">General</h3>
                                        
        
                                        <p class="info-dash" id="type_input">Tipo: <?php echo $category_type["Alimento"];?></p>
                                        <p class="info-dash" id="name_input">Nombre: <?php echo $name_selected;?></p>
        
                                    </div>
        
                                    <div class="oneinfo-desc">
                                        <h3 class="desc-subtitle">Ambiente ideal</h3>
                                        <p id="dummy_val" method></p>

                                        <p class="info-dash" id="temp-ideal">Temperatura: <?php echo $category_type["Temperatura_ideal_rango_mayor"];?>°C - <?php echo $category_type["Temperatura_ideal_rango_menor"];?>°C</p>
                                        <p class="info-dash" id="hum-ideal">Humedad: <?php echo $category_type["Humedad_ideal_rango_mayor"];?>% - <?php echo $category_type["Humedad_ideal_rango_menor"];?>%</p>
        
                                    </div>
                                </div>
        
                            </div>
        
                            <div class="dummy-grid-row"></div>
                            <div class="dash-card-wrap">
                                <h2 class="cards-title" style="margin-top:0px">Descripción</h2>
                                <p class="info-dash only-txt-dash">
                                    Aquí observarás un resumen gráfico y sencillo de los datos obtenidos
                                    con base en el tipo de alimento escogido previamente. <br> <br>
                                    En la tarjeta "<strong>Datos del alimento</strong>" verás los datos
                                    ingresados; en "<strong>Gráficas</strong>" observarás las gráficas de comportamiento de
                                    la temperatura y humedad con respecto del tiempo; en "<strong>Estado</strong>"
                                    podrás ver si las condiciones actuales cumplen con los estándares para su conservación; finalmente,
                                    en "<strong>Reporte en vivo</strong>" verás el historial de datos registrados por el "<strong>LEF-MCU™</strong>".
                                    <br><br><br> Para más información puedes dirigirte a la sección "<strong>Información</strong>" en la barra de navegación superior.
                                </p>
                            </div>
                        </div>
        
                        <div class="dash-second-col">
                            <h2 class="cards-title">Gráficas</h2>
                            <div class="dash-card-center-wrap">

                                <h4 class="graph-title">Temperatura vs Tiempo</h4>
                                <div id="t_chart" style="height: 80%; width: 90%;"></div>

                            </div>
                            <div class="dummy-grid-row-center"></div>
                            <div class="dash-card-center-wrap">

                                <h4 class="graph-title">Humedad vs Tiempo</h4>
                                <div id="hum_chart" style="height: 80%; width: 90%;"></div>

                            </div>
                        </div>
        
                        <div class="dash-first-col">
                            <div class="dash-card-wrap">
                                <h2 class="cards-title" style="margin: 0px 0px 0px;">Estado</h2>

                                <div class="state-info">
                                    <span class="material-symbols-outlined md-xl" style="color: red;" id="state_sym">cancel</span>
                                </div>
                                

                                <h3 class="desc-subtitle" style = "margin-top: 20px;">Pruebas de cada sensor:</h3>
                                <div class="st-wrap">
                                        <div class="state-txt"><span class="material-symbols-outlined" style="color: red; margin-right: 5px;" id="st_temp">cancel</span>Temperatura</div>
                                        <div class="dummydiv-state"></div>
                                        <div class="state-txt"><span class="material-symbols-outlined" style="color: red; margin-right: 5px;" id="st_hum">cancel</span>Humedad</div>
                                    </div>

                                    <div class="info-dash state-description" id="state_desc">Tu alimento <strong>NO</strong> se encuentra en un
                                    ambiente óptimo para su conservación, te sugerimos cambiarlo de lugar para asegurar su calidad.</div>

                            </div>
                            <div class="dummy-grid-row"></div>
                            <div class="dash-card-wrap">
                                <h2 class="cards-title" style="margin-top:0px;">Reporte en vivo</h2>

                                <div class="report-main">

                                    <div class="data-actual-wrap">
                                    <h3 class="desc-subtitle" style = "margin-top: 0px;">Temperatura</h3>
                                    <p style="font-weight: 600;" id="temp_actual"></p>
                                    </div>

                                    <div class="data-actual-wrap">
                                    <div class="dummy-div-actual" style="width: 10px;"></div>
                                    <h3 class="desc-subtitle" style = "margin-top: 0px;">Humedad</h3>
                                    <p style="font-weight: 600;" id="hum_actual"></p>
                                    </div>
                                </div>

                                <div class="table-wrap">
                                    <table class="report_table" id="data_table">
                                    <thead id="tab_head">
                                            <tr>
                                            <th id="tableh">Tiempo</th>
                                            <th id="tableh1">Temperatura</th>
                                            <th id="tableh2">Humedad</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
        
        
                            </div>
                        </div>
        
                    </div>
        
                </div>
            
            </div> <!-- End dash-wrap -->

            <div class="informacion-wrap">
                <div class="main-title">Información</div>
                    <div class="info-main">
                        <h2 class="subt-main" style="margin: 0px 0px 0px;">¿Cómo funciona mi producto lefnica.?</h2>
                        <div class="steps-wrap">
                            <div class="num-step">1</div>
                            <h3 class="step-title">Pasos iniciales</h3>
                            <p class="step-txt">Coloca tu producto "<strong>LEF-MCU™</strong>" en el lugar en donde deseas medir la temperatura y humedad del ambiente en el que se conservan tus alimentos, puede ser un contenedor, almacén, refrigerador, etc.
                                El "<strong>LEF-MCU™</strong>" comenzará a registrar los datos inmediatamente cada 3 minutos.
                            </p>
                        </div>
                        <div class="steps-wrap">
                            <div class="num-step">2</div>
                            <h3 class="step-title">Definiendo el alimento</h3>
                            <p class="step-txt">En la pestaña "<strong>Tablero</strong>" ingresa los datos requeridos del alimento que quieras evaluar. En la lista desplegable marcada como "<strong>Tipo de alimento</strong>" selecciona el tipo de alimento de dicha lista, y en la
                                caja de texto marcada como "<strong>Nombre del alimento</strong>" ingresa el nombre con el cuál lo quieres identificar. Posteriormente da clic en "<strong>Continuar</strong>", tus datos ingresados se guardarán por el transcurso de la sesión.</p>
                        </div>
                        <div class="steps-wrap">
                            <div class="num-step">3</div>
                            <h3 class="step-title">El tablero</h3>
                            <p class="step-txt">En el tablero podrás visualizar información en tiempo real del registro realizado por el "<strong>LEF-MCU™</strong>". <br>
                                <ul class="step-txt" style="margin-left: 50px;">
                                    <li style="margin-top: 10px;">En la tarjeta "<strong>Datos del alimento</strong>" observarás datos relevantes del alimento: En el apartado "<strong>General</strong>" verás el tipo y el nombre del alimento seleccionados, y en el apartado "<strong>Ambiente ideal</strong>" podrás ver los rangos de de temperatura y humedad ideales para conservar el alimento.</li>
                                    <li style="margin-top: 10px;">En la tarjeta "<strong>Gráficas</strong>" verás dos gráficas (una para temperatura y otra para humedad) actualizadas en tiempo real en donde se describe el comportamiento de la temparatura y humedad frente al tiempo para cada registro del "<strong>LEF-MCU™</strong>".</li>
                                    <li style="margin-top: 10px;">En la tarjeta "<strong>Estado</strong>" observarás un análisis del último registro del "<strong>LEF-MCU™</strong>", esta tarjeta interpretará si el alimento se encuentra en condiciones óptimas para su conservación con base en los rangos ideales definidos por el tipo de alimento ingresado.</li>
                                    <li style="margin-top: 10px;">En la tarjeta "<strong>Reporte en vivo</strong>" podrás ver los últimos valores de temperatura y humedad registrados por el "<strong>LEF-MCU™</strong>", así como una tabla con el historial de datos.</li>
                                    
                                </ul>
                        </p>
                        </div>
                        <div class="steps-wrap" style="margin-bottom: 0px;">
                            <div class="num-step">4</div>
                            <h3 class="step-title">Cambiar de alimento</h3>
                            <p class="step-txt">Para seleccionar otro tipo de alimento, da clic en "<strong>Escoger otro tipo de alimento</strong>" en la esquina superior izquierda (debajo del título "<strong>Tablero</strong>").</p>
                        </div>
                    </div>
            </div> <!-- End informacion-wrap -->

            <div class="about-wrap">
                    <div class="main-title">Quiénes somos</div>
                    <div class="info-main">

                        <div class="about-subw">
                            <div class="anim-lottie-main">
                                <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                                <lottie-player src="https://assets9.lottiefiles.com/packages/lf20_thgy1p9c.json"  background="transparent"  speed="0.7"  style="width: 500px;"  loop  autoplay></lottie-player>
                            </div>
                            <h2 class="subt-main txt-si">PRESERVANDO LA CONSERVACIÓN DE TUS ALIMENTOS</h2>
                            <h2 class="subt-main title-pm">Somos lefnica.</h2>
                            <p class="about-txt">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Similique aut tempore numquam asperiores repellat, quasi et sint pariatur, excepturi est odit officiis accusamus ipsa optio velit modi enim quas amet!</p>
                        </div>

                        <div class="team-wrap">
                            <!-- Team -->
                            <div class="team-grid">
                                <div class="dash-card-wrap card-team">
                                    <div class="img-teammate antonio"></div>
                                    <h3 class="name-team">Antonio Miranda</h3>
                                    <h4 class="rol-team">Técnico en NodeMCU</h4>
                                    
                                </div>
                                <div class="dash-card-wrap card-team">
                                    <div class="img-teammate david"></div>
                                    <h3 class="name-team">David Langarica</h3>
                                    <h4 class="rol-team">Desarrollador Full Stack</h4>
                                    
                                </div>
                                <div class="dash-card-wrap card-team">
                                    <div class="img-teammate alan"></div>
                                    <h3 class="name-team">Alan González</h3>
                                    <h4 class="rol-team">Desarrollador de base de datos</h4>
                                    <!-- <p class="step-txt">Breve descripcion de los integrantes del equipo</p>
                                    <div class="socials-team">
                                    <a href="https://www.linkedin.com/in/david-langarica/" target="_blank"><img class="socials-logo-team" src="https://cdn-icons-png.flaticon.com/512/3128/3128329.png" alt="Linkedin"/></a> -->
                                    <!-- </div> -->
                                </div>
                            </div> <!-- End team -->
                        </div>

                        <div class="about-prod">
                            <div class="desctxt">
                                <h2 class="subt-main subt-about">Desarrollo del producto</h2>
                                <p class="step-txt">El producto "LEF-MCU™" funciona con base en los principios del Internet de las cosas (IoT), Red Hat menciona que el término "hace referencia a todos los sistemas de dispositivos físicos que reciben y transfieren datos a través de redes inalámbricas con intervención humana mínima, lo cual es posible gracias a la integración de dispositivos informáticos en todo tipo de objetos". </br>
                                <br> A grandes rasgos, el "LEF-MCU™" utiliza el sensor DHT11 para medir las variables de temperatura y de humedad del ambiente, estos son enviados por el NODE MCU ESP8266 a la base de datos en MySQL y enviados a este sitio para su visualización.
                            </p>
                            </div>
                            <div style="align-items: center; justify-content: center; padding-right: 40px;">
                                <img class="product-dev" src="./public/process.png" alt="proceso"/>
                            </div>
                        </div>

                        <div class="sources step-txt">
                            <strong>Recursos empleados:</strong></br>
                            <ul>
                                <li>Center for Food Safety and Applied Nutrition. (2021, 9 febrero). ¿Está almacenando los alimentos en forma segura? U.S. Food and Drug Administration. https://www.fda.gov/consumers/articulos-para-el-consumidor-en-espanol/esta-almacenando-los-alimentos-en-forma-segura</li>
                                <li>Anaya, M. (2018, 22 marzo). Temperatura de los alimentos y Seguridad Alimentaria. Alimentos sanos y vida saludable. https://www.manipulador-de-alimentos.es/blog/temperatura-de-los-alimentos/</li>
                                <li>Red Hat. (s. f.). ¿Qué es el Internet de las cosas? https://www.redhat.com/es/topics/internet-of-things/what-is-iot</li>
                            </ul>
                        </div>
                    </div>
                </div> <!-- End about-wrap -->

        </div>

    </div>
</div>

</body>

</html>