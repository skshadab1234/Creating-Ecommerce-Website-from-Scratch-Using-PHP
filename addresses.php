<?php
    require 'includes/header.php';
    

    if(isset($_GET['controller']) && $_GET['controller'] == 'delete' && isset($_GET['id']) && $_GET['id'] > 0){
        $id = get_safe_value($_GET['id']);
        $DeleteSql = "delete from user_address where id = '$id'";
        mysqli_query($con, $DeleteSql);
        $redirect = get_safe_value($_GET['redirect']);
        redirect($redirect);
    }
?>

<section id="wrapper">

    <nav data-depth="3" class="breadcrumb">
        <div class="container">
            <ol itemscope="" itemtype="http://schema.org/BreadcrumbList" class="p-a-0">

                <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="<?= FRONT_SITE_PATH ?>">
                        <span itemprop="name">Home</span>
                    </a>
                    <meta itemprop="position" content="1">
                </li>


                <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="<?= FRONT_SITE_PATH.'identity' ?>">
                        <span itemprop="name">Your account</span>
                    </a>
                    <meta itemprop="position" content="2">
                </li>


                <li>
                    <span>Addresses</span>
                </li>

            </ol>
        </div>
    </nav>


    <div class="container">
        <div class="row">

            <div id="content-wrapper" class="col-lg-12 col-xs-12">

                <aside id="notifications">
                    <div class="container">

                    </div>
                </aside>
                <?php
                $addresss_data = FetchUserAddresssDetails($user['id']);
                if(isset($_GET['controller']) && $_GET['controller'] != ''){
                    $id = '';
                    $add_firstname = '';
                    $add_lastname = '';
                    $company = '';
                    $address = '';
                    $addres_complement = '';
                    $city = '';
                    $state = '';
                    $postal_code = '';
                    $country = '';
                    $phone_number = '';
                    $heading = 'New Address';    

                    if(isset($_GET['id']) && $_GET['id'] > 0) {
                        $id = get_safe_value($_GET['id']);
                        $sql = "SELECT * FROM `user_address` where id = '$id'";
                        $res = mysqli_query($con, $sql);
                        $row = mysqli_fetch_assoc($res);
                        $add_firstname = $row['add_firstname'];
                        $add_lastname = $row['add_lastname'];
                        $company = $row['company'];
                        $address = $row['address'];
                        $addres_complement = $row['addres_complement'];
                        $city = $row['city'];
                        $state = $row['state'];
                        $postal_code = $row['postal_code'];
                        $country = $row['country'];
                        $phone_number = $row['phone_number'];

                        $heading = 'Edit Address';

                    }

                    if(isset($_POST['submitAddress'])){
                        $redirect = get_safe_value($_GET['redirect']);
                        $add_firstname = get_safe_value($_POST['add_firstname']);
                        $add_lastname = get_safe_value($_POST['add_lastname']);
                        $company = get_safe_value($_POST['company']);
                        $address = get_safe_value($_POST['address']);
                        $addres_complement = get_safe_value($_POST['addres_complement']);
                        $city = get_safe_value($_POST['city']);
                        $state = get_safe_value($_POST['state']);
                        $postal_code = get_safe_value($_POST['postal_code']);
                        $country = get_safe_value($_POST['country']);
                        $phone_number = get_safe_value($_POST['phone_number']);


                        if($id > 0){
                            $updateData = "update user_address set add_firstname = '$add_firstname', add_lastname='$add_lastname', company='$company', address = '$address', addres_complement = '$addres_complement', city = '$city', state = '$state', postal_code = '$postal_code', country = '$country', phone_number = '$phone_number' where id = '$id'";
                            mysqli_query($con, $updateData);
                            
                        }else{
                            $uid = $user['id'];
                            $insertData = "INSERT into user_address (user_id,add_firstname,add_lastname,company,address,addres_complement,city,state,postal_code,country,phone_number,status) VALUES('$uid','$add_firstname','$add_lastname','$company','$address','$addres_complement','$city','$state','$postal_code','$country','$phone_number','1')";
                            mysqli_query($con, $insertData);
                            
                        }
                        redirect($redirect);
                        
                    }

                    ?>

                <!-- Address Edit or New Adding  -->
                <section id="main">
                    <header class="page-header">
                        <h1>
                            <?= $heading ?>
                        </h1>
                    </header>

                    <section id="content" class="page-content">
                        <div class="address-form">

                            <div class="js-address-form">

                                <form method="post" action="">
                                    <section class="form-fields">


                                        <div class="form-group row align-items-center ">
                                            <label class="col-md-2 col-form-label required">
                                                First name
                                            </label>
                                            <div class="col-md-8">

                                                <input class="form-control" name="add_firstname" type="text" value="<?= $add_firstname ?>"
                                                    maxlength="255" required="">

                                            </div>

                                            <div class="col-md-2 form-control-comment">

                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center ">
                                            <label class="col-md-2 col-form-label required">
                                                Last name
                                            </label>
                                            <div class="col-md-8">

                                                <input class="form-control" name="add_lastname" type="text" value="<?= $add_lastname ?>"
                                                    maxlength="255" required="">

                                            </div>

                                            <div class="col-md-2 form-control-comment">

                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center ">
                                            <label class="col-md-2 col-form-label">
                                                Company
                                            </label>
                                            <div class="col-md-8">

                                                <input class="form-control" name="company" type="text" value="<?= $company ?>"
                                                    maxlength="255">
                                            </div>

                                            <div class="col-md-2 form-control-comment">

                                                Optional

                                            </div>
                                        </div>


                                        <div class="form-group row align-items-center ">
                                            <label class="col-md-2 col-form-label required">
                                                Address
                                            </label>
                                            <div class="col-md-8">
                                                <input class="form-control" name="address" type="text" value="<?= $address ?>"
                                                    maxlength="128" required="">


                                            </div>

                                            <div class="col-md-2 form-control-comment">

                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center ">
                                            <label class="col-md-2 col-form-label">
                                                Address Complement
                                            </label>
                                            <div class="col-md-8">
                                                <input class="form-control" name="addres_complement" type="text" value="<?= $addres_complement ?>"
                                                    maxlength="128">

                                            </div>

                                            <div class="col-md-2 form-control-comment">

                                                Optional

                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center ">
                                            <label class="col-md-2 col-form-label required">
                                                City
                                            </label>
                                            <div class="col-md-8">

                                                <input class="form-control" name="city" type="text" value="<?= $city ?>"
                                                    maxlength="64" required="">

                                            </div>

                                            <div class="col-md-2 form-control-comment">

                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center ">
                                            <label class="col-md-2 col-form-label required">
                                                State
                                            </label>
                                            <div class="col-md-8">

                                                <div class="custom-select2">
                                                    <select class="form-control form-control-select" name="state"
                                                        required="">
                                                        <option value="" disabled='' selected>Select State</option>
                                                        <?php
                                                            $indian_all_states  = array (
                                                                'AP' => 'Andhra Pradesh',
                                                                'AR' => 'Arunachal Pradesh',
                                                                'AS' => 'Assam',
                                                                'BR' => 'Bihar',
                                                                'CT' => 'Chhattisgarh',
                                                                'GA' => 'Goa',
                                                                'GJ' => 'Gujarat',
                                                                'HR' => 'Haryana',
                                                                'HP' => 'Himachal Pradesh',
                                                                'JK' => 'Jammu & Kashmir',
                                                                'JH' => 'Jharkhand',
                                                                'KA' => 'Karnataka',
                                                                'KL' => 'Kerala',
                                                                'MP' => 'Madhya Pradesh',
                                                                'MH' => 'Maharashtra',
                                                                'MN' => 'Manipur',
                                                                'ML' => 'Meghalaya',
                                                                'MZ' => 'Mizoram',
                                                                'NL' => 'Nagaland',
                                                                'OR' => 'Odisha',
                                                                'PB' => 'Punjab',
                                                                'RJ' => 'Rajasthan',
                                                                'SK' => 'Sikkim',
                                                                'TN' => 'Tamil Nadu',
                                                                'TR' => 'Tripura',
                                                                'UK' => 'Uttarakhand',
                                                                'UP' => 'Uttar Pradesh',
                                                                'WB' => 'West Bengal',
                                                                'AN' => 'Andaman & Nicobar',
                                                                'CH' => 'Chandigarh',
                                                                'DN' => 'Dadra and Nagar Haveli',
                                                                'DD' => 'Daman & Diu',
                                                                'DL' => 'Delhi',
                                                                'LD' => 'Lakshadweep',
                                                                'PY' => 'Puducherry',
                                                            );

                                                            foreach ($indian_all_states as $key => $value) {
                                                                if($state == $value) {
                                                                    $checked = 'selected';
                                                                }else {
                                                                    $checked = '';
                                                                }
                                                                ?>
                                                                    <option value='<?= $value ?>' <?= $checked ?>><?= $value ?></option>       
                                                                <?php
                                                            }
                                        
                                                        ?>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="col-md-2 form-control-comment">

                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center ">
                                            <label class="col-md-2 col-form-label required">
                                                Zip/Postal Code
                                            </label>
                                            <div class="col-md-8">

                                                <input class="form-control" name="postal_code" type="text" value="<?= $postal_code ?>"
                                                    maxlength="12" required="">

                                            </div>

                                            <div class="col-md-2 form-control-comment">

                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center ">
                                            <label class="col-md-2 col-form-label required">
                                                Country
                                            </label>
                                            <div class="col-md-8">

                                                <div class="custom-select2">
                                                    <select class="form-control form-control-select js-country"
                                                        name="country" required="">
                                                        <option value="" disabled="" selected="">-- please
                                                            choose --</option>
                                                        <option value="India" selected="">India</option>
                                                    </select>
                                                </div>


                                            </div>

                                            <div class="col-md-2 form-control-comment">

                                            </div>
                                        </div>


                                        <div class="form-group row align-items-center ">
                                            <label class="col-md-2 col-form-label">
                                                Phone
                                            </label>
                                            <div class="col-md-8">
                                                <input class="form-control" name="phone_number" type="tel" value="<?= $phone_number ?>"
                                                    maxlength="32">
                                            </div>

                                            <div class="col-md-2 form-control-comment">

                                                Optional

                                            </div>
                                        </div>

                                    </section>

                                    <footer class="form-footer clearfix">

                                        <button class="btn btn-primary float-xs-right" name= 'submitAddress' type="submit">
                                            Save
                                        </button>
                                    </footer>


                                </form>
                            </div>


                        </div>

                    </section>
                </section>

                <?php
                }else{
                    if (count($addresss_data) > 0) {
                        ?>
                        <!-- Show All Address -->
                        <section id="main">
                            <header class="page-header">
                                <h1>
                                    Your addresses
                                </h1>
                            </header>

                            <section id="content" class="page-content">

                                <aside id="notifications">
                                    <div class="container">
                                        <!-- <article class="alert alert-success" role="alert" data-alert="success">
                                                <ul>
                                                    <li>Address successfully added!</li>
                                                </ul>
                                            </article> -->
                                    </div>
                                </aside>
                                
                                <?php
                                    foreach ($addresss_data as $key => $value) {
                                        if($value['default_address'] > 0){
                                            $setCheck = 'checked';
                                        }else {
                                            $setCheck = '';
                                        }
                                        ?>
                                        <div class="col-lg-4 col-md-6 col-sm-6" style="margin-top: 20px">
                                            <article id="address-12" onclick="setDefaultAddress('<?= $value['id'] ?>')" class="address" data-id-address="12"
                                                style="border: 1px solid #ddd;padding: 20px;" >
                                                <div class="address-body" style="position: relative;left: 15px;">
                                                    <h4><?= $value['add_firstname'].' '.$value['add_lastname'] ?></h4>
                                                    <input type="radio" name="setdefault" onclick = "setAddresDefault('<?= $value['id'] ?>')" title ="set Default" style="position: absolute;top: 0;right: 24px;" <?= $setCheck ?>>
                                                    <address><?= $value['company'] ?><br><?= $value['address'] ?><br><?= $value['addres_complement'] ?><br><?= $value['city'].', '.$value['state'].'-'.$value['postal_code'] ?><br><?= $value['country'] ?><br><?= $value['phone_number'] ?></address>
                                                </div>

                                                <div class="address-footer"
                                                    style="border-top: 1px solid #ddd;padding: 10px;display: flex;justify-content: space-evenly;">
                                                    <a href="<?= FRONT_SITE_PATH.'addresses?controller=update&id='.$value['id'].'&redirect='.$page_url.'' ?>" data-link-action="edit-address">
                                                        <i class="material-icons"></i>
                                                        <span>Update</span>
                                                    </a>
                                                    <a href="<?= FRONT_SITE_PATH.'addresses?controller=delete&id='.$value['id'].'&redirect='.$page_url ?>" data-link-action="delete-address">
                                                        <i class="material-icons"></i>
                                                        <span>Delete</span>
                                                    </a>
                                                    
                                                </div>
                                                <p class="default_msg<?= $value['id'] ?>"></p>
                                            </article>

                                        </div>
                                <?php
                                    } 
                                
                                ?>

                                <div class="clearfix"></div>


                                <div class="addresses-footer" style="margin-top: 16px;">
                                    <a href="<?= FRONT_SITE_PATH.'addresses?controller=add&redirect='.$page_url  ?>" data-link-action="add-address">
                                        <i class="material-icons"></i>
                                        <span>Create new address</span>
                                    </a>
                                </div>

                            </section>
                        </section>
                <?php
                    }else{
                        ?>
                        <!-- No Address  -->
                        <section id="main">

                            <header class="page-header">
                                <h1>
                                    Your addresses
                                </h1>
                            </header>




                            <section id="content" class="page-content">



                                <aside id="notifications">
                                    <div class="container">


                                        <article class="alert alert-warning" role="alert" data-alert="warning">
                                            <ul>
                                                <li>No addresses are available. <a
                                                        href="<?= FRONT_SITE_PATH.'addresses?controller=add&redirect='.$page_url ?>">Add a
                                                        new address</a></li>
                                            </ul>
                                        </article>

                                    </div>
                                </aside>

                                <div class="clearfix"></div>
                            </section>

                        </section>
                <?php
                    }
                    ?>
                <?php
                }
            ?>


                <footer class="page-footer">
                    <a href="<?= FRONT_SITE_PATH.'identity' ?>" class="btn account-link">
                        <i class="material-icons"></i>
                        <span>Back to your account</span>
                    </a>
                    <a href="<?= FRONT_SITE_PATH ?>" class="btn account-link">
                        <i class="material-icons"></i>
                        <span>Home</span>
                    </a>



                </footer>


            </div>



        </div>

    </div>

</section>

<?php
            require 'includes/footer.php';
       ?>