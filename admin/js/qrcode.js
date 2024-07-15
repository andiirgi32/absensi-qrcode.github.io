document.getElementById('qrcode-form').addEventListener('submit', function (e) {
    e.preventDefault();
    let qrcodeContainer = document.getElementById('qrcode');
    let qrcodeParentContainer = document.getElementById('qrcode-container');
    qrcodeContainer.innerHTML = "";
    qrcodeParentContainer.style.display = 'none';
    let text = document.getElementById('text').value;
    let logoInput = document.getElementById('logo');
    let errorMessage = document.getElementById('error-message');
    errorMessage.style.display = 'none';

    // Check if a logo is provided and if it's square
    if (logoInput.files && logoInput.files[0]) {
        let logo = new Image();
        logo.onload = function () {
            if (logo.width !== logo.height) {
                errorMessage.style.display = 'block';
                return;
            }
            generateQRCode(text, logo);
        };
        logo.src = URL.createObjectURL(logoInput.files[0]);
    } else {
        generateQRCode(text, null);
    }
});

function generateQRCode(text, logo) {
    let qrcodeContainer = document.getElementById('qrcode');
    let qrcodeParentContainer = document.getElementById('qrcode-container');
    let qrcode = new QRCode(qrcodeContainer, {
        text: text,
        width: 1024,
        height: 1024,
        correctLevel: QRCode.CorrectLevel.H
    });

    setTimeout(() => {
        let canvas = qrcodeContainer.getElementsByTagName('canvas')[0];
        let newCanvas = document.createElement('canvas');
        let padding = 100;
        newCanvas.width = canvas.width + padding * 2;
        newCanvas.height = canvas.height + padding * 2;
        let newContext = newCanvas.getContext("2d");
        newContext.fillStyle = "white";
        newContext.fillRect(0, 0, newCanvas.width, newCanvas.height);
        newContext.drawImage(canvas, padding, padding);

        if (logo) {
            let logoSize = 192; // Ukuran logo
            let x = (newCanvas.width / 2) - (logoSize / 2);
            let y = (newCanvas.height / 2) - (logoSize / 2);
            newContext.drawImage(logo, x, y, logoSize, logoSize);
        }

        qrcodeContainer.innerHTML = "";
        qrcodeContainer.appendChild(newCanvas);

        let downloadBtn = document.getElementById('download-btn');
        downloadBtn.style.display = 'block';
        downloadBtn.addEventListener('click', function () {
            let link = document.createElement('a');
            link.href = newCanvas.toDataURL("image/png");
            link.download = 'qrcode.png';
            link.click();
        });

        // Display the QR code container after QR code generation is complete
        qrcodeParentContainer.style.display = 'block';
    }, 100);
}