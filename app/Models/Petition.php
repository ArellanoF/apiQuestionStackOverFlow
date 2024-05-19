<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petition extends Model
{
    use HasFactory;

    protected $fillable = ['tagged', 'response', 'from_date', 'to_date'];

    protected $casts = [
        'response' => 'array',
    ];

    public function searchOrCreate($tagged, $fromDate = null, $toDate = null)
    {
        $query = $this->where('tagged', $tagged)
            ->where(function ($q) use ($fromDate) {
                if ($fromDate !== null) {
                    $q->where('from_date', $fromDate);
                } else {
                    $q->whereNull('from_date');
                }
            })
            ->where(function ($q) use ($toDate) {
                if ($toDate !== null) {
                    $q->where('to_date', $toDate);
                } else {
                    $q->whereNull('to_date');
                }
            });


        return $query->first();
    }
}
