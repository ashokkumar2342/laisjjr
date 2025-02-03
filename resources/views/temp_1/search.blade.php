@php
    $include_page_extends = 'temp_1.include.main';
    $include_page_section = 'temp_1.include.main.container';
@endphp

@extends($include_page_extends)
@section($include_page_section)
<div class="section-space accent-bg">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-8 col-sm-12">
                <form action="{{ route('template.search.result') }}" method="post" class="add_form" no-reset="true" success-content-id="result_table_id">
                    {{csrf_field()}}
                    <div class="profile-details tab-content">
                        <div class="tab-pane tab-item animated fadeIn show active" id="menu-1" role="tabpanel" aria-labelledby="menu-1-tab">
                            <h3 class="title-section title-bar-high mb-40">Personal Information</h3>
                            <div class="personal-info">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label class="control-label">First Name</label>
                                        <input class="form-control" id="first-name" type="text">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="control-label">First Name</label>
                                        <input class="form-control" id="first-name" type="text">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="control-label">First Name</label>
                                        <input class="form-control" id="first-name" type="text">
                                    </div>
                                    <div class="form-group col-md-12 text-center" style="margin-top: 10px;">
                                        <button class="view-all-accent-btn disabled col-md-9" type="submit" value="Search">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-8 col-sm-12">                
                <div class="profile-details tab-content">
                    <h3 class="title-section title-bar-high mb-40">Orders</h3>
                    <div class="orders-info">
                        <div class="table-responsive">
                            <table class="table table-bordered table-responsive">
                                <thead>
                                    <tr>
                                        <th>Order</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="result_table_id">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection