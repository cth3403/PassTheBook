<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Support\Facades\DB;

use App\Isbn as ISBN;

class IsbnModelTest extends TestCase
{
	/**
	 * [testIsbn13 description]
	 * see if an isbn or array of isbns are an isbn13 after running
	 * an isbn13 conversion 
	 * @return [type] [description]
	 */
	public function testIsbn13(){

		$arrNo13 = ['0321832183','0596000278', '059600382X'];
		$arrAll13 = ['9780321832184','9780596000271', '9780596003821'];
		$arrMix13 = ['9780321832184','9780596000271','059600382X'];
		$isbn13True = '9780321832184';
		$isbn13False = '0321832183';

		$i = new ISBN;

		$this->assertEquals(['9780321832184','9780596000271','9780596003821'], $i->isbn13($arrNo13));
		$this->assertEquals(['9780321832184','9780596000271', '9780596003821'], $i->isbn13($arrAll13));
		$this->assertEquals(['9780321832184','9780596000271','9780596003821'], $i->isbn13($arrMix13));
		$this->assertEquals('9780321832184', $i->isbn13($isbn13True));
		$this->assertEquals('9780321832184', $i->isbn13($isbn13False));

	}

}