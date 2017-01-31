<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Support\Facades\DB;

use App\User as User;

class UserModelTest extends TestCase
{
	/**
	 * does the admin attribute return false when not an admin.
	 * @return [type] [description]
	 */
	public function testGetAdminAttribute(){
		$user = User::where('admin', 0)->get()->first();
		$this->assertFalse($user->admin);
	}

	/**
	 * [testGetListedItems description]
	 * if there is a user with a listed item, then get the user_id and use the listed method to 
	 * retrieve all listed items for that user
	 * @return [type] [description]
	 */
	public function testGetListedItems(){
		$user = DB::table('item_user')->where('relationship', 'listed')->get()->first();
		if($user != null ){
			$user = User::find($user->user_id);
			$this->assertInternalType('object', $user->listed);
		}
		else{
			$this->assertEquals(null, $user);
		}
	}

	/**
	 * [testGetEnquiredItems description]
	 * if there is a user with a enquired item, then get the user_id and use the enquired method to 
	 * retrieve all enquired items for that user
	 * @return [type] [description]
	 */
	public function testGetEnquiredItems(){
		$user = DB::table('item_user')->where('relationship', 'enquired')->get()->first();
		if($user != null ){
			$user = User::find($user->user_id);
			$this->assertInternalType('object', $user->enquired);
		}
		else{
			$this->assertEquals(null, $user);
		}

	}

}