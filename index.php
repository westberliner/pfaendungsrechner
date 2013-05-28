<?php
// Berechnung des pfändbaren Einkommens
function gesamtpfandbetrag($nettoeinkommen, $kinder) {
  $nettomax = 3203.67; // Grenze ab dem das Einkommen voll verpfändendet wird
  if ($nettoeinkommen > $nettomax) {
    // wenn man drüber dann wird alles drüber eingezogen
    $ergebnis = round(100 * lohnpfaendungsrechner($nettomax, $kinder) + 100 * $nettoeinkommen - 100 * $nettomax);
  }
  else {
    // wenn man drunter liegt
    $ergebnis = round(lohnpfaendungsrechner($nettoeinkommen, $kinder) * 100);
  }
  return $ergebnis / 100;
}

// basierend auf http://www.bmj.de/SharedDocs/Downloads/DE/pdfs/Verkuendung_BGBl_Pfaendungsfreigrenzen.pdf?__blob=publicationFile
function lohnpfaendungsrechner($nettoeinkommen, $kinder) {
  $kinder = $kinder > 5 ? 5 : $kinder;
  $pf_erstbetrag = array(3.47, 0.83, 1.02, 1.03, 0.86, 0.52); // pfändbarer Erstbetrag (in Bezug auf Einkommen und Kinder)
  $pf_freisufe = array(1, 40, 62, 84, 106, 128); // abzgl. kinder in 10 Euro schritten (siehe: Tabellen-Zeile)
  $pf_abzug_pro_10 = array(7, 5, 4, 3, 2, 1); // wird von den 10 Euro Abgezogen (je nach Anzahl der Kinder / siehe von Zeile zu Zeile)
  $pf_untergrenze = 1049.99; // monatlicher unpfändbarer Betrag

  $arr_t = 10; // 10 Euro Schritte

  $netto_abzgl_max = ceil(($nettoeinkommen - $pf_untergrenze) / $arr_t); // Aufrunden
  return $pf_erstbetrag[$kinder] + $pf_abzug_pro_10[$kinder] * ($netto_abzgl_max - $pf_freisufe[$kinder]);
}

print gesamtpfandbetrag(20329.99,4);

