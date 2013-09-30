<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php
        require("database.php");

        $meta = "<meta HTTP-EQUIV=\"REFRESH\" content=\"5; url=short.php\">";
        if (isset($_GET['u'])){

            $fword = $_GET['u'];
            mysql_real_escape_string($fword);

            $query = "select url from links where shortURL='$fword'";
            //echo $query;

            $result = mysql_query($query);

            /*if ( mysql_num_rows($result )== 0 ) {
               $meta = "<meta HTTP-EQUIV=\"REFRESH\" content=\"5; url=short.php\">";
            //echo"no";
                
            }
            else {*/
            if (mysql_num_rows($result) > 0) {
                $result = mysql_fetch_array($result);
                $furl = $result['url'];
                $meta = "<meta HTTP-EQUIV=\"REFRESH\" content=\"0; url=$furl\">";
                //echo $meta;
            //echo "wors";
            }
            
        }
        echo $meta;
        ?>

        <title>Short URLs</title>
    </head>
    <body>
         The shortened URL you are looking for does not exist. I'm sorry for the inconvenience. <br/>
         Forwarding you to the home page in 5 seconds.<br/>
         <a href='http://www.travvik.com/shorturl/short.php'> Return Home </a><br/>
    </body>
</html>