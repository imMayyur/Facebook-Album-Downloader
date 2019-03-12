<?php
    session_start();
    require_once('config.php');

    // Facebook API call for Albums's Cover Photos
    $albums = [];
    $albums = $graphNode;
    $albumVar = [];
    $albumIds = '';
    foreach ($albums as $album)
    {
        $albumIds.=$album['id'].',';
        $album['cover_photo'] = getCover($album['cover_photo']['id']);
        $albumVar[] = $album;
    }   

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

    

</head>

<body>
    <style type="text/css">    
            #child{
                display: none;
            }
        </style>
    <form method="post" name="form_album" id="form_album">
    
    <!-- START NAVBAR -->
    <nav class="navbar navbar-expand-lg fixed-top custom-nav sticky">
        <div class="container">

            <!-- LOGO -->
           <a class="navbar-brand logo" href="album.php">
                <img src="images/logo.png" alt="" class="img-fluid logo-light"> 
                <img src="images/logo-dark.png" alt="" class="img-fluid logo-dark">
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <i class="mdi mdi-menu"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mx-auto">                    
                    <li class="nav-item">
                        <a href="#about" class="nav-link" data-toggle="modal" data-target="#downloadModal">Download</a>
                    </li>
                    <li class="nav-item">
                        <a href="#services" class="nav-link" data-toggle="modal" data-target="#uploadModal">Upload</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo $logoutURL; ?>" class="nav-link" >Logout</a>
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

    <!-- Start User -->
    <section class="section_all bg_cta_personal_img">
        <div class="bg_overlay_cover_on"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mt-4">
                        <div style="margin-top: 80px">
                        <a class="btn btn_outline_custom" style="color: white;cursor: pointer;"><?php echo $user['name']; ?>'s &nbsp;&nbsp;Albums</a>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End User -->

    <!-- Start Albums -->
    <section class="section_all bg_cta_personal_img" id="albums">
        <div class="bg_overlay_cover_on"></div>
        <div class="container" style="margin-top: -100px">
                <div class="row">

                <!--Loop for Displaying Albums -->
                <?php foreach ($albumVar as $album) { ?>
                <div class="col-lg-4 mt-3">
                    <div class="blog_box_contant p-2">
                        <h5 class="mb-1 font-weight-bold">
                            <a href="#" style="color: white">
                                <center><?php echo $album['name']; ?></center>
                            </a>
                        </h5>
                        <div class="blog_image">
                            <a href="album_disp.php?id=<?php echo $album['id']; ?>">
                                <img src="<?php echo $album['cover_photo']; ?>" style="height:250px; width:334px; border-radius: 15% " alt="Image" class="img-fluid d-block mx-auto" />
                            </a>
                        </div>
                        <div class="blog_box_detail mt-3">
                            <center>
                            <button type="button" class="btn btnc_custom btn_rounded_border" style="height: 35.5px;width: 45.5px;">
                                <label class="containercheckbox">
                                <input type="checkbox" class="cbalbum" name="album[]" value="<?php echo $album['id']; ?>" >
                                <span class="checkmark"></span>
                            </label></button>
                            <a href="download.php?album=<?php echo $album['id']; ?>">
                            <button type="button" class="btn btn_custom btn_rounded_border">Download</button>
                            </a>
                            <a href="upload.php?album=<?php echo $album['id']; ?>">
                            <button type="button" class="btn btn_custom btn_rounded_border">Upload</button>
                            </a>
                            </center>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <!-- Loop End -->
            </div>
        </div>
    </section>
    <!-- End Albums -->


    <!-- Start Download Modal -->
    <div class="modal fade" id="downloadModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mb-0 font-weight-bold" id="exampleModalLongTitle">Download Album(s)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class='custom_form_body'>
                        <center>
                            <div class="form-group">
                                <a name="select_download" id="select_download" style="cursor: pointer;">
                                    <button type="button" class="btn btn_custom btn_rounded_border">Download Selected Album</button>
                                </a>
                            </div>
                            <div class="form-group">
                                <a id="select_download_all" name="select_download_all" style="cursor: pointer;">
                                    <button type="button" class="btn btn_custom btn_rounded_border">Download All Album</button>
                                </a>
                            </div>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Download Modal -->

    <!-- Start Upload Modal -->
    <div class="modal fade" id="uploadModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mb-0 font-weight-bold" id="exampleModalLongTitle">Upload Album(s)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <center>
                        <div class="form-group">
                            <a id="select_upload" name="select_upload" style="cursor: pointer;">
                                <button type="button" class="btn btn_custom btn_rounded_border" data-toggle="modal" data-target="#exampleModalCenter">Upload Selected Album</button>
                            </a>
                        </div>
                        <div class="form-group">
                            <a id="select_upload_all" name="select_upload_all" style="cursor: pointer;">
                                <button type="button" class="btn btn_custom btn_rounded_border" data-toggle="modal" data-target="#exampleModalCenter">Upload All Album</button>
                            </a>
                        </div>
                    </center>
                </div>
            </div>
        </div>
    </div>
    <!-- End Upload Modal -->
    </form>

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

    <!-- JavaScripts For Checkboxes -->
    <script type="text/javascript">
        var checkboxes = document.getElementsByClassName("cbalbum");

        // Script For Download All
        $('#select_download_all').click(function(){
            var form = document.getElementById("form_album")
            form.action = "download.php";
            for(i=0;i<checkboxes.length;i++)
            {
                checkboxes[i].checked = true;
            }
            form.submit();
        });

        // Script For Upload All
        $('#select_upload_all').click(function(){
            var form = document.getElementById("form_album")
            form.action = "upload.php";
            for(i=0;i<checkboxes.length;i++)
            {
                checkboxes[i].checked = true;
            }
            form.submit();
        });

        // Script For Download
        $('#select_download').click(function(){
            var form = document.getElementById("form_album")
            form.action = "download.php";
            var count=0;
            for(i=0;i<checkboxes.length;i++)
            {
                if(checkboxes[i].checked==true)
                    count++;
            }
            if(count>0)
                form.submit();
        });

        // Script For Upload
        $('#select_upload').click(function(){
            var form = document.getElementById("form_album")
            form.action = "upload.php";
            var count=0;
            for(i=0;i<checkboxes.length;i++)
            {
                if(checkboxes[i].checked==true)
                    count++;
            }
            if(count>0)
                form.submit();
        });
    </script>

</body>
</html>