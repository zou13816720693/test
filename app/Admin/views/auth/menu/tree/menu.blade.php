<div class="box">

    <div class="box-header">

        <div class="btn-group">
            <a class="btn btn-primary btn-sm {{ $id }}-tree-tools" data-action="expand">
                <i class="fa fa-plus-square-o"></i>&nbsp;展开
            </a>
            <a class="btn btn-primary btn-sm {{ $id }}-tree-tools" data-action="collapse">
                <i class="fa fa-minus-square-o"></i>&nbsp;收起
            </a>
        </div>

        <div class="btn-group">
            <a class="btn btn-info btn-sm  {{ $id }}-save"><i class="fa fa-save"></i>&nbsp;保存</a>
        </div>

    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
        <div class="dd" id="{{ $id }}">
            <ol class="dd-list">
                @each($branchView, $items, 'branch')
            </ol>
        </div>
    </div>
    <!-- /.box-body -->
</div>
