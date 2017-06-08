<?php

use App\Models\Person;
use Illuminate\Database\Seeder;

/**
 * Class PersonSeeder
 */
class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Person::truncate();

        factory(App\Models\Person::class, 20)->create();
    }
}
