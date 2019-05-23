<!-- Member modal -->
<div id="member" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="glyphicon glyphicon-edit"></i> @{{ update  ? 'Update' : 'Add New'}}</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" name="pointForm" enctype="multipart/form-data">
                    <div class="form-group" ng-class="{'has-error' : errors.name[0] }" >
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Enter a name" ng-model="member.name">
                            <span class="help-block" style="color: #b94a48;" ng-show="errors.name[0]" ng-bind="errors.name[0].toString()"></span>
                        </div>
                    </div>
                    
                    <div class="form-group" ng-class="{'has-error' : errors.infomation[0] }" >
                        <label for="infomation" class="col-sm-2 control-label">Infomation</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" ng-model="member.infomation"></textarea>
                            <span class="help-block" style="color: #b94a48;" ng-show="errors.infomation[0]" ng-bind="errors.infomation[0].toString()"></span>
                        </div>
                    </div>

                    <div class="form-group" ng-class="{'has-error' : errors.avatar[0] }" >
                        <label for="avatar" class="col-sm-2 control-label">Avatar</label>
                        <div class="col-sm-10">
                            <input type="file" ng-files="setTheFiles($files)" id="avatar" name="avatar" class="form-control">
                            <span class="help-block" style="color: #b94a48;" ng-show="errors.avatar[0]" ng-bind="errors.avatar[0].toString()"></span>
                        </div>
                        <div class="col-sm-12 col-md-offset-2" ng-if="member.avatar != null ">
                            <img ng-src="{{ url('avatars') }}/@{{member.avatar}}" width="100">
                        </div>
                    </div>

                    <div class="form-group" ng-class="{'has-error' : errors.phone[0] }" >
                        <label for="phone" class="col-sm-2 control-label">Phone</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Enter a phone" ng-model="member.phone">
                            <span class="help-block" style="color: #b94a48;" ng-show="errors.phone[0]" ng-bind="errors.phone[0].toString()"></span>
                        </div>
                    </div>

                    <div class="form-group" ng-class="{'has-error' : errors.date_of_birth[0] }" >
                        <label for="date_of_birth" class="col-sm-2 control-label">Data of Birth</label>
                        <div class="col-sm-10">
                            <input type='text' date-picker
                                placeholder='DD-MM-YYYY' 
                                maxlength="10" 
                                ng-required='true'
                                data-language="en"
                                data-date-format="dd-mm-yyyy"
                                class="datepicker-here form-control"
                                ng-model='member.date_of_birth'
                                data-position="right top">
                            <span class="help-block" style="color: #b94a48;" ng-show="errors.date_of_birth[0]" ng-bind="errors.date_of_birth[0].toString()"></span>
                        </div>
                    </div>

                    <div class="form-group" ng-class="{'has-error' : errors.position[0] }" >
                        <label for="position" class="col-sm-2 control-label">Positon</label>
                        <div class="col-sm-10">
                            <select name="method_payment" id="position"  class="form-control" ng-model="member.position">
                                <option value="">Please choose positon</option>
                                <option value="intern">Intern</option>
                                <option value="junior">Junior</option>
                                <option value="senior">Senior</option>
                                <option value="pm">PM</option>
                                <option value="ceo">CEO</option>
                                <option value="cto">CTO</option>
                                <option value="bo">BO</option>
                            </select>
                            <span class="help-block" style="color: #b94a48;" ng-show="errors.position[0]" ng-bind="errors.position[0].toString()"></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" ng-click="actionMember();">@{{ update  ? 'Update' : 'Add New'}}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>