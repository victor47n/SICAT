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
            ['name' => 'Habilitado', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Desabilitado', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Finalizado', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Pendente', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Atrasado', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        foreach ($status as $s)
        {
            DB::table('status')->insert($s);
        }


    }
}
