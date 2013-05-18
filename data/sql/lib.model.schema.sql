
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- saga
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `saga`;


CREATE TABLE `saga`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`titre` VARCHAR(255)  NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `saga_U_1` (`titre`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- nationalite
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `nationalite`;


CREATE TABLE `nationalite`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`pays` VARCHAR(255)  NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `nationalite_U_1` (`pays`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- personne
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `personne`;


CREATE TABLE `personne`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`nom` VARCHAR(255)  NOT NULL,
	`prenom` VARCHAR(255)  NOT NULL,
	`nom_prenom_clean` VARCHAR(255)  NOT NULL,
	`image` VARCHAR(255),
	`date_naissance` DATE,
	`date_deces` DATE,
	`nb_visite` INTEGER,
	`nationalite_id` INTEGER,
	PRIMARY KEY (`id`),
	UNIQUE KEY `personne_U_1` (`nom_prenom_clean`),
	INDEX `personne_FI_1` (`nationalite_id`),
	CONSTRAINT `personne_FK_1`
		FOREIGN KEY (`nationalite_id`)
		REFERENCES `nationalite` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- qualite
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `qualite`;


CREATE TABLE `qualite`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`nom` VARCHAR(255)  NOT NULL,
	`description` TEXT,
	PRIMARY KEY (`id`),
	UNIQUE KEY `qualite_U_1` (`nom`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- version
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `version`;


CREATE TABLE `version`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`nom` VARCHAR(255)  NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `version_U_1` (`nom`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- video
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `video`;


CREATE TABLE `video`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`type` enum('film','spectacle','episode')  NOT NULL,
	`saison_id` INTEGER,
	`numero` INTEGER,
	`saga_id` INTEGER,
	`realisateur_id` INTEGER  NOT NULL,
	`titre` VARCHAR(255)  NOT NULL,
	`sous_titre` VARCHAR(255),
	`titre_original` VARCHAR(255),
	`titre_clean` VARCHAR(255)  NOT NULL,
	`avertissement` TEXT,
	`resume` TEXT,
	`image` VARCHAR(255),
	`bande_annonce` VARCHAR(255),
	`annee_sortie` INTEGER,
	`duree` INTEGER,
	`qualite_id` INTEGER  NOT NULL,
	`version_id` INTEGER,
	`nb_visite` INTEGER,
	`is_public` TINYINT default 1 NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `video_FI_1` (`saison_id`),
	CONSTRAINT `video_FK_1`
		FOREIGN KEY (`saison_id`)
		REFERENCES `saison` (`id`),
	INDEX `video_FI_2` (`saga_id`),
	CONSTRAINT `video_FK_2`
		FOREIGN KEY (`saga_id`)
		REFERENCES `saga` (`id`),
	INDEX `video_FI_3` (`realisateur_id`),
	CONSTRAINT `video_FK_3`
		FOREIGN KEY (`realisateur_id`)
		REFERENCES `personne` (`id`),
	INDEX `video_FI_4` (`qualite_id`),
	CONSTRAINT `video_FK_4`
		FOREIGN KEY (`qualite_id`)
		REFERENCES `qualite` (`id`),
	INDEX `video_FI_5` (`version_id`),
	CONSTRAINT `video_FK_5`
		FOREIGN KEY (`version_id`)
		REFERENCES `version` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- serie
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `serie`;


CREATE TABLE `serie`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`realisateur_id` INTEGER  NOT NULL,
	`titre` VARCHAR(255)  NOT NULL,
	`sous_titre` VARCHAR(255),
	`titre_original` VARCHAR(255),
	`titre_clean` VARCHAR(255)  NOT NULL,
	`bande_annonce` VARCHAR(255),
	`image` VARCHAR(255),
	`resume` TEXT,
	`annee_diffusion` VARCHAR(255),
	`format_duree` INTEGER,
	`is_public` TINYINT default 1 NOT NULL,
	`nb_visite` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `serie_FI_1` (`realisateur_id`),
	CONSTRAINT `serie_FK_1`
		FOREIGN KEY (`realisateur_id`)
		REFERENCES `personne` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- saison
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `saison`;


CREATE TABLE `saison`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`serie_id` INTEGER  NOT NULL,
	`numero` INTEGER  NOT NULL,
	`realisateur_id` INTEGER  NOT NULL,
	`titre` VARCHAR(255),
	`sous_titre` VARCHAR(255),
	`titre_original` VARCHAR(255),
	`titre_clean` VARCHAR(255),
	`nb_episode_tot` INTEGER,
	`nb_episode_possede` INTEGER,
	`version_generale_id` INTEGER,
	`bande_annonce` VARCHAR(255),
	`resume` TEXT,
	`image` VARCHAR(255),
	`annee_diffusion` VARCHAR(255),
	`is_public` TINYINT default 1 NOT NULL,
	`nb_visite` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `saison_FI_1` (`serie_id`),
	CONSTRAINT `saison_FK_1`
		FOREIGN KEY (`serie_id`)
		REFERENCES `serie` (`id`),
	INDEX `saison_FI_2` (`realisateur_id`),
	CONSTRAINT `saison_FK_2`
		FOREIGN KEY (`realisateur_id`)
		REFERENCES `personne` (`id`),
	INDEX `saison_FI_3` (`version_generale_id`),
	CONSTRAINT `saison_FK_3`
		FOREIGN KEY (`version_generale_id`)
		REFERENCES `version` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- utilisateur
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `utilisateur`;


CREATE TABLE `utilisateur`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`nom` VARCHAR(255),
	`prenom` VARCHAR(255),
	`nom_prenom_clean` VARCHAR(255),
	`image` VARCHAR(255),
	`login` VARCHAR(255)  NOT NULL,
	`pass` VARCHAR(255)  NOT NULL,
	`date_naissance` VARCHAR(255),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- noteserie
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `noteserie`;


CREATE TABLE `noteserie`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`saison_id` INTEGER  NOT NULL,
	`utilisateur_id` INTEGER  NOT NULL,
	`note` INTEGER  NOT NULL,
	`message` TEXT  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `noteserie_FI_1` (`saison_id`),
	CONSTRAINT `noteserie_FK_1`
		FOREIGN KEY (`saison_id`)
		REFERENCES `saison` (`id`),
	INDEX `noteserie_FI_2` (`utilisateur_id`),
	CONSTRAINT `noteserie_FK_2`
		FOREIGN KEY (`utilisateur_id`)
		REFERENCES `utilisateur` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- notevideo
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `notevideo`;


CREATE TABLE `notevideo`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`video_id` INTEGER  NOT NULL,
	`utilisateur_id` INTEGER  NOT NULL,
	`note` INTEGER  NOT NULL,
	`message` TEXT  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `notevideo_FI_1` (`video_id`),
	CONSTRAINT `notevideo_FK_1`
		FOREIGN KEY (`video_id`)
		REFERENCES `video` (`id`),
	INDEX `notevideo_FI_2` (`utilisateur_id`),
	CONSTRAINT `notevideo_FK_2`
		FOREIGN KEY (`utilisateur_id`)
		REFERENCES `utilisateur` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- commentaireacteur
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `commentaireacteur`;


CREATE TABLE `commentaireacteur`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`acteur_id` INTEGER  NOT NULL,
	`utilisateur_id` INTEGER  NOT NULL,
	`message` TEXT  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `commentaireacteur_FI_1` (`acteur_id`),
	CONSTRAINT `commentaireacteur_FK_1`
		FOREIGN KEY (`acteur_id`)
		REFERENCES `personne` (`id`),
	INDEX `commentaireacteur_FI_2` (`utilisateur_id`),
	CONSTRAINT `commentaireacteur_FK_2`
		FOREIGN KEY (`utilisateur_id`)
		REFERENCES `utilisateur` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- commentairerealisateur
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `commentairerealisateur`;


CREATE TABLE `commentairerealisateur`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`realisateur_id` INTEGER  NOT NULL,
	`utilisateur_id` INTEGER  NOT NULL,
	`message` TEXT  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `commentairerealisateur_FI_1` (`realisateur_id`),
	CONSTRAINT `commentairerealisateur_FK_1`
		FOREIGN KEY (`realisateur_id`)
		REFERENCES `personne` (`id`),
	INDEX `commentairerealisateur_FI_2` (`utilisateur_id`),
	CONSTRAINT `commentairerealisateur_FK_2`
		FOREIGN KEY (`utilisateur_id`)
		REFERENCES `utilisateur` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- categorie
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `categorie`;


CREATE TABLE `categorie`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`nom` VARCHAR(255)  NOT NULL,
	`nom_clean` VARCHAR(255),
	PRIMARY KEY (`id`),
	UNIQUE KEY `categorie_U_1` (`nom`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- motscle
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `motscle`;


CREATE TABLE `motscle`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`mot` VARCHAR(255)  NOT NULL,
	`mot_clean` VARCHAR(255),
	PRIMARY KEY (`id`),
	UNIQUE KEY `motscle_U_1` (`mot`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- acteurvideo
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `acteurvideo`;


CREATE TABLE `acteurvideo`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`acteur_id` INTEGER  NOT NULL,
	`video_id` INTEGER  NOT NULL,
	`created_at` DATETIME,
	PRIMARY KEY (`id`,`acteur_id`,`video_id`),
	INDEX `acteurvideo_FI_1` (`acteur_id`),
	CONSTRAINT `acteurvideo_FK_1`
		FOREIGN KEY (`acteur_id`)
		REFERENCES `personne` (`id`)
		ON DELETE CASCADE,
	INDEX `acteurvideo_FI_2` (`video_id`),
	CONSTRAINT `acteurvideo_FK_2`
		FOREIGN KEY (`video_id`)
		REFERENCES `video` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- acteurserie
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `acteurserie`;


CREATE TABLE `acteurserie`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`acteur_id` INTEGER  NOT NULL,
	`saison_id` INTEGER  NOT NULL,
	`created_at` DATETIME,
	PRIMARY KEY (`id`,`acteur_id`,`saison_id`),
	INDEX `acteurserie_FI_1` (`acteur_id`),
	CONSTRAINT `acteurserie_FK_1`
		FOREIGN KEY (`acteur_id`)
		REFERENCES `personne` (`id`)
		ON DELETE CASCADE,
	INDEX `acteurserie_FI_2` (`saison_id`),
	CONSTRAINT `acteurserie_FK_2`
		FOREIGN KEY (`saison_id`)
		REFERENCES `saison` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- categorievideo
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `categorievideo`;


CREATE TABLE `categorievideo`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`categorie_id` INTEGER  NOT NULL,
	`video_id` INTEGER  NOT NULL,
	PRIMARY KEY (`id`,`categorie_id`,`video_id`),
	INDEX `categorievideo_FI_1` (`categorie_id`),
	CONSTRAINT `categorievideo_FK_1`
		FOREIGN KEY (`categorie_id`)
		REFERENCES `categorie` (`id`)
		ON DELETE CASCADE,
	INDEX `categorievideo_FI_2` (`video_id`),
	CONSTRAINT `categorievideo_FK_2`
		FOREIGN KEY (`video_id`)
		REFERENCES `video` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- categorieserie
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `categorieserie`;


CREATE TABLE `categorieserie`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`categorie_id` INTEGER  NOT NULL,
	`serie_id` INTEGER  NOT NULL,
	PRIMARY KEY (`id`,`categorie_id`,`serie_id`),
	INDEX `categorieserie_FI_1` (`categorie_id`),
	CONSTRAINT `categorieserie_FK_1`
		FOREIGN KEY (`categorie_id`)
		REFERENCES `categorie` (`id`)
		ON DELETE CASCADE,
	INDEX `categorieserie_FI_2` (`serie_id`),
	CONSTRAINT `categorieserie_FK_2`
		FOREIGN KEY (`serie_id`)
		REFERENCES `serie` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- motsclevideo
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `motsclevideo`;


CREATE TABLE `motsclevideo`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`motscle_id` INTEGER  NOT NULL,
	`video_id` INTEGER  NOT NULL,
	PRIMARY KEY (`id`,`motscle_id`,`video_id`),
	INDEX `motsclevideo_FI_1` (`motscle_id`),
	CONSTRAINT `motsclevideo_FK_1`
		FOREIGN KEY (`motscle_id`)
		REFERENCES `motscle` (`id`)
		ON DELETE CASCADE,
	INDEX `motsclevideo_FI_2` (`video_id`),
	CONSTRAINT `motsclevideo_FK_2`
		FOREIGN KEY (`video_id`)
		REFERENCES `video` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- motscleserie
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `motscleserie`;


CREATE TABLE `motscleserie`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`motscle_id` INTEGER  NOT NULL,
	`saison_id` INTEGER  NOT NULL,
	PRIMARY KEY (`id`,`motscle_id`,`saison_id`),
	INDEX `motscleserie_FI_1` (`motscle_id`),
	CONSTRAINT `motscleserie_FK_1`
		FOREIGN KEY (`motscle_id`)
		REFERENCES `motscle` (`id`)
		ON DELETE CASCADE,
	INDEX `motscleserie_FI_2` (`saison_id`),
	CONSTRAINT `motscleserie_FK_2`
		FOREIGN KEY (`saison_id`)
		REFERENCES `saison` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- noteserieAdmin
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `noteserieAdmin`;


CREATE TABLE `noteserieAdmin`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`saison_id` INTEGER  NOT NULL,
	`utilisateur_id` INTEGER  NOT NULL,
	`note` INTEGER  NOT NULL,
	`message` TEXT  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `noteserieAdmin_FI_1` (`saison_id`),
	CONSTRAINT `noteserieAdmin_FK_1`
		FOREIGN KEY (`saison_id`)
		REFERENCES `saison` (`id`),
	INDEX `noteserieAdmin_FI_2` (`utilisateur_id`),
	CONSTRAINT `noteserieAdmin_FK_2`
		FOREIGN KEY (`utilisateur_id`)
		REFERENCES `sf_guard_user` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- notevideoAdmin
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `notevideoAdmin`;


CREATE TABLE `notevideoAdmin`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`video_id` INTEGER  NOT NULL,
	`utilisateur_id` INTEGER  NOT NULL,
	`note` INTEGER  NOT NULL,
	`message` TEXT  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `notevideoAdmin_FI_1` (`video_id`),
	CONSTRAINT `notevideoAdmin_FK_1`
		FOREIGN KEY (`video_id`)
		REFERENCES `video` (`id`),
	INDEX `notevideoAdmin_FI_2` (`utilisateur_id`),
	CONSTRAINT `notevideoAdmin_FK_2`
		FOREIGN KEY (`utilisateur_id`)
		REFERENCES `sf_guard_user` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- videoproprietaire
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `videoproprietaire`;


CREATE TABLE `videoproprietaire`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`video_id` INTEGER  NOT NULL,
	`utilisateur_id` INTEGER  NOT NULL,
	`note` INTEGER,
	`created_at` DATETIME,
	PRIMARY KEY (`id`,`video_id`,`utilisateur_id`),
	INDEX `videoproprietaire_FI_1` (`video_id`),
	CONSTRAINT `videoproprietaire_FK_1`
		FOREIGN KEY (`video_id`)
		REFERENCES `video` (`id`)
		ON DELETE CASCADE,
	INDEX `videoproprietaire_FI_2` (`utilisateur_id`),
	CONSTRAINT `videoproprietaire_FK_2`
		FOREIGN KEY (`utilisateur_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- serieproprietaire
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `serieproprietaire`;


CREATE TABLE `serieproprietaire`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`serie_id` INTEGER  NOT NULL,
	`utilisateur_id` INTEGER  NOT NULL,
	`note` INTEGER,
	`created_at` DATETIME,
	PRIMARY KEY (`id`,`serie_id`,`utilisateur_id`),
	INDEX `serieproprietaire_FI_1` (`serie_id`),
	CONSTRAINT `serieproprietaire_FK_1`
		FOREIGN KEY (`serie_id`)
		REFERENCES `serie` (`id`)
		ON DELETE CASCADE,
	INDEX `serieproprietaire_FI_2` (`utilisateur_id`),
	CONSTRAINT `serieproprietaire_FK_2`
		FOREIGN KEY (`utilisateur_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- sauvegarde_visiteur
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `sauvegarde_visiteur`;


CREATE TABLE `sauvegarde_visiteur`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`nom` VARCHAR(255) default 'inconnu',
	`adresse` VARCHAR(15)  NOT NULL,
	`derniere_connection` DATETIME,
	`proprio_id` INTEGER default 0,
	PRIMARY KEY (`id`),
	UNIQUE KEY `sauvegarde_visiteur_U_1` (`adresse`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- MODEL
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `MODEL`;


CREATE TABLE `MODEL`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- ANOTHER_MODEL
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ANOTHER_MODEL`;


CREATE TABLE `ANOTHER_MODEL`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (`id`)
)Type=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
