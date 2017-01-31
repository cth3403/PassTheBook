<?php

use PHPUnit\Framework\TestCase;

class BibInfoTest extends TestCase
{
	/**
	 * [testCopacRetrieval description]
	 * the response object should have the bib_details set
	 * @return [type] [description]
	 */
	public function testCopacRetrieval(){
		$response = new BibInfo\Copac('0321832183');
		$this->assertObjectHasAttribute('bib_details', $response);	
	}
	
	/**
	 * [testLocRetrieval description]
	 * the response object should have the bib_details set
	 * @return [type] [description]
	 */
	public function testLocRetrieval(){
		$response = new BibInfo\Loc('0321832183');
		$this->assertObjectHasAttribute('bib_details', $response);	
	}

	/**
	 * [testCopacUrl description]
	 * the xml using the sru should match that of the dowloaded record
	 * @return [type] [description]
	 */
	public function testCopacUrl() {
    	$url = file_get_contents("http://copac.jisc.ac.uk:3000/copac?operation=searchRetrieve&version=1.1&query=bath.isbn=0321832183&maximumRecords=1&recordSchema=mods");
    	$this->assertXmlStringEqualsXmlFile('app/BibInfo/tests/copac.xml', $url);
  	}

  	/**
  	 * [testLocUrl description]
  	 * the xml using the sru should match that of the dowloaded record
  	 * @return [type] [description]
  	 */
  	public function testLocUrl() {
  		$url = file_get_contents("http://lx2.loc.gov:210/lcdb?version=1.1&query=bath.isbn=0321832183&maximumRecords=1&recordSchema=mods");
    	$this->assertXmlStringEqualsXmlFile('app/BibInfo/tests/lcdb.xml', $url);
  	}

}
