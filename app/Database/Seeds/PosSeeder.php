<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PosSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $this->db->table('users')->insert([
            'username' => 'admin',
            'full_name' => 'System Administrator',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'avatar' => null,
            'created_at' => $now
        ]);

        $this->db->table('customers')->insertBatch([
            [
                'full_name' => 'Ana Santos',
                'email' => 'ana@example.com',
                'phone' => '09171234567',
                'created_at' => $now
            ],
            [
                'full_name' => 'Mark Reyes',
                'email' => 'mark@example.com',
                'phone' => '09181234567',
                'created_at' => $now
            ],
            [
                'full_name' => 'Liza Cruz',
                'email' => 'liza@example.com',
                'phone' => '09191234567',
                'created_at' => $now
            ],
            [
                'full_name' => 'John Garcia',
                'email' => 'john@example.com',
                'phone' => '09201234567',
                'created_at' => $now
            ],
            [
                'full_name' => 'Maria Dela Cruz',
                'email' => 'maria@example.com',
                'phone' => '09211234567',
                'created_at' => $now
            ]
        ]);

        $this->db->table('products')->insertBatch([
            [
                'name' => 'Iced Coffee',
                'price' => 95.00,
                'stock_quantity' => 25,
                'image' => null,
                'created_at' => $now
            ],
            [
                'name' => 'Chicken Sandwich',
                'price' => 150.00,
                'stock_quantity' => 15,
                'image' => null,
                'created_at' => $now
            ],
            [
                'name' => 'French Fries',
                'price' => 85.00,
                'stock_quantity' => 30,
                'image' => null,
                'created_at' => $now
            ],
            [
                'name' => 'Chocolate Cake',
                'price' => 180.00,
                'stock_quantity' => 10,
                'image' => null,
                'created_at' => $now
            ],
            [
                'name' => 'Fresh Lemonade',
                'price' => 75.00,
                'stock_quantity' => 20,
                'image' => null,
                'created_at' => $now
            ]
        ]);
    }
}