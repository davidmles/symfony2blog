<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160324111941 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__author AS SELECT id, createdAt, name FROM author');
        $this->addSql('DROP TABLE author');
        $this->addSql('CREATE TABLE author (id INTEGER NOT NULL, name VARCHAR(100) NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO author (id, created_at, name) SELECT id, createdAt, name FROM __temp__author');
        $this->addSql('DROP TABLE __temp__author');
        $this->addSql('DROP INDEX IDX_5A8A6C8DF675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__post AS SELECT id, author_id, createdAt, title, body, slug FROM post');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TABLE post (id INTEGER NOT NULL, author_id INTEGER NOT NULL, title VARCHAR(150) NOT NULL COLLATE BINARY, body CLOB NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_5A8A6C8DF675F31B FOREIGN KEY (author_id) REFERENCES author (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO post (id, author_id, created_at, title, body, slug) SELECT id, author_id, createdAt, title, body, slug FROM __temp__post');
        $this->addSql('DROP TABLE __temp__post');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DF675F31B ON post (author_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__author AS SELECT id, created_at, name FROM author');
        $this->addSql('DROP TABLE author');
        $this->addSql('CREATE TABLE author (id INTEGER NOT NULL, name VARCHAR(100) NOT NULL, createdAt DATETIME NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO author (id, createdAt, name) SELECT id, created_at, name FROM __temp__author');
        $this->addSql('DROP TABLE __temp__author');
        $this->addSql('DROP INDEX IDX_5A8A6C8DF675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__post AS SELECT id, author_id, created_at, title, slug, body FROM post');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TABLE post (id INTEGER NOT NULL, author_id INTEGER NOT NULL, title VARCHAR(150) NOT NULL, body CLOB NOT NULL, createdAt DATETIME NOT NULL, slug VARCHAR(255) DEFAULT \'""\' NOT NULL COLLATE BINARY, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO post (id, author_id, createdAt, title, slug, body) SELECT id, author_id, created_at, title, slug, body FROM __temp__post');
        $this->addSql('DROP TABLE __temp__post');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DF675F31B ON post (author_id)');
    }
}
