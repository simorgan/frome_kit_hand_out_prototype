<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="style3.css" />
    <link rel="shortcut icon" type="image/png" href="frome_logo.png" />

    <title>Home</title>
  <body>

<?php
//import the required config and DB
require('config/config.php');
require('config/db.php');

//The mail function will be called if all kit has been collected
function mailMember($memberEmail,$memberName,$memberID)
{
  require_once('phpMailer/PHPMailerAutoload.php'); //require phpMailler file

      $mail = new PHPMailer();
      $mail->isSMTP();
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = 'TLS';
      $mail->Host = 'fromerfc.org';
      $mail->Port = '587';
      $mail->isHTML();
      $mail->Username = 'membership@fromerfc.org';
      $mail->Password = ')%Car2010';
      $mail->SetFrom('membership@fromerfc.org');
      $mail->addReplyTo('membership@fromerfc.org');
      $mail->addBCC('membership@fromerfc.org');
      $mail->addBCC('cameron.hastie@yahoo.co.uk');
      $mail->Subject = 'Stash Collection Confirmation';
      $mail->AddEmbeddedImage('fromeLogo.png','testImage');
      $mail->Body = '<img style="display: block;
                    margin-left: auto;
                    margin-right: auto;
                    " src="cid:testImage" alt="Frome RFC" 
                    width="150" height="150">'.'<h1 style="text-align: center;">Frome RFC
                    </h1>'.
                    '<h5>'.'Dear'. ' '. $memberName.'</h5>'.'<h5>'.'ID:'.' '
                    .$memberID .'</h5>'.'<p>'.'Thank You for collecting your membership stash. 
                    If you have any issues please contact Cameron Hastie at cameron.hastie@yahoo.co.uk ASAP.'.'</p>'.
                    '<p>'.'Regards, <br> Frome RFC <br> <a href="http://www.fromerfc.org" target="_blank">www.fromerfc.org</a>'.'</p>';

      $mail->AddAddress($memberEmail);

      $mail->send();
}
function mailVoucher($memberEmail,$memberName,$memberID,$memberTopSize,$memberShortSize)
{
  require_once('phpMailer/PHPMailerAutoload.php'); //require phpMailler file

      $mail = new PHPMailer();
      $mail->isSMTP();
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = 'TLS';
      $mail->Host = 'fromerfc.org';
      $mail->Port = '587';
      $mail->isHTML();
      $mail->Username = 'membership@fromerfc.org';
      $mail->Password = ')%Car2010';
      $mail->SetFrom('membership@fromerfc.org');
      $mail->addReplyTo('membership@fromerfc.org');
      $mail->addBCC('membership@fromerfc.org');
      $mail->Subject = 'Stash Collection Voucher';
      $mail->AddEmbeddedImage('fromeLogo.png','testImage');
      $mail->Body = '<img style="display: block;
                    margin-left: auto;
                    margin-right: auto;
                    " src="cid:testImage" alt="Frome RFC" 
                    width="150" height="150">'.'<h1 style="text-align: center;">Frome RFC Membership Stash Voucher
                    </h1>'.
                    '<h5>'.'Dear'. ' '. $memberName.'</h5>'.'<h5>'.'<p>'.'This email confirms your stash has been reserved for you. Please produced this email upon collection..'.'</p>'.'<h5>'.'ID:'.' '
                    .$memberID .'</h5>'.'<h5>'.'Top Size: '. $memberTopSize.'</h5>'.'<h5>'.'Short Size: '.$memberShortSize.'</h5>'.'<p>'.'If you have any issues please contact Cameron Hastie at cameron.hastie@yahoo.co.uk ASAP.'.'</p>'.
                    '<p>'.'Regards, <br> Frome RFC <br> <a href="http://www.fromerfc.org" target="_blank">www.fromerfc.org</a>'.'</p>';

      $mail->AddAddress($memberEmail);

      $mail->send();
}

