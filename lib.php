<?php
include "phpCAS/CAS.php";

phpCAS::setVerbose(true);

phpCAS::client(CAS_VERSION_3_0, $cas_host, $cas_port, $cas_context);

if (file_exists($cas_server_ca_cert_path)) {
  phpCAS::setCasServerCACert($cas_server_ca_cert_path);
} else {
  phpCAS::setNoCasServerValidation();
}

phpCAS::forceAuthentication();

$login=phpCAS::getUser();

$attrs=phpCAS::getAttributes();

if (array_key_exists("eduPersonPrimaryAffiliation",$attrs)) {
  $affil=$attrs['eduPersonPrimaryAffiliation'];
} else {
  $affil="guest";
}
if (array_key_exists("displayName",$attrs)) {
  $nom=$attrs['displayName'];
} else {
  $nom=$login;
}

function echo_link($dest="", $lname="", $myid="") {
  if ($myid == "") {
    $myid=preg_replace('[^\d\w]','',$lname);
  }
  if ($lname == "") {
    $lname=$dest;
  }
  if (preg_match('/^frame /',$dest)) {
    $myuri=preg_replace('/^frame /','',$dest);
    //echo "<a class=\"framable\" onClick=\"load_frame('$myuri');\" href=\"$myuri\" target=\"_$myid\">$lname</a>\n";
    echo "<a class=\"framable\" href=\"$myuri\" target=\"_$myid\">$lname</a>\n";
  } else {
    echo "<a href=\"$dest\" target=\"_$myid\">$lname</a>\n";
  }
}
