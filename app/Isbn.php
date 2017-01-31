<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Isbn extends Model
{
	protected $table = 'isbns';

	/** 
   	* fillable fields that can be mass assigned when using Eloquent
   	* @var 
   	*/
	protected $fillable = [
			'isbn', 'title_id'
		];


	public static function validIsbn($isbn){
		// lowercase 'x' will cause the validator to return false even for valid isbns
		if(preg_match('/x/', $isbn)){
			$isbn = preg_replace('/x/', 'X', $isbn);	
		}
		$is = new \Isbn\Isbn();
		$valid = $is->validation->isbn($isbn);
		return $valid;
	}


	public static function isbn13($isbns){
		if(is_array($isbns)){
			$arr_isbn = [];
			
			foreach ($isbns as $key => $value) {
				$isbn = new \Isbn\Isbn();
				$value = $isbn->hyphens->removeHyphens($value);
				if($isbn->check->is13($value) == true){
					$arr_isbn[$key] = $value;
				}
				elseif($isbn->check->is10($value) == true){
					$value = $isbn->translate->to13($value);
					$arr_isbn[$key] = $value;
				}
				else{
					$arr_isbn[$key] = $value;
				}
			}
			return array_unique($arr_isbn);
		}

		else{
			$isbn = new \Isbn\Isbn();
			$isbns = $isbn->hyphens->removeHyphens($isbns);
			if($isbn->check->is13($isbns) == true){
				return $isbns;
			}
			elseif($isbn->check->is10($isbns) == true){
				return $isbn->translate->to13($isbns);
			}
			else{
				return $isbns;
			}
		}
	}

	public function getTitle(){
		return $this->belongsTo('App\Title', 'title_id');
	}
	
}
