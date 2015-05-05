<?php

namespace ImageUplaoder\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150504094702 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(32) NOT NULL, last_name VARCHAR(32) NOT NULL, user_name VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(500) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E924A232CF (user_name), UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), UNIQUE INDEX user (user_name, email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hashtags (id INT AUTO_INCREMENT NOT NULL, hash_tag VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, location VARCHAR(255) NOT NULL, image_size INT NOT NULL, INDEX IDX_E01FBE6AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images_hashtags (image_id INT NOT NULL, hashtag_id INT NOT NULL, INDEX IDX_82C256853DA5256D (image_id), INDEX IDX_82C25685FB34EF56 (hashtag_id), PRIMARY KEY(image_id, hashtag_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE images_hashtags ADD CONSTRAINT FK_82C256853DA5256D FOREIGN KEY (image_id) REFERENCES images (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE images_hashtags ADD CONSTRAINT FK_82C25685FB34EF56 FOREIGN KEY (hashtag_id) REFERENCES hashtags (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6AA76ED395');
        $this->addSql('ALTER TABLE images_hashtags DROP FOREIGN KEY FK_82C25685FB34EF56');
        $this->addSql('ALTER TABLE images_hashtags DROP FOREIGN KEY FK_82C256853DA5256D');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE hashtags');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE images_hashtags');
    }
}
