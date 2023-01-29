<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $details = collect([
            'Jeans',
            'Kaos',
            'Sekolah',
            'Jas',
        ]);

        $details->each(function ($detail) {
            \App\Models\Category::create([
                'name' => $detail,
                'created_by' => auth()->id() ?? 1,
            ]);
        });
    }
}
