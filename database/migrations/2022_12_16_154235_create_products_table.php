<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('price');
            $table->smallInteger('stock_first');
            $table->smallInteger('stock_last')->nullable();
            $table->text('description');
            $table->foreignId('product_material_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('product_category_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('slug')->index()->unique();

            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
