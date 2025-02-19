@extends('admin.layout.base')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Award Land Details</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    
                </ol>
            </div>
        </div> 
    </div>
    <div class="card card-info">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 form-group">
                    <label for="exampleInputEmail1">Scheme/Award</label>
                    <span class="fa fa-asterisk"></span>
                    <select name="scheme" class="form-control select2" id="scheme_select_box" onchange="callAjax(this,'{{ route('admin.common.scheme.wise.schemeAwardInfo') }}','scheme_award_select_box')" required>
                        <option selected disabled>Select Scheme/Award</option>
                        @foreach ($rs_schemes as $val_rec)
                            <option value="{{ Crypt::encrypt($val_rec->opt_id) }}">{{ $val_rec->opt_text }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-6 form-group">
                    <label for="exampleInputEmail1">Scheme/Award Village</label>
                    <span class="fa fa-asterisk"></span>
                    <select name="scheme_award_info" class="form-control select2" id="scheme_award_select_box" data-table-new-without-pagination="ajax_data_table" onchange="callAjax(this,'{{ route('admin.master.award.detail.table') }}','result_table')" required>
                        <option selected disabled>Select Scheme/Award Village</option> 
                    </select>
                </div>
            </div>             
        </div>
    </div>
    <div class="card card-info">
        <div class="card-body">
            <div id="result_table"></div>
        </div>
    </div> 
</section>
@endsection
@push('scripts')
    <script>
        function getTranslatedata() {
            var name_e = $("#name_1_e").val(); 
            if ($("#name_1_l").val().length !=0) {

            }else{
                $.ajax({
                    dataType: "json",
                    url: "{{route('admin.common.getTranslateData')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "name_e": name_e
                    },
                    type: "GET",
                    success: function(data) {              
                        if(data.st==1){
                            var n = data.msg.split('|');
                            $("#name_1_l").val(n[0]);

                        } else if(data.st==0){
                            alert('ok');
                        }
                    }
                })
            }    
        }
    </script>
    <script>
        function getTranslatedata2() {
            var name_e = $("#name_2_e").val(); 
            if ($("#name_2_l").val().length !=0) {

            }else{
                $.ajax({
                    dataType: "json",
                    url: "{{route('admin.common.getTranslateData')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "name_e": name_e
                    },
                    type: "GET",
                    success: function(data) {              
                        if(data.st==1){
                            var n = data.msg.split('|');
                            $("#name_2_l").val(n[0]);

                        } else if(data.st==0){
                            alert('ok');
                        }
                    }
                })
            }    
        }
    </script>
    <script>
        function getTranslatedata3() {
            var name_e = $("#name_3_e").val(); 
            if ($("#name_3_l").val().length !=0) {

            }else{
                $.ajax({
                    dataType: "json",
                    url: "{{route('admin.common.getTranslateData')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "name_e": name_e
                    },
                    type: "GET",
                    success: function(data) {              
                        if(data.st==1){
                            var n = data.msg.split('|');
                            $("#name_3_l").val(n[0]);

                        } else if(data.st==0){
                            alert('ok');
                        }
                    }
                })
            }    
        }
    </script> 
    <script>
        function NameFill(val, id, fill_id) {
            if(fill_id == 1){
               $("#name_1_l").val(''); 
               $("#name_1_l").val(val); 
            }
            if(fill_id == 2){
               $("#name_2_l").val(''); 
               $("#name_2_l").val(val); 
            }
            if(fill_id == 3){
               $("#name_3_l").val(''); 
               $("#name_3_l").val(val); 
            }
            
            $("#btn_close_1").click();
            callAjax(this,'{{ route('admin.common.getTraDataPopUpdate') }}'+'?dic_id='+id);
        }
    </script>
@endpush

