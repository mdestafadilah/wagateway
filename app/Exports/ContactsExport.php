<?php

namespace App\Exports;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;

class ContactsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $tag;

    public function __construct($tag)
    {
        $this->tag = $tag;
    }
    public function collection()
    {
        return Contact::whereUserId(Auth::user()->id)->whereTagId($this->tag)->get(['name','number']);
        // return Auth::user()->contacts()->whereHas('tag_id',function($t){
        //     return $t->where
        // })->get(['name','number']);
    }
}
