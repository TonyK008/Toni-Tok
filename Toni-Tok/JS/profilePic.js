function displaySelectedImage(event) {
    var input = event.target;
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('selectedImage').src = e.target.result;
            document.getElementById('selectedImageContainer').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}