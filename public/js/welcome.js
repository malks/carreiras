$(document).ready(function () {
    welcomeLogin();
    if ($('[profile-edit]')[0]!=undefined)
        profile();
    else if ($('[candidate-jobs]')[0]!=undefined)
        candidateJobs();
    else if ($('[candidate-subscriptions]')[0]!=undefined)
        candidateSubscription();        
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

function candidateSubscription(){
    console.log('subs');
    candiSubs = new Vue({
        el:'#app',
        data:getSubscriptionsData(),
        methods:{
            isSubscribed:function (job){
                let that = this;
                let ret = false;
                console.log(job);
                for ( i in that.subscriptions ){
                    if (that.subscriptions[i].id==job){
                        ret = true;
                        break;
                    }
                }
                return ret;
            },
            closeModal:function () {
                $('#job-modal').hide();
            },
            viewJob:function(job){
                this.viewingJob={...job};
                $('#job-modal').show();
            },
            resetViewingJob: function(){
                this.viewingJob={id:null};
                $('#job-modal').hide();
            },
            cancelApplication:function (job){
                let that = this;
                let data = {};
                data['_token']=$('[name="_token"]').val();
                data['job_id']=job;
                data['candidate_id']=that.candidate_id;
                that.saving=true;
                $.ajax({
                    url:'/cancel-application',
                    type:'POST',
                    data:data,
                    success:function (data){
                        that.saving=false;

                        for (i in that.subscriptions){
                            if (that.subscriptions[i].id==job)
                                that.subscriptions.splice(i,1);
                        }
                    }
                })
            }, 
            inFilter:function(job){
                console.log(job);
                let activeFilters ='';
                let tempJob={...job};
                console.log(tempJob);
                let contain = false;
                if (this.filters.length>0)
                    activeFilters = this.filters.split(" ");

                if (activeFilters.length>0){
                    for (i in activeFilters){
                        console.log("activefilter="+activeFilters[i]);
                        if (activeFilters[i]=="" || typeof activeFilters[i] == undefined || activeFilters[i]==null){
                            contain = false;
                            break;
                        }
                        for (j in tempJob){
                            console.log("tempjob="+tempJob[j]);
                            console.log(typeof tempJob[j]);
                            if (typeof tempJob[j] == 'string'){
                                console.log('testando...');
                                contain = tempJob[j].toLowerCase().includes(activeFilters[i].toLowerCase());
                            }
                            console.log(contain);
                            if (contain)
                                break;
                            else if (j=='tags'){
                                for (t in tempJob[j]){
                                    contain=false;
                                    console.log("typeof jt"+typeof tempJob[j][t]);
                                    if (typeof tempJob[j][t] != undefined)
                                        contain = tempJob[j][t]['name'].toLowerCase().includes(activeFilters[i].toLowerCase());
                                    if (contain)
                                        break;
                                }
                            }
                        }
                        if (contain)
                            break;
                    }
                    return contain;
                }
                return true;
            }
        },
    })
}


function candidateJobs(){
    candiJobs = new Vue({
        el:'#app',
        data:getJobsData(),
        computed:{
            canApply:function(){
                if (this.user_id!=0)
                    return false;
                return true;
            },
        },
        methods:{
            isSubscribed:function (job){
                let that = this;
                let ret = false;
                console.log(job);
                for ( i in that.subscriptions ){
                    if (that.subscriptions[i].id==job){
                        ret = true;
                        break;
                    }
                }
                return ret;
            },
            cancelApplication:function (job){
                let that = this;
                let data = {};
                data['_token']=$('[name="_token"]').val();
                data['job_id']=job;
                data['candidate_id']=that.candidate_id;
                that.saving=true;
                $.ajax({
                    url:'/cancel-application',
                    type:'POST',
                    data:data,
                    success:function (data){
                        that.saving=false;

                        for (i in that.subscriptions){
                            if (that.subscriptions[i].id==job)
                                that.subscriptions.splice(i,1);
                        }
                    }
                })
            }, 
            applyForJob:function (job){
                console.log(job);
                let that = this;
                let data = {};
                data['_token']=$('[name="_token"]').val();
                data['job_id']=job;
                data['candidate_id']=that.candidate_id;
                that.saving=true;
                $.ajax({
                    url:'/apply-for-job',
                    type:'POST',
                    data:data,
                    success:function (data){
                        that.saving=false;
                        console.log(data);
                        let tempscriptions = that.subscriptions;
                        let subscriptionew = null;

                        console.log("--------tempscriptions--------");
                        console.log(tempscriptions);
                        for (i in that.jobs){
                            if (that.jobs[i].id==job)
                                subscriptionew=that.jobs[i];
                        }
                        console.log(subscriptionew);
                        tempscriptions.push(subscriptionew);

                        console.log(tempscriptions);
                        that.subscriptions=tempscriptions;
                    }
                })
            },
            closeModal:function () {
                $('#job-modal').hide();
            },
            validateKey:function (loopKey,valueKey){
                if (loopKey==valueKey)
                    return true;
                return false;
            },
            resetViewingJob: function(){
                this.viewingJob={id:null};
                $('#job-modal').hide();
            },
            viewJob:function(job){
                this.viewingJob={...job};
                $('#job-modal').show();
            },
            inFilter:function(job){
                console.log(job);
                let activeFilters ='';
                let tempJob={...job};
                console.log(tempJob);
                let contain = false;
                if (this.filters.length>0)
                    activeFilters = this.filters.split(" ");

                if (activeFilters.length>0){
                    for (i in activeFilters){
                        console.log("activefilter="+activeFilters[i]);
                        if (activeFilters[i]=="" || typeof activeFilters[i] == undefined || activeFilters[i]==null){
                            contain = false;
                            break;
                        }
                        for (j in tempJob){
                            console.log("tempjob="+tempJob[j]);
                            console.log(typeof tempJob[j]);
                            if (typeof tempJob[j] == 'string'){
                                console.log('testando...');
                                contain = tempJob[j].toLowerCase().includes(activeFilters[i].toLowerCase());
                            }
                            console.log(contain);
                            if (contain)
                                break;
                            else if (j=='tags'){
                                for (t in tempJob[j]){
                                    contain=false;
                                    console.log("typeof jt"+typeof tempJob[j][t]);
                                    if (typeof tempJob[j][t] != undefined)
                                        contain = tempJob[j][t]['name'].toLowerCase().includes(activeFilters[i].toLowerCase());
                                    if (contain)
                                        break;
                                }
                            }
                        }
                        if (contain)
                            break;
                    }
                    return contain;
                }
                return true;
            }
        }
    });
}

function profile(){
    startProfile('profile-edit','candidate-data');
}

function startProfile(screenNameHelper='',firstTab=''){
    edit = new Vue({
        el:'#app',
        data: getCustomData(screenNameHelper,firstTab),
        computed: {
            stringedExcludedSchoolings:function () {
                that=this;
                return JSON.stringify(that.excluded_schoolings);
            },
            stringedExcludedExperiences:function () {
                that=this;
                return JSON.stringify(that.excluded_experiences);
            },
            stringedSchoolings:function () {
                that=this;
                return JSON.stringify(that.schoolings);
            },
            stringedExperiences:function () {
                that=this;
                return JSON.stringify(that.experiences);
            },
        },
        methods:{
            isItMe:function (who) {
                if (this.currentTab==who)
                    return true;
                return false;
            },
            validateKey:function (loopKey,valueKey){
                if (loopKey==valueKey)
                    return true;
                return false;
            },
            addSchooling:function (){
                this.schoolings.unshift(loadDefault('schoolings'));
            },
            addExperience:function (){
                this.experiences.unshift(loadDefault('experience'));
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
            },
            excludeSchooling: function(index) {
                let tempSchoolings=this.schoolings;
                let helper = {...this.schoolings[index]};
                tempSchoolings.splice(index,1);
                this.schoolings=tempSchoolings;
                let tempArray=this.excluded_schoolings;
                tempArray.push(helper.id);
                if (typeof helper.id != undefined)
                    this.excluded_schoolings=tempArray;
            },
            excludeExperience: function(index) {
                let tempExperience=this.experiences;
                let helper = {...this.experiences[index]};
                tempExperience.splice(index,1);
                this.experiences=tempExperience;
                let tempArray=this.excluded_experiences;
                tempArray.push(helper.id);
                if (typeof helper.id != undefined)
                    this.excluded_experiences=tempArray;
            },
        }
    })
}


function getCustomData(screenNameHelper,firstTab){
    let customData = {
        screenName:screenNameHelper,
        currentTab:firstTab,
        alwaysTrue:true,
        saving:false,
        excluded_schoolings:[],
        excluded_experiences:[],
    };
    if (screenNameHelper=='profile-edit'){
        customData.schoolings=JSON.parse(document.getElementById('schooling-data').value);
        customData.experiences=JSON.parse(document.getElementById('experience-data').value);
        customData.schooling_grades=JSON.parse(document.getElementById('schooling-grades').value);
        customData.schooling_status=JSON.parse(document.getElementById('schooling-status').value);
        customData.schooling_formation=JSON.parse(document.getElementById('schooling-formation').value);
    }
    return customData;
}

function getJobsData(){
    let customData={};
    customData.candidate_id=document.getElementById('candidate-id').value;
    customData.jobs=JSON.parse(document.getElementById('jobs-data').value);
    customData.fields=JSON.parse(document.getElementById('fields-data').value);
    customData.units=JSON.parse(document.getElementById('units-data').value);
    customData.subscriptions=JSON.parse(document.getElementById('subscriptions-data').value);
    customData.filters='';
    customData.user_id=document.getElementById('user-id').value;
    customData.saving=false;
    customData.viewingJob={
        id:null,
        field_id:1,
        unit_id:1,
    };
    console.log(customData);
    return customData;
}

function getSubscriptionsData(){
    let customData={};
    customData.candidate_id=document.getElementById('candidate-id').value;
    customData.subscriptions=JSON.parse(document.getElementById('subscriptions-data').value);
    customData.fields=JSON.parse(document.getElementById('fields-data').value);
    customData.units=JSON.parse(document.getElementById('units-data').value);
    customData.filters='';
    customData.viewingJob={
        id:null,
        field_id:1,
        unit_id:1,
    };

    return customData;
}

function loadDefault(which){
    if (which=="schoolings"){
        let helper = {
            formation:'',
            status:'',
            course:'',
            grade:'',
            institution:'',
            start:'2008-01-01',
            end:'2011-04-01'
        };
        return  helper;
    }
    else if (which=="experience"){
        let helper = {
            business:'',
            job:'',
            activities:'',
            admission:'2021-01-01',
            demission:'2021-06-01',
        };
        return  helper;
    }
}