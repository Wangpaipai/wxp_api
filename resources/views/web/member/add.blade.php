

<div class="container" style="max-width: 100%">

    <!-- /.row -->
    <div class="row">

        <form id="js_addMemberForm" role="form" method="post">

            <div class="alert alert-dismissable alert-warning">
                <i class="fa fa-fw fa-info-circle"></i>&nbsp;
                默认成员只能查看项目及项目接口,
                勾选编辑属性后，该成员可以编辑项目模块和接口,
                勾选删除属性后，该成员可以删除项目模块和接口.
            </div>

            <div class="form-group">
                <label>成员信息</label>
                <input type="hidden" v-model="roleData.id">
                <input type="text" v-if="is_create" v-model="roleData.name" class="form-control" value="">
                <input type="text" v-else readonly v-model="roleData.name" class="form-control" value="">
            </div>

            <div class="form-group">
                <label>项目权限</label>
                <label class="checkbox-inline">
                    <input checked type="checkbox" v-model="roleData.role_group" value="show">查看
                </label>
                <label class="checkbox-inline">
                    <input type="checkbox" v-model="roleData.role_group" value="give">转让
                </label>
                <label class="checkbox-inline">
                    <input type="checkbox" v-model="roleData.role_group" value="update">编辑
                </label>
                <label class="checkbox-inline">
                    <input type="checkbox" v-model="roleData.role_group" value="delete">删除
                </label>
            </div>

        </form>

        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
