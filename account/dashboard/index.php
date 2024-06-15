<?php session_start(); ?>
<!DOCTYPE html>
<html style="scroll-behavior: smooth;">
    <head>
        <?php
            $back_by = "";
            $document_title = "Printing";
            $back_by = "../../";
            require_once $back_by . 'header.php';
        ?>
    </head>
    <body style="overflow-x: hidden;">
        <?php require_once $back_by . 'mainnav.php'; ?>
        <div class="container" style="height: 60vh; display: flex; align-items: center; justify-content: center;">
            <div class="">
                <h1>
                    Hi,
                </h1>
                <h1>
                    Welcome to the print app, upload your files to get started.
                </h1>
                <br><br>
                <div class="row">
                    <div class="col">
                        <form action="../../upload_new.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="userDocUpload" class="form-label">Select a PDF file</label>
                                <div class="input-group">
                                    <input type="file" name="userDocUpload" class="form-control" id="userDocUpload" aria-describedby="basic-addon4" accept=".pdf" required>
                                </div>
                                <div class="form-text" id="basic-addon4">Supported file types: PDF</div>
                            </div>
                            <button class="btn btn-outline-primary" style="width: 100%;">
                                <span class="material-symbols-rounded color-blue">upload_file</span>&nbsp;Upload files
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br><br><br><br><br><br>
        <?php
            $footer_path = '<a href="https://lynkrtech.com/" class="uLine">Home</a>';
            require_once $back_by . 'footer.php';
        ?>
    </body>
    <script src="script.js" crossorigin="anonymous" defer></script>
</html>