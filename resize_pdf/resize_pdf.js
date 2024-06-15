document.getElementById('resize').addEventListener('click', async () => {
    const fileInput = document.getElementById('upload');
    if(fileInput.files.length === 0) {
        alert('Please upload a PDF file.');
        return;
    }

    const file = fileInput.files[0];
    const arrayBuffer = await file.arrayBuffer();

    const { PDFDocument } = PDFLib;
    const pdfDoc = await PDFDocument.load(arrayBuffer);

    const pages = pdfDoc.getPages();
    const newWidth = 136; // example new width in points
    const newHeight = 350; 

    pages.forEach(page => {
        const { width, height } = page.getSize();
        const scale = Math.min(newWidth / width, newHeight / height);
        page.scaleContent(scale, scale);
        page.setSize(newWidth, newHeight);
    });

    const pdfBytes = await pdfDoc.save();
    download(pdfBytes, 'resized.pdf', 'application/pdf');
});

function download(data, filename, type) {
    const blob = new Blob([data], { type });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = filename;
    link.click();
}
