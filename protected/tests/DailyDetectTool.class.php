<?php
/**
 * 日常维护工具类
 * @version 1.0
 * @author qing.m
 * @since 2010-08-03
 */
class DailyDetectTool{

    /**
     * excel文件对应的列
     */
    const COMPANY_NAME_COLS = 0;
    const STATUS_COLS = 1;
    const TYPE_COLS = 2;
    const GUIDE_MARK_COLS = 3;
    const MAIN_DOMAIN_COLS = 4;
    const RESERVER_DOMAIN_COLS = 5;
    const MAIN_FIRST_IP_COLS = 6;
    const MAIN_SECOND_IP_COLS = 7;
    const MAIN_THREE_IP_COLS = 8;
    const MAIN_FOUR_IP_COLS = 9;
    const MAIN_FIVE_IP_COLS = 10;
    const MAIN_SIX_IP_COLS = 11;
    const MAIN_SEVEN_IP_COLS = 12;
    const MAIN_EIGHT_IP_COLS = 13;
    const MAIN_NINE_IP_COLS = 14;
    const RESERVER_FIRST_IP_COLS = 15;
    const RESERVER_SECOND_IP_COLS = 16;
    const RESERVER_THREE_IP_COLS = 17;
    const RESERVER_FOUR_IP_COLS = 18;
    const RESERVER_FIVE_IP_COLS = 19;
    const RESERVER_SIX_IP_COLS = 20;
    const GROUP_COLS = 21;
    const DATABASE_NAME_COLS = 22;
    const DATABASE_NAME_INSTANCE_COLS = 23;
    const ONLINE_COLS = 24;
    const COMMET_SERVICE_COLS = 25;
    const START_PAY_COLS = 26;
    const PROJECT_NAME_COLS = 27;
    const USED_COMPANY_NAME_COLS = 28;
    /**
     * 前后台标识
     */
    const BACKEND = '后台';
    const FRONTEND = '前台';
    /**
     * 代理标识
     */
    const AGENT = ture;
    const MEMBER_NOTE = '会员';
    const AGENT_NOTE = '代理';
    /**
     * 登录页标识
     */
    const MEMBER_FLAG = 'f';
    const COMPANY_FLAG = 'c';
    const AGENT_FLAG = 'a';
    /**
     * 登录页后缀
     */
    const MEMBER_SUFFIX = '/user/login.htm';
    const COMPANY_SUFFIX = '/account/login.htm';
    const AGENT_SUFFIX = '/account/login.htm';
    const JOCKEYSTAR_SUFFIX = '/Login.aspx';
    /**
     * 线路名称
     */
    const LINE_FIRST = '线路一';
    const LINE_SECOND = '线路二';
    const LINE_THREE = '线路三';
    const LINE_FOUR = '线路四';
    const LINE_FIVE = '线路五';
    const LINE_SIX = '线路六';
    const LINE_SEVEN = '线路七';
    const LINE_EIGHT = '线路八';
    const LINE_NINE = '线路九';
    const LINE_FIRST_JOCKEYSTAR = '线路1';
    const LINE_SECOND_JOCKEYSTAR = '线路2';
    const LINE_THREE_JOCKEYSTAR = '线路3';
    const LINE_FOUR_JOCKEYSTAR = '线路4';
    const LINE_FIVE_JOCKEYSTAR = '线路5';
    /**
     * 主备线路标识
     */
    const MAIN = 'main';
    const RESERVER = 'reserver';
    /**
     * 线路排序
     */
    const FIRST = 1;
    const SECOND = 2;
    const THREE = 3;
    const FOUR = 4;
    const FIVE = 5;
    const SIX = 6;
    const SEVEN = 7;
    const EIGHT = 8;
    const NINE = 9;
    /**
     * 记录消息分隔符
     */
    const SEPARATOR = '|';
    const ERROR_SEPARATOR_START = "[";
    const ERROR_SEPARATOR_END = "]";
    /**
     * 备用线路引导标识
     */
    const RESERVER_GUIDE_FLAG = 'b';
    /**
     * 隐藏线路引导标识
     */
    const HIDE_GUIDE_FLAG = 'c';
    /**
     * 标题后缀
     */
    const TITLE_SUFFIX = '导航';
    /**
     * 暂停服务说明文字
     */
   const NOT_SERVICE_NOTE = '此公司网站暂时不提供服务，请联系管理员。';
    /**
     * 标题分隔符
     */
    const TITLE_FLAG = '-';
    const IS_NULL = "&nbsp; ";
    /**
     * 清洗IP
     */
    const CLEAR_IP_ONE = '114.141.73';
    const CLEAR_IP_TWO = '208.64.126';
    const CLEAR_IP_THREE = '208.64.121';
    const CLEAR_IP_FOUR = '173.255.210';
    /**
     * 测试没有检测
     */
    const TEST_DOMAIN = "9826.us";
    const JS_TEST_NAME = 'JS测试';
    /**
     * 项目名称
     */
    const PROJECT_BBTP = '交易';
    const PROJECT_JOCKEYSTAR = '赛马';
    const PROJECT_MAKSIX = '六彩';
    /**
     * 集群
     */
    const GROUP_ONE = '集群1';
    const GROUP_TWO = '集群2';
    /**
     * 集群二CPS IP
     */
    const GROUP_TWO_CPS_IP = '218.189.17.26';
    /**
     * 计数器
     */
    private $num = 0;
    /**
     * 重复请求次数
     */
    private $request_time = 0;
    /**
     * 设置file_get_contents请求超时时间
     */
    private $opts = array(
                         'http'=>array(
                                      'method'=>"GET",
                                      'timeout'=>10,
                                      )
                         );
    /**
     * 设置curl请求超时时间
     */
     private $time_out = 12;
    /**
     * stream context
     */
    private $context = '';
    /**
     * 是否存在错误信息
     */
    private $is_exist_error = false;
    /**
     * 是否是集群二
     */
    private $is_group_two = false;
    /**
     * 检测成功返回信息
     */
    private $success_message = "检测正常";
    /**
     * 返回数据
     */
    private $data = array();
    /**
     * 错误信息
     */
    private $message_info = '';
    /**
     * 匹配URL
     */
    //private $url_str = '/http\:\/\/([a-z0-9]+\.)?\d{4}\.(us|com)\/(.*?)\.htm/';
    //private $url_str = '/http\:\/\/([a-z0-9]+\.)(.*?)\.(us|com)\/(.*?)\.htm/';
    private $url_str = "/^[a-zA-Z]+[:\/\/]+[A-Za-z0-9\-_]+\\.+[A-Za-z0-9\.\/%&=\?\-_]+$/i";
    /**
     * 定义错误类型
     */
    private $message = array("0"=>"主引导页面公司名称错误",
                             "1"=>"备用引导页面公司名称错误",
                             "2"=>"备用隐藏域名IP指向错误",
                             "3"=>"备隐藏线路地址指向错误",
                             "4"=>"备隐藏代理线路登录页面公司名称错误",
                             "5"=>"主线路与IP不匹配",
                             "6"=>"当前页面访问失败",
                             "7"=>"引导页上存在一个不符合命名规律的线路名称",
                             "8"=>"获取当前域名指向IP失败",
                             "9"=>"引导标识不匹配",
                             "10"=>"当前域名访问失败",
                             "11"=>"当前URL验证失败",
                             "12"=>"CPS域名IP指向错误",
                             "13"=>"备隐藏会员线路登录页面公司名称错误",
                             "14"=>"访问当前CPS失败",

                             "101"=>"主1域名IP指向错误",
                             "102"=>"主2域名IP指向错误",
                             "103"=>"主3域名IP指向错误",
                             "104"=>"主4域名IP指向错误",
                             "105"=>"主5域名IP指向错误",
                             "106"=>"主6域名IP指向错误",
                             "107"=>"主7域名IP指向错误",
                             "108"=>"主8域名IP指向错误",
                             "109"=>"主9域名IP指向错误",
                             "110"=>"主10域名IP指向错误",

                             "201"=>"备1域名IP指向错误",
                             "202"=>"备2域名IP指向错误",
                             "203"=>"备3域名IP指向错误",
                             "204"=>"备4域名IP指向错误",
                             "205"=>"备5域名IP指向错误",
                             "206"=>"备6域名IP指向错误",
                             "207"=>"备7域名IP指向错误",
                             "208"=>"备8域名IP指向错误",
                             "209"=>"备9域名IP指向错误",
                             "210"=>"备10域名IP指向错误",

                             "301"=>"主引导页面线路1指向错误",
                             "302"=>"主引导页面线路2指向错误",
                             "303"=>"主引导页面线路3指向错误",
                             "304"=>"主引导页面线路4指向错误",
                             "305"=>"主引导页面线路5指向错误",
                             "306"=>"主引导页面线路6指向错误",
                             "307"=>"主引导页面线路7指向错误",
                             "308"=>"主引导页面线路8指向错误",
                             "309"=>"主引导页面线路9指向错误",
                             "310"=>"主引导页面线路10指向错误",

                             "401"=>"备引导页面线路1指向错误",
                             "402"=>"备引导页面线路2指向错误",
                             "403"=>"备引导页面线路3指向错误",
                             "404"=>"备引导页面线路4指向错误",
                             "405"=>"备引导页面线路5指向错误",
                             "406"=>"备引导页面线路6指向错误",
                             "407"=>"备引导页面线路7指向错误",
                             "408"=>"备引导页面线路8指向错误",
                             "409"=>"备引导页面线路9指向错误",
                             "410"=>"备引导页面线路10指向错误",

                             "501"=>"主线路1登录页面公司名称错误",
                             "502"=>"主线路2登录页面公司名称错误",
                             "503"=>"主线路3登录页面公司名称错误",
                             "504"=>"主线路4登录页面公司名称错误",
                             "505"=>"主线路5登录页面公司名称错误",
                             "506"=>"主线路6登录页面公司名称错误",
                             "507"=>"主线路7登录页面公司名称错误",
                             "508"=>"主线路8登录页面公司名称错误",
                             "509"=>"主线路9登录页面公司名称错误",
                             "510"=>"主线路10登录页面公司名称错误",

                             "601"=>"备线路1登录页面公司名称错误",
                             "602"=>"备线路2登录页面公司名称错误",
                             "603"=>"备线路3登录页面公司名称错误",
                             "604"=>"备线路4登录页面公司名称错误",
                             "605"=>"备线路5登录页面公司名称错误",
                             "606"=>"备线路6登录页面公司名称错误",
                             "607"=>"备线路7登录页面公司名称错误",
                             "608"=>"备线路8登录页面公司名称错误",
                             "609"=>"备线路9登录页面公司名称错误",
                             "610"=>"备线路10登录页面公司名称错误"
                             );
    /**
     * 记录字段信息
     */
    private $field = array();
    /**
     * 要读取的excel文件
     */
    private $xls ="";
    /**
     * 邮件列表
     */
    private $email = "";
    /**
     * 主机IP
     */
    private $hostIp = '192.168.1.135';
    /**
     * CPS标识
     */
    private $cps = true;
    /**
     * CPS对应数组
     */
    private $cps_arr = array(
                   '218.189.17'=>'218.189.28.226',
                   '218.189.28'=>'218.189.28.226',
                   '63.221.84'=>'63.221.84.136',
                   '203.78.182'=>'203.78.182.126',
                   '202.153.19'=>'202.153.195.77',
                   '218.32.216'=>'218.32.216.16',
                   '218.32.217'=>'218.32.216.16',
                   '218.32.53'=>'218.32.216.16',
                   '114.141.73'=>'218.32.216.16',
                   '208.64.126'=>'218.32.216.16',
                   '208.64.121'=>'218.32.216.16',
                   '173.255.21'=>'218.32.216.16',
                   '218.32.58' =>'218.32.216.16',
                   '208.64.123'=>'218.32.216.16'
    );

