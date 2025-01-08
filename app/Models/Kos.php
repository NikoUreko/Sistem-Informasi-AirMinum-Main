<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kos extends Model
{
    use HasFactory;
    protected $table = 'tb_admkost';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable = ['nama', 'alamat', 'bln_thn', 'no_meterblnini', 'no_meterblnlalu', 'pemakaian_M', 'pemakaian_1', 'tarif_I', 'pemakaian_2','tarif_II', 'pemakaian_3', 'tarif_III', 'harga_air', 'sewa_M', 'denda', 'total_byr'];
}

