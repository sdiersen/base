<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190304145044 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE scheduled_event (id INT AUTO_INCREMENT NOT NULL, presenter_id INT DEFAULT NULL, location_id INT DEFAULT NULL, event_id INT DEFAULT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, start_time TIME DEFAULT NULL, end_time TIME DEFAULT NULL, INDEX IDX_79D3538CDDE4C635 (presenter_id), INDEX IDX_79D3538C64D218E (location_id), INDEX IDX_79D3538C71F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) DEFAULT NULL, short_title VARCHAR(20) DEFAULT NULL, description LONGTEXT DEFAULT NULL, short_description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE scheduled_class (id INT AUTO_INCREMENT NOT NULL, gx_class_id INT DEFAULT NULL, location_id INT DEFAULT NULL, start_time TIME DEFAULT NULL, end_time TIME DEFAULT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, day_of_week VARCHAR(9) DEFAULT NULL, room VARCHAR(25) DEFAULT NULL, INDEX IDX_AF3640B4D53FADE5 (gx_class_id), INDEX IDX_AF3640B464D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE scheduled_class_user (scheduled_class_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_A79C69BF9BD549CF (scheduled_class_id), INDEX IDX_A79C69BFA76ED395 (user_id), PRIMARY KEY(scheduled_class_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gx_class (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) DEFAULT NULL, description LONGTEXT DEFAULT NULL, short_description LONGTEXT DEFAULT NULL, short_name VARCHAR(20) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(30) DEFAULT NULL, last_name VARCHAR(40) DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, location_id INT DEFAULT NULL, type VARCHAR(25) DEFAULT NULL, street_one VARCHAR(255) DEFAULT NULL, street_two VARCHAR(255) DEFAULT NULL, city VARCHAR(40) DEFAULT NULL, state VARCHAR(25) DEFAULT NULL, zip VARCHAR(10) DEFAULT NULL, route VARCHAR(30) DEFAULT NULL, INDEX IDX_D4E6F8164D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE phone (id INT AUTO_INCREMENT NOT NULL, location_id INT DEFAULT NULL, type VARCHAR(25) DEFAULT NULL, number VARCHAR(12) DEFAULT NULL, INDEX IDX_444F97DD64D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(40) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lesson (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) DEFAULT NULL, description LONGTEXT DEFAULT NULL, requirements LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE scheduled_lesson (id INT AUTO_INCREMENT NOT NULL, lesson_id INT DEFAULT NULL, instructor_id INT DEFAULT NULL, location_id INT DEFAULT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, start_time TIME DEFAULT NULL, end_time TIME DEFAULT NULL, days_of_week LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', INDEX IDX_548AF0EACDF80196 (lesson_id), INDEX IDX_548AF0EA8C4FC193 (instructor_id), INDEX IDX_548AF0EA64D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE scheduled_event ADD CONSTRAINT FK_79D3538CDDE4C635 FOREIGN KEY (presenter_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE scheduled_event ADD CONSTRAINT FK_79D3538C64D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE scheduled_event ADD CONSTRAINT FK_79D3538C71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE scheduled_class ADD CONSTRAINT FK_AF3640B4D53FADE5 FOREIGN KEY (gx_class_id) REFERENCES gx_class (id)');
        $this->addSql('ALTER TABLE scheduled_class ADD CONSTRAINT FK_AF3640B464D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE scheduled_class_user ADD CONSTRAINT FK_A79C69BF9BD549CF FOREIGN KEY (scheduled_class_id) REFERENCES scheduled_class (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE scheduled_class_user ADD CONSTRAINT FK_A79C69BFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F8164D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE phone ADD CONSTRAINT FK_444F97DD64D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE scheduled_lesson ADD CONSTRAINT FK_548AF0EACDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id)');
        $this->addSql('ALTER TABLE scheduled_lesson ADD CONSTRAINT FK_548AF0EA8C4FC193 FOREIGN KEY (instructor_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE scheduled_lesson ADD CONSTRAINT FK_548AF0EA64D218E FOREIGN KEY (location_id) REFERENCES location (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE scheduled_event DROP FOREIGN KEY FK_79D3538C71F7E88B');
        $this->addSql('ALTER TABLE scheduled_class_user DROP FOREIGN KEY FK_A79C69BF9BD549CF');
        $this->addSql('ALTER TABLE scheduled_class DROP FOREIGN KEY FK_AF3640B4D53FADE5');
        $this->addSql('ALTER TABLE scheduled_event DROP FOREIGN KEY FK_79D3538CDDE4C635');
        $this->addSql('ALTER TABLE scheduled_class_user DROP FOREIGN KEY FK_A79C69BFA76ED395');
        $this->addSql('ALTER TABLE scheduled_lesson DROP FOREIGN KEY FK_548AF0EA8C4FC193');
        $this->addSql('ALTER TABLE scheduled_event DROP FOREIGN KEY FK_79D3538C64D218E');
        $this->addSql('ALTER TABLE scheduled_class DROP FOREIGN KEY FK_AF3640B464D218E');
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F8164D218E');
        $this->addSql('ALTER TABLE phone DROP FOREIGN KEY FK_444F97DD64D218E');
        $this->addSql('ALTER TABLE scheduled_lesson DROP FOREIGN KEY FK_548AF0EA64D218E');
        $this->addSql('ALTER TABLE scheduled_lesson DROP FOREIGN KEY FK_548AF0EACDF80196');
        $this->addSql('DROP TABLE scheduled_event');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE scheduled_class');
        $this->addSql('DROP TABLE scheduled_class_user');
        $this->addSql('DROP TABLE gx_class');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE phone');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE lesson');
        $this->addSql('DROP TABLE scheduled_lesson');
    }
}
