<?php

use Illuminate\Support\Facades\Route;

foreach (registeredModules() as $module) {
    $path = base_path("modules/{$module}/Routes/web.php");
    if (file_exists($path)) {
        Route::group(['namespace' => "Modules\\{$module}\\Controllers"], $path);
    }
}