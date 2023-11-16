<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231116150140 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD pp_image_name VARCHAR(255) DEFAULT NULL, ADD pp_image_size INT DEFAULT NULL, ADD banner_image_name VARCHAR(255) DEFAULT NULL, ADD banner_image_size INT DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP pp_url, DROP banner_url');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` ADD pp_url VARCHAR(255) DEFAULT NULL, ADD banner_url VARCHAR(255) DEFAULT NULL, DROP pp_image_name, DROP pp_image_size, DROP banner_image_name, DROP banner_image_size, DROP updated_at');
    }
}
