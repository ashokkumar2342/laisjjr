<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" id="btn_close" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body"> 
            <div class="box-body"> 
                <div class="col-lg-12">
                    <fieldset class="fieldset_border">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="ajax_data_table_2">
                                <thead style="background-color: #6c757d;color: #fff">
                                    <tr>
                                        <th>Sr. No.</th>                
                                        <th>Name (E)</th>
                                        <th>Name (H)</th>
                                        <th>Hissa</th>
                                        <th>Value</th>
                                        <th>Award Detail File</th>
                                        <th>Page No.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sr_no = 1;
                                    @endphp
                                    @foreach($rs_beneficiary as $value)
                                    <tr>
                                        <td>{{ $sr_no++ }}</td>
                                        <td>{{$value->name_complete_e}}</td>
                                        <td>{{$value->name_complete_l}}</td>
                                        <td>{{$value->hissa_numerator}}/{{$value->hissa_denominator}}</td>
                                        <td>{{$value->value_txt}}</td>
                                        <td>{{$value->file_description}}</td>
                                        <td>{{$value->page_no}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer card-footer justify-content-between">
                    <button type="button" class="btn btn-danger form-control" data-dismiss="modal">Close</button>
                </div> 
            </div>
        </div>
    </div>
</div>


