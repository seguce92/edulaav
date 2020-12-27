<?php 

return [

    'sigla'         =>  'UESA',
    'name'          =>  'Unidad Educativa Albert Einsten',
    'logo'          =>  'https://edulaav.test/logo.png',
    'description'   =>  'Lorem ipsun lo logorium parse to minium',

    'service'   =>  [
        'api'       =>  'https://edulaav.test/',
        'assets'    =>  'https://edulaav.test/',
        'vtoken'    =>  '7a2bfeb0-a6cc-11ea-bb37-0242ac130002',
    ],

    'db' =>   [
        'delete'        =>  true,
        'forceDelete'   =>  true
    ],

    'ui'    =>  [
        'markdown'  =>  true,
        'videoroom' =>  true
    ],

    'filemanager'   =>  [
        'byUser'        =>  true,
        'maxFilesize'   =>  '10', // MB,
        'maxFiles'      =>  '5',
        'acceptedFiles' =>  'image/png,image/jpg,image/gif,application/pdf,.doc,.docx,.xls,.xlsx'
    ]
];