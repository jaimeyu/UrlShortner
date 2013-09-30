<?php
//function calls (maybe change to class later?)


function isDuplicateURL($curl) {

      mysql_real_escape_string($curl);

      $query = "select * from links where url='$curl'";
      $result = mysql_query($query) or die(' error ' . mysql_error());

      if (mysql_num_rows($result) > 0) {
          return true;
      }
      else {
             return false;
          }
      }

 function isValidCharacters($wordB){
    $failchar=false;
    $max = strlen($wordB);
            for ($var=0; $var < $max;$var++){
                if (preg_match('/^[a-z]|[A-Z]|[0-9]/',$wordB[$var]) == false){
                    $failchar=true;}
            }
            if ($failchar == false)
               return true;
            else
                return false;
          }

function isShortURLValid($word) {
    if ( strlen($word) == 4){
            if (isValidCharacters($word) == true)
               return true;
            else
                return false;
            /*$failchar=false;
            $max = strlen($word);
            for ($var=0; $var < $max;$var++){
                if (preg_match('/^[a-z]|[A-Z]|[0-9]/',$word[$var]) == false){
                    $failchar=true;}
            }
            if ($failchar == false)
               return true;
            else
                return false;*/
          }
    else {
        return false;
    }
}
function isDuplicateShortURL($sword) {
          $query = "select * from links where shorturl='$sword'";
          $result = mysql_query($query) or die(' error ' . mysql_error());

          if (mysql_num_rows($result) > 0) {
              return true;
          }
          else {
              return false;
          }
}
/*
function isValidURL($url) {
    //http://www.webdeveloper.com/forum/archive/index.php/t-11290.html
    if (preg_match("/^(http:\/\/{1})((\w+\.){1,})\w{2,}$/i", $url)) {
        return true;
        }
    else {
        return false;
        }
}
*/
function randomWord() {

    $alphanum = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    //26+26+10 = 62 characters
    //words of 8 char lengths
    //62^4 combinations = 14776336 combinations

    $word = '';

    for ($tmpvar = 0; $tmpvar <4; $tmpvar++) {
        $rand = rand(0,61);
        $word .= $alphanum[$rand];
        //echo "wat $alphanum[$rand]     <br/>$word";
    }
    return $word;

}

function insertIntoDB($iurl, $iword) {
    mysql_real_escape_string($iurl);
    $today = date('Y-m-d');
    $query = "insert into links(url,shorturl,date) values ('$iurl','$iword','$today') ";
    mysql_query($query) or die("can't insert:" . mysql_error());
}

function displayForm() {

    $html =
    "
        <form name='geturl' action='$siteLocation' method='get'>
        URL (requires 'http'): <input type='text' name='url'> <br/>
        <input type='submit' value='Short it!'> <br/>
        </form>
    ";

    echo $html;


}
function fwdpage($fword){

    $query = "select url from links where shortURL=$fword";
    $result = mysql_query($query);
    if ( mysql_num_rows($result != 1) )
        $meta = "<meta HTTP-EQUIV=\"REFRESH\" content=\"0; url=error.html\">";
    else {
        $result = mysql_fetch_array($result);
        $furl = $result['url'];
        $meta = "<meta HTTP-EQUIV=\"REFRESH\" content=\"0; url=$furl\">";
    }
}

function findShortURL($surl) {

    $query = "select shortURL from links where url='$surl'";
    mysql_real_escape_string ($query);
    $result = mysql_query($query);
    $result = mysql_fetch_array($result);
    return $result['shortURL'];
}

function doesShortURLExist($fword){


            //$fword = $_GET['u'];
            mysql_real_escape_string($fword);

            $query = "select url from links where shortURL='$fword'";

            $result = mysql_query($query) or die('Failed  query: ' . mysql_error());

            if (mysql_num_rows($result) > 0) {
                /*$result = mysql_fetch_array($result);
                $furl = $result['url'];
                $meta = "<meta HTTP-EQUIV=\"REFRESH\" content=\"0; url=$furl\">";
*/
                return false;
            }
            else {
                /*$meta = "<meta HTTP-EQUIV=\"REFRESH\" content=\"3; url=index.php\">";
                //$errShortURL = true;
*/              return true;
            }
            //return $meta;
}
function getURL($shortURL) {
    mysql_real_escape_string($shortURL);

            $query = "select url from links where shortURL='$shortURL'";

            $result = mysql_query($query) or die('Failed  query: ' . mysql_error());

            if (mysql_num_rows($result) > 0) {
                $result = mysql_fetch_array($result);
                $furl = $result['url'];
                //$meta = "<meta HTTP-EQUIV=\"REFRESH\" content=\"0; url=$furl\">";

                return $furl;
            }
            else {
                /*$meta = "<meta HTTP-EQUIV=\"REFRESH\" content=\"3; url=index.php\">";
                //$errShortURL = true;
*/              return "Error";
            }
}

function isValidURL($vurl) {
    //from http://www.weberdev.com/get_example-4227.html
    if ( preg_match("/^[a-zA-Z]+[:\/\/]+[A-Za-z0-9\-_]+\\.+[A-Za-z0-9\.\/%&=\?\-_]+$/i",$vurl) ==true)
        return true;
    else
        return false;
}


function registerClick($surl){
    $now = date('Y-m-d');
    $ip = $_SERVER['REMOTE_ADDR'];
    $location = fopen("http://api.hostip.info/get_html.php?ip=$ip");
    //$location = preg_split("/[\s,]+/", $location);
    //echo;
    echo $location;
    $query = "insert into clicks (date, city,state,country) values () ";
}
?>
