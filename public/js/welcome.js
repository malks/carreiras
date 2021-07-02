$(document).ready(function () {
    welcomeLogin();
    if ($('[profile-edit]')[0]!=undefined)
        profile();
})

function welcomeLogin() {
    welcoLogin = new Vue({
        el:'#welcoLogin',
        data:{
            login_user:'',
            login_user_ok:'0',
            login_pass:'',
            login_pass_ok:'0',
        },
        methods:{
            checkLogin: function () {
                if (this.login_user.length>0){
                    this.login_user_ok=1;
                    window.setTimeout(function () {
                        document.getElementById('login-pass').focus();
                    },200);
                }
            },
            checkPass: function () {
                if (this.login_user.length>0 && this.login_pass.length>0)
                    return true;
                return false;
            },
            goToLogin: function (){
                if (this.login_user.length>0 && this.login_pass.length>0)
                    document.getElementById('login-form').submit();
                return false;
            },
            backToUsername: function (){
                this.login_user_ok=0;
                window.setTimeout(function () {
                    document.getElementById('login-user').focus();
                },300);
            }
        }
    })
}

function profile(){
    startProfile('profile-edit','candidate-data');
}


function startProfile(screenNameHelper='',firstTab=''){
    edit = new Vue({
        el:'#app',
        data:{
            screenName:screenNameHelper,
            currentTab:firstTab,
            alwaysTrue:true,
            saving:false,
        },
        methods:{
            isItMe:function (who) {
                if (this.currentTab==who)
                    return true;
                return false;
            },
            saveProfile:function(){
                this.saving=true;
                that=this;
                data=$('form').serialize();
                $.ajax({
                    url:'/save-profile',
                    type:'POST',
                    data:data,
                    success:function (data){
                        that.saving=false;
                        console.log(data);
                    }
                })
            }
        }
    })
}