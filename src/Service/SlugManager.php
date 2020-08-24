<?php

namespace App\Service;

class SlugManager
{
    public function slugThis($string)
    {
        $slug = strtolower(trim(
            preg_replace(
                '/[\s-]+/',
                '-',
                preg_replace(
                    '/[^A-Za-z0-9-]+/',
                    '-',
                    preg_replace(
                        '/[&]/',
                        'and',
                        preg_replace(
                            '/[\']/',
                            '',
                            iconv('UTF-8', 'ASCII//TRANSLIT', $string)
                        )
                    )
                )
            ),
            '-'
        ));

        return $slug;
    }
}
