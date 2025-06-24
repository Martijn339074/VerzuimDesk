<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class VerzuimController extends Controller
{
    public function showUploadForm()
    {
        return view('verzuim.upload');
    }

    public function upload(Request $request)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(300); // Increase max execution time to 5 minutes

        $request->validate([
            'verzuimbestand' => 'required|file|mimes:xlsx,xls',
        ]);

        $data = Excel::toArray([], $request->file('verzuimbestand'));
        // Sla de data tijdelijk op in de sessie
        // $data[0] bevat alle rijen van het eerste werkblad
        $rows = $data[0];
        if (count($rows) < 3) {
            return back()->withErrors(['verzuimbestand' => 'Bestand bevat te weinig rijen.']);
        }
        $header = array_map('strtolower', $rows[0]); // eerste rij: kolomnamen
        // Sla alleen de data vanaf de derde rij op (index 2 en verder)
        $dataRows = array_slice($rows, 2);
        Session::put('verzuim_data', [$header, ...$dataRows]);

        // Zoek het indexnummer van de kolom 'groep code' (of 'klas' als je dat wilt)
        $klasIndex = array_search('groep code', $header);
        $klassen = collect($dataRows)->pluck($klasIndex)->unique()->values();

        return view('verzuim.select', compact('klassen'));
    }

    public function showGemiddelde(Request $request)
    {
        $request->validate([
            'klas' => 'required',
        ]);
        $data = Session::get('verzuim_data');
        if (!$data) {
            return redirect()->route('verzuim.upload.form')->withErrors('Geen data gevonden.');
        }
        $header = $data[0];
        $dataRows = array_slice($data, 1);
        $klasIndex = array_search('groep code', $header); // or 'klas' if that's the column name
        $verzuimIndex = array_search('% aanwezig', $header); // adjust if needed
        $filtered = collect($dataRows)->filter(function($row) use ($klasIndex, $request) {
            return isset($row[$klasIndex]) && $row[$klasIndex] == $request->klas;
        });
        $gemiddelde = $filtered->avg(function($row) use ($verzuimIndex) {
            if (!isset($row[$verzuimIndex])) return 0;
            $value = str_replace([',', '%'], ['.', ''], $row[$verzuimIndex]);
            return floatval($value);
        });
        $gemiddelde = $gemiddelde * 100; // Convert to percentage
        return view('verzuim.result', [
            'klas' => $request->klas,
            'gemiddelde' => $gemiddelde,
        ]);
    }
}
