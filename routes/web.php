<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/myphp', function () {
    return view('myphp');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tcpdf', function () {
    // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Nicola Asuni');
    $pdf->SetTitle('TCPDF Example 038');
    $pdf->SetSubject('TCPDF Tutorial');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 038', PDF_HEADER_STRING);

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

    // ---------------------------------------------------------

    // set font
    $pdf->SetFont('helvetica', '', 20);

    // add a page
    $pdf->AddPage();

    $txt = 'Example of CID-0 CJK unembedded font.
    To display extended text you must have CJK fonts installed for your PDF reader:';
    $pdf->Write(0, $txt, '', 0, 'L', true, 0, false, false, 0);

    // set font
    $pdf->SetFont('kozgopromedium', '', 40);

    $txt = 'こんにちは世界';
    $pdf->Write(0, $txt, '', 0, 'L', true, 0, false, false, 0);
    $txt = 'こんにちは世界';
    $pdf->Write(0, $txt, '', 0, 'L', true, 0, false, false, 0);

    // ---------------------------------------------------------

    //Close and output PDF document
    $pdf->Output('example_038.pdf', 'I');
});

Route::get('/phpword', function () {
    // $styleCell = array('textDirection'=>'tbRlV');
    $styleSection = array(
        'orientation'=>'landscape',
        'marginLeft'=>500,
        'marginRight'=>500,
        'marginTop'=>500,
        'marginBottom'=>500
    );
    $styleCell = array(
        'textDirection'=>\PhpOffice\PhpWord\Style\Cell::TEXT_DIR_TBRLV,
        'bgColor'=>'FFFFFF'
    );
    $styleRow = array(

	);
    $styleTable = array(
		'borderColor'=>'FFFFFF',
		'cellSpacing'=>0,
		'borderSize' => 0
	);

    // $styleCell = array('valign' => 'center');

	// Creating the new document...
	$phpWord = new \PhpOffice\PhpWord\PhpWord();

	// Adding an empty Section to the document...
	$section = $phpWord->addSection($styleSection);
		
	$table = $section->addTable($styleTable);
	
    $table->addRow(11000);
    $cell=$table->addCell(2000,$styleCell);
    // $cell->setTextDirection('tbRlV');

    $cellText = '番目テキスト';
    for ($i = 0; $i < 60; $i++) {
        $cell->addText( ( $i + 1) .$cellText, null, array('alignment' => 'right'));
    }


	$table = $section->addTable($styleTable);
	
    $table->addRow(11000);
    $cell=$table->addCell(2000,$styleCell);
	for ($i = 61; $i < 120; $i++) {
        $cell->addText( ( $i + 1) .$cellText);
    }

    // Saving the document as OOXML file...
    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
    $objWriter->save('helloWorld.docx');
});