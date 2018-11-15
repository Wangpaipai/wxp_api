/**
 * Created by 54714 on 2018/11/12.
 */
/**
 * 检测字符串所占字节长度
 * @param {Object} s
 */
function mbStringLength(s) {
    var totalLength = 0;
    var i;
    var charCode;
    for (i = 0; i < s.length; i++) {
        charCode = s.charCodeAt(i);
        if (charCode < 0x007f) {
            totalLength = totalLength + 1;
        } else if ((0x0080 <= charCode) && (charCode <= 0x07ff)) {
            totalLength += 2;
        } else if ((0x0800 <= charCode) && (charCode <= 0xffff)) {
            totalLength += 3;
        }
    }
    return totalLength;
}

/**
 * 验证账号是否合法  4-16位
 * @param {Object} str 需要验证的字符
 * 验证规则：字母、数字、下划线组成，字母或数字开头，4-16位
 */
function checkUser(str){
    var re = /^[0-9a-zA-z]\w{3,15}$/;
    if(re.test(str)){
        return true;
    }else{
        return false;
    }
}

/**
 * 验证手机号码是否合法
 * @param {Object} str 需要验证的字符
 * 验证规则：11位数字，以1开头。
 */
function checkMobile(str) {
    var re = /^1[34578]\d{9}$/
    if(re.test(str)){
        return true;
    }else{
        return false;
    }
}

/**
 * 验证邮箱是否合法
 * @param {Object} str 需要验证的字符
 * 验证规则：姑且把邮箱地址分成“第一部分@第二部分”这样 第一部分：由字母、数字、下划线、短线“-”、点号“.”组成，
 * 第二部分：为一个域名，域名由字母、数字、短线“-”、域名后缀组成，
 * 而域名后缀一般为.xxx或.xxx.xx，一区的域名后缀一般为2-4位，如cn,com,net，现在域名有的也会大于4位
 */
function checkEmail(str){
    var re = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/
    if(re.test(str)){
        return true;
    }else{
        return false;
    }
}


function CheckUrl(url){
    var reg=/^([hH][tT]{2}[pP]:\/\/|[hH][tT]{2}[pP][sS]:\/\/)(([A-Za-z0-9-~]+)\.)+([A-Za-z0-9-~\/])+$/;
    if(!reg.test(url)){
        return false;
    } else{
        return true;
    }
}
function timestampToTime(timestamp) {
    var date = new Date(timestamp * 1000);//时间戳为10位需*1000，时间戳为13位的话不需乘1000
    var Y = date.getFullYear() + '-';
    var M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
    var D = date.getDate() + ' ';
    var h = date.getHours() + ':';
    var m = date.getMinutes() + ':';
    var s = date.getSeconds();
    return Y+M+D+h+m+s;
}