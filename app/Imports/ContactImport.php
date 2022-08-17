<?php

namespace App\Imports;

use App\Models\Contact;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;

class ContactImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
        protected $tag;
    public function __construct($tag)
    {
        $this->tag = $tag;
    }
    public function collection(Collection $collection)
    {
   
        foreach($collection as $row){
            Contact::create([
                'user_id' => Auth::user()->id,
                'tag_id' => $this->tag,
                'name' => $row[0],
                'number' => $row[1]
            ]);
        }
      
    }
}
