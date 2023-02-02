<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $details = collect([
            ['name' => 'Biru', 'hexa' => '#3159b3', 'created_by' => auth()->id() ?? 1],
            ['name' => 'Hitam', 'hexa' => '#3159b3', 'created_by' => auth()->id() ?? 1],
            ['name' => 'Kuning', 'hexa' => '#3159b3', 'created_by' => auth()->id() ?? 1],
            ['name' => 'Merah', 'hexa' => '#3159b3', 'created_by' => auth()->id() ?? 1],
            ['name' => 'Hijau', 'hexa' => '#3159b3', 'created_by' => auth()->id() ?? 1],
        ]);

        $details->each(function ($detail) {
            \App\Models\Color::create($detail);
        });
    }
}
