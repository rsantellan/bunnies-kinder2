<?php

namespace AppBundle\Fpdf;

// Xavier Nicolay 2004
// Version 1.02
// http://fpdf.org/en/script/script20.php
//////////////////////////////////////
// Public functions                 //
//////////////////////////////////////
//  function sizeOfText( $texte, $larg )
//  function addSociete( $nom, $adresse )
//  function fact_dev( $libelle, $num )
//  function addDevis( $numdev )
//  function addFacture( $numfact )
//  function addDate( $date )
//  function addClient( $ref )
//  function addPageNumber( $page )
//  function addClientAdresse( $adresse )
//  function addReglement( $mode )
//  function addEcheance( $date )
//  function addNumTVA($tva)
//  function addReference($ref)
//  function addCols( $tab )
//  function addLineFormat( $tab )
//  function lineVert( $tab )
//  function addLine( $ligne, $tab )
//  function addRemarque($remarque)
//  function addCadreTVAs()
//  function addCadreEurosFrancs()
//  function addTVAs( $params, $tab_tva, $invoice )
//  function temporaire( $texte )

class Invoice extends \fpdf\FPDF_EXTENDED
{
    // private variables
    public $colonnes;
    public $format;
    public $angle = 0;

// private functions
  public function roundedRect($xPosition, $yPosition, $width, $height, $round, $style = '')
  {
      $k = $this->k;
      $hp = $this->h;
      if ($style == 'F') {
          $op = 'f';
      } elseif ($style == 'FD' || $style == 'DF') {
          $op = 'B';
      } else {
          $op = 'S';
      }
      $MyArc = 4 / 3 * (sqrt(2) - 1);
      $this->_out(sprintf('%.2F %.2F m', ($xPosition + $round) * $k, ($hp - $yPosition) * $k));
      $xc = $xPosition + $width - $round;
      $yc = $yPosition + $round;
      $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - $yPosition) * $k));

      $this->arcFunction($xc + $round * $MyArc, $yc - $round, $xc + $round, $yc - $round * $MyArc, $xc + $round, $yc);
      $xc = $xPosition + $width - $round;
      $yc = $yPosition + $height - $round;
      $this->_out(sprintf('%.2F %.2F l', ($xPosition + $width) * $k, ($hp - $yc) * $k));
      $this->arcFunction($xc + $round, $yc + $round * $MyArc, $xc + $round * $MyArc, $yc + $round, $xc, $yc + $round);
      $xc = $xPosition + $round;
      $yc = $yPosition + $height - $round;
      $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - ($yPosition + $height)) * $k));
      $this->arcFunction($xc - $round * $MyArc, $yc + $round, $xc - $round, $yc + $round * $MyArc, $xc - $round, $yc);
      $xc = $xPosition + $round;
      $yc = $yPosition + $round;
      $this->_out(sprintf('%.2F %.2F l', ($xPosition) * $k, ($hp - $yc) * $k));
      $this->arcFunction($xc - $round, $yc - $round * $MyArc, $xc - $round * $MyArc, $yc - $round, $xc, $yc - $round);
      $this->_out($op);
  }

    public function arcFunction($xPositionFirst, $yPostitionFirst, $xPostitionSecond, $yPositionSecond, $xPositionThird, $yPositionThird)
    {
        $h = $this->h;
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $xPositionFirst * $this->k, ($h - $yPostitionFirst) * $this->k, $xPostitionSecond * $this->k, ($h - $yPositionSecond) * $this->k, $xPositionThird * $this->k, ($h - $yPositionThird) * $this->k));
    }

    public function rotate($angle, $x = -1, $y = -1)
    {
        if ($x == -1) {
            $x = $this->x;
        }
        if ($y == -1) {
            $y = $this->y;
        }
        if ($this->angle != 0) {
            $this->_out('Q');
        }
        $this->angle = $angle;
        if ($angle != 0) {
            $angle *= M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
        }
    }

    public function endPage()
    {
        if ($this->angle != 0) {
            $this->angle = 0;
            $this->_out('Q');
        }
        parent::_endpage();
    }

// public functions
  public function sizeOfText($texte, $largeur)
  {
      $index = 0;
      $nb_lines = 0;
      $loop = true;
      while ($loop) {
          $pos = strpos($texte, "\n");
          if (!$pos) {
              $loop = false;
              $ligne = $texte;
          } else {
              $ligne = substr($texte, $index, $pos);
              $texte = substr($texte, $pos + 1);
          }
          $length = floor($this->GetStringWidth($ligne));
          if ($largeur == 0) {
              $res = 1;
          } else {
              $res = 1 + floor($length / $largeur);
          }

          $nb_lines += $res;
      }

      return $nb_lines;
  }

