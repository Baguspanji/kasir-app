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
            'open_time' => 'jam setengah 7 pagi - jam 4 sore',
            'struk_message' => 'Terima kasih.',
            'status' => true,
            'messages' => json_encode([
                'Selamat Datang di Kasir Demo',
                'Terima Kasih Telah Menggunakan Kasir Demo',
            ]),
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
            // [
            //     'app_id' => 'app.demo.kasir',
            //     'username' => 'employee_demo',
            //     'name' => 'Employee Kasir',
            //     'email' => 'employee@demo.com',
            //     'password' => Hash::make('password'),
            //     'email_verified_at' => now(),
            //     'role' => 'employee',
            //     'status' => true,
            // ],
        ]);

        $values = [];
        foreach (['gram', 'pcs', 'liter', 'kodi', 'pack'] as $value) {
            $values[] = [
                'app_id' => 'app.demo.kasir',
                'name' => $value,
                'created_at' => now(),
            ];
        }

        DB::table('units')->insert($values);

        $items = [];
        foreach ([
            [
                'code_1' => 'BRG-001',
                'name' => 'Susu Murni',
                'unit' => '100/gram',
                'take_price' => 8000,
                'price' => 11000,
            ],
            [
                'code_1' => 'BRG-002',
                'name' => 'Kentang',
                'unit' => '100/gram',
                'take_price' => 3000,
                'price' => 4500,
            ],
            [
                'code_1' => 'BRG-003',
                'name' => 'Kopi Bubuk Dampit',
                'unit' => '100/gram',
                'take_price' => 4000,
                'price' => 5500,
            ],
            [
                'code_1' => 'BRG-004',
                'name' => 'Mie Sedap Campur',
                'unit' => '1/pack',
                'take_price' => 89000,
                'price' => 98000,
            ],
            [
                'code_1' => 'BRG-005',
                'name' => 'Sosis Ayam',
                'unit' => '1/pcs',
                'take_price' => 1500,
                'price' => 2000,
            ],
        ] as $item) {
            $items[] = array_merge([
                'app_id' => 'app.demo.kasir',
                'created_at' => now(),
            ], $item);
        }

        DB::table('items')->insert($items);
    }
}
