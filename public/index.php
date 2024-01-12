<?php

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    // Crée une instance du Kernel avec les variables d'environnement
    $kernel = new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
    
    return $kernel;
};

