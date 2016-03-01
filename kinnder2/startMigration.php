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
  
  public function migrateEstudiantes()
  {
    $sql = 'select id from usuario';
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    while($row = $stmt->fetch())
    {
        $this->doMigrateUsuario($row['id']);
    } 
  }
  
  public function migratePadres()
  {
    $sql = "select id from progenitor where mail != ''";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    while($row = $stmt->fetch())
    {
        $this->doMigrateParent($row['id']);
    } 
  }
  
  public function migrateUsuariosActividades()
  {
    $sql = "select usuario_id, actividad_id from usuario_actividades";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    while($row = $stmt->fetch())
    {
        $this->doMigrateUserActivity($row['usuario_id'], $row['actividad_id']);
    } 
  }
  
  public function migrateUsuariosProgenitores()
  {
    $sql = "select up.usuario_id, up.progenitor_id from usuario_progenitor up";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    while($row = $stmt->fetch())
    {
        $this->doMigrateUserProgenitor($row['usuario_id'], $row['progenitor_id']);
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
  
  public function doMigrateUsuario($id)
  {
    $url = $this->baseUrl.'migrations/estudiante/%s/%s';
    $this->doCallNewSystem($id, $url);
  }
  
  public function doDisableUsuario($id)
  {
    $url = $this->baseUrl.'migrations/estudiante-disable/%s/%s';
    $this->doCallNewSystem($id, $url);
  }
  
  public function doMigrateParent($id)
  {
    $url = $this->baseUrl.'migrations/parent/%s/%s';
    $this->doCallNewSystem($id, $url);
  }
  
  public function doRemoveParent($id)
  {
    $url = $this->baseUrl.'migrations/parent-remove/%s/%s';
    $this->doCallNewSystem($id, $url);
  }
  
  public function doMigrateUserActivity($userId, $activityId)
  {
    $url = $this->baseUrl.'migrations/user-activity/%s/%s/%s';
    $today = new \DateTime();
    $finalUrl = sprintf($url, $userId, $activityId, md5($today->format('Y-m-d')));
    $this->doCurl($finalUrl);
  }
  
  public function doRemoveUserActivity($userId, $activityId)
  {
    $url = $this->baseUrl.'migrations/user-activity-remove/%s/%s/%s';
    $today = new \DateTime();
    $finalUrl = sprintf($url, $userId, $activityId, md5($today->format('Y-m-d')));
    $this->doCurl($finalUrl);
  }
  
  public function doMigrateUserProgenitor($userId, $progenitorId)
  {
    $url = $this->baseUrl.'migrations/user-parent/%s/%s/%s';
    $today = new \DateTime();
    $finalUrl = sprintf($url, $userId, $progenitorId, md5($today->format('Y-m-d')));
    $this->doCurl($finalUrl);
  }
  
  public function doRemoveUserProgenitor($userId, $progenitorId)
  {
    $url = $this->baseUrl.'migrations/user-parent-remove/%s/%s/%s';
    $today = new \DateTime();
    $finalUrl = sprintf($url, $userId, $progenitorId, md5($today->format('Y-m-d')));
    $this->doCurl($finalUrl);
  }
  
  private function doCallNewSystem($id, $url)
  {
    $today = new \DateTime();
    $finalUrl = sprintf($url, $id, md5($today->format('Y-m-d')));
    $this->doCurl($finalUrl);
  }
  
  private function doCurl($url)
  {
    $crl = curl_init();
    $timeout = 5;
    curl_setopt ($crl, CURLOPT_URL,$url);
    curl_setopt ($crl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
    $ret = curl_exec($crl);
    var_dump($ret);
    curl_close($crl);
  }
  
  
}

$m = new DoMigration('root', 'root', 'bunnyski_site', 'http://kinder2.local:9550/app_dev.php/');

$m->migrateActividades();
$m->migrateDescuentos();
$m->doCallUpdateCostos();
$m->migrateEstudiantes();
$m->migratePadres();
$m->migrateUsuariosActividades();

$m->migrateUsuariosProgenitores();
return;
