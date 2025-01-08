<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    //obtener todos los pacientes
    public function index(){
        $patients = Patient::all();

        if(count($patients)>0){
            return response()->json($patients, 200);
        }
        return response()->json([], 200);
    }

    //guardar un paciente
    public function store(Request $request){
        //validando entrada de datos
        $validator = Validator::make($request->all(),[
            //reglas
            'name'=>'required|string|max:50',
            'date_born'=>'required|date_format:Y-m-d',
            'gender'=>'required|in:Masculino,Femenino',
            'address'=>'required|string',
            'phone'=>'required|digits:8|unique:patients,phone',
            'email'=>'email|nullable|unique:patients,email'
        ]);

        //validando si se rompe las reglas de entrada de datos
        if($validator->fails()){
            return response()->json([
                'message'=>'Validation Error',
                'errors'=>$validator->errors()
            ],400);
        }

        $patient = new Patient();
        $patient->name = $request->input('name');
        $patient->date_born = $request->input('date_born');
        $patient->gender = $request->input('gender');
        $patient->address = $request->input('address');
        $patient->phone = $request->input('phone');
        $patient->email = $request->input('email');
        $patient->save();

        return response()->json(['message'=>'Successfully registeres'],201);
    }
}
