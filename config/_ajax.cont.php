<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>

  let states = [];
  let listeners = [];
  
  function execute({ 
    method = 'GET', 
    script, 
    data = {}, 
    success = () => {}, 
    error = () => {} 
}) {
    const baseUrl = "/src/";
    const fileExtension = ".src.php";

    // Ensure the script does not end with the file extension
    if (!script.endsWith(fileExtension)) {
        script += fileExtension;
    }

    $.ajax({
        url: baseUrl + script,
        type: method.toUpperCase(),  // Ensure method is in uppercase
        data: data,
        success: (response) => {
            if (typeof success === "function") {
                success(response);
            }
        },
        error: (err) => {
            if (typeof error === "function") {
                error(err);
            }
        }
    });
}


  function $update(target, data) {
    $(target).html(data);
  }

  function addFavicon(faviconURL, type = 'image/x-icon') {
    // Create a new link element
    const link = document.createElement('link');
    link.rel = 'icon';
    link.href = faviconURL;
    link.type = type;

    // Remove any existing favicon
    const existingFavicon = document.querySelector('link[rel="icon"]');
    if (existingFavicon) {
        existingFavicon.parentNode.removeChild(existingFavicon);
    }

    // Append the new favicon to the <head>
    document.head.appendChild(link);
}

// Usage example:
// Adding a favicon with default type (image/x-icon)
addFavicon('path/to/favicon.ico');

// For other types like PNG:
// addFavicon('path/to/favicon.png', 'image/png');

</script>