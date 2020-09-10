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
            ],
            [
                'name' => 'Adaptadores',
            ],
            [
                'name' => 'Cabos',
            ],
            [
                'name' => 'Notebooks',
            ],
            [
                'name' => 'Periféricos',
            ],
            [
                'name' => 'Projetores',
            ],
            [
                'name' => 'Suportes',
            ],
        ];

        foreach ($types as $type){
            Type::create($type);
        }
    }
}
