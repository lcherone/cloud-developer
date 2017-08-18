<div class="row">
    <div class="col-lg-12">
        <!--<h1 class="page-header">-->
        <!--    Settings-->
        <!--</h1>-->
        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><i class="fa fa-cogs"></i> Settings</li>
        </ol>
    </div>
</div>

<?php if (!empty($form['errors']['global'])): ?>
<div class="alert alert-danger">
    <a href="#" class="close" data-dismiss="alert">&times;</a>
    <?= $form['errors']['global'] ?>
</div>
<?php endif ?>
<?php if (!empty($form['errors']['success'])): ?>
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <?= $form['errors']['success'] ?>
    </div>
<?php endif ?>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-search fa-fw"></i> Search</h3>
            </div>
            <div class="panel-body nopadding">
                <div class="table-responsive">
                    <table class="table table-condensed table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th style="width:1%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ((array) $results as $type => $result): ?>
                            <?php foreach ($result as $row): ?>
                            <tr>
                                <td><?= $row->title ?></td>
                                <td><?= ucfirst($type) ?></td>
                                <td><button type="button" class="btn btn-xs btn-primary show-code" data-id="<?= $row->id ?>"><i class="fa fa-eye"></i> Show Code</button></td>
                            </tr>
                            <tr class="hidden" id="code-<?= $row->id ?>">
                                <td colspan="3" class="nopadding" style="padding:0px">
                                    <textarea class="editor" data-id="<?= $row->id ?>" data-term="<?= $f3->get('GET.term') ?>" id="editor-<?= $row->id ?>"><?= $row->body ?></textarea>
                                </td>
                            </tr>
                            <?php endforeach ?>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ob_start() ?>
<script>
    $(document).ready(function() {

        $('.show-code').on('click', function() {
            var btn   = $(this);
            var id    = btn.data('id');
            var panel = $('#code-'+id);
         
            if (panel.hasClass('hidden')) {
                btn.html('<i class="fa fa-eye-slash"></i> Hide Code');
                panel.removeClass('hidden');
            } else {
                btn.html('<i class="fa fa-eye"></i> Show Code');
                panel.addClass('hidden');
            }
        });
        
        $('textarea.editor').each(function () {
            //
            var textarea = $(this),
                editor = ace.edit("editor-"+textarea.data('id')),
                editorSession = editor.getSession();
    
            editor.setTheme("ace/theme/eclipse");
            editor.setOptions({
                minLines: 1,
                maxLines: Infinity
            });
            editorSession.setUseWorker(false);
            editorSession.setMode("ace/mode/php");

            editor.findAll(new RegExp(textarea.data('term').replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&")),{
                caseSensitive: false,
                regExp: true
            });
        });

    });
</script>
<?php $f3->set('javascript', $f3->get('javascript').ob_get_clean()) ?>