//POST request to request the member for the entered id number. 
//This will show the member in the container box.
if(isset($_POST['submitId']))
{
  // get the form data
    $id = mysqli_real_escape_string($conn, $_POST['idQuery']);
    $idQuery = 'SELECT * FROM members WHERE id = '.$id;
    $idResult = mysqli_query($conn, $idQuery);

        // If ID is not in DB this will return asking to check the ID number.
        if(mysqli_num_rows($idResult) > 0)
        { 
        $member = mysqli_fetch_assoc($idResult);
        } else {
        $noResult = 'MEMBER NOT IN DATABASE, PLEASE CHECK THE ID NUMBER.'; //variable to echo out
        }
}
if(isset($_POST['submitName']))
{
  // get the form data
    $name = mysqli_real_escape_string($conn, $_POST['nameQuery']);
    $nameQuery = 'SELECT * FROM members WHERE `name` = '.$name;
   
    $nameResult = mysqli_query($conn, $nameQuery);
    echo $nameResult;

        // If ID is not in DB this will return asking to check the ID number.
        if(mysqli_num_rows($nameResult) > 0)
        { 
        $member = mysqli_fetch_assoc($nameResult);
        } else {
        $noResult = 'MEMBER NOT IN DATABASE, PLEASE CHECK THE ID NUMBER.'; //variable to echo out no match found.
        }
}
//-----------------------------------------TOP collection
//Update DB when TOP has been collected
if(isset($_POST['collectedTop']))
{
  echo '<script> alert("Completed");</script>';
    // get the form data
    $topUpdate = mysqli_real_escape_string($conn, $_POST['topUpdate']);
    $date = date('d-m-y');
    $sql = "UPDATE `members` SET top = 1 , topCollectDate = CURDATE() WHERE id= '$topUpdate'";
        
        //check for error
        if(mysqli_query($conn, $sql)){
        }else{
        echo 'ERROR: '. mysqli_error($conn);}
}
//Reloading to members page to show that the kit has been collected.
if(isset($_POST['collectedTop']))
{
    // get the form data
    $id = mysqli_real_escape_string($conn, $_POST['topUpdate']);
    $idQuery = 'SELECT * FROM members WHERE id = '.$id;
    $idResult = mysqli_query($conn, $idQuery);
    $member = mysqli_fetch_assoc($idResult);

        if(mysqli_query($conn, $idQuery)){
        }else{
        echo 'ERROR: '. mysqli_error($conn);}

          
            //If all kit is collected the member will be emailed conformation of collection.
            if ($member['top'] == 1 && $member['shorts'] == 1 && $member['socks'] == 1)   //checking if all the kit has been collected.
            {
             // echo '<script> alert("Stash Collection Completed");</script>';
              mailMember($member['email'], $member['name'], $member['id']);//calling the mail function
            }
}

//-----------------------------------------SHORTS collection

//Update DB when SHORTS are collected.
if(isset($_POST['collectedShorts']))
{
  echo '<script> alert("Completed");</script>';
    // get the form data
    $shortsUpdate = mysqli_real_escape_string($conn, $_POST['shortsUpdate']);
    $sql = "UPDATE `members` SET shorts = 1 , shortCollectDate = CURDATE() WHERE id= '$shortsUpdate'";

        if(mysqli_query($conn, $sql)){
        }else{
        echo 'ERROR: '. mysqli_error($conn);}
}
//Reloading to members page to show that the kit has been collected.
if(isset($_POST['collectedShorts']))
{
    // get the form data
    $id = mysqli_real_escape_string($conn, $_POST['shortsUpdate']);
    $idQuery = 'SELECT * FROM members WHERE id = '.$id;
    $idResult = mysqli_query($conn, $idQuery);
    $member = mysqli_fetch_assoc($idResult);

        if(mysqli_query($conn, $idQuery)){
        }else{
        echo 'ERROR: '. mysqli_error($conn);}

            //If all kit is collected the member will be emailed conformation of collection.
            if ($member['top'] == 1 && $member['shorts'] == 1 && $member['socks'] == 1)   //checking if all the kit has been collected.
            {
              //echo '<script> alert("Stash Collection Completed");</script>';
              mailMember($member['email'],$member['name'],  $member['id']);//calling the mail function
            }
}

//---------------------------------------SOCK collection
if(isset($_POST['collectedSocks']))
{
  echo '<script> alert("Completed");</script>';
    // get the form data
    $sockUpdate = mysqli_real_escape_string($conn, $_POST['sockUpdate']);
    $sql = "UPDATE `members` SET socks = 1 , sockCollectDate = CURDATE() WHERE id= '$sockUpdate'";

        if(mysqli_query($conn, $sql)){
        }else{
        echo 'ERROR: '. mysqli_error($conn);}
}
//Reloading to members page to show that the kit has been collected.
if(isset($_POST['collectedSocks']))
{
    // get the form data
    $id = mysqli_real_escape_string($conn, $_POST['sockUpdate']);
    $idQuery = 'SELECT * FROM members WHERE id = '.$id;
    $idResult = mysqli_query($conn, $idQuery);
    $member = mysqli_fetch_assoc($idResult);

        if(mysqli_query($conn, $idQuery)){
        }else{
        echo 'ERROR: '. mysqli_error($conn);}

            //If all kit is collected the member will be emailed conformation of collection.
            if ($member['top'] == 1 && $member['shorts'] == 1 && $member['socks'] == 1)   //checking if all the kit has been collected.
            {
              //echo '<script> alert("Stash Collection Completed");</script>';
              mailMember($member['email'],$member['name'],  $member['id']);//calling the mail function
            }
}
//update the database stashEmail to 1
if(isset($_POST['stashEmail']))
{
    // get the form data
    $stashEmailSent = mysqli_real_escape_string($conn, $_POST['voucherEmail']);
    $sql = "UPDATE `members` SET stashEmail = 1 WHERE id= '$stashEmailSent'";

        if(mysqli_query($conn, $sql)){
        }else{
        echo 'ERROR: '. mysqli_error($conn);}
}

//reload and email the stash voucher
if(isset($_POST['stashEmail']))
{
   // get the form data
   $id = mysqli_real_escape_string($conn, $_POST['voucherEmail']);
   $idQuery = 'SELECT * FROM members WHERE id = '.$id;
   $idResult = mysqli_query($conn, $idQuery);
   $member = mysqli_fetch_assoc($idResult);

   mailVoucher($member['email'],$member['name'],$member['id'],$member['topSize'],$member['shortSize']);//calling the mail function
}


