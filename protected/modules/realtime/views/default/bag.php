<style type="text/css">
table.miji_table{
	border-collapse:collapse;
}
.miji_table td,.miji_table th{
	padding:4px;
}
.miji_table th{
	background:#DDD;
}
.miji_table tr:nth-child(even){
	background:#FFF;
}
.miji_table tr:nth-child(odd){
	background:#EEE;
}
.miji_table tr:hover{
	background:#9CF;
}
strong{
	font-weight:bold;
}
</style>

<table border = 1 class="miji_table">
    <tr>
       <?php 
          if (count($list)){
          	  echo "<tr><th colspan='5'><strong>物品包</strong></th></tr>";
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

<table border = 1 class="miji_table">
    <tr>
       <?php 
          if (count($list)){
          	  echo "<tr><th colspan='5'><strong>秘籍包</strong></th></tr>";
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
