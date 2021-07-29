<?php

$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

return [
        'mode'              => 'ja+aCJK',
        'format'            => 'A4',
        'default_font_size' => '12',
        'margin_left'       => 0,
        'margin_right'      => 0,
        'margin_top'        => 0,
        'margin_bottom'     => 0,
        'margin_header'     => 0,
        'margin_footer'     => 0,
        'orientation'       => 'L',
        'fontDir'           => array_merge($fontDirs, [base_path('resources/fonts')]),
        'fontdata'          => $fontData + [
                        'ipaexg' => [
                                'R' => 'ipaexg.ttf',
                        ],
                ],
];
