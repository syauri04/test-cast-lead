<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\ErrorLog;
use Illuminate\Support\Facades\DB;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        try {
            // throw new \Exception("Simulasi error manual untuk testing error_logs");
            
            $data = $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'source' => 'required',
                'message' => 'nullable',
            ]);

            $lead = Lead::create($data);

        
            Http::post(env('THIRD_PARTY_API_URL'), [
                'text' => "📩 *New Lead Submitted!*\n\n*Name:* {$lead->name}\n*Email:* {$lead->email}\n*Phone:* {$lead->phone}\n*Source:* {$lead->source}\n*Message:* {$lead->message}",
            ]);


            return response()->json(['message' => 'Lead created', 'data' => $lead], 201);

        } catch (\Exception $e) {
           DB::connection('pgsql_logs')->table('error_logs')->insert([
                'error_message' => $e->getMessage(),
                'endpoint' => '/api/leads',
                'status_code' => 500,
                'timestamp' => now()
            ]);


            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function index()
    {
        return Lead::all();
    }

    public function show($id)
    {
        $lead = Lead::find($id);
        if (!$lead) return response()->json(['message' => 'Not Found'], 404);
        return $lead;
    }

}
