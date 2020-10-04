<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="style.css" />
    <link rel="shortcut icon" type="image/png" href="frome_logo.png" />

    <title>Members Details</title>
  <body>




  <?php

    //import the required config and DB
    require('config/config.php');
    require('config/db.php');




    //POST request to request the member for the entered id number.
    if(isset($_POST['submit'])){
      // get the form data
      $id = mysqli_real_escape_string($conn, $_POST['idQuery']);

      

      $idQuery = 'SELECT * FROM members WHERE id = '.$id;

      $idResult = mysqli_query($conn, $idQuery);

      $member = mysqli_fetch_assoc($idResult);

      if(mysqli_query($conn, $idQuery)){
      
      }else{
        echo 'ERROR: '. mysqli_error($conn);}
      }

      //Update DB when the done is submitted
      if(isset($_POST['collectedTop'])){
      // get the form data
      $topUpdate = mysqli_real_escape_string($conn, $_POST['topUpdate']);
      
      $date = date('d-m-y');
        echo $date;
      $sql = "UPDATE `members` SET top = 1 , topCollectDate = CURDATE() WHERE id= '$topUpdate'";
  
    
      refresh($topUpdate);

      if(mysqli_query($conn, $sql)){
    
        }else{
            echo 'ERROR: '. mysqli_error($conn);}

      }

      function refresh($id){
        require('config/config.php');
        require('config/db.php');

        $idQuery = 'SELECT * FROM members WHERE id = '.$id;
  
        $idResult = mysqli_query($conn, $idQuery);
  
        $member = mysqli_fetch_assoc($idResult);

      
  
        if(mysqli_query($conn, $idQuery)){
        
        }else{
          echo 'ERROR: '. mysqli_error($conn);}
        }
      
    
?>


<a href="index.php">back</a>



      <div class="wrapper table" id="MemberList">
        
        <h2>Members Details</h2>
        
                <div class="members-results">

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
                        echo $newDate
                  ?>
                </td>
                </table>


                <!---Table to display kit sizes, and if they have been collected---->
                <table class="tableKit">
                <!--Table header -->
                  <tr>
                    <th>Top</th>
                    <th>Shorts</th>
                    <th>Socks</th>
                  </tr>

                <tr>
                  <td><?php echo 'size'. ' ' .$member['topSize'];?></td>
                  <td><?php echo 'size'. ' ' .$member['shortSize'];?></td>
                  
                </tr>
                      <!--New table row, showing if kit has been collected.
                          If not collected will show a input button to submit 
                          that the kit have been collected --->
               <tr>
              <td>
                <?php if ($member['top'] == 0) { //If top field in DB is 0 and button will be displayed, if 1 the date collected is displayed.                   
                       echo '<form method="POST">'. "<input type='hidden' name='topUpdate' value='{$member['id']}'>";
                       echo '<input type="submit"  name="collectedTop" value="Collected">'. '</form>';
                       }else {
                       echo 'collected';
                       }?></td>
                <td><?php if ($member['shorts'] == 0) {//If short field in DB is 0 and button will be displayed, if 1 the date collected is displayed.
                       
                       echo '<input type="submit" name="collectedShorts" value="Collected">';
                       }else {
                       echo 'collected';
                       }?></td>
                <td><?php if ($member['socks'] == 0) {//If sock field in DB is 0 and button will be displayed, if 1 the date collected is displayed.
                       echo '<input type="submit" name="collectedSocks" value="Collected">';
                       }else {
                       echo 'collected';
                       }?></td>
                </tr>
                <!---New table row to display date if the kit has been collected--->
              <tr>
              <?php
                if ($member['top'] != 0) {
                  $date = $member['topCollectDate'];
                        $newDate = date("d-m-Y", strtotime($date)); //sorts the date to UK format
                 echo '<td>'. $newDate .'</td>';
                }
                if ($member['shorts'] != 0) {
                  echo '<td>'. $member['shortCollectDate'] .'</td>';
                 }
                 if ($member['socks'] != 0) {
                  echo '<td>'. $member['sockCollectDate'] .'</td>';
                 }?>
              
              </tr>
                </table>
                
                         
              
                
                </div>
      </div>
    
        </div>
      </div>
    </div>
    <!--^^container end^^-->
    <script src="main.js"></script>
  </body>
</html>

