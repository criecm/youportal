<!DOCTYPE html>
<html>
<head>
<?php include "config.php"; ?>
<title>$entitle</title>
<?php include "lib.php"; ?>
<?php include "layoutchannelpagstrucs.php"; ?>
<link type="text/css" href="css/ent.css" rel="stylesheet">
<script>//<![CDATA[

// chargement de frame et gestion de la hauteur
function load_frame(frameurl,divid,title) {
  document.getElementById('mainhead').innerHTML=title;
  document.getElementById(divid).innerHTML = '<iframe src="'+frameurl+'" id="contentframe" frameborder="0"/>';
  document.getElementById('contentframe').addEventListener("onload", resizeIframe());
  window.onresize = resizeIframe;
}

function resizeIframe() {
var height = parent.document.documentElement.clientHeight;
height -= 160;
parent.document.getElementById('contentframe').style.height = height +"px";
//console.log("height: "+height);
};


// remplace les liens href par du javascript
document.addEventListener('DOMContentLoaded',function() {
    var links = document.getElementsByClassName("framable")
    Array.prototype.forEach.call(links, function(alink) {
        dest=alink.href;
        alink.href="javascript:load_frame('"+dest+"','content','"+alink.innerHTML+"');";
        alink.removeAttribute('target');
	//console.log("modified "+alink.href);
    });
});
//]]></script>
</head>
<body>
<div id="header">
  <div id="logo">
  <a href="<?php echo $logourl ?>"><img src="<?php echo $logo; ?>"/></a>
  </div>
  <div id="welcome">
<?php if (!$login) { ?>
<a id="connexion" href="<?php echo $cas_uri; ?>/login">Connexion</a>
<?php } else { 
        if (array_key_exists("logout",$_GET)) {
          session_destroy();
	  phpCAS::logout();
        } else { ?>
    <a id="connexion" href="?logout=now">Déconnexion</a>
<?php   } ?>
  </div>
  <div id="welcometxt">Bonjour <?php echo $nom; ?>.
<?php } ?>
  </div>
</div>
<section id="apps">
  <div id="tabs">
    <ul id="tabList">
<?php foreach ($tabs as $btn1 => $b1val) { $b1id=preg_replace('/[^\w\d]/','',$btn1); ?>
      <li id="<?php echo "$b1id"; ?>">
        <?php   if (is_array($b1val)) {
          if (array_key_exists("root",$b1val)) {
            echo_link($b1val['root'],$btn1);
           } else { 
            echo_link('#',$btn1);
           } ?>
        <ul id="<?php echo "$b1id"; ?>Tabs">
<?php     foreach ($b1val as $btn2 => $b2val) { if ("$btn2" == "root") { continue; } $b2id=preg_replace('/[^\w\d]/','',$btn2); ?>
          <li id="<?php echo "$b2id"; ?>">
	    <?php echo_link($b2val,$btn2,$b2id); ?>
          </li>
<?php     } ?>
        </ul>
        <?php } else {
	  echo_link($b1val,$btn1);
        } ?>
      </li>
<?php } ?>
    </ul>
  </div>
</section>

<section id="main">
  <h2 id="mainhead">
  </h2>
  <section id="content">
    <div class="include"><?php include("content.html"); ?></div>
  </section>
</section>

  <footer>
  <a href="https://github.com/criecm/youportal">YouPortal <?php echo $version ?></a> Digital Technology Early Advanced Preview ®<?php echo (string) (int) date('Y')+1; ?>
  </footer>
</body>
</html>
