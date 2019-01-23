<?php

$version = json_decode(file_get_contents("version.json"), true);
// This gives:
// - $version['version']
// - $version['version_suffix']
// - $version['update_channel']

?>
