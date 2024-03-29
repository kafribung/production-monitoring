<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $details = collect([
            'Cotton Combed',
            'Cottun Carded',
            'Viscose',
            'Spandex',
            'Polyester',
            'Chief Value Cotton',
            'Cutton Bamboo',
            'Rayon',
            'Hyget',
        ]);

        $details->each(function ($detail) {
            \App\Models\Material::create([
                'name' => $detail,
                'created_by' => auth()->id() ?? 1,
            ]);
        });
    }
}
