<?php

use yii\db\Migration;

/**
 * Handles the creation of table `library`.
 */
class m170919_183553_create_library_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('library', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64)->notNull()->unique(),
            'date' => $this->dateTime()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('library');
    }
}
