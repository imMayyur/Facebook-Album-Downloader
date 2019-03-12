<?php

    session_start();
    spl_autoload_register();
    require_once('config.php');
    
    //check that album is array or not
    if(gettype($_REQUEST['album'])!="array")
    {
        //if not make album as array
        $albums= array($_REQUEST['album'],);
    }
    else
    {
        //if then store album into albums
        $albums = $_REQUEST["album"];
    }   
    
    $access_token = $_SESSION["fb_access_token"];

    //if not exits then create temporary directory named 'Download'
    $tmp_dir = __DIR__.'/Download/';
    if (!is_dir($tmp_dir)) {
        mkdir($tmp_dir, 0777);
    }   
    
    foreach ($albums as $ID) {
        try {
            $albumid = $ID;
            $response = $fb->get('/'.$albumid.'/?fields=name',$_SESSION['fb_access_token']);
            $album = $response->getGraphNode()->asArray();
            $albumName = $album['name'];
            $albumName = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $albumName);
            $albumName = mb_ereg_replace("([\.]{2,})", '', $albumName);
            
            //fetching the images albumwise
            $access_url="https://graph.facebook.com/v3.1/".$albumid."/photos?fields=name,images%2Calbum&access_token=".$access_token;
            $result = file_get_contents($access_url);
            $pic=json_decode($result);
            $existphotokey=(array)$pic;
            $page=(array)$pic->paging;
            
            //check that paging is there or not
            if(array_key_exists("next",$page))
            {
                $access_url=$page["next"]; //if paging that set access_url to page url
            }

            //create directory inside the temp_dir('Download') having album name
            $path = $tmp_dir.$albumName.'/';
            if (!is_dir($path)) {
                mkdir($path, 0777);
            }
            //fetch image with paging
            do
            { 
                //check that paging is there or not           
                if(array_key_exists("next",$page))
                {
                    $access_url=$page["next"]; //if paging that set access_url to page url
                }
                else
                {
                    $access_url="none"; //if paging is not there then set 'none'
                }
                foreach($pic->data as $mydata)
                {
                    $image_url = $mydata->images[0]->source; //fetch image link
                    $photoId = $mydata->id; //fetch the is of album photo
                    $file = $path.$photoId.'.jpg'; //set the name of album photo as id.jpg
                    file_put_contents($file, file_get_contents($image_url));   
                }

                //if access_url is none set result to previous access_url      
                if($access_url!="none")
                {
                    $result = file_get_contents($access_url);
                }
                
                $pic=json_decode($result);
                $existphotokey=(array)$pic;
                $page=(array)$pic->paging; //set pagging link
            }while($access_url!="none");
        }catch(FacebookExceptionsFacebookResponseException $e){
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        }catch(FacebookExceptionsFacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }  
    }

    // make album zip
    $zip_name = 'FacebookAlbum.zip'; //default name of album zip
    $zip_directory = '/';
    
    //create object of zip class and pass the two parameter zip name and directory
    $zip = new zip( $zip_name, $zip_directory ); 
    $dir = 'Download';
    $zip->add_directory($dir); //add directory to zip file named 'Download'
    $zip->save(); //save the zip instance and close it

    $zip_path = $zip->get_zip_path(); //retrive the zip file path
    
    //zip configuration like type, description, length,etc.
    header( "Pragma: public" );
    header( "Expires: 0" );
    header( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
    header( "Cache-Control: public" );
    header( "Content-Description: File Transfer" );
    header( "Content-type: application/zip" );
    header( "Content-Disposition: attachment; filename=\"" . $zip_name . "\"" );
    header( "Content-Transfer-Encoding: binary" );
    header( "Content-Length: " . filesize( $zip_path ) );
    
    //read the zip file
    readfile( $zip_path );
    
    //recursively remove all directory
    $zip->removeRecursive($dir.'/');

?>