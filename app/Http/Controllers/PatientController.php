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

        return response()->json(['message'=>'Successfully registered'],201);
    }

    //obtener paciente por id
    public function patient_by_id($id){
        $validator = Validator::make(['id'=>$id],[
            'id'=>'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json([
                'message'=>'Validation Error',
                'errors'=>$validator->errors()
            ],400);
        }

        //Patient::where('id',$id)->get();//query builder + orm
        $patient = Patient::find($id);//me puede devolver: {}, null
        if($patient !=null){
            return response()->json($patient,200);
        }
        return response()->json(['message'=>'Patient not found'],404);
    }

    //metodo para actualizar un paciente
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'name'=>'required|string|max:50',
            'address'=>'required|string',
            'phone'=>'required|digits:8',
            'email'=>'email|nullable'
        ]);

        //validando si se rompe las reglas de entrada de datos
        if($validator->fails()){
            return response()->json([
                'message'=>'Validation Error',
                'errors'=>$validator->errors()
            ],400);
        }

        $patient = Patient::find($id);
        $patient->name = $request->input('name');
        $patient->address = $request->input('address');
        $patient->phone = $request->input('phone');
        $patient->email = $request->input('email');
        $patient->update();

        return response()->json(['message'=>'Successfully updated'],200);
    }
}
