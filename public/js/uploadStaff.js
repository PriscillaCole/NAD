
window.uploadFile = function(input, token) {
    const file = input.files[0];
    const formData = new FormData();
    formData.append('_token', token); // Append CSRF token
    formData.append('file', file);

    const xhr = new window.XMLHttpRequest();

    xhr.upload.addEventListener('progress', function(event) {
        if (event.lengthComputable) {
            const percentComplete = (event.loaded / event.total) * 100;
            document.getElementById('upload-progress').value = percentComplete;
        }
    });

    xhr.onreadystatechange = function() {
        if (xhr.readyState === xhr.DONE) {
            console.log(xhr.status);
            if (xhr.status === 200) {
                // Upload successful, you can handle the response here if needed
                // For now, let's just change the button to a submit button
                document.getElementById('upload-progress').style.display = 'none';
                input.style.display = 'none';
                input.parentNode.innerHTML = '<i class=\"fa fa-check\"></i>&nbsp;Submitted';
                //success message
                Swal.fire({
                    title: 'Success',
                    text: 'Staff data uploaded successfully',
                    icon: 'success'
                });
            } else {
                // Error handling
                console.error('Error during file upload');
                Swal.fire({
                    title: 'Oops...',
                    text: 'Error during file upload. Please try again.'
                });
                
            }
        }
    };

    xhr.open('POST', '/upload-staff', true);
    xhr.send(formData);

    // Display the progress bar
    document.getElementById('upload-progress').style.display = 'block';
}