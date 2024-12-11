window.uploadFile = function(input, token) {
    const file = input.files[0];
    if (!file) {
        Swal.fire({
            title: 'Error',
            text: 'No file selected.',
            icon: 'error'
        });
        return;
    }

    const formData = new FormData();
    formData.append('_token', token); // Append CSRF token
    formData.append('file', file);

    const xhr = new XMLHttpRequest();

    xhr.upload.addEventListener('progress', function(event) {
        if (event.lengthComputable) {
            const percentComplete = (event.loaded / event.total) * 100;
            document.getElementById('upload-progress').value = percentComplete;
        }
    });

    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Upload successful
                document.getElementById('upload-progress').style.display = 'none';
                input.style.display = 'none';
                input.parentNode.innerHTML = '<i class="fa fa-check"></i>&nbsp;Submitted';
                // Success message
                Swal.fire({
                    title: 'Success',
                    text: 'Staff data uploaded successfully',
                    icon: 'success'
                });
            } else {
                // Error handling
                console.error('Error during file upload:', xhr.responseText);
                Swal.fire({
                    title: 'Error',
                    text: 'File upload failed. Please try again.',
                    icon: 'error'
                });
            }
        }
    };

    xhr.open('POST', '/upload-staff', true);

    // Add cache-busting parameter to prevent issues with browser caching
    xhr.setRequestHeader('Cache-Control', 'no-cache');

    xhr.send(formData);

    // Display the progress bar
    document.getElementById('upload-progress').style.display = 'block';
};