// Company
  public function addSociete($imageSrc)
  {
      $x1 = 10;
      $y1 = 8;
      $this->Image($imageSrc, $x1, $y1, 50);
  }

// Label and number of invoice/estimate
  public function factDev($libelle, $num)
  {
      $r1 = $this->w - 80;
      $r2 = $r1 + 68;
      $y1 = 6;
      $y2 = $y1 + 2;

      $texte = $libelle.' EN '.EURO.' N° : '.$num;
      $szfont = 12;
      $loop = 0;

      while ($loop == 0) {
          $this->SetFont('Arial', 'B', $szfont);
          $sz = $this->GetStringWidth($texte);
          if (($r1 + $sz) > $r2) {
              --$szfont;
          } else {
              ++$loop;
          }
      }

      $this->SetLineWidth(0.1);
      $this->SetFillColor(192);
      $this->roundedRect($r1, $y1, ($r2 - $r1), $y2, 2.5, 'DF');
      $this->SetXY($r1 + 1, $y1 + 2);
      $this->Cell($r2 - $r1 - 1, 5, $texte, 0, 0, 'C');
  }

// Estimate
  public function addDevis($numdev)
  {
      $string = sprintf('DEV%04d', $numdev);
      $this->factDev('Devis', $string);
  }

// Invoice
  public function addFacture($numfact)
  {
      $string = sprintf('FA%04d', $numfact);
      $this->factDev('Facture', $string);
  }

    public function addDate($date)
    {
        $r1 = $this->w - 61;
        $r2 = $r1 + 30;
        $y1 = 17;
        $y2 = $y1;
        $mid = $y1 + ($y2 / 2);
        $this->roundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
        $this->Line($r1, $mid, $r2, $mid);
        $this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 3);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(10, 5, 'Fecha', 0, 0, 'C');
        $this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 9);
        $this->SetFont('Arial', '', 10);
        $this->Cell(10, 5, $date, 0, 0, 'C');
    }

    public function addClient($ref)
    {
        $r1 = $this->w - 31;
        $r2 = $r1 + 19;
        $y1 = 17;
        $y2 = $y1;
        $mid = $y1 + ($y2 / 2);
        $this->roundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
        $this->Line($r1, $mid, $r2, $mid);
        $this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 3);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(10, 5, 'Ref', 0, 0, 'C');
        $this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 9);
        $this->SetFont('Arial', '', 10);
        $this->Cell(10, 5, $ref, 0, 0, 'C');
    }

    public function addPageNumber($page)
    {
        $r1 = $this->w - 80;
        $r2 = $r1 + 19;
        $y1 = 17;
        $y2 = $y1;
        $mid = $y1 + ($y2 / 2);
        $this->roundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
        $this->Line($r1, $mid, $r2, $mid);
        $this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 3);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(10, 5, 'Pag', 0, 0, 'C');
        $this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 9);
        $this->SetFont('Arial', '', 10);
        $this->Cell(10, 5, $page, 0, 0, 'C');
    }

// Client address
  public function addClientAdresse($adresse)
  {
      $r1 = $this->w - 80;

      $y1 = 40;
      $this->SetXY($r1, $y1);
      $this->MultiCell(60, 4, $adresse);
  }

// Mode of payment
  public function addAlumnos($mode)
  {
      $r1 = 10;
      $r2 = $r1 + 100;
      $y1 = 40;
      $y2 = $y1 + 10;
      $mid = $y1 + (($y2 - $y1) / 2);
      $this->roundedRect($r1, $y1, ($r2 - $r1), ($y2 - $y1), 2.5, 'D');
      $this->Line($r1, $mid, $r2, $mid);
      $this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 1);
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(10, 4, 'Alumno(s)', 0, 0, 'C');
      $this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 5);
      $this->SetFont('Arial', '', 10);
      $this->Cell(10, 5, $mode, 0, 0, 'C');
  }

// Expiry date
  public function addPadres($date)
  {
      $r1 = 120;
      $r2 = $r1 + 80;
      $y1 = 40;
      $y2 = $y1 + 10;
      $mid = $y1 + (($y2 - $y1) / 2);
      $this->roundedRect($r1, $y1, ($r2 - $r1), ($y2 - $y1), 2.5, 'D');
      $this->Line($r1, $mid, $r2, $mid);
      $this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 1);
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(10, 4, 'Padres', 0, 0, 'C');
      $this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 5);
      $this->SetFont('Arial', '', 10);
      $this->Cell(10, 5, $date, 0, 0, 'C');
  }

