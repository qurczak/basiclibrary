<?php

use yii\db\Migration;

/**
 * Handles the creation of table `book`.
 * Has foreign keys to the tables:
 *
 * - `library`
 */
class m170919_183558_create_book_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('book', [
            'id' => $this->primaryKey(),
            'library_id' => $this->integer()->notNull(),
            // should be FK
            'category_id' => $this->integer(),
            'name' => $this->string(128)->notNull(),
            // should be integer
            // There isn't UNIQUE KEY for ISBN and title
            'ISBN' => $this->string(64)->notNull(),
            'title' => $this->string(128)->notNull(),
            // should be FK
            'author' => $this->string(64)->notNull(),
            'date' => $this->dateTime()->notNull(),
        ]);

        // creates index for column `library_id`
        $this->createIndex(
            'idx-book-library_id',
            'book',
            'library_id'
        );

        // add foreign key for table `library`
        $this->addForeignKey(
            'fk-book-library_id',
            'book',
            'library_id',
            'library',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `library`
        $this->dropForeignKey(
            'fk-book-library_id',
            'book'
        );

        // drops index for column `library_id`
        $this->dropIndex(
            'idx-book-library_id',
            'book'
        );

        $this->dropTable('book');
    }
}
