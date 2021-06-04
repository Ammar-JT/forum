<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Channel;

class ChannelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $channels = Channel::create([
            'name' => 'Laravel 8',
            'slug' => str_slug('Laravel 8')
        ]);
        $channels = Channel::create([
            'name' => 'Vue Js 3',
            'slug' => str_slug('Vue Js 3')
        ]);
        $channels = Channel::create([
            'name' => 'Android Framework',
            'slug' => str_slug('Android Framework')
        ]);
        $channels = Channel::create([
            'name' => 'Node Js',
            'slug' => str_slug('Node Js')
        ]);
    }
}
