<?php

namespace AppBundle\Entity;

/**
 * Description of GalleryEntity
 *
 * @author rodrigo
 */
class GalleryEntity {
  
  public function getId()
  {
    return 1;
  }

  public function retrieveAlbums()
  {
      return array('inicio', 'filosofia');
  }

  public function getFullClassName(){
    return get_class($this);
  }
  
}
