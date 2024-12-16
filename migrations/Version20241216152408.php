<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241216152408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id SERIAL NOT NULL, libelle VARCHAR(25) NOT NULL, qte_stock INT NOT NULL, prix INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE client (id SERIAL NOT NULL, user_account_id INT DEFAULT NULL, surname VARCHAR(255) NOT NULL, telephone VARCHAR(22) NOT NULL, adresse VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C74404553C0C9956 ON client (user_account_id)');
        $this->addSql('CREATE TABLE debt (id SERIAL NOT NULL, client_id INT DEFAULT NULL, mount INT NOT NULL, date DATE NOT NULL, paid_mount INT NOT NULL, remaining_mount INT NOT NULL, is_achieved BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DBBF0A8319EB6921 ON debt (client_id)');
        $this->addSql('CREATE TABLE debt_request (id SERIAL NOT NULL, client_id INT DEFAULT NULL, date DATE NOT NULL, total_amount INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_23A25C7D19EB6921 ON debt_request (client_id)');
        $this->addSql('CREATE TABLE detail_debt (id SERIAL NOT NULL, debt_id INT DEFAULT NULL, article_id INT DEFAULT NULL, quantity INT NOT NULL, prix INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2CEAE20C240326A5 ON detail_debt (debt_id)');
        $this->addSql('CREATE INDEX IDX_2CEAE20C7294869C ON detail_debt (article_id)');
        $this->addSql('CREATE TABLE detail_debt_request (id SERIAL NOT NULL, article_id INT DEFAULT NULL, debt_request_id INT DEFAULT NULL, quantity INT NOT NULL, prix INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3FA136727294869C ON detail_debt_request (article_id)');
        $this->addSql('CREATE INDEX IDX_3FA1367214BEEE8C ON detail_debt_request (debt_request_id)');
        $this->addSql('CREATE TABLE payment (id SERIAL NOT NULL, debt_id INT DEFAULT NULL, date DATE NOT NULL, amount INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6D28840D240326A5 ON payment (debt_id)');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, client_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, login VARCHAR(20) DEFAULT NULL, is_active BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64919EB6921 ON "user" (client_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C74404553C0C9956 FOREIGN KEY (user_account_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE debt ADD CONSTRAINT FK_DBBF0A8319EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE debt_request ADD CONSTRAINT FK_23A25C7D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE detail_debt ADD CONSTRAINT FK_2CEAE20C240326A5 FOREIGN KEY (debt_id) REFERENCES debt (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE detail_debt ADD CONSTRAINT FK_2CEAE20C7294869C FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE detail_debt_request ADD CONSTRAINT FK_3FA136727294869C FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE detail_debt_request ADD CONSTRAINT FK_3FA1367214BEEE8C FOREIGN KEY (debt_request_id) REFERENCES debt_request (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D240326A5 FOREIGN KEY (debt_id) REFERENCES debt (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D64919EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE client DROP CONSTRAINT FK_C74404553C0C9956');
        $this->addSql('ALTER TABLE debt DROP CONSTRAINT FK_DBBF0A8319EB6921');
        $this->addSql('ALTER TABLE debt_request DROP CONSTRAINT FK_23A25C7D19EB6921');
        $this->addSql('ALTER TABLE detail_debt DROP CONSTRAINT FK_2CEAE20C240326A5');
        $this->addSql('ALTER TABLE detail_debt DROP CONSTRAINT FK_2CEAE20C7294869C');
        $this->addSql('ALTER TABLE detail_debt_request DROP CONSTRAINT FK_3FA136727294869C');
        $this->addSql('ALTER TABLE detail_debt_request DROP CONSTRAINT FK_3FA1367214BEEE8C');
        $this->addSql('ALTER TABLE payment DROP CONSTRAINT FK_6D28840D240326A5');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D64919EB6921');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE debt');
        $this->addSql('DROP TABLE debt_request');
        $this->addSql('DROP TABLE detail_debt');
        $this->addSql('DROP TABLE detail_debt_request');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
