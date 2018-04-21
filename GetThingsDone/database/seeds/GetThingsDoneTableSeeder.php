<?php

use Illuminate\Database\Seeder;

class GetThingsDoneTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\GetThingsDone::class, 7)->create();
    }
}
