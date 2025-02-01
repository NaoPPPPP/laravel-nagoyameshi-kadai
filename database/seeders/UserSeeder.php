<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 既存のデータを削除
        User::truncate();
        
        $user = new User();
        $user->name = "太郎";
        $user->kana = "タロウ";
        $user->email = 'tarou@example.com';
        $user->email_verified_at = Carbon::now();
        $user->password = Hash::make('password');
        $user->postal_code = "0000000";
        $user->address = "東京都";
        $user->phone_number = "000-0000-0000";
        $user->save();
        
        // 新しいデータを作成
        User::factory()->count(100)->create();
    }
}
