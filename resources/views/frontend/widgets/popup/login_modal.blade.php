<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="card p-5">
                <form method="POST" id="login" action="{{ route('login') }}" data-parsley-validate="">
                    @csrf
                    <h5>@translate(Log In Your Account)</h5>
                    <div class="form-group">
                        <input class="form-control" id="email" type="email"
                               name="email" placeholder="@translate(Email address)" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" id="password" name="password" placeholder="@translate(Password)"
                               required>
                    </div>
                    <span class="text-danger py-2 font-weight-bold fs-16 text-center message d-none"
                          role="alert"></span>
                    <div class="form-group">
                        <div class="ps-checkbox">
                            <input class="form-control" type="checkbox" id="remember-me" name="remember">
                            <label for="remember-me">@translate(Rememeber me)</label>
                        </div>
                    </div>
                    <div class="form-group submtit">
                        <button class="ps-btn ps-btn--fullwidth submit" onclick="loginModal()" type="button">
                            @translate(Login)
                        </button>
                    </div>

                </form>
                <a href="{{ route('password.request') }}">@translate(Forgot)?</a>

                <p>@translate(Connect with):</p>
                <ul class="ps-list--social text-center p-2">
                    <li class=""><a class="facebook " href="{{ url('/auth/redirect/facebook') }}"><i class="fa fa-facebook"></i></a></li>
                    <li class=""><a class="google " href="{{ url('/auth/redirect/google') }}"><i
                                class="fa fa-google-plus"></i></a></li>
                   
                </ul>
            </div>
        </div>
    </div>
</div>


<script>
    "use strict"

    /*login modal*/
    function loginModal() {

        var email = $('#email').val();
        var password = $('#password').val();
        $.ajax({
            url: '{{route('credential.check')}}',
            method: 'GET',
            data: {email: email, password: password},
            success: function (result) {
                if (result.ok == false) {
                    $('#email').addClass('is-invalid');
                    $('#password').addClass('is-invalid');
                    $('.message').removeClass('d-none');
                    $('.message').text(result.message);
                } else {
                    $('#email').removeClass('is-invalid');
                    $('#password').removeClass('is-invalid');
                    $('.message').addClass('d-none');
                    $('#login').submit();
                }
            }
        })
    }

</script>



