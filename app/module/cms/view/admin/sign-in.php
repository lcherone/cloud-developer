<div class="row">
    <div class="col-lg-12">
        <!--<h1 class="page-header">-->
        <!--    Admin <small> - Authorised users only.</small>-->
        <!--</h1>-->
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Please sign in</h3>
            </div>
            <div class="panel-body">
                <form method="post" action="">
                    <input type="hidden" name="csrf" value="<?= $csrf ?>">

                    <?php if (!empty($form['errors']['global'])): ?>
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <?= $form['errors']['global'] ?>
                    </div>
                    <?php endif ?>
                    <fieldset>
                        <div class="form-group<?= (!empty($form['errors']['username']) ? ' has-error has-feedback' : '') ?>">
                            <input class="form-control" value="<?= (!empty($form['values']['username']) ? htmlentities($form['values']['username']) : '') ?>" placeholder="Enter username..." name="username" type="text" autofocus="">
                            <?php if (!empty($form['errors']['username'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                            <?php if (!empty($form['errors']['username'])): ?><span class="help-block"><?= $form['errors']['username'] ?></span><?php endif ?>
                        </div>
                        <div class="form-group<?= (!empty($form['errors']['password']) ? ' has-error has-feedback' : '') ?>">
                            <input class="form-control" placeholder="Enter password..." name="password" type="password">
                            <?php if (!empty($form['errors']['password'])): ?><span class="glyphicon glyphicon-warning-sign form-control-feedback"></span><?php endif ?>
                            <?php if (!empty($form['errors']['password'])): ?><span class="help-block"><?= $form['errors']['password'] ?></span><?php endif ?>
                        </div>

                        <button type="submit" class="btn btn-sm btn-success">Sign In</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4"></div>
</div>
