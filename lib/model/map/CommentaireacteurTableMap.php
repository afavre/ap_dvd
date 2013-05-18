<?php


/**
 * This class defines the structure of the 'commentaireacteur' table.
 *
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Mon Mar 19 16:27:23 2012
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class CommentaireacteurTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.CommentaireacteurTableMap';

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
		$this->setName('commentaireacteur');
		$this->setPhpName('Commentaireacteur');
		$this->setClassname('Commentaireacteur');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignKey('ACTEUR_ID', 'ActeurId', 'INTEGER', 'personne', 'ID', true, null, null);
		$this->addForeignKey('UTILISATEUR_ID', 'UtilisateurId', 'INTEGER', 'utilisateur', 'ID', true, null, null);
		$this->addColumn('MESSAGE', 'Message', 'LONGVARCHAR', true, null, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Personne', 'Personne', RelationMap::MANY_TO_ONE, array('acteur_id' => 'id', ), null, null);
    $this->addRelation('Utilisateur', 'Utilisateur', RelationMap::MANY_TO_ONE, array('utilisateur_id' => 'id', ), null, null);
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
			'symfony_timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', ),
		);
	} // getBehaviors()

} // CommentaireacteurTableMap
