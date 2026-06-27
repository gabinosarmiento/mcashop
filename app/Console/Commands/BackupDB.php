<?php

namespace App\Console\Commands;

use App\Console\BaseCommand;

class BackupDB extends BaseCommand
{
   /**
    * The label of the console command.
    *
    * @var string
    */
   protected $label = 'Respaldo DB';

   /**
    * The name and signature of the console command.
    *
    * @var string
    */
   protected $signature = 'backup:db {id?}';

   /**
    * The console command description.
    *
    * @var string
    */
   protected $description = 'Command to generate a database backup once per day';

   /**
    * Create a new command instance.
    *
    * @return void
    */
   public function __construct()
   {
      parent::__construct();
   }

   /**
    * Execute the console command.
    *
    * @return mixed
    */
   public function handle()
   {
      $code = 0;

      $this->total = 1;

      $id = $this->argument('id');

      $command = $this->startCommand($id, 'Ejecutando backup de la base de datos');

      $storage = sprintf('/var/bups/dbase/dbmcashop_%s.sql', date('dmY'));

      $cmd = sprintf(
         'mysqldump -h%s -P%s -u%s -p%s %s > %s',
         escapeshellarg(env('DB_HOST')),
         escapeshellarg(env('DB_PORT')),
         escapeshellarg(env('DB_USERNAME')),
         escapeshellarg(env('DB_PASSWORD')),
         escapeshellarg(env('DB_DATABASE')),
         escapeshellarg($storage)
      );

      system($cmd, $code);

      if ($code !== 0) {
         $this->stopCommand($command, 'Backup falló al ejecutar mysqldump', null, 'Fallido');
      }

      $this->checkCommand($command);

      $this->completeCommand($command);
   }

}