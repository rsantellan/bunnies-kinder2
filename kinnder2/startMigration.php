<?php

namespace migrate;

class DoMigration{
  
  private $conn;
  private $baseUrl;
  
  public function __construct($username, $password, $database, $baseUrl)
  {
    $this->baseUrl = $baseUrl;
    $this->conn = new \PDO(sprintf('mysql:host=localhost;dbname=%s', $database), $username, $password, array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
  }
  
  public function migrateActividades()
  {
    $sql = 'select id, nombre, costo, horario, md_news_letter_group_id from actividades';
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    
    while($row = $stmt->fetch())
    {
        $this->doMigrateActividad($row['id']);
    }    
  }
  
  public function migrateDescuentos()
  {
    $sql = 'select id, cantidad_de_hermanos, porcentaje from descuentos';
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    while($row = $stmt->fetch())
    {
        $this->doMigrateDescuento($row['id']);
    }    
  }
  
  public function doMigrateActividad($id)
  {
    $url = $this->baseUrl.'migrations/activity/%s/%s';
    $this->doCallNewSystem($id, $url);
  }
  
  public function doRemoveActividad($id)
  {
    $url = $this->baseUrl.'migrations/activity-remove/%s/%s';
    $this->doCallNewSystem($id, $url);
  }
  

  
  public function doMigrateDescuento($id)
  {
    $url = $this->baseUrl.'migrations/discount/%s/%s';
    $this->doCallNewSystem($id, $url);
  }
  
  public function doRemoveDescuento($id)
  {
    $url = $this->baseUrl.'migrations/discount-remove/%s/%s';
    $this->doCallNewSystem($id, $url);
  }
  
  public function doCallUpdateCostos($id = 0)
  {
    $url = $this->baseUrl.'migrations/costos/%s/%s';
    $this->doCallNewSystem($id, $url);
  }
    
  private function doCallNewSystem($id, $url)
  {
    $today = new \DateTime();
    
    $finalUrl = sprintf($url, $id, md5($today->format('Y-m-d')));
    $crl = curl_init();
    $timeout = 5;
    curl_setopt ($crl, CURLOPT_URL,$finalUrl);
    curl_setopt ($crl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
    $ret = curl_exec($crl);
    //var_dump($ret);
    curl_close($crl);
  }
  
  
}

$m = new DoMigration('root', 'root', 'bunnyski_site', 'http://kinder2.local/app_dev.php/');
$m->migrateActividades();
$m->migrateDescuentos();
$m->doCallUpdateCostos();
return;
