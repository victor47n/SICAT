<?php

use App\Status;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            ['name' => 'Atrasado'],
            ['name' => 'Devolvido'],
            ['name' => 'Emprestado'],
            ['name' => 'Finalizado'],
            ['name' => 'Pendente'],
        ];

        foreach ($status as $s)
        {
            Status::create($s);
        }


    }
}
