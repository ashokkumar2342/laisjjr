@extends('admin.layout.base')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Award Statement</h3>
            </div>
        </div> 
    </div>
    <div class="card card-info">
        <div class="card-body">
            <form  class="add_form" method="post" action="{{ route('admin.report.result') }}" success-content-id="result_div_id" no-reset="true" data-table-new-without-pagination="example1"> 
            {{ csrf_field() }} 
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Report Type</label>
                            <span class="fa fa-asterisk"></span>
                            <select name="report_type" class="form-control select2" select2="true"required>
                                <option value="{{ Crypt::encrypt(0) }}" disabled selected>Select Report</option>
                               {{--  @foreach ($reportTypes as $reportType)
                                    <option value="{{ Crypt::encrypt($reportType->report_id) }}">{{ $reportType->name }}</option>
                                @endforeach --}}
                            </select>
                        </div>                               
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <input type="submit" class="form-control btn btn-primary" style="margin-top: 30px;" value="Show">
                        </div>                               
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <a type="button" target="_blank" href="{{ route('admin.report.print') }}" class="form-control btn btn-warning" style="margin-top: 30px;">Print</a>
                        </div>                               
                    </div>  
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


