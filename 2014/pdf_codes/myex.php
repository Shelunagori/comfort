<?php
header('Content-type: application/pdf');
header('Content-Disposition: attachment; filename="' . basename("vehicle.pdf") . '"');
header('Content-Transfer-Encoding: binary');
readfile("vehicle.pdf");
	require '../classes/databaseclasses/DataBaseConnect.php'; 
    require('fpdf.php');

    
    $data_base_object = new DataBaseConnect(); 
    $pdf=new FPDF();
    $pdf->AddPage();

    $pdf->SetFont('Arial','B',10);

    $pdf->Cell(50,3,"Vehicle Booking Status");
    $pdf->Ln();
    $pdf->Ln();

  //  $pdf->SetFont('Arial','',6);
  //  $text = "As a PHP programmer on any day you may need to write PDF file using PHP at run time. Here i have just tried to include each and everything required to write pdf file. Please go through the following blog link.";
   // $pdf->Write(5,$text);
     /* While you are using text we would recommend to use this function only because This method prints text from the current position. When the right margin is reached (or the \n character is met) a line break occurs and text continues from the left margin. Upon method exit, the current position is left just at the end of the text. */ 

    //$pdf->Ln();

//    $link = "http://dirtyhandsphp.blogspot.com/";
//    $pdf->SetTextColor(0,136,60); //set color of the text using R,G,B combination
//    $pdf->Write(5,$link,$link);
//    $pdf->Ln();

    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(13,5,"Booked By");
    $pdf->Cell(20,5,"Company Name");
    $pdf->Cell(20,5,"Customer Name");
    $pdf->Cell(15,5,"Travel From");
    $pdf->Cell(15,5,"Travel To");
    $pdf->Cell(20,5,"Service Name");
    $pdf->Cell(20,5,"Flight Number");
    $pdf->Cell(20,5,"Pickup Time");
    $pdf->Cell(20,5,"Pickup From");
    $pdf->Cell(20,5,"Drop To");
    $pdf->Ln();
    $pdf->SetFont('Arial','',6);
        $pdf->Cell(450,3,"--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------");

    $pdf->Ln();
    //Get data from table.
    $result=$data_base_object->execute_query_return("select * from booking where travel_from>='".date('Y-m-d')."' or (travel_from<='".date('Y-m-d')."' and travel_to>='".date('Y-m-d')."')");
    while($row=mysql_fetch_array($result))
    {
        $pdf->Cell(13,5,"{$row['booked_by']}");
        $pdf->Cell(20,5,"{$row['company_name']}");
        $pdf->Cell(20,5,"{$row['customer_reg_name']}");
        $pdf->Cell(15,5,"{$row['travel_from']}");
        $pdf->Cell(15,5,"{$row['travel_to']}");
        $pdf->Cell(25,5,"{$row['service_id']}");
        $pdf->Cell(15,5,"{$row['flight_no']}");
        $pdf->Cell(20,5,"{$row['pickup_time']}");
        $pdf->Cell(15,5,"{$row['pickup_from']}");
        $pdf->Cell(15,5,"{$row['drop_to']}");
        $pdf->Ln();
        //$pdf->MultiCell(350,5,"{$row['name']}");
    } 
    $data_base_object->close_connection();
    $pdf->Ln();
   // $pdf->Image('images/php.jpg', 50, 50, 55, 35, 'JPG'); // iserts the image
    $pdf->Output("vehicle.pdf","F"); // It would automatically call $pdf->Close();

?>