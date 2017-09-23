<?php

use app\models\Book;
use app\models\Library;

$library_name = "Biblioteka rządowa";
$ISBN = "0-306-40615-2";
$name = "Biblioteka rządowa";

$I = new ApiTester($scenario);

// FIXME: Database is not cleared after tests, configuration problem?
Book::deleteAll();
Library::deleteAll();

$I->wantTo('Create book in library via API');


$I->sendPOST('index-test.php/libraries', ['name' => $library_name]);
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
$library = Library::findOne(["name" => $library_name]);


// FIXME: (Ugly hack) Url::toRoute('books') -> Unable to resolve the relative route: books.
// FIXME: No active controller is available.
$I->sendPOST('index-test.php/books', [
    "library_id" => $library->primaryKey,
    "category_id" => 1,
    "ISBN" => $ISBN,
    "author" => "Tom",
    "name" => "Książeczka",
    "title" => "Całe życie w rekurencji. Koncepcja pętli"
]);

$I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
$I->seeResponseIsJson();
$I->seeResponseContainsJson(["ISBN" => '0-306-40615-2']);


$book = Book::findOne([
    "library_id" => $library->primaryKey,
    "ISBN" => $ISBN
]);
$I->sendDELETE('index-test.php/libraries/' . $library->primaryKey);
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::NO_CONTENT);
