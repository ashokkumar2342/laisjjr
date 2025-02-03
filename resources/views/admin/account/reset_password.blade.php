@extends('admin.layout.base')
@section('body')
@php
    Session::put('CryptoRandom',App\Helper\MyFuncs::generateId());
    Session::put('CryptoRandomInfo',App\Helper\MyFuncs::generateRandomIV());
@endphp
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Reset Password</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right"> 
                </ol>
            </div>
        </div> 
        <div class="card card-info"> 
            <div class="card-body">
                <form action="{{ route('admin.account.reset.password.change') }}" method="post" class="add_form" no-reset="" onsubmit="return hashPasswordEncryption();" autocomplete="off">
                    {{ csrf_field()}}
                    <div class="form-body overflow-hide">
                        <div class="form-group">
                            <label class="control-label mb-10">Email</label>
                            <span class="fa fa-asterisk"></span>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <select name="email" class="form-control form-group select2" required>
                                    <option value="">Select Email</option>
                                    @foreach ($admins as $admin)
                                        <option value="{{ Crypt::encrypt($admin->id) }}">{{ $admin->email }}</option> 
                                    @endforeach
                                </select>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="control-label mb-10" for="exampleInputpwd_01">New Password</label>
                            <span class="fa fa-asterisk"></span>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" name="new_pass" id="new_pass" class="form-control" placeholder="Enter New Password" required="">
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="control-label mb-10" for="exampleInputpwd_01">Confirm password</label>
                            <span class="fa fa-asterisk"></span>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" name="con_pass" id="con_pass" class="form-control" placeholder="Enter Confirm Password" required="">
                            </div>
                        </div>
                    </div>
                    <div class="form-actions mt-10">            
                        <button type="submit" class="btn btn-success mr-10 mb-30">Reset Password</button>
                    </div>              
                </form>
            </div> 
        </div>
    </div><!-- /.container-fluid -->
</section>
@endsection 
@push('scripts')
<script src={!! asset('admin_asset/dist/js/crypto-js.min.js?ver=') !!}{{date('Y-m-d')}}></script>
<script>
    function hashPasswordEncryption(){
        var new_pass = jQuery("#new_pass").val();
        var con_pass = jQuery("#con_pass").val();
        
        var Cryptoksduid = '<?php echo Session::get('CryptoRandom');?>';
        var Cryptoikeywords = '<?php echo Session::get('CryptoRandomInfo');?>';
        var Cryptokfydsdyg = CryptoJS.enc.Utf8.parse(Cryptoksduid);
        
        var encrypted = CryptoJS.DES.encrypt(new_pass,
        Cryptokfydsdyg, {
            mode: CryptoJS.mode.CBC,
            padding: CryptoJS.pad.Pkcs7,
            iv: CryptoJS.enc.Utf8.parse(Cryptoikeywords)
        });

        var hexstr = encrypted.ciphertext.toString();
        jQuery("#new_pass").val(hexstr);

        var encrypted = CryptoJS.DES.encrypt(con_pass,
        Cryptokfydsdyg, {
            mode: CryptoJS.mode.CBC,
            padding: CryptoJS.pad.Pkcs7,
            iv: CryptoJS.enc.Utf8.parse(Cryptoikeywords)
        });

        var hexstr = encrypted.ciphertext.toString();
        jQuery("#con_pass").val(hexstr);
    }
</script>

@endpush 


