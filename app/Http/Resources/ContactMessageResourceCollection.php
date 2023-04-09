<?php

namespace App\Http\Resources;

use App\Library\Datatable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ContactMessageResourceCollection extends ResourceCollection
{
    /**
     * Define the headers and consequently values for the datatable
     */
    protected $headers = [
        ['text' => '#', 'value' => 'id'],
        'name', 'contact',
        ['text' => 'Message', 'value' => 'body'],
        'actions'
    ];

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data'      => $this->collection,

            'headers'   => (new Datatable)->headers($this->headers)
        ];
    }
}
