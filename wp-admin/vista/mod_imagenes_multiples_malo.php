

<!-- jQuery UI styles -->
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/dark-hive/jquery-ui.css" id="theme">

<style>
/* Adjust the jQuery UI widget font-size: */
.ui-widget {
    font-size: 0.95em;
}
</style>
<!-- blueimp Gallery styles -->
<link rel="stylesheet" href="http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="scripts/fileupload2/css/jquery.fileupload.css">
<link rel="stylesheet" href="scripts/fileupload2/css/jquery.fileupload-ui.css">


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="http://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="http://blueimp.github.io/JavaScript-Load-Image/js/load-image.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="http://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- blueimp Gallery script -->
<script src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="scripts/fileupload2/js/jquery.iframe-transport.js"></script>

<!-- The File Upload processing plugin -->
<script src="scripts/fileupload2/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="scripts/fileupload2/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="scripts/fileupload2/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="scripts/fileupload2/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="scripts/fileupload2/js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="scripts/fileupload2/js/jquery.fileupload-ui.js"></script>
<!-- The File Upload jQuery UI plugin -->
<script src="scripts/fileupload2/js/jquery.fileupload-jquery-ui.js"></script>
<!-- The main application script -->
<script src="scripts/fileupload2/js/main.js"></script>


<!--
<link href="scripts/fileupload/css/jquery.fileupload-ui.css" rel="stylesheet" type="text/css" />
-->
<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<!--
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/trontastic/jquery-ui.css" rel="stylesheet" type="text/css" />
-->
<style>
.progress-bar {
	float: left;
    height: 18px;
    text-shadow: 0 -1px 0 rgba(0,0,0,0.25);
	background-color: #5bb75b;
	background-image: -moz-linear-gradient(top,#62c462,#51a351);
	background-image: -webkit-gradient(linear,0 0,0 100%,from(#62c462),to(#51a351));
	background-image: -webkit-linear-gradient(top,#62c462,#51a351);
	background-image: -o-linear-gradient(top,#62c462,#51a351);
	background-image: linear-gradient(to bottom,#62c462,#51a351);
	background-repeat: repeat-x;
	border-color: #51a351 #51a351 #387038;
	border-color: rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff62c462',endColorstr='#ff51a351',GradientType=0);
	filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
}
.progress{
	width: 90%;
}
</style>

<!--
<script src="../scripts/bootstrap.min.js"></script>
-->
<br><br>
<!-- The file upload form used as target for the file upload widget -->
<form id="fileupload" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">
    <!-- Redirect browsers with JavaScript disabled to the origin page -->
    <noscript><input type="hidden" name="redirect" value="http://blueimp.github.io/jQuery-File-Upload/"></noscript>
    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
    <div class="fileupload-buttonbar">
        <div class="fileupload-buttons">
            <!-- The fileinput-button span is used to style the file input field as button -->
            <span class="fileinput-button">
                <span>Add files...</span>
                <input type="file" name="files[]" multiple>
            </span>
            <button type="submit" class="start">Start upload</button>
            <button type="reset" class="cancel">Cancel upload</button>
            <button type="button" class="delete">Delete</button>
            <input type="checkbox" class="toggle">
            <!-- The global file processing state -->
            <span class="fileupload-process"></span>
        </div>
        <!-- The global progress state -->
        <div class="fileupload-progress fade" style="display:none">
            <!-- The global progress bar -->
            <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
            <!-- The extended global progress state -->
            <div class="progress-extended">&nbsp;</div>
        </div>
    </div>
    <!-- The table listing the files available for upload/download -->
    <table role="presentation"><tbody class="files"></tbody></table>
</form>
<br>
<h3>Demo Notes</h3>
<ul>
    <li>The maximum file size for uploads in this demo is <strong>5 MB</strong> (default file size is unlimited).</li>
    <li>Only image files (<strong>JPG, GIF, PNG</strong>) are allowed in this demo (by default there is no file type restriction).</li>
    <li>Uploaded files will be deleted automatically after <strong>5 minutes</strong> (demo setting).</li>
    <li>You can <strong>drag &amp; drop</strong> files from your desktop on this webpage (see <a href="https://github.com/blueimp/jQuery-File-Upload/wiki/Browser-support">Browser support</a>).</li>
    <li>Please refer to the <a href="https://github.com/blueimp/jQuery-File-Upload">project website</a> and <a href="https://github.com/blueimp/jQuery-File-Upload/wiki">documentation</a> for more information.</li>
    <li>Built with <a href="http://jqueryui.com">jQuery UI</a>.</li>
</ul>
<!-- The blueimp Gallery widget -->
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress"></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="start">Start</button>
            {% } %}
            {% if (!i) { %}
                <button class="cancel">Cancel</button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
            </p>
            {% if (file.error) { %}
                <div><span class="error">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            <button class="delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>Delete</button>
            <input type="checkbox" name="delete" value="1" class="toggle">
        </td>
    </tr>
{% } %}
</script>

<script>
// Initialize the jQuery UI theme switcher:
$('#theme-switcher').change(function () {
    var theme = $('#theme');
    theme.prop(
        'href',
        theme.prop('href').replace(
            /[\w\-]+\/jquery-ui.css/,
            $(this).val() + '/jquery-ui.css'
        )
    );
});
</script>