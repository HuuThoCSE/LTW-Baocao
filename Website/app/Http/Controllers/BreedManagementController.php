<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BreedManagementController extends Controller
{
    public function getView()
    {
        return view('breed-management',[]);
    }
    public function up()
{
    
    Schema::create('breed_goats', function (Blueprint $table) {
        $table->id('breed_id'); // Tạo khóa chính với auto increment
        $table->string('breed_origin', 100)->nullable(); // breed_origin, varchar(100), cho phép null
        $table->string('breed_size', 255)->nullable(); // breed_size, varchar(255), cho phép null
        $table->string('breed_color', 100)->nullable(); // breed_color, varchar(100), cho phép null
        $table->string('breed_characteristics', 255)->nullable(); // breed_characteristics, varchar(255), cho phép null
        $table->string('breed_note', 255)->nullable(); // breed_note, varchar(255), cho phép null
        $table->timestamps(); // created_at và updated_at
    });
}
}
