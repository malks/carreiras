$(document).ready(function () {
    welcomeLogin();
    if ($('[profile-edit]')[0]!=undefined)
        profile();
    else if ($('[candidate-jobs]')[0]!=undefined)
        candidateJobs();
    else if ($('[candidate-subscriptions]')[0]!=undefined)
        candidateSubscription();
    else if ($('[check-jobs-home]')[0]!=undefined)
        homeJobs();
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
        computed:{
            printDescription:function (){
                if (this.viewingJob.id!=null)
                    return this.viewingJob.description.split("\r\n").join("<br>");
                return "";
            },
            printActivities:function (){
                if (this.viewingJob.id!=null)
                    return this.viewingJob.activities.split("\r\n").join("<br>");
                return "";
            },
            printRequired:function (){
                if (this.viewingJob.id!=null)
                    return this.viewingJob.required.split("\r\n").join("<br>");
                return "";
            },
            printDesirable:function (){
                if (this.viewingJob.id!=null)
                    return this.viewingJob.desirable.split("\r\n").join("<br>");
                return "";
            }

        },
        methods:{
            getSubscriptionState:function (job){
                let that = this;
                for (let i in that.subscriptions){
                    if (that.subscriptions[i].job_id==job)
                        return that.subscriptions[i].states[that.subscriptions[i].states.length-1].name
                }
                return "&nbsp";
            },
            getStatusClass:function (job){
                let that = this;
                let state_id=null;
                for (let i in that.subscriptions){
                    if (that.subscriptions[i].job_id==job)
                        state_id=that.subscriptions[i].states[that.subscriptions[i].states.length-1].name
                }
                if (state_id==2)
                    return 'red-color';
                else 
                    return 'green-color';
            },
            getSubscriptionsJob: function(subscription){
                let that = this;
                return that.jobs.find(obj => {
                    return obj.id==subscription.job_id;
                })
            },
            isSubscribed:function (job){
                let that = this;
                let ret = false;
                console.log(job);
                for ( i in that.subscriptions ){
                    if (that.subscriptions[i].job_id==job){
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
                            if (that.subscriptions[i].job_id==job)
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
            printDescription:function (){
                if (this.viewingJob.id!=null)
                    return this.viewingJob.description.split("\r\n").join("<br>");
                return "";
            },
            printActivities:function (){
                if (this.viewingJob.id!=null)
                    return this.viewingJob.activities.split("\r\n").join("<br>");
                return "";
            },
            printRequired:function (){
                if (this.viewingJob.id!=null)
                    return this.viewingJob.required.split("\r\n").join("<br>");
                return "";
            },
            printDesirable:function (){
                if (this.viewingJob.id!=null)
                    return this.viewingJob.desirable.split("\r\n").join("<br>");
                return "";
            }
        },
        methods:{
            getSubscriptionState:function (job){
                let that = this;
                for (let i in that.subscriptions){
                    if (that.subscriptions[i].job_id==job)
                        return that.subscriptions[i].states[that.subscriptions[i].states.length-1].name
                }
                return " &nbsp ";
            },
            isSubscribed:function (job){
                let that = this;
                let ret = false;
                console.log(job);
                for ( let i in that.subscriptions ){
                    if (that.subscriptions[i].job_id==job){
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
                            if (that.subscriptions[i].job_id==job)
                                that.subscriptions.splice(i,1);
                        }
                    }
                })
            }, 
            applyForJob:function (job){
                $('#observation-modal').show();
            },
            jobApply:function(){
                let job = this.viewingJob.id;
                if (this.user_id==0){
                    alert('Registre-se e faça o login para se inscrever.');
                    this.closeModal();
                    return false;
                }
                console.log(job);
                let that = this;
                let tempData = {};
                tempData['_token']=$('[name="_token"]').val();
                tempData['job_id']=job;
                tempData['candidate_id']=that.candidate_id;
                tempData['obs']=that.observation;
                tempData['states']=[{name:'Inscrito'}];
                that.saving=true;
                $.ajax({
                    url:'/apply-for-job',
                    type:'POST',
                    data:tempData,
                    success:function (){
                        that.saving=false;
                        let tempscriptions = that.subscriptions;
                        let subscriptionew = tempData;

                        tempscriptions.push(subscriptionew);

                        that.subscriptions=tempscriptions;
                    }
                })
            },
            closeModal:function () {
                this.viewingJob={id:null};
                $('#job-modal').hide();
            },
            closeObsModal:function () {
                this.jobApply();
                $('#observation-modal').hide();
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


function homeJobs(){
    $('#subscribe').click(function (){
        let subscriberData={};
        subscriberData['email']=$('#subscriber-email').val();
        subscriberData['_token']=$('[name="_token"]').val();
        $.ajax({
            url:'/newsletter-subscribe',
            type:'POST',
            data:subscriberData,
            success:function (data){
                console.log(data);
                $('#subscribe').text('Assinar');
                $('#subscriber-email').val('');
            }
        })
    });

    landingJobs = new Vue({
        el:'#home-jobs-app',
        data:getJobsData(),
        computed:{
            canApply:function(){
                if (this.user_id!=0)
                    return false;
                return true;
            },
            printDescription:function (){
                if (this.viewingJob.id!=null)
                    return this.viewingJob.description.split("\r\n").join("<br>");
                return "";
            },
            printActivities:function (){
                if (this.viewingJob.id!=null)
                    return this.viewingJob.activities.split("\r\n").join("<br>");
                return "";
            },
            printRequired:function (){
                if (this.viewingJob.id!=null)
                    return this.viewingJob.required.split("\r\n").join("<br>");
                return "";
            },
            printDesirable:function (){
                if (this.viewingJob.id!=null)
                    return this.viewingJob.desirable.split("\r\n").join("<br>");
                return "";
            }
        },
        methods:{
            isSubscribed:function (job){
                let that = this;
                let ret = false;
                console.log(job);
                for ( let i in that.subscriptions ){
                    if (that.subscriptions[i].job_id==job){
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
                            if (that.subscriptions[i].job_id==job)
                                that.subscriptions.splice(i,1);
                        }
                    }
                })
            },
            applyForJob:function (job){
                if (this.user_id==0){
                    alert('Registre-se e faça o login para se inscrever.');
                    this.closeModal();
                    window.location.href='/register';
                    return false;
                }
                $('#observation-modal').show();
            },
            jobApply:function(){
                let job = this.viewingJob.id;
                console.log(job);
                let that = this;
                let tempData = {};
                tempData['_token']=$('[name="_token"]').val();
                tempData['job_id']=job;
                tempData['candidate_id']=that.candidate_id;
                tempData['obs']=that.observation;
                that.saving=true;
                $.ajax({
                    url:'/apply-for-job',
                    type:'POST',
                    data:tempData,
                    success:function (){
                        that.saving=false;
                        let tempscriptions = that.subscriptions;
                        let subscriptionew = tempData;

                        tempscriptions.push(subscriptionew);

                        that.subscriptions=tempscriptions;
                    }
                })
            },
            closeModal:function () {
                this.viewingJob={id:null};
                $('#job-modal').hide();
            },
            closeObsModal:function () {
                this.jobApply();
                $('#observation-modal').hide();
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
                let theJob=this.jobs.find(obj => {
                    return obj.id==job;
                })
                this.viewingJob={...theJob};
                $('#job-modal').show();
            },
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
            currentInterestSize:function () {
                let len=this.currentInterest.length;
                if (len<10)
                    len=10;
                return "width:"+len+"0px;";
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
            filterTags:function(){
                let ctag=this.currentInterest;
                if (ctag.length==0)
                    this.filteredTags=[{id:null,name:""}];
                else
                    this.filteredTags=this.tags.filter(obj=>{
                        return obj.name.toLowerCase().startsWith(ctag.toLowerCase())==true;
                    })
            },
            selectTag:function (){
                let that=this;

                if (that.currentInterest.length==0)
                    return false;

                let filter = that.filteredTags;
                let tempTags=that.selectedTags;
                let tag = null;
                if (filter.length>0)
                    tag=filter[0].id;
                let newTag=that.tags.find(obj=>{ return obj.id==tag; });
                if (newTag)
                    tempTags.push(newTag);
                else
                    tempTags.push({id:null,name:that.currentInterest});
                that.selectedTags=tempTags;
                that.currentInterest="";
            },
            removeTag:function (idx){
                let that=this;
                let tempTags=that.selectedTags;
                tempTags.splice(idx,1);
            },
            targetInterestsInputFocus: function () {
                $('#interests-input').focus();
            },
            targetInterestsInputShow: function () {
                this.interestInput=true;
            },
            targetInterestsInputHide: function () {
                this.interestInput=false;
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
                let interests=JSON.stringify(that.selectedTags);
                $('#data-interests').val(interests);
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
        customData.tags=JSON.parse(document.getElementById('tags-data').value);
        customData.interestInput=false;
        customData.currentInterest='';
        if ($('#data-interests').val()!="")
            customData.selectedTags=JSON.parse($('#data-interests').val());
        else
            customData.selectedTags=[];
        customData.filteredTags=[];
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
    customData.observation='';
    customData.user_id=document.getElementById('user-id').value;
    customData.saving=false;
    customData.viewingJob={
        id:null,
        field_id:1,
        unit_id:1,
        description:"",
    };
    console.log(customData);
    return customData;
}

function getSubscriptionsData(){
    let customData={};
    customData.candidate_id=document.getElementById('candidate-id').value;
    customData.subscriptions=JSON.parse(document.getElementById('subscriptions-data').value);
    customData.jobs=JSON.parse(document.getElementById('jobs-data').value);
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