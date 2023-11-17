<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patients;

class PatientsController extends Controller
{
    public function index()
    {
        $patienst = Patients::all();

        if (!Empty($patients)) {

            $data = [
                'message' => 'Menampilkan data pasien',
                'data' => $patients,
            ];

            return response()->json($data,200);

        } else {
            $data = [
                'message' => 'Data tidak ada',
            ];
            return response()->json($data, 404);
        }
    }

    public function post(Request $request)
    {
        $input = [
            'name' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required',
            'status' => 'required',
            'in_date_at' => 'required',
            'out_date_at' => 'required',
        ];

        $validated = $request->validate($input);

        $patients = Patients::create($validated);
        $data = [
            'message' => 'Berhasil menambahkan',
            'data' => $patients
        ];
        return response()->json($data);
    }

    public function put(Request $request, $id)
    {
        $patients = Patients::find($id);

        $input = [
            'name' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required',
            'status' => 'required',
            'in_date_at' => 'required',
            'out_date_at' => 'required',
        ];

        $validated = $request->validate($input);

        if ($patients) {
            // menangkap data request
            $input = [
                'name' => $validated['name'] ?? $patients->name,
                'phone' => $validated['phone'] ?? $patients->phone,
                'address' => $validated['address'] ?? $patients->address,
                'status' => $validated['status'] ?? $patients->status,
                'in_date_at' => $validated['in_date_at'] ?? $patients->in_date_at,
                'out_date_at' => $validated['out_date_at'] ?? $patients->out_date_at,
            ];

            // melakukan update data
            $patients->update($input);
            $data = [
                'message' => 'patients is updated',
                'data' => $patients
            ];
            // mengembalikan data (json) dan kode 200
            return response()->json($data, 200);
        } else {

            $data = [
                'message' => 'Update - patients not found',
            ];

            return response()->json($data, 404);
        }
    }

    public function destroy($id)
    {
        $patients = Patients::find($id);
        if ($patients) {
            $patients->delete();
            $data = [
                'message' => 'menghapus data dengan id ' . $id
            ];
            return response()->json($data);
        } else {
            $data = [
                'message' => 'Delete - Id tidak ditemukan'
            ];
            return response()->json($data);
        }
    }

    public function show($id)
    {
        // cari id patients yang ingin didapatkan
        $Patients = Patients::find($id);
        if ($Patients) {
            $data = [
                'message' => 'Get detail Patients',
                'data' => $Patients,
            ];
            // mengembalikan data (json) dan kode 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'patients not found'
            ];
            // mengembalikan data (json) dan kode 404
            return response()->json($data, 404);
        }
    }

    public function search(Request $request)
    {
        # mencari patients menggunakan nama
        $Patients = Patients::where('status', 'name')->get;
            $data = [
                'message' => 'Nama yang dicari',
                'data' => $Patients
            ];

            return response()->json($data, 200);
    }

    public function dead()
    {
        # mencari patients yang meninggal
        $deadPatients = Patients::where('status', 'Dead')->get();
            $data = [
                'message' => 'Data yang meninggal',
                'data' => $deadPatients
            ];

            return response()->json($data, 200);
    }

    public function positive()
    {
        # mencari patients yang positive covid
        $Patients = Patients::where('status', 'positive')->get();
            $data = [
                'message' => 'Data yang positive covid',
                'data' => $Patients
            ];

            return response()->json($data, 200);
    }

    public function recovered()
    {
        # mencari patients yang meninggal
        $Patients = Patients::where('status', 'recovered')->get();
            $data = [
                'message' => 'Data yang positive covid',
                'data' => $Patients
            ];

            return response()->json($data, 200);
    }
}