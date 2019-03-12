<?php
    
    session_start();
    spl_autoload_register();
    require_once('config.php');
    require_once('gconfig.php');

    // Check Requseted album id is of array type? if it is not then make it array type
    if(gettype($_REQUEST['album'])!="array")
    {
        $albums= array($_REQUEST['album'],);
        // $albums = implode(",",$str);
    }
    else
    {
        $albums = $_REQUEST["album"];
    }   

    // Fetch Specific albums detail
    foreach ($albums as $ID)
    {
        try {
            // Returns a `FacebookFacebookResponse` object
            $a=$ID;
            $get = $fb->get('/'.$a.'/photos?fields=picture,name,images&limit=100',$_SESSION['fb_access_token']);
            $getAlbum = $fb->get('/'.$a.'?fields=name,photos.limit(100){images,name,created_time}',$_SESSION['fb_access_token']);
        }catch(FacebookExceptionsFacebookResponseException $e){
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        }catch(FacebookExceptionsFacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        $graphNode = $getAlbum->getGraphEdge()->asArray();  

        // Make Temporary (UPLOAD) folder
        $tmp_dir = __DIR__.'/Upload/';
        
        // check Temporary(UPLOAD) folder is already exist or not if it is not then create new folder
        if (!is_dir($tmp_dir)) {
            mkdir($tmp_dir, 0777);
        }
    
        // Pic ALbum and fetch detail of it
        $albumId = $a;
        $album = $getAlbum->getGraphNode()->asArray();
        $albumName = $album['name'];
        $albumName = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $albumName);
        $albumName = mb_ereg_replace("([\.]{2,})", '', $albumName);    
        $path = $tmp_dir.$albumName.'/';    
        if (!is_dir($path)) {
            mkdir($path, 0777);
        }
        
        // Fetch photos of album and copy it to Upload folder
        foreach ($album['photos'] as $photo)
        {
            $file = $photo['id'].'.jpg';
            copy($photo['images'][0]['source'], $path.$file);
        }
    }


    // Pic Upload folder
    $files= array();
    $dir = dir('UPLOAD/');
    while ($file = $dir->read())
    {
        if ($file != '.' && $file != '..')
        {
            $files[] = $file;
        }
    }
    $dir->close();


    $client->setAccessToken($_SESSION['accessToken']);

    $folder_mime = "application/vnd.google-apps.folder";
    $folder_name = 'Facebook_'.$user['name'].'_Albums';

    $service = new Google_DriveService($client);
    $folder = new Google_DriveFile();

    //insert folder
    $folder->setTitle($folder_name);
    $folder->setMimeType($folder_mime);
    $newFolder = $service->files->insert($folder);

    $parentId  = $newFolder['id'];

    // Fetch files or folder from UPLOAD folder
    foreach ($files as $file_name)
    {
        $file_path = 'Upload/'.$file_name;
        if(is_dir($file_path))
        {
            //create folder
            $folder_mime = "application/vnd.google-apps.folder";
            $folder_name = $file_name;

            $service = new Google_DriveService($client);
            $folder = new Google_DriveFile();

            //insert folder
            $folder->setTitle($folder_name);
            $folder->setMimeType($folder_mime);
            

            $parent = new Google_ParentReference();
            $parent->setId($parentId);          
            $folder->setParents(array($parent));

            $newFolder = $service->files->insert($folder);

            $folderId  = $newFolder['id'];
        }

        $picture = array();
        $dir = dir($file_path.'/');

        while ($file = $dir->read())
        {
            if ($file != '.' && $file != '..')
            {
                $picture[] = $file;
            }
        }
        $dir->close();

        //upload file
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $service = new Google_DriveService($client);
        $file = new Google_DriveFile();

        if ($folderId != null) {
            $folder = new Google_ParentReference();
            $folder->setId($folderId);
            $file->setParents(array($folder));

        }

        foreach ($picture as $file_name)
        {
            $file_path1 = $file_path.'/'.$file_name;
            $mime_type = finfo_file($finfo, $file_path1);
            $file->setTitle($file_name);
            $file->setDescription('This is a '.$mime_type.' document');
            $file->setMimeType($mime_type);
            $service->files->insert(
                    $file,
                    array(
                        'data' => file_get_contents($file_path1),
                        'mimeType' => $mime_type
                    )
                );
        }
        finfo_close($finfo);
    }


    // Remove Temporary(UPLOAD) Folder from the server
    function removeRecursive($dir)
    {
        // Remove directories from the directory list
        $files = array_diff(scandir($dir), array('.','..'));

        // Delete all files one by one
        foreach ($files as $file) {
            // If current file is directory then recurse it
            (is_dir("$dir/$file")) ? removeRecursive("$dir/$file") : unlink("$dir/$file");
        }

        // Remove blank directory after deleting all files
        return rmdir($dir);
    }
    removeRecursive($tmp_dir.'/');
    
    // Redirect to home page after the task complrtation
    header('location: album.php');
?>