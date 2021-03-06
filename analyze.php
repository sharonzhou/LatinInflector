<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="keywords" lang="en" content="Latin, language, inflect, inflection, conjugate, conjugation, decline, declension, Catholic, Catholicism" xml:lang="en" />
  <meta name="keywords" lang="la" content="Lingua, Latina" xml:lang="la" />
  <meta name="description" lang="en" content="Inflect (conjugate or decline) words in Latin phrases." xml:lang="en" />
  <style type="text/css">
/*<![CDATA[*/
  #box{float:left;text-align:center;margin:10px;}#lemma{font-size:150%;}select{text-align:center;background:white;}a:link{color:black;text-decoration:none}a:visited{text-decoration:none}a:hover{color:blue;text-decoration:underline}
  /*]]>*/
  </style>

  <title>Latin Inflector Output</title>
</head>

<body>
  <script type="text/javascript">
//<![CDATA[
  function definePopup(word) {
        void window.open("http://www.perseus.tufts.edu/hopper/morph?la=la&l="+word,"Lewis & Short","width="+screen.width*0.75+",height="+screen.height*0.75+",screenX="+screen.width*0.125+"px,screenY="+screen.height*0.125+"px,scrollbars=1,resizable=1,toolbar=0");
  }
  //]]>
  </script>

  <h3><span id="status"></span></h3><?php
              function printFloatBox($word){ 
                      $sansLigaturesEtc = iconv("utf-8", "us-ascii//TRANSLIT", $word); //remove ligatures
		      $wordForPerseus = preg_replace("/[^A-Z^a-z]/", "", $sansLigaturesEtc); //remove non-alpha
                      $simple = file_get_contents("http://www.perseus.tufts.edu/hopper/xmlmorph?lang=la&lookup=".$wordForPerseus) or die('<script type="text/javascript">document.getElementById("status").innerHTML=\'<font color="red">Cannot reach Perseus server</font>\';</script>');
                      $p = xml_parser_create(); 
                      xml_parse_into_struct($p, $simple, $vals, $index); 
                      xml_parser_free($p); 
                      $str = "";
                      $strarray = array();
                      foreach ($vals as $value) {
                              if ($value["level"]==3) {
                                      if ($value["tag"]!="FORM" && $value["tag"]!="LEMMA" && $value["tag"]!="EXPANDEDFORM" && !is_null($value["value"])) {
                                              $str = $str.$value["value"]." ";
                                      } else {
                                              $strarray[] = trim($str);
                                              $str = "";
                                      }
                              }
                      }
                      $strarray = array_filter($strarray);
                      $strarray = array_unique($strarray);
                      //Print it out
                      $pos_as_html = '<div id="box"><select>';
                      foreach ($strarray as $elem)
                              $pos_as_html = $pos_as_html."<option>".$elem."</option>";
                      $pos_as_html = $pos_as_html.'</select><div id="lemma"><a href="javascript:definePopup(\''.$wordForPerseus.'\')">'.$word."</a></div></div>";
                      print $pos_as_html;
              }
              
              if ($_POST['thetext']!="") {
                      print '<script type="text/javascript">document.getElementById("status").innerHTML=\'<font color="blue">Processing...</font>\';</script>';
                      flush(); ob_flush();
                      $wordsarray = preg_split("/\s+/",$_POST['thetext']);
                      foreach ($wordsarray as $word) {
                              printFloatBox($word);
                      }
                      print '<script type="text/javascript">document.getElementById("status").innerHTML=\'\';</script>';
              } else
	  die('<script type="text/javascript">document.getElementById("status").innerHTML=\'<font color="red">No Latin phrase entered</font>\';parent.document.getElementById(\'thetext\').focus();</script>');
              ?><script type="text/javascript">
//<![CDATA[
  var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
  document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
  //]]>
  </script><script type="text/javascript">
//<![CDATA[
  try {
        var pageTracker = _gat._getTracker("UA-11314314-2");
        pageTracker._trackPageview();
  } catch(err) {}
  //]]>
  </script>
</body>
</html>
