<div class="col-md-2 col-md-offset-1" >
    <div class="panel panel-default">
        <div class="panel-collapse collapse in">
            <ul class="nav nav-pills nav-stacked">
                <li role="presentation" {!! setActive('admin/moderator') !!}><a href="{{ route('admin.moderator.index') }}">Moderiranje oglasa</a></li>
                <li role="presentation" {!! setActive('admin/users') !!}><a href="{{ route('admin.users.index') }}">Korisnici</a></li>
                <li role="presentation" {!! setActive('admin/report') !!}><a href="{{ route('admin.report.index') }}">Izvješća</a></li>
                <li role="presentation" {!! setActive('admin/analytics') !!}><a href="{{ route('admin.analytics.index') }}">Statistike</a></li>
            </ul>
        </div>
    </div>
</div>