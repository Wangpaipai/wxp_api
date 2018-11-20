

<div class="container" style="max-width: 100%">
    <!-- /.row -->
    <div class="row">
        <form id="js_addApiForm" role="form" method="post">
            <div class="form-group">
                <label>所属模块</label>
                <input class="form-control" v-model="apiCreateData.model_name" value="" placeholder="必填" disabled>
            </div>

            <div class="form-group">
                <label>接口名称</label>
                <input class="form-control" v-model="apiCreateData.title" value="" placeholder="必填">
            </div>

            <div class="form-group">
                <label class="control-label">请求类型</label>
                <div class="form-group">
                    <label class="radio-inline">
                        <input type="radio" v-model="apiCreateData.method" value="GET"> GET
                    </label>
                    <label class="radio-inline">
                        <input type="radio" v-model="apiCreateData.method" value="POST"> POST
                    </label>
                    <label class="radio-inline">
                        <input type="radio" v-model="apiCreateData.method" value="PUT"> PUT
                    </label>
                    <label class="radio-inline">
                        <input type="radio" v-model="apiCreateData.method" value="DELETE"> DELETE
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label>接口路径</label>
                <input class="form-control" v-model="apiCreateData.url" placeholder="必填，不包含域名部分">
            </div>


            <div class="form-group">
                <label>接口描述</label>
                <textarea class="form-control" v-model="apiCreateData.brief" placeholder="非必填"></textarea>
                <span class="Validform_checktip"></span>
            </div>

        </form>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#wrapper -->
