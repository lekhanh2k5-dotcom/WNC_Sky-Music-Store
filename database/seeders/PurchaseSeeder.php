<?php

use Illuminate\Database\Seeder;
use App\Models\Purchase;
use App\Models\User;
use App\Models\Product;

class PurchaseSeeder extends Seeder
{
    public function run()
    {
        // Lấy user đầu tiên (admin có thể)
        $user = User::first();
        if (!$user) {
            $this->command->info('Không có user nào. Hãy tạo user trước.');
            return;
        }

        // Lấy một số products
        $products = Product::take(3)->get();
        if ($products->count() == 0) {
            $this->command->info('Không có product nào. Hãy seed products trước.');
            return;
        }

        // Tạo purchases cho user
        foreach ($products as $product) {
            Purchase::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'coins_spent' => $product->price,
                'status' => 'completed'
            ]);
        }

        $this->command->info('Đã tạo ' . $products->count() . ' purchases cho user ' . $user->name);
    }
}
