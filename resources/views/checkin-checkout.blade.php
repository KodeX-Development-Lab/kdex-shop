<!DOCTYPE html>
<html class="h-100" lang="en">
    {{-- <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate('Make me into an QrCode!')) !!} ">
    <input type="text" name="mycode" id="pincode-input1"> --}}
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Goody</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/favicon.png">
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"> -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/pincode.css') }}">

</head>

<body class="">
     <div class="row" class=""  style=" margin-top : 100px">
        <div class="col-md-4 offset-md-4">
            <div class="card">
                <div class="card-body">
                   <div class="text-center">
                    <div class="">
                        <h4>QR Code</h4>
                        <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(400)->generate($scan)) !!} ">
                        <h5 class=" text-muted">Please scan Qr to checkin checkout</h5>
                    </div>
                    <hr>
                   </div>
                   <div class=" text-center my-3">
                    <h4>Pin Code</h4>
                    <input type="text" name="mycode" id="pincode-input1">
                    <h5 class=" text-muted mt-3">Please enter pin code to checkin checkout</h5>
                   </div>
                </div>
            </div>
        </div>
     </div>
    <!--Scripts-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="{{ asset('js/pincode.js') }}"></script>
</body>
<script>
    $(document).ready(function() {
        $('#pincode-input1').pincodeInput({
            inputs: 6,
            complete: function(value, e, errorElement) {
                console.log("code entered: " + value);
                $.ajax({
                    url: `checkInOut/${value}`,
                    type: 'GET',
                    success: function(res) {
                        if (res.status == 404) {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: res.msg,
                            });
                        }
                        if (res.status == 200) {
                            Swal.fire({
                                title: "Good job!",
                                text: res.msg,
                                icon: "success"
                            });
                        }
                        $('.pincode-input-container .pincode-input-text').val('')
                        $('.pincode-input-text', this._container).first().select().focus();
                    }
                });
            }
        });

    })
</script>

</html>
