<?php

namespace App\Exports;

use Auth;
use App\Models\Kelas;
use App\Exports\PembayaranExport;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PembayaranExportAll implements WithMultipleSheets
{
    use Exportable;

    protected $request;
    
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        if ($this->request->kelas_id) {
            $kelas = Kelas::where('id', $this->request->kelas_id)->first();
            $sheets[] = new PembayaranExport($this->request, $this->request->kelas_id, $kelas->tingkat->romawi . ' ' . $kelas->nama);
        }else{
            foreach (Auth::user()->sekolah->kelas as $key => $kelas) {
                $sheets[] = new PembayaranExport($this->request, $kelas->id, $kelas->tingkat->romawi . ' ' . $kelas->nama);
            }
        }

        return $sheets;
    }
}
