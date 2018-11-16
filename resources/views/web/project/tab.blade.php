
<ul class="nav nav-tabs">
    <li class="{{ active('web.project.api.home') }}"><a href="{{ route('web.project.api.home',['id' => $project->id]) }}">项目主页</a></li>
    <li class="{{ active('web.project.api.group') }}"><a href="{{ route('web.project.api.group',['id' => $project->id]) }}">项目成员</a></li>
</ul>