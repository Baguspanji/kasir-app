<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('apps')->insert([
            'id' => 'app.demo.kasir',
            'name' => 'Kasir Demo',
            'address' => 'Purwosari Pasuruan',
            'phone' => '123456789',
            'pr_name' => 'Panji',
            'status' => true,
        ]);

        DB::table('users')->insert([
            [
                'app_id' => 'app.demo.kasir',
                'username' => 'admin_demo',
                'name' => 'Admin Kasir',
                'email' => 'admin@demo.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'admin',
                'status' => true,
            ],
            [
                'app_id' => 'app.demo.kasir',
                'username' => 'employee_demo',
                'name' => 'Employee Kasir',
                'email' => 'employee@demo.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'employee',
                'status' => true,
            ],
        ]);

        $values = [];
        foreach (['Makanan', 'Minuman', 'Kopi', 'Bahan Mentah'] as $value) {
            $values[] = [
                'app_id' => 'app.demo.kasir',
                'name' => $value,
                'created_at' => now(),
            ];
        }

        DB::table('categories')->insert($values);

        $items = [];
        foreach ([
            [
                'category' => 4,
                'name' => 'Susu Murni',
                'unit' => 'gram',
                'type' => 'storage',
            ],
            [
                'category' => 4,
                'name' => 'Kentang',
                'unit' => 'gram',
                'type' => 'storage',
            ],
            [
                'category' => 4,
                'name' => 'Kopi Bubuk Dampit',
                'unit' => 'gram',
                'type' => 'storage',
            ],
            [
                'category' => 4,
                'name' => 'Mie Sedap Campur',
                'unit' => 'pcs',
                'type' => 'storage',
            ],
            [
                'category' => 4,
                'name' => 'Sosis Ayam',
                'unit' => 'pcs',
                'type' => 'storage',
            ],
        ] as $item) {
            $items[] = [
                'app_id' => 'app.demo.kasir',
                'category_id' => $item['category'],
                'name' => $item['name'],
                'unit' => $item['unit'],
                'type' => $item['type'],
                'created_at' => now(),
            ];
        }

        DB::table('items')->insert($items);
    }
}
