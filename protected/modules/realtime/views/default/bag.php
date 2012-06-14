<!--<style type="text/css">-->
<!--.tableborder{border:0px; border-collapse:collapse;} -->
<!--.tableborder td{border-top:1px #666 solid;border-right:1px #666 solid;} -->
<!--.tableborder{border-bottom:1px #666 solid;border-left:1px #666 solid;}-->
<!--</style>-->
<center>
<font size="5" face ="隶书">物品包</font>
</center>  
<hr>
<table>
    <tr>
       <?php 
          if (count($list)){
              for($i = 0;$i <= 36;$i++){
                  if ($i%4 == 0){
                    echo '</tr><tr>';
                  }
                  echo '<td>';
                  echo isset($list['bag'.$i])?$list['bag'.$i]:'';
                  echo '</td>';
              }
          }
        ?>
</table>
<br>
<center>
<font size="5" face ="隶书">秘籍包</font>
</center>
<hr>
<table>
    <tr>
       <?php 
          if (count($list)){
              for($i = 0;$i <= 36;$i++){
                  if ($i%4 == 0){
                    echo '</tr><tr>';
                  }
                  echo '<td>';
                  echo isset($list['book'.$i])?$list['book'.$i]:'';
                  echo '</td>';
              }
          }
        ?>
</table>
