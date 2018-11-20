
<style>
    .container {
        min-height: 200px;
    }
</style>
<div class="container" style="max-width: 100%">
    <!-- /.row -->
    <div class="row">
        <form id="js_addModuleForm" role="form" method="get">

            <div class="form-group">
                <label class="control-label">模块名称:</label>
                <input type="text" v-model="model.name" class="form-control" value="" placeholder="必填，不大于8位" maxlength="8">
            </div>

            {{--<div class="form-group">--}}
                {{--<label class="control-label">模块描述:</label>--}}
                {{--<textarea class="form-control" placeholder="必填" datatype="*1-250" name="intro"></textarea>--}}
            {{--</div>--}}

        </form>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
