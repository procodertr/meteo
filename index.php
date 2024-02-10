<!DOCTYPE html>
<?php

include ('vericek.php');
// URL Veri Çekme Fonkisyonu
function curlRequest($url) {
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, $url);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($c);
    curl_close($c);
    return $data;
}

function durumgetir($durum) {
    if($durum == "Snow"){
        echo "Kar Yağışlı";
    }else if($durum == "Cloudy"){
        echo "Bulutlu";
    }else if($durum == "Partly Cloudy"){
        echo "Parçalı Bulutlu";
    }else if($durum == "Clear"){
        echo "Hava Açık";
    }else if($durum == "Fog"){
        echo "Sisli";
    }else if($durum == "Rain"){
        echo "Yağmur Yağışlı";
    }else{
        echo $durum;
    }
}
function Yagistipi($tur) {
    if($tur == "partly-cloudy-day"){
        echo "assets/svg/hava/parcalibulutlu.svg";
    }elseif($tur == "cloudy"){
        echo "assets/svg/hava/bulutlu.svg";
    }elseif($tur == "snow"){
        echo "assets/svg/hava/kar.svg";
    }elseif($tur == "clear-day"){
        echo "assets/svg/hava/acikhava.svg";
    }elseif($tur == "clear-night"){
        echo "assets/svg/hava/acikgece.svg";
    }elseif($tur == "rain"){
        echo "assets/svg/hava/yagmur.svg";
    }elseif($tur == "sleet"){
        echo "assets/svg/hava/sulukar.svg";
    }elseif($tur == "wind"){
        echo "assets/svg/hava/ruzgar.svg";
    }elseif($tur == "fog"){
        echo "assets/svg/hava/Sis.svg";
    }elseif($tur == "partly-cloudy-night"){
        echo "assets/svg/hava/parcalibulutlugece.svg";
    }
}

$gunler= array(

    0=>"Pazar",
    1=>"Pazartesi",
    2=>"Salı",
    3=>"Çarşamba",
    4=>"Perşembe",
    5=>"Cuma",
    6=>"Cumartesi"

);


$url = "https://dev.pirateweather.net/forecast/sOG996wVXq25GXXkFYCvB3mfWp2vIWxy2ZLr0RD4/39.95605560076559,33.09458616473921"; // Api Url
$json = curlRequest($url);
$weatherinforaw = json_decode($json, true);
$nowhissedilen = (($weatherinforaw['currently']['apparentTemperature'] - 32) * 5) / 9; // Fahrenheit, Celsius Çevirme
$nowhissedilen = round($nowhissedilen, 2);
$nowtemp = (($weatherinforaw['currently']['temperature'] - 32) * 5) / 9; // Fahrenheit, Celsius Çevirme
$nowtemp = round($nowtemp, 2);
$ruzgaryonu = $weatherinforaw['currently']['windBearing'];
$donmanoktasi = round((($weatherinforaw['currently']['dewPoint'] - 32) * 5) / 9,2); // Fahrenheit, Celsius Çevirme
$nemorani = $weatherinforaw['currently']['humidity'] * 100;
$durum = $weatherinforaw['currently']['summary'];
$ruzgarhizi = round($weatherinforaw['currently']['windSpeed'],2) ;
$aniruzgarlar = round($weatherinforaw['currently']['windGust'],2) ;
$bulutorani = $weatherinforaw['currently']['cloudCover'] * 100;
$gorusmesafesi = $weatherinforaw['currently']['visibility'];
$guncelicon = $weatherinforaw['currently']['icon'];
$uvindex = $weatherinforaw['currently']['uvIndex'];
$ozonorani = $weatherinforaw['currently']['ozone'];
date_default_timezone_set('Asia/Istanbul');

for($i=1;$i<=6; $i++){
$saatlikicon[$i] = $weatherinforaw['hourly']['data'][$i]['icon'];
$saatlikderece[$i] = round((($weatherinforaw['hourly']['data'][$i]['temperature'] - 32) * 5) / 9,2); // Fahrenheit, Celsius Çevirme
$saatliksaat[$i] = date("H:i",$weatherinforaw['hourly']['data'][$i]['time']);
$saatlikdurum[$i] = $weatherinforaw['hourly']['data'][$i]['summary'];
}

