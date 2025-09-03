<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$kernel->bootstrap();

// Use this script to test direct database updates without model issues
$productId = 1; // Change this to the ID you're trying to update
$debugLogPath = storage_path('logs/product_db_test.log');

file_put_contents($debugLogPath, "\n\n====== DB TEST START: " . date('Y-m-d H:i:s') . " ======\n", FILE_APPEND);

try {
    // Step 1: Verify the product exists
    $product = DB::table('products')->where('id', $productId)->first();
    
    if (!$product) {
        file_put_contents($debugLogPath, "Product ID {$productId} not found!\n", FILE_APPEND);
        echo "Product not found!";
        exit;
    }
    
    file_put_contents($debugLogPath, "Found product: " . $product->name . "\n", FILE_APPEND);
    
    // Step 2: Try a minimal update with just one field
    $updateResult = DB::table('products')
        ->where('id', $productId)
        ->update([
            'name' => $product->name . ' (Updated at ' . date('H:i:s') . ')'
        ]);
    
    file_put_contents($debugLogPath, "Update result: " . ($updateResult ? "SUCCESS" : "FAILED") . "\n", FILE_APPEND);
    
    // Step 3: Verify the update happened
    $updatedProduct = DB::table('products')->where('id', $productId)->first();
    file_put_contents($debugLogPath, "Updated product name: " . $updatedProduct->name . "\n", FILE_APPEND);
    
    echo "Test completed - check " . $debugLogPath . " for results";
    
} catch (Exception $e) {
    file_put_contents($debugLogPath, "ERROR: " . $e->getMessage() . "\n", FILE_APPEND);
    file_put_contents($debugLogPath, "STACK TRACE: " . $e->getTraceAsString() . "\n", FILE_APPEND);
    echo "Error: " . $e->getMessage();
}

file_put_contents($debugLogPath, "====== DB TEST END: " . date('Y-m-d H:i:s') . " ======\n", FILE_APPEND);
