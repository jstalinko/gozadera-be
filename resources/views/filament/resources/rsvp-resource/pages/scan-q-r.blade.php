<x-filament-panels::page>

    <video id="previewKamera" style="width:100%;height:autoo;"></video>
    <br>
    <div id="alert"></div>
    <div id="results">

    <select id="pilihKamera" style="width:100%;color:white;background:black;border:1px solid #fff;border-radius:4px;">
    </select>
    <br>
   
    </div>

    @push('styles')
    <style>
        .alert {
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

    </style>
    @endpush
    
    @push('scripts')
        <script type="text/javascript" src="https://unpkg.com/@zxing/library@latest"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

        <script>
            let selectedDeviceId = null;
            const codeReader = new ZXing.BrowserMultiFormatReader();
            const sourceSelect = $("#pilihKamera");

            $(document).on('change', '#pilihKamera', function() {
                selectedDeviceId = $(this).val();
                if (codeReader) {
                    codeReader.reset()
                    initScanner()
                }
            })

            function initScanner() {
                codeReader
                    .listVideoInputDevices()
                    .then(videoInputDevices => {
                        videoInputDevices.forEach(device =>
                            console.log(`${device.label}, ${device.deviceId}`)
                        );

                        if (videoInputDevices.length > 0) {

                            if (selectedDeviceId == null) {
                                if (videoInputDevices.length > 1) {
                                    selectedDeviceId = videoInputDevices[1].deviceId
                                } else {
                                    selectedDeviceId = videoInputDevices[0].deviceId
                                }
                            }


                            if (videoInputDevices.length >= 1) {
                                sourceSelect.html('');
                                videoInputDevices.forEach((element) => {
                                    const sourceOption = document.createElement('option')
                                    sourceOption.text = element.label
                                    sourceOption.value = element.deviceId
                                    if (element.deviceId == selectedDeviceId) {
                                        sourceOption.selected = 'selected';
                                    }
                                    sourceSelect.append(sourceOption)
                                })

                            }

                            codeReader
                                .decodeOnceFromVideoDevice(selectedDeviceId, 'previewKamera')
                                .then(result => {

                                    //hasil scan
                                    console.log(result.text)
                                    var alert = $('#alert');    
                                    var results = $('#results');
                                    var memberId = atob(result.text);
                                    fetch('/api/scanqr/'+memberId)
                                        .then(response => response.json())
                                        .then(data => {
                                            console.log(data)
                                            if (data.status == 'success') {
                                                alert.html('<div class="alert alert-success" role="alert">Scan QR Code Success</div>');
                                                results.html('<div class="alert alert-success" role="alert">'+data.message+'</div>');
                                            } else {
                                                alert.html('<div class="alert alert-danger" role="alert">Scan QR Code Failed</div>');
                                                results.html('<div class="alert alert-danger" role="alert">'+data.message+'</div>');
                                            
                                            }
                                        })
                                        .catch(err => console.error(err));
 

                                    if (codeReader) {
                                        codeReader.reset();
                                        setTimeout(() => {
                                            window.location.reload();
                                        }, 10000);
                                    
                                    }
                                })
                                .catch(err => console.error(err));

                        } else {
                            alert("Camera not found!")
                        }
                    })
                    .catch(err => console.error(err));
            }


            if (navigator.mediaDevices) {


                initScanner()


            } else {
                alert('Cannot access camera.');
            }
        </script>
    @endpush
</x-filament-panels::page>
