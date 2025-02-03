<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Edit</h4>
            <button type="button" id="btn_close" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.account.user.update', Crypt::encrypt($accounts[0]->id)) }}" method="post" class="add_form" content-refresh="example" button-click="btn_close">
                {{ csrf_field() }}
                <div class="box-body">                    
                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <span class="fa fa-asterisk"></span>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input Name="name" class="form-control" value="{{ $accounts[0]->name }}"  maxlength="50" placeholder="Enter name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <span class="fa fa-asterisk"></span>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-chalkboard-teacher"></i></span>
                            </div>
                            <select class="form-control" name="role_id" required>
                                @foreach($roles as $role)
                                <option value="{{ Crypt::encrypt($role->id) }}" {{ $accounts[0]->role_id == $role->id?'selected' : '' }}>{{ $role->name }}</option>  
                                @endforeach 
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Mobile No.</label>
                        <span class="fa fa-asterisk"></span>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>
                            <input type="text" Name="mobile" class="form-control" maxlength="10" onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value="{{ $accounts[0]->mobile }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email ID</label>
                        <span class="fa fa-asterisk"></span>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="text" disabled name="email" class="form-control" value="{{ $accounts[0]->email }}" id="exampleInputEmail1" maxlength="50" placeholder="Enter email">
                        </div>
                    </div>
                </div>
                <div class="modal-footer card-footer justify-content-between">
                    <button type="submit" class="btn btn-success form-control">Update</button>
                    <button type="button" class="btn btn-danger form-control" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

