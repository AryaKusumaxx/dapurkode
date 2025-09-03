<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    // Mark the orders migration as completed
    DB::table('migrations')->insert([
        'migration' => '2025_08_22_032925_create_orders_table',
        'batch' => 2
    ]);
    
    echo "Orders migration marked as completed successfully!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
