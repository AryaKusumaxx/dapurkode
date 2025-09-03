<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function testCheckoutWithoutVariantWorks()
    {
        // Create a product without variants
        $product = Product::factory()->create([
            'price' => 100000,
            'is_active' => true
        ]);

        // Create a user
        $user = User::factory()->create();
        
        // Login as the user
        $this->actingAs($user);
        
        // Make a checkout request
        $response = $this->post(route('checkout.process'), [
            'product_id' => $product->id,
            'variant_id' => null,
            'warranty_id' => null,
            'notes' => 'Test order'
        ]);
        
        // Assert redirect to payment page (successful checkout)
        $response->assertStatus(302);
        $response->assertSessionHas('success');
        
        // Check if the order was created in the database
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'status' => 'pending'
        ]);
        
        // Check if the order item was created with null variant_id
        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'product_variant_id' => null
        ]);
    }
}