// VAT number
  public function addNumTVA($tva)
  {
      $this->SetFont('Arial', 'B', 10);
      $r1 = $this->w - 80;
      $r2 = $r1 + 70;
      $y1 = 80;
      $y2 = $y1 + 10;
      $mid = $y1 + (($y2 - $y1) / 2);
      $this->roundedRect($r1, $y1, ($r2 - $r1), ($y2 - $y1), 2.5, 'D');
      $this->Line($r1, $mid, $r2, $mid);
      $this->SetXY($r1 + 16, $y1 + 1);
      $this->Cell(40, 4, 'TVA Intracommunautaire', '', '', 'C');
      $this->SetFont('Arial', '', 10);
      $this->SetXY($r1 + 16, $y1 + 5);
      $this->Cell(40, 5, $tva, '', '', 'C');
  }

    public function addReference($ref)
    {
        $this->SetFont('Arial', '', 10);
        $length = $this->GetStringWidth('Références : '.$ref);
        $r1 = 10;
        $y1 = 92;
        $this->SetXY($r1, $y1);
        $this->Cell($length, 4, 'Références : '.$ref);
    }

    public function addCols($tab)
    {
        $r1 = 10;
        $r2 = $this->w - ($r1 * 2);
        $y1 = 60;
        $y2 = $this->h - 50 - $y1;
        $this->SetXY($r1, $y1);
        $this->Rect($r1, $y1, $r2, $y2, 'D');
        $this->Line($r1, $y1 + 6, $r1 + $r2, $y1 + 6);
        $colX = $r1;
        $this->colonnes = $tab;
        while (list($lib, $pos) = each($tab)) {
            $this->SetXY($colX, $y1 + 2);
            $this->Cell($pos, 1, $lib, 0, 0, 'C');
            $colX += $pos;
            $this->Line($colX, $y1, $colX, $y1 + $y2);
        }
    }

    public function addLineFormat($tab)
    {
        while (list($lib) = each($this->colonnes)) {
            if (isset($tab["$lib"])) {
                $this->format[$lib] = $tab["$lib"];
            }
        }
    }

    public function lineVert($tab)
    {
        reset($this->colonnes);
        $maxSize = 0;
        while (list($lib, $pos) = each($this->colonnes)) {
            $texte = $tab[$lib];
            $longCell = $pos - 2;
            $size = $this->sizeOfText($texte, $longCell);
            if ($size > $maxSize) {
                $maxSize = $size;
            }
        }

        return $maxSize;
    }


  public function addLine($ligne, $tab)
  {
      $ordonnee = 10;
      $maxSize = $ligne;

      reset($this->colonnes);
      $counter = 0;
      while (list($lib, $pos) = each($this->colonnes)) {
          ++$counter;
          $longCell = $pos - 2;
          $texte = $tab[$lib];
          $length = $this->GetStringWidth($texte);
          $formText = $this->format[$lib];
          if ($counter == count($tab)) {
              $this->SetFont('Arial', 'B', 10);
          }
          $this->SetXY($ordonnee, $ligne - 1);
          $this->MultiCell($longCell, 4, $texte, 0, $formText);
          if ($maxSize < ($this->GetY())) {
              $maxSize = $this->GetY();
          }
          $ordonnee += $pos;
      }
      $this->SetFont('');
      return  $maxSize - $ligne;
  }

    public function addRemarque($remarque)
    {
        $this->SetFont('Arial', '', 10);
        $length = $this->GetStringWidth('Remarque : '.$remarque);
        $r1 = 10;
        $y1 = $this->h - 45.5;
        $this->SetXY($r1, $y1);
        $this->Cell($length, 4, 'Remarque : '.$remarque);
    }

    public function addCadreTVAs()
    {
        $this->SetFont('Arial', 'B', 8);
        $r1 = 10;
        $r2 = $r1 + 120;
        $y1 = $this->h - 40;
        $y2 = $y1 + 20;
        $this->roundedRect($r1, $y1, ($r2 - $r1), ($y2 - $y1), 2.5, 'D');
        $this->Line($r1, $y1 + 4, $r2, $y1 + 4);
        $this->Line($r1 + 5, $y1 + 4, $r1 + 5, $y2); // avant BASES HT
        $this->Line($r1 + 27, $y1, $r1 + 27, $y2);  // avant REMISE
        $this->Line($r1 + 43, $y1, $r1 + 43, $y2);  // avant MT TVA
        $this->Line($r1 + 63, $y1, $r1 + 63, $y2);  // avant % TVA
        $this->Line($r1 + 75, $y1, $r1 + 75, $y2);  // avant PORT
        $this->Line($r1 + 91, $y1, $r1 + 91, $y2);  // avant TOTAUX
        $this->SetXY($r1 + 9, $y1);
        $this->Cell(10, 4, 'BASES HT');
        $this->SetX($r1 + 29);
        $this->Cell(10, 4, 'REMISE');
        $this->SetX($r1 + 48);
        $this->Cell(10, 4, 'MT TVA');
        $this->SetX($r1 + 63);
        $this->Cell(10, 4, '% TVA');
        $this->SetX($r1 + 78);
        $this->Cell(10, 4, 'PORT');
        $this->SetX($r1 + 100);
        $this->Cell(10, 4, 'TOTAUX');
        $this->SetFont('Arial', 'B', 6);
        $this->SetXY($r1 + 93, $y2 - 8);
        $this->Cell(6, 0, 'H.T.   :');
        $this->SetXY($r1 + 93, $y2 - 3);
        $this->Cell(6, 0, 'T.V.A. :');
    }

    public function addCadreEurosFrancs($amountText = '$0')
    {
        $r1 = $this->w - 70;
        $r2 = $r1 + 40;
        $y1 = $this->h - 40;
        $y2 = $y1 + 10;
        $this->roundedRect($r1, $y1, ($r2 - $r1), ($y2 - $y1), 2.5, 'D');
        $this->Line($r1 + 20, $y1, $r1 + 20, $y2); // avant EUROS
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY($r1 + 22, $y1);
        $this->Cell(15, 4, ' ', 0, 0, 'C');
        $this->SetFont('Arial', '', 8);
        $this->SetXY($r1, $y1 + 5);
        $this->Cell(20, 4, 'TOTAL', 0, 0, 'C');

        $re = $this->w - 50;
        $y1 = $this->h - 40;
        $this->SetFont('Arial', 'B', 10);
        $this->SetXY($re, $y1 + 5);
        $this->Cell(17, 4, $amountText, '', '', 'R');
    }

  public function addTVAs($params, $tab_tva, $invoice)
  {
      $this->SetFont('Arial', '', 8);

      reset($invoice);
      $px = array();
      while (list($prod) = each($invoice)) {
          if(isset($prod['tva']) && isset($prod['qte']) && isset($prod['px_unit']))
          {
            $tva = $prod['tva'];
            $px[$tva] += $prod['qte'] * $prod['px_unit'];  
          }
      }
      $totalHT = 0;
      $totalTTC = 0;
      $totalTVA = 0;
      $y = 261;
      reset($px);
      natsort($px);
      while (list($code_tva, $articleHT) = each($px)) {
          $tva = $tab_tva[$code_tva];
          $this->SetXY(17, $y);
          $this->Cell(19, 4, sprintf('%0.2F', $articleHT), '', '', 'R');
          if ($params['RemiseGlobale'] == 1) {
              if ($params['remise_tva'] == $code_tva) {
                  $this->SetXY(37.5, $y);
                  if ($params['remise'] > 0) {
                      if (is_int($params['remise'])) {
                          $l_remise = $param['remise'];
                      } else {
                          $l_remise = sprintf('%0.2F', $params['remise']);
                      }
                      $this->Cell(14.5, 4, $l_remise, '', '', 'R');
                      $articleHT -= $params['remise'];
                  } elseif ($params['remise_percent'] > 0) {
                      $rp = $params['remise_percent'];
                      if ($rp > 1) {
                          $rp /= 100;
                      }
                      $rabais = $articleHT * $rp;
                      $articleHT -= $rabais;
                      if (is_int($rabais)) {
                          $l_remise = $rabais;
                      } else {
                          $l_remise = sprintf('%0.2F', $rabais);
                      }
                      $this->Cell(14.5, 4, $l_remise, '', '', 'R');
                  } else {
                      $this->Cell(14.5, 4, 'ErrorRem', '', '', 'R');
                  }
              }
          }
          $totalHT += $articleHT;
          $totalTTC += $articleHT * (1 + $tva / 100);
          $tmp_tva = $articleHT * $tva / 100;
          $totalTVA += $tmp_tva;
          $this->SetXY(11, $y);
          $this->Cell(5, 4, $code_tva);
          $this->SetXY(53, $y);
          $this->Cell(19, 4, sprintf('%0.2F', $tmp_tva), '', '', 'R');
          $this->SetXY(74, $y);
          $this->Cell(10, 4, sprintf('%0.2F', $tva), '', '', 'R');
          $y += 4;
      }

      if ($params['FraisPort'] == 1) {
          if($params['portTTC'] > 0 || $params['portHT'] > 0)
          {
            $pTTC = 0;
            $pHT = 0;
            $pTVA = 0;
            if ($params['portTTC'] > 0) {
              $pTTC = sprintf('%0.2F', $params['portTTC']);
              $pHT = sprintf('%0.2F', $pTTC / 1.196);
              $pTVA = sprintf('%0.2F', $pHT * 0.196);
            }else{
              $pHT = sprintf('%0.2F', $params['portHT']);
              $pTVA = sprintf('%0.2F', $params['portTVA'] * $pHT / 100);
              $pTTC = sprintf('%0.2F', $pHT + $pTVA);
            }
            $this->SetFont('Arial', '', 6);
            $this->SetXY(85, 261);
            $this->Cell(6, 4, 'HT : ', '', '', '');
            $this->SetXY(92, 261);
            $this->Cell(9, 4, $pHT, '', '', 'R');
            $this->SetXY(85, 265);
            $this->Cell(6, 4, 'TVA : ', '', '', '');
            $this->SetXY(92, 265);
            $this->Cell(9, 4, $pTVA, '', '', 'R');
            $this->SetXY(85, 269);
            $this->Cell(6, 4, 'TTC : ', '', '', '');
            $this->SetXY(92, 269);
            $this->Cell(9, 4, $pTTC, '', '', 'R');
            $this->SetFont('Arial', '', 8);
            $totalHT += $pHT;
            $totalTVA += $pTVA;
            $totalTTC += $pTTC;
          }
      }

      $this->SetXY(114, 266.4);
      $this->Cell(15, 4, sprintf('%0.2F', $totalHT), '', '', 'R');
      $this->SetXY(114, 271.4);
      $this->Cell(15, 4, sprintf('%0.2F', $totalTVA), '', '', 'R');

      $params['totalHT'] = $totalHT;
      $params['TVA'] = $totalTVA;
      $accompteTTC = 0;
      if ($params['AccompteExige'] == 1) {
          if ($params['accompte'] > 0) {
              $accompteTTC = sprintf('%.2F', $params['accompte']);
              if (strlen($params['Remarque']) == 0) {
                  $this->addRemarque("Accompte de $accompteTTC Euros exigé à la commande.");
              } else {
                  $this->addRemarque($params['Remarque']);
              }
          } elseif ($params['accompte_percent'] > 0) {
              $percent = $params['accompte_percent'];
              if ($percent > 1) {
                  $percent /= 100;
              }
              $accompteTTC = sprintf('%.2F', $totalTTC * $percent);
              $percent100 = $percent * 100;
              if (strlen($params['Remarque']) == 0) {
                  $this->addRemarque("Accompte de $percent100 % (soit $accompteTTC Euros) exigé à la commande.");
              } else {
                  $this->addRemarque($params['Remarque']);
              }
          } else {
              $this->addRemarque("Drôle d'acompte !!! ".$params['Remarque']);
          }
      } else {
          if (strlen($params['Remarque']) > 0) {
              $this->addRemarque($params['Remarque']);
          }
      }
      $re = $this->w - 50;
      $rf = $this->w - 29;
      $y1 = $this->h - 40;
      $this->SetFont('Arial', '', 8);
      $this->SetXY($re, $y1 + 5);
      $this->Cell(17, 4, sprintf('%0.2F', $totalTTC), '', '', 'R');
      $this->SetXY($re, $y1 + 10);
      $this->Cell(17, 4, sprintf('%0.2F', $accompteTTC), '', '', 'R');
      $this->SetXY($re, $y1 + 14.8);
      $this->Cell(17, 4, sprintf('%0.2F', $totalTTC - $accompteTTC), '', '', 'R');
      $this->SetXY($rf, $y1 + 5);
      $this->Cell(17, 4, sprintf('%0.2F', $totalTTC * EURO_VAL), '', '', 'R');
      $this->SetXY($rf, $y1 + 10);
      $this->Cell(17, 4, sprintf('%0.2F', $accompteTTC * EURO_VAL), '', '', 'R');
      $this->SetXY($rf, $y1 + 14.8);
      $this->Cell(17, 4, sprintf('%0.2F', ($totalTTC - $accompteTTC) * EURO_VAL), '', '', 'R');
  }

// add a watermark (temporary estimate, DUPLICATA...)
// call this method first
  public function temporaire($texte)
  {
      $this->SetFont('Arial', 'B', 50);
      $this->SetTextColor(203, 203, 203);
      $this->rotate(45, 55, 190);
      $this->Text(55, 190, $texte);
      $this->rotate(0);
      $this->SetTextColor(0, 0, 0);
  }
}
