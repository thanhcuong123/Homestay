<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy email người dùng cuối cùng trong cơ sở dữ liệu (nếu có)


        // Tạo danh sách người dùng
        $list = [];

        // Người dùng mẫu 1
        $row1 = [
            'name' => 'Danh Thanh Cường',
            'email' => 'cuong123456@gmail.com', // Sử dụng email mới
            'phone' => '0964094074',
            'address' => 'Hà Nội',
            'gender' => 'Nam',
            'password' => Hash::make('123456'), // Mã hóa mật khẩu
            'role' => 'admin', // Quyền là admin
            'created_at' => now(),
            'updated_at' => now()
        ];

        array_push($list, $row1);

        // Có thể thêm nhiều người dùng khác vào danh sách nếu cần
        $row2 = [
            'name' => 'Danh Thanh ',
            'email' => 'cuong555@gmail.com', // Sử dụng email mới
            'phone' => '0964094024',
            'address' => 'Hà Nội',
            'gender' => 'Nam',
            'password' => Hash::make('123456'), // Mã hóa mật khẩu
            'role' => 'user', // Quyền là admin
            'created_at' => now(),
            'updated_at' => now()
        ];
        array_push($list, $row2);

        // Chèn danh sách người dùng vào cơ sở dữ liệu
        DB::table('users')->insert($list);
    }
}
