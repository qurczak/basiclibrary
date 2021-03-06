Basic Library
=============


Application written in [Yii 2](http://www.yiiframework.com/) framework.
Simple API for create Books and Libraries through API call.


Problems with token and composer
--------------------------------

Create an OAuth token on GitHub. Read more on this.
https://github.com/settings/tokens

Add it to the configuration running composer config -g github-oauth.github.com <oauthtoken>

~~~
composer config --global github-oauth.github.com <TOKEN>
composer global require "fxp/composer-asset-plugin:^1.3.1"
~~~


### Source code

~~~
$ cd ~
$ git clone https://github.com/qurczak/basiclibrary.git
$ cd basiclibrary
$ export PATH=$PATH:$PWD:$PWD/vendor/bin
$ chmod u+x yii
$ composer update
$ php requirements.php
~~~


### Change database password

Change password:

[PROJECT_DIR]/config/db_password.php

```php
return [
    'password' => 'asdzxc',
];
```

Change password for tests

[PROJECT_DID]/codeception.yml

```yaml
modules:
    config:
        Db:
            dsn: 'mysql:host=localhost;dbname=yii2_basic_tests'
            user: 'root'
            password: 'asdzxc'
```

Create databases:

```sql
DB:> CREATE DATABASE yii2basic CHARACTER SET utf8 COLLATE utf8_unicode_ci;
DB:> CREATE DATABASE yii2_basic_tests CHARACTER SET utf8 COLLATE utf8_unicode_ci;
```

Run migration

~~~
$ yii migrate
~~~

### Testing

Run development server for testing API, without this you'll see error like this:

~~~
  [GuzzleHttp\Exception\ConnectException] cURL error 7: Failed to connect to localhost port 8000: Connection refused (see http://curl.haxx.se/libcurl/c/libcurl-errors.html)  
~~~

~~~
$ cd [PROJECT_DIR]
$ export PATH=$PATH:$PWD:$PWD/vendor/bin
$ yii serve/index --port=8000
~~~

Run all tests or specific test

~~~
codecept build
codecept run
codecept run api
codecept run unit  # Development server not required
codecept run unit tests/unit/models/LibraryTest.php
~~~


We should see output like this.

```
$:~basiclibrary$ codecept run 
Codeception PHP Testing Framework v2.3.5
Powered by PHPUnit 6.2.4 by Sebastian Bergmann and contributors.

Api Tests (2) ---------------------------------------------------------------------------------------------------------------------------------------------------------------
✔ CreateDeleteBookCept: Create book in library via api (0.23s)
✔ CreateDeleteLibraryCept: Create library via api (0.09s)
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

Functional Tests (10) -------------------------------------------------------------------------------------------------------------------------------------------------------
✔ ContactFormCest: Open contact page (0.07s)
✔ ContactFormCest: Submit empty form (0.03s)
✔ ContactFormCest: Submit form with incorrect email (0.02s)
✔ ContactFormCest: Submit form successfully (0.02s)
✔ LoginFormCest: Open login page (0.00s)
✔ LoginFormCest: Internal login by id (0.01s)
✔ LoginFormCest: Internal login by instance (0.00s)
✔ LoginFormCest: Login with empty credentials (0.01s)
✔ LoginFormCest: Login with wrong credentials (0.01s)
✔ LoginFormCest: Login successfully (0.01s)
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

Unit Tests (14) -------------------------------------------------------------------------------------------------------------------------------------------------------------
✔ BookTest: Create book (0.01s)
✔ BookTest: Delete book (0.01s)
✔ ContactFormTest: Email is sent on contact (0.01s)
✔ LibraryTest: Delete library with book (0.01s)
✔ LibraryTest: Library with date own (0.00s)
✔ LibraryTest: Library with date from model (0.00s)
✔ LibraryTest: Delete library (0.00s)
✔ LoginFormTest: Login no user (0.00s)
✔ LoginFormTest: Login wrong password (0.00s)
✔ LoginFormTest: Login correct (0.00s)
✔ UserTest: Find user by id (0.00s)
✔ UserTest: Find user by access token (0.00s)
✔ UserTest: Find user by username (0.00s)
✔ UserTest: Validate user (0.00s)
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------


Time: 1.35 seconds, Memory: 28.00MB

OK (26 tests, 82 assertions)
```


### API access

~~~
$ cd [PROJECT_DIR]
$ export PATH=$PATH:$PWD:$PWD/vendor/bin
$ yii serve/index --port=8000
~~~

Normal endpoint.

~~~
http://localhost:8000/
http://localhost:8000/books
http://localhost:8000/libraries
~~~

Test server. 

~~~
http://localhost:8000/
http://localhost:8000/index-test.php/books
http://localhost:8000/index-test.php/libraries
~~~

### Access to API via console

Listing

~~~
$ curl -i -H "Accept:application/json" "http://localhost:8000/libraries"
$ curl -i -H "Accept:application/json" "http://localhost:8000/books"
~~~

Simple create

~~~
$ curl -i -H "Accept:application/json" -H "Content-Type:application/json" -XPOST "http://localhost:8000/libraries" -d '{"name": "Biblioteka rządowa"}'
...
{"name":"Biblioteka rządowa","date":"2017-09-24 10:52:16","id":1}
...
~~~

To delete, use ID from previous response

~~~
curl -i -H "Accept:application/json" -H "Content-Type:application/json" -XDELETE "http://localhost:8000/libraries/1"

...
HTTP/1.1 204 No Content
...
~~~

Create book (specific library does not exists)

~~~
$ curl -i -H "Accept:application/json" -H "Content-Type:application/json" -XPOST "http://localhost:8000/books" -d '{"library_id": "1", "category_id": 1, "ISBN": "0-306-40615-2", "author": "Tom", "name": "Book1", "title": "Title1"}'

...
HTTP/1.1 500 Internal Server Error
...
~~~

Create book (specific library exists)

~~~
$ curl -i -H "Accept:application/json" -H "Content-Type:application/json" -XPOST "http://localhost:8000/books" -d '{"library_id": "1", "category_id": 1, "ISBN": "0-306-40615-2", "author": "Tom", "name": "Book1", "title": "Title1"}'

...
HTTP/1.1 201 Created
...
~~~
