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
            getField:function (field_id){
                let ret = this.fields.find(obj=>{
                    return obj.id==field_id;
                });
                if (ret==undefined)
                    ret={name:''};
                return ret;
            },
            getUnit:function (unit_id){
                let ret = this.units.find(obj=>{
                    return obj.id==unit_id;
                });
                if (ret==undefined)
                    ret={name:''};
                return ret;
            },
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
                console.log(subscription);
                let ret=null;
                ret= that.jobs.find(obj => {
                    return obj.id==subscription.job_id;
                })
                if (ret==undefined)
                    ret={name:''};
                return ret;
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
                if (this.viewingJob.id!=null && this.viewingJob.description!=null)
                    return this.viewingJob.description.split("\r\n").join("<br>");
                return "";
            },
            printActivities:function (){
                if (this.viewingJob.id!=null && this.viewingJob.activities!=null)
                    return this.viewingJob.activities.split("\r\n").join("<br>");
                return "";
            },
            printRequired:function (){
                if (this.viewingJob.id!=null && this.viewingJob.required!=null)
                    return this.viewingJob.required.split("\r\n").join("<br>");
                return "";
            },
            printDesirable:function (){
                if (this.viewingJob.id!=null && this.viewingJob.desirable!=null)
                    return this.viewingJob.desirable.split("\r\n").join("<br>");
                return "";
            }
        },
        methods:{
            getField:function (field_id){
                let ret = this.fields.find(obj=>{
                    return obj.id==field_id;
                });
                if (ret==undefined)
                    ret={name:''};
                return ret;
            },
            getUnit:function (unit_id){
                let ret = this.units.find(obj=>{
                    return obj.id==unit_id;
                });
                if (ret==undefined)
                    ret={name:''};
                return ret;
            },
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
                                    if (tempJob[j][t] != undefined && tempJob[j][t] != null)
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
                if (this.viewingJob.id!=null && this.viewingJob.description!=undefined)
                    return this.viewingJob.description.split("\r\n").join("<br>");
                return "";
            },
            printActivities:function (){
                if (this.viewingJob.id!=null && this.viewingJob.activities!=undefined)
                    return this.viewingJob.activities.split("\r\n").join("<br>");
                return "";
            },
            printRequired:function (){
                if (this.viewingJob.id!=null && this.viewingJob.required!=undefined)
                    return this.viewingJob.required.split("\r\n").join("<br>");
                return "";
            },
            printDesirable:function (){
                if (this.viewingJob.id!=null && this.viewingJob.desirable!=undefined)
                    return this.viewingJob.desirable.split("\r\n").join("<br>");
                return "";
            }
        },
        methods:{
            getField:function (field_id){
                let ret = this.fields.find(obj=>{
                    return obj.id==field_id;
                });
                if (ret==null || ret==undefined || ret=='')
                    ret = {id:null,name:''};
                return ret;
            },
            getUnit:function (unit_id){
                let ret = this.units.find(obj=>{
                    return obj.id==unit_id;
                });
                if (ret==null || ret==undefined || ret=='')
                    ret = {id:null,name:''};
                return ret;
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
                this.viewingJob={id:null,name:''};
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

function validate(whichTab){
    let ret=[];
    let gotProblem={
        'candidate-data':   false,
        'schooling-data':   false,
        'experience-data':  false,
        'language-data':    false,
        'family-data':      false,
        'extra':            false,
        'questionary':      false,
    };
    switch(whichTab){
        case 'candidate-data':
            if ($('#data-name').val().length<3){
                ret.push({'candidate-data': 'Nome completo é necessário'});
            }
            if ($('#data-email').val().match(/^[a-z0-9._]+@[a-z0-9]+\.[a-z]+(\.[a-z]+)?$/i)==null){
                ret.push({'candidate-data': 'E-mail precisa ser válido'});
            }
            if (($('#data-ddd-phone').val().length<2 || $('#data-phone').val().length<9) && ($('#data-ddd-mobile').val().length<2 || $('#data-mobile').val().length<10 ) ){
                ret.push({'candidate-data': 'Telefone ou Celular são necessários'});
            }
            if ($('#data-dob').val().length<10){
                ret.push({'candidate-data': 'Data de nascimento é obrigatório'});
            }
            if ($('#data-address-street').val().length<4 || $('#data-address-city').val().length<4 || $('#data-address-district').val().length<4 || $('#data-address-state').val().length<2 || $('#data-address-country').val().length<3 || $('#data-address-zip').val().length<10){
                ret.push({'candidate-data': 'Endereço residencial é obrigatório'});
            }
            if ($('#data-cpf').val().length!=14){
                ret.push({'candidate-data': 'Documentos são obrigatórios'});
            }
            if ( $('#data-natural-city').val().length<4 || $('#data-natural-state').val().length<2 || $('#data-natural-country').val().length<3 ){
                ret.push({'candidate-data': 'Naturalidade é obrigatória'});
            }
            if ( $('#data-foreigner').val()==1){
                if ($('#data-data-arrival-date').val().length<10 || $('#data-foreign-register').val().length<5 || $('#data-foreign-emitter').val().length<3 || $    ('#data-visa-expiration').val()<10 ){
                    ret.push({'candidate-data': 'Se você é estrangeiro, os dados relacionados são obrigatórios'});
                }
            }
            if ( $('#data-deficiency').val()==1){
                if ($('#data-deficiency-type').val()==0 || $('#data-cid').val().length==0 ){
                    ret.push({'candidate-data': 'Se você tem alguma deficiência, os dados relacionados são obrigatórios'});
                }
            }
            if ( $('#data-mother-name').val().length<3 || 
                 $('#data-mother-dob').val().length<2 ){
                ret.push({'candidate-data': 'Dados da mãe obrigatórios'});
            }
            if ($('#data-pretended-salary').val().length<2 ){
                ret.push({'candidate-data': 'Pretensão salarial obrigatória'});
            }
            break;
        case 'schooling-data':
            if ($('#schooling-formation0')[0]==undefined || 
                $('#schooling-formation0').val()==null ||
                $('#schooling-status0').val()==null ||
                $('#schooling-course-0').val()==null ||
                $('#schooling-grade0').val()==null ||
                $('#schooling-institution0').val()==null ||
                $('#schooling-start0').val()==null ||
                $('#schooling-end0').val()==null
            ){
                ret.push({'schooling-data': 'Ao menos uma formação necessária.'});
                ret.push({"schooling-data": "As formações precisam ter todos os dados preenchidos."});
                ret.push({"schooling-data":"Você pode selecionar Fundamental ou Médio em formação para ensino fundamental e médio."});
            }
            /*if ($('#interests-holder .badge')[0]==undefined)
                ret.push({'extra': 'Informe ao menos uma área de interesse'});*/
            break;
        case 'experience-data':
            break;
        case 'language-data':
            break;
        case 'family-data':
            break;
        case 'extra':
            break;
    }

    return ret;
}

function jumpTab(current){
    let ret = current;
    switch (current){
        case 'candidate-data':
            ret='schooling-data';
            break;
        case 'schooling-data':
            ret='experience-data';
            break;
        case 'experience-data':
            ret='success';
            break;
        /*case 'language-data':
            ret='family-data';
            break;
        case 'family-data':
            ret='extra';
            break;
        case 'extra':
            ret='questionary';
            break;
        case 'questionary':
            ret='success';
            break;*/
        }
    window.scroll(0,0);

    return ret;
}

function canTab(current,trial){
    let ret = false;
    let freeTabbing={
        'candidate-data':   [],
        'schooling-data':   ['candidate-data'],
        'experience-data':  ['candidate-data','schooling-data'],
        'language-data':    ['candidate-data','schooling-data','experience-data'],
        'family-data':      ['candidate-data','schooling-data','experience-data','language-data'],
        'extra':            ['candidate-data','schooling-data','experience-data','language-data','family-data'],
        'questionary':      ['candidate-data','schooling-data','experience-data','language-data','family-data','extra'],
    }
    ret=freeTabbing[current].includes( trial );
    console.log(ret);
    return ret;
}

function dec2hex (dec) {
    return dec.toString(16).padStart(2, "0")
}
  
// generateId :: Integer -> String
function generateId (len) {
    var arr = new Uint8Array((len || 40) / 2)
    window.crypto.getRandomValues(arr)
    return Array.from(arr, dec2hex).join('')
}


function profile(){
    startProfile('profile-edit','candidate-data');
}

function startProfile(screenNameHelper='',firstTab=''){
    Vue.use(VueMask.VueMaskPlugin);
    
    edit = new Vue({
        el:'#app',
        data: getCustomData(screenNameHelper,firstTab),
        computed: {
            stringedExcludedSchoolings:function () {
                that=this;
                return JSON.stringify(that.excluded_schoolings);
            },
            stringedLanguages:function () {
                that=this;
                return JSON.stringify(that.selected_languages);
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
            tabTo:function (trialTab){
                let that = this;
                let stop = false;
                that.errors=validate(that.currentTab);
                for (i in that.errors){
                    stop = Object.keys(that.errors[i]).includes(that.currentTab);
                    if (stop)
                        break;
                }
                console.log(Object.keys(that.errors));
                console.log(stop);
                if (!stop || canTab(that.currentTab,trialTab)){
                    that.errors=[];
                    that.currentTab=trialTab;
                }
                return;
            },
            addLang:function () {
                this.selected_languages.push({id:"",pivot:{id:null,level:'basic'}})
            },
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
            getCep:function (){ 
                let that=this;
                if (that.holdingData.zip!=''){
                    let form = new FormData();
                    form.append('_token',$('[name="_token"]').val());
                    form.append('cep',that.holdingData.zip);

                    $.ajax({
                        url:'/busca-cep',
                        type:'POST',
                        processData: false,
                        contentType: false,            
                        data: form,
                        success:function (data){
                            console.log(data);
                            jdata= JSON.parse(data);
                            for (let i in jdata){
                                console.log(i);
                                if (i!='zip')
                                    that.holdingData['address_'+i]=jdata[i];
                            }
                        }
                    })
                }
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
            pickMe:function(tagIdx){
                let that=this;
                let tempTags=that.selectedTags;
                let newTag=that.filteredTags[tagIdx];
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
                that=this;
                let interests=JSON.stringify(that.selectedTags);
                $('#data-interests').val(interests);
                data=$('form').serialize();
                that.errors=validate(that.currentTab);
                if (that.errors.length==0){
                    that.saving=true;
                    $.ajax({
                        url:'/save-profile',
                        type:'POST',
                        data:data,
                        success:function (data){
                            let handler = null;
                            let temp_schoolings={...that.schoolings};
                            let temp_experiences={...that.experiences};
                            if (data){
                                handler=JSON.parse(data);
                                for (let i in temp_schoolings){
                                    if( that.schoolings[i].hash!=undefined && that.schoolings[i].hash!="" && that.schoolings[i].hash!=null && (that.schoolings[i].id==undefined || that.schoolings[i].id==null)){
                                        that.schoolings.splice(i,1);
                                        that.schoolings.unshift(handler.schoolings.find(obj => { return obj.hash==temp_schoolings[i].hash}));
                                    }
                                }
                                for (let i in temp_experiences){
                                    if( that.experiences[i].hash!=undefined && that.experiences[i].hash!="" && that.experiences[i].hash!=null && (that.experiences[i].id==undefined || that.experiences[i].id==null)){
                                        that.experiences.splice(i,1);
                                        that.experiences.unshift(handler.experiences.find(obj => { return obj.hash==temp_experiences[i].hash}));
                                    }
                                }
                            }
                            that.saving=false;
                            that.currentTab=jumpTab(that.currentTab);
                        }
                    })
                }
                else
                    window.scroll(0,0);
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
        errors:[],
    };
    if (screenNameHelper=='profile-edit'){
        customData.schoolings=JSON.parse(document.getElementById('schooling-data').value);
        customData.experiences=JSON.parse(document.getElementById('experience-data').value);
        customData.tags=JSON.parse(document.getElementById('tags-data').value);
        customData.interestInput=false;
        customData.currentInterest='';
        if ($('#data-interests').val()!="")
            customData.selectedTags=JSON.parse(decodeURIComponent($('#data-interests').val()).replace(/\+/g," "));
        else
            customData.selectedTags=[];
        customData.filteredTags=[];
        customData.schooling_grades=JSON.parse(document.getElementById('schooling-grades').value);
        customData.schooling_status=JSON.parse(document.getElementById('schooling-status').value);
        customData.schooling_formation=JSON.parse(document.getElementById('schooling-formation').value);
        customData.selected_languages=JSON.parse(document.getElementById('selected-languages').value);
        customData.languages=JSON.parse(document.getElementById('languages').value);
        customData.holdingData=JSON.parse(decodeURIComponent(profile_data).replace(/\+/g," "));
        if (customData.holdingData.prefered_work_period==undefined || customData.holdingData.prefered_work_period.length==0)
            customData.holdingData.prefered_work_period=[];
    }
    console.log(customData);
    return customData;
}

function getJobsData(){
    let customData={};
    customData.candidate_id=document.getElementById('candidate-id').value;
    customData.jobs=JSON.parse(decodeURIComponent(document.getElementById('jobs-data').value).replace(/\+/g," "));
    customData.fields=JSON.parse(decodeURIComponent(document.getElementById('fields-data').value).replace(/\+/g," "));
    customData.units=JSON.parse(decodeURIComponent(document.getElementById('units-data').value).replace(/\+/g," "));
    customData.subscriptions=JSON.parse(decodeURIComponent(document.getElementById('subscriptions-data').value));
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
    customData.subscriptions=JSON.parse(decodeURIComponent(document.getElementById('subscriptions-data').value).replace(/\+/g," "));
    customData.jobs=JSON.parse(decodeURIComponent(document.getElementById('jobs-data').value).replace(/\+/g," "));
    customData.fields=JSON.parse(decodeURIComponent(document.getElementById('fields-data').value).replace(/\+/g," "));
    customData.units=JSON.parse(decodeURIComponent(document.getElementById('units-data').value).replace(/\+/g," "));
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
            hash:generateId(7),
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
            hash:generateId(7),
            business:'',
            job:'',
            activities:'',
            admission:'2021-01-01',
            demission:'2021-06-01',
        };
        return  helper;
    }
}