?>


<!-------------------------------------------------------             HTML START                      ---------------------------->

<div Class="" id="container"> <h1></h1>
<div class="container" >
      <h1 class="page-title"><u>Membership Stash</u></h1>
        
        <form method="POST" class="result-form">
         <u>Members Search</u>
             <div class="form-inputs">
                <span class="result-result"
                  >ID Number<br />
                  <input type="text" name="idQuery" id="players-result"/>
                </span> <br/>
                  <input type="submit" name="submitId" value="Search" class="form-button">
                  <h5>OR</h5>
                  <span class="result-result"
                  >Name<br />
                  <input type="text" name="nameQuery" id="players-result"/>
                </span> <br/>
                  <input type="submit" name="submitName" value="Search" class="form-button">
              </div>
        </form>

      <div class="wrapper table" id="MemberList">
           <h2>Members Details</h2>
              <div class="members-results">
                    <h2><?php echo $noResult?></h2>

                <!--Table to display members name and date membership was paid-->
                <table class="tableName">
                <tr>
                <th><u>Name</u></th>
                <th><u>Paid on</u></th>
                </tr>
                <td>
                <?php echo $member['name'];?>
                </td>
                <td>
                  <?php $date = $member['paid'];
                        $newDate = date("d-m-Y", strtotime($date));
                        echo $newDate?>
                </td>
                </table>


                <!---Table to display kit sizes, and if they have been collected---->
                
                

              <div class="tableKit">

                 <Table class="topTable">
                 <tr>
                 <th>Top</th>
                 </tr>
                 <tr><td><?php echo 'size'. ' ' .$member['topSize'];?></td></tr>

                 <tr>    <td>
                <?php if ($member['top'] == 0) { //If top field in DB is 0 and button will be displayed, if 1 the date collected is displayed.                
                       echo '<form method="POST"  >'. "<input type='hidden' name='topUpdate' value='{$member['id']}' >";
                       echo '<input type="submit"  name="collectedTop" value="Done" class="form-button">'. '</form>';
                       }else {
                       echo 'collected';
                       }?></td></tr>
                       <tr> <?php   if ($member['top'] != 0) {
                  $date = $member['topCollectDate'];
                        $newDate = date("d-m-Y", strtotime($date)); //sorts the date to UK format
                 echo '<td>'. $newDate .'</td>';
                }?></tr>
                 </Table>

                 <table class="shortTable">
                 <tr>
                 <th>Shorts</th>
                 </tr>
                 <tr>
                 <td><?php echo 'size'. ' ' .$member['shortSize'];?></td>
                 </tr>
                 <tr>
                 <td>
                 <?php if ($member['shorts'] == 0) {//If short field in DB is 0 and button will be displayed, if 1 the date collected is displayed.
                       echo '<form method="POST">'. "<input type='hidden' name='shortsUpdate' value='{$member['id']}'>";
                       echo '<input type="submit" name="collectedShorts" value="Done" class="form-button">';
                       }else {
                       echo 'collected';
                       }?>
                 </td>
                 </tr>
                 <tr>
                 <?php if ($member['shorts'] != 0) {
                  $dates = $member['shortCollectDate'];
                        $newDates = date("d-m-Y", strtotime($dates)); //sorts the date to UK format
                  echo '<td>'. $newDates .'</td>';
                 }    ?>
                 </tr>
               </table>

               <table class="sockTable">
               <tr>
               <th>Socks</th>
               </tr>
               <tr>
               <td>
               n/a
               </td>
               </tr>
               <tr>
               <td>
               <?php if ($member['socks'] == 0) {//If sock field in DB is 0 and button will be displayed, if 1 the date collected is displayed.
                       echo '<form method="POST">'. "<input type='hidden' name='sockUpdate' value='{$member['id']}'>";
                       echo '<input type="submit" name="collectedSocks" value="Done" class="form-button">';
                       }else {
                       echo 'collected';
                       }?>
               </td>
               </tr>
               <tr>
               <?php    if ($member['socks'] != 0) {
                  $dates2 = $member['sockCollectDate'];
                  $newDates2 = date("d-m-Y", strtotime($dates2)); //sorts the date to UK format
            echo '<td>'. $newDates2 .'</td>';
                 }?>
               </tr>
               </table>
               </div>
               
            
             <div class="emailVoucher">
               <?php if ($member['stashEmail'] == 0) {//If sock field in DB is 0 and button will be displayed, if 1 the date collected is displayed.
                       echo '<form method="POST">'. "<input type='hidden' name='voucherEmail' value='{$member['id']}'>";
                       echo '<input type="submit" name="stashEmail" value="Mail Stash Voucher" class="form-button">';
                       }else {
                       echo 'Voucher Sent'. '<br>'. 'To'.' <br>' . $member['email'];
                       }?>
                       
                       
                       </div>
              
                </div>
      </div>
    
        </div>
      </div>

    </div>
    <!--^^container end^^-->
    </div>
    <script></script>
  </body>
</html>
