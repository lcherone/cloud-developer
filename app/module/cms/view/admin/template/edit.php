<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Templates <small> - Edit</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="/admin/template"><i class="fa fa-columns"></i> Templates</a></li>
            <li class="active"><i class="fa fa-pencil"></i> Edit</li>
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

<form class="form-horizontal" method="post">
    <input type="hidden" name="csrf" value="<?= $csrf ?>">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-columns fa-fw"></i> Template Details</h3>
                </div>
                <div class="panel-body nopadding">
                    <table class="table table-condensed form-table">
                        <tbody>
                            <tr class="form-group<?= (!empty($form['errors']['name']) ? ' has-error has-feedback' : '') ?>">
                                <td class="text-right col-md-2"><label for="input-name" class="control-label">Name</label></td>
                                <td>
                                    <div class="input-group col-xs-10">
                                        <input type="text" class="form-control" id="input-name" name="name" value="<?= (!empty($form['values']['name']) ? htmlentities($form['values']['name']) : '') ?>" placeholder="Enter template name... e.g: Default">
                                    </div>
                                    <?php if (!empty($form['errors']['name'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                                    <?php if (!empty($form['errors']['name'])): ?><span class="help-block"><?= $form['errors']['name'] ?></span><?php endif ?>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="form-group">
                                <td class="text-right"></td>
                                <td>
                                    <div class="input-group col-xs-10">
                                        <button type="submit" class="btn btn-primary save-details">Save</button>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-eye fa-fw"></i> Preview <small>- Links are disabled!</small></h3>
                </div>
                <div class="panel-body nopadding" style="height:350px">
                    <div class="embed-responsive embed-responsive-16by9" style="height:350px">
                        <iframe class="embed-responsive-item" id="template-preview" src="/admin/template/preview/<?= $f3->get('PARAMS.sub_action_id') ?>?html" style="height:350px" height="350px"></iframe>
                    </div>
                    <!--<img src="/admin/template/preview/<?= $f3->get('PARAMS.sub_action_id') ?>" alt="" class="img-responsive" style="margin: 0 auto;">-->
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-files-o" aria-hidden="true"></i> Files</h3>

                    <div class="panel-buttons text-right" style="height:22px">
                        <div class="btn-group-xs">
                            <a href="#" role="button" class="btn btn-link btn-xs label-btn hidden" id="file-saved" aria-disabled="true"><span class="text-success">File saved!</span></a>
                            <?php $snippets = $getsnippets('template'); if (!empty($snippets)): ?>
                            <a href="#" role="button" class="btn btn-link btn-xs label-btn" aria-disabled="true">Snippets:</a>
                            <?php foreach ($snippets as $row): if ($row->type != 'template') { continue; } ?>
                            <button type="button" data-id="<?= $row->id ?>" data-type="<?= $row->type ?>" class="btn btn-xs btn-default fetch-snippet"><?= $row->title ?></button>
                            <?php endforeach ?>
                            <?php endif ?>
                            <button type="button" class="btn btn-success save-file" data-file="template.php"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                        </div>
                    </div>
                </div>
                <div class="panel-body nopadding">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-2 nopadding">
                        <div class="row" style="padding:5px;background:#f5f5f5;margin-left:0px;margin-right:0px">
                            <div class="col-xs-12 col-sm-3 nopadding">
                                <button type="button" class="btn btn-xs btn-danger remove-file hidden"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                            </div>
                            <div class="col-xs-12 col-sm-9 nopadding text-right">
                                <form class="form-inline" style="margin-right:-20px">
                                    <div class="input-group">
                                        <input type="text" class="form-control input-xs" id="new-file-name" value="" placeholder="Enter filename.ext&hellip;" >
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-xs btn-success new-file"><i class="fa fa-file" aria-hidden="true"></i> New File</button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div id="fileList" style="width:100%"></div>
                        <form action="/admin/template/upload-file/<?= $f3->get('PARAMS.sub_action_id') ?>" class="dropzone" role="form"></form>
                    </div>
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-10 nopadding">
                        <textarea class="form-control form-textarea" rows="10" id="input-source" name="source"><?= (!empty($form['values']['source']) ? $form['values']['source'] : '') ?></textarea>
                        <div id="source" style="position:relative;min-height:750px;width:100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form> 

<?php ob_start() ?>
<?php
$db = new \Framework\Model('servers');

$server =  $db->findOne('id = ?', [1]);

try {
    $error = [];
    $tasks = new Plinker\Core\Client(
        $server->endpoint,
        'Tasks\Manager',
        hash('sha256', gmdate('h').$server->public_key),
        hash('sha256', gmdate('h').$server->private_key),
        json_decode($server->config, true),
        $server->encrypted // enable encryption [default: true]
    );
    $files = $tasks->files('/var/www/html/tmp/template/'.(int) $f3->get('PARAMS.sub_action_id'));
} catch (\Exception $e) {
    $files = '{}';
}
?>
<script src="https://ajaxorg.github.io/ace-builds/src-min-noconflict/ace.js"></script>
<script src="/js/filebrowser.js"></script>
<script>
    $(function(){
    /**
     * Module - nodes
     * 
     * @usage:  load.script('/js/module/template.js', function(){});
     */
        /*global $, load, ace*/
        var template = (function() {

            var init = function(options) {

                Dropzone.autoDiscover = false;
                var myDropzone = new Dropzone("form.dropzone", { url: "/admin/template/upload-file/<?= $f3->get('PARAMS.sub_action_id') ?>"});

                var textarea = $('textarea[name="source"]').hide();
                var editor = ace.edit("source");
                editor.getSession().setUseWorker(false);
                editor.setTheme("ace/theme/eclipse");
                editor.setOptions({
                    minLines: 20,
                    maxLines: Infinity
                });
                editor.getSession().setMode("ace/mode/php");

                var whichForm = 'save-details';
                editor.getSession().setValue(textarea.val());
                editor.getSession().on('change', function() {
                    whichForm = 'save-file';
                    textarea.val(editor.getSession().getValue());
                });

                //if (options.files.length > 0) {
                    $("#fileList").fileBrowser({
                        json: options.files,
                        path: '/',
                        view: 'details',
                        select: false,
                        breadcrumbs: true,
                        onSelect: function(obj, file, folder, type) {
                            $('button.new-file').data('folder', folder);
                        },
                        onOpen: function(obj, file, folder, type) {
                            if (type == 'file') {
                                if (folder == '/') {
                                    folder = '';
                                }
    
                                $('.remove-file').removeClass('hidden').data('file', folder + '/' + file);
                                $('.save-file').removeClass('hidden').data('file', folder + '/' + file);
                                $('.new-file').data('file', folder + '/' + file);
    
                                $('.dropzone').addClass('hidden');
    
                                loadFile(folder + '/' + file);
                            }
                            else {
                                if (folder == '/') {
                                    folder = '';
                                }
    
                                myDropzone.options.url = '/admin/template/upload-file/<?= $f3->get('PARAMS.sub_action_id') ?>' + folder;
    
                                $('.dropzone').removeClass('hidden');
                                $('.remove-file').addClass('hidden');
                                $('.save-file').addClass('hidden');
                                $('button.new-file').data('folder', folder);
                            }
                            $('.fmBreadCrumbs li').first().html('/var/www/html');
                        }
                    });
                //}

                function loadFile(path) {
                    if (path.charAt(0) == "/") path = path.substr(1);

                    $.get('/admin/template/file/' + options.route_id + '/' + path,
                          function(data, status) {
                        textarea.val(data);
                        editor.getSession().setValue(data);
                        $("#select").html(data);
                    });
                }

                $("input[name='path']").on("change", function() {
                    var input = $(this);

                    $("#example1").fileBrowser("chgOption", {
                        path: input.val()
                    });
                    $("#example1").fileBrowser("redraw");
                });

                $('button.remove-file').on('click', function(e) {
                    e.preventDefault();
                    if (!$(this).data('file')) {
                        $(this).data('file', '');
                    }
                    $.get('/admin/template/file/' + options.route_id + $(this).data('file') + '?del=1',
                          function(data, status) {
                        window.location = '/admin/template/edit/' + options.route_id;
                    });
                });

                $('button.save-file').on('click', function(e) {
                    e.preventDefault();

                    var btn = $(this);

                    if (!btn.data('file')) {
                        btn.data('file', '');
                    }

                    var file = btn.data('file');

                    if (file.charAt(0) == "/") {
                        file = file.substr(1);
                    }

                    $.post('/admin/template/file/' + options.route_id + '/'+ file + '?save=1', { data: editor.getSession().getValue() },
                    function(data, status) {
                        $('#template-preview').attr("src", $('#template-preview').attr("src"));
                        $('#file-saved').hide().removeClass('hidden').fadeIn(300, function(){
                            var elm = $(this);
                            setTimeout(function(){ 
                                elm.fadeOut(1000, function(){
                                    elm.addClass('hidden');
                                });
                            }, 1700);
                        });
                    });
                });

                $('button.new-file').on('click', function(e) {
                    e.preventDefault();
                    if (!$(this).data('folder')) {
                        $(this).data('folder', '');
                    }
                    var new_file = $(this).data('folder') + '/' + $('#new-file-name').val();

                    $.get('/admin/template/file/' + options.route_id + new_file,
                          function(data, status) {
                        window.location = '/admin/template/edit/' + options.route_id;
                    });
                });

                $('.fmBreadCrumbs').first('li').html('/var/www/html');
                
                $(window).bind('keydown', function(event) {
                    if (event.ctrlKey || event.metaKey) {
                        switch (String.fromCharCode(event.which).toLowerCase()) {
                            case 's':
                                event.preventDefault();
                                $('.'+whichForm).trigger('click');
                            break;
                        }
                    }
                });
                
                $(document).on('click', '.fetch-snippet', function(){
                    var id = $(this).data('id');
                    var type = $(this).data('type');
                    $.ajax({
                        type: "GET",
                        url: '/admin/snippet/get/'+id,
                        dataType: "text",
                        success: function(data) {
                            if (type == 'template') {
                                editor.getSession().insert(editor.getCursorPosition(), data);
                            }
                        }
                    });
                });
            };
            
            return {
                init: init
            };
        })();

        template.init({
            route_id: '<?= (int) $f3->get('PARAMS.sub_action_id') ?>',
            files: <?= $files ?>
        });

    });
</script>
<?php $f3->set('javascript', $f3->get('javascript').ob_get_clean()) ?>
