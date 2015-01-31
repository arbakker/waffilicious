<?php
/**
 * The Template for displaying authors
 *
 */
 if (is_user_logged_in()){
   $url=curPageURL();
   $pattern="/http:\/\/.*\/member\/(.*)\//";
   preg_match($pattern,$url,$matches);
   $author=$matches[1];
   $user = get_user_by( 'login', $author );
   $user_id = $user->ID;
   if  (!current_user_can('edit_user', $user_id )){
     $url= site_url()."/member/".wp_get_current_user()->user_login."/";
     wp_redirect( $url);
     exit;
   }
   }else{
     wp_redirect(site_url());
     exit;
   }

get_header();
    $userinfo = get_userdata( $user_id );
    $username = $userinfo->user_login;
    $display_name= $userinfo->display_name;
    $user_pass =   $userinfo->user_pass;
    $user_email=   $userinfo->user_email;
    $author_registered = $userinfo->user_registered;

    $phone_nr= get_the_author_meta( 'phone',   $user_id  );
    $veggie = get_the_author_meta( 'veggie',   $user_id  );
    $adress = get_the_author_meta( 'adress',   $user_id  );
    $allergies = get_the_author_meta( 'allergies',   $user_id  );
    $WBA_ID = get_the_author_meta( 'WBA_ID',   $user_id  );
    $studentnr = get_the_author_meta( 'studentnr',   $user_id  );
    $institute = get_the_author_meta( 'institute',   $user_id  );
    $member_type = get_the_author_meta( 'member_type',   $user_id  );
    $dob = get_the_author_meta( 'dob',   $user_id  );

    if ($author_registered){
        $registered_since=   date("n/j/Y", strtotime($author_registered));
      }else{
        $registered_since="Not registered";
      }
    $avatar =get_avatar($user_id);
    $class_poss = strpos ( $avatar , 'class');
      $avatar=str_replace('avatar-96', 'avatar-96 img-circle', $avatar);
    ?>

    <script type="text/javascript">
      var currentMemberId="<?php echo $user_id; ?>";
      var displayname="<?php echo $display_name; ?>";
      var email="<?php echo $user_email; ?>";
      var password="<?php echo $user_pass; ?>";
      var telephone="<?php echo $phone_nr; ?>";
      var adress="<?php echo $adress; ?>";
      var WBA_ID="<?php echo $WBA_ID; ?>";
      var display_name="<?php echo $display_name; ?>";
      var veggie="<?php echo $veggie; ?>";
      var studentnr="<?php echo $studentnr; ?>";
      var allergies="<?php echo $allergies; ?>";
      var member_type="<?php echo $member_type; ?>";
      var institute="<?php echo $institute; ?>";
      var dob="<?php echo $dob; ?>";
    </script>

