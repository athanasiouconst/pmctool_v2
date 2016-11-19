<?php $this->load->view('header/header'); ?>

<body>

    <!-- Heaser Area Start -->
    <header class="header-area" style="position: fixed; width: 100%;">
        <!-- Navigation start -->
        <nav class="navbar navbar-custom tb-nav" role="navigation">
            <div class="container">        
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#tb-nav-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                <a class="navbar-brand logo" href="<?php echo base_url(); ?>"><h2>Project Management <br><span>Complexity </span>Tool</h2></a>
                </div>

                <div class="collapse navbar-collapse" id="tb-nav-collapse">

                    <ul class="nav navbar-nav navbar-right">
                        <li ><a class="page-scroll" href="<?php echo base_url('pmctool'); ?>">Home</a></li>
                        <li><a class="page-scroll" href="<?php echo base_url('Projects/ViewProjects'); ?>">Projects</a></li>
                        <li class="active"><a class="page-scroll" href="<?php echo base_url('Models/ViewModels'); ?>">Models</a></li>
                        <li><a class="page-scroll" href="<?php echo base_url('ComplexityFactors/ViewComplexityFactors'); ?>">Complexity Factors</a></li>
                        <li><a class="page-scroll" href="<?php echo base_url('Metrics/ViewMetrics'); ?>">Metrics</a></li>
                        <li><a class="page-scroll" href="<?php echo base_url('EvaluationScale/ViewEvaluationScale'); ?>">Evaluation Scale</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- Navigation end -->




<!-- Models Section-->

<section class="models-section section-padding" id="models">
    <div class="container-fluid">
        <h2 class="section-title text-center">Models</h2>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 text-center ">
                <div class="align-left">
                    <?php echo $this->session->flashdata('success_msg'); ?>
                    <?php echo $this->session->flashdata('delete_msg'); ?>
                    <?php echo $this->session->flashdata('edit_msg'); ?>

                    <div class="align-left">
                        <div  style="float: right;">
                            <a href="<?php echo base_url('Models/ViewModelsCreationForm'); ?>" class="btn btn-danger">Add Model</a>
                            <a href="<?php echo base_url('Models/ViewModelsAssignFactorCreationForm'); ?>" class="btn btn-danger">Assigning Complexity Factors to Models</a>

                            <br><br>
                        </div>
                        <?php if (isset($gens)): ?>
                            <?php if (count($gen) > 0) : ?>
                                <table class="table table-responsive table-active table-condensed" style="font-size:16px; font-family: sans-serif; 
                                       alignment-adjust: auto; text-align:  left;" >
                                    <tr class="alert-success">
                                        <?php foreach ($fields as $field_name => $field_display): ?>
                                            <td <?php if ($sort_by == $field_name) echo "class=\"sort_$sort_order\"" ?>>
                                                <?php echo $field_display; ?>
                                                <?php
                                                //echo anchor("Models/ViewModels/$field_name/" .
                                                //        ( ($sort_order == 'asc' && $sort_by == $field_name ) ? 'desc' : 'asc' ), $field_display);
                                                ?>
                                            </td>
                                        <?php endforeach; ?>
                                        <td></td>
                                    </tr>
                                    <?php foreach ($gen as $gen): ?>

                                        <tr>
                                            <?php foreach ($fields as $field_name => $field_display): ?>
                                                <td >
                                                    <?php echo $gen->$field_name; ?>
                                                </td>
                                            <?php endforeach; ?> 
                                            <td>
                                                <?php
                                                $model_cf_id = $gen->model_cf_id;
                                                $base_url = base_url();
                                                $assign = '<img alt=""' . $model_cf_id . '"" src="' . $base_url . 'img/messages/assignment.jpg" width="20" height="20">   ';
                                                $view = '<img alt=""' . $model_cf_id . '"" src="' . $base_url . 'img/messages/success.jpg" width="20" height="20">   ';
                                                $edit = '<img alt=""' . $model_cf_id . '"" src="' . $base_url . 'img/messages/edit.jpg" width="20" height="20">   ';
                                                $delete = '<img alt=""' . $model_cf_id . '"" src="' . $base_url . 'img/messages/delete.jpg" width="20" height="20">  ';
                                                ?>
                                                <?php
                                                //echo anchor("Models/ViewModelsAssignments/$mod_id", $assign, array('onClick' => "return confirm('Are you sure for viewing the assignments of this metric ?')"));
                                                ?>
                                                <?php
                                                echo anchor("Models/ViewModelsAssignmentsDetails/$model_cf_id", $view, array('onClick' => "return confirm('Are you sure for viewing this model ?')"));
                                                ?>
                                                <?php
                                                echo anchor("Models/ViewModelsAssignFactorEditForm/$model_cf_id", $edit, array('onClick' => "return confirm('Are you sure for editing this model ?')"));
                                                ?>
                                                <?php echo anchor("Models/ViewModelsAssignmentsDelete/$model_cf_id", $delete, array('onClick' => "return confirm('Are you sure for deleting this model?')")); ?>    
                                            </td>
                                        <?php endforeach; ?> 
                                    </tr>

                                <?php else : ?>
                                    <tr>
                                        <td>
                                            <div style="padding-left: 25px;"><i>There is no Data to Display !!</i></div>
                                        </td>
                                    </tr>
                                <?php endif ?>

                            </table>
                            <?php if (strlen($pagination)): ?>
                                <div class="pagination gradient" style="width: 100%; margin-top: -10px;">
                                    <div class="page gradient">
                                        &nbsp; <?php echo $pagination; ?> &nbsp;
                                    </div>
                                </div>                 
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
</section>
<!-- Models Section -->

<?php $this->load->view('menu/pmctoolPreloader'); ?>

<?php $this->load->view('footer/pmctoolFooter'); ?>