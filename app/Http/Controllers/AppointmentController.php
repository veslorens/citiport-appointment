<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        if ($query) {
            $appointments = Appointment::where('id', 'LIKE', "%{$query}%")
                ->orWhere('service_name', 'LIKE', "%{$query}%")
                ->orWhere('office', 'LIKE', "%{$query}%")
                ->paginate(10);
        } else {
            $appointments = Appointment::paginate(10);
        }

        return view('appointment.index', compact('appointments'));
    }

    public function create()
    {
        return view('appointment.create');
    }

    public function schedule()
    {
        $appointments = Appointment::all();
        return view('appointment.schedule', [
            'appointments' => $appointments
        ]);
    }

    public function store(Request $request)
    {
        $booked_at = $request->input('booked_at');
        $service_name = $request->input('service_name');
        $service_type = $request->input('service_type');
        $office = $request->input('office');

        $data['service_name'] = $service_name;
        $data['service_type'] = $service_type;
        $data['office'] = $office;
        $data['status'] = 'Pending';
        $data['booked_at'] = $booked_at;
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        $data['created_at'] = Carbon::now()->toDateTimeString();
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        $data['created_at'] = Carbon::now()->toDateTimeString();
        $newAppointment = Appointment::create($data);
        return response()->json(['id' => $newAppointment->id]);
    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
        return redirect()->back()->with('success', 'Appointment deleted successfully!');
    }

    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointments = Appointment::all();
        return view("appointment.edit", ['appointment' => $appointment, 'appointments' => $appointments]);
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->booked_at = $request->input('booked_at');
        $appointment->service_name = $request->input('service_name');
        $appointment->service_type = $request->input('service_type');
        $appointment->office = $request->input('office');
        $appointment->updated_at = date('Y-m-d H:i:s');
        $appointment->save();

        return response()->json(['message' => 'Appointment updated successfully'], 200);
    }

    public function search(Request $request)
    {
        return $this->index($request);
    }
}
