<?php
require_once 'functions.php';
session_start();

// Inizializzazione libreria in sessione
if (!isset($_SESSION['library'])) {
    $_SESSION['library'] = [];
}
$library = &$_SESSION['library'];

$message = null;

// LOGICA AGGIUNTA LIBRO
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {

    $title  = trim($_POST['title'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $year   = trim($_POST['year'] ?? '');
    $price  = trim($_POST['price'] ?? '');
    $pages  = trim($_POST['pages'] ?? '');

    if ($title && $author) {
        addBook($library, $title, $author, $year, $price, $pages);
        $message = "📚 Libro aggiunto con successo!";
    } else {
        $message = "⚠️ Inserisci almeno titolo e autore.";
    }
}

// LOGICA RICERCA
$searchTitle = null;
$searchResult = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {

    $searchTitle = trim($_POST['search_title'] ?? '');

    if ($searchTitle !== '') {
        $searchResult = searchBook($library, $searchTitle);
    }
}

// LOGICA CANCELLAZIONE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {

    $indexToDelete = (int)$_POST['index'];
    deleteBook($library, $indexToDelete);

    $message = "🗑️ Libro eliminato correttamente.";
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>

<?php include 'header.php'; ?>

<div class="container py-4">

    <!-- MESSAGGI DI SISTEMA -->
    <?php if ($message): ?>
        <div class="alert alert-info text-center fw-bold"><?= $message ?></div>
    <?php endif; ?>

    <!-- FORM AGGIUNTA LIBRO -->
    <h3 class="my-4">Aggiungi un Libro</h3>

    <form method="POST" class="row g-3 mb-4">
        <div class="col-md-4">
            <input type="text" name="title" class="form-control" placeholder="Titolo">
        </div>

        <div class="col-md-4">
            <input type="text" name="author" class="form-control" placeholder="Autore">
        </div>

        <div class="col-md-4">
            <input type="text" name="year" class="form-control" placeholder="Anno (es. 2001)">
        </div>

        <div class="col-md-6">
            <input type="text" name="price" class="form-control" placeholder="Prezzo">
        </div>

        <div class="col-md-6">
            <input type="text" name="pages" class="form-control" placeholder="Numero pagine">
        </div>

        <div class="col-md-3">
            <button class="btn btn-primary w-100" type="submit" name="add">Aggiungi</button>
        </div>
    </form>

    <!-- FORM DI RICERCA -->
    <h3 class="my-4">Ricerca Libro</h3>

    <form method="POST" class="row g-3">
        <div class="col-md-9">
            <input type="text" name="search_title" class="form-control" placeholder="Titolo da cercare...">
        </div>
        <div class="col-md-3">
            <button class="btn btn-secondary w-100" type="submit" name="search">Cerca</button>
        </div>
    </form>

    <!-- RISULTATI RICERCA -->
    <?php if ($searchTitle !== null): ?>
        <h3 class="mt-5">Risultato Ricerca</h3>

        <?php if ($searchResult): ?>
            <div class="card shadow-sm mt-3">
                <div class="card-body">
                    <h5 class="card-title"><?= $searchResult->title ?></h5>
                    <p class="card-text">
                        Autore: <?= $searchResult->author ?><br>
                        Anno: <?= $searchResult->year ?><br>
                        Prezzo: <?= $searchResult->price ?> €<br>
                        Pagine: <?= $searchResult->pages ?>
                    </p>
                </div>
            </div>
        <?php else: ?>
            <p class="text-danger mt-2">Nessun libro trovato.</p>
        <?php endif; ?>
    <?php endif; ?>

    <!-- ELENCO LIBRI -->
    <h3 class="my-4">Elenco Libri</h3>

    <?php if (empty($library)): ?>

        <p class="text-muted">La biblioteca è vuota.</p>

    <?php else: ?>

        <ul class="list-group mb-5">
            <?php foreach ($library as $index => $book): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">

                    <div>
                        <strong><?= $book->title ?></strong><br>
                        <small>
                            Autore: <?= $book->author ?> —
                            Anno: <?= $book->year ?> —
                            <?= $book->price ?> € —
                            <?= $book->pages ?> pagine
                        </small>
                    </div>

                    <form method="POST" onsubmit="return confirm('Eliminare questo libro?')">
                        <input type="hidden" name="index" value="<?= $index ?>">
                        <button type="submit" name="delete" class="btn btn-danger btn-sm">Cancella</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>

    <?php endif; ?>

</div>

<?php include 'footer.php'; ?>

</body>
</html>