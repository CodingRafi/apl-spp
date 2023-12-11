<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use DB;

class t_pembayaran extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function siswa(){
        return $this->belongsTo(User::class, 'siswa_id');
    }
    
    public function petugas(){
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public static function parse_bulan($bulan){
        foreach (config('services.bulan') as $key => $name_bulan) {
            if ($key+1 == $bulan) {
                return $name_bulan;
            }
        }
    }

    public static function get_pembayaran($request, $user_id){
        $response = [];
        $tahun_ajaran = TahunAjaran::getTahunAjaran($request);
        $user = User::findOrFail($user_id);

        if ($request->bulan) {
            $pembayaran = $user->pembayaran()->where('tahun_ajaran_id', $tahun_ajaran->id)->where('bulan', $request->bulan)->first();
                
            $response[] = [   
                'id' => $pembayaran ? $pembayaran->id : '',
                'bulan' => t_pembayaran::parse_bulan($request->bulan),
                'status' => $pembayaran ? 'Sudah di bayar pada tanggal <strong>' . date('d F Y', strtotime($pembayaran->created_at)) . '</strong>': '',
                'diterima_oleh' => $pembayaran ? ($pembayaran->petugas->profile_user ? $pembayaran->petugas->profile_user->name : '') : '',
            ];
        }else{
            foreach (config('services.bulan') as $key => $bulan) {
                $pembayaran = $user->pembayaran()->where('tahun_ajaran_id', $tahun_ajaran->id)->where('bulan', $key+1)->first();
                
                $response[] = [   
                    'id' => $pembayaran ? $pembayaran->id : '',
                    'bulan' => $bulan,
                    'status' => $pembayaran ? 'Sudah di bayar pada tanggal <strong>' . date('d F Y', strtotime($pembayaran->created_at)) . '</strong>': '',
                    'diterima_oleh' => $pembayaran ? ($pembayaran->petugas->profile_user ? $pembayaran->petugas->profile_user->name : '') : '',
                ];
            }
        }

        return [
            'response' => $response,
            'status_pembayaran' => DB::select('CALL get_siswa_pembayaran('. $user_id .', '. $tahun_ajaran->id .')')
        ];
    }
}
