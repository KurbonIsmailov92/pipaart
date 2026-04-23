<?php

return [
    'site_name' => env('CMS_SITE_NAME', env('APP_NAME', 'PIPAA')),
    'contact' => [
        'email' => env('CONTACT_RECIPIENT_EMAIL', 'info@pipaa.tj'),
        'backup_email' => env('CONTACT_BACKUP_EMAIL', 'pipaart@mail.ru'),
        'phone' => env('CONTACT_PHONE', '+992 935 60 33 38'),
    ],
];
