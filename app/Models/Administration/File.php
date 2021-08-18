<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class File extends Model
{
    use HasFactory, Userstamps;

    protected $fillable = [
        'name',
        'extension',
        'mime_type',
        'size',
        'url'
    ];

    public static $rules = [
        'file' => 'required'
    ];

    public static $messages = [
        'file.required' => 'Debe envíar el archivo.'
    ];
}
