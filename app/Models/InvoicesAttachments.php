<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicesAttachments extends Model
{
    use HasFactory;
    protected $fillable = [
        'file_name',
        'invoice_id',
    ];
    public function invoice()
    {
        return $this->belongsTo(Invoices::class);
    }
}
