<?php $this->load->view('header/header'); ?>

<body>

    <!-- Heaser Area Start -->
    <header class="header-area">
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
                        <li><a class="page-scroll" href="<?php echo base_url('Models/ViewModels'); ?>">Models</a></li>
                        <li><a class="page-scroll" href="<?php echo base_url('ComplexityFactors/ViewComplexityFactors'); ?>">Complexity Factors</a></li>
                        <li class="active"><a class="page-scroll" href="<?php echo base_url('Metrics/ViewMetrics'); ?>">Metrics</a></li>
                        <li><a class="page-scroll" href="<?php echo base_url('EvaluationScale/ViewEvaluationScale'); ?>">Evaluation Scale</a></li>
                        <li>
                            <?php if ($is_authenticated): ?>
                                <?php $role; ?>
                                <?php if ($role == 1) { ?>
                                    <a href="<?php echo base_url('User/ViewUsers'); ?>" >Admin </a>
                                <?php } ?>
                            <?php endif; ?>

                            <?php if ($this->session->userdata('userIsLoggedIn')) { ?>
                                <a href="<?php echo base_url('User/Logout'); ?>" >Logout </a>
                            <?php } else { ?>
                                <a class="page-scroll" href="<?php echo base_url('User'); ?>">Login</a>
                            <?php } ?>

                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- Navigation end -->






    <!-- Metrics Section-->

    <section class="metrics-section section-padding" id="metrics">
        <div class="container-fluid">

            <h2 class="section-title text-center">Assign Evaluation Scale to Metrics</h2>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 text-center ">

                    <div class="align-left">

                        <!--  FORM -->
                        <?php if (isset($error)) : ?>
                            <div class="alert alert-danger" >
                                <strong><?= $error ?></strong>
                                <strong><?php echo validation_errors(); ?></strong>
                            </div>                    
                        <?php endif; ?>

                        <?php echo form_open('Metrics/ViewMetricsAssignEvaluationScaleEditSubmitForm') ?>  
                        <table class="table " style="width: 100%; alignment-adjust: auto; text-align:  left; font-size:16px; font-family: sans-serif;">

                            <?php if (isset($gMetric)): ?>
                                <?php foreach ($genMetric as $genMetrics): ?>
                                    <p><input type="hidden" size="80" id="metric_evsc_id" name="metric_evsc_id" value="<?php echo $genMetrics->metric_evsc_id; ?>"/>
                                    <?php endforeach; ?>
                                <?php endif; ?>   

                            <tr>
                                <td>
                                    <span title="Metric">
                                        <label for="Metric"></label>
                                        <select name='metric_id' id='metric_id' >

                                            <?php if (isset($gMetric)): ?>
                                                <?php foreach ($genMetric as $genMetric): ?>
                                                    <option value="<?php echo $genMetric->metric_id; ?>">
                                                        <?php echo $genMetric->metric_name; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </span>
                                </td>
                            </tr>
                            <tr><td>Selected Evaluation Scale (before update) :</td></tr>
                            <tr>
                                <td>
                                    <span title="Evaluation Scale">
                                        <label for="Evaluation Scale"></label>
                                        <select  >
                                            <?php if (isset($gEvaluationScale)): ?>
                                                <?php foreach ($genEvaluationScale as $genEvaluationScale): ?>
                                                    <option value="<?php echo $genEvaluationScale->evsc_id; ?>">
                                                        <?php echo $genEvaluationScale->evsc_name; ?> - <?php echo $genEvaluationScale->evsc_type; ?> - <?php echo $genEvaluationScale->evsc_description; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </span>
                                </td>
                            </tr>
                            <tr><td>New Evaluation Scale :</td></tr>
                            <tr>
                                <td>
                                    <span title="Evaluation Scale">
                                        <label for="Evaluation Scale"></label>
                                        <select name='evsc_id' id='evsc_id' >

                                            <?php if (isset($gEvaluationScaleAll)): ?>
                                                <?php foreach ($genEvaluationScaleAll as $genEvaluationScaleAll): ?>
                                                    <option value="<?php echo $genEvaluationScaleAll->evsc_id; ?>">
                                                        <?php echo $genEvaluationScaleAll->evsc_name; ?> - <?php echo $genEvaluationScaleAll->evsc_type; ?> - <?php echo $genEvaluationScaleAll->evsc_description; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </span>
                                </td>
                            </tr>
                        </table>
                        <div class="btn btn-danger">
                            <?php echo form_submit('submit', 'Submit Assignment'); ?>
                            <?php echo form_close() ?>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Metrics Section -->


    <?php $this->load->view('menu/pmctoolPreloader'); ?>

    <?php $this->load->view('content/content'); ?>
    <?php $this->load->view('prefooter/prefooter'); ?>
    <?php $this->load->view('footer/pmctoolFooter'); ?>