<div class="container">

      <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xlg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 col-xlg-offset-3 toppad" >
              <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title"><?php echo $display_name;?></h3>

            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3 col-lg-3  " align="center"> <?php echo  $avatar;?> </div>
                <div class=" col-md-9 col-lg-9 ">
                  <table class="table table-user-information">
                    <caption><h4>Account details</h4></caption>
                    <tbody>
                      <tr>
                        <td>Username</td>
                        <td><?php echo $username; ?></td>
                      </tr>
                      <tr>
                        <td>Email</td>
                        <td><?php echo $user_email; ?><a href="#" data-original-title="Change email address" data-toggle="modal" data-target="#modalEmail" data-toggle="tooltip" type="button" class=" btn btn-default btn-sm pull-right btn-edit-usr"><i class="fa fa-edit"></i></a></td>

                      </tr>
                      <tr>
                        <td>Password</td>
                        <td><?php echo "*********" ?><a href="#" data-original-title="Change password" data-toggle="modal" data-target="#modalPassword" data-toggle="tooltip" type="button" class=" btn btn-default btn-sm pull-right btn-edit-usr"><i class="fa fa-edit"></i></a></td>

                      </tr>
                    </tbody>
                  </table>
                  <table class="table table-user-information">
                      <caption><h4 class="profile-header">Member details <a href="#" data-original-title="Edit this user" data-toggle="modal" data-target="#myModal" data-toggle="tooltip" type="button" class=" btn btn-default btn-sm pull-right btn-edit-usr btn-profile"><i class="fa fa-edit"></i></a></h4></caption>
                    <tbody>

                      <tr>
                        <td>Full Name</td>
                        <td id="displayname_display"><?php echo $display_name; ?></td>
                      </tr>

                      <tr>
                        <td>Telephone number</td>
                        <td id="phone_nr_display"> <?php echo $phone_nr;?></td>
                      </tr>

                      <tr>
                        <td>Adress</td>
                        <td id="adress_display"> <?php echo $adress;?></td>
                      </tr>

                      <tr>
                        <td>Date of birth</td>
                        <td id="dob_display"> <?php echo $dob;?></td>
                      </tr>
                      <tr>
                        <td>Student number</td>
                        <td id="studentnr_display"> <?php echo $studentnr;?></td>
                      </tr>
                      <tr>
                        <td>WBA ID</td>
                        <td id="WBA_ID_display"> <?php echo $WBA_ID;?></td>
                      </tr>


                      <tr>
                        <td>Type of member</td>
                        <td id="member_type_display"> <?php echo $member_type;?></td>
                      </tr>
                      <tr>
                        <td>Institution</td>
                        <td id="institute_display"> <?php echo $institute;?></td>
                      </tr>
                      <tr>
                        <td>Veggie</td>
                        <td id="veggie_display"> <?php if ($veggie){
                          echo "Yes";}else{echo "No";
                        }?></td>
                      </tr>
                      <?php if ($allergies){ ?>
                      <tr>
                        <td>Allergies</td>
                        <td id="allergies_display"> <?php echo $allergies;?></td>
                      </tr>
                      <?php }
                      ?>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


