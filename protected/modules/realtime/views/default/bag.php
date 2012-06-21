<!--<style type="text/css">-->
<!--.tableborder{border:0px; border-collapse:collapse;} -->
<!--.tableborder td{border-top:1px #666 solid;border-right:1px #666 solid;} -->
<!--.tableborder{border-bottom:1px #666 solid;border-left:1px #666 solid;}-->
<!--</style>-->
<center>
<font size="5" face ="隶书">物品包</font>
 
<hr>
<table border = 1>
    <tr>
       <?php 
          if (count($list)){
              for($i = 0;$i <= 36;$i++){
                  if ($i%5 == 0){
                    echo '</tr><tr>';
                  }
                  if (isset($list['bag'.$i])){
                    echo '<td>';
                    echo $list['bag'.$i];
                    echo '</td>';
                  }
              }
          }
        ?>
</table>
<br>
<font size="5" face ="隶书">秘籍包</font>
<hr>
<table border = 1>
    <tr>
       <?php 
          if (count($list)){
              for($i = 0;$i <= 20;$i++){
                  if ($i%6 == 0){
                    echo '</tr><tr>';
                  }
                  if (isset($list['book'.$i])){
                    echo '<td>';
                    echo $list['book'.$i];
                    echo '</td>';
                  }
              }
          }
        ?>
</table>
