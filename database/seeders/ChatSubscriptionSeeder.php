<?php

namespace Database\Seeders;

use App\Models\ChatSubscription;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ChatSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ChatSubscription::create([
            'user_id'=>2,
            'transaction_no'=>'test1234',
            'expire_at'=>Carbon::now()->addMonth()
        ]);
        ChatSubscription::create([
            'user_id'=>3,
            'transaction_no'=>'test1234',
            'expire_at'=>Carbon::now()->addMonth()
        ]);
    }
}
