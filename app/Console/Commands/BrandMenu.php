<?php

namespace App\Console\Commands;

use App\Models\BrandModel;
use App\Models\ErrorModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Exception;

class BrandMenu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'brand:menu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates brand visibility for the ecommerce menu based on active products with inventory.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            DB::beginTransaction();

            BrandModel::query()->update(['menu' => 0]);

            $brands = BrandModel::where('status', 'Activo')->get();

            foreach ($brands as $brand) {
                $exists = $brand->products()->has('inventory')->where('status', 'Activo')->exists();

                if ($exists) {
                    $brand->update(['menu' => 1]);
                }
            }

            DB::commit();
        } catch (Exception $exception) {
            DB::rollback();

            ErrorModel::create(['tag' => 'menu', 'reference' => $this->signature, 'exception' => $exception]);
        }
    }
}
