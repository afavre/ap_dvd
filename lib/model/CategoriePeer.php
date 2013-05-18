<?php


/**
 * Skeleton subclass for performing query and update operations on the 'categorie' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * 12/04/10 09:58:08
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class CategoriePeer extends BaseCategoriePeer {
 static public function getLuceneIndex()
        {
          ProjectConfiguration::registerZend();

          if (file_exists($index = self::getLuceneIndexFile()))
          {
            return Zend_Search_Lucene::open($index);
          }
          else
          {
            $de= Zend_Search_Lucene::create($index);
            return $de;
          }
        }

        static public function getLuceneIndexFile()
        {
          return sfConfig::get('sf_data_dir').'/categorie.'.sfConfig::get('sf_environment').'.index';
        }



        static public function getForLuceneQuery($query)
        {
		  $quer=FilmPeer::clean($query);
          $hits = self::getLuceneIndex()->find($quer);
          $pks = array();
          foreach ($hits as $hit)
          {
            $pks[] = $hit->pk;
          }

          $criteria = new Criteria();
          $criteria->add(self::ID, $pks, Criteria::IN);
          $criteria->setLimit(20);

          return self::doSelect($criteria);
        }

        public static function doDeleteAll($con = null)
        {
          if (file_exists($index = self::getLuceneIndexFile()))
          {
            sfToolkit::clearDirectory($index);
            rmdir($index);
          }

          return parent::doDeleteAll($con);
        }


} // CategoriePeer
