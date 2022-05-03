var DropzoneExample = function () {
    var DropzoneDemos = function () {
        Dropzone.options.singleFileUpload = {
            paramName: "file",
            maxFiles: 1,
            maxFilesize: 5,
            accept: function(file, done) {
                if (file.name == "justinbieber.jpg") {
                    done("Naha, you don't.");
                } else {
                    done();
                }
            }
        };
        Dropzone.options.multiFileUpload = {
            paramName: "file",
            maxFiles: 10,
            maxFilesize: 2,
            uploadMultiple: true,
            acceptedFiles: "image/*",
            // addRemoveLinks: true,
            accept: function(file, done) {
                if (file.name == "justinbieber.jpg") {
                    done("Naha, you don't.");
                } else {
                    done();
                }
            },
            success: function (file, response) {
                console.log('more than one')
                response.forEach((entry) => {
                    $('form.product-create').append('<input type="hidden" name="image[]" value="' + entry.image_raw.id + '" class="input img_id" data-url="' + entry.image_raw.url + '">')
                    console.log(entry);
                });
                console.log(response);
                if (response.length > 1) {
                    
                } else {
                    console.log('single')
                    // $('form.product-create').append('<input type="hidden" name="image[]" value="' + response.image_raw.id + '" class="input img_id" data-url="' + response.image_raw.url + '">')
                }
            },
            removedfile: function (file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedDocumentMap[file.name]
                }
                $('form').find('input[name="document[]"][value="' + name + '"]').remove()
            },
        };
        Dropzone.options.fileTypeValidation = {
            paramName: "file",
            maxFiles: 10,
            maxFilesize: 10, 
            acceptedFiles: "image/*,application/pdf,.psd",
            accept: function(file, done) {
                if (file.name == "justinbieber.jpg") {
                    done("Naha, you don't.");
                } else {
                    done();
                }
            }
        };
    }
    return {
        init: function() {
            DropzoneDemos();
        }
    };
}();
DropzoneExample.init();