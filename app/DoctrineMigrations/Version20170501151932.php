<?php

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170501151932 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $table = $schema->createTable('project');
        $table->addColumn('id', Type::GUID);
        $table->addColumn('name', Type::STRING)
            ->setLength(100);
        $table->addColumn('start_date', Type::DATE);
        $table->addColumn('end_date', Type::DATE)
            ->setNotnull(false);
        $table->addColumn('vacancies', Type::SMALLINT)
            ->setNotnull(false)
            ->setDefault(null);

        $table->setPrimaryKey(['id']);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('project');
    }
}
