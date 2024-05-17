<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Petition;
use Carbon\Carbon;

class StackOverflowController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'tagged' => 'required|string',
            'fromDate' => 'nullable|date',
            'toDate' => 'nullable|date',
        ]);

        $tagged = $request->input('tagged');
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');

        // Crear una instancia del modelo Petition
        $petition = new Petition();

        $existingPetition = $petition->searchOrCreate($tagged, $fromDate, $toDate);

        if ($existingPetition) {
            // Si se encuentra una consulta existente, mostrar su resultado almacenado
            $result = $existingPetition->response;
  
        } else {
            // Si no se encuentra una consulta existente, realizar la consulta a la API
            $queryParams = [
                'order' => 'desc',
                'sort' => 'activity',
                'tagged' => $tagged,
                'site' => 'stackoverflow',
                'pagesize' => 100, //máximo que devuelve la api
            ];

            if ($fromDate) {
                $queryParams['fromdate'] = Carbon::parse($fromDate)->timestamp;
            }

            if ($toDate) {
                $queryParams['todate'] = Carbon::parse($toDate)->timestamp;
            }

            $response = Http::get('https://api.stackexchange.com/2.3/questions', $queryParams);

            if ($response->successful()) {
                // Guardar la consulta y la respuesta en la base de datos
                Petition::create([
                    'tagged' => $tagged,
                    'response' => $response->json(),
                    'from_date' => $fromDate,
                    'to_date' => $toDate,
                ]);

                $result = $response->json();
            } else {
                return response()->json(['error' => 'Error fetching data from Stack Overflow API'], 500);
            }
        }

        // Devolver el resultado al cliente, ya sea de la base de datos o de la API
        return view('search', ['result' => $result]);
    }
}