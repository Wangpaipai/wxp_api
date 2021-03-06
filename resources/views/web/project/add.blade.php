
    <style>
        body {
            background-color: #ffffff;
        }

        table a{
            margin-top: 10px;
        }
    </style>
    <div class="container" style="max-width: 100%">

        <!-- /.row -->
        <div class="row">

            <form id="js_addProjectForm" role="form" method="post">

                <input type="hidden" class="form-control" v-model="create.id" value="">

                <div class="form-group">
                    <label for="recipient-name" class="control-label">项目名称:</label>
                    <input type="text" maxlength="30" class="form-control" v-model="create.name" value="" placeholder="必填">
                </div>

                <div class="form-group">
                    <label for="message-text" class="control-label">项目描述:</label>
                    <textarea class="form-control" v-model="create.brief" placeholder="必填"></textarea>
                </div>

                <div class="form-group">
                    <label for="recipient-name" class="control-label">环境域名:</label>
                    <div class="table-responsive table-bordered">
                        <table class="table">
                            <tbody>
                                <tr v-for="(item,index) in create.param">
                                    <td style="width:20%"><input class="form-control" v-model="item.name" placeholder="必填，标识符" value="formal"></td>
                                    <td style="width:20%"><input class="form-control" v-model="item.title" placeholder="必填，名称"></td>
                                    <td style="width:50%"><input class="form-control" v-model="item.url" placeholder="必填，环境域名，带http、https协议"></td>
                                    <td style="width:10%">
                                        <a href="javascript:void(0);" @click="createParam" class="fa fa-plus js_addEnvBtn" data-title="添加环境"></a>
                                        <a href="javascript:void(0);" @click="removeParam" :data-index="index" class="fa fa-trash-o js_deleteEnvBtn" data-title="删除环境"></a>
                                    </td>
                                </tr>

                                {{--<tr>--}}
                                    {{--<td style="width:20%"><input class="form-control" placeholder="必填，标识符" value="test"></td>--}}
                                    {{--<td style="width:20%"><input class="form-control" placeholder="必填，备注"></td>--}}
                                    {{--<td style="width:50%"><input class="form-control" placeholder="必填，环境域名，包含协议"></td>--}}
                                    {{--<td style="width:10%">--}}
                                        {{--<a href="javascript:void(0);" class="fa fa-plus js_addEnvBtn" data-title="新增环境"></a>--}}
                                        {{--<a href="javascript:void(0);" class="fa fa-trash-o js_deleteEnvBtn" data-title="删除环境"></a>--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="form-group">
                    <label for="recipient-name" class="control-label">是否允许被搜索到:
                        <a data-toggle="tooltip" data-placement="right" title="如果设为不允许搜索，那么其他人无法通过搜索项目搜索到该项目" class="btn-show-tips">
                            <i class="fa fa-info-circle"></i>
                        </a>
                    </label>
                    <div class="form-group">
                        <label class="radio-inline">
                            <input type="radio" v-model="create.is_show" name="is_show" value="1"> 允许
                        </label>
                        <label class="radio-inline">
                            <input type="radio" v-model="create.is_show" name="is_show" value="0"> 禁止
                        </label>
                    </div>
                </div>
            </form>
        </div>
    </div>
