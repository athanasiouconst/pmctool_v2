<?php $this->load->view('header/header'); ?>
<?php $this->load->view('menu/menu'); ?>
<body>

    <!-- Navigation end -->





    <!-- Users Section-->

    <section class="users-section section-padding" id="users">
        <div class="container-fluid">

            <h2 class="section-title text-center">Edit a User</h2>

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

                        <?php echo form_open('User/EditUser') ?>  
                        <?php if (count($edit) > 0) : ?>
                            <?php foreach ($edit as $edit): ?>
                        <table class="table " style="width: 100%; alignment-adjust: auto; text-align:  left; font-size:16px; font-family: sans-serif;">
                                <p><input type="hidden" size="80" id="users_id" name="users_id" value="<?= $edit['users_id'] ?>"/>    

                            <?php if (isset($gens)): ?>
                                <?php foreach ($gen as $gen): ?>
                                    <p><input type="hidden" size="80" id="users_id" name="users_id" value="<?php echo $gen->users_id; ?>"/>
                                    <?php endforeach; ?>
                                <?php endif; ?> 
                            <tr>
                                <td >
                                    <span title="User's Name">
                                        <input class="table table-responsive" style="color:#000; border: 0px;" type="text" name="first_name" id="first_name" placeholder="User's Name" value="<?= $edit['first_name'] ?>"  />
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span title="User's LastName">
                                        <input class="table table-responsive" style="color:#000; border: 0px;" type="text" name="last_name" id="last_name" placeholder="User's LastName" value="<?= $edit['last_name'] ?>"  />
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span title="Email">
                                        <input class="table table-responsive" style="color:#000; border: 0px;" type="text" name="email" id="email" placeholder="Email" value="<?= $edit['email'] ?>"  />
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span title="Username">
                                        <input class="table table-responsive" style="color:#000; border: 0px;" type="text" name="username" id="username" placeholder="Username" value="<?= $edit['username'] ?>"  />
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span title="Password">
                                        <input class="table table-responsive" style="color:#000; border: 0px;" type="password" name="password" id="password" placeholder="Password" value="<?= $edit['password'] ?>"  />
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span title="Recover Password Phrase">
                                        <input class="table table-responsive" style="color:#000; border: 0px;" type="text" name="choosenWord" id="choosenWord" placeholder="Recover Password Phrase" value="<?= $edit['choosenWord'] ?>"  />
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span title="User's Group">
                                        <label for="User's Group"></label>
                                        <select name='user_group_id' id='user_group_id' >
                                            <?php if (isset($gensGroup)): ?>
                                                <?php foreach ($genGroup as $gen): ?>
                                                    <option value="<?php echo $gen->user_group_id; ?>">
                                                        <?php echo $gen->user_group_name; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </span>
                                </td>
                            </tr>
                            
                            <?php endforeach; ?>
                        </table>
                        <div class="btn btn-danger">
                            <?php echo form_submit('submit', 'Edit User'); ?>
                            <?php echo form_close() ?>
                        </div> 
                        <?php else: ?>
                            <a href="javascript:history.go(-1)" class="btn btn-danger">go to the User's Form</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Projects Section -->


    <?php $this->load->view('menu/pmctoolPreloader'); ?>

<?php $this->load->view('content/content'); ?>
<?php $this->load->view('prefooter/prefooter'); ?>
<?php $this->load->view('footer/pmctoolFooter'); ?>