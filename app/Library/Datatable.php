<?php

namespace App\Library;

use Illuminate\Support\Str;

class Datatable
{
    protected $headers = [];

    /**
     | To make the headers more easier and accommodating to several styles, I have made them accept
     | uni and multi-dimensional arrays (to level 1). In cases where a value is hidden inside
     | a relationship e.g. props.item.patient.full_name, you can specify the 'value' as 'patient.full_name'
     | and the search will just work!
     |
     | Here is a sample header member
     |
     | protected $headers = [
     |        ['text' => "patient Name", 'value' => 'patient.full_name'],
     |        ['text' => "Admission Type", 'sortable' => false, 'value' => 'admission type'],
     |        "Authorized Amount", "Date", "actions"
     |   ];
     |
     | or even
     |  'name', ['text' => 'amount', 'align' => 'right'], 'type', ['text' => 'used?', 'value' => 'used'], 'actions'
     | 
     | Available Header attributes - From Vuetify v2
     |  {
     |     text: string
     |     value: string
     |     align?: 'start' | 'center' | 'end'
     |     sortable?: boolean
     |     filterable?: boolean
     |     groupable?: boolean
     |     divider?: boolean
     |     class?: string | string[]
     |     width?: string | number
     |     filter?: (value: any, search: string, item: any) => boolean
     |     sort?: (a: any, b: any) => number
     |   }
     |
     */

    /**
     * @param string|array $headers
     *
     * @return array
     */

    /**
     * Prepare the headers. The headers are very friendly to set, and here at the top is sample code
     * 
     * @param array $headers
     *
     * @return array
     */
    public function headers(array $headers) : array
    {
        foreach($headers as $header)
        {
            $arr = [
                'text' => $this->getText($header),
                'sortable' => $this->getSortable($header),
                'value' => $this->getValue($header),
                'align' => $this->getAlignment($header),
            ];

            isset($header['filterable']) ? $arr = array_merge($arr, ['filterable' => $this->getBoolean($header, 'filterable')]) : null;
            isset($header['sortable']) ? $arr = array_merge($arr, ['sortable' => $this->getBoolean($header, 'sortable')]) : null;
            isset($header['groupable']) ? $arr = array_merge($arr, ['groupable' => $this->getBoolean($header, 'groupable')]) : null;
            isset($header['divider']) ? $arr = array_merge($arr, ['divider' => $this->getBoolean($header, 'divider')]) : null;

            $this->headers[] = $arr;
        }

        return $this->headers;
    }

    /**
     * get the text for the datatable. This is the display
     *
     * @param string|array $header
     *
     * @return string
     */
    private function getText($header)
    {
        $value = $header;

        if(is_array($header) and isset($header['text'])) {
            $value = $header['text'];
        }

        return is_array($value) ? ucwords($value[1]) : ucwords($value);
    }

    /**
     * get the value. This value is used in searching the vuetify datatable when no ajax search is required
     *
     * @param string|array $header
     *
     * @return string
     */
    private function getValue($header)
    {
        $value = $header;

        if(is_array($header) and isset($header['value'])) {
            $value = $header['value'];
        }

        return is_array($value) ? Str::snake(strtolower(collect($value)->first())) : Str::snake(strtolower($value));
    }

    /**
     * get the boolean value.
     *
     * @param string|array $header
     *
     * @return bool
     */
    private function getBoolean($header, $entity)
    {
        $bool = $header;

        if(is_array($header) and isset($header[$entity])) {
            $bool = $header[$entity];
        }

        return is_array($bool) ? (bool)(strtolower(collect($bool)->first())) : (bool)(strtolower($bool));
    }

    /**
     * get the sortable attribute
     *
     * @param string|array $header
     *
     * @return bool|mixed
     */
    private function getSortable($header)
    {
        $value = true;

        if(is_array($header) and isset($header['sortable'])) {

            $value = $header['sortable'];

        } else if(! is_array($header) and str_contains($header, 'action')) {
            // check if string is action
            $value = false;
        }

        return $value;
    }
    
    /**
     * Get allignment attr
     * 
     * @param string|array $header
     *
     * @return mixed|string
     */
    private function getAlignment($header)
    {
        $value = 'left';

        if(is_array($header) and isset($header['align'])) {
            $value = $header['align'];
        }

        return $value;
    }

    /**
     * function to get the value for a certain index.
     *
     * @param string|array $header
     * @param int $index
     *
     * @return mixed
     */
    private function getValueFromIndex($header, $index = 0)
    {
        return isset(array_keys($header)[$index]) ? $header[array_keys($header)[$index]] : $header[array_keys($header)[0]];
    }
}