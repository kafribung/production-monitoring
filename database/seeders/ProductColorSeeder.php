<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $details = collect([
            'Biru',
            'Hitam',
            'Kuning',
            'Merah',
            'Hijau',
        ]);

        $details->each(function ($detail) {
            \App\Models\ProductColor::create([
                'name' => $detail,
                'created_by' => auth()->id() ?? 1,
            ]);
        });
    }
}
