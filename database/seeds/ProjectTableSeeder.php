<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ProjectTableSeeder extends Seeder
{
    public function run()
    {
        DB::collection('projects')->delete();
        DB::collection('projects')->insert(['title' => 'Project 1']);

    }
}
