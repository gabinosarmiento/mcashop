<?php

namespace App\Console\Commands;

use App\Models\CategoryModel;
use App\Models\ErrorModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Exception;

class CategoryMenu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:menu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates category visibility for the menu based on active products with inventory.';

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

            CategoryModel::query()->update(['menu' => 0]);

            $categories = CategoryModel::where('status', 'Activo')->doesntHave('children')->get();

            foreach ($categories as $category) {
                $exists = $category->products()->has('inventory')->where('status', 'Activo')->exists();

                if ($exists) {
                    $category->update(['menu' => 1]);
                }
            }

            DB::commit();
        } catch (Exception $exception) {
            DB::rollback();

            ErrorModel::create(['tag' => 'menu', 'reference' => $this->signature, 'exception' => $exception]);
        }
    }
}
