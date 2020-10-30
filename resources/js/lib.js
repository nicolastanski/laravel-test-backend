module.exports = function(document) {
    if (document.length == 11) return document.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");

    return document.replace(/(\d{2})(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3/$4-$5");
}
