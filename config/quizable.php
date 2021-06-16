<?php

return [
    'appname'                   =>    'Quizable',
    'applogo'                   =>    '/vendor/quizable/df_logo.png',
    'favico'                    =>    '/vendor/quizable/ico.png',
    'diskdriver'                =>    'public',
    'asseturl'                  =>    'https://quiz-package.test/storage/',
    'migrations_publish_path'   =>    'tenant',
    'middlewares'               =>    'web', // 'web, auth , ...' separated with comma
    'urlprefix'                 =>    'dashboard',
    'enabled_question_options'  =>    'multiple,radio,dropdown,text,file,textarea',
];
