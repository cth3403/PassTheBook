<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SeederTest extends TestCase
{
    /***
     * test ISBNS table
     *      
     * @return void
     */
    public function testIsbnsTable()
    {
        $isbn = factory(App\Isbn::class)->create();
    	$this->seeInDatabase('isbns', ['isbn' => $isbn->isbn]);
    }

    /***
     * test AUTHORS table
     *      
     * @return void
     */
    public function testAuthorsTable()
    {
        $author = factory(App\Creator::class)->create();
    	$this->seeInDatabase('creators', ['fname' => $author->fname, 'lname' => $author->lname, 'born' => $author->born]);
    }

    /***
     * test RLISTS table
     *      
     * @return void
     */
    public function testRlistsTable()
    {
        $rlist = factory(App\Rlist::class)->create();
    	$this->seeInDatabase('rlists', ['rlist_name' => $rlist->rlist_name, 'rlist_href' => $rlist->rlist_href]);
    }

     /***
     * test ITEMS table
     *      
     * @return void
     */
    public function testItemsTable()
    {
        $item = factory(App\Item::class)->create();
    	$this->seeInDatabase('items', ['price' => $item->price, 'status' => $item->status, 'condition' => $item->condition, 'disp' => $item->disp, 'comments' => $item->comments, 'ref' => $item->ref, 'special' => $item->special, 'location' => $item->location]);
    }

    /***
     * test TITLES table
     *      
     * @return void
     */
    public function testTitlesTable()
    {
        $title = factory(App\Title::class)->create();
    	$this->seeInDatabase('titles', ['title' => $title->title, 'subtitle' => $title->subtitle, 'pubdate' => $title->pubdate]);
    }

     /***
     * test USERS table
     *      
     * @return void
     */
    public function testUsersTable()
    {
        $user = factory(App\User::class)->create();
    	$this->seeInDatabase('users', ['fname' => $user->fname, 'lname' => $user->lname, 'pay' => $user->pay, 'uni_id' => $user->uni_id, 'password' => $user->password, 'remember_token' => $user->remember_token]);
    }
}
