<?php
/**
 * BibInfo
 *
 * @author Joe Schulkins <j_schulkins@hotmail.com>
 * @version 0.1.0
 * @package BibInfo
*/

namespace BibInfo;
use Scriptotek\Sru\Client as SruClient;
use App\Isbn;

abstract class BibInfo{

	public $searchIsbn;
	public $bib_details = [];

	/**
	 * We need an ISBN for searching
	 * @param [type] $isbn [description]
	 */
	public function __construct($searchIsbn){
		$this->searchIsbn = $searchIsbn;
	}

	/**
	 * If not using SRU, format the endpoint url with the ISBN in the correct location
	 * setUrl replace {isbn} token in url with isbn
	 * @param string isbn 
	 * @param string url with {isbn} token - 'http://copac.jisc.ac.uk/search?isn={isbn}&format=XML+-+MODS'
	 * @return string url with isbn inserted
	 */
	public static function setUrl($isbn, $url){
		$url = str_replace('{isbn}', $isbn, $url);
		return $url;
	}

	/**
	 * setup CURL to perform a request to the url given in setUrl
	 * @param  string $url url endpoint
	 * @return mixed      data returned by endpoint: marcxml, mods etc.
	 */
	public static function useCurl($url){
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $url,
			CURLOPT_ENCODING => "gzip",
			CURLOPT_FOLLOWLOCATION => true
			));

		$curl_result = curl_exec($curl);
		curl_close($curl);
		return $curl_result;
	}

	/**
	 * get the value of a subfield given the $att value of an $object['tag']
	 * @param  obj $object simplexmlelement object
	 * @param  str $att    value of the 'tag' attribute
	 * @return str         data in subfield of object
	 */
	public function xml_attribute($object, $att){
		if(null !== ($object["tag"]== $att))
			return (string) $object->subfield;
	}

	/***
	 * [modsRetrieval description]
	 * @return bib_details [object] [bibliographic details]
	 * @return searchIsbn [string] [original ISBN searched for]
	 */
	public function modsRetrieval(){

		$record = $this->response;

		if($record != null){

        	// create an empty object - requires PHP 7
			$bib_record = new \stdClass;

			$bib_record->position = trim($record->position);
			$bib_record->title = trim(mb_strtolower((string)$record->data->el->mods->titleInfo->title, 'UTF-8'));

			$bib_record->subtitle = trim(mb_strtolower((string)$record->data->el->mods->titleInfo->subTitle, 'UTF-8'), '[]');

			$bib_author = [];

			foreach( $record->data->el->mods->name as $name){
				$au_split = explode(",", (string)$name->namePart, 2);
				if(!isset($au_split[1])){
					return false;
				}
				elseif(sizeof($au_split) > 0){
                        // create an empty object - requires PHP 7
					$au = new \stdClass;
					$au->lname = trim(mb_strtolower($au_split[0], 'UTF-8'));
					$au->fname = trim(mb_strtolower($au_split[1], 'UTF-8'));
					array_push($bib_author, $au);
				}
			}
			if(sizeof($bib_author) > 0){
				$bib_record->authors = $bib_author;
			}

			$bib_subjects = [];
            //dd($record->data->el->mods->subject->topic);
			foreach($record->data->el->mods->subject as $subject){
				if($subject['authority'] == 'lcsh'){
					foreach($subject->topic as $subj){
						array_push($bib_subjects, trim((string) $subj));
					}
				}
			}
			$bib_record->subjects = $bib_subjects;

			$origin = [];
			foreach ($record->data->el->mods->originInfo as $key => $v) {
				foreach($v as $key => $value ){
					$origin[$key]= $v->$key;
					if ($key == 'edition'){
						$bib_record->edition = trim((string) $origin['edition']);
					}
					if($key == 'dateIssued'){
						$date = preg_replace("/[^0-9]/", "", (string)$origin['dateIssued']);
						preg_match("/[0-9]{4}/",$date,$matches);
						$bib_record->pubdate = $matches[0];

					}

				}
			}

			$bib_isbn = [];
			foreach ($record->data->el->mods->identifier as $bib_key) {
				if($bib_key['type'] == 'isbn'){
                    //$ib_dash = str_replace('-', '', (string)$bib_key);
					$ib_reg = preg_replace("/[^0-9xX].+/", "",(string)$bib_key);
					$isbn13 = Isbn::isbn13(trim($ib_reg));
					$isbn = new \Isbn\Isbn();
					$isbn->hyphens->removeHyphens($isbn13);
					if(strlen($isbn13) < '13' ){
						$isbn13 = $isbn->translate->to13($isbn13);
						$isbn13 = (string)$isbn13;
					}
					$bib_isbn[] = $isbn13;
				}
			}

			$bib_record->isbns = array_unique($bib_isbn);
			$array_pos = $bib_record->position-1; 

			$this->bib_details = $bib_record;

			return $this->bib_details;
		}
		else{
			$bib_record->isbns = false;
			$this->bib_details = $bib_record;
			return $this->bib_details;
		}
	}

}
