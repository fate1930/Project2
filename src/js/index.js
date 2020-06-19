<script>
function toggle(){
    $.getJSON("php/get.php",function (res) {
        if(res['flag']){
            $('li.toggle').toggleClass('hidden');
            $('#nicheng').html(res['nc'])
        }
    });
}
$('#form_login').submit(function (e) {/*登录*/
    e.preventDefault();/*阻止表单默认事件，页面全局刷新*/
    var data=$('#form_login').serialize();/*将表单里的数据包装起来*/
    $.getJSON('php/login.php',data,function (res) {
        /*data：将表单里的数据传给php，回调函数接受php返回来的值*/
        if(res==3){//用户名、密码、验证码都输入正确
            toggle();/*修改首页选项菜单*/
            $('#loginer').modal('hide');/*关闭模态框*/
        }else if(res==2){
            $('#info').html('用户名或密码有误')
        }else {
            $('#info').html('验证码有误')
        }
    })
});
$('#logout').click(function () {
    confirm('确定要注销？');
    $.getJSON('php/logout.php',function (res) {
        if(res)toggle();
    })
})
$('#form_regist').submit(function (e) {
    e.preventDefault();
    var data=$('#form_regist').serialize();
    $.getJSON('php/regist.php',data,function (res) {
        if(res==3){
            toggle();
            $('#register').modal('hide');
        }else if (res==2) {
            $('#wanner').html('两次密码不一致，请重试！')
        }else if (res==1) {
            $('#wanner').html('用户名冲突，请重试！')
        }
    })
});