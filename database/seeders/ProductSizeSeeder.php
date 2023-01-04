<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $details = collect([
            'S',
            'M',
            'XL',
            'X2L',
            'X3L',
        ]);

        $details->each(function ($detail) {
            \App\Models\ProductSize::create([
                'name' => $detail,
                'created_by' => auth()->id() ?? 1,
            ]);
        });
    }
}
