<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class CertificateController extends Controller
{
    private function getCertificateData()
    {
        $user = auth()->user();

        // Only allow if OJT is complete
        if ($user->getRemainingHours() > 0) {
            abort(403, 'OJT not yet completed.');
        }

        $logs = $user->dtrLogs()->where('status', 'completed')->orderBy('date')->get();
        $startDate = $logs->first() ? Carbon::parse($logs->first()->date)->format('F d, Y') : now()->format('F d, Y');
        $endDate   = $logs->last()  ? Carbon::parse($logs->last()->date)->format('F d, Y')  : now()->format('F d, Y');
        $issuedDate = now()->format('F d, Y');

        return compact('user', 'startDate', 'endDate', 'issuedDate');
    }

    /** Preview certificate in browser */
    public function view()
    {
        $data = $this->getCertificateData();
        return view('certificate.show', $data);
    }

}
