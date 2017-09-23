<?php

use app\models\Library;

$library_name = "Biblioteka rządowa";

$I = new ApiTester($scenario);

// FIXME: Database is not cleared after tests, configuration problem?
Library::deleteAll();

$I->wantTo('Create library via API');

// FIXME: (Ugly hack) Url::toRoute('libraries') -> Unable to resolve the relative route: libraries.
// FIXME No active controller is available.
$I->sendPOST('index-test.php/libraries', ['name' => $library_name]);
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED); // 200
$I->seeResponseIsJson();
$I->seeResponseContainsJson(["name" => $library_name]);


$library = Library::findOne(["name" => $library_name]);
$I->sendDELETE('index-test.php/libraries/' . $library->primaryKey);
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::NO_CONTENT);
