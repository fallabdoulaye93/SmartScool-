<?php
/**
 * HTML2PDF Librairy - example
 *
 * HTML => PDF convertor
 * distributed under the LGPL License
 *
 * @author      Laurent MINGUET <webmaster@html2pdf.fr>
 *
 * isset($_GET['vuehtml']) is not mandatory
 * it allow to display the result in the HTML format
 */

    // get the HTML
    ob_start();
    include('histo_perso_admin.php');
    $content = ob_get_clean();
	
    // convert in PDF
    require_once('html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 0);
//      $html2pdf->setModeDebug();
        $html2pdf->setDefaultFont('Times',8);
        $html2pdf->writeHTML($content);
        $html2pdf->Output('liste_personnel_administratif.pdf','I');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    } 
$insertGoTo = "../tiers/Page_administrateur.php"; 
 header(sprintf("Location: %s", $insertGoTo));
?>

