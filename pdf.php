<?php
    include_once 'plugins/dompdf/autoload.inc.php';
    
    // reference the Dompdf namespace
	use Dompdf\Dompdf;

	// instantiate and use the dompdf class
	$dompdf = new Dompdf();

    ob_start(); 
    
    echo $_POST['html'];
?>
<?php
    $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
	ob_end_clean();
	
	// (Optional) Setup the paper size and orientation
	$dompdf->setPaper('A4', 'landscape');
	// $dompdf->setPaper(array(0, 0, 550, 300));
	
	$dompdf->loadHtml(utf8_encode($html));
	
	// Render the HTML as PDF
	$dompdf->render();

	// Output the generated PDF to Browser
	$dompdf->stream("Nota.pdf", array("Attachment" => 0));

	// exit(0);
?>