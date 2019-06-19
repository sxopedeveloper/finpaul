<?php
$xy_arr = [
	3 => [
		'wholesaler_name' => [
			'x'     => 21,
			'y'     => -52.5,
			'text'  => 'Christian Burgos',
			'size'  => 9
		],
		'wholesaler_sig_date' => [
			'x'     => 83,
			'y'     => -37,
			'text'  => date( 'd F Y'),
			'size'  => 9
		]
	]
];
		
$pdf = new FPDI();
$directory = './assets/pdf_templates/';
$page_count = $pdf->setSourceFile($directory.'template_tradein_package.pdf');

for($i=1; $i<=$page_count; $i++)
{
	if ($i == 1 OR $i == 2 OR $i == 3)
	{
		continue;
	}
	
	$pdf->AddPage(); // Add a page per loop
	$tplIdx = $pdf->importPage($i);// Import page of the given pdf $i = page number
	$pdf->useTemplate($tplIdx, 0, 0, 0);// Use the imported page as the template

	$pdf->SetFont('Helvetica');
	$pdf->SetTextColor(125, 126, 128);// Rgb text color
	$pdf->SetMargins(0,0,0);// Set the margin of the pdf to 0 all
	$pdf->SetAutoPageBreak('auto',0); // Page break per page

	if(isset($xy_arr[$i]))
	{
		foreach ($xy_arr[$i] as $x_key => $x_val) 
		{
			$pdf->SetFontSize($xy_arr[$i][$x_key]['size']); // Font size
			$pdf->SetXY($xy_arr[$i][$x_key]['x'], $xy_arr[$i][$x_key]['y']); //x and y coordinates
			$pdf->Write(0, $xy_arr[$i][$x_key]['text']); // write the text
		}
	}
}
$pdf->Output();
		
// $final_file_name = "CHANGE TO YOUR FILE NAME";
// $pdf->Output('./your/directory/'.$final_file_name, 'F'); //F if you want to save the file to a path
			