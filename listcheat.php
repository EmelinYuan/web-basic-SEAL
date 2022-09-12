<?php require_once('template/header.php'); ?>
<?php require_once('config.php'); ?>
<?php 
$sql = "SELECT * FROM cheatlist";
$cheat_list = $conn->query($sql);
?>
  <!--Untuk Home-->
  
  <p><a href="https://wa.me/628973940550" class ="tbl-pink"> WHATSAPP ME!</a></p>
        <hr>
        <div style="width: 400px; margin: 0px auto;font-size: 20px;"> 
              <ol>
                <?php while ($row = $cheat_list->fetch_object()): ?>
                    <li><?=$row->cheat_name?></li>
                <?php endwhile; ?>
              </ol> 
        </div> 
  
<?php require_once 'template/footer.php'; ?>
    