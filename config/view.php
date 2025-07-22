<?php

namespace Config;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{
    private static ?Environment $twig = null;

    public static function getView(): Environment
    {
        if (self::$twig === null) {
            $loader = new FilesystemLoader(__DIR__ . '/../app/views');
            self::$twig = new Environment($loader, [
                'cache' => false,
                'debug' => true,
            ]);
        }

        return self::$twig;
    }
}