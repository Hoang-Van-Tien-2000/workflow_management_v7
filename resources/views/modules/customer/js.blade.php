<script>
    $('#btn-submit-form').click(function() {
        if ($('#frm-them-moi').parsley().validate()) {
            var formData = new FormData();
            $("input[name='code']").map(function() {
                formData.append('code', this.value)
            }).get();
            $("input[name='name']").map(function() {
                formData.append('name', this.value)
            }).get();
            $("input[name='phone']").map(function() {
                formData.append('phone', this.value)
            }).get();
            $("input[name='email']").map(function() {
                formData.append('email', this.value)
            }).get();
            $("input[name='birthday']").map(function() {
                formData.append('birthday', this.value)
            }).get();
            $("input[name='phone']").map(function() {
                formData.append('phone', this.value)
            }).get();
            $("input[name='address']").map(function() {
                formData.append('address', this.value)
            }).get();
            $("input[name='address']").map(function() {
                formData.append('address', this.value)
            }).get();
            $.ajax({
                url: "{{ route('customer.store') }}",
                type: 'POST',
                data: formData,
                cache: false,
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
                        icon: 'error',
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
