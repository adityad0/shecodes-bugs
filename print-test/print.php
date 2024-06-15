<?php
    // Function to get the list of printers
    function getPrinters() {
        $output = [];
        exec('wmic printer get name', $output);
        array_shift($output);
        $output = array_filter($output);
        $output = array_map('trim', $output);
        return $output;
    }

    // Function to send a PDF to a printer
    function printPDF($printerName, $pdfPath) {
        // Escape printer name and PDF path for the command line
        $printerNameEscaped = escapeshellarg($printerName);
        $pdfPathEscaped = escapeshellarg($pdfPath);

        // Command to print the PDF
        $command = "PDFtoPrinter.exe $pdfPathEscaped $printerNameEscaped";

        // Execute the command
        exec($command, $output, $returnVar);

        // Check if the command was successful
        if($returnVar === 0) {
            return "PDF sent to printer '$printerName' successfully.";
        } else {
            return "Failed to send PDF to printer '$printerName'.";
        }
    }

    // // Example usage
    $printers = getPrinters();
    $pdfFilePath = 'rs.pdf'; 
    $selectedPrinter = 'POS58 Printer'; 


    // // Send the PDF to the selected printer
    $message = printPDF($selectedPrinter, $pdfFilePath);
?>