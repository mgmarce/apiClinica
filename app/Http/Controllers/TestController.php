<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    //QUERY BUILDER->una herramienta para construir consultas SQL
    //ELOQUENT ORM->utiliza la sintaxis de php
    public function get_patients(){
        //QUERY BUILDER ES CON SETENCIA SQL
        DB::table('patients')->get();
        DB::table('patients')->select('*')->where('id',2)->get();
        
        //ORM ELOQUENT USA EL MODELO
        //Patient::where('gender','Femenino')->select('name','date_born')->get();
        Patient::all();//es lo mismo select
        Patient::where('id',2)->get();//es lo mismo de select where
    }
}
