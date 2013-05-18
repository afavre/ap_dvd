<?php


/**
 * This class defines the structure of the 'motscle' table.
 *
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Mon Mar 19 16:27:24 2012
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class MotscleTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.MotscleTableMap';

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
		$this->setName('motscle');
		$this->setPhpName('Motscle');
		$this->setClassname('Motscle');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('MOT', 'Mot', 'VARCHAR', true, 255, null);
		$this->addColumn('MOT_CLEAN', 'MotClean', 'VARCHAR', false, 255, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Motsclevideo', 'Motsclevideo', RelationMap::ONE_TO_MANY, array('id' => 'motscle_id', ), 'CASCADE', null);
    $this->addRelation('Motscleserie', 'Motscleserie', RelationMap::ONE_TO_MANY, array('id' => 'motscle_id', ), 'CASCADE', null);
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

} // MotscleTableMap
