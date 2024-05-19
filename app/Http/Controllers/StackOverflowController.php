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

        // Create an instance of the Petition model
        $petition = new Petition();

        $existingPetition = $petition->searchOrCreate($tagged, $fromDate, $toDate);

        if ($existingPetition) {
           // If an existing query is found, display its stored result in the BBDD
            $result = $existingPetition->response;

        } else {

            // If no existing query is found, query the API
            $queryParams = [
                'order' => 'desc',
                'sort' => 'activity',
                'tagged' => $tagged,
                'site' => 'stackoverflow',
                'pagesize' => 100, //maximum returned by the api
            ];

            if ($fromDate) {
                $queryParams['fromdate'] = Carbon::parse($fromDate)->timestamp;
            }

            if ($toDate) {
                $queryParams['todate'] = Carbon::parse($toDate)->timestamp;
            }

            $response = Http::get('https://api.stackexchange.com/2.3/questions', $queryParams);

            if ($response->successful()) {
                // Save the response to the database
                Petition::create([
                    'tagged' => $tagged,
                    'response' => $response->json(),
                    'from_date' => $fromDate,
                    'to_date' => $toDate,
                ]);

                $result = $response->json();
            } else {
               $error = response()->json(['error' => 'Error fetching data from Stack Overflow API'], 500);
               return view('search', ['error' => $error]);
            }
        }

        // Return the result to the client, either from the database or the API
        return view('search', ['result' => $result]);
    }
}