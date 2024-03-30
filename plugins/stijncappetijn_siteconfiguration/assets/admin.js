const isImageOrVideoFile = (fileName) => {
  // Regular expression to match image file extensions
  const imageExtensions = /\.(jpg|jpeg|png|gif|bmp|svg\+xml)$/i;
  // Regular expression to match video file extensions
  const videoExtensions = /\.(mp4|webm|ogg|flv|avi|mov|wmv|mkv)$/i;

  // Check if the file name matches any of the image or video extensions
  if (imageExtensions.test(fileName)) {
    return 'image';
  } else if (videoExtensions.test(fileName)) {
    return 'video';
  } else {
    return 'unknown';
  }
}

document.addEventListener('DOMContentLoaded', function() {
  let image_elements = ['about_picture', 'landing_background']
  for (let i = 0; i < image_elements.length; i++) {
    let uploadButton = document.querySelector(`.${image_elements[i]}.select-image-button`);
    let imageUrlInput = document.querySelector(`.${image_elements[i]}.image-url`);
    let previewImage = document.querySelector(`.${image_elements[i]}.image-preview`);
    let previewVideo = document.querySelector(`.${image_elements[i]}.video-preview`);
    let previewContainer = document.querySelector(`.${image_elements[i]}.image-preview-container`);
    let removeButton = document.querySelector(`.${image_elements[i]}.remove-image`);
    uploadButton.addEventListener('click', function(e) {
      e.preventDefault();
      let custom_uploader = wp.media({
        title: 'Choose Image',
        button: {
          text: 'Choose Image'
        },
        multiple: false
      }).on('select', function() {
        let attachment = custom_uploader.state().get('selection').first().toJSON();
        imageUrlInput.value = attachment.url;
        if (isImageOrVideoFile(attachment.url) === 'video') {
          previewVideo.src = attachment.url;
          previewVideo.style.display = 'block';
          previewImage.style.display = 'none';
        } else {
          previewImage.src = attachment.url;
          previewImage.style.display = 'block';
          previewVideo.style.display = 'none';
        }
        state_image();
      }).open();
    });
    removeButton.addEventListener('click', function(e) {
      e.preventDefault();
      previewImage.src = '';
      imageUrlInput.value = '';
      state_no_image();
    });
    let state_image = () => {
      previewContainer.style.display = 'block';
      uploadButton.style.display = 'none';
    }
    let state_no_image = () => {
      previewContainer.style.display = 'none';
      uploadButton.style.display = 'block';
    }
    if (imageUrlInput.value.trim() === '') {
      state_no_image();
    } else {
      state_image();
    }
  }


});

let addSocialsRow = () => {
  let new_row_index = document.getElementById('dynamic-list').childElementCount;
  let newRow = document.createElement('div');
  newRow.className = 'row';
  newRow.innerHTML = `
<input type="text" class="url-input" name="footer_socials[${new_row_index}][0]" placeholder="Enter URL">
<textarea class="svg-input" name="footer_socials[${new_row_index}][1]" placeholder="Enter SVG HTML"></textarea>
`;
  document.getElementById('dynamic-list').appendChild(newRow);
}
