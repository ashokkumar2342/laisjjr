@extends('admin.layout.base')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Report</h3>
            </div>
        </div> 
    </div>
    <div class="card card-info">
        <div class="card-body">
            <form  class="add_form" method="post" action="{{ route('admin.report.result') }}" success-content-id="result_div_id" no-reset="true" data-table-new-without-pagination="example1"> 
            {{ csrf_field() }} 
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Report Type</label>
                            <span class="fa fa-asterisk"></span>
                            <select name="report_type" id="report_type" class="form-control select2" select2="true" onchange="callAjax(this,'{{ route('admin.report.formControl.show') }}','form_controls');callAjax(this,'{{ route('admin.common.blank.view') }}','result_div_id')" required>
                                <option value="{{ Crypt::encrypt(0) }}" disabled selected>Select Report</option>
                                @foreach ($reportTypes as $reportType)
                                    <option value="{{ Crypt::encrypt($reportType->report_id) }}">{{ $reportType->name }}</option>
                                @endforeach
                            </select>
                        </div>                               
                    </div> 
                </div>
                <div class="row" id="form_controls"> 
                        
                </div>
            </form> 
        </div>
    </div>
    <div class="card card-info">
        <div class="card-body">
            <div class="row" id="result_div_id"> 

            </div>    
        </div>
    </div> 
</section>
@endsection
@push('scripts')
<script>
    function print_1(val) {
        if(val == 1){
            $('#print_btn').attr("href",'{{route('admin.report.print','')}}'+'&report_type='+$('#report_type').val()+'&scheme='+$('#scheme_select_box').val()+'&scheme_award_info='+$('#scheme_award_select_box').val());
        }
        if(val == 2){
            $('#print_btn').attr("href",'{{route('admin.report.print','')}}'+'&report_type='+$('#report_type').val()+'&scheme='+$('#scheme_select_box').val()+'&scheme_award_info='+$('#scheme_award_select_box').val()+'&award_detail='+$('#award_detail_select_box').val());
        }
        
    }
</script>
@endpush


