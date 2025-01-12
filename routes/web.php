<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// chamando as rotas de forma minimizadas
foreach (File::allFIles(__DIR__.'/web') as $route_file) {
    require $route_file->getPathname();
}

require __DIR__.'/auth.php';



