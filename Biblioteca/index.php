<?php


    require_once 'functions.php';

    //parte la sessione
    session_start();

    //inizializzazione della sessione
    if(!isset($_SESSION['library'])){
        $_SESSION['library'] = [];
    }

    //dichiaro che 
    $library = &$_SESSION['library']; // puntatore di riferimento variabile sessione con &

    //messaggi informativi ( inizializzo a null poi cambia a seconda di cio' che voglio avere come info)
    $messagge = null;


    //LOGICA AGGIUNTA LIBRO
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])){ //mi sono preso il bottone di add book

        //Salvo in variabili i valori inseriti in input form
        $title = trim($_POST['title'] ?? ''); //?? valore di dafalt, quindi prendi il titolo oppure vuoto
        $author = trim($_POST['author'] ?? '');
        $year = trim($_POST['year'] ?? '');
        $price = trim($_POST['price'] ?? '');
        $pages = trim($_POST['pages'] ?? '');

        //aggiungo un libro se ho il titolo e l autore
        if($title && $author){

            addBook($library, $title, $author, $year, $price, $pages);

            $message = "Libro Aggiunto";

        }else{

            $message = "Inserisci il titolo e un autore";
        }


    }


    //LOGICA DI RICERCA LIBRO
    //inizializzo il libro da cercare come nullo
    $searchTitle = null;
    $searchResult = null;

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])){ //mi sono preso il bottone di search button book

        $searchTitle = trim($_POST['search_title'] ?? ''); // il valore inserito sarà salvato in searchTitle

        if($searchTitle !== ''){ // se ho valori

            $searchResult = searchBook($library, $searchTitle);
        }
       
    }


    //LOGICA DI CANCELLAZIONE

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])){ //mi sono preso il bottone di search button book

        $indexToDelete = (int)$_POST['index']; // ho preso l id del book da cancellare

       deleteBook($library, $indexToDelete);
       $message = "Libro cancellato";
    }



?>






<!DOCTYPE html>
<html lang="it"> <!--BUG?! Altrimenti non prende il css personale -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca</title>
    
    <!--importo Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!--importo style personale-->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <!--importo header-->
    <?php include 'header.php' ?>



    <div class="container py-4">

        <!--FORM AGGIUNTA LIBRO-->
        <h3>Aggiungi un libro</h3>
        <form action="" method="POST" class="row g-3 mb-4">

            <div class="col-md-4">

                <input type="text" name="title" class="form-control" placeholder="Inserisci Titolo...">


            </div>

            <div class="col-md-4">

                <input type="text" name="author" class="form-control" placeholder="Inserisci Autore...">


            </div>

            <div class="col-md-4">

                <input type="text" name="year" class="form-control" placeholder="Inserisci Anno...">


            </div>

            <div class="col-md-6">

                <input type="text" name="price" class="form-control" placeholder="Inserisci Prezzo Libro...">


            </div>

            <div class="col-md-6">

                <input type="text" name="pages" class="form-control" placeholder="Inserisci Numero delle pagine...">


            </div>
            
            <!--Bottone d submit-->
            <div class="col-md-2 ">
                <button class="btn btn-primary w-100" type="submit" name="add">Aggiungi</button>
            </div>


        </form>


        <!--FORM RICERCA LIBRO-->
        <h3>Ricerca Libro</h3>
        <form action="" method="POST">

            <div class="col-md-12">
                <input type="text" name="search_title" class="form-control" placeholder="Inserisci titolo da cercare">
            </div>

            <!--Bottone di invio ricerca -->
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary mt-3 w-100" name="search">Cerca</button>
            </div>

        </form>




        <!--CREO I RISULTATI DELLA RICERCA PER TITOLO-->
        
        <?php  if($searchTitle !== null) :  ?> <!-- se sto effettivamente cercando qualcosa -->

            <h3>Risultato Ricerca</h3>
            <?php if($searchResult) : ?>
                
                <div class="card">

                    <div class="card-body d-flex justify-content-between align-items-center">

                        <?= $searchResult->getInfo() ?>

                    </div>

                </div>
            <?php else: ?>
                <p>Nessun libro trovato</p>

            <?php endif; ?>

        <?php endif; ?>




        <h3>Elenco Libri</h3>
        <!--Se la libreria è vuota...-->
        <?php if(empty($library)): ?>
            
            <p>Nessun libro presente</p>
        
            <?php else: ?>

                <ul class="list-group mb-4">
                    <!--Ciclo su tutti i libri -->
                    <?php  foreach($library as $index => $book) :   ?>
                    <!--Creo elemento in pagina del libro-->
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= $book->getInfo() ?><!--prendo tutte le info con la funzione della classe-->
                            <!--Form di eliminazione libro-->
                            <form action="" method="POST" onsubmit="return confirm('Sei sicuro di voler eliminare questo libro?')">
                                <input type="hidden" name="index" value="<?php $index ?>">
                                <button type="submit" name="delete" class="btn btn-danger">Cancella</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>

        <?php endif; ?>
    </div>

    <h3>debug</h3>
    <pre><?php print_r($_SESSION) ?></pre>



    <!--importo footer-->
    <?php include 'footer.php' ?>




</body>
</html>