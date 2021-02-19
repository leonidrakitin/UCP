<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/main.php';
$ICnews = R::getAssocRow('SELECT `id`,`date`,`text`,`author` FROM ic_news ORDER BY `id` DESC LIMIT 10');

ucp_header();
sidebar();

$new_characters_q = R::getAssocRow('SELECT * FROM users WHERE ? - create_date < (2*24*60*60)', [time()]);
$all_characters_q = R::getAssocRow('SELECT * FROM users');
$been_today_q = R::getAssocRow('SELECT * FROM users WHERE ? - last_login < (2*24*60*60)', [time()]);
$online = R::getAssocRow('SELECT * FROM users WHERE online=1');

$new_characters = count($new_characters_q);
$all_characters = count($all_characters_q);
$been_today = count($been_today_q);


$news_get= R::getRow('SELECT `link` FROM ooc_news ORDER BY id DESC LIMIT 1');
$news_path = $news_get['link'];
$forumpage = file_get_contents($news_path);

$txt_news_starts_from = '<div class="content">';
$txt_news_ends_at = '<div class="back2top">';

$txt_news_start = strpos($forumpage, $txt_news_starts_from);
$txt_news_end = strpos($forumpage, $txt_news_ends_at, $txt_news_start) - 21;

$txt_news = mb_strcut($forumpage, $txt_news_start, $txt_news_end-$txt_news_start);


$ava_news_starts_from = '<img class="avatar" src="';
$ava_news_ends_at = '" width="';

$ava_news_start = strpos($forumpage, $ava_news_starts_from)+25;
$ava_news_end = strpos($forumpage, $ava_news_ends_at, $ava_news_start);

$ava_news = mb_strcut($forumpage, $ava_news_start, $ava_news_end-$ava_news_start);


$date_author_news_starts_from = '<span class="responsive-hide"> ';
$date_author_news_ends_at = '</p>';

$date_author_news_start = strpos($forumpage, $date_author_news_starts_from)+30;
$date_author_news_end = strpos($forumpage, $date_author_news_ends_at, $date_author_news_start);

$date_author_news = mb_strcut($forumpage, $date_author_news_start, $date_author_news_end-$date_author_news_start);
$date_author_news = substr_replace($date_author_news, "http://forum.rc-rp.ru", strpos($date_author_news, "./"), 1);


$title_news_starts_from = '<h2 class="topic-title">';
$title_news_ends_at = '</h2>';

$title_news_start = strpos($forumpage, $title_news_starts_from)+24;
$title_news_end = strpos($forumpage, $title_news_ends_at, $title_news_start);

$title_news = mb_strcut($forumpage, $title_news_start, $title_news_end-$title_news_start);
$title_news = substr_replace($title_news, "http://forum.rc-rp.ru", strpos($title_news, "./"), 1);



?>

