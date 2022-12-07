<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class() extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            CREATE TABLE IF NOT EXISTS reference.locations(
                id SERIAL PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                code VARCHAR(30) NOT NULL,
                bpscode VARCHAR(30),
                level INTEGER,
                validfrom DATE default now()::date,
                validto date,
                geom geometry(MultiPolygon,4326),
                centroid geometry(Point,4326),
                createdby INTEGER NOT NULL,
                createdon TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT now(),
                modifiedby INTEGER,
                modifiedon TIMESTAMP WITHOUT TIME ZONE,
                del BOOLEAN NOT NULL DEFAULT false,
                comment TEXT,
                geom_proj geometry(MultiPolygon,3857),
                centroid_proj geometry(Point,3857),
                temp BOOLEAN DEFAULT false,
                mendagricode VARCHAR(100)
            )
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP TABLE IF EXISTS reference.locations CASCADE');
    }
};
