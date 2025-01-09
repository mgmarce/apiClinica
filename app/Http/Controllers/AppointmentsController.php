<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AppointmentsController extends Controller
{
    public function store(Request $request){
        //validando entrada de datos
        $validator = Validator::make($request->all(),[
            'patient_id'=>'required|exists:patients,id',
            'user_id'=>'required|exists:users,id',
            //validando que la fecha de la cita debe ser posterior a la actual
            'date_appointment'=>'required|date_format:Y-m-d|after_or_equal:today',
            'time_appointment'=>'required|date_format:H:i',
            'reason'=>'required|string'
        ]);

        //validando si se rompe las reglas de entrada de datos
        if($validator->fails()){
            return response()->json([
                'message'=>'Validation Error',
                'errors'=>$validator->errors()
            ],400);
        }

        $appointment = new Appointment();
        $appointment->patient_id = $request->input('patient_id');
        $appointment->user_id = $request->input('user_id');
        $appointment->date_appointment = $request->input('date_appointment');
        $appointment->time_appointment = $request->input('time_appointment');
        $appointment->reason = $request->input('reason');
        $appointment->status = "Pendiente";
        $appointment->save();

        return response()->json(['message'=>'Successfully registered'],201);
    }

    public function get_appointments(Request $request){
        $validator = Validator::make($request->all(),[
            'start_date'=>'date|nullable|date_format:Y-m-d',
            'end_date'=>'date|nullable|date_format:Y-m-d|after_or_equal:start_date'
        ]);

        //validando si se rompe las reglas de entrada de datos
        if($validator->fails()){
            return response()->json([
                'message'=>'Validation Error',
                'errors'=>$validator->errors()
            ],400);
        }

        $query_appointments = Appointment::select('*');

        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');

        if($start_date && $end_date){
            $query_appointments->whereBetween('date_appointment', [$start_date, $end_date]);
        }

        $data = $query_appointments->get();
        return response()->json($data,200);
    }
}
