<?php

    //importo la classe
    require_once 'Book.php';


    function addBook(array &$library, string $title, string $author, string $year, string $pages, string $price ){

        //creo l oggetto dentro l array libreria
        $library[] = new Book($title, $author, $year, $pages, $price);
        

    }



    function searchBook(array $library, string $title): ?Book {

            foreach ($library as $book){

                if(strtolower($book->title) === strtolower($title)){

                    return $book;
                }

            }

            return null; // nessun contatto trovato

    }



    
    function deleteBook(array &$library, int $index){

        if(isset($library[$index])){ //se ho un indice

            unset($library[$index]);  //cancello l indice

            $library = array_values($library); // reindicizza la lista

        }

    }

?>