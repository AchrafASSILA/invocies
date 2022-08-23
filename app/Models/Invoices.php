<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoices extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = [
        'invoice_number',
        'invoice_Date',
        'Due_date',
        'section_id',
        'product',
        'amount',
        'Status',
        'Value_Status',
        'note'
    ];

    public function attachment()
    {
        return $this->hasMany(InvoicesAttachments::class, 'invoice_id');
    }
    public function section()
    {
        return $this->belongsTo(Sections::class);
    }
}
