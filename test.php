<!DOCTYPE html>
<html>
<head>
    <style>
        /* Style the container that holds the file input */
        .file-upload-container {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }

        /* Style the file input itself */
        .file-upload-input {
            position: absolute;
            font-size: 100px;
            opacity: 0;
            right: 0;
            top: 0;
        }

        /* Style the custom button to trigger the file input */
        .file-upload-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }

        /* Style the text inside the custom button */
        .file-upload-button-label {
            font-size: 16px;
        }

        /* Style the image preview */
        #image-preview {
            max-width: 100%;
            max-height: 200px;
        }
    </style>
</head>
<body>

<!-- Container for the file input -->
<div class="file-upload-container">
    <input type="file" name="fileToUpload" id="fileToUpload" class="file-upload-input" onchange="previewImage()">
    <button class="file-upload-button">
        <span class="file-upload-button-label">Select Image</span>
    </button>
</div>

<!-- Image preview -->
<img id="image-preview" src="">

<script>
    function previewImage() {
        const fileInput = document.getElementById('fileToUpload');
        const imagePreview = document.getElementById('image-preview');
        const file = fileInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.src = ''; // Clear the image if no file is selected
        }
    }
</script>

</body>
</html>
