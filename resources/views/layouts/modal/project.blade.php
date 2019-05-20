<!-- Modal project-->
<div id="project_data" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="glyphicon glyphicon-edit"></i> @{{ update  ? 'Update project' : 'Add New project'}}</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" name="pointForm" >
                    <div class="form-group" ng-class="{'has-error' : errors.name[0] }" >
                        <label for="name" class="col-sm-2 control-label">Name project</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Enter a name project" ng-model="project.name">
                            <span class="help-block" style="color: #b94a48;" ng-show="errors.name[0]" ng-bind="errors.name[0].toString()"></span>
                        </div>
                    </div>
                    
                    <div class="form-group" ng-class="{'has-error' : errors.infomation[0] }" >
                        <label for="infomation" class="col-sm-2 control-label">Infomation</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" ng-model="project.infomation"></textarea>
                            <span class="help-block" style="color: #b94a48;" ng-show="errors.infomation[0]" ng-bind="errors.infomation[0].toString()"></span>
                        </div>
                    </div>

                    <div class="form-group" ng-class="{'has-error' : errors.deadline[0] }" >
                        <label for="deadline" class="col-sm-2 control-label">Deadline</label>
                        <div class="col-sm-10">
                            <input type=text date-picker 
                                placeholder='MM/DD/YYYY' 
                                maxlength="10" 
                                ng-required='true'
                                class='form-control' 
                                ng-model='project.deadline'>
                            <span class="help-block" style="color: #b94a48;" ng-show="errors.deadline[0]" ng-bind="errors.deadline[0].toString()"></span>
                        </div>
                    </div>

                    <div class="form-group" ng-class="{'has-error' : errors.type[0] }" >
                        <label for="type" class="col-sm-2 control-label">Type</label>
                        <div class="col-sm-10">
                            <select name="method_payment" id="type"  class="form-control" ng-model="project.type">
                                <option value="">Please choose type</option>
                                <option value="lab">lab</option>
                                <option value="single">single</option>
                                <option value="acceptance">acceptance</option>
                            </select>
                            <span class="help-block" style="color: #b94a48;" ng-show="errors.type[0]" ng-bind="errors.type[0].toString()"></span>
                        </div>
                    </div>

                    <div class="form-group" ng-class="{'has-error' : errors.status[0] }" >
                        <label for="status" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-10">
                            <select name="method_payment" id="status"  class="form-control" ng-model="project.status">
                                <option value="">Please choose status</option>
                                <option value="planned">planned</option>
                                <option value="onhold">onhold</option>
                                <option value="doing">doing</option>
                                <option value="done">done</option>
                                <option value="cancelled">cancelled</option>
                            </select>
                            <span class="help-block" style="color: #b94a48;" ng-show="errors.status[0]" ng-bind="errors.status[0].toString()"></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" ng-click="actionProject();">@{{ update  ? 'Update' : 'Add New'}}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal add member for project -->
<div id="addMemberProject" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="glyphicon glyphicon-edit"></i>Add Member</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" name="pointForm" >
                    <div class="form-group" ng-class="{'has-error' : errors.member[0] }" >
                        <label for="member" class="col-sm-2 control-label">Member</label>
                        <div class="col-sm-10">
                            <select name="method_payment" id="member"  class="form-control" ng-model="addRole.member">
                                <option value="">Please choose member</option>
                                <option ng-repeat="item in listmember" value="@{{item.id}}">@{{item.name}}</option>
                            </select>
                            <span class="help-block" style="color: #b94a48;" ng-show="errors.member[0]" ng-bind="errors.member[0].toString()"></span>
                        </div>
                    </div>

                    <div class="form-group" ng-class="{'has-error' : errors.role[0] }" >
                        <label for="role" class="col-sm-2 control-label">Role</label>
                        <div class="col-sm-10">
                            <select name="method_payment" id="role"  class="form-control" ng-model="addRole.role">
                                <option value="">Please choose role</option>
                                <option value="DEV">DEV</option>
                                <option value="PL">PL</option>
                                <option value="PM">PM</option>
                                <option value="PO">PO</option>
                                <option value="SM">SM</option>
                            </select>
                            <span class="help-block" style="color: #b94a48;" ng-show="errors.role[0]" ng-bind="errors.role[0].toString()"></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" ng-click="addMemberProject();">Add</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal detail member of project -->
<div id="detailProject" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Detail member of project</h4>
            </div>
            <div class="modal-body">
                <table class="table table-hover">
                    <thead>
                        <tr ng-show="listMemberOfProject.length">
                            <th>ID</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="item in listMemberOfProject" ng-show="listMemberOfProject.length">
                            <td ng-bind="item.member.id"></td>
                            <td ng-bind="item.member.name"></td>
                            <td ng-bind="item.member.position"></td>
                            <td ng-bind="item.role"></td>
                            <td>
                                <button class="btn btn-xs btn-primary" ng-click="openUpdateRole(item.id, item.role)">
                                    <i class="glyphicon glyphicon-edit"></i>
                                </button>
                                <button class="btn btn-xs btn-danger" ng-click="deleteUserRole(item.id)">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <div ng-show="!listMemberOfProject.length">
                            <p class="text-center">
                                No data !              
                            </p>
                    </div>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<!-- Modal add member for project -->
<div id="updateMemberProject" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title btn-md"><i class="glyphicon glyphicon-edit"></i> Update Role</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" name="pointForm" >

                    <div class="form-group" ng-class="{'has-error' : errors.role[0] }" >
                        <label for="role" class="col-sm-2 control-label">Role</label>
                        <div class="col-sm-10">
                            <select name="method_payment" id="role"  class="form-control" ng-model="updateRole.role">
                                <option value="">Please choose role</option>
                                <option value="DEV">DEV</option>
                                <option value="PL">PL</option>
                                <option value="PM">PM</option>
                                <option value="PO">PO</option>
                                <option value="SM">SM</option>
                            </select>
                            <span class="help-block" style="color: #b94a48;" ng-show="errors.role[0]" ng-bind="errors.role[0].toString()"></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" ng-click="updateUserRole();">Update</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>