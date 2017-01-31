<?php

namespace App;
use App\Title as Title;
use App\Isbn as Isbn;
use App\Creator as Author;
use App\User as User;
use BibInfo\Loc as Loc;
use App\Exceptions\Handler;
use Mail;
use Config;



class AddTitleItem{

    protected $user;
    public $title;
    public $isbn;


    /**
     * [__construct description]
     * take in an isbn, and see whether it is already in the database
     * @param [type] $isbn [description]
     */
    public function __construct($isbn){
      $valid = Isbn::validIsbn($isbn);
      if($valid == true){
        //format isbn to isbn13, removing any hyphens
        $isbn = Isbn::isbn13($isbn);
        $this->isbn = Isbn::firstOrNew(['isbn' => $isbn]);
        $title = $this->isbn->getTitle;
        if( $title != null){
            $this->title = $this->isbn->getTitle;
        }
      }
      else{
        throw new Exception('invalid ISBN supplied');
      }

        return;
    }

    /**
     * [importTitle description]
     * import title information from our data endpoint
     * @return [type] [description]
     */
    public function importTitle(){

        if(!$this->error){
            $isbn = $this->isbn->isbn;
            $import = new Loc($isbn);
            $this->rawTitle = $import->bib_details;
        } else {
            $err_arr = $this->error;
            $err_arr['02'] = 'unable to import title';
            $this->error = $err_arr; 
        }
        return;
    }

    /**
     * [createTitleModel description]
     * create a new title model if no existing match
     * @return [type] [description]
     */
    public function createTitleModel(){

        if(!$this->error){
            $title = new Title;
            $details = $this->rawTitle;
            $title->title = $details->title;
            $title->subtitle = $details->subtitle;
            $title->pubdate = $details->pubdate;
            $date = preg_replace("/[^0-9]/", "", (string)$title->pubdate);
            preg_match("/[0-9]{4}/",$date,$matches);
            $title->pubdate = $matches[0].'-01'.'-01';
            $this->title = $title;
        } else {
            $err_arr = $this->error;
            $err_arr['03'] = 'unable to create title model';
            $this->error = $err_arr; 
        }

        return;
    }

    /**
     * [convertAuthorModels description]
     * create author(s) models
     * @return [type] [description]
     */
    public function createAuthorModel(){
        $details = $this->rawTitle;
        $author = [];
        foreach($details->authors as $au){
            $a = new Author;
            $a->lname = $au->lname;
            $a->fname = $au->fname;
            array_push($author, $a);
        }
        $this->authors = $author;
        return $this;
    }

    /**
     * [createIsbnModels description]
     * create isbn(s) models 
     * @return [type] [description]
     */
    public function createIsbnModel(){
        $details = $this->rawTitle;
        $isbns = [];
        foreach($details->isbns as $is){
            $i = new Isbn;
            $i->isbn = $is;
            array_push($isbns, $i);
        }
        $this->isbn = $isbns;
        return $this;
    }

    public function addItem(){
        $this->item = new Item;
        return $this;
    }

    /**
     * [setUser description]
     * take in a user object and use this as the user properties
     * @param User $user [description]
     */
    public function setUser(User $user){
        $this->user = $user;
    }

    /**
     * [getUser description]
     * access the user properties
     * @return [type] [description]
     */
    public function getUser(){
        return $this->user;
    }

    public function saveTitle(){
        return $this->title->save();
    }

    public function saveAuthorIsbn(){
        $isbn = $this->isbn;
        $creator = $this->authors;
        $this->title->getIsbn()->saveMany($isbn);
        $this->title->creators()->saveMany($creator);

        return $this;
    }

    public function saveItem(){
        $item = $this->item;
        $user = $this->getUser();
        $this->title->getItem()->saveMany($item);
        $item->listed()->save($user);

        return $this;
    }

}