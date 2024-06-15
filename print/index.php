<?php
    session_start();
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
    $upload_name = $_SESSION["doc_id"];
    $pdfFilePath = 'C:\xampp\htdocs\hackathon\user-uploads\\' . $upload_name; // Specify the path to your PDF file
    $selectedPrinter = 'POS58 Printer'; // Specify the name of the printer

    // // Send the PDF to the selected printer
    $message = printPDF($selectedPrinter, $pdfFilePath);

    header('Location: ../pay/delete_file.php');
    exit;

?>