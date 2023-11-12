<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class ImportData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:data {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from file to database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = $this->argument('file');
        if(file_exists($filePath)){
            $fileExt = pathinfo($filePath,PATHINFO_EXTENSION);

            switch ($fileExt) {
                case 'xml':
                    $this->handleXMLFile($filePath);
                    break;
                default:

            }
        }else{
            Log::channel('datafeedlog')->error('File path does not exist.');
        }

    }

    private function handleXMLFile(string $xmlPath): void
    {
        $xmlObj = simplexml_load_file($xmlPath);
        $itemData = [];
        foreach ($xmlObj->item as $item) {
            $itemData[] = [
                    'entity_id' => (int)$item->entity_id,
                    'category_name' => (string)$item->CategoryName,
                    'sku' => (string)$item->sku,
                    'name' => (string)$item->name,
                    'description' => (string)$item->description,
                    'short_desc' => (string)$item->shortdesc,
                    'price' => (float)$item->price,
                    'link' => (string)$item->link,
                    'image' => (string)$item->image,
                    'brand' => (string)$item->Brand,
                    'rating' => (int)$item->Rating,
                    'caffeine_type' => (string)$item->CaffeineType,
                    'count' => (int)$item->Count,
                    'flavored' => (string)$item->Flavored,
                    'seasonal' => (string)$item->Seasonal,
                    'in_stock' => (string)$item->Instock,
                    'facebook' => (int)$item->Facebook,
                    'is_KCup' => (int)$item->IsKCup,
            ];
            $this->insertIntoItemsTable($itemData);
        }
        $this->info('Data from XML file imported to DB successfully.');
    }

    public function cleanPriceVal(float $price): string
    {
        return number_format($price, 2, '.', '');
    }

    /**
     * @return void
     */
    public function insertIntoItemsTable(Array $item): void
    {
        try {
            DB::table('items')->insert([
                'entity_id' => $item->entity_id,
                'category_name' => $item->CategoryName,
                'sku' => $item->sku,
                'name' => $item->name,
                'description' => $item->description,
                'short_desc' => $item->shortdesc,
                'price' => $this->cleanPriceVal($item->price),
                'link' => $item->link,
                'image' => $item->image,
                'brand' => $item->Brand,
                'rating' => $item->Rating,
                'caffeine_type' => $item->CaffeineType,
                'count' => $item->Count,
                'flavored' => $item->Flavored,
                'seasonal' => $item->Seasonal,
                'in_stock' => $item->Instock,
                'facebook' => $item->Facebook,
                'is_KCup' => $item->IsKCup,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::channel('datafeedlog')->error('Error inserting into items table:', $e->getMessage());
    }

    }
}
