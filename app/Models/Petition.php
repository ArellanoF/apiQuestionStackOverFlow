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
        $query = $this->where('tagged', $tagged);

        if ($fromDate !== null) {
            $query->where('from_date', $fromDate);
        }

        if ($toDate !== null) {
            $query->where('to_date', $toDate);
        }

        return $query->first();
    }
}
