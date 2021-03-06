<?php


/**
 * This class defines the structure of the 'personne' table.
 *
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Mon Mar 19 16:27:20 2012
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class PersonneTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PersonneTableMap';

	/**
	 * Initialize the table attributes, columns and validators
	 * Relations are not initialized by this method since they are lazy loaded
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function initialize()
	{
	  // attributes
		$this->setName('personne');
		$this->setPhpName('Personne');
		$this->setClassname('Personne');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('NOM', 'Nom', 'VARCHAR', true, 255, null);
		$this->addColumn('PRENOM', 'Prenom', 'VARCHAR', true, 255, null);
		$this->addColumn('NOM_PRENOM_CLEAN', 'NomPrenomClean', 'VARCHAR', true, 255, null);
		$this->addColumn('IMAGE', 'Image', 'VARCHAR', false, 255, null);
		$this->addColumn('DATE_NAISSANCE', 'DateNaissance', 'DATE', false, null, null);
		$this->addColumn('DATE_DECES', 'DateDeces', 'DATE', false, null, null);
		$this->addColumn('NB_VISITE', 'NbVisite', 'INTEGER', false, null, null);
		$this->addForeignKey('NATIONALITE_ID', 'NationaliteId', 'INTEGER', 'nationalite', 'ID', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Nationalite', 'Nationalite', RelationMap::MANY_TO_ONE, array('nationalite_id' => 'id', ), null, null);
    $this->addRelation('Video', 'Video', RelationMap::ONE_TO_MANY, array('id' => 'realisateur_id', ), null, null);
    $this->addRelation('Serie', 'Serie', RelationMap::ONE_TO_MANY, array('id' => 'realisateur_id', ), null, null);
    $this->addRelation('Saison', 'Saison', RelationMap::ONE_TO_MANY, array('id' => 'realisateur_id', ), null, null);
    $this->addRelation('Commentaireacteur', 'Commentaireacteur', RelationMap::ONE_TO_MANY, array('id' => 'acteur_id', ), null, null);
    $this->addRelation('Commentairerealisateur', 'Commentairerealisateur', RelationMap::ONE_TO_MANY, array('id' => 'realisateur_id', ), null, null);
    $this->addRelation('Acteurvideo', 'Acteurvideo', RelationMap::ONE_TO_MANY, array('id' => 'acteur_id', ), 'CASCADE', null);
    $this->addRelation('Acteurserie', 'Acteurserie', RelationMap::ONE_TO_MANY, array('id' => 'acteur_id', ), 'CASCADE', null);
	} // buildRelations()

	/**
	 * 
	 * Gets the list of behaviors registered for this table
	 * 
	 * @return array Associative array (name => parameters) of behaviors
	 */
	public function getBehaviors()
	{
		return array(
			'symfony' => array('form' => 'true', 'filter' => 'true', ),
			'symfony_behaviors' => array(),
		);
	} // getBehaviors()

} // PersonneTableMap
