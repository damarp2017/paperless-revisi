<?php

use App\Employee;
use App\Store;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Store::create([
            'id' => 'STR-000001',
            'name' => 'Toko Damar',
            'store_logo' => 'https://res.cloudinary.com/damarp2017/image/upload/v1607499791/default/store_qnl6rf.png',
            'code' => 'KdeDMR',
            'phone' => '+628996308805',
            'address' => 'Jalan Sunan Kalijaga No 17, Kaligangsa Wetan, Brebes',
            'owner_id' => '2012000001'
        ]);

        Employee::create([
            'id' => IdGenerator::generate(['table' => 'employees', 'length' => 10, 'prefix' =>'EMP-']),
            'store_id' => 'STR-000001',
            'api_token' => 'L4CwtSMOlCvyU43HVkgvQdDoMc4ovNUDsPyj5z4WS3DDcHIaslKfbzyVWiNARYmo32F9vqGvNjt8CXMr',
            'username' => "staff@KdeDMR",
            'password' => Hash::make("12345678"),
            'role' => Employee::$ROLESTAFF,
        ]);

        Employee::create([
            'id' => IdGenerator::generate(['table' => 'employees', 'length' => 10, 'prefix' =>'EMP-']),
            'store_id' => 'STR-000001',
            'api_token' => 'isQJld7QE7tpuIAjfXZ0CCAA9OiZI7DBPU64ypqGm4XLu8lRaThQUMwXnsYMwjYOTP3hRvu7N74yvdQI',
            'username' => "cashier@KdeDMR",
            'password' => Hash::make("12345678"),
            'role' => Employee::$ROLECASHIER,
        ]);

        Store::create([
            'id' => 'STR-000002',
            'name' => 'Toko Prieyuda',
            'store_logo' => 'https://res.cloudinary.com/damarp2017/image/upload/v1607499791/default/store_qnl6rf.png',
            'code' => 'KodYDH',
            'phone' => '+628996308808',
            'address' => 'Jalan Karang Djati',
            'owner_id' => '2012000002'
        ]);

        Employee::create([
            'id' => IdGenerator::generate(['table' => 'employees', 'length' => 10, 'prefix' =>'EMP-']),
            'store_id' => 'STR-000002',
            'api_token' => '8VUZ7c6Z3iV3jlrm2M5e8aGlW4G28jTvi4yraWCmpCQdTRYa4ctkcXMRE5nt41ouCbzUVJ27Sh8QL18R',
            'username' => "staff@KdeYDH",
            'password' => Hash::make("12345678"),
            'role' => Employee::$ROLESTAFF,
        ]);

        Employee::create([
            'id' => IdGenerator::generate(['table' => 'employees', 'length' => 10, 'prefix' =>'EMP-']),
            'store_id' => 'STR-000002',
            'api_token' => 'TwF02EfLkdUE8DnGxFIgU89c7hcow33x2LXWHIAk8FJVQYYHUhZEtC66USyjuamr9yVoVrLd3Ll1OV6R',
            'username' => "cashier@KdeYDH",
            'password' => Hash::make("12345678"),
            'role' => Employee::$ROLECASHIER,
        ]);
    }
}
