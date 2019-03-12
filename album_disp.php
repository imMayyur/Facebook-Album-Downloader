<?php

    session_start();
    require_once('config.php');

    // Facebook API For Images of Specific Album
    try {
    // Returns a `FacebookFacebookResponse` object
        $a=$_GET['id'];
        $response = $fb->get('/'.$a.'/photos?fields=picture,name,images&limit=100',$_SESSION['fb_access_token']);
        $response1 = $fb->get('/'.$a.'/?fields=name,link',$_SESSION['fb_access_token']);
    } catch(FacebookExceptionsFacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } catch(FacebookExceptionsFacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }
    $graphNode = $response->getGraphEdge()->asArray();
    $graphNode1 = $response1->getGraphNode();

?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Facebook Album Downloader</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="VBThemes" />

    <link rel="shortcut icon" href="images/favicon.png">

    <!-- Magnific-popup -->
    <link rel="stylesheet" href="css/magnific-popup.css">

    <!--Slider Css-->
    <link href="css/owl.carousel.css" rel="stylesheet">
    <link href="css/owl.theme.css" rel="stylesheet">
    <link href="css/owl.transitions.css" rel="stylesheet">

    <!-- Icon -->
    <link rel="stylesheet" type="text/css" href="css/pe-7s-icon.css" />
    <link rel="stylesheet" type="text/css" href="css/materialdesignicons.min.css" />

    <!--bootstrap Css-->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">

    <!-- JavaScripts For Slider -->
    <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="js/jssor.slider.min.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {

            var jssor_1_SlideshowTransitions = [
              {$Duration:1400,x:0.25,$Zoom:1.5,$Easing:{$Left:$Jease$.$InWave,$Zoom:$Jease$.$InSine},$Opacity:2,$ZIndex:-10,$Brother:{$Duration:1400,x:-0.25,$Zoom:1.5,$Easing:{$Left:$Jease$.$InWave,$Zoom:$Jease$.$InSine},$Opacity:2,$ZIndex:-10}},
              {$Duration:1500,x:0.5,$Cols:2,$ChessMode:{$Column:3},$Easing:{$Left:$Jease$.$InOutCubic},$Opacity:2,$Brother:{$Duration:1500,$Opacity:2}},
              {$Duration:1500,x:0.3,$During:{$Left:[0.6,0.4]},$Easing:{$Left:$Jease$.$InQuad,$Opacity:$Jease$.$Linear},$Opacity:2,$Outside:true,$Brother:{$Duration:1000,x:-0.3,$Easing:{$Left:$Jease$.$InQuad,$Opacity:$Jease$.$Linear},$Opacity:2}},
              {$Duration:1200,x:0.25,y:0.5,$Rotate:-0.1,$Easing:{$Left:$Jease$.$InQuad,$Top:$Jease$.$InQuad,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InQuad},$Opacity:2,$Brother:{$Duration:1200,x:-0.1,y:-0.7,$Rotate:0.1,$Easing:{$Left:$Jease$.$InQuad,$Top:$Jease$.$InQuad,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InQuad},$Opacity:2}},
              {$Duration:1600,x:1,$Rows:2,$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2,$Brother:{$Duration:1600,x:-1,$Rows:2,$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2}},
              {$Duration:1600,y:-1,$Cols:2,$ChessMode:{$Column:12},$Easing:{$Top:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2,$Brother:{$Duration:1600,y:1,$Cols:2,$ChessMode:{$Column:12},$Easing:{$Top:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2}},
              {$Duration:1200,y:1,$Easing:{$Top:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2,$Brother:{$Duration:1200,y:-1,$Easing:{$Top:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2}},
              {$Duration:1500,x:-0.1,y:-0.7,$Rotate:0.1,$During:{$Left:[0.6,0.4],$Top:[0.6,0.4],$Rotate:[0.6,0.4]},$Easing:{$Left:$Jease$.$InQuad,$Top:$Jease$.$InQuad,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InQuad},$Opacity:2,$Brother:{$Duration:1000,x:0.2,y:0.5,$Rotate:-0.1,$Easing:{$Left:$Jease$.$InQuad,$Top:$Jease$.$InQuad,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InQuad},$Opacity:2}},
              {$Duration:1600,x:-0.2,$Delay:40,$Cols:12,$During:{$Left:[0.4,0.6]},$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationStraight,$Assembly:260,$Easing:{$Left:$Jease$.$InOutExpo,$Opacity:$Jease$.$InOutQuad},$Opacity:2,$Outside:true,$Round:{$Top:0.5},$Brother:{$Duration:1000,x:0.2,$Delay:40,$Cols:12,$Formation:$JssorSlideshowFormations$.$FormationStraight,$Assembly:1028,$Easing:{$Left:$Jease$.$InOutExpo,$Opacity:$Jease$.$InOutQuad},$Opacity:2,$Round:{$Top:0.5}}},
              {$Duration:700,$Opacity:2,$Brother:{$Duration:1000,$Opacity:2}},
              {$Duration:1200,x:1,$Easing:{$Left:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2,$Brother:{$Duration:1200,x:-1,$Easing:{$Left:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2}}
            ];

            var jssor_1_options = {
              $AutoPlay: 1,
              $FillMode: 5,
              $SlideshowOptions: {
                $Class: $JssorSlideshowRunner$,
                $Transitions: jssor_1_SlideshowTransitions,
                $TransitionsOrder: 1
              },
              $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$
              },
              $BulletNavigatorOptions: {
                $Class: $JssorBulletNavigator$
              }
            };

            var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

            /*#region responsive code begin*/

            var MAX_WIDTH = 600;

            function ScaleSlider() {
                var containerElement = jssor_1_slider.$Elmt.parentNode;
                var containerWidth = containerElement.clientWidth;

                if (containerWidth) {

                    var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);

                    jssor_1_slider.$ScaleWidth(expectedWidth);
                }
                else {
                    window.setTimeout(ScaleSlider, 30);
                }
            }

            ScaleSlider();

            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            /*#endregion responsive code end*/
        });
    </script>

    <!-- Style For Slider -->
    <style>
        /* jssor slider loading skin spin css */
        .jssorl-009-spin img {
            animation-name: jssorl-009-spin;
            animation-duration: 1.6s;
            animation-iteration-count: infinite;
            animation-timing-function: linear;
        }

        @keyframes jssorl-009-spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }


        .jssorb072 .i {position:absolute;color:#000;font-family:"Helvetica neue",Helvetica,Arial,sans-serif;text-align:center;cursor:pointer;z-index:0;}
        .jssorb072 .i .b {fill:#fff;opacity:.3;}
        .jssorb072 .i:hover {opacity:.7;}
        .jssorb072 .iav {color:#fff;}
        .jssorb072 .iav .b {fill:#000;opacity:.5;}
        .jssorb072 .i.idn {opacity:.3;}

        .jssora073 {display:block;position:absolute;cursor:pointer;}
        .jssora073 .a {fill:#ddd;fill-opacity:.7;stroke:#000;stroke-width:160;stroke-miterlimit:10;stroke-opacity:.7;}
        .jssora073:hover {opacity:.8;}
        .jssora073.jssora073dn {opacity:.4;}
        .jssora073.jssora073ds {opacity:.3;pointer-events:none;}
    </style>

</head>

<body>

    <!-- START NAVBAR -->
    <nav class="navbar navbar-expand-lg fixed-top custom-nav sticky">
        <div class="container">

            <!-- LOGO -->
           <a class="navbar-brand logo" href="index.html">
                <img src="images/logo.png" alt="" class="img-fluid logo-light"> 
                <img src="images/logo-dark.png" alt="" class="img-fluid logo-dark">
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <i class="mdi mdi-menu"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item active">
                        <a href="album.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="download.php?album=<?php echo $a; ?>" class="nav-link" ">Download</a>
                    </li>
                    <li class="nav-item">
                        <a href="upload.php?album=<?php echo $a; ?>" class="nav-link" ">Upload</a>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link" ">Logout</a>
                    </li>
                </ul>
                <div>
                    <ul class="text-right list-unstyled list-inline mb-0 social_menu">
                        <li class="list-inline-item"><a href="#"><?php echo $user['name']; ?></a></li>
                        <li class="list-inline-item" style="pointer:none"><img src="<?php echo $img['url']; ?>" style="width:35px ;height: 35px;margin-bottom: 5px;border-radius: 50%"></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END NAVBAR -->

    <!-- Start Slider -->
    <section class="section_all bg_cta_personal_img" style="margin-top: -20px">
        <div class="bg_overlay_cover_on"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mt-4">
                        <h1 class="home_title text-white text-capitalize mb-0"><?php echo $graphNode1['name']; ?></h1>
                        <div class="home_btn_manage mt-4 pt-2">
                            <a href="<?php echo $graphNode1['link']; ?>" class="btn btn_outline_custom" style="margin-top: -40px" target="_new">View On Facebook</a>
                        </div>
                    </div>
                    <div class="text-center mt-5">
                        <div id="jssor_1" style="position:relative;margin:0 auto;top:0px;left:0px;width:900px;height:750;overflow:hidden;visibility:hidden;">
                        <!-- Loading Screen -->
                            <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
                                <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="images/spin.svg" />
                            </div>
                            <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:900px;height:750px;overflow:hidden;">

                                <!-- Loop for Images -->
                                <?php foreach ($graphNode as $album) { ?>
                                <div>
                                        <img data-u="image" src="<?php echo $album['images'][0]['source']; ?>" />
                                </div>
                                <?php } ?> 
                                <!-- End Loop        -->
                            </div>
                       
                            <!-- Arrow Navigator -->
                            <div data-u="arrowleft" class="jssora073" style="width:40px;height:50px;top:0px;left:30px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
                                <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                                    <path class="a" d="M4037.7,8357.3l5891.8,5891.8c100.6,100.6,219.7,150.9,357.3,150.9s256.7-50.3,357.3-150.9 l1318.1-1318.1c100.6-100.6,150.9-219.7,150.9-357.3c0-137.6-50.3-256.7-150.9-357.3L7745.9,8000l4216.4-4216.4 c100.6-100.6,150.9-219.7,150.9-357.3c0-137.6-50.3-256.7-150.9-357.3l-1318.1-1318.1c-100.6-100.6-219.7-150.9-357.3-150.9 s-256.7,50.3-357.3,150.9L4037.7,7642.7c-100.6,100.6-150.9,219.7-150.9,357.3C3886.8,8137.6,3937.1,8256.7,4037.7,8357.3 L4037.7,8357.3z">
                                    </path>
                                </svg>
                            </div>
                            <div data-u="arrowright" class="jssora073" style="width:40px;height:50px;top:0px;right:30px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
                                <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                                    <path class="a" d="M11962.3,8357.3l-5891.8,5891.8c-100.6,100.6-219.7,150.9-357.3,150.9s-256.7-50.3-357.3-150.9 L4037.7,12931c-100.6-100.6-150.9-219.7-150.9-357.3c0-137.6,50.3-256.7,150.9-357.3L8254.1,8000L4037.7,3783.6 c-100.6-100.6-150.9-219.7-150.9-357.3c0-137.6,50.3-256.7,150.9-357.3l1318.1-1318.1c100.6-100.6,219.7-150.9,357.3-150.9 s256.7,50.3,357.3,150.9l5891.8,5891.8c100.6,100.6,150.9,219.7,150.9,357.3C12113.2,8137.6,12062.9,8256.7,11962.3,8357.3 L11962.3,8357.3z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Slider -->

    <!--START FOOTER-->
    <footer class="footer_content bg-light">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-12">
                    <div class="text-center text-white about_social_icons">
                        <ul class="list-unstyled list-inline mb-3">
                            <li class="list-inline-item"><a href="https://www.facebook.com/programmer.mayur" target="_new"><i class="mdi mdi-facebook"></i></a></li>
                            <li class="list-inline-item"><a href="https://twitter.com/programer_mayur" target="_new"><i class="mdi mdi-twitter"></i></a></li>
                            <li class="list-inline-item"><a href="https://www.linkedin.com/in/programmer-mayur" target="_new"><i class="mdi mdi-linkedin"></i></a></li>
                        </ul>
                        <p class="text-muted mb-0">Created By <a href="https://mayyur.azurewebsites.net/Resume" target="_new">Mayur Patel </a></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--END FOOTER-->

    <!-- JAVASCRIPTS -->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!--TESTISLIDER JS-->
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/masonry.pkgd.min.js"></script>
    <script src="js/isotope.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/scrollspy.min.js"></script>
    <script src="js/jquery.easing.min.js"></script>    
    <script src="js/particles.js"></script>  
    <script src="js/particles.app.js"></script>
    <script src="js/custom.js"></script>
</body>
</html>