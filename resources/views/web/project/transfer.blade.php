<div class="container" style="max-width:100%">

    <!-- /.row -->
    <div class="row">
        <form id="js_transferProjectForm" role="form">
            <div class="alert alert-dismissable alert-warning">
                <i class="fa fa-fw fa-info-circle"></i>
                只能转让给项目成员，转让后与该项目不再有任何关系，如果要加入需要重新申请，请谨慎操作!
            </div>

            <div class="form-group">
                <label class="control-label">转让项目:</label>
                <input type="text" class="form-control" v-model="give.name" value="" placeholder="必填" readonly>
            </div>

            <div class="form-group">
                <label class="control-label">登录密码:</label>
                <input type="password" class="form-control" v-model="give.password" name="password" value="" placeholder="重要操作，请输入登录密码">
            </div>

            <div class="form-group">
                <label class="control-label">转让给:</label>
                <select class="form-control" v-model="give.uid">
                    <option value="0" selected>请选择成员</option>
                    <option v-for="item in member" :value="item.id">@{{ item.name }}</option>
                </select>

            </div>

        </form>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>