<?php

namespace tests\models;

use app\models\Book;
use app\models\Library;

include_once("helpers.php");


class BookTest extends \Codeception\Test\Unit
{

    public function testCreateBook()
    {
        $library = createLibrary("Biblioteka Wołomin");
        expect($library->name)->equals("Biblioteka Wołomin");
        createBook($library, 1);

        $book = Book::findOne([
            "name" => "Książka",
            "library_id" => $library->primaryKey
        ]);

        expect($book->name)->equals("Książka");
        expect($book->category_id)->equals(1);
        expect($book->ISBN)->equals("0-306-40615-2");
        expect($book->title)->equals("Programowanie w X");
        expect($book->author)->equals("Brzęczyszczykiewicz Jan");
        expect($book->date);
    }

    public function testDeleteBook()
    {
        $library = createLibrary("Biblioteka Wołomin");
        expect($library->name)->equals("Biblioteka Wołomin");
        createBook($library, 1);

        $book = Book::findOne([
            "name" => "Książka",
            "library_id" => $library->primaryKey
        ]);

        // Delete Book, Library should be not deleted
        $book->delete();

        $book = Book::findOne([
            "name" => "Książka",
            "library_id" => $library->primaryKey
        ]);
        expect($book)->null();
        expect(Library::find()->count())->equals(1);
    }
}
