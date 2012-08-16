<div class="main-box">
    <div class="main-body">
        <aside class="span5">

        </aside>
        <div class="main-container prepend5">
            <div class="main-content">

                <?php
                    $form = $this->beginWidget('ActiveForm', array('id' => 'close_server'));
                ?>

                <div class="clearfix">
                    <div class="cell">
                        <label>请选择服务器:</label>
                        <div class="item">
                            <div class="main">
                                <?php
                                    echo Html5::dropDownList('server_id', $server_id, $select, array('class'=>'span3'));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clearfix">
                    <div class="cell">
                        <label>请输入验证码:</label>
                        <div class="item" style="margin-top: -15px;">
                            <div class="main">
                                <?php
                                    echo Html5::textField('code', '', array('style' => 'float:left; margin-top:15px; '));  $this->widget('CCaptcha');
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="actions">
                    <button type="button" id="save" name="save">提交</button>
                </div>

                <?php $this->endWidget(); ?>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
var url = <?php echo '"' . $url . '"'; ?> + '/index.php?r=/service/default/closeserver';
var btn = document.getElementById('save');
$('#save').click(function(){
    var Ext = window.parent.Ext;
    var server_id = $('#server_id').val(),
        code = $('#code').val(),
        data = 'server_id=' + server_id + '&code=' + code;
    if(!code || !server_id ){
        !Ext || Ext.MessageBox.alert("操作提示",'请填写完整数据再提交');
    }
    $.ajax({
        url : url,
        type : 'POST',
        data : data,
        success : function( d ){
            try{
                d = parseJSON(d);
            }catch(e){
                console.log(d);
            }
            console.log(d);
            if( typeof d == 'string') return ;
            if(d.success){
                !Ext || Ext.MessageBox.alert("操作提示", '操作成功', function(){
                    window.parent.location.reload();
                });
            }else{
                !Ext || Ext.MessageBox.alert("操作提示",d.text);
            }
        },
        error : function(a,b,c){
            !Ext || Ext.MessageBox.alert('错误码:'+a.status,'操作异常');
        }
    });
});

function  parseJSON( str ){
    if( typeof JSON === 'undefined'){
        return (new Function("return " + str))();
    }else{
        return JSON.parse( str );
    }
}
</script>
