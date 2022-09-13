<?php

use Illuminate\Support\Facades\Route;

foreach (registeredModules() as $module) {
    $path = base_path("modules/{$module}/Routes/api.php");
    if (file_exists($path)) {
        Route::group(['namespace' => "Modules\\{$module}\\Controllers\\Api"], $path);
    }
}
