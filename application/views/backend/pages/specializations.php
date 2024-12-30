<style>
    .error{

        color:red;
    }
    #specializationdatatable{
        max-width: 98% !important;
    }
</style>


<input type="hidden" id="base_url" name="base_url" value="<?=  base_url() ?>" />

<!-- Highlighting rows and columns -->
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title"><?php echo $header_data['page_title'];?></h5>
        <div class="header-elements" id="exportbuttons">
            <div class="list-icons">
                <a  href="javascript:void(0);" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addSpecializationModal">Add</a>

                <a class="list-icons-item" data-action="collapse"></a>

                <a class="list-icons-item reload" data-action="reloadtable"></a>
            </div>
        </div>
    </div>
    <div class="table-responsive">
    <table class="table table-hover datatable-highlight" id="specializationdatatable">
        <thead>
        <tr>
            <th style="max-width: 100px">Id</th>
            <th>Name</th>
            <th style="max-width: 250px">Action</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    </div>
</div>
<!-- /highlighting rows and columns -->


<!-- The Modal -->
<div class="modal" id="addSpecializationModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add New Specialization</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="addspecialization">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" placeholder="Enter name" id="name" name="name" required />
                    </div>


                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="formspecialization">Add</button>
                    <a herf="javascript:void(0);" class="btn btn-danger" data-dismiss="modal" style="color:#fff;">close</a>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- The Modal -->
<div class="modal" id="editSpecializationsModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Update Specialization</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="updatespecialization">
                <input type="hidden" id="id" name="id" value="" />
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editName">Name:</label>
                        <input type="text" class="form-control" placeholder="Enter name" id="editName" name="editName" required />
                    </div>

                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="formUpdate">Update</button>
                    <a herf="javascript:void(0);" class="btn btn-danger" data-dismiss="modal" style="color:#fff;">close</a>
                </div>
            </form>
        </div>
    </div>
</div>
