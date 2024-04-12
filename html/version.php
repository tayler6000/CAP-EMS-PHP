<?php

$version = "1.0.0-beta";
$semver_regex = "^(0|[1-9]\d*)\.(0|[1-9]\d*)\.(0|[1-9]\d*)(?:-((?:0|[1-9]\d*|\d*[a-zA-Z-][0-9a-zA-Z-]*)(?:\.(?:0|[1-9]\d*|\d*[a-zA-Z-][0-9a-zA-Z-]*))*))?(?:\+([0-9a-zA-Z-]+(?:\.[0-9a-zA-Z-]+)*))?$";
$ch = curl_init("https://api.github.com/repos/tayler6000/CAP-EMS-PHP/releases/latest");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = json_decode(curl_exec($ch), true);
curl_close($ch);

if(isset($result["tag_name"])){
    $current_version = $result["tag_name"];
    if($current_version !== $version){
        $current_version_match = preg_match($semver_regex, $current_version);
        $version_match = preg_match($semver_regex, $version);
        $current_major = (int)$current_version_match[1];
        $current_minor = (int)$current_version_match[2];
        $current_patch = (int)$current_version_match[3];
        $major = (int)$version_match[1];
        $minor = (int)$version_match[2];
        $patch = (int)$version_match[3];
        if($current_major >= $major and $current_minor >= $minor and $current_patch >= $patch){
            print("<center><span><a href='".$result["html_url"]."'>New Version Available!</a></span></center>");
        }
    }
}

?>
