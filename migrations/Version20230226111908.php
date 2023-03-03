<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230226111908 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE anneescolaire (id INT AUTO_INCREMENT NOT NULL, annee VARCHAR(9) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, INDEX IDX_3AF34668727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classe (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eleves (id INT AUTO_INCREMENT NOT NULL, niveau_id INT DEFAULT NULL, classe_id INT NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, codemassar VARCHAR(20) NOT NULL, image VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_383B09B12A478587 (codemassar), INDEX IDX_383B09B1B3E9C81 (niveau_id), INDEX IDX_383B09B18F5EA509 (classe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enseignants (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enseignants_matiere (enseignants_id INT NOT NULL, matiere_id INT NOT NULL, INDEX IDX_2A304E287CF12A69 (enseignants_id), INDEX IDX_2A304E28F46CD258 (matiere_id), PRIMARY KEY(enseignants_id, matiere_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enseignants_niveau (enseignants_id INT NOT NULL, niveau_id INT NOT NULL, INDEX IDX_BFF0949F7CF12A69 (enseignants_id), INDEX IDX_BFF0949FB3E9C81 (niveau_id), PRIMARY KEY(enseignants_id, niveau_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enseignants_classe (enseignants_id INT NOT NULL, classe_id INT NOT NULL, INDEX IDX_7BA8D8627CF12A69 (enseignants_id), INDEX IDX_7BA8D8628F5EA509 (classe_id), PRIMARY KEY(enseignants_id, classe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enseignants_anneescolaire (enseignants_id INT NOT NULL, anneescolaire_id INT NOT NULL, INDEX IDX_28135D017CF12A69 (enseignants_id), INDEX IDX_28135D017DEA6356 (anneescolaire_id), PRIMARY KEY(enseignants_id, anneescolaire_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matiere (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, lastname VARCHAR(100) NOT NULL, firstname VARCHAR(100) NOT NULL, address VARCHAR(255) NOT NULL, zipcode VARCHAR(5) NOT NULL, city VARCHAR(150) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_authenticator (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_53013882E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF34668727ACA70 FOREIGN KEY (parent_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE eleves ADD CONSTRAINT FK_383B09B1B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('ALTER TABLE eleves ADD CONSTRAINT FK_383B09B18F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE enseignants_matiere ADD CONSTRAINT FK_2A304E287CF12A69 FOREIGN KEY (enseignants_id) REFERENCES enseignants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE enseignants_matiere ADD CONSTRAINT FK_2A304E28F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE enseignants_niveau ADD CONSTRAINT FK_BFF0949F7CF12A69 FOREIGN KEY (enseignants_id) REFERENCES enseignants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE enseignants_niveau ADD CONSTRAINT FK_BFF0949FB3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE enseignants_classe ADD CONSTRAINT FK_7BA8D8627CF12A69 FOREIGN KEY (enseignants_id) REFERENCES enseignants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE enseignants_classe ADD CONSTRAINT FK_7BA8D8628F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE enseignants_anneescolaire ADD CONSTRAINT FK_28135D017CF12A69 FOREIGN KEY (enseignants_id) REFERENCES enseignants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE enseignants_anneescolaire ADD CONSTRAINT FK_28135D017DEA6356 FOREIGN KEY (anneescolaire_id) REFERENCES anneescolaire (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF34668727ACA70');
        $this->addSql('ALTER TABLE eleves DROP FOREIGN KEY FK_383B09B1B3E9C81');
        $this->addSql('ALTER TABLE eleves DROP FOREIGN KEY FK_383B09B18F5EA509');
        $this->addSql('ALTER TABLE enseignants_matiere DROP FOREIGN KEY FK_2A304E287CF12A69');
        $this->addSql('ALTER TABLE enseignants_matiere DROP FOREIGN KEY FK_2A304E28F46CD258');
        $this->addSql('ALTER TABLE enseignants_niveau DROP FOREIGN KEY FK_BFF0949F7CF12A69');
        $this->addSql('ALTER TABLE enseignants_niveau DROP FOREIGN KEY FK_BFF0949FB3E9C81');
        $this->addSql('ALTER TABLE enseignants_classe DROP FOREIGN KEY FK_7BA8D8627CF12A69');
        $this->addSql('ALTER TABLE enseignants_classe DROP FOREIGN KEY FK_7BA8D8628F5EA509');
        $this->addSql('ALTER TABLE enseignants_anneescolaire DROP FOREIGN KEY FK_28135D017CF12A69');
        $this->addSql('ALTER TABLE enseignants_anneescolaire DROP FOREIGN KEY FK_28135D017DEA6356');
        $this->addSql('DROP TABLE anneescolaire');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE eleves');
        $this->addSql('DROP TABLE enseignants');
        $this->addSql('DROP TABLE enseignants_matiere');
        $this->addSql('DROP TABLE enseignants_niveau');
        $this->addSql('DROP TABLE enseignants_classe');
        $this->addSql('DROP TABLE enseignants_anneescolaire');
        $this->addSql('DROP TABLE matiere');
        $this->addSql('DROP TABLE niveau');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE users_authenticator');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
