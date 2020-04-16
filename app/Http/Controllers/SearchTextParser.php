<?php


namespace App\Http\Controllers;


use Illuminate\Support\Str;

class SearchTextParser
{
    /**
     * @var array
     */
    public $words = [];

    public $town, $mnemonic, $name, $street, $countryCode, $zip;

    public function __construct($searchText)
    {
        $phrases = explode(' ', $searchText);
        foreach ($phrases as $phrase) {
            switch ($phrase) {
                case Str::startsWith($phrase, 'k:'):
                    $this->mnemonic = substr($phrase, 2, strlen($phrase)-2);
                    break;
                case Str::startsWith($phrase, 'n:'):
                    $this->name = substr($phrase, 2, strlen($phrase)-2);
                    break;
                case Str::startsWith($phrase, 'o:'):
                    $this->town = substr($phrase, 2, strlen($phrase)-2);
                    break;
                case Str::startsWith($phrase, 's:'):
                    $this->street = substr($phrase, 2, strlen($phrase)-2);
                    break;
                case Str::startsWith($phrase, 'l:'):
                    $this->countryCode = substr($phrase, 2, strlen($phrase)-2);
                    break;
                case Str::startsWith($phrase, 'p:'):
                    $this->zip = substr($phrase, 2, strlen($phrase)-2);
                    break;
                default:
                    $this->words[] = $phrase;
            }
        }
    }

}