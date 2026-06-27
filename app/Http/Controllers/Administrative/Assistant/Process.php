<?php

namespace App\Http\Controllers\Administrative\Assistant;

use App\Events\AssistantProcessEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Administrative\SearchRequest;
use App\Models\CommandLogModel;
use App\Models\CommandModel;
use Illuminate\Http\Request;

class Process
{
   public function index()
   {
      $data = CommandModel::whereDate('created_at', today())->orderByDesc('id')->get()->toArray();

      return view('administrative.assistant.process.index', compact('data'));
   }

   public function execute(Request $request)
   {
      if (isset($request->label)) {
         exec("php ../artisan {$request->label} > /dev/null 2>&1 &");

         return response(['message' => "El proceso {$request->label} comenzará en breve."]);
      }
   }
}