<?php
/**
 * Helpers for tests
 */

use app\models\Book;
use app\models\Library;


/**
 * @param $library_name
 * @param string $date
 * @return Library
 */
function createLibrary($library_name, $date = "")
{
    $library = new Library();
    $library->name = $library_name;
    if ($date != "") {
        $library->date = $date;

    }
    $library->save();
    return $library;
}

/**
 * @param $library
 * @param $category_id
 * @param $name
 * @return Book
 */
function createBook($library, $category_id, $name = "")
{
    $book = new Book();
    $book->library_id = $library->primaryKey;
    $book->category_id = $category_id;
    $book->name = $name ? $name : "Książka";
    $book->ISBN = "0-306-40615-2";
    $book->title = "Programowanie w X";
    $book->author = "Brzęczyszczykiewicz Jan";
    $book->save();
    return $book;
}