for($i=1;$i<=6; $i++){
    $gunlukicon[$i] = $weatherinforaw['daily']['data'][$i]['icon'];
    $gunlukdereceyuksek[$i] = round((($weatherinforaw['daily']['data'][$i]['temperatureHigh'] - 32) * 5) / 9,2); // Fahrenheit, Celsius Çevirme
    $gunlukderecedusuk[$i] = round((($weatherinforaw['daily']['data'][$i]['temperatureLow'] - 32) * 5) / 9,2); // Fahrenheit, Celsius Çevirme
    $gunluksaat[$i] = date("w",$weatherinforaw['daily']['data'][$i]['time']);
    $gunlukdurum[$i] = $weatherinforaw['daily']['data'][$i]['summary'];
    $gunlukruzgaryonu[$i]  = $weatherinforaw['daily']['data'][$i]['windBearing'];
    $gunluknem[$i] = $weatherinforaw['daily']['data'][$i]['humidity']* 100;
    $gunlukruzgarhizi[$i] = round($weatherinforaw['daily']['data'][$i]['windSpeed'],2);
}




?>

<html
  lang="tr"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="assets/"
  data-template="horizontal-menu-template-starter"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>FY Sistem - Hava Durumu</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons -->
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="assets/vendor/fonts/tabler-icons.css" />
    <link rel="stylesheet" href="assets/vendor/fonts/flag-icons.css" />

      <!-- Harita -->
    <link href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" rel="stylesheet"/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <!-- Core CSS -->
    <link rel="stylesheet" href="assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="assets/vendor/libs/node-waves/node-waves.css" />
	<link rel="stylesheet" href="assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="assets/js/config.js"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
      <div class="layout-container">
        <!-- Navbar -->

        <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
          <div class="container-xxl">
            <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
              <a href="index.html" class="app-brand-link gap-2">
                <span class="app-brand-logo demo">
                  <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                      fill="#7367F0"
                    />
                    <path
                      opacity="0.06"
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z"
                      fill="#161616"
                    />
                    <path
                      opacity="0.06"
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z"
                      fill="#161616"
                    />
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                      fill="#7367F0"
                    />
                  </svg>
                </span>
                <span class="app-brand-text demo menu-text fw-bold">FY Sistem - Hava Durumu</span>
              </a>

              <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
                <i class="ti ti-x ti-sm align-middle"></i>
              </a>
            </div>

            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="ti ti-menu-2 ti-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <div class="navbar-nav align-items-center">
                <a class="nav-link style-switcher-toggle hide-arrow" href="javascript:void(0);">
                  <i class="ti ti-sm"></i>
                </a>
              </div>

              
            </div>
          </div>
        </nav>

        <!-- / Navbar -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Menu -->
            <aside id="layout-menu" class="layout-menu-horizontal menu-horizontal menu bg-menu-theme flex-grow-0">
              <div class="container-xxl d-flex h-100">
                <ul class="menu-inner py-1">
                  <!-- Page -->
                  <li class="menu-item active">
                    <a href="#" class="menu-link">
                      <i class="menu-icon tf-icons ti ti-smart-home"></i>
                      <div data-i18n="Page 1">Lalahan</div>
                    </a>
                  </li>
                </ul>
              </div>
            </aside>
            <!-- / Menu -->

            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="row ">
                    <!-- Line Area Chart -->
                    <div class="col-xl-4 mb-4 col-lg-12 col-12">
                        <div class="row">
                            <!-- Expenses -->
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div id="expensesChart"></div>
                                        <div class="mt-md-2 text-center mt-lg-3 mt-3">
                                            <h5 class="card-title mb-0">Güncel Durum</h5>
                                            <img src="<?php Yagistipi($guncelicon); ?>" width="30%">
                                            <div class="row"><div style="text-align: center;"><h3><?php echo $sicaklik[0];?> °C</h3></div></div>
                                            <h6 class="text-center"><?php durumgetir($durum); ?></h6>
                                            <div class="row"><div style="text-align: center;">Hissedilen : <b><?php echo $nowhissedilen;?></b> °</div></div>
                                            <div class="row"><div style="text-align: center;">Donma Noktası : <b><?php echo $donmanoktasi;?></b> °</div></div>
                                            <div class="row"><div style="text-align: center;">Nem Oranı : %<b><?php echo $nemorani;?></b></div></div>
                                            <div class="row"><br></div>
                                            <div class="row"><b><div style="text-align: center;">Rüzgar Bilgisi</div></b></div>
                                            <img src="assets/svg/hava/yon.svg" style="transform: rotate(<?php echo $ruzgaryonu; ?>deg);" width="10%">
                                            <div class="row"><div style="text-align: center;">Rüzgar Hızı : <b><?php echo $ruzgarhizi; ?></b> km/s</div></div>
                                            <div class="row"><div style="text-align: center;">Ani Rüzgar Hızı : <b><?php echo $aniruzgarlar; ?></b> km/s</div></div>
                                            <div class="row"><br></div>
                                            <div class="row"><b><div style="text-align: center;">Diğer Bilgiler</div></b></div>
                                            <div class="row"><div style="text-align: center;">Bulut Oranı : %<b><?php echo $bulutorani; ?></b></div></div>
                                            <div class="row"><div style="text-align: center;">Görüş Mesafesi : <b><?php echo $gorusmesafesi; ?> km</b></div></div>
                                            <div class="row"><div style="text-align: center;">UV İndeksi : <b><?php echo $uvindex; ?></b></div></div>
                                            <div class="row"><div style="text-align: center;">Ozon Tabakası : <b><?php echo $ozonorani; ?> DU</b></div></div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ Expenses -->
                        </div>
                    </div>

                    <!-- Revenue Report -->
                    <div class="col-12 col-xl-8 mb-4 col-lg-7">
                        <div style="row">
                            <div class="col-xl-12 mb-4 col-md-12">
                                <div class="card">
                                    <div class="card-header pb-3">
                                        <h5 class="m-0 me-2 card-title">Saatlik Durum</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row row-bordered g-0">
                                            <?php for($i=1;$i<=6; $i++){ ?>
                                            <div class="col-md-2">
                                                <h5 class="text-center"><span class="fw-bold"><?php echo $saatliksaat[$i]; ?></h5>
                                                <div class="text-center mt-1">
                                                    <img src="<?php Yagistipi($saatlikicon[$i]); ?>" width="30%">
                                                </div>
                                                <h5 class="text-center"><?php echo $ilerisicak[$i-1]; ?> °</h5>
                                                <h6 class="text-center"><?php durumgetir($saatlikdurum[$i]); ?></h6>

                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 mb-4 col-md-12">
                                <div class="card">
                                    <div class="card-header pb-3">
                                        <h5 class="m-0 me-2 card-title">Günlük Durum</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row row-bordered g-0">
                                            <?php for($i=1;$i<=6; $i++){ ?>
                                                <div class="col-md-2">
                                                    <h5 class="text-center"><span class="fw-bold"><?php echo  $gunler[$gunluksaat[$i]]; ?></h5>
                                                    <div class="text-center mt-1">
                                                        <img src="<?php Yagistipi($gunlukicon[$i]); ?>" width="30%">
                                                    </div>
                                                    <h5 class="text-center" ><font color="#008b8b"> <?php echo $gunlukderecedusuk[$i]; ?> °</font>&nbsp;&nbsp;&nbsp;<font color="#ff6347"> <?php echo $gunlukdereceyuksek[$i]; ?> °</font></h5>
                                                    <h6 class="text-center"><?php durumgetir($gunlukdurum[$i]); ?></h6>
                                                    <div class="text-center">Nem: %<?php echo $gunluknem[$i]; ?></div>
                                                    <div class="text-center mt-4">
                                                        <img src="assets/svg/hava/yon.svg" style="transform: rotate(<?php echo $gunlukruzgaryonu[$i]; ?>deg);" width="20%">
                                                    </div>
                                                    <div class="text-center"><?php echo $gunlukruzgarhizi[$i]; ?> km/s</div>

                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                        <div class="row">
                            <!-- Line Area Chart -->
                            <div class="col-12 mb-4">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between">
                                        <div>
                                            <h5 class="card-title mb-0">Radar Görüntüsü</h5>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                        <div id="mapid" style="height: 400px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <div class="row">
                    <!-- Line Area Chart -->
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title mb-0">GFS Diyagramı</h5>
                                </div>
                            </div>
                            <div class="card-body">
                                <center><a href="https://www.wetterzentrale.de/de/ens_image.php?geoid=117679&var=201&model=gfs&member=ENS&bw=0"><img src="https://www.wetterzentrale.de/de/ens_image.php?geoid=117679&var=201&model=gfs&member=ENS&bw=0" width="80%"></a></center>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">

                        <!-- Line Area Chart -->
                        <div class="col-12 mb-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div>
                                        <h5 class="card-title mb-0">ECMWF Diyagramı</h5>
                                    </div>
                                </div>
                                <div class="card-body" style="alignment: center">
                                    <center><a href="https://www.wetterzentrale.de/de/ens_image.php?geoid=117679&var=201&model=ecm&member=ENS&bw=0"><img src="https://www.wetterzentrale.de/de/ens_image.php?geoid=117679&var=201&model=ecm&member=ENS&bw=0" width="80%"></a></center>
                                </div>
                            </div>
                        </div>
                </div>
                    <div class="row">

                        <!-- Line Area Chart -->
                        <div class="col-12 mb-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div>
                                        <h5 class="card-title mb-0">Güncel Basınç Haritası</h5>
                                    </div>
                                </div>
                                <div class="card-body" style="alignment: center">
                                    <center><a href="https://www.meteociel.fr/cartes_obs/pression2_eur2.png"><img src="https://www.meteociel.fr/cartes_obs/pression2_eur2.png" width="80%"></a></center>
                                </div>
                            </div>
                        </div>
                </div>

            </div>
            <!--/ Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl">
                <div
                  class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column"
                >
                  <div>
                    ©
                    <script>
                      document.write(new Date().getFullYear());
                    </script>
                    , Furkan YILDIRIM
                  </div>
                  <div>

                  </div>
                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!--/ Content wrapper -->
        </div>

        <!--/ Layout container -->
      </div>
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>

    <!--/ Layout wrapper -->

    <!-- Radar JS -->

        <script>
            var map = L.map('mapid').setView([39.95605560076559, 33.09458616473921], 8);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attributions: ''
            }).addTo(map);

            /**
             * RainViewer radar animation part
             * @type {number[]}
             */
            var apiData = {};
            var mapFrames = [];
            var lastPastFramePosition = -1;
            var radarLayers = [];

            var optionKind = 'radar'; // can be 'radar' or 'satellite'

            var optionTileSize = 256; // can be 256 or 512.
            var optionColorScheme = 2; // from 0 to 8. Check the https://rainviewer.com/api/color-schemes.html for additional information
            var optionSmoothData = 1; // 0 - not smooth, 1 - smooth
            var optionSnowColors = 1; // 0 - do not show snow colors, 1 - show snow colors

            var animationPosition = 0;
            var animationTimer = false;

            var loadingTilesCount = 0;
            var loadedTilesCount = 0;

            function startLoadingTile() {
                loadingTilesCount++;
            }
            function finishLoadingTile() {
                // Delayed increase loaded count to prevent changing the layer before
                // it will be replaced by next
                setTimeout(function() { loadedTilesCount++; }, 250);
            }
            function isTilesLoading() {
                return loadingTilesCount > loadedTilesCount;
            }

            /**
             * Load all the available maps frames from RainViewer API
             */
            var apiRequest = new XMLHttpRequest();
            apiRequest.open("GET", "https://api.rainviewer.com/public/weather-maps.json", true);
            apiRequest.onload = function(e) {
                // store the API response for re-use purposes in memory
                apiData = JSON.parse(apiRequest.response);
                initialize(apiData, optionKind);
            };
            apiRequest.send();

            /**
             * Initialize internal data from the API response and options
             */
            function initialize(api, kind) {
                // remove all already added tiled layers
                for (var i in radarLayers) {
                    map.removeLayer(radarLayers[i]);
                }
                mapFrames = [];
                radarLayers = [];
                animationPosition = 0;

                if (!api) {
                    return;
                }
                if (kind == 'satellite' && api.satellite && api.satellite.infrared) {
                    mapFrames = api.satellite.infrared;

                    lastPastFramePosition = api.satellite.infrared.length - 1;
                    showFrame(lastPastFramePosition, true);
                }
                else if (api.radar && api.radar.past) {
                    mapFrames = api.radar.past;
                    if (api.radar.nowcast) {
                        mapFrames = mapFrames.concat(api.radar.nowcast);
                    }

                    // show the last "past" frame
                    lastPastFramePosition = api.radar.past.length - 1;
                    showFrame(lastPastFramePosition, true);
                }
            }

            /**
             * Animation functions
             * @param path - Path to the XYZ tile
             */
            function addLayer(frame) {
                if (!radarLayers[frame.path]) {
                    var colorScheme = optionKind == 'satellite' ? 0 : optionColorScheme;
                    var smooth = optionKind == 'satellite' ? 0 : optionSmoothData;
                    var snow = optionKind == 'satellite' ? 0 : optionSnowColors;

                    var source = new L.TileLayer(apiData.host + frame.path + '/' + optionTileSize + '/{z}/{x}/{y}/' + colorScheme + '/' + smooth + '_' + snow + '.png', {
                        tileSize: 256,
                        opacity: 0.01,
                        zIndex: frame.time
                    });

                    // Track layer loading state to not display the overlay
                    // before it will completelly loads
                    source.on('loading', startLoadingTile);
                    source.on('load', finishLoadingTile);
                    source.on('remove', finishLoadingTile);

                    radarLayers[frame.path] = source;
                }
                if (!map.hasLayer(radarLayers[frame.path])) {
                    map.addLayer(radarLayers[frame.path]);
                }
            }

            /**
             * Display particular frame of animation for the @position
             * If preloadOnly parameter is set to true, the frame layer only adds for the tiles preloading purpose
             * @param position
             * @param preloadOnly
             * @param force - display layer immediatelly
             */
            function changeRadarPosition(position, preloadOnly, force) {
                while (position >= mapFrames.length) {
                    position -= mapFrames.length;
                }
                while (position < 0) {
                    position += mapFrames.length;
                }

                var currentFrame = mapFrames[animationPosition];
                var nextFrame = mapFrames[position];

                addLayer(nextFrame);

                // Quit if this call is for preloading only by design
                // or some times still loading in background
                if (preloadOnly || (isTilesLoading() && !force)) {
                    return;
                }

                animationPosition = position;

                if (radarLayers[currentFrame.path]) {
                    radarLayers[currentFrame.path].setOpacity(0);
                }
                radarLayers[nextFrame.path].setOpacity(100);


                var pastOrForecast = nextFrame.time > Date.now() / 1000 ? 'FORECAST' : 'PAST';

                document.getElementById("timestamp").innerHTML = pastOrForecast + ': ' + (new Date(nextFrame.time * 1000)).toString();
            }

            /**
             * Check avialability and show particular frame position from the timestamps list
             */
            function showFrame(nextPosition, force) {
                var preloadingDirection = nextPosition - animationPosition > 0 ? 1 : -1;

                changeRadarPosition(nextPosition, false, force);

                // preload next next frame (typically, +1 frame)
                // if don't do that, the animation will be blinking at the first loop
                changeRadarPosition(nextPosition + preloadingDirection, true);
            }

            /**
             * Stop the animation
             * Check if the animation timeout is set and clear it.
             */
            function stop() {
                if (animationTimer) {
                    clearTimeout(animationTimer);
                    animationTimer = false;
                    return true;
                }
                return false;
            }

            function play() {
                showFrame(animationPosition + 1);

                // Main animation driver. Run this function every 500 ms
                animationTimer = setTimeout(play, 500);
            }

            function playStop() {
                if (!stop()) {
                    play();
                }
            }

            /**
             * Change map options
             */
            function setKind(kind) {
                optionKind = kind;
                initialize(apiData, optionKind);
            }


            function setColors() {
                var e = document.getElementById('colors');
                optionColorScheme = e.options[e.selectedIndex].value;
                initialize(apiData, optionKind);
            }


            /**
             * Handle arrow keys for navigation between next \ prev frames
             */
            document.onkeydown = function (e) {
                e = e || window.event;
                switch (e.which || e.keyCode) {
                    case 37: // left
                        stop();
                        showFrame(animationPosition - 1, true);
                        break;

                    case 39: // right
                        stop();
                        showFrame(animationPosition + 1, true);
                        break;

                    default:
                        return; // exit this handler for other keys
                }
                e.preventDefault();
                return false;
            }
        </script>
    <!-- Radar JS -->


    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="assets/vendor/libs/jquery/jquery.js"></script>
    <script src="assets/vendor/libs/popper/popper.js"></script>
    <script src="assets/vendor/js/bootstrap.js"></script>
    <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="assets/vendor/libs/node-waves/node-waves.js"></script>

    <script src="assets/vendor/libs/hammer/hammer.js"></script>

    <script src="assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <!-- Main JS -->
    <script src="assets/js/main.js"></script>

    <!-- Page JS -->

  </body>
</html>
