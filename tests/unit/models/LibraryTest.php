<?php

namespace tests\models;

use app\models\Book;
use app\models\Library;
use DateTime;
use PHPUnit\Framework\TestResult;

include_once("helpers.php");


class LibraryTest extends \Codeception\Test\Unit
{

    private $libraryName = "Biblioteka Różana";


    /**
     * Delete library, should delete all books
     */
    public function testDeleteLibraryWithBook()
    {
        $library = createLibrary($this->libraryName);
        createBook($library, 1);

        expect(Library::find()->count())->equals(1);
        expect(Book::find()->count())->equals(1);

        Library::deleteAll();

        expect(Library::find()->count())->equals(0);
        expect(Book::find()->count())->equals(0);

    }

    /**
     * Set up date by us
     */
    public function testLibraryWithDateOwn()
    {
        $olddate = "2000-01-01 01:01:01";
        createLibrary($this->libraryName, $olddate);

        $library = Library::findOne(["name" => $this->libraryName]);
        expect($library->name)->equals($this->libraryName);
        expect($library->date)->equals($olddate);
    }

    /**
     * Fill empty date by model
     */
    public function testLibraryWithDateFromModel()
    {
        // Date filled by model
        $currDate = date("Y-m-d G:i:s");
        createLibrary($this->libraryName);

        $library = Library::findOne(["name" => $this->libraryName]);
        $date_from_db = new DateTime($library->date);
        expect($date_from_db)->greaterOrEquals($currDate);
    }

    /**
     *
     */
    public function testDeleteLibrary()
    {
        createLibrary($this->libraryName);
        $library = Library::findOne(["name" => $this->libraryName]);
        expect($library->name)->equals($this->libraryName);
        $library->delete();
        $number = Library::find()->count();
        expect($number)->equals(0);
    }
}
