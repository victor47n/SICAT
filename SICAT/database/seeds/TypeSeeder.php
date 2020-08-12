<?php

use App\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'name' => 'Acessórios',
                'status_id' => 1
            ],
            [
                'name' => 'Adaptadores',
                'status_id' => 1
            ],
            [
                'name' => 'Cabos',
                'status_id' => 1
            ],
            [
                'name' => 'Periféricos',
                'status_id' => 1
            ],
            [
                'name' => 'Suportes',
                'status_id' => 1
            ],
        ];

        foreach ($types as $type){
            Type::create($type);
        }
    }
}
