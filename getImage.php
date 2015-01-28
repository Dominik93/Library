<?php
    // The path where the images are stored.
    $imgLocation = 'C:/WebServ/httpd-users/covers/';
    if($_SERVER['REMOTE_ADDR'] == "::1" || $_SERVER['REMOTE_ADDR'] == "127.0.0.1")
        $imgLocation = 'C:/WebServ/httpd-users/covers/';
    else
        $imgLocation = '/home/tele-12/dslusarz/covers/';
    // This fetches a file name from the URL,
    // named "image". E.G.
    // - example.com?image=myimage.jpg
    // The "basename" function is there for
    // security, to make sure only a filename
    // is passed, not a path.
    $imgName = basename($_GET['image']);
     
    // Construct the actual image path.
    $imgPath = $imgLocation . $imgName;
    // Make sure the file exists
    if(!file_exists($imgPath) || !is_file($imgPath)) {
        header('HTTP/1.0 404 Not Found');
        die('The file does not exis1t');
    }
     
    // Make sure the file is an image
    $imgData = getimagesize($imgPath);
    if(!$imgData) {
        header('HTTP/1.0 403 Forbidden');
        die('The file you requested is not an image.');
    }
     
    // Set the appropriate content-type
    // and provide the content-length.
    header('Content-type: ' . $imgData['mime']);
    header('Content-length: ' . filesize($imgPath));
     
    // Print the image data
    readfile($imgPath);
?>

