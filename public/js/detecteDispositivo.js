function detectarDispositivo() {
    var userAgent = navigator.userAgent || navigator.vendor || window.opera;

    // Verificar se é um dispositivo móvel
    if (/android/i.test(userAgent)) {
        return "Android";
    }
    if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
        return "iOS";
    }
    if (/windows phone/i.test(userAgent)) {
        return "Windows Phone";
    }
    if (/Macintosh/i.test(userAgent)) {
        return "Mac";
    }
    if (/Windows/i.test(userAgent)) {
        return "Windows";
    }
    if (/Linux/i.test(userAgent)) {
        return "Linux";
    }

    return "Desconhecido";
}

// Exibir o tipo de dispositivo
var dispositivo = detectarDispositivo();
console.log("Tipo de dispositivo: " + dispositivo);
document.getElementById('tipo-dispositivo').textContent = "Tipo de dispositivo: " + dispositivo;
