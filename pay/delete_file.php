<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en" style="scroll-behavior: smooth;">
    <head>
        <?php
            $back_by = "";
            $document_title = "Printing";
            require_once '../header.php';
        ?>
    </head>
    <body style="overflow-x: hidden;">
        <?php require_once '../mainnav.php'; ?>
        <div class="container" style="height: 60vh; display: flex; justify-content: center; align-items: center;">
            <div class="text-center">
                <h1>
                    Thank you!
                </h1>
                <?php
                    if(isset($_SESSION["doc_id"])) {
                        $uploadDir = '../user-uploads/';
                        $filename = basename($_SESSION['doc_id']);
                        $filePath = $uploadDir . $filename;
                        if(file_exists($filePath)) {
                            if(unlink($filePath)) {
                                echo "File '$filename' deleted successfully after printing.";
                            } else {
                                echo "Error deleting file '$filename'.";
                            }
                        } else {
                            // File does not exist.
                            echo "File '$filename' deleted successfully.";
                        }
                    } else {
                        // File does not exist.
                        echo "Session invalidated, all session files deleted successfully.";
                    }
                    session_destroy();
                ?>
            </div>
        </div>
        <br><br><br><br>
        <?php require_once '../footer.php'; ?>
    </body>
</html>