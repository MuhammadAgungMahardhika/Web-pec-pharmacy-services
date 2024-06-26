<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csv = Reader::createFromPath(database_path('csv/product.csv'), 'r');
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords();

        foreach ($records as $record) {
            DB::table('products')->insert([
                'code' => $record['code'],
                'name' => $record['name'],
                'description' => $record['description'],
                'price' => $record['price'],
                'stock_quantity' => $record['stock_quantity'],
            ]);
        }
    }
}
