<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $targetDir = "user-uploads/";
    $originalFileName = basename($_FILES["userDocUpload"]["name"]);
    $fileType = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));
    $newFileName = uniqid('upload_', true) . '.' . $fileType;
    $targetFile = $targetDir . $newFileName;
    $uploadOk = 1;

    if($_FILES["userDocUpload"]["size"] > 5000000) {
        echo "Sorry, your file is too large. 1";
        $uploadOk = 0;
        exit;
    }

    $allowedTypes = array("pdf");
    if(!in_array($fileType, $allowedTypes)) {
        echo "Sorry, only PDF files are allowed.";
        $uploadOk = 0;
        exit;
    }

    if($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        header('Location: home.php?error=An unknown error prevented your file from being uploaded. Please try again.&error_code=1');
        exit;
    } else {
        if(move_uploaded_file($_FILES["userDocUpload"]["tmp_name"], $targetFile)) {
            echo "Your file " . htmlspecialchars(strip_tags(trim($originalFileName))) . " has been uploaded as " . htmlspecialchars($newFileName) . ".";
        } else {
            echo "Sorry, there was an error uploading your file.";
            header('Location: home.php?error=An unknown error prevented your file from being uploaded. Please try again.&error_code=2');
            exit;
        }
    }
} else {
    header('Location: home.php?action=upload');
    exit;
}
?>

<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en" style="scroll-behavior: smooth;">
    <head>
        <?php
            $back_by = "";
            $document_title = "Printing";
            require_once 'header.php';
        ?>
    </head>
    <body style="overflow-x: hidden;">
        <?php require_once 'mainnav.php'; ?>
        <div class="container">
            <br>
            <div id="pdf-controls">
                <button class="btn btn-outline-primary" id="prev-page"><span class="material-symbols-rounded color-cyan">skip_previous</span>&nbsp;Previous</button>
                <button class="btn btn-outline-primary" id="next-page"><span class="material-symbols-rounded color-cyan">skip_next</span>&nbsp;Next</button>
                <button class="btn btn-outline-primary" id="zoom-in"><span class="material-symbols-rounded color-cyan">zoom_in</span>&nbsp;Zoom In</button>
                <button class="btn btn-outline-primary" id="zoom-out"><span class="material-symbols-rounded color-cyan">zoom_out</span>&nbsp;Zoom Out</button>
                <button class="btn btn-outline-primary" id="rotate-cw"><span class="material-symbols-rounded color-cyan">rotate_right</span>&nbsp;Rotate Clockwise</button>
                <button class="btn btn-outline-primary" id="rotate-ccw"><span class="material-symbols-rounded color-cyan">rotate_left</span>&nbsp;Rotate Counterclockwise</button>
                <span>Page: <span id="page-num"></span> / <span id="page-count"></span></span>
            </div>
            <br>
            <div id="pdf-viewer" style="width: 100%; border: 1px solid black; text-align: center;"></div>
            <br>
        </div>
        <div class="container">
            <form action="pay/index.php" method="POST">
                <input type="hidden" name="doc_id" value="<?php echo $newFileName; ?>" required>
                <input type="hidden" id="payFormPageCount" name="page_count" value="" required>
                <input type="checkbox" name="" id="" required>&nbsp;I agree that the document is correct and ready to be printed.
                <br><br>
                <button class="btn btn-outline-primary" style="width: 100%;">
                    <span class="material-symbols-rounded color-cyan">print</span>&nbsp;Pay & Print
                </button>
                <br><br>
            </form>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.5.207/pdf.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.5.207/pdf.worker.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var url = "<?php echo $targetDir . $newFileName; ?>";
                var pdfjsLib = window['pdfjs-dist/build/pdf'];
                pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.5.207/pdf.worker.min.js';
                var pdfDoc = null,
                    pageNum = 1,
                    pageRendering = false,
                    pageNumPending = null,
                    scale = 1.0,
                    rotation = 0,
                    canvas = document.createElement('canvas'),
                    ctx = canvas.getContext('2d'),
                    container = document.getElementById('pdf-viewer');
                container.appendChild(canvas);
                function renderPage(num) {
                    pageRendering = true;
                    pdfDoc.getPage(num).then(function (page) {
                        var viewport = page.getViewport({ scale: scale, rotation: rotation });
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;
                        var renderContext = {
                            canvasContext: ctx,
                            viewport: viewport
                        };
                        var renderTask = page.render(renderContext);
                        renderTask.promise.then(function () {
                            pageRendering = false;
                            if (pageNumPending !== null) {
                                renderPage(pageNumPending);
                                pageNumPending = null;
                            }
                        });
                    });
                    document.getElementById('page-num').textContent = num;
                }
                function queueRenderPage(num) {
                    if(pageRendering) {
                        pageNumPending = num;
                    } else {
                        renderPage(num);
                    }
                }
                function onPrevPage() {
                    if(pageNum <= 1) {
                        return;
                    }
                    pageNum--;
                    queueRenderPage(pageNum);
                }
                function onNextPage() {
                    if(pageNum >= pdfDoc.numPages) {
                        return;
                    }
                    pageNum++;
                    queueRenderPage(pageNum);
                }
                function onZoomIn() {
                    scale += 0.1;
                    queueRenderPage(pageNum);
                }
                function onZoomOut() {
                    if(scale > 0.2) {
                        scale -= 0.1;
                        queueRenderPage(pageNum);
                    }
                }
                function onRotateCW() {
                    rotation = (rotation + 90) % 360;
                    queueRenderPage(pageNum);
                }
                function onRotateCCW() {
                    rotation = (rotation - 90) % 360;
                    queueRenderPage(pageNum);
                }
                document.getElementById('prev-page').addEventListener('click', onPrevPage);
                document.getElementById('next-page').addEventListener('click', onNextPage);
                document.getElementById('zoom-in').addEventListener('click', onZoomIn);
                document.getElementById('zoom-out').addEventListener('click', onZoomOut);
                document.getElementById('rotate-cw').addEventListener('click', onRotateCW);
                document.getElementById('rotate-ccw').addEventListener('click', onRotateCCW);
                var loadingTask = pdfjsLib.getDocument(url);
                loadingTask.promise.then(function (pdf) {
                    pdfDoc = pdf;
                    document.getElementById('page-count').textContent = pdf.numPages;
                    document.getElementById('payFormPageCount').value = pdf.numPages;
                    renderPage(pageNum);
                }, function (reason) {
                    console.error(reason);
                });
            });
        </script>
        <br><br><br><br>
        <?php require_once 'footer.php'; ?>
    </body>
</html>
