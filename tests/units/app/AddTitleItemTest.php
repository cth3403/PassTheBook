<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Support\Facades\DB;

use App\AddTitleItem as Add;
use App\Isbn as ISBN;
use App\Title as Title;


class AddTitleItemTest extends TestCase
{

	public $new;

	/**
	 * [testConstructor description]
	 * should end up with at least an ISBN object with a 13 digit ISBN
	 * @return [type] [description]
	 */
/*	public function testConstructor(){
		$new = new Add('0-596-00382-x');
		$this->assertInstanceOf(ISBN::class, $new->isbn);
		$this->assertEquals('9780596003821', $new->isbn->isbn);

		$new = new Add('');
		$this->assertEquals('invalid ISBN supplied', $new->error);
	}

	/**
	 * [testImportTitle description]
	 * test that we are getting back enough information to create a complete record from LoC/COPAC
	 * @return [type] [description]
	 */
/*	public function testImportTitle(){
		$new = new Add('0-596-00382-x');
		$new->importTitle();
		$this->assertObjectHasAttribute('title',$new->rawTitle);
		$this->assertObjectHasAttribute('authors',$new->rawTitle);
		$this->assertObjectHasAttribute('isbns',$new->rawTitle);
	}

	/**
	 * [testCreateTitleModel description]
	 * 
	 * @return [type] [description]
	 */
	public function testCreateTitleModel(){
		$new = new Add('');
		$new->importTitle();
		$new->createTitleModel();
		$this->assertInstanceOf(Title::class, $new->title);
		$this->assertInternalType('string',$new->title->title);
	}

}