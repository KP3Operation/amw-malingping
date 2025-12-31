<?php

namespace App\Http\Controllers\Api\V1\Patient;

use App\Http\Controllers\Controller;
use App\Services\SimrsService\PatientService\IPatientService;
use Illuminate\Http\Request;
use stdClass;

class GuarantorController extends Controller
{
    private IPatientService $patientService;

    public function __construct(IPatientService $patientService)
    {
        $this->patientService = $patientService;
    }

    public function index(Request $request)
    {
        $GuarantorID   = $request->guarantor_id ?? '';
        $guarantorName = $request->guarantor_name ?? '';

        // get data from service
        $guarantorLists = $this->patientService->getGuarantorList(
            $GuarantorID,
            $guarantorName
        );

        $guarantorLists = collect($guarantorLists)
            ->flatten(1) // hilangkan 1 tingkat array
            ->filter(function ($item) {
                $id = data_get($item, 'guarantorID');
                // Tampilkan data berdasarkan guarantorID tertentu
                return in_array($id, ['SELF', 'G-00007', 'G-00004', 'G-00003']);
            })
            ->sortBy('guarantorName')
            ->values()
            ->all();

        // Bungkus dengan format sesuai kebutuhan
        return response()->json([
            'guarantor' => [
                'data' => $guarantorLists
            ]
        ]);
    }
}
