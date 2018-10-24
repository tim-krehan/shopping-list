<?php

// We only can count up. The 4. digit is only for the internal patchlevel to trigger DB upgrades
// between betas, final and RCs. This is _not_ the public version number. Reset minor/patchlevel
// when updating major/minor version number.

$SL_Version = array(0, 2, 3, 1);

// The human readable string
$SL_VersionString = '0.2.3 alpha';

$SL_VersionCanBeUpgradedFrom = [
    'shopping-list' => [
        '0.1.0' => true,
        '0.2.0' => true,
        '0.2.1' => true,
    ],
];

// default shopping-list channel
$SL_Channel = 'git';

// The build number
$SL_Build = '';
