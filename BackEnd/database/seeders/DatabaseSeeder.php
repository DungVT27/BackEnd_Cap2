<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Images;
use App\Models\PersonalTours;
use App\Models\Rooms;
use App\Models\Tours;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\TSProfile;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => "Tân",
            'email' => "tannguyen.010201@gmail.com",
            'password' => 'truongboanhai', //123456
            'phone_number' => "0999999999",
            'is_Admin' => true,
            'email_verified_at' => now(),
            'user_roles' => 'user',
            'about' => "(*_*)",
        ]);

        User::create([
            'name' => "Trường",
            'email' => "letruong02072001@gmail.com",
            'password' => 'truongboanhai', //123456
            'phone_number' => "0192197",
            'is_Admin' => false,
            'email_verified_at' => now(),
            'user_roles' => 'user',
            'about' => "Trường đầu bò ăn hại ngu si tứ tri phát triển :)",
        ]);

        UserProfile::create([
            'user_id' => 2,
            'gender' => 'female',
            'avatar' => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQElwzWmZoog_w97HKC4Birkcqac1I_z1ZJKw&usqp=CAU",
        ]);

        User::create([
            'name' => "Tân",
            'email' => "tan123@gmail.com",
            'password' => 'truongboanhai', //123456
            'phone_number' => "023428468",
            'is_Admin' => false,
            'email_verified_at' => now(),
            'user_roles' => 'user',
            'about' => "Solo yasuo?",
        ]);

        UserProfile::create([
            'user_id' => 3,
            'gender' => 'male',
            'avatar' => "https://cdn2.vectorstock.com/i/1000x1000/47/61/web-developer-design-vector-6584761.jpg",
        ]);

        User::create([
            'name' => "Vũ",
            'email' => "vu123@gmail.com",
            'password' => 'truongboanhai', //123456
            'phone_number' => "02936942",
            'is_Admin' => false,
            'email_verified_at' => now(),
            'user_roles' => 'ts',
            'about' => "Your will, my hand",
        ]);

        TSProfile::create([
            'user_id' => 4,
            'avatar' => "https://haycafe.vn/wp-content/uploads/2021/12/hinh-anh-anime-nam-1.jpg",
        ]);

        User::create([
            'name' => "Hằng",
            'email' => "hang123@gmail.com",
            'password' => 'truongboanhai', //123456
            'phone_number' => "02349294",
            'is_Admin' => false,
            'email_verified_at' => now(),
            'user_roles' => 'ts',
            'about' => "Solo ys?",
        ]);

        TSProfile::create([
            'user_id' => 5,
            'avatar' => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRrmlMm8jN0GqRjo2L9b6OBtm8gJbJS9cIZfw&usqp=CAU",
        ]);

        Rooms::create([
            'room_owner' => 2,
            'name' => "Phòng đi bay",
            'description' => "Không bay không ngủ",
            'image' => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTPKXglM8hw473nI64ggSKgk5sjIlThRlAyag&usqp=CAU",
        ]);

        User::factory(10)->create([
            'user_roles' => 'user'
        ]);
        
        User::factory(10)->create([
            'user_roles' => 'ts'
        ]);

        UserProfile::factory(10)->create();
        TSProfile::factory(10)->create();
        Rooms::factory(20)->create();

        Tours::create([
            'ts_id' => 1,
            'name' => "Đà Nẵng Tour",
            'address' => "Huế",
            'description'=> "Tour giá hạt dẻ",
            'from_date' => "2023-05-10",
            'to_date' => "2023-05-14",
            'price' => 1000000,
            'slot' => 10,
        ]);

        Tours::create([
            'ts_id' => 2,
            'name' => "Huế Tour",
            'address' => "Hồ Chí Minh",
            'description'=> "Tour giá rẻ",
            'from_date' => "2023-05-10",
            'to_date' => "2023-05-14",
            'price' => 10000000,
            'slot' => 10,
        ]);

        Tours::create([
            'ts_id' => 3,
            'name' => "Hồ Chí Minh Tour",
            'address' => "Hồ Chí Minh",
            'description'=> "Tour giá đắt",
            'from_date' => "2023-05-10",
            'to_date' => "2023-05-14",
            'price' => 1000000000,
            'slot' => 10,
        ]);

        Tours::create([
            'ts_id' => 4,
            'name' => "Hồ Chí Minh Tour",
            'address' => "Hồ Chí Minh",
            'description'=> "Tour giá đắt",
            'from_date' => "2023-05-10",
            'to_date' => "2023-05-14",
            'price' => 1000000000,
            'slot' => 10,
        ]);

        Tours::create([
            'ts_id' => 5,
            'name' => "Hồ Chí Minh Tour",
            'address' => "Hồ Chí Minh",
            'description'=> "Tour giá đắt",
            'from_date' => "2023-05-10",
            'to_date' => "2023-05-14",
            'price' => 1000000000,
            'slot' => 10,
        ]);

        PersonalTours::create([
            'name' => "Chuyến đi đến Đà Nẵng",
            'owner_id' => 2,
            'room_id' => 1,
            'description' => "Tham quan Đà Nẵng",
            'from_date' => "2023-05-10",
            'to_date' => "2023-05-14",
            'lat' => "1,91823912",
            'lon' => "103,212133",
            'from_where' => "Huế",
            'to_where' => "Đà Nẵng",
            'image' => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTPKXglM8hw473nI64ggSKgk5sjIlThRlAyag&usqp=CAU",
        ]);

        PersonalTours::create([
            'name' => "Chuyến đi đến Huế",
            'owner_id' => 3,
            'room_id' => 1,
            'description' => "Tham quan Huế",
            'from_date' => "2023-05-10",
            'to_date' => "2023-05-14",
            'lat' => "1,6213213",
            'lon' => "103,16123561",
            'from_where' => "Hồ Chí Minh",
            'to_where' => "Huế",
            'image' => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTPKXglM8hw473nI64ggSKgk5sjIlThRlAyag&usqp=CAU",
        ]);

        PersonalTours::create([
            'name' => "Chuyến đi đến Hà Nội",
            'owner_id' => 4,
            'room_id' => 2,
            'description' => "Tham quan Hà Nội",
            'from_date' => "2023-05-10",
            'to_date' => "2023-05-14",
            'lat' => "1,512313",
            'lon' => "103,123123",
            'from_where' => "Vinh",
            'to_where' => "Hà Nội",
            'image' => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTPKXglM8hw473nI64ggSKgk5sjIlThRlAyag&usqp=CAU",
        ]);
        
        Images::factory(20)->create();
    }
}
