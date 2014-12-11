<?php
/**
 * The Template for displaying authors
 *
 */

get_header();

if (is_user_logged_in()){

    $user_id = get_current_user_id();

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
    $institution = get_the_author_meta( 'institution',   $user_id  );
    $member_type = get_the_author_meta( 'member_type',   $user_id  );

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
    var display_name="<?php echo $display_name; ?>";
    var email="<?php echo $user_email; ?>";
    var password="<?php echo $user_password; ?>";
    var phone_nr="<?php echo $phone_nr; ?>";
    var adress="<?php echo $adress; ?>";
    var WBA_ID="<?php echo $WBA_ID; ?>";
    var display_name="<?php echo $display_name; ?>";


    </script>

<div class="container">
      <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
              <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title"><?php echo $display_name;?>  <a href="edit.html" data-original-title="Edit this user" data-toggle="modal" data-target="#myModal" data-toggle="tooltip" type="button" class=" btn btn-default "><i class="fa fa-edit"></i></a></h3>

            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3 col-lg-3 " align="center"> <?php echo  $avatar;?> </div>
                <div class=" col-md-9 col-lg-9 ">
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>Username</td>
                        <td><?php echo $username; ?></td>
                      </tr>
                      <tr>
                        <td>Full Name</td>
                        <td><?php echo $display_name; ?></td>
                      </tr>
                      <tr>
                        <td>Email</td>
                        <td><?php echo $user_email; ?></td>
                      </tr>
                      <tr>
                        <td>Password</td>
                        <td><?php echo "*********" ?></td>
                      </tr>
                      <tr>
                        <td>Telephone number</td>
                        <td> <?php echo $phone_nr;?></td>
                      </tr>

                      <tr>
                        <td>Adress</td>
                        <td> <?php echo $adress;?></td>
                      </tr>

                      <tr>
                        <td>WBA ID</td>
                        <td> <?php echo $WBA_ID;?></td>
                      </tr>

                      <tr>
                        <td>Student number</td>
                        <td> <?php echo $studentnr;?></td>
                      </tr>

                      <tr>
                        <td>Institution</td>
                        <td> <?php echo $institution;?></td>
                      </tr>

                      <tr>
                        <td>Veggie</td>
                        <td> <?php echo $veggie;?></td>
                      </tr>

                      <tr>
                        <td>Allergies</td>
                        <td> <?php echo $allergies;?></td>
                      </tr>
                      <tr>
                        <td>Type of member</td>
                        <td> <?php echo $member_type;?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit: <?php echo $display_name;?></h4>
      </div>
      <div class="modal-body">
        <form>
        <table class="table table-user-information">
        <tbody>
          <tr>
            <td><LABEL for="displayname">Display Name</LABEL></td>
            <td><INPUT type="text" id="displayname" value="<?php echo $display_name; ?>"></td>
          </tr>
          <tr>
            <td><LABEL for="email">Email</LABEL></td>
            <td><INPUT type="email" id="email" value="<?php echo $user_email; ?>"></td>
          </tr>
          <tr>
            <td><LABEL for="password">Password</LABEL></td>
            <td><INPUT type="password" id="password" value="*********"></td>
          </tr>
          <tr>
            <td><LABEL for="telephone">Telephone number</LABEL></td>
            <td><INPUT type="text" id="telephone" value="<?php echo $phone_nr;?>"></td>
          </tr>
          <tr>
            <td><LABEL for="adress">Adress</LABEL></td>
            <td><INPUT type="text" id="adress" value="<?php echo $adress;?>"></td>
          </tr>
          <tr>
            <td><LABEL for="WBA_ID">WBA ID</LABEL></td>
            <td><INPUT type="text" id="WBA_ID" value="<?php echo $WBA_ID;?>"></td>
          </tr>
          <tr>
            <td><LABEL for="studentnr">Student number</LABEL></td>
            <td><INPUT type="text" id="studentnr" value="<?php echo $studentnr;?>"></td>
          </tr>
          <tr>
            <td><LABEL for="allergies">Allergies</LABEL></td>
            <td><INPUT type="text" id="allergies" value="<?php echo $allergies;?>"></td>
          </tr>
          <tr>
            <td><LABEL for="member_type">Type of member</LABEL></td>
            <td><INPUT type="text" id="member_type" value="<?php echo $member_type;?>"></td>
            </tr>


          <?php
          /* TODO: implement radioboxes in form for:
          - $veggie = get_the_author_meta( 'veggie',   $user_id  );
          - $institution = get_the_author_meta( 'institution',   $user_id  );
          */
          ?>

        </tbody>
      </table>
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
}



 get_footer(); ?>
<?php
