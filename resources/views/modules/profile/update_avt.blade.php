<div class="modal fade" id="update-avt-modal" tabindex="-1"  aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cập nhật</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="update_avt_form" id="frm-cap-nhat-avt" data-parsley-validate="" novalidate>
                    @csrf
                    <div class="mb-3 needs-validation">
                        <input name="id" type="hidden" value="{{auth()->user()->id}}">
                        <div class="custom-file-container" data-upload-id="anhDaiDien">
                            <label>Ảnh đại diện <a href="javascript:void(0)" class="custom-file-container__image-clear"
                                    title="Clear Image">x</a></label>
                            <label class="custom-file-container__custom-file">
                            <input type="file" class="custom-file-container__custom-file__custom-file-input" name="image"
                                accept="image/*" value="{{ auth()->user()->avatar }}" >
                            <input type="hidden" name="old_image" value="{{ auth()->user()->avatar }}" />
                            <span class="custom-file-container__custom-file__custom-file-control"></span>
                            </label>
                            @if (!empty(auth()->user()->avatar))
                                <div class="custom-file-container__image-preview">

                                </div>
                            @else
                                <div class="custom-file-container__image-preview"></div>
                            @endif
                        </div>
                    </div>
                    <div class="d-lg-flex justify-content-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button id="btn-update-avt-modal" type="button" class="btn btn-primary ml-3">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<link href="{{ asset('assets/css/custom-admin-page.css') }}" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://unpkg.com/file-upload-with-preview@4.1.0/dist/file-upload-with-preview.min.css"/>
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="https://unpkg.com/file-upload-with-preview@4.1.0/dist/file-upload-with-preview.min.js"></script>
<script>
    var fileImages = [];
        @if(!empty(auth()->user()->avatar))
        var firstUpload = new FileUploadWithPreview("anhDaiDien", {
            text: {
                chooseFile: "Chọn ảnh đại diện...",
                browse: "Chọn ảnh",
                //selectedCount: "Custom Files Selected Copy",
            },
            images: {
                baseImage: '{{ $user->avatar }}',
            },
           
        })
        @else 
        var firstUpload = new FileUploadWithPreview("anhDaiDien", {
            text: {
                chooseFile: "Chọn ảnh đại diện...",
                browse: "Chọn ảnh",
                //selectedCount: "Custom Files Selected Copy",
            }, 
        })
        @endif
        window.addEventListener('fileUploadWithPreview:imagesAdded', function (e) {
            if (e.detail.uploadId === 'anhDaiDien') {
                fileImages = e.detail.cachedFileArray
            }
        })
        window.addEventListener('fileUploadWithPreview:imageDeleted', function (e) {
            if (e.detail.uploadId === 'anhDaiDien') {
                fileImages= e.detail.cachedFileArray;
            } 
        })
</script>
<script>
    $('#btn-update-avt-modal').click(function() {
        if($('#update-avt-modal').parsley().validate()) {
            var formData = new FormData();
                $("input[name='id']").map(function(){ formData.append('id', this.value)}).get();
                fileImages.map(function(file){ formData.append('avatar', file)})
                $.ajax({
                    url: "{{ route('profile.update_avt') }}",
                    type: 'POST',
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                }).done(function(res) {
                    if (res.status == 'success') {
                        swal.fire({
                            title: res.message,
                            icon: 'success',
                            showCancelButton: false,
                            showConfirmButton: false,
                            position: 'center',
                            padding: '2em',
                            timer: 1500,
                        }).then((result) => {
                            if (result.dismiss === Swal.DismissReason.timer) {
                                    window.location.replace(res.redirect)
                                }
                            })
                    } else {
                        Swal.fire({
                            title: res.message,
                            icon: res.status,
                            showCancelButton: false,
                            showConfirmButton: false,
                            position: 'center',
                            padding: '2em',
                            timer: 1500,
                        })
                    }
                });
            }
        });
</script>