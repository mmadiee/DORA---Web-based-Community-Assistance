function generatePDF(){
    const element = document.getElementById("pdf-container");   

    html2pdf()
    .from(element)
    .save();
}