<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$settings = App\Models\Setting::getSettings();
echo "From DB: \n";
print_r($settings->toArray());

Auth::loginUsingId(1);

$page = app()->make(App\Filament\Pages\ManageSettings::class);
$page->mount();

echo "\nFrom Livewire Data: \n";
echo json_encode($page->data, JSON_PRETTY_PRINT);
