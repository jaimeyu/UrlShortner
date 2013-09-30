<?php
ob_start();
session_start();
require("database.php"); //db info
require("functions.php");
//some global variables
$errShortURL = false;

$meta = '';
$body = '';


/* Main Loop */
if (isset($_GET['u'])) { // check if we want to forward
    if (doesShortURLExist($_GET['u']) == false){
        $url = getURL($_GET['u']);
        $meta = "<meta HTTP-EQUIV=\"REFRESH\" content=\"0; url=$url\">";
        $body = "<br/>Forwarding you to the site now!<br/>
                <img src='images/loading.gif' /> <br/>"; //made w/ http://www.ajaxload.info/

        //register click
        

    }
    else {
        $meta = "<meta HTTP-EQUIV=\"REFRESH\" content=\"3; url=http://www.travvik.com/shorturl/\">";
        $body = "Sorry, the short URL you requested does not exist.<br/>
                Forwarding to the main page in 3 seconds.<br/>
                <img src='images/loading.gif' /> <br/>";
    }
}
else if ( isset($_GET['url']) == true) {
    $url = $_GET['url'];

    if ( isValidURL($url) == true ){
        if ( isDuplicateURL($url) == true) {

            $surl = findShortURL($url);
            $body = "A duplicate url was found. <br/>
                            Original URL was: <a href='$url'>$url</a> <br/>
                            Short URL is:
                        <a href='http://www.travvik.com/shorturl/$surl'>
                        http://www.travvik.com/shorturl/$surl </a><br/>";
        }
        else {
        //echo "Inserting ";
            if ( isset($_GET['short']) ==false){
                        $word = randomWord();
                    }
            else {
                        $word = $_GET['short'];
                    }

            while ( isDuplicateShortURL($word) 
                || !isShortURLValid($word) ){        /*
                 * DO NOT UNCOMMENT THIS
                         * INFINITE LOOP
                         * $word = "Rb2P";
                        echo "Stuck in a loop";*/
                $word = randomWord();
            }; //making sure short url doesn't already exist
            
            insertIntoDB($url,$word);
            $body =  "Original URL is: <a href='$url'>$url</a><br/>
                        Short URL is:
                        <a href='http://www.travvik.com/shorturl/$word'>
                        http://www.travvik.com/shorturl/$word </a><br/>";

       }
    }
    else {
        $meta = "<meta HTTP-EQUIV=\"REFRESH\" content=\"3; url=$siteLocation\">";
        $body = "The URL you supplied was not valid. <br/>
                Returning you to the main page in 3 seconds. <br/>";
    }
}
else {
        //displayForm();
        $body ="<form name='geturl' action='$siteLocation' method='get'>
        URL: <input type='text' name='url' size='100'> <br/>
        Prefered Shortened URL (No Guarantee): <input type='text' name='short' size='4' maxlength='4'> <br/>
        <input type='submit' value='Short it!'> <br/>
        </form>
    ";

    //registerClick("http://www.google.com");
    }/*
else if ($errShortURL == true) {
            $body =  "Sorry, the URL you are using does not exist. <br/>
                    We are forwarding you to the main page in 3 seconds.<br/>";
        }
else {
            $body =  "Critical Error";
}*/

//$meta = "<meta HTTP-EQUIV=\"REFRESH\" content=\"0; url=$siteLocation\">";

ob_end_flush();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php echo $meta ?>
        <title></title>
    </head>
    <body>
<?php echo $body ?>
        <br/><a href='http://www.travvik.com/shorturl/'>Return Home </a><br/>
    </body>
</html>
