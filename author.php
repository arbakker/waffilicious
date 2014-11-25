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
    $first_name = $userinfo->first_name;
    $last_name = $userinfo->last_name;
    $user_pass =   $userinfo->user_pass;
    $user_email=   $userinfo->user_email;
    $author_registered = $userinfo->user_registered;
    if ($author_registered){
        $registered_since=   date("n/j/Y", strtotime($author_registered));
      }else{
        $registered_since="Not registered";
      }
    $avatar =get_avatar($user_id);

    $class_poss = strpos ( $avatar , 'class');

      $avatar=str_replace('avatar-96', 'avatar-96 img-circle', $avatar);

    ?>
<div class="container">
      <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
              <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title"><?php echo $first_name." ".$last_name;?></h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3 col-lg-3 " align="center"> <?php echo  $avatar;?> </div>

                <!--<div class="col-xs-10 col-sm-10 hidden-md hidden-lg"> <br>
                  <dl>
                    <dt>DEPARTMENT:</dt>
                    <dd>Administrator</dd>
                    <dt>HIRE DATE</dt>
                    <dd>11/12/2013</dd>
                    <dt>DATE OF BIRTH</dt>
                       <dd>11/12/2013</dd>
                    <dt>GENDER</dt>
                    <dd>Male</dd>
                  </dl>
                </div>-->
                <div class=" col-md-9 col-lg-9 ">
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>Username</td>
                        <td><?php echo $username; ?></td>
                      </tr>
                      <tr>
                        <td>Display Name</td>
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
                        <td>Registered Since</td>
                        <td><?php echo $registered_since; ?></td>
                      </tr>

                    </tbody>
                  </table>

                  <a href="#" class="btn btn-primary">My Sales Performance</a>
                  <a href="#" class="btn btn-primary">Team Sales Performance</a>
                </div>
              </div>
            </div>
                 <div class="panel-footer">
                        <a data-original-title="Broadcast Message" data-toggle="tooltip" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-envelope"></i></a>
                        <span class="pull-right">
                            <a href="edit.html" data-original-title="Edit this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
                            <a data-original-title="Remove this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
                        </span>
                    </div>

          </div>
        </div>
      </div>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        <form>
        <table class="table table-user-information">
        <tbody>
          <tr>
            <td><LABEL for="username">Username</LABEL></td>
            <td><INPUT type="text" id="username" value="<?php echo $username; ?>"></td>
          </tr>
          <tr>
            <td><LABEL for="displayname">Display Name</LABEL></td>
            <td><INPUT type="text" id="displayname" value="<?php echo $display_name; ?>"></td>
          </tr>
          <tr>
            <td><LABEL for="email">Email</LABEL></td>
            <td><INPUT type="text" id="email" value="<?php echo $user_email; ?>"></td>
          </tr>
          <tr>
            <td><LABEL for="password">Password</LABEL></td>
            <td><INPUT type="password" id="password" value="*********"></td>
          </tr>

        </tbody>
      </table>
      </form
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<?php
}



 get_footer(); ?>
<?php
