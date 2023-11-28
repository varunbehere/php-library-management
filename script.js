function validateForm() {
    var isbn = document.getElementById('isbn').value;
    // Simple ISBN validation - should be numeric and of a certain length
    if (isNaN(isbn) || isbn.length !== 13) {
        alert('Invalid ISBN. Please enter a 13-digit numeric ISBN.');
        return false;
    }
    return true;
}
function showPrompt(message) {
    alert(message);
}