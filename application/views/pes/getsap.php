
<!DOCTYPE html>
<html lang="en">
<aside class="right-side">
    <body class="skin-silver pace-done skin-blue">
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="grid no-border">
                                <div class="grid-header">
                                    <i class="fa fa-table"></i>
                                    <span class="grid-title">Basic DataTables</span>
                                    <div class="pull-right grid-tools">
                                        <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                                        <a data-widget="reload" title="Reload"><i class="fa fa-refresh"></i></a>
                                        <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                                    </div>
                                </div>
                                <div class="grid-body">
                                    <table id="dataTables1" class="table table-hover display" cellspacing="0" width="100%">
                                       <?php echo $this->table->generate();?>

                                    </table>
                                </div>
                            </div>
                        </div>
                </section>
            </aside>

    </body>

</html>