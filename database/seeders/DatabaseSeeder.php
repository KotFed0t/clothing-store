<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//         \App\Models\User::factory(10)->create();
//
//         \App\Models\User::factory()->create([
//             'name' => 'Test User',
//             'email' => 'test@example.com',
//         ]);

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'Slayvi555@gmail.com',
            'password' => bcrypt('Admin12345*'),
            'email_status' => 'verified',
            'phone' => '89995479234',
            'google_auth_secret' => 'Z563CDHHXNVY6RTY'
        ]);

        DB::table('roles')->insert([
            ['name' => 'admin'],
            ['name' => 'manager'],
            ['name' => 'support']
        ]);

        DB::table('statuses')->insert([
            ['name' => 'Не оформлен'],
            ['name' => "Оформлен"],
            ['name' => "комплектуется"],
            ['name' => "передан в доставку"],
            ['name' => "доставлен"],
            ['name' => "возврат"]
        ]);

        DB::table('role_user')->insert([
            'role_id' => 1,
            'user_id' => 1
        ]);

        DB::table('categories')->insert([
            ['name' => "Куртки", 'code' => "jacket"],
            ['name' => "Футболки", 'code' => "t-shirts"],
            ['name' => "Брюки", 'code' => "pants"],
            ['name' => "Свитеры", 'code' => "sweaters"],
            ['name' => "Пальто", 'code' => "coat"]
        ]);

        DB::table('products')->insert([
            'category_id' => 2,
            'name' => 'Футболка',
            'code' => 't-shirt-1',
            'price' => 2100,
            'gender' => 'man'
        ]);

        DB::table('properties')->insert([
            ['name' => "материал"],
            ['name' => "цвет"],
            ['name' => "бренд"],
            ['name' => "размер"]
        ]);

        DB::table('values')->insert([
            ['property_id' => 1, 'name' => "кожа"],
            ['property_id' => 2, 'name' => "черный"],
            ['property_id' => 2, 'name' => "белый"],
            ['property_id' => 1, 'name' => "хлопок"],
            ['property_id' => 2, 'name' => "синий"],
            ['property_id' => 2, 'name' => "красный"],
            ['property_id' => 2, 'name' => "желтый"],
            ['property_id' => 2, 'name' => "фиолетовый"],
            ['property_id' => 1, 'name' => "шерсть"],
            ['property_id' => 1, 'name' => "синтетика"],
            ['property_id' => 3, 'name' => "Cookie"],
            ['property_id' => 3, 'name' => "Deseo"],
            ['property_id' => 3, 'name' => "Ellips"],
            ['property_id' => 4, 'name' => "S"],
            ['property_id' => 4, 'name' => "M"],
            ['property_id' => 4, 'name' => "L"],
            ['property_id' => 4, 'name' => "XL"],
            ['property_id' => 4, 'name' => "XXL"]
        ]);

        DB::table('product_value')->insert([
            ['product_id' => 1, 'value_id' => 4],
            ['product_id' => 2, 'value_id' => 2],
            ['product_id' => 3, 'value_id' => 12],
            ['product_id' => 4, 'value_id' => 16],
            ['product_id' => 4, 'value_id' => 17],
        ]);

    }
}
