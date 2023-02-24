<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB, Auth;

class Kelas extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function users(){
        return $this->belongsToMany(User::class, 'user_kelas');
    }

    public function sekolah(){
        return $this->belongsTo(Sekolah::class);
    }
    
    public function tingkat(){
        return $this->belongsTo(ref_tingkat::class, 'ref_tingkat_id');
    }

    public static function getKelas(){
        return DB::table('kelas')
                    ->select('kelas.*', 'ref_tingkats.romawi')
                    ->join('ref_tingkats', 'ref_tingkats.id', 'kelas.ref_tingkat_id')
                    ->where('kelas.sekolah_id', Auth::user()->sekolah_id)
                    ->get();
    }
}
