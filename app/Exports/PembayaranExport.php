<?php

namespace App\Exports;

use DB;
use App\Models\{TahunAjaran, User, t_pembayaran};
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class PembayaranExport implements FromView, ShouldAutoSize, WithTitle
{
    protected $request;
    protected $kelas;
    protected $sheetName;
    protected $datas;

    public function __construct($request, $kelas, $sheetName){
        $this->request = $request;
        $this->kelas = $kelas;
        $this->sheetName = $sheetName;
        $this->get_pembayaran();
    }

    private function get_pembayaran(){
        $users = User::getUser($this->request, 'siswa', true, false, ['kelas' => $this->kelas]);

        foreach ($users as $key => $user) {
            // $pembayaran = [];
            // foreach (config('services.bulan') as $key => $bulan) {
            //     $check = DB::table('t_pembayarans')
            //                 ->where('siswa_id', $user->id)
            //                 ->where('tahun_ajaran_id', $tahun_ajaran->id)
            //                 ->where('bulan', $key + 1)
            //                 ->count();
            //     $pembayaran[$key+1] = $check > 0 ? true : false;
            // }
            $user['pembayarans'] = t_pembayaran::get_pembayaran($this->request, $user->id);;
        }   

        $this->datas = $users;
    }

    public function view(): View
    {   
        $users = $this->datas;
        return view('pembayaran.export_all', [
            'users' => $users,
        ]);
    }

    public function title(): string
    {
        return $this->sheetName;
    }
}
