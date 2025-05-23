<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250523155457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE authors (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE book_issues (id INT AUTO_INCREMENT NOT NULL, book_id INT NOT NULL, reader_id INT NOT NULL, issued_at DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_F3AA740E16A2B381 (book_id), INDEX IDX_F3AA740E1717D737 (reader_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE book_returns (id INT AUTO_INCREMENT NOT NULL, book_issue_id INT NOT NULL, returned_at DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_183664334785B3D5 (book_issue_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE books (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, title VARCHAR(255) NOT NULL, isbn VARCHAR(13) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_4A1B2A92CC1CF4E6 (isbn), INDEX IDX_4A1B2A92F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE readers (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_34AD8C05E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE book_issues ADD CONSTRAINT FK_F3AA740E16A2B381 FOREIGN KEY (book_id) REFERENCES books (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE book_issues ADD CONSTRAINT FK_F3AA740E1717D737 FOREIGN KEY (reader_id) REFERENCES readers (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE book_returns ADD CONSTRAINT FK_183664334785B3D5 FOREIGN KEY (book_issue_id) REFERENCES book_issues (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE books ADD CONSTRAINT FK_4A1B2A92F675F31B FOREIGN KEY (author_id) REFERENCES authors (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE book_issues DROP FOREIGN KEY FK_F3AA740E16A2B381
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE book_issues DROP FOREIGN KEY FK_F3AA740E1717D737
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE book_returns DROP FOREIGN KEY FK_183664334785B3D5
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE books DROP FOREIGN KEY FK_4A1B2A92F675F31B
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE authors
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE book_issues
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE book_returns
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE books
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE readers
        SQL);
    }
}
