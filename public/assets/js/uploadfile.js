var images = [];
function imageSelect(event) {
	var image = document.getElementById('image').files;
	for (i = 0; i < image.length; i++) {
		images.push({
			name: image[i].name,
			url: URL.createObjectURL(image[i]),
			file: image[i]
		});
	}
	document.getElementById('form').reset();
	document.getElementById('container').innerHTML = imageShow();
}
function imageShow() {
	var image = '';
	images.forEach((i) => {
		image +=
			` <div class="image_container d-flex justify-content-center position-relative">
                    <img src="` +
			i.url +
			`" alt="` +
			i.name +
			`"> 
        <span class="position-absolute" onclick="delete_image(` +
			images.indexOf(i) +
			`)">X</span>
                </div>`;
	});
	return image;
}
function delete_image(e) {
	images.splice(e, 1);
	document.getElementById('container').innerHTML = imageShow();
}