    /**
     * 设置数据源
     * @param string $xls
     * @param string $email
     */
    public function setParams($xls,$email){
        $this->xls = $xls;
        $this->email = $email;
    }
    /**
     * 读取excel 返回数据源
     * return array
     */
    public function DailyDetectToolCore(){
        //date_default_timezone_set("PRC");
        $begin = time();
        $date = date("Y-m-d");
        $start_time = date("H:i:s");
        $this->context = stream_context_create($this->opts);
        require_once 'Classes/PHPExcel/IOFactory.php';
        if (!file_exists($this->xls)) {
            exit("co_info.xls不存在.<br />");
        }
        $reader = new PHPExcel_Reader_Excel5();
        //$reader = new PHPExcel_Reader_Excel2007();
        $reader->setReadDataOnly(true);
        $reader->setLoadSheetsOnly(array("公司"));
        $PHPExcel = $reader->load($this->xls);
        $return = $PHPExcel->getSheetByName("公司")->toArray();
        /*******************excel中时间数据处理方式**************************** *******/
        /********           $value = $return[2][0]; 当前单元格时间数据项 *******/
        /********           date_default_timezone_set('PRC');  设置时区 *******/
        /********           $value=gmdate("Y-m-d H:i:s", PHPExcel_Shared_Date::ExcelToPHP($value));  格式化为Ymd His  *******/
        //require_once "Excel/reader.php";
        require_once "mail/class.phpmailer.php";//调用
        //$data = new Spreadsheet_Excel_Reader();
        //$data->setRowColOffset(0);
        //$data->setOutputEncoding('UTF-8');
        //$data->read($this->xls);
        //$return = $data->sheets[0][cells];print_r($return);exit;
        $sum = count($return);
        $companyArr = array();
        for ($i=1;$i<$sum+1;$i++){
            if($i > 1){
                //屏蔽测试公司和晨检环境
                if(strpos($return[$i][DailyDetectTool::COMPANY_NAME_COLS],'晨检') !== false || strpos($return[$i][DailyDetectTool::COMPANY_NAME_COLS],'测试') !== false || trim($return[$i][DailyDetectTool::COMPANY_NAME_COLS]) == '新中原'){
                    continue;
                }
                if(!empty($return[$i][DailyDetectTool::COMPANY_NAME_COLS]) && (trim($return[$i][DailyDetectTool::GROUP_COLS]) == DailyDetectTool::GROUP_ONE || trim($return[$i][DailyDetectTool::GROUP_COLS]) == DailyDetectTool::GROUP_TWO)){
                    //错误信息
                    $this->message_info = $return[$i][DailyDetectTool::COMPANY_NAME_COLS] . DailyDetectTool::SEPARATOR .
                                          $return[$i][DailyDetectTool::TYPE_COLS] . DailyDetectTool::SEPARATOR .
                                          $return[$i][DailyDetectTool::GUIDE_MARK_COLS] . DailyDetectTool::SEPARATOR .
                                          $return[$i][DailyDetectTool::MAIN_DOMAIN_COLS] . DailyDetectTool::SEPARATOR .
                                          $return[$i][DailyDetectTool::RESERVER_DOMAIN_COLS] . DailyDetectTool::SEPARATOR .
                                          $return[$i][DailyDetectTool::GROUP_COLS] . DailyDetectTool::SEPARATOR;
                    //统计检测公司数量
                    if(!in_array($return[$i][DailyDetectTool::COMPANY_NAME_COLS], $companyArr)){
                        array_push($companyArr, $return[$i][DailyDetectTool::COMPANY_NAME_COLS]);
                    }
                    //六合彩测试没有检测  备用域名为空没有检测
                    if(DailyDetectTool::TEST_DOMAIN != $return[$i][DailyDetectTool::MAIN_DOMAIN_COLS] && !empty($return[$i][DailyDetectTool::MAIN_DOMAIN_COLS])){
                            $this->getDomain($return[$i]);
                            $this->checkDomain($return[$i]);
                            $main_content = $this->checkTitle($this->field['main_domain_first'], $return[$i][DailyDetectTool::GUIDE_MARK_COLS],$return[$i][DailyDetectTool::COMPANY_NAME_COLS], true);
                            //屏蔽备用线路和隐藏线路检查
                            if(false && !empty($return[$i][DailyDetectTool::RESERVER_DOMAIN_COLS])){
                                $reserver_content = $this->checkTitle($return[$i][DailyDetectTool::RESERVER_DOMAIN_COLS], $return[$i][DailyDetectTool::GUIDE_MARK_COLS],$return[$i][DailyDetectTool::COMPANY_NAME_COLS], false);
                            }else{
                                $reserver_content = false;
                            }
                            $this->checkLine($main_content,$return[$i],$reserver_content);
                        if($this->is_exist_error){
                            $this->is_exist_error = false;
                        }else{
                            array_push($this->data, $this->message_info . $this->success_message . DailyDetectTool::SEPARATOR . DailyDetectTool::IS_NULL . DailyDetectTool::SEPARATOR . DailyDetectTool::IS_NULL);
                        }
                    }
                    $project_name = '';
                    //交易平台
                    /*if($return[$i][DailyDetectTool::PROJECT_NAME_COLS] == DailyDetectTool::PROJECT_BBTP){
                        $project_name = 'bbtp';
                    }
                    //赛马
                    if($return[$i][DailyDetectTool::PROJECT_NAME_COLS] == DailyDetectTool::PROJECT_JOCKEYSTAR){
                        $project_name = 'jockeystar';
                    }
                    if(false === strpos($return[$i][DailyDetectTool::COMPANY_NAME_COLS], DailyDetectTool::JS_TEST_NAME)){
                        switch ($project_name) {
                            case 'bbtp':
                                $this->checkBBTP($return[$i]);
                                if($this->is_exist_error){
                                    $this->is_exist_error = false;
                                }else{
                                    array_push($this->data, $this->message_info . $this->success_message . DailyDetectTool::SEPARATOR . DailyDetectTool::IS_NULL . DailyDetectTool::SEPARATOR . DailyDetectTool::IS_NULL);
                                }
                            break;
                            case 'jockeystar':
                                $this->checkJockeyStar($return[$i]);
                                if($this->is_exist_error){
                                    $this->is_exist_error = false;
                                }else{
                                    array_push($this->data, $this->message_info . $this->success_message . DailyDetectTool::SEPARATOR . DailyDetectTool::IS_NULL . DailyDetectTool::SEPARATOR . DailyDetectTool::IS_NULL);
                                }
                            break;
                        }
                    }*/
                }
            }else{
                Common::log_write('Excel read successful!');
                //获取域名前缀
                $this->field['main_domain_first_prefix'] = $this->getDomainSuffix($return[$i][DailyDetectTool::MAIN_FIRST_IP_COLS]);
                $this->field['main_domain_second_prefix'] = $this->getDomainSuffix($return[$i][DailyDetectTool::MAIN_SECOND_IP_COLS]);
                $this->field['main_domain_three_prefix'] = $this->getDomainSuffix($return[$i][DailyDetectTool::MAIN_THREE_IP_COLS]);
                $this->field['main_domain_four_prefix'] = $this->getDomainSuffix($return[$i][DailyDetectTool::MAIN_FOUR_IP_COLS]);
                $this->field['main_domain_five_prefix'] = $this->getDomainSuffix($return[$i][DailyDetectTool::MAIN_FIVE_IP_COLS]);
                $this->field['main_domain_six_prefix'] = $this->getDomainSuffix($return[$i][DailyDetectTool::MAIN_SIX_IP_COLS]);
                $this->field['main_domain_seven_prefix'] = $this->getDomainSuffix($return[$i][DailyDetectTool::MAIN_SEVEN_IP_COLS]);
                $this->field['main_domain_eight_prefix'] = $this->getDomainSuffix($return[$i][DailyDetectTool::MAIN_EIGHT_IP_COLS]);
                $this->field['main_domain_nine_prefix'] = $this->getDomainSuffix($return[$i][DailyDetectTool::MAIN_NINE_IP_COLS]);
                $this->field['reserver_domain_first_prefix'] = $this->getDomainSuffix($return[$i][DailyDetectTool::RESERVER_FIRST_IP_COLS]);
                $this->field['reserver_domain_hide_prefix'] = $this->getDomainSuffix($return[$i][DailyDetectTool::RESERVER_SIX_IP_COLS]);
            }
        }
        //检测异常  EMAIL发送异常数据 并生成HTML
        $end_time = date("H:i:s");
        $error = 0;
        if(count($this->data)){
            $str = '<br/><table class="table_border"><tr><td>序号</td><td>公司名称</td><td>前后台</td><td>引导标识</td>
                    <td>主域名</td><td>备域名</td><td>集群</td><td>检测结果</td></tr>';
            foreach($this->data as $key=>$value){
                $html_content = '';
                $valueArr = explode(DailyDetectTool::SEPARATOR, $value,7);
                $error_flag = false;
                foreach($valueArr as $k=>$v){
                    $v = empty($v) ? DailyDetectTool::IS_NULL : $v;
                    if(6 == $k){
                        $v = preg_replace('/(\t|\n|\r)/',' ',$v);
                        if(strpos($v, $this->success_message) === false){
                        //if($vArr[0] != $this->success_message){
                            $vArr = explode(DailyDetectTool::SEPARATOR, $v);
                            $error++;
                            $error_flag = true;
                            $desc = ($vArr[1] == DailyDetectTool::IS_NULL) ? '' : "&nbsp;当前值：" . $vArr[1];
                            $desc .= ($vArr[2] == DailyDetectTool::IS_NULL || empty($vArr[2])) ? '' : "&nbsp;预期值：" . $vArr[2];
                            $html_content .= "<td class='tdbg'>" . $vArr[0] . $desc . "</td>";
                        }else{
                            $v = str_replace('|', '', $v);
                            $html_content .= "<td>" . $v . "</td>";
                        }
                    }else{
                        $html_content .= "<td>" . $v . "</td>";
                    }
                }
                $number = $key+1;
                if($error_flag){
                    $html_content_error .= "<tr><td>" . $number . "</td>" . $html_content . "</tr>";
                }
                $html_content_all .= "<tr><td>" . $number . "</td>" . $html_content . "</tr>";
            }
        }
        $html_content_all = $str . $html_content_all . "</table>";
        $info = empty($error) ? 'OK' : 'Err：'.$error;
        $end = time();
        $diff = $end-$begin;
        $diffhour  = (int)($diff/3600);
        $diffminute = (int)(($diff-$diffhour*3600)/60);
        $diffsecond = $diff-$diffhour*3600-$diffminute*60;
        $execute_time = empty($diffhour) ? $diffminute . "分" . $diffsecond . "秒" : $diffhour . "时" .
                        $diffminute . "分" . $diffsecond . "秒";
        try{
            $host_ip = Common::getOnlineIP();   //主机IP
        }catch (Exception $e) {
            Common::log_write($e->getMessage());
            $host_ip = '127.0.0.1';       //主机IP
        }
        $check_point = "<br/> 检查点:
<br/> 1. 域名对应IP是否一致。
<br/> 2. 域名对应IP所分配的集群是否正确。
<br/> 3. 访问域名后转向的引导页是否能正常访问并且页面文件名称是否与引导标识一致。（第1次请求页面）
<br/> 4. 检查CPS是否能正常访问。（第2次请求页面）
<br/> 5. 访问域名后转向的引导页页面标题是否与公司名称一致。（第3次请求页面）
<br/> 6. 访问域名后转向的引导页中的线路布局，及每个线路的链接是否与要求的一致。（第3次请求页面）
<br/> 7. 域名对应线路的登录页是否能正常访问并且登录页的标题是否与公司名称一致。（第4次请求页面）
<br/> 每个检查点的检查顺序:
<br/> a. 后台【主1~7】
<br/> b. 后台【备1~6】
<br/> c. 前台【主1~7】
<br/> d. 前台【备1~6】
<br/> e. 前台【备隐藏线路7】";
        $html_content = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" " http://www.w3.org/TR/html4/strict.dtd">
<html><title>网站检测报告（' . $info . '）' .$date . ' ' . $start_time . '</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
body,table,tr,td{
    font-family: "宋体";
    font-size: 10pt;
}
.tdbg{
    background-color:#FFFFC4;
    color:#FF0000;
}
.table_border td{
    border:1px #DDD solid;
}
.table_border{
    border:1px #DDD solid;
}
</style>
<body>
<br/> <center><span>网站检测报告</span></center>
<br/> 公司总数/错误数：' . count($companyArr) . '/' . $error . '
<br/> 检测时间：' . $date . '&nbsp;' . $start_time .'
<br/> 检测耗时：' .$execute_time . '
<br/> 执行检测的主机：' . $host_ip;
        if(isset($html_content_error)){
            $html_content_error = $str . $html_content_error . "</table>";
            $html_content = $html_content . "<br/><br/> 错误信息：" . $html_content_error . "<br/><hr>
                            <br/> 完整报告：" . $html_content_all . $check_point . "</body></html>";
        }else{
            $html_content = $html_content . "<br/> 错误信息：无<hr>
                            <br/> 完整报告：" . $html_content_all . $check_point . "</body></html>";
        }
        $file_name = $this->makeHtml($html_content);
        $this->sendEmail($html_content,$start_time,$date,$info,$file_name);
        unset($this->data);
        unset($this->field);
        unset($this->message);
    }
    /**
     * 组装域名
     * @param array $record
     */
    private function getDomain($record){
        Common::log_write("get Domain start ! ");
        $this->field['main_domain_first'] = empty($record[DailyDetectTool::MAIN_FIRST_IP_COLS]) ? '' : $this->field['main_domain_first_prefix'] . "." . $record[DailyDetectTool::MAIN_DOMAIN_COLS];
        $this->field['main_domain_second'] = empty($record[DailyDetectTool::MAIN_SECOND_IP_COLS]) ? '' : $this->field['main_domain_second_prefix'] . "." . $record[DailyDetectTool::MAIN_DOMAIN_COLS];
        $this->field['main_domain_three'] = empty($record[DailyDetectTool::MAIN_THREE_IP_COLS]) ? '' : $this->field['main_domain_three_prefix'] . "." . $record[DailyDetectTool::MAIN_DOMAIN_COLS];
        $this->field['main_domain_four'] = empty($record[DailyDetectTool::MAIN_FOUR_IP_COLS]) ? '' : $this->field['main_domain_four_prefix'] . "." . $record[DailyDetectTool::MAIN_DOMAIN_COLS];
        $this->field['main_domain_five'] = empty($record[DailyDetectTool::MAIN_FIVE_IP_COLS]) ? '' : $this->field['main_domain_five_prefix'] . "." . $record[DailyDetectTool::MAIN_DOMAIN_COLS];
        $this->field['main_domain_six'] = empty($record[DailyDetectTool::MAIN_SIX_IP_COLS]) ? '' : $this->field['main_domain_six_prefix'] . "." . $record[DailyDetectTool::MAIN_DOMAIN_COLS];
        $this->field['main_domain_seven'] = empty($record[DailyDetectTool::MAIN_SEVEN_IP_COLS]) ? '' : $this->field['main_domain_seven_prefix'] . "." . $record[DailyDetectTool::MAIN_DOMAIN_COLS];
        $this->field['main_domain_eight'] = empty($record[DailyDetectTool::MAIN_EIGHT_IP_COLS]) ? '' : $this->field['main_domain_eight_prefix'] . "." . $record[DailyDetectTool::MAIN_DOMAIN_COLS];
        $this->field['main_domain_nine'] = empty($record[DailyDetectTool::MAIN_NINE_IP_COLS]) ? '' : $this->field['main_domain_nine_prefix'] . "." . $record[DailyDetectTool::MAIN_DOMAIN_COLS];
        $this->field['reserver_domain_hide'] = empty($record[DailyDetectTool::RESERVER_SIX_IP_COLS]) ? '' : $this->field['reserver_domain_hide_prefix'] . "." . $record[DailyDetectTool::RESERVER_DOMAIN_COLS];
        Common::log_write("main_domain_first is " . $this->field['main_domain_first']);
        Common::log_write("main_domain_second is " . $this->field['main_domain_second']);
        Common::log_write("main_domain_three is " . $this->field['main_domain_three']);
        Common::log_write("main_domain_four is " . $this->field['main_domain_four']);
        Common::log_write("main_domain_five is " . $this->field['main_domain_five']);
        Common::log_write("main_domain_six is " . $this->field['main_domain_six']);
        Common::log_write("main_domain_seven is " . $this->field['main_domain_seven']);
        Common::log_write("main_domain_eight is " . $this->field['main_domain_eight']);
        Common::log_write("main_domain_nine is " . $this->field['main_domain_nine']);
        Common::log_write("reserver_domain_hide is " . $this->field['reserver_domain_hide']);
        Common::log_write("get Domain end ! ");
    }
    /**
     * 检测域名IP对应关系
     * @param array $record 记录
     */
    private function checkDomain($record){
        Common::log_write("check Domain start ! ");
        //检测重定向后引导标识是否正确
        if(!empty($record[DailyDetectTool::MAIN_DOMAIN_COLS])){
            $main_url = $this->field['main_domain_first'];
            $flag = $this->checkPageRedirect($main_url, $record[DailyDetectTool::GUIDE_MARK_COLS]);
            if($flag){
                //解析域名对应IP
                $this->matchDomainIp($record[DailyDetectTool::GROUP_COLS],$this->message[101],$this->field['main_domain_first'],$record[DailyDetectTool::MAIN_FIRST_IP_COLS]);
                $this->matchDomainIp($record[DailyDetectTool::GROUP_COLS],$this->message[102],$this->field['main_domain_second'],$record[DailyDetectTool::MAIN_SECOND_IP_COLS]);
                $this->matchDomainIp($record[DailyDetectTool::GROUP_COLS],$this->message[103],$this->field['main_domain_three'],$record[DailyDetectTool::MAIN_THREE_IP_COLS]);
                $this->matchDomainIp($record[DailyDetectTool::GROUP_COLS],$this->message[104],$this->field['main_domain_four'],$record[DailyDetectTool::MAIN_FOUR_IP_COLS]);
                $this->matchDomainIp($record[DailyDetectTool::GROUP_COLS],$this->message[105],$this->field['main_domain_five'],$record[DailyDetectTool::MAIN_FIVE_IP_COLS]);
                $this->matchDomainIp($record[DailyDetectTool::GROUP_COLS],$this->message[106],$this->field['main_domain_six'],$record[DailyDetectTool::MAIN_SIX_IP_COLS]);
                $this->matchDomainIp($record[DailyDetectTool::GROUP_COLS],$this->message[107],$this->field['main_domain_seven'],$record[DailyDetectTool::MAIN_SEVEN_IP_COLS]);
                //$this->matchDomainIp($record[DailyDetectTool::GROUP_COLS],$this->message[109],$this->field['main_domain_nine'],$record[DailyDetectTool::MAIN_NINE_IP_COLS]);
            }
        }
        //屏蔽备用域名检查
        if(false && !empty($record[DailyDetectTool::RESERVER_DOMAIN_COLS])){
            $reserver_url = "http://" . $record[DailyDetectTool::RESERVER_DOMAIN_COLS];
            //备用域名不检查重定向后引导页标识
            $flag = $this->checkPageRedirect($reserver_url, DailyDetectTool::RESERVER_GUIDE_FLAG . $record[DailyDetectTool::GUIDE_MARK_COLS]);
            if($flag){
                //解析域名对应IP
                $this->matchDomainIp($record[DailyDetectTool::GROUP_COLS],$this->message[201],$record[DailyDetectTool::RESERVER_DOMAIN_COLS],$record[DailyDetectTool::RESERVER_FISRT_IP_COLS]);
                $this->matchDomainIp($record[DailyDetectTool::GROUP_COLS],$this->message[2],$this->field['reserver_domain_hide'],$record[DailyDetectTool::RESERVER_SIX_IP_COLS]);
            }
        }
        Common::log_write("check Domain end ! ");
    }
    /**
     * 检测引导页面公司名称
     * @param string $domain 域名
     * @param boolean $guide_mark 引导标识
     * @param string $company 公司
     * @param boolean $flag 主备标识
     * @return string $content 页面内容
     */
    private function checkTitle($domain,$guide_mark,$company,$flag){
        Common::log_write('check Title start! url is : '.$domain);
        Common::log_write("guide_mark is : ".$guide_mark);
        //检测引导页面公司名称
        if($flag){//主
            $str_message = $this->message[0];
        }else{//备
            //备用域名不检查引导页标题
            $str_message = $this->message[1];
            $guide_mark = DailyDetectTool::RESERVER_GUIDE_FLAG . $guide_mark;
        }
        $url = "http://" . $domain . "/" . $guide_mark . ".htm";
        $content = '';
        if(preg_match($this->url_str, $url)){
            Common::log_write('preg_match url true: '.$url);
            $content = $this->getPageContent($url);
            if($content){
                Common::log_write('get page content true:'.$url);
                //preg_match('/<title>(.*)<\/title>/is',$content,$match);
                //$title_arr = explode(DailyDetectTool::TITLE_FLAG, $match[1]);
                //$title = str_replace(DailyDetectTool::TITLE_SUFFIX, "", $title_arr[1]);
                preg_match('/<title>线路选择-(.*)导航-(.*)<\/title>/is',$content,$match);
                Common::log_write("title is : ".$match[1]);
                if($match[1] != $company){
                    array_push($this->data,$this->message_info. $str_message . DailyDetectTool::ERROR_SEPARATOR_START .$url . DailyDetectTool::ERROR_SEPARATOR_END . DailyDetectTool::SEPARATOR . $match[1] . DailyDetectTool::SEPARATOR . $company);
                    $this->is_exist_error = true;
                }
            }else{
                Common::log_write('get page content false:'.$url);
                array_push($this->data, $this->message_info . $this->message[6] . DailyDetectTool::SEPARATOR . $url . DailyDetectTool::SEPARATOR . DailyDetectTool::IS_NULL);
                $this->is_exist_error = true;
            }
        }else{
            Common::log_write('preg_match url false: '.$url);
            array_push($this->data, $this->message_info . $this->message[11] . DailyDetectTool::SEPARATOR . $url . DailyDetectTool::SEPARATOR . DailyDetectTool::IS_NULL);
            $this->is_exist_error = true;
        }
        Common::log_write("check Title end ! ");
        return $content;
    }
    /**
     * 检测线路
     * @param array $record 记录
     * @param string $main_content 主页面内容
     * @param string $reservse_content 备用引导页面内容
     */
    private function checkLine($main_content,$record,$reserver_content){
        Common::log_write("check Line Start ! ");
        $main_line_first = $this->getLineUrl($record,DailyDetectTool::FIRST,$record[DailyDetectTool::TYPE_COLS],DailyDetectTool::MAIN);
        $main_line_second = $this->getLineUrl($record,DailyDetectTool::SECOND,$record[DailyDetectTool::TYPE_COLS],DailyDetectTool::MAIN);
        $main_line_three = $this->getLineUrl($record,DailyDetectTool::THREE,$record[DailyDetectTool::TYPE_COLS],DailyDetectTool::MAIN);
        $main_line_four = $this->getLineUrl($record,DailyDetectTool::FOUR,$record[DailyDetectTool::TYPE_COLS],DailyDetectTool::MAIN);
        $main_line_five = $this->getLineUrl($record,DailyDetectTool::FIVE,$record[DailyDetectTool::TYPE_COLS],DailyDetectTool::MAIN);
        $main_line_six = $this->getLineUrl($record,DailyDetectTool::SIX,$record[DailyDetectTool::TYPE_COLS],DailyDetectTool::MAIN);
        $main_line_seven = $this->getLineUrl($record,DailyDetectTool::SEVEN,$record[DailyDetectTool::TYPE_COLS],DailyDetectTool::MAIN);
        $main_line_eight = $this->getLineUrl($record,DailyDetectTool::EIGHT,$record[DailyDetectTool::TYPE_COLS],DailyDetectTool::MAIN);
        $main_line_nine = $this->getLineUrl($record,DailyDetectTool::NINE,$record[DailyDetectTool::TYPE_COLS],DailyDetectTool::MAIN);
        //屏蔽备用域名线路组装
        //$reserver_line_first = $this->getLineUrl($record,DailyDetectTool::FIRST,$record[DailyDetectTool::TYPE_COLS],DailyDetectTool::RESERVER);
        //$reserver_line_second = $this->getLineUrl($record,DailyDetectTool::SECOND,$record[DailyDetectTool::TYPE_COLS],DailyDetectTool::RESERVER);
        //$reserver_line_three = $this->getLineUrl($record,DailyDetectTool::THREE,$record[DailyDetectTool::TYPE_COLS],DailyDetectTool::RESERVER);
        //$reserver_line_four = $this->getLineUrl($record,DailyDetectTool::FOUR,$record[DailyDetectTool::TYPE_COLS],DailyDetectTool::RESERVER);
        //$reserver_line_five = $this->getLineUrl($record,DailyDetectTool::FIVE,$record[DailyDetectTool::TYPE_COLS],DailyDetectTool::RESERVER);
        //后台
        if($record[DailyDetectTool::TYPE_COLS] == DailyDetectTool::BACKEND){
            Common::log_write("check Line BACKEND Start ! ");
            if($main_content){//主引导页面
                Common::log_write("check Line BACKEND MAIN Start ! ");
                preg_match_all('/href\="(.*?)\<\/a\>/',$main_content,$main_match);
                $this->checkLineDetail(DailyDetectTool::BACKEND,DailyDetectTool::MAIN,$main_match[1],$main_line_first,$main_line_second,$main_line_three,$main_line_four,$main_line_five,$main_line_six,$main_line_seven,$main_line_eight,$main_line_nine);
                Common::log_write("check Line BACKEND MAIN end ! ");
            }
            if($reserver_content){//备引导页面
                Common::log_write("check Line BACKEND RESERVER Start ! ");
                preg_match_all('/href\="(.*?)\<\/a\>/',$reserver_content,$reserver_match);
                $this->checkLineDetail(DailyDetectTool::BACKEND,DailyDetectTool::RESERVER,$reserver_match[1],$reserver_line_first,$reserver_line_second,$reserver_line_three,$reserver_line_four,$reserver_line_five);
                Common::log_write("check Line BACKEND RESERVER end ! ");
            }
            Common::log_write("check Line BACKEND end ! ");
        }else{//前台
            Common::log_write("check Line FRONTEND Start ! ");
            if($main_content){
                //主引导页面会员线路检测
                Common::log_write("check Line FRONTEND MAIN MEMBER Start ! ");
                $main_str = preg_replace('/(\t|\n|\r)/','',$main_content);
                //preg_match_all('/<\/h2>(.*?)<p>/',$main_str,$main_arr);
                //preg_match_all('/href\="(.*?)<\/a>/',$main_arr[1][0],$main_user_match);
                preg_match_all('/<span>会员<\/span>(.*?)class="fl fir"/',$main_str,$main_arr_user);//匹配会员线路
                preg_match_all('/href\="(.*?)<\/a>/',$main_arr_user[1][0],$main_user_match);
                //preg_match_all('/<\/h2>(.*?)class="fl fir"/',$main_str,$main_arr_user);//匹配会员线路
                $this->checkLineDetail(DailyDetectTool::FRONTEND,DailyDetectTool::MAIN,$main_user_match[1],$main_line_first,$main_line_second,$main_line_three,$main_line_four,$main_line_five,$main_line_six,$main_line_seven,$main_line_eight,$main_line_nine,DailyDetectTool::MEMBER_NOTE);
                Common::log_write("check Line FRONTEND MAIN MEMBER end ! ");
                //主引导页面代理线路检测
                Common::log_write("check Line FRONTEND MAIN AGENT start ! ");
                $main_agent_line_first = $this->getLineUrl($record,DailyDetectTool::FIRST,$record[DailyDetectTool::TYPE_COLS],DailyDetectTool::MAIN,DailyDetectTool::AGENT);
                $main_agent_line_second = $this->getLineUrl($record,DailyDetectTool::SECOND,$record[DailyDetectTool::TYPE_COLS],DailyDetectTool::MAIN,DailyDetectTool::AGENT);
                $main_agent_line_three = $this->getLineUrl($record,DailyDetectTool::THREE,$record[DailyDetectTool::TYPE_COLS],DailyDetectTool::MAIN,DailyDetectTool::AGENT);
                $main_agent_line_four = $this->getLineUrl($record,DailyDetectTool::FOUR,$record[DailyDetectTool::TYPE_COLS],DailyDetectTool::MAIN,DailyDetectTool::AGENT);
                $main_agent_line_five = $this->getLineUrl($record,DailyDetectTool::FIVE,$record[DailyDetectTool::TYPE_COLS],DailyDetectTool::MAIN,DailyDetectTool::AGENT);
                $main_agent_line_six = $this->getLineUrl($record,DailyDetectTool::SIX,$record[DailyDetectTool::TYPE_COLS],DailyDetectTool::MAIN,DailyDetectTool::AGENT);
                $main_agent_line_seven = $this->getLineUrl($record,DailyDetectTool::SEVEN,$record[DailyDetectTool::TYPE_COLS],DailyDetectTool::MAIN,DailyDetectTool::AGENT);
                $main_agent_line_eight = $this->getLineUrl($record,DailyDetectTool::EIGHT,$record[DailyDetectTool::TYPE_COLS],DailyDetectTool::MAIN,DailyDetectTool::AGENT);
                $main_agent_line_nine = $this->getLineUrl($record,DailyDetectTool::NINE,$record[DailyDetectTool::TYPE_COLS],DailyDetectTool::MAIN,DailyDetectTool::AGENT);
                //preg_match_all('/href\="(.*?)<\/a>/',$main_arr[1][1],$main_agent_match);
                preg_match_all('/<span>代理<\/span>(.*?)<p>/',$main_str,$main_arr_agent);
                preg_match_all('/href\="(.*?)<\/a>/',$main_arr_agent[1][0],$main_agent_match);
                $this->checkLineDetail(DailyDetectTool::FRONTEND,DailyDetectTool::MAIN,$main_agent_match[1],$main_agent_line_first,$main_agent_line_second,$main_agent_line_three,$main_agent_line_four,$main_agent_line_five,$main_agent_line_six,$main_agent_line_seven,$main_agent_line_eight,$main_agent_line_nine,DailyDetectTool::AGENT_NOTE);
                Common::log_write("check Line FRONTEND MAIN AGENT end ! ");
            }
            if($reserver_content){
                //备引导页面会员线路检测
                Common::log_write("check Line FRONTEND RESERVER MEMBER Start ! ");
                $reserver_str = preg_replace('/(\t|\n|\r)/','',$reserver_content);
                preg_match_all('/<\/h2>(.*?)<p>/',$reserver_str,$reserver_arr);
                preg_match_all('/href\="(.*?)<\/a>/',$reserver_arr[1][0],$reserver_user_match);
                $this->checkLineDetail(DailyDetectTool::FRONTEND,DailyDetectTool::RESERVER,$reserver_user_match[1],$reserver_line_first,$reserver_line_second,$reserver_line_three,$reserver_line_four,$reserver_line_five,'','','','',DailyDetectTool::MEMBER_NOTE);
                Common::log_write("check Line FRONTEND RESERVER MEMBER end ! ");
                //备引导页面代理线路检测
                Common::log_write("check Line FRONTEND RESERVER AGENT Start ! ");
                $reserver_agent_line_first = $this->getLineUrl($record,DailyDetectTool::FIRST,$record[DailyDetectTool::TYPE_COLS],DailyDetectTool::RESERVER,DailyDetectTool::AGENT);
                $reserver_agent_line_second = $this->getLineUrl($record,DailyDetectTool::SECOND,$record[DailyDetectTool::TYPE_COLS],DailyDetectTool::RESERVER,DailyDetectTool::AGENT);
                $reserver_agent_line_three = $this->getLineUrl($record,DailyDetectTool::THREE,$record[DailyDetectTool::TYPE_COLS],DailyDetectTool::RESERVER,DailyDetectTool::AGENT);
                $reserver_agent_line_four = $this->getLineUrl($record,DailyDetectTool::FOUR,$record[DailyDetectTool::TYPE_COLS], DailyDetectTool::RESERVER,DailyDetectTool::AGENT);
                $reserver_agent_line_five = $this->getLineUrl($record,DailyDetectTool::FIVE,$record[DailyDetectTool::TYPE_COLS],DailyDetectTool::RESERVER,DailyDetectTool::AGENT);
                //隐藏线路检查
                $reserver_line_hide = $this->field['reserver_domain_hide'];
                $this->checkLineHide($reserver_line_hide,$record[DailyDetectTool::COMPANY_NAME_COLS],$record[DailyDetectTool::RESERVER_SIX_IP_COLS],$record[DailyDetectTool::GUIDE_MARK_COLS]);

                preg_match_all('/href\="(.*?)<\/a>/',$reserver_arr[1][1],$reserver_agent_match);
                $this->checkLineDetail(DailyDetectTool::FRONTEND,DailyDetectTool::RESERVER,$reserver_agent_match[1],$reserver_agent_line_first,$reserver_agent_line_second,$reserver_agent_line_three,$reserver_agent_line_four,$reserver_agent_line_five,'','','','',DailyDetectTool::AGENT_NOTE);
                Common::log_write("check Line FRONTEND RESERVER AGENT end ! ");
            }
            Common::log_write("check Line FRONTEND end ! ");
        }
        $lineArr = array($this->message[501]=>$main_line_first . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::MAIN_FIRST_IP_COLS],
                         $this->message[502]=>$main_line_second . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::MAIN_SECOND_IP_COLS],
                         $this->message[503]=>$main_line_three . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::MAIN_THREE_IP_COLS],
                         $this->message[504]=>$main_line_four . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::MAIN_FOUR_IP_COLS],
                         $this->message[505]=>$main_line_five . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::MAIN_FIVE_IP_COLS],
                         $this->message[506]=>$main_line_six . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::MAIN_SIX_IP_COLS],
                         $this->message[507]=>$main_line_seven . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::MAIN_SEVEN_IP_COLS],
                         $this->message[508]=>$main_line_eight . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::MAIN_EIGHT_IP_COLS]
                         //$this->message[509]=>$main_line_nine . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::MAIN_NINE_IP_COLS]
                         //屏蔽备用域名检查
                         //$this->message[601]=>$reserver_line_first . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::RESERVER_FISRT_IP_COLS],
                         //$this->message[602]=>$reserver_line_second . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::RESERVER_SECOND_IP_COLS],
                         //$this->message[603]=>$reserver_line_three . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::RESERVER_THREE_IP_COLS],
                         //$this->message[604]=>$reserver_line_four . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::RESERVER_FOUR_IP_COLS],
                         //$this->message[605]=>$reserver_line_five . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::RESERVER_FIVE_IP_COLS]
                         );
        $this->checkLineTitle($lineArr,$record[DailyDetectTool::COMPANY_NAME_COLS]);
    }
    /**
     * 检测隐藏线路
     * @param string $url 隐藏线路域名
     * @param string $company_name 公司名称
     */
    private function checkLineHide($url,$company_name,$ip,$guide_mark){
        Common::log_write("check Line HIDE START ! ");
        //检查线路是否对应
        $content = $this->getPageContent($url);
        $reserver_str = preg_replace('/(\t|\n|\r)/','',$reserver_content);
        preg_match_all('/<\/h2>(.*?)<p>/',$reserver_str,$reserver_arr);
        preg_match_all('/href\="(.*?)<\/a>/',$reserver_arr[1][0],$reserver_user_match);
        preg_match_all('/href\="(.*?)<\/a>/',$reserver_arr[1][1],$reserver_agent_match);
        $reserver_agent_line_first = "http://" . $url . "/" . $guide_mark . DailyDetectTool::AGENT_FLAG . DailyDetectTool::AGENT_SUFFIX;
        $reserver_user_line_first = "http://" . $url . "/" . $guide_mark . DailyDetectTool::MEMBER_FLAG . DailyDetectTool::MEMBER_SUFFIX;
        Common::log_write("reserver_agent_line_first is : " . $reserver_agent_line_first);
        Common::log_write("reserver_user_line_first is : " . $reserver_user_line_first);
        $match = array('user'=>$reserver_user_match,'agent'=>$reserver_agent_match);
        foreach($match as $key => $value){
            $arr = explode('" target="_blank">',$value);
            if(isset($arr[1])){
                Common::log_write("check Line Detail ! line name is : ".$arr[1]);
                Common::log_write("check Line Detail ! line value is : ".$arr[0]);
                //检测线路一
                $line_first = ('user' == $key) ? $reserver_user_line_first : $reserver_agent_line_first;
                if(DailyDetectTool::LINE_FIRST == $arr[1]){
                    if($arr[0] != $line_first){
                        array_push($this->data,$this->message_info . $this->message[3] . DailyDetectTool::SEPARATOR . $arr[0] . DailyDetectTool::SEPARATOR . $line_first);
                        $this->is_exist_error = true;
                    }
                }
            }
        }
        //检查隐藏线路标题
        $lineArr = array($this->message[4]=>$reserver_agent_line_first. DailyDetectTool::SEPARATOR . $ip,
                         $this->message[13]=>$reserver_user_line_first. DailyDetectTool::SEPARATOR . $ip);
        $this->checkLineTitle($lineArr,$company_name);
        Common::log_write("check Line HIDE end ! ");
    }
    /**
     * 检测线路链接是否正确
     * @param array $match 线路数组
     * @param string $line_first 线路一
     * @param string $line_second 线路二
     * @param string $line_three 线路三
     * @param string $line_four 线路四
     * @param string $flag 前后台标识
     * @param string $type 主备线路标识
     */
    private function checkLineDetail($flag,$type,$match,$line_first = '',$line_second = '',$line_three = '',$line_four = '',$line_five = '',$line_six = '',$line_seven = '',$line_eight = '',$line_nine = '',$note = ''){
        Common::log_write("check Line Detail start ! ");
        Common::log_write("check Line Detail ! frontend or backend is : ".$flag);
        Common::log_write("check Line Detail ! main or resverser is : ".$type);
        Common::log_write("check Line Detail ! line_first value is : ".$line_first);
        Common::log_write("check Line Detail ! line_second value is : ".$line_second);
        Common::log_write("check Line Detail ! line_three value is : ".$line_three);
        Common::log_write("check Line Detail ! line_four value is : ".$line_four);
        Common::log_write("check Line Detail ! line_five value is : ".$line_five);
        Common::log_write("check Line Detail ! line_six value is : ".$line_six);
        Common::log_write("check Line Detail ! line_seven value is : ".$line_seven);
        Common::log_write("check Line Detail ! line_eight value is : ".$line_eight);
        Common::log_write("check Line Detail ! line_nine value is : ".$line_nine);
        foreach($match as $value){
            $arr = explode('" target="_blank">',$value);
            if(isset($arr[1])){
                Common::log_write("check Line Detail ! line name is : ".$arr[1]);
                Common::log_write("check Line Detail ! line value is : ".$arr[0]);
                //检测线路一
                if(DailyDetectTool::LINE_FIRST == $arr[1]){
                    if($flag == DailyDetectTool::BACKEND){
                        if($type == DailyDetectTool::MAIN){
                            $temp_line = $line_second;
                            $temp_message = $this->message[301];
                        }else{
                            $temp_line = $line_first;
                            $temp_message = $this->message[401];;
                        }
                        if($arr[0] != $temp_line){
                            array_push($this->data,$this->message_info . $temp_message . DailyDetectTool::SEPARATOR . $arr[0] . DailyDetectTool::SEPARATOR . $temp_line);
                            $this->is_exist_error = true;
                        }
                    }else{
                        if($type == DailyDetectTool::MAIN){
                            $temp_line = $line_second;
                            $temp_message = $this->message[301];
                        }else{
                            $temp_line = $line_first;
                            $temp_message = $this->message[401];
                        }
                        if($arr[0] != $temp_line){
                            array_push($this->data,$this->message_info . $temp_message . DailyDetectTool::SEPARATOR . $arr[0] . DailyDetectTool::SEPARATOR . $temp_line);
                            $this->is_exist_error = true;
                        }
                    }
                }else if(DailyDetectTool::LINE_SECOND == $arr[1]){//检测线路二
                    if($flag == DailyDetectTool::BACKEND){
                        if($type == DailyDetectTool::MAIN){
                            $temp_line = $line_five;
                            $temp_message = $this->message[302];
                        }else{
                            $temp_line = $line_second;
                            $temp_message = $this->message[402];
                        }
                        if($arr[0] != $temp_line){
                            array_push($this->data,$this->message_info . $temp_message . DailyDetectTool::SEPARATOR . $arr[0] . DailyDetectTool::SEPARATOR . $temp_line);
                            $this->is_exist_error = true;
                        }
                    }else{
                        if($type == DailyDetectTool::MAIN){
                            $temp_line = $line_seven;
                            $temp_message = $this->message[302];
                        }else{
                            $temp_line = $line_four;
                            $temp_message = $this->message[402];
                        }
                        if($arr[0] != $temp_line){
                            array_push($this->data,$this->message_info . $temp_message . DailyDetectTool::SEPARATOR . $arr[0] . DailyDetectTool::SEPARATOR . $temp_line);
                            $this->is_exist_error = true;
                        }
                    }
                }else if(DailyDetectTool::LINE_THREE == $arr[1]){//检测线路三
                    if($flag == DailyDetectTool::BACKEND){
                        if($type == DailyDetectTool::MAIN){
                            $temp_line = $line_first;
                            $temp_message = $this->message[303];
                        }else{
                            $temp_line = $line_three;
                            $temp_message = $this->message[403];
                        }
                        if($arr[0] != $temp_line){
                            array_push($this->data,$this->message_info . $temp_message . DailyDetectTool::SEPARATOR . $arr[0] . DailyDetectTool::SEPARATOR . $temp_line);
                            $this->is_exist_error = true;
                        }
                    }else{
                        if($type == DailyDetectTool::MAIN){
                            $temp_line = $line_five;
                            $temp_message = $this->message[303];
                        }else{
                            $temp_line = $line_second;
                            $temp_message = $this->message[403];
                        }
                        if($arr[0] != $temp_line){
                            array_push($this->data,$this->message_info . $temp_message . DailyDetectTool::SEPARATOR . $arr[0] . DailyDetectTool::SEPARATOR . $temp_line);
                            $this->is_exist_error = true;
                        }
                    }
                }else if(DailyDetectTool::LINE_FOUR == $arr[1]){//检测线路四
                    if($flag == DailyDetectTool::BACKEND){
                        if($type == DailyDetectTool::MAIN){
                            $temp_line = $line_four;
                            $temp_message = $this->message[304];
                        }else{
                            $temp_line = $line_four;
                            $temp_message = $this->message[404];
                        }
                        if($arr[0] != $temp_line){
                            array_push($this->data,$this->message_info . $temp_message . DailyDetectTool::SEPARATOR . $arr[0] . DailyDetectTool::SEPARATOR . $temp_line);
                            $this->is_exist_error = true;
                        }
                    }else{
                        if($type == DailyDetectTool::MAIN){
                            $temp_line = $line_three;
                            $temp_message = $this->message[304];
                        }else{
                            $temp_line = $line_five;
                            $temp_message = $this->message[404];
                        }
                        if($arr[0] != $temp_line){
                            array_push($this->data,$this->message_info . $temp_message . DailyDetectTool::SEPARATOR . $arr[0] . DailyDetectTool::SEPARATOR . $temp_line);
                            $this->is_exist_error = true;
                        }
                    }
                }else if(DailyDetectTool::LINE_FIVE == $arr[1]){//检测线路五
                    if($flag == DailyDetectTool::BACKEND){
                        if($type == DailyDetectTool::MAIN){
                            $temp_line = $line_seven;
                            $temp_message = $this->message[305];
                        }else{
                            $temp_line = $line_five;
                            $temp_message = $this->message[405];
                        }
                        if( $arr[0] != $temp_line){
                            array_push($this->data,$this->message_info . $temp_message . DailyDetectTool::SEPARATOR . $arr[0] . DailyDetectTool::SEPARATOR . $temp_line);
                            $this->is_exist_error = true;
                        }
                    }else{
                        if($type == DailyDetectTool::MAIN){
                            $temp_line = $line_first;
                            $temp_message = $this->message[305];
                        }else{
                            $temp_line = $line_three;
                            $temp_message = $this->message[405];
                        }
                        if($arr[0] != $temp_line){
                            array_push($this->data,$this->message_info . $temp_message . DailyDetectTool::SEPARATOR . $arr[0] . DailyDetectTool::SEPARATOR . $temp_line);
                            $this->is_exist_error = true;
                        }
                    }
                }else if(DailyDetectTool::LINE_SIX == $arr[1]){//检测线路六
                    if($flag == DailyDetectTool::BACKEND){
                        if($type == DailyDetectTool::MAIN){
                            $temp_line = $line_three;
                            $temp_message = $this->message[306];
                        }else{
                            $temp_line = '';
                            $temp_message = $this->message[406];
                        }
                        if($arr[0] != $temp_line){
                            array_push($this->data,$this->message_info . $temp_message . DailyDetectTool::SEPARATOR . $arr[0] . DailyDetectTool::SEPARATOR . $temp_line);
                            $this->is_exist_error = true;
                        }
                    }else{
                        if($type == DailyDetectTool::MAIN){
                            $temp_line = $line_six;
                            $temp_message = $this->message[306];
                        }else{
                            $temp_line = '';
                            $temp_message = $this->message[406];
                        }
                        if($arr[0] != $temp_line){
                            array_push($this->data,$this->message_info . $temp_message . DailyDetectTool::SEPARATOR . $arr[0] . DailyDetectTool::SEPARATOR . $temp_line);
                            $this->is_exist_error = true;
                        }
                    }
                }else if(DailyDetectTool::LINE_SEVEN == $arr[1]){//检测线路七
                    if($flag == DailyDetectTool::BACKEND){
                        if($type == DailyDetectTool::MAIN){
                            $temp_line = $line_six;
                            $temp_message = $this->message[307];
                        }else{
                            $temp_line = '';
                            $temp_message = $this->message[407];
                        }
                        if($arr[0] != $temp_line){
                            array_push($this->data,$this->message_info . $temp_message . DailyDetectTool::SEPARATOR . $arr[0] . DailyDetectTool::SEPARATOR . $temp_line);
                            $this->is_exist_error = true;
                        }
                    }else{
                        if($type == DailyDetectTool::MAIN){
                            $temp_line = $line_four;
                            $temp_message = $this->message[307];
                        }else{
                            $temp_line = '';
                            $temp_message = $this->message[407];
                        }
                        if($arr[0] != $temp_line){
                            array_push($this->data,$this->message_info . $temp_message . DailyDetectTool::SEPARATOR . $arr[0] . DailyDetectTool::SEPARATOR . $temp_line);
                            $this->is_exist_error = true;
                        }
                    }
                }else if(DailyDetectTool::LINE_EIGHT == $arr[1]){//检测线路八
                    if($flag == DailyDetectTool::BACKEND){
                        if($type == DailyDetectTool::MAIN){
                            $temp_line = $this->is_group_two ? $line_second : $line_eight;
                            $temp_message = $this->message[308];
                        }else{
                            $temp_line = '';
                            $temp_message = $this->message[408];
                        }
                        if($arr[0] != $temp_line){
                            array_push($this->data,$this->message_info . $temp_message . DailyDetectTool::SEPARATOR . $arr[0] . DailyDetectTool::SEPARATOR . $temp_line);
                            $this->is_exist_error = true;
                        }
                    }else{
                        if($type == DailyDetectTool::MAIN){
                            $temp_line = $this->is_group_two ? $line_second : $line_eight;
                            $temp_message = $this->message[308];
                        }else{
                            $temp_line = '';
                            $temp_message = $this->message[408];
                        }
                        if($arr[0] != $temp_line){
                            array_push($this->data,$this->message_info . $temp_message . DailyDetectTool::SEPARATOR . $arr[0] . DailyDetectTool::SEPARATOR . $temp_line);
                            $this->is_exist_error = true;
                        }
                    }
                }else if(DailyDetectTool::LINE_NINE == $arr[1]){//检测线路九
                    if($flag == DailyDetectTool::BACKEND){
                        if($type == DailyDetectTool::MAIN){
                            $temp_line = '';
                            $temp_message = $this->message[309];
                        }else{
                            $temp_line = '';
                            $temp_message = $this->message[409];
                        }
                        if($arr[0] != $temp_line){
                            array_push($this->data,$this->message_info . $temp_message . DailyDetectTool::SEPARATOR . $arr[0] . DailyDetectTool::SEPARATOR . $temp_line);
                            $this->is_exist_error = true;
                        }
                    }else{
                        if($type == DailyDetectTool::MAIN){
                            $temp_line = '';
                            $temp_message = $this->message[309];
                        }else{
                            $temp_line = '';
                            $temp_message = $this->message[409];
                        }
                        if($arr[0] != $temp_line){
                            array_push($this->data,$this->message_info . $temp_message . DailyDetectTool::SEPARATOR . $arr[0] . DailyDetectTool::SEPARATOR . $temp_line);
                            $this->is_exist_error = true;
                        }
                    }
                }else{//线路名称不存在
                    Common::log_write("line name is not exist");
                    Common::log_write($this->message_info . $this->message[7] . $note . DailyDetectTool::ERROR_SEPARATOR_START . $arr[1] . DailyDetectTool::ERROR_SEPARATOR_END . DailyDetectTool::SEPARATOR . DailyDetectTool::IS_NULL . DailyDetectTool::SEPARATOR . DailyDetectTool::IS_NULL);
                    array_push($this->data,$this->message_info . $this->message[7] . $note . DailyDetectTool::ERROR_SEPARATOR_START . $arr[1] . DailyDetectTool::ERROR_SEPARATOR_END . DailyDetectTool::SEPARATOR . DailyDetectTool::IS_NULL . DailyDetectTool::SEPARATOR . DailyDetectTool::IS_NULL);
                    $this->is_exist_error = true;
                }
            }
        }
        Common::log_write("check Line Detail end !");
    }
    /**
     * 检测线路标题是否正确
     * @param string $type 前后台标识
     * @param array $lineArr 线路数组
     * @param string $company_name 公司名称
     */
    private function checkLineTitle($lineArr,$company_name){
         Common::log_write("check Line Title Start ! ");
         foreach($lineArr as $key=>$value){
             $value_arr = explode(DailyDetectTool::SEPARATOR, $value);
             if(!empty($value_arr[1])){
                 if(preg_match($this->url_str, $value_arr[0])){
                     Common::log_write("check Line Title ! url is : ".$value_arr[0]);
                     //过滤清洗IP
                     if(true){
                         $content = $this->getPageContent($value_arr[0]);
                         if($content){
                             if($content != DailyDetectTool::NOT_SERVICE_NOTE){
                                 preg_match('/<title>(.*)<\/title>/is',$content,$match);
                                 Common::log_write("check Line Title ! title is : ".$match[1]);
                                 if(trim($match[1]) != $company_name){
                                     array_push($this->data, $this->message_info.$key . DailyDetectTool::ERROR_SEPARATOR_START . $value_arr[0] . DailyDetectTool::ERROR_SEPARATOR_END . DailyDetectTool::SEPARATOR . $match[1] . DailyDetectTool::SEPARATOR . $company_name);
                                    $this->is_exist_error = true;
                                 }
                             }
                         }else{
                             array_push($this->data, $this->message_info . $this->message[6] . DailyDetectTool::SEPARATOR . $value_arr[0] . DailyDetectTool::SEPARATOR . DailyDetectTool::IS_NULL);
                             $this->is_exist_error = true;
                         }
                     }
                 }
             }
         }
         Common::log_write("check Line Title end ! ");
    }
    /**
     * 检测页面重定向后引导标识是否正确
     * @param string $url 跳转前域名
     * @param string $real_guide_mark 引导标识
     */
    private function checkPageRedirect($url,$real_guide_mark){
        Common::log_write("check check Page Redirect Start ! url is : ".$url);
        Common::log_write("real_guide_mark is : ".$real_guide_mark);
        $this->request_time++;
        $ch = curl_init();
        //初始化url
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->time_out);
        //返回字符串
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //返回重定向信息
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        //最大重定向次数
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        //模拟浏览器访问设置头部信息
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        //执行curl
        curl_exec($ch);
        //curl获取头部信息
        $header_info = curl_getinfo($ch);
        //获取页面内容
        //$rs = curl_exec($ch);
        //获取引导标识
        Common::log_write("http_code is : ".$header_info['http_code']);
        if('200' == $header_info['http_code']){
            $redirect_url  = $header_info['url'];
            $url_arr = parse_url($redirect_url);
            //截取引导标识
            $guide_mark = substr($url_arr['path'],1,strlen($url_arr['path'])-5);
            Common::log_write("guide_mark is : ".$guide_mark);
            if($guide_mark != $real_guide_mark){
                array_push($this->data, $this->message_info . $this->message[9] . DailyDetectTool::ERROR_SEPARATOR_START . $url . DailyDetectTool::ERROR_SEPARATOR_END . DailyDetectTool::SEPARATOR . $guide_mark . DailyDetectTool::SEPARATOR . $real_guide_mark);
                $this->is_exist_error = true;
            }
            $flag = true;
        }else{
            if($this->request_time < 2){
                sleep(5);
                $this->checkPageRedirect($url, $real_guide_mark);
            }else{
                array_push($this->data, $this->message_info . $this->message[10] . DailyDetectTool::SEPARATOR . $url . DailyDetectTool::SEPARATOR . DailyDetectTool::IS_NULL);
                $this->is_exist_error = true;
                $flag = false;
            }
        }
        curl_close($ch);
        $this->request_time = 0;
        Common::log_write("check check Page Redirect end ! ");
        return $flag;
    }
    /**
     * 获取域名前缀
     * @param string $str 要解析的字符串
     * @return string $suffix 前缀
     */
    private function getDomainSuffix($str){
        Common::log_write("get DomainSuffix start ! str is : " . $str);
        if(empty($str)){
            $result = "";
        }else{
            $suffixArr = explode("_", $str);
            $result = $suffixArr[1];
        }
        Common::log_write("get DomainSuffix end ! DomainSuffix is : ".$result);
        return $result;
    }
    /**
     * 匹配IP和域名
     * @param string $domain 域名
     * @param string $ip IP地址
     * @param string $message 错误消息
     * @param string $group 集群
     */
    private function matchDomainIp($group,$message,$domain,$ip){
        Common::log_write("check match Domain Ip Start !");
        Common::log_write("domain is : ".$domain);
        Common::log_write("ip is : ".$ip);
        $message = $this->message_info . $message;
        if(!empty($domain) && !empty($ip)){
            $realIp = gethostbynamel($domain);
            Common::log_write("realIp is : ".$realIp[0]);
            if(!empty($realIp[0])){
                if(trim($realIp[0]) != trim($ip)){
                    array_push($this->data,$message . DailyDetectTool::ERROR_SEPARATOR_START .
                        $domain . DailyDetectTool::ERROR_SEPARATOR_END .DailyDetectTool::SEPARATOR .
                        $realIp[0] . DailyDetectTool::SEPARATOR . $ip);
                    $this->is_exist_error = true;
                }
                if($this->cps){
                    $cps_url = 'cps.' . $domain;
                    $this->checkCPS($cps_url);
                    $cpsIp = gethostbynamel($cps_url);
                    Common::log_write("cpsIp is : ".$cpsIp[0]);
                    $cps_temp = explode('.',$realIp[0]);
                    $cps_pos = $cps_temp[0].'.'.$cps_temp[1].'.'.$cps_temp[2];
                    Common::log_write("group is : ".$group);
                    Common::log_write("DailyDetectTool::GROUP_TWO is : ".DailyDetectTool::GROUP_TWO);
                    if($group == DailyDetectTool::GROUP_TWO){
                        $this->is_group_two = true;
                    }else{
                        $this->is_group_two = false;
                    }
                    $cps_real_ip = $this->cps_arr[$cps_pos];
                    Common::log_write("cps_pos is : ".$cps_pos);;
                    Common::log_write("cps real Ip is : ".$cps_real_ip);
                    if(!empty($cpsIp[0])){
                        if($cpsIp[0] != $cps_real_ip){
                            array_push($this->data,$this->message_info . $this->message[12] . DailyDetectTool::ERROR_SEPARATOR_START .
                                $cps_url . DailyDetectTool::ERROR_SEPARATOR_END .DailyDetectTool::SEPARATOR .
                                $cpsIp[0] . DailyDetectTool::SEPARATOR . $cps_real_ip);
                            $this->is_exist_error = true;
                        }
                    }else{
                        array_push($this->data,$this->message_info . '获取当前域名指向IP失败' . DailyDetectTool::SEPARATOR . $cps_url .
                                DailyDetectTool::SEPARATOR);
                        $this->is_exist_error = true;
                    }
                }
            }else{
                array_push($this->data,$this->message_info . '获取当前域名指向IP失败' . DailyDetectTool::SEPARATOR . $domain .
                        DailyDetectTool::SEPARATOR);
                $this->is_exist_error = true;
            }
        }
        Common::log_write("check match Domain Ip end ! ");
    }
    /**
     * 线路URL组装
     * @param string $order 线路排序
     * @param array $record 记录数组
     * @param string $type 前后台标识
     * @param string $flag 主备线路标识
     * @param boolean $agent 是否为代理
     * @return string $line 线路URl
     */
    private function getLineUrl($record,$order,$type,$flag,$agent = false){
        Common::log_write("get Line Url start ! ");
        $line = '';
        if($type == DailyDetectTool::BACKEND){//后台引导页面线路url
            $loginPageSuffix = DailyDetectTool::COMPANY_SUFFIX;
            $loginPageFlag = DailyDetectTool::COMPANY_FLAG;
        }else{//前台引导页面线路url
            if($agent){
                $loginPageSuffix = DailyDetectTool::AGENT_SUFFIX;
                $loginPageFlag = DailyDetectTool::AGENT_FLAG;
            }else{
                $loginPageSuffix = DailyDetectTool::MEMBER_SUFFIX;
                $loginPageFlag = DailyDetectTool::MEMBER_FLAG;
            }
        }
        $domain = $this->getLineUrlDetail($record,$flag,$order,$type);
        if(!empty($domain)){
            $line = "http://" . $domain . '/' . $record[DailyDetectTool::GUIDE_MARK_COLS] . $loginPageFlag . $loginPageSuffix;
        }else{
            $line = '';
        }
        Common::log_write("get Line Url end! line is : ".$line);
        return $line;
    }
    /**
     * 获取线路域名
     * @param array $record 记录数组
     * @param string $flag 主备线路标识
     * @param string $order 线路排序
     * @param string $type 前后台标识
     * @return string $domain 域名
     */
    private function getLineUrlDetail($record,$flag,$order,$type){
        Common::log_write("get Line Url Detail start ! ");
        if($flag == DailyDetectTool::MAIN){//主引导页面线路url
            switch($order) {
                case 1:
                    $domain = $this->field['main_domain_first'];
                break;
                case 2:
                    $domain = $this->field['main_domain_second'];
                break;
                case 3:
                    $domain = $this->field['main_domain_three'];
                break;
                case 4:
                    $domain = $this->field['main_domain_four'];
                break;
                case 5:
                    $domain = $this->field['main_domain_five'];
                break;
                case 6:
                    $domain = $this->field['main_domain_six'];
                break;
                case 7:
                    $domain = $this->field['main_domain_seven'];
                break;
                case 8:
                    $domain = $this->field['main_domain_eight'];
                break;
                case 9:
                    $domain = $this->field['main_domain_nine'];
                break;
                default:
                    $domain = '';
                break;
            }
        }else{//备用引导页面线路url
            switch($order) {
                case 1:
                    $domain = $record[DailyDetectTool::RESERVER_DOMAIN_COLS];
                break;
                case 2:
                    $domain = $record[DailyDetectTool::RESERVER_SECOND_IP_COLS];
                break;
                case 3:
                    $domain = $record[DailyDetectTool::RESERVER_THREE_IP_COLS];
                break;
                case 4:
                    $domain = $record[DailyDetectTool::RESERVER_FOUR_IP_COLS];
                break;
                case 5:
                    $domain = $record[DailyDetectTool::RESERVER_FIVE_IP_COLS];
                break;
                default:
                    $domain = '';
                break;
            }
        }
        Common::log_write("get Line Url Detail end! Domain is : " .$domain);
        return $domain;
    }
    /**
     * file_get_contents获取页面内容
     * @param string $url 页面地址
     */
    private function getPageContentFile($url){
        $this->request_time++;
        $content = @file_get_contents($url,false,$this->context);
        if(!$content){
            if($this->request_time < 4){
                sleep(5);
                $this->getPageContent($url);
            }
        }
        $this->request_time = 0;
        return $content;
    }
    /**
     * curl获取页面内容
     * @param string $url 页面地址
     */
    private function getPageContent($url){
        Common::log_write("get Page Content start：".$url);
        $this->request_time++;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->time_out);
        //返回字符串
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //返回重定向信息
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        //最大重定向次数
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        //模拟浏览器访问设置头部信息
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        //获取页面内容
        $content = curl_exec($ch);
        $header_info = curl_getinfo($ch);
        if('200' != $header_info['http_code']){
            if($this->request_time < 2){
                sleep(5);
                $this->getPageContent($url);
            }else{
                Common::log_write("get Page Content fail：".$url);
            }
        }
        curl_close($ch);
        $this->request_time = 0;
        Common::log_write("get Page Content end：".$url);
        return $content;
    }
    /**
     * 获取服务器IP
     */
    private function getHostIp($dest='64.0.0.0', $port=80){
        $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        socket_connect($socket, $dest, $port);
        socket_getsockname($socket, $addr, $port);
        socket_close($socket);
        return $addr;
    }
    /**
     * 发送email
     * @param string $content 邮件内容
     * @param date $start_time 时间
     * @param date $start_time 日期
     * @param string $info 标题信息
     * @param string $filename 附件
     * @return boolean
     */
    private function sendEmail($content,$start_time,$date,$info,$file_name){
        Common::log_write("send email start ! ");
        $emailArr = explode(',', $this->email);
        $mail = new PHPMailer();//实例化phpmailer
        //$address = "qing.m@evervtech.com";//接收邮件的邮箱
        $mail->IsSMTP(); // 设置发送邮件的协议：SMTP
        $mail->SMTPAuth   = true;// enable SMTP authentication
        $mail->SMTPSecure = "tls";
        $mail->Host = "evervtech.com"; // 发送邮件的服务器
        //$mail->SMTPAuth = false; // 打开SMTP
        $mail->Username = "auto.check@evervtech.com"; // SMTP账户
        $mail->Password = "123456"; // SMTP密码
        $mail->From = "auto.check@evervtech.com";
        $mail->FromName = "网站检测邮箱";
        foreach ($emailArr as $address){
            $mail->AddAddress($address, "");
        }
        //$mail->AddAddress($address, "");
        //$mail->AddAddress(""); // name is optional
        //$mail->AddReplyTo("", "");

        //$mail->WordWrap = 50; // set word wrap to 50 characters
        $mail->AddAttachment($file_name); // add attachments
        //$mail->AddAttachment("/tmp/image.jpg", "new.jpg"); // optional name
        $mail->IsHTML(true); // set email format to HTML
        $mail->CharSet = "UTF-8";//设置字符集编码
        $mail->Subject = "网站检测报告（" . $info . "）" . $date . ' ' . $start_time;
        $mail->Body = $content;//邮件内容（可以是HTML邮件）
        //$mail->AltBody = "This is the body in plain text for non-HTML mail clients";
        if(!$mail->Send()){
            $this->request_time++;
            if($this->request_time < 6){
                Common::log_write("Message could not be sent. <p>Mailer Error: " . $mail->ErrorInfo);
                sleep(5);
                $this->sendEmail($content, $start_time, $date, $info,$file_name);
            }else{
                Common::log_write("Message could not be sent. <p>Mailer Error: " . $mail->ErrorInfo);
            }
        }else{
            Common::log_write("Message has been sent");
        }
        Common::log_write("send email end ! ");
    }
    /**
     * 生成HTML
     * @param $content 页面内容
     */
    private function makeHtml($content){
        Common::log_write("make Html start ! ");
        $dir = Common::parseXml('htmdir');
        $file_name = $dir . date("YmdHis") . ".htm";
        Common::log_write("make Html to " . $file_name);
        try{
            $fp=fopen($file_name,"w");
            fwrite($fp,$content);
            fclose($fp);
        }catch (Exception $e) {
            Common::log_write($e->getMessage());
        }
        Common::log_write("make Html end ! ");
        return $file_name;
    }

    /**
     * 交易平台检查
     * @param array $record 记录
     */
    private function checkBBTP($record){
        Common::log_write("check BBTP start ! ");
        $this->getDomain($record);
        //解析域名对应IP
        $this->matchDomainIp('',DailyDetectTool::PROJECT_BBTP . $this->message[101],$record[DailyDetectTool::MAIN_DOMAIN_COLS],$record[DailyDetectTool::MAIN_FIRST_IP_COLS]);
        $this->matchDomainIp('',DailyDetectTool::PROJECT_BBTP . $this->message[102],$this->field['main_domain_second'],$record[DailyDetectTool::MAIN_SECOND_IP_COLS]);
        $this->matchDomainIp('',DailyDetectTool::PROJECT_BBTP . $this->message[103],$this->field['main_domain_three'],$record[DailyDetectTool::MAIN_THREE_IP_COLS]);
        $this->matchDomainIp('',DailyDetectTool::PROJECT_BBTP . $this->message[104],$this->field['main_domain_four'],$record[DailyDetectTool::MAIN_FOUR_IP_COLS]);
        $this->matchDomainIp('',DailyDetectTool::PROJECT_BBTP . $this->message[105],$this->field['main_domain_five'],$record[DailyDetectTool::MAIN_FIVE_IP_COLS]);
        //匹配登陆页面公司名称
        $main_line_first = "http://" . $record[DailyDetectTool::MAIN_DOMAIN_COLS];
        $main_line_second = "http://" . $this->field['main_domain_second_prefix'] . "." . $record[DailyDetectTool::MAIN_DOMAIN_COLS];
        $main_line_three = "http://" . $this->field['main_domain_three_prefix'] . "." . $record[DailyDetectTool::MAIN_DOMAIN_COLS];
        $main_line_four = "http://" . $this->field['main_domain_four_prefix'] . "." . $record[DailyDetectTool::MAIN_DOMAIN_COLS];
        $main_line_five = "http://" . $this->field['main_domain_five_prefix'] . "." . $record[DailyDetectTool::MAIN_DOMAIN_COLS];
        $lineArr = array(
                    DailyDetectTool::PROJECT_BBTP . $this->message[301]=>$main_line_first . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::MAIN_FIRST_IP_COLS],
                    DailyDetectTool::PROJECT_BBTP . $this->message[302]=>$main_line_second . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::MAIN_SECOND_IP_COLS],
                    DailyDetectTool::PROJECT_BBTP . $this->message[303]=>$main_line_three . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::MAIN_THREE_IP_COLS],
                    DailyDetectTool::PROJECT_BBTP . $this->message[304]=>$main_line_four . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::MAIN_FOUR_IP_COLS],
                    DailyDetectTool::PROJECT_BBTP . $this->message[305]=>$main_line_five . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::MAIN_FIVE_IP_COLS]
                 );
        $this->checkLineTitle($lineArr, $record[DailyDetectTool::COMPANY_NAME_COLS]);
        Common::log_write("check BBTP end ! ");
    }

    /**
     * 赛马检查
     * @param array $record 记录
     */
    private function checkJockeyStar($record){
        Common::log_write("check JockeyStar start ! ");
        $this->getDomain($record);
        //解析域名对应IP
        $this->matchDomainIp('',DailyDetectTool::PROJECT_JOCKEYSTAR . $this->message[101],$record[DailyDetectTool::MAIN_DOMAIN_COLS],$record[DailyDetectTool::MAIN_FIRST_IP_COLS]);
        $this->matchDomainIp('',DailyDetectTool::PROJECT_JOCKEYSTAR . $this->message[102],$this->field['main_domain_second'],$record[DailyDetectTool::MAIN_SECOND_IP_COLS]);
        $this->matchDomainIp('',DailyDetectTool::PROJECT_JOCKEYSTAR . $this->message[103],$this->field['main_domain_three'],$record[DailyDetectTool::MAIN_THREE_IP_COLS]);
        $this->matchDomainIp('',DailyDetectTool::PROJECT_JOCKEYSTAR . $this->message[104],$this->field['main_domain_four'],$record[DailyDetectTool::MAIN_FOUR_IP_COLS]);
        $this->matchDomainIp('',DailyDetectTool::PROJECT_JOCKEYSTAR . $this->message[105],$this->field['main_domain_five'],$record[DailyDetectTool::MAIN_FIVE_IP_COLS]);
        //获取引导页面内容  检查引导页面标题和线路
        $url = "http://" . $record[DailyDetectTool::MAIN_DOMAIN_COLS];
        $main_content = $this->getPageContent($url);
        if($main_content){
            Common::log_write('get page content true:'.$url);
            preg_match('/<title>线路选择-(.*)导航-(.*)<\/title>/is',$main_content,$match);
            Common::log_write("title is : ".$match[1]);
            if(trim($match[1]) != $record[DailyDetectTool::COMPANY_NAME_COLS]){
                array_push($this->data,$this->message_info. $this->message[0] . DailyDetectTool::ERROR_SEPARATOR_START .
                            $url . DailyDetectTool::ERROR_SEPARATOR_END . DailyDetectTool::SEPARATOR . $match[1] .
                            DailyDetectTool::SEPARATOR . $record[DailyDetectTool::COMPANY_NAME_COLS]);
                $this->is_exist_error = true;
            }
            //检查线路
            if($record[DailyDetectTool::TYPE_COLS] == DailyDetectTool::BACKEND){//后台
                Common::log_write("check Line BACKEND Start ! ");
                //主引导页面公司线路检查
                Common::log_write("check Line BACKEND MAIN Start ! ");
                preg_match_all('/href \="(.*?)\<\/a\>/',$main_content,$main_match);
                //组装线路
                $main_line_first = 'http://'.$record[DailyDetectTool::MAIN_DOMAIN_COLS] . '/' . $record[DailyDetectTool::GUIDE_MARK_COLS] . DailyDetectTool::COMPANY_FLAG . DailyDetectTool::JOCKEYSTAR_SUFFIX;
                $main_line_second = 'http://'.$this->field['main_domain_second_prefix'] . "."  . $record[DailyDetectTool::MAIN_DOMAIN_COLS] . '/' . $record[DailyDetectTool::GUIDE_MARK_COLS] . DailyDetectTool::COMPANY_FLAG . DailyDetectTool::JOCKEYSTAR_SUFFIX;
                $main_line_three = 'http://'.$this->field['main_domain_three_prefix'] . "."  . $record[DailyDetectTool::MAIN_DOMAIN_COLS] . '/' . $record[DailyDetectTool::GUIDE_MARK_COLS] . DailyDetectTool::COMPANY_FLAG . DailyDetectTool::JOCKEYSTAR_SUFFIX;
                $main_line_four = 'http://'.$this->field['main_domain_four_prefix'] . "."  . $record[DailyDetectTool::MAIN_DOMAIN_COLS] . '/' . $record[DailyDetectTool::GUIDE_MARK_COLS] . DailyDetectTool::COMPANY_FLAG . DailyDetectTool::JOCKEYSTAR_SUFFIX;
                $main_line_five = 'http://'.$this->field['main_domain_five_prefix'] . "."  . $record[DailyDetectTool::MAIN_DOMAIN_COLS] . '/' . $record[DailyDetectTool::GUIDE_MARK_COLS] . DailyDetectTool::COMPANY_FLAG . DailyDetectTool::JOCKEYSTAR_SUFFIX;
                $this->checkJOCKEYSTARLineDetail($main_match[1],$main_line_first,$main_line_second,$main_line_three,$main_line_four,$main_line_five);
                Common::log_write("check Line BACKEND MAIN end ! ");
                $lineArr = array(
                    DailyDetectTool::PROJECT_JOCKEYSTAR . $this->message[301]=>$main_line_first . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::MAIN_FIRST_IP_COLS],
                    DailyDetectTool::PROJECT_JOCKEYSTAR . $this->message[302]=>$main_line_second . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::MAIN_SECOND_IP_COLS],
                    DailyDetectTool::PROJECT_JOCKEYSTAR . $this->message[303]=>$main_line_three . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::MAIN_THREE_IP_COLS],
                    DailyDetectTool::PROJECT_JOCKEYSTAR . $this->message[304]=>$main_line_four . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::MAIN_FOUR_IP_COLS],
                    DailyDetectTool::PROJECT_JOCKEYSTAR . $this->message[305]=>$main_line_five . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::MAIN_FIVE_IP_COLS]
                 );
                Common::log_write("check Line BACKEND end ! ");
            }else{//前台
                Common::log_write("check Line FRONTEND Start ! ");
                //主引导页面会员线路检测
                Common::log_write("check Line FRONTEND MAIN MEMBER Start ! ");
                $main_str = preg_replace('/(\t|\n|\r)/','',$main_content);
                preg_match_all('/<\/h2>(.*?)<p>/',$main_str,$main_arr);
                preg_match_all('/href \="(.*?)<\/a>/',$main_arr[1][0],$main_user_match);
                //组装线路
                $main_member_line_first = 'http://'.$record[DailyDetectTool::MAIN_DOMAIN_COLS] . '/' . $record[DailyDetectTool::GUIDE_MARK_COLS] . DailyDetectTool::MEMBER_FLAG . DailyDetectTool::JOCKEYSTAR_SUFFIX;
                $main_member_line_second = 'http://'.$this->field['main_domain_second_prefix'] . "."  . $record[DailyDetectTool::MAIN_DOMAIN_COLS] . '/' . $record[DailyDetectTool::GUIDE_MARK_COLS] . DailyDetectTool::MEMBER_FLAG . DailyDetectTool::JOCKEYSTAR_SUFFIX;
                $main_member_line_three = 'http://'.$this->field['main_domain_three_prefix'] . "."  . $record[DailyDetectTool::MAIN_DOMAIN_COLS] . '/' . $record[DailyDetectTool::GUIDE_MARK_COLS] . DailyDetectTool::MEMBER_FLAG . DailyDetectTool::JOCKEYSTAR_SUFFIX;
                $main_member_line_four = 'http://'.$this->field['main_domain_four_prefix'] . "."  . $record[DailyDetectTool::MAIN_DOMAIN_COLS] . '/' . $record[DailyDetectTool::GUIDE_MARK_COLS] . DailyDetectTool::MEMBER_FLAG . DailyDetectTool::JOCKEYSTAR_SUFFIX;
                $main_member_line_five = 'http://'.$this->field['main_domain_five_prefix'] . "."  . $record[DailyDetectTool::MAIN_DOMAIN_COLS] . '/' . $record[DailyDetectTool::GUIDE_MARK_COLS] . DailyDetectTool::MEMBER_FLAG . DailyDetectTool::JOCKEYSTAR_SUFFIX;
                $this->checkJOCKEYSTARLineDetail($main_user_match[1],$main_member_line_first,$main_member_line_second,$main_member_line_three,$main_member_line_four,$main_member_line_five,DailyDetectTool::MEMBER_NOTE);
                Common::log_write("check Line FRONTEND MAIN MEMBER end ! ");
                //主引导页面代理线路检测
                Common::log_write("check Line FRONTEND MAIN AGENT start ! ");
                preg_match_all('/href \="(.*?)<\/a>/',$main_arr[1][1],$main_agent_match);
                $main_agent_line_first = 'http://'.$record[DailyDetectTool::MAIN_DOMAIN_COLS] . '/' . $record[DailyDetectTool::GUIDE_MARK_COLS] . DailyDetectTool::AGENT_FLAG . DailyDetectTool::JOCKEYSTAR_SUFFIX;
                $main_agent_line_second = 'http://'.$this->field['main_domain_second_prefix'] . "."  . $record[DailyDetectTool::MAIN_DOMAIN_COLS] . '/' . $record[DailyDetectTool::GUIDE_MARK_COLS] . DailyDetectTool::AGENT_FLAG . DailyDetectTool::JOCKEYSTAR_SUFFIX;
                $main_agent_line_three = 'http://'.$this->field['main_domain_three_prefix'] . "."  . $record[DailyDetectTool::MAIN_DOMAIN_COLS] . '/' . $record[DailyDetectTool::GUIDE_MARK_COLS] . DailyDetectTool::AGENT_FLAG . DailyDetectTool::JOCKEYSTAR_SUFFIX;
                $main_agent_line_four = 'http://'.$this->field['main_domain_four_prefix'] . "."  . $record[DailyDetectTool::MAIN_DOMAIN_COLS] . '/' . $record[DailyDetectTool::GUIDE_MARK_COLS] . DailyDetectTool::AGENT_FLAG . DailyDetectTool::JOCKEYSTAR_SUFFIX;
                $main_agent_line_five = 'http://'.$this->field['main_domain_five_prefix'] . "."  . $record[DailyDetectTool::MAIN_DOMAIN_COLS] . '/' . $record[DailyDetectTool::GUIDE_MARK_COLS] . DailyDetectTool::AGENT_FLAG . DailyDetectTool::JOCKEYSTAR_SUFFIX;
                $this->checkJOCKEYSTARLineDetail($main_agent_match[1], $main_agent_line_first, $main_agent_line_second, $main_agent_line_three, $main_agent_line_four, $main_agent_line_five,DailyDetectTool::AGENT_NOTE);
                Common::log_write("check Line FRONTEND MAIN AGENT end ! ");
                $lineArr = array(
                    DailyDetectTool::PROJECT_JOCKEYSTAR . $this->message[301]=>$main_member_line_first . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::MAIN_FIRST_IP_COLS],
                    DailyDetectTool::PROJECT_JOCKEYSTAR . $this->message[302]=>$main_member_line_second . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::MAIN_SECOND_IP_COLS],
                    DailyDetectTool::PROJECT_JOCKEYSTAR . $this->message[303]=>$main_member_line_three . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::MAIN_THREE_IP_COLS],DailyDetectTool::PROJECT_JOCKEYSTAR . $this->message[304]=>$main_member_line_four . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::MAIN_FOUR_IP_COLS],
                    DailyDetectTool::PROJECT_JOCKEYSTAR . $this->message[305]=>$main_member_line_five . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::MAIN_FIVE_IP_COLS],
                    DailyDetectTool::PROJECT_JOCKEYSTAR . $this->message[301]=>$main_agent_line_first . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::MAIN_FIRST_IP_COLS],
                    DailyDetectTool::PROJECT_JOCKEYSTAR . $this->message[302]=>$main_agent_line_second . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::MAIN_SECOND_IP_COLS],
                    DailyDetectTool::PROJECT_JOCKEYSTAR . $this->message[303]=>$main_agent_line_three . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::MAIN_THREE_IP_COLS],
                    DailyDetectTool::PROJECT_JOCKEYSTAR . $this->message[304]=>$main_agent_line_four . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::MAIN_FOUR_IP_COLS],
                    DailyDetectTool::PROJECT_JOCKEYSTAR . $this->message[305]=>$main_agent_line_five . DailyDetectTool::SEPARATOR . $record[DailyDetectTool::MAIN_FIVE_IP_COLS]
                 );
                Common::log_write("check Line FRONTEND end ! ");
            }
            //检查登陆页面公司名称
            $this->checkLineTitle($lineArr, $record[DailyDetectTool::COMPANY_NAME_COLS]);
        }else{
            Common::log_write('get page content false:'.$url);
            array_push($this->data, $this->message_info . $this->message[6] . DailyDetectTool::SEPARATOR . $url .
                        DailyDetectTool::SEPARATOR . DailyDetectTool::IS_NULL);
            $this->is_exist_error = true;
        }
        Common::log_write("check JockeyStar end ! ");
    }

    /**
     * 赛马平台线路检查
     * @param array $match 线路数组
     * @param string $line_first 线路一
     * @param string $line_second 线路二
     */
    private function checkJOCKEYSTARLineDetail($match,$line_first,$line_second,$line_three,$line_four,$line_five,$note = ''){
        foreach($match as $value){
            $arr = explode('" target="_blank">',$value);
             if(isset($arr[1])){
                Common::log_write("check Line Detail ! line name is : ".$arr[1]);
                Common::log_write("check Line Detail ! line value is : ".$arr[0]);
                //检测线路一
                if(DailyDetectTool::LINE_FIRST_JOCKEYSTAR == $arr[1]){
                    if($arr[0] != $line_second){
                        array_push($this->data,$this->message_info . DailyDetectTool::PROJECT_JOCKEYSTAR . $this->message[301] . DailyDetectTool::SEPARATOR . $arr[0] . DailyDetectTool::SEPARATOR . $line_second);
                        $this->is_exist_error = true;
                    }
                }else if(DailyDetectTool::LINE_SECOND_JOCKEYSTAR == $arr[1]){//检测线路二
                    if($arr[0] != $line_four){
                        array_push($this->data,$this->message_info . DailyDetectTool::PROJECT_JOCKEYSTAR . $this->message[302] . DailyDetectTool::SEPARATOR . $arr[0] . DailyDetectTool::SEPARATOR . $line_four);
                        $this->is_exist_error = true;
                    }
                }else if(DailyDetectTool::LINE_THREE_JOCKEYSTAR == $arr[1]){//检测线路三
                    if($arr[0] != $line_first){
                        array_push($this->data,$this->message_info . DailyDetectTool::PROJECT_JOCKEYSTAR . $this->message[303] . DailyDetectTool::SEPARATOR . $arr[0] . DailyDetectTool::SEPARATOR . $line_first);
                        $this->is_exist_error = true;
                    }
                }else if(DailyDetectTool::LINE_FOUR_JOCKEYSTAR == $arr[1]){//检测线路四
                    if($arr[0] != $line_three){
                        array_push($this->data,$this->message_info . DailyDetectTool::PROJECT_JOCKEYSTAR . $this->message[304] . DailyDetectTool::SEPARATOR . $arr[0] . DailyDetectTool::SEPARATOR . $line_three);
                        $this->is_exist_error = true;
                    }
                }else if(DailyDetectTool::LINE_FIVE_JOCKEYSTAR == $arr[1]){//检测线路五
                    if($arr[0] != $line_five){
                        array_push($this->data,$this->message_info . DailyDetectTool::PROJECT_JOCKEYSTAR . $this->message[305] . DailyDetectTool::SEPARATOR . $arr[0] . DailyDetectTool::SEPARATOR . $line_five);
                        $this->is_exist_error = true;
                    }
                }else{//线路名称不存在
                    Common::log_write("line name is not exist");
                    array_push($this->data,$this->message_info . $this->message[7] . $note . DailyDetectTool::ERROR_SEPARATOR_START .
                                $arr[1] . DailyDetectTool::ERROR_SEPARATOR_END . DailyDetectTool::SEPARATOR .
                                DailyDetectTool::IS_NULL . DailyDetectTool::SEPARATOR . DailyDetectTool::IS_NULL);
                    $this->is_exist_error = true;
                }
             }
        }
    }

    /**
     * CPS检查
     * @param array $url CPS地址
     */
    private function checkCPS($url){
        Common::log_write("check CPS Start !");
        Common::log_write("url is : ".$url);
        $this->request_time++;
        $ch = curl_init();
        //初始化url
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        //返回字符串
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //返回重定向信息
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        //最大重定向次数
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        //模拟浏览器访问设置头部信息
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        //执行curl
        curl_exec($ch);
        //curl获取头部信息
        $header_info = curl_getinfo($ch);
        //获取页面内容
        //$rs = curl_exec($ch);
        //获取引导标识
        Common::log_write("CPS check http_code is : ".$header_info['http_code']);
        if('200' == $header_info['http_code']){
            $flag = true;
        }else{
            if($this->request_time < 2){
                sleep(5);
                $this->checkCPS($url);
            }else{
                array_push($this->data, $this->message_info . $this->message[14] .
                    DailyDetectTool::SEPARATOR . $url . DailyDetectTool::SEPARATOR . DailyDetectTool::IS_NULL);
                $this->is_exist_error = true;
                $flag = false;
            }
        }
        curl_close($ch);
        $this->request_time = 0;
        Common::log_write("check CPS end ! ");
        return $flag;
    }
}
?>
