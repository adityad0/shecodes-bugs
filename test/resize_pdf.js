document.getElementById('resize').addEventListener('click', async (e) => {
    e.preventDefault(); // Prevent form submission

    try {
        const [fileHandle] = await window.showOpenFilePicker({
            types: [
                {
                    description: 'PDF Files',
                    accept: {
                        'application/pdf': ['.pdf'],
                    },
                },
            ],
            excludeAcceptAllOption: true,
            multiple: false,
        });

        const file = await fileHandle.getFile();
        const arrayBuffer = await file.arrayBuffer();

        const { PDFDocument } = PDFLib;
        const pdfDoc = await PDFDocument.load(arrayBuffer);

        const pages = pdfDoc.getPages();
        const newWidth = 136; // example new width in points
        const newHeight = 350; // example new height in points

        pages.forEach(page => {
            const { width, height } = page.getSize();
            const scale = Math.min(newWidth / width, newHeight / height);
            page.scaleContent(scale, scale);
            page.setSize(newWidth, newHeight);
        });

        const pdfBytes = await pdfDoc.save();

        // Create a FormData object to send the cropped PDF to the server
        const formData = new FormData();
        const blob = new Blob([pdfBytes], { type: 'application/pdf' });
        formData.append('userDocUpload', blob, file.name);

        const response = await fetch('upload.php', {
            method: 'POST',
            body: formData,
        });

        if (response.ok) {
            const result = await response.json();
            alert(`PDF resized and uploaded successfully as ${result.newFileName}.`);
            // Optionally, redirect to another page or update the UI
        } else {
            const error = await response.text();
            alert('Failed to upload resized PDF: ' + error);
        }
    } catch (err) {
        console.error(err);
        alert('Failed to resize PDF: ' + err.message);
    }
});
