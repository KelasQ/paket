        <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

        <script>
            window.jQuery || document.write('<script src="<?= base_url(); ?>assets/src/js/vendor/jquery-3.3.1.min.js"><\/script>')
        </script>

        <script src="<?= base_url(); ?>assets/js/webcamjs.js"></script>
        <script src="<?= base_url(); ?>assets/plugins/popper.js/dist/umd/popper.min.js"></script>
        <script src="<?= base_url(); ?>assets/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="<?= base_url(); ?>assets/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
        <script src="<?= base_url(); ?>assets/plugins/screenfull/dist/screenfull.js"></script>
        <script src="<?= base_url(); ?>assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="<?= base_url(); ?>assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="<?= base_url(); ?>assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="<?= base_url(); ?>assets/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
        <script src="<?= base_url(); ?>assets/plugins/jvectormap/jquery-jvectormap.min.js"></script>
        <script src="<?= base_url(); ?>assets/plugins/jvectormap/tests/assets/jquery-jvectormap-world-mill-en.js"></script>
        <script src="<?= base_url(); ?>assets/plugins/moment/moment.js"></script>
        <script src="<?= base_url(); ?>assets/plugins/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js"></script>
        <script src="<?= base_url(); ?>assets/plugins/d3/dist/d3.min.js"></script>
        <script src="<?= base_url(); ?>assets/plugins/c3/c3.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/tables.js"></script>
        <script src="<?= base_url(); ?>assets/js/widgets.js"></script>
        <script src="<?= base_url(); ?>assets/js/charts.js"></script>
        <script src="<?= base_url(); ?>assets/dist/js/theme.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/form-components.js"></script>
        <script src="<?= base_url(); ?>assets/js/datatables.js"></script>
        <script src="<?= base_url(); ?>assets/tesseract.min.js"></script>
        <script src="<?= base_url(); ?>assets/cropper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.js"></script>
        <script src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
        <script src="<?= base_url(); ?>assets/OwlCarousel/dist/owl.carousel.min.js"></script>
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.js"></script> -->
        <script src="<?php echo base_url('/assets/dist/js/jquery.lazy.min.js') ?>"></script>
        <script>
            // let dateTime = new Date()
            // let formatDate = dateTime.toISOString().slice(0, 19).replace("T", " ")
            // console.log(formatDate)      

            var cropper;

            function gray(imgObj) {
                var canvas = document.createElement('canvas');
                var canvasContext = canvas.getContext('2d');

                var imgW = imgObj.width;
                var imgH = imgObj.height;
                canvas.width = imgW;
                canvas.height = imgH;

                canvasContext.drawImage(imgObj, 0, 0);
                var imgPixels = canvasContext.getImageData(0, 0, imgW, imgH);

                for (var y = 0; y < imgPixels.height; y++) {
                    for (var x = 0; x < imgPixels.width; x++) {
                        var i = (y * 4) * imgPixels.width + x * 4;
                        var avg = (imgPixels.data[i] + imgPixels.data[i + 1] + imgPixels.data[i + 2]) / 3;
                        imgPixels.data[i] = avg;
                        imgPixels.data[i + 1] = avg;
                        imgPixels.data[i + 2] = avg;
                    }
                }
                canvasContext.putImageData(imgPixels, 0, 0, 0, 0, imgPixels.width, imgPixels.height);
                return canvas.toDataURL();
            }

            function readURL(input, el, cb = '') {
                if (input.files && input.files[0]) {
                    console.log(input.files[0]);
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $(el).attr('src', e.target.result);
                        if (cb) cb()
                    }

                    reader.readAsDataURL(input.files[0]); // convert to base64 string

                }
            }

            function addElementAfterChangeFile() {
                var divEl = document.createElement('div');
                divEl.setAttribute('class', 'text-center my-camera-preview-container mb-3');

                var btnAction = document.createElement('button');
                btnAction.setAttribute('id', 'js-cropAndExtract');
                btnAction.setAttribute('class', 'btn btn-primary btn-block');
                btnAction.innerHTML = 'Crop Gambar';
                btnAction.addEventListener('click', function(e) {
                    e.preventDefault();
                    btnAction.innerHTML = '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Cropping...'

                    let canvas = cropper.getCroppedCanvas();

                    //extractTextFromImage( canvas.toDataURL() )
                    extractTextFromImage(gray(canvas))
                        .then((data) => {
                            console.log(data)
                            btnAction.innerHTML = 'Crop Gambar';

                            let extracted_no_invoice = data.data.text;
                            extracted_no_invoice = extracted_no_invoice.replace(" ", "");
                            extracted_no_invoice = extracted_no_invoice.replace("'", "");
                            extracted_no_invoice = extracted_no_invoice.replace("`", "");
                            extracted_no_invoice = extracted_no_invoice.replace("\n", "");
                            document.querySelector('#hasil').value = extracted_no_invoice;
                        });


                });

                divEl.appendChild(btnAction);
                document.getElementById('results').appendChild(divEl);
            }

            function cropImage(image) {
                var minAspectRatio = 0.5;
                var maxAspectRatio = 1.5;
                cropper = new Cropper(image, {
                    dragMode: 'move',
                });
            }

            function extractTextFromImage(image) {
                return Tesseract.recognize(image, 'eng', {
                    workerPath: 'https://unpkg.com/tesseract.js@v2.0.0/dist/worker.min.js',
                    langPath: 'https://cdn.rawgit.com/naptha/tessdata/gh-pages/3.02/',
                    corePath: 'https://unpkg.com/tesseract.js-core@v2.0.0/tesseract-core.wasm.js',
                })
            }
        </script>
        <?php if ($this->uri->segment(1) == 'paket') {
            if ($this->uri->segment(2) == 'edit') { ?>

                <script type="text/javascript">
                    $('#register').on('submit', function(event) {
                        event.preventDefault();

                        var start = $('#i-start').val();
                        var end = $('#i-end').val();

                        var id = $('#i-id').val();
                        var gambar = $('#my_camera')[0].files[0];
                        var username = $('#username').val();
                        var old_gambar = $('#i-old_gambar').val();
                        //var noInvoice   = $('#hasil').val();
                        var paketFormData = new FormData();

                        paketFormData.append('username', username);
                        paketFormData.append('gambar', gambar);
                        paketFormData.append('id', id);
                        paketFormData.append('old_gambar', old_gambar);
                        paketFormData.append('start', start);
                        paketFormData.append('end', end);
                        //paketFormData.append('noInvoice', noInvoice);

                        $.ajax({
                                url: '<?php echo site_url("paket/update/"); ?>' + id,
                                type: 'POST',
                                contentType: false,
                                processData: false,
                                data: paketFormData,
                                success: function(res) {
                                    console.log('success', res);
                                    let obj = JSON.parse(res)
                                    alert('insert data sukses');
                                    document.location = obj.redirect;

                                    if (res > 0) {


                                        $('#results').html('');
                                        $('#hasil').val('');
                                        $('#my_camera').val('');
                                        $('#previewCamera').attr('src', '');
                                        //cropper.destroy();
                                    }
                                },
                                error: function(err) {
                                    console.log(err);
                                }
                            })
                            .fail(function(err) {
                                console.log("error", err);
                            })
                            .always(function() {
                                console.log("complete");
                            });
                    });
                </script>
                <script type="text/javascript">
                    // <Paket>
                    let myCamera = document.querySelector('#my_camera');
                    myCamera.addEventListener('change', function() {
                        readURL(this, '#previewCamera');
                        //addElementAfterChangeFile();
                    });

                    function paketPreviewLoaded() {
                        cropImage(document.querySelector('#previewCamera'));
                    }

                    // </Paket>
                </script>
        <?php }
        } ?>

        <script>
            // <Kasir>
            let iInvoiceEl = document.querySelector('#i-invoice');
            if (iInvoiceEl) {
                iInvoiceEl.addEventListener('change', function(e) {
                    readURL(this, '#imagePreview');
                    //kasirAddElementAfterChangeFile();
                    console.log(e.target.files)
                    previewUploadFile(e.target.files[0]);
                });
            }

            function kasirPreviewLoaded() {
                cropImage(document.querySelector('#imagePreview'));
            }

            function kasirAddElementAfterChangeFile() {
                $('#imagePreviewContainer').append(`
                    <button class='btn btn-primary btn-block mt-2' id="kasir-crop-image">Crop Gambar</button>
                `);
            }

            function previewUploadFile(file) {
                $('#preview-file').html('Loading...');
                let formData = new FormData();
                formData.append('file', file);
                $.ajax({
                    method: 'POST',
                    url: '<?php echo base_url('invoice/tmpUpload') ?>',
                    data: formData,
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(response) {
                        console.log(response);

                        switch (file.type) {
                            case 'application/pdf':
                                $('#preview-file').html(`<iframe src="<?php echo base_url('/ViewerJS/#../tmpUpload/') ?>${response}" width="100%" height="300"></iframe>`);
                                break;

                            case 'image/png':
                            case 'image/jpg':
                            case 'image/jpeg':
                            case 'image/gif':
                                $('#preview-file').html(`<img src="<?php echo base_url('/tmpUpload/') ?>${response}" class="img-fluid">`)
                                break;
                        }
                    }
                })
            }


            $(document).on('click', '#kasir-crop-image', function(e) {
                e.preventDefault();
                let btnAction = $(this);
                $(this).html('Cropping...');
                extractTextFromImage(cropper.getCroppedCanvas().toDataURL())
                    .then(({
                        data: {
                            text
                        }
                    }) => {
                        btnAction.html('Crop Gambar');
                        text = text.replace(/\s/g, '')
                        document.querySelector('#i-no_invoice').value = text;
                    });
            })

            $('#saveKasir').click(function(event) {
                event.preventDefault();
                //var invoice = $('#i-invoice')[0].files[0];
                var noInvoice = $('#i-no_invoice').val();
                var keterangan = $('#i-keterangan').val();
                var id = $('#i-id').val();
                var kasirFormData = new FormData();
                kasirFormData.append('no_invoice', noInvoice);
                //kasirFormData.append('invoice', invoice);
                kasirFormData.append('keterangan', keterangan);
                kasirFormData.append('id', id);
                kasirFormData.append('start', $('[name=start]').val());
                kasirFormData.append('end', $('[name=end]').val());

                $.ajax({
                        url: '<?php echo site_url("kasir/update/"); ?>' + id,
                        type: 'POST',
                        contentType: false,
                        processData: false,
                        data: kasirFormData,
                        success: function(res) {
                            console.log('success', res);
                            var obj = JSON.parse(res);

                            alert('Update data sukses');
                            $('#i-no_invoice').html('');
                            $('#i-keterangan').val('');
                            $('#i-id').val('');
                            $('#imagePreview').val('');
                            $('#i-invoice').attr('src', '');
                            //cropper.destroy();

                            document.location = obj.redirect;
                        }
                    })
                    .done(function(data) {


                    })
                    .fail(function() {
                        console.log("error");
                    })
                    .always(function() {
                        console.log("complete");
                    });
            });



            $(document).ready(function() {



            })
            // </Kasir> 

            // <AdminInvoice>

            $('#js-add-invoice').click(function(e) {

                e.preventDefault();

                var btn = $(this);

                btn.html('Loading...');

                var invoice = $('#i-invoice')[0].files[0];
                var noInvoice = $('#i-no_invoice').val();
                var stock = $('#i-stock').val();
                //var keterangan = $('#i-keterangan').val();
                //var id = $('#i-id').val();
                var formData = new FormData();

                formData.append('no_invoice', noInvoice);
                formData.append('invoice', invoice);
                formData.append('stock', stock);
                //formData.append('keterangan', keterangan);
                //formData.append('id', id);
                formData.append('start', $('[name=start]').val());
                formData.append('end', $('[name=end]').val());

                $.ajax({
                        url: '<?php echo site_url("invoice/add/"); ?>',
                        type: 'POST',
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(res) {

                            console.log('success', res);
                            var obj = JSON.parse(res);

                            switch (obj.code) {
                                case 200:


                                    alert('Simpan data sukses');

                                    $('#i-no_invoice').html('');
                                    $('#i-keterangan').val('');
                                    $('#i-id').val('');
                                    $('#imagePreview').val('');
                                    $('#i-invoice').attr('src', '');

                                    //cropper.destroy();
                                    btn.html('Submit');

                                    document.location = obj.redirect;




                                    break;

                                case 400:

                                    alert(obj.message);

                                    btn.html('Submit');

                                    break;

                            }



                        }
                    })
                    .done(function(data) {


                    })
                    .fail(function() {
                        console.log("error");
                    })
                    .always(function() {
                        console.log("complete");
                    });
            })

            $('#js-update-invoice').click(function(e) {

                e.preventDefault();

                var btn = $(this);

                btn.html('Loading...');

                var invoice = $('#i-invoice')[0].files[0];
                var noInvoice = $('#i-no_invoice').val();
                //var keterangan    = $('#i-keterangan').val();
                var id = $('#i-id').val();
                var stock = $('#i-stock').val();
                var oldInvoice = $('#i-old_invoice').val();
                var formData = new FormData();

                console.log('no invoice', noInvoice);

                formData.append('no_invoice', noInvoice);
                formData.append('invoice', invoice);
                formData.append('old_invoice', oldInvoice);
                formData.append('stock', stock);
                //formData.append('keterangan', keterangan);
                formData.append('id', id);
                formData.append('start', $('[name=start]').val());
                formData.append('end', $('[name=end]').val());
                console.log(formData);

                $.ajax({
                        url: '<?php echo site_url("invoice/update/"); ?>' + id,
                        type: 'POST',
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(res) {

                            console.log('success', res);
                            var obj = JSON.parse(res);

                            switch (obj.status) {

                                case 'failed':
                                    alert(obj.error)
                                    break;

                                case 'success':

                                    alert('Simpan data sukses');
                                    $('#i-no_invoice').html('');
                                    $('#i-keterangan').val('');
                                    $('#i-id').val('');
                                    $('#imagePreview').val('');
                                    $('#i-invoice').attr('src', '');
                                    btn.html('Submit');

                                    document.location = obj.redirect;
                                    break;

                            }

                        }
                    })
                    .done(function(data) {


                    })
                    .fail(function() {
                        console.log("error");
                    })
                    .always(function() {
                        console.log("complete");
                    });

            })

            // </AdminInvoice>
        </script>

        <script>
            $(".js-supplier").select2({
                width: '166px',
                placeholder: "All",
                allowClear: true // need to override the changed default
            });

            $(".js-sup").select2({
                width: '425px',
                placeholder: "Please Select One!",
                allowClear: true // need to override the changed default
            });

            $(".invoices").select2({
                width: '100%',
                placeholder: "Please Select One!",
                allowClear: true, // need to override the changed default,
                ajax: {
                    url: '<?php echo base_url('timeline/invoices'); ?>',
                    data: function(params) {
                        var query = {
                            s: params.term,
                        }
                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    },
                    processResults: function(data, params) {
                        let invoices = JSON.parse(data);
                        let results = [];
                        invoices.map((invoice, index) => {
                            results.push({
                                id: invoice.no_invoice,
                                text: invoice.no_invoice
                            })
                        });

                        console.log(results);

                        return {
                            results: results
                        };
                    }
                }
            });
        </script>
        <script>
            function deletepaket(controller, id) {
                swal({
                        title: "Anda Yakin?",
                        text: "Data Akan Dihapus Secara Permanen!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, delete it!",
                        closeOnConfirm: false
                    },
                    function() {
                        $.ajax({
                            url: "<?php echo base_url('paket/') ?>" + controller + "/" + id,
                            type: "post",
                            data: {
                                id: id
                            },
                            success: function() {
                                swal('Data Berhasil Di Hapus', ' ', 'success');
                                $("#delete" + id).fadeTo("slow", 0.7, function() {
                                    $(this).remove();
                                })

                            },
                            error: function() {
                                swal('data gagal di hapus', 'error');
                            }
                        });

                    });
            }

            function deleteuser(controller, id) {
                swal({
                        title: "Anda Yakin?",
                        text: "Data Akan Dihapus Secara Permanen!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, delete it!",
                        closeOnConfirm: false
                    },
                    function() {
                        $.ajax({
                            url: "<?php echo base_url('user/') ?>" + controller + "/" + id,
                            type: "post",
                            data: {
                                id: id
                            },
                            success: function() {
                                swal('Data Berhasil Di Hapus', ' ', 'success');
                                $("#delete" + id).fadeTo("slow", 0.7, function() {
                                    $(this).remove();
                                })

                            },
                            error: function() {
                                swal('data gagal di hapus', 'error');
                            }
                        });

                    });
            }
        </script>

        <script>
            $(document).ready(function() {

                $('.lazy').lazy();

                /* This is basic - uses default settings */

                $().fancybox({
                    'selector': '.single-image',
                    'type': 'image',
                    beforeShow: function() {
                        $(".fancybox-image").css({
                            // "width": 1280,
                            // "height": 720
                        });
                        this.width = 1280;
                        this.height = 720;
                    },
                    fitToView: false, // images won't be scaled to fit to browser's height
                    //'width' : 720,
                    //'height' : 1280,
                    'scrolling': 'no',
                    'autoSize': false,
                    helpers: {
                        overlay: {
                            locked: false,
                            css: {
                                'background': 'rgba(0, 0, 0, 0.8)'
                            }
                        }
                    }
                });

                function updateJamKerja(data) {

                    return $.ajax({
                        method: 'POST',
                        url: '<?php echo base_url('dashboard/updateJamKerja') ?>',
                        data: data
                    })

                }

                $('#js-update-jam-kerja').click(function(e) {
                    e.preventDefault();

                    let form = $(this).closest('form');
                    let data = form.serialize();

                    console.log(data);

                    updateJamKerja(data)
                        .then(() => {
                            alert('Berhasil memperbaharui');
                        });

                })

                function loadActiveUser() {


                    return $.ajax({
                        method: 'GET',
                        url: '<?php echo base_url('/dashboard/onlineUser') ?>'
                    })

                }


                let tableUserOnline = $('#table-user-online');

                if (tableUserOnline.length) {

                    setInterval(function() {


                        loadActiveUser()
                            .then((response) => tableUserOnline.html(response))
                            .catch(err => console.log(err));

                    }, 1 * 10000)
                }


                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {
                        let filterStatus = $('#filter-status').val();

                        if (filterStatus == 'Publish') {
                            return true;
                        } else if (filterStatus == 'Draft') {
                            return true;
                        } else {
                            return true;
                        }


                        return false;
                    }
                );
                var table = $('#simpletable').DataTable();

                // Event listener to the two range filtering inputs to redraw on input
                $('#filter-status').change(function() {
                    table.draw();
                });

            });

            // add file upload 
            let inputInvoiceTokopedia = document.querySelector("#input-invoice-tokopedia");
            let fpTokopedia = FilePond.create(inputInvoiceTokopedia, {
                server: {
                    url: '<?php echo base_url(''); ?>',
                    process: {
                        url: '/invoice/uploads',
                        method: 'POST',
                        ondata: (formData) => {
                            formData.append('invoice_store', 'tokopedia');
                            return formData;
                        }
                    }
                }
            });

            let inputInvoiceShopee = document.querySelector("#input-invoice-shopee");
            let fpShopee = FilePond.create(inputInvoiceShopee, {
                server: {
                    url: '<?php echo base_url(''); ?>',
                    process: {
                        url: '/invoice/uploads',
                        method: 'POST',
                        ondata: (formData) => {
                            formData.append('invoice_store', 'shopee');
                            return formData;
                        }
                    }
                }
            });

            let inputInvoiceLazada = document.querySelector("#input-invoice-lazada");
            let fpLazada = FilePond.create(inputInvoiceLazada, {
                server: {
                    url: '<?php echo base_url(''); ?>',
                    process: {
                        url: '/invoice/uploads',
                        method: 'POST',
                        ondata: (formData) => {
                            formData.append('invoice_store', 'lazada');
                            return formData;
                        }
                    }
                }
            });


            // let inputInvoiceTiktok = document.querySelector("#input-invoice-tiktok");
            // let fpTiktok = FilePond.create(inputInvoiceTiktok, {
            //     server: {
            //         url: '<?php echo base_url(''); ?>',
            //         process: {
            //             url: '/invoice/uploads',
            //             method: 'POST',
            //             ondata: (formData) => {
            //                 formData.append('invoice_store', 'tiktok');
            //                 return formData;
            //             }
            //         }
            //     }
            // });

            setInterval(function() {
                $.ajax({
                    url: "<?= base_url('auth/last_aktive'); ?>",
                    success: function(data) {
                        // console.log(data)
                    }
                })
            }, 60000)

            $('.dataTable').DataTable();

            getDataUser();

            function getDataUser() {
                setInterval(function() {
                    getDataUserOnline();
                    getDataUserOffline();
                }, 30000);
            }

            function getDataUserOnline() {
                $.ajax({
                    url: "<?= base_url('dashboard/getUserOnline'); ?>",
                    type: 'POST',
                    async: true,
                    dataType: 'json',
                    success: function(data) {
                        var html = '';
                        var count = 1;
                        var i;
                        for (i = 0; i < data.length; i++) {
                            html += '<tr>' +
                                '<td>' + count++ + '</td>' +
                                '<td>' + data[i].username + '</td>' +
                                '<td>' + data[i].last_aktive + '</td>' +
                                '</tr>';
                        }
                        $('.listUserOnline').html(html);
                    }
                })
            }

            function getDataUserOffline() {
                $.ajax({
                    url: "<?= base_url('dashboard/getUserOffline'); ?>",
                    type: 'POST',
                    async: true,
                    dataType: 'json',
                    success: function(data) {
                        var html = '';
                        var count = 1;
                        var i;
                        for (i = 0; i < data.length; i++) {
                            html += '<tr>' +
                                '<td>' + count++ + '</td>' +
                                '<td>' + data[i].username + '</td>' +
                                '<td>' + data[i].last_aktive + '</td>' +
                                '</tr>';
                        }
                        $('.listUserOffline').html(html);
                    }
                })
            }

            $('#btnListHistoryPaket').click(function() {
                let no_invoice = $(this).data('no_invoice');
                $('#no_invoice').html(no_invoice);
                $.ajax({
                    url: "<?= base_url('timeline/history/'); ?>" + no_invoice,
                    async: true,
                    method: 'POST',
                    dataType: 'json',
                    success: function(data) {
                        // console.log(data);
                        var html = '';
                        var count = 1;
                        var i;
                        for (i = 0; i < data.length; i++) {
                            html += '<tr>' +
                                '<td>' + count++ + '</td>' +
                                '<td>' + data[i].username + '</td>' +
                                '<td>' + data[i].keterangan + '</td>' +
                                '<td>' + data[i].tgl_input + '</td>' +
                                '</tr>';
                        }
                        $('.listHistoriTimeline').html(html);
                    }
                });
            });

            Webcam.set({
                width: 320,
                height: 240,
                image_format: 'jpg',
                jpeg_quality: 100
            });
            Webcam.attach('#camera');

            function ambilGambar() {
                Webcam.snap(function(data_uri) {
                    document.getElementById('canva').innerHTML = '<img src="' + data_uri + '"/>';
                });
            }
        </script>
        </body>

        </html>