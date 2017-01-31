<?php
/**
 * COPAC
 *
 * @author Joe Schulkins <j_schulkins@hotmail.com>
 * @version 0.1.0
 * @package BibInfo
*/
namespace BibInfo;

use BibInfo\BibInfo as BibInfo;
use Scriptotek\Sru\Client as SruClient;
use App\Isbn;
use Carbon\Carbon;

/**
* Copac class
*
* @return  array [<description>]
*/
class Copac extends BibInfo{
	
	/**
	 * Set the SRU client and search
	 * once finished execute modsRetrieval() method
	 */
	function __construct($searchIsbn){
		$isbn = new \Isbn\Isbn();
		$searchIsbn = $isbn->hyphens->removeHyphens($searchIsbn);
		$this->searchIsbn = $searchIsbn;
		$url = "http://copac.ac.uk:3000/copac";
        $client = new SruClient($url, array('schema'=>'mods','version'=>'1.1'));
        $this->response = $client->first("bath.isbn='".$searchIsbn."'");    
        $this->modsRetrieval();
	}

}