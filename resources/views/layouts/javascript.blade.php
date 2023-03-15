<script src="{{ uploadAndDownloadUrl() }}admin/assets/js/bootstrap.bundle.min.js"></script>
<!--plugins-->
<script src="{{ uploadAndDownloadUrl() }}admin/assets/js/jquery.min.js"></script>
<script src="{{ uploadAndDownloadUrl() }}admin/assets/plugins/simplebar/js/simplebar.min.js"></script>
<script src="{{ uploadAndDownloadUrl() }}admin/assets/plugins/metismenu/js/metisMenu.min.js"></script>
<script src="{{ uploadAndDownloadUrl() }}admin/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<script src="{{ uploadAndDownloadUrl() }}admin/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="{{ uploadAndDownloadUrl() }}admin/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="{{ uploadAndDownloadUrl() }}admin/assets/plugins/chartjs/js/Chart.min.js"></script>
<script src="{{ uploadAndDownloadUrl() }}admin/assets/plugins/chartjs/js/Chart.extension.js"></script>
<script src="{{ uploadAndDownloadUrl() }}admin/assets/js/index.js"></script>
<script src="{{ uploadAndDownloadUrl() }}admin/assets/js/common.js"></script>
<!--app JS-->
<script src="{{ uploadAndDownloadUrl() }}admin/assets/js/notify/bootstrap-notify.min.js"></script>
<script src="{{ uploadAndDownloadUrl() }}admin/assets/js/sweet-alert/sweetalert.min.js"></script>
<script src="{{ uploadAndDownloadUrl() }}admin/assets/js/toaster/toastr.min.js"></script>
<script src="{{ uploadAndDownloadUrl() }}admin/assets/js/tinymce/jquery.tinymce.min.js"></script>
<script src="{{ uploadAndDownloadUrl() }}admin/assets/js/tinymce/tinymce.min.js"></script>
<script src="{{ uploadAndDownloadUrl() }}/admin/assets/js/select2/js/select2.min.js"></script>
<script src="{{ uploadAndDownloadUrl() }}admin/assets/js/app.js"></script>
<script type="text/javascript">
    $(document).on("click", "#select_all", function() {
        check_uncheck_data();
    });

    function check_uncheck_data() {
        if ($("#select_all").prop("checked")) {
            $(".select_checkbox_value").prop("checked", true);
        } else {
            $(".select_checkbox_value").prop("checked", false);
        }
    }

    tinymce.init({
        selector: '.editor-tinymce',
        height: 250,
        directionality: "ltr",
        plugins: 'advlist autolink lists link charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table contextmenu paste code image codesample',
        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image codesample',

        automatic_uploads: false,
        relative_urls: false,

        images_upload_handler: function(blobInfo, success, failure) {
            var xhr, formData;

            xhr = new XMLHttpRequest();


            xhr.withCredentials = false;

            var generateToken = '{{ csrf_token() }}';
            xhr.setRequestHeader("X-CSRF-Token", generateToken);

            xhr.onload = function(data) {

                var json;

                if (xhr.status != 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }

                json = JSON.parse(xhr.responseText);

                if (!json || typeof json.file_path != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }

                success(json.file_path);
            };

            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            xhr.send(formData);
        },
    });
</script>
