<?php

class Book {

    //attributi
    public string $title;
    public string $author;
    public string $year;
    public string $price;
    public string $pages;

    //costruttore della classe
    public function __construct(string $title, string $author, string $year, string $price, string $pages){

        $this->title = $title;
        $this->author = $author;
        $this->year = $year;
        $this->price = $price;
        $this->pages = $pages;



    }

    public function getInfo() : string{

        return "Titolo : {$this->title} - 
                Autore : {$this->author} - 
                Anno : {$this->year} - 
                Prezzo : {$this->price} -
                Numero Pagine : {$this->pages}";
    }
}
?>