<div class="content-wrapper">
    <section class="content">
        <div class="container">
        <div class="row">
            <div class="col-lg-9 col-6">
            <div class="row">
                <!-- ./col -->
                <div class="col-lg-4 col-6">
                    <div class="info-box bg-blue">
                        <div class="inner">
                            <?php echo '<h2>'. $all_characters .'</h2>'; ?>
                            <p>CHARACTERS</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-6">
                    <div class="info-box bg-green">
                        <div class="inner">
                            <?php echo '<h2>'. $been_today .'</h2>'; ?> 
                            <p>PLAYERS TODAY</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-6">
                    <div class="info-box bg-red">
                        <div class="inner">
                            <?php echo '<h2>'. $new_characters .'</h2>'; ?>
                            <p>NEW CHARACTERS</p>
                        </div>
                        <div class="icon">
                        <i class="ion ion-person-add"></i>
                        </div>
                    </div>
                </div>
            </div>

                <div class="row">
                                                <!-- Left col -->
                    <div class="col-lg-12 col-6">
                        <div id="devNews">
                            
                            <div id="devNewsHeader"> <!--- Header -->
                                <div id="devNewsHeaderAvatar">
                                    <?php echo '<img src="'. $ava_news .'" width="50" height="50" class="ipsUserPhoto ipsUserPhoto_medium">' ?>
                                </div>
                                <div id="devNewsHeaderText">
                                    <h2>
                                        <?php echo $title_news ?>
                                    </h2>
                                    <h3>
                                        <?php echo $date_author_news ?>
                                    </h3>
                                </div>
                            </div>
                        
                            <div id="devNewsContent">  <!--- Content -->
                                <h3>
                                    <?php echo $txt_news ?>
                                </h3>
                            </div>
                            <?php echo '<a href=' . $news_path . '>' ?>
                                <div class="btn-redirect" style="text-align:center; float:right; margin-top:10px;">
                                    <div class="btnContent" style="padding:7px; float:left; width:150px; color:#fff; background-color:#fda03a;">
                                        LEARN MORE
                                    </div>
                                    <div class="btnChar" style="padding:7px; float:right; width:20px; background-color:#000; color:#fff;">&gt;</div>
                                </div>
                            </a>
                        </div>
                    </div> <!-- left col -->
                </div><!-- /.row (main row) -->
                <div class="row">
                    <div class="col-lg-4 col-6">
                            <!-- VK Widget
                            <div id="vk_groups"></div>
                            <script type="text/javascript">
                                VK.Widgets.Group("vk_groups", {mode: 3, no_cover: 1, width: "262"}, 85755564);
                            </script>-->
                        <div class="Social">
                            <!-- FaceBook Widget -->
                            <div class="fb-page" data-href="https://www.facebook.com/facebook" data-tabs="timeline" data-width="262" data-height="205" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                                <blockquote cite="https://www.facebook.com/facebook" class="fb-xfbml-parse-ignore">
                                    <a href="https://www.facebook.com/facebook">Facebook</a>
                                </blockquote>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 col-6">
                        <div id="devWheather">
                            <div id="devWheatherCity">
                                <h1>WEATHER</h1>
                                <hr style="margin: 3px;">
                                <h2>RED COUNTY</h2>
                                <h3>San Andreas, USA</h3>
                                <div id="devWheatherCelsius">
                                    <h2>26°</h2>
                                    <h3>
                                        <b>Humidity</b> 66 %<br>
                                        <b>Wind</b> 2 m/s<br>
                                        <b>Probability of precipitation</b> 66 %
                                    </h3>
                                </div>               
                            </div>
                            <div id="devWheatherImage">
                                <img src="../assets/weather_sunny.gif" height="190px">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6"> <!-- right col -->
                                        <!-- RC NEWS -->
                                        <!-- ./col -->
                <div class="row"><div class="col-lg-12 col-6">
                    <a href="../online.php"><div class="info-box bg-orange">
                        <div class="inner">
                            <?php echo '<h2>'. count($online) .'</h2>'; ?>
                            <p>PLAYERS ONLINE</p>
                        </div>
                        <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                        </div>
                    </div></a>
                </div></div>
                <div class="row"><div class="col-lg-12 col-6">
                <div id="RCNews">
                    <div id="RCNewsHeader">
                        <h2>RED COUNTY TABLOID</h2>
                        <h3>ONLINE BLOG</h3>
                    </div>
                    <div id="RCNewsContent">
                        <?php 
                            for ($i = 0; $i < count($ICnews); $i++) { 
                                echo '<h3>
                                    ' . $ICnews[$i]['text'] . '
                                    <br>
                                    <span id="author" style="color:#000; font-size:10px;">' . $ICnews[$i]['author'] . '</span>
                                    <span id="timestamp" style="color:#afafaf; padding-left:2px; font-spize:10px;">' . $ICnews[$i]['date'] . '</span>
                                </h3>';
                            }
                        ?>
                    </div>
                </div></div></div></div>
            </div><!-- right col -->    
        </div> <!-- container -->
    </section> <!--content-wrapper-->
</div> <!-- content -->
<?php echo ucp_footer() ?>
<script src="../assets/jquery.min.js"></script>
<script src="../assets/bootstrap.min.js"></script>
<script src="../assets/adminlte.min.js"></script>
<script src="../assets/demo.js"></script>
</body>
</html>