<div class="modal fade" id="modalPassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel3">Change password</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-warning" id="alert-warning-password" style="display: none;">
          <button type="button" onclick="$('.alert').hide();" class="close" >
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
          </button>
          <div id="warning-message-password">
          </div>
        </div>
        <div class="alert alert-warning" id="alert-error-password" style="display: none;">
          <button type="button" onclick="$('.alert').hide();" class="close" >
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
          </button>
          <div id="error-message-password">
          </div>
        </div>
        <div class="alert alert-warning" id="alert-success-password" style="display: none;">
          <button type="button" onclick="$('.alert').hide();" class="close" >
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
          </button>
          <div id="success-message-password">
          </div>
        </div>

        <form class="form-horizontal" id="changePassword">
          <div class="form-group">
            <LABEL class="control-label col-md-4 col-xs-4" for="password-new">New password</LABEL>
            <div class="col-md-6 col-xs-6"><INPUT class="required form-control" type="password" id="password-new"></div>
          </div>
          <div class="form-group">
            <LABEL class="control-label col-md-4 col-xs-4" for="password-new-rep">Repeat new password</LABEL>
            <div class="col-md-6 col-xs-6"><INPUT class="required form-control" type="password" id="password-new-rep"></div>
          </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="savePassword" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="modalEmail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel2">Change email address</h4>
      </div>
      <div class="modal-body">

        <div class="alert alert-warning" id="alert-warning-email" style="display: none;">
          <button type="button" onclick="$('.alert').hide();" class="close" >
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
          </button>
          <div id="warning-message-email">
          </div>
        </div>

        <form class="form-horizontal" id="changeEmail">
          <div class="form-group">
            <LABEL class="control-label col-md-4 col-xs-4" for="email">Email</LABEL>
            <div class="col-md-6 col-xs-6"><INPUT class="required form-control" type="email" id="email"></div>
          </div>
          <div class="form-group">
            <LABEL class="control-label col-md-4 col-xs-4" for="email-rep">Repeat email</LABEL>
            <div class="col-md-6 col-xs-6"><INPUT class="required form-control" type="email" id="email-rep"></div>
          </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="saveEmail" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit: <?php echo $display_name;?></h4>
      </div>
      <div class="modal-body">

        <form class="form-horizontal" id="userdetails">
          <div class="form-group">
            <LABEL class="control-label col-md-4 col-xs-4" for="displayname">Full Name</LABEL>
            <div class="col-md-6 col-xs-6"><INPUT class="required form-control input-details" type="text" id="displayname" value="<?php echo $display_name; ?>"></div>
          </div>
          <div class="form-group">
            <LABEL class="control-label col-md-4 col-xs-4" for="telephone">Telephone number</LABEL>
            <div class="col-md-6 col-xs-6"><INPUT class="required form-control input-details" type="text" id="telephone" value="<?php echo $phone_nr;?>"></div>
          </div>
          <div class="form-group">
            <LABEL class="control-label col-md-4 col-xs-4" for="adress">Adress</LABEL>
            <div class="col-md-6 col-xs-6"><INPUT class="required form-control input-details" type="text" id="adress" value="<?php echo $adress;?>"></div>
          </div>
          <div class="form-group">
            <LABEL class="control-label col-md-4 col-xs-4"  for="dob">Date of birth</LABEL>
            <div class="col-md-6 col-xs-6">
              <INPUT class="form-control  required input-details" id="dob" type="text" value="<?php echo  $dob; ?>" />
              </div>
            </div>
          <div class="form-group">
            <LABEL class="control-label col-md-4 col-xs-4" for="studentnr">Student number</LABEL>
            <div class="col-md-6 col-xs-6"><INPUT class="required form-control input-details" type="text" id="studentnr" value="<?php echo $studentnr;?>"></div>
          </div>
          <div class="form-group">
            <LABEL class="control-label col-md-4 col-xs-4" for="WBA_ID">WBA ID</LABEL>
            <div class="col-md-6 col-xs-6"><INPUT class="required form-control input-details" type="text" id="WBA_ID" value="<?php echo $WBA_ID;?>"></div>
            </div>
                      <div class="form-group">
            <LABEL class="control-label col-md-4 col-xs-4" for="member_type">
              Type of member
            </LABEL>
            <div class="col-md-6 col-xs-6"><select id='member_type'>
            <option <?php if ($member_type=="Student" or $member_type==="") echo 'selected="selected"'; ?>>Student</option>
              <option <?php if ($member_type=="PHD") echo 'selected="selected"'; ?>>PHD</option>
              <option <?php if ($member_type=="Clubcard") echo 'selected="selected"'; ?>>Clubcard</option>
              <option <?php if ($member_type=="Trainer") echo 'selected="selected"'; ?>>Trainer</option>
            </select></div>
          </div>
          <div class="form-group">
            <LABEL class="control-label col-md-4 col-xs-4" for="institute">
              Institution
            </LABEL>
            <div class="col-md-6 col-xs-6"><select id='institute'>
              <option <?php if ($institute=="WUR") echo 'selected="selected"'; ?>>WUR</option>
              <option <?php if ($institute=="VHL") echo 'selected="selected"'; ?>>VHL</option>
              <option <?php if ($institute=="None" or $institute==="") echo 'selected="selected"'; ?>>None</option>
              <option <?php if ($institute=="Other") echo 'selected="selected"'; ?>>Other</option>
            </select></div>
          </div>

          <div class="form-group">
              <LABEL class="control-label col-md-4 col-xs-4" for="veggie">
                Vegetarian
              </LABEL>
              <div class="col-md-6 col-xs-6"><INPUT  type="checkbox"  id="veggie"<?php if ($veggie){echo "checked";} ?>></div>
          </div>
          <div class="form-group">
            <LABEL class="control-label col-md-4 col-xs-4" for="allergies">Allergies</LABEL>
            <div class="col-md-6 col-xs-6"><input class="form-control  input-details" type="text" id="allergies" value="<?php echo $allergies;?>"></div>
          </div>
      </form
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="save" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>





<?php




 get_footer(); ?>
<?php
