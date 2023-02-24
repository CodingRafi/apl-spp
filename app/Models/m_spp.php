<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_spp extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function tahun_ajaran(){
        return $this->belongsTo(TahunAjaran::class);
    }

    public function sekolah(){
        return $this->belongsTo(Sekolah::class);
    }

    public function user(){
        return $this->hasMany(profile_siswa::class, 'spp_id');
    }
}
