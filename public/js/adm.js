var recruitMachine = null;
let admConf=null;
let edit=null;
let fullData=null;
let selectedIds=Array();
let ajaxUrl="";
let form = new FormData();


$(document).ready(function () {
    if ($('[check-fields-list]').length>0)
        fieldsList();
    if ($('[check-subscribers-list]').length>0)
        subscribersList();
    if ($('[check-states-list]').length>0)
        statesList();
    if ($('[check-candidates-list]').length>0)
        candidatesList();
    if ($('[check-jobs-list]').length>0)
        jobsList();
    if ($('[check-roles-list]').length>0)
        rolesList();
    if ($('[check-jobs-templates-list]').length>0)
        jobsTemplatesList();
    if ($('[check-units-list]').length>0)
        unitsList();
    if ($('[check-users-list]').length>0)
        usersList();
    if ($('[check-tags-list]').length>0)
        tagsList();
    if ($('[check-candidates-edit]').length>0)
        editCandidate();
    if ($('[check-recruiting]').length>0)
        recruiting();
    if ($('#configurations').length>0)
        configurations();
    if ($('#jobs-tags').length>0)
        editJobs();
    if ($('#jobs-templates-tags').length>0)
        editJobsTemplates();

})

function editJobs(){
    let jobsEdit=new Vue({
        el:'#jobs-tags',
        data:{
            currentInterest:"",
            filteredTags:[],
            tags:JSON.parse($('#all-tags').val()),
            selectedTags:JSON.parse($('#initial-tags').val()),
            interestInput:'',
            currentInterestSize:0
        },
        computed:{
            stringedTags:function () {
                let that = this;
                return JSON.stringify(that.selectedTags);
            }
        },
        methods:{
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
        }
    })
}

function editJobsTemplates(){
    let jobsTemplatesEdit=new Vue({
        el:'#jobs-templates-tags',
        data:{
            currentInterest:"",
            filteredTags:[],
            tags:JSON.parse($('#all-tags').val()),
            selectedTags:JSON.parse($('#initial-tags').val()),
            interestInput:'',
            currentInterestSize:0
        },
        computed:{
            stringedTags:function () {
                let that = this;
                return JSON.stringify(that.selectedTags);
            }
        },
        methods:{
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
        }
    })
}


function recruiting(){
    let bootstrapData = {
        runData: {
            jobs:null,
            jobStatusNames:{
                1:'Ativo',
                0:'Inativo',
            },
            states:[],
            subscriptions:null,
            selectedJob:{
                id:null,
                subscriptions:null,
            },
            notingSubscription:{
                id:null,
                notes:null,
            },
            notepad:false,
            saving:false,
            updating:false,
            specificFilter:false,
        },
        pushData: {
            filters: {
                jobs: {
                    direct:{
                        like:{
                            name:''
                        },
                        in:{
                            field_id:"",
                            unit_id:"",
                            status:[]
                        },
                        gt:{
                            created_at:''
                        },
                        lt:{
                            created_at:''
                        }
                    },
                    deep:{
                        "subscriptions":{
                            mustHave:{
                                states:{
                                    in: {
                                        state_id:[1],
                                    }
                                },
                            }
                        },
                        tags:{
                            like:{
                                name:''
                            }
                        },
                    },
                },
            },
        },
        persistentData:{
            subscriptions:null,
        },
        otherData:{
            jobSearch:'',
            jobNameSearch:'',
            jobTagSearch:'',
            candidateNameSearch:'',
            candidateTagSearch:'',
            candidateExpSearch:'',
            tagFilters:'',
        }
    };
    console.log(bootstrapData);

    recruitMachine=new Vue({
        el:'#app',
        data: {...bootstrapData},
        computed:{
            jobSize:function(){
                if (this.runData.selectedJob.id!=null)
                    return "col-4";
                return "col-8";
            },
            candidateSize: function(){
                if (this.runData.selectedJob.id!=null)
                    return "col-8";
                return "col-4";
            },
            notingObservation:function () {
                let obs = "";
                if (this.runData.notingSubscription.obs!==undefined)
                    obs=this.runData.notingSubscription.obs;
                return obs.split("\n");
            }
        },
        mounted:function () {
            this.updateData();
        },
        methods:{
            specificFilter:function (who){
                if (!this.runData.specificFilter || this.pushData.filters.jobs.deep.subscriptions.mustHave.states.in.state_id.indexOf(who.states[who.states.length-1].id)!=-1)
                    return true;
                return false;
            },
            viewCandidate:function(subscription){
                let helper = null;
                helper = subscription.states.find(obj=>{
                    return obj.name.toLowerCase()=="visualizado";
                })
                if (typeof helper==undefined || helper==null)
                    this.addSubscriptionState(subscription.candidate_id,subscription.job_id,'visualizado');
            },
            addSubscriptionState:function (who,where,what){
                let that = this;
                console.log(that.runData.selectedJob);
                let persistentData=that.persistentData;
                persistentData['_token']=$('[name="_token"]').val();
                persistentData['candidate_id']=who;
                persistentData['job_id']=where;
                persistentData['status']=what;
                console.log(persistentData);
                $.ajax({
                    url:'/adm/add-subscription-state',
                    type:'POST',
                    data:persistentData,
                    success:function (data){
                        that.updateData();
                        console.log(that.runData.selectedJob);
                    }
                });
            },
            updateNotes:function (){
                this.runData.saving=true;
                let that = this;
                let persistentData=that.persistentData;
                persistentData['_token']=$('[name="_token"]').val();
                persistentData['subscription']=that.runData.notingSubscription;
                $.ajax({
                    url:'/adm/update-subscription-note',
                    type:'POST',
                    data:persistentData,
                    success:function(data){
                        that.updateData();
                        that.closeNotes();
                        that.runData.saving=false;
                    }
                })
            },
            showNotes:function(subscription){
                this.runData.notepad=true;
                this.runData.notingSubscription=subscription;
                $('#note-modal').show();
            },
            closeNotes:function (){
                this.runData.notepad=false;
                this.runData.notingSubscription={...this.runData.notingSubscription};
                $('#note-modal').hide();
            },
            compareData: function (loopData,currentData){
                if (loopData==currentData)
                    return true;
                return false;
            },
            notYet:function (what) {
                if (what===null)
                    return true;
                return false;
            },
            getCandidate:function (subscription){
                let ret = null;
                this.runData.jobs.find(obj=>{
                    ret =  obj.subscribers.find(inobj=>{
                        return inobj.id===subscription.candidate_id;
                    })
                    return ret;
                })
                return ret;
            },
            getState:function(id){
                let ret = this.runData.states.find(obj=>{
                    return obj.id==id; 
                })
                return ret;
            },
            checkedState:function (id){
                let helper = 0;
                helper = this.pushData.filters.jobs.deep.subscriptions.mustHave.states.in.state_id.indexOf(id);
                if (helper!=-1)
                    return true;
                return false;
            },
            checkState:function (id){
                let helper = 0;
                helper = this.pushData.filters.jobs.deep.subscriptions.mustHave.states.in.state_id.indexOf(id);
                if (helper==-1)
                    this.pushData.filters.jobs.deep.subscriptions.mustHave.states.in.state_id.push(id);
                else
                    this.pushData.filters.jobs.deep.subscriptions.mustHave.states.in.state_id.splice(helper,1);
                this.updateData();
            },
            getUnitById:function(id){
                let ret = this.runData.units.find(obj=>{
                    return obj.id==id; 
                })
                return ret;
            },
            getFieldById:function(id){
                let ret = this.runData.fields.find(obj=>{
                    return obj.id==id; 
                })
                if(ret==undefined)
                    ret={'name':'Sem área definida'};
                return ret;
            },
            inspectJob:function(job){
                console.log("inspectJob");
                let that = this;
                console.log(this.runData.selectedJob);
                if (this.runData.selectedJob.id==null || this.runData.selectedJob.id!=job.id){
                    this.runData.selectedJob={...job};
                    for (let i in that.runData.selectedJob.subscriptions){
                        that.runData.selectedJob.subscriptions[i].current_state=that.runData.selectedJob.subscriptions[i].states[that.runData.selectedJob.subscriptions[i].states.length-1].id;
                    }
                    that.runData.subscriptions=that.runData.selectedJob.subscriptions;
                }
                else{
                    that.runData.selectedJob={...bootstrapData.selectedJob};
                    that.runData.subscriptions={...bootstrapData.subscriptions};
                }
            },
            updateSelectedJob:function (){
                console.log("updateSelectedJob");
                let that = this;
                if (this.runData.selectedJob.id!=null){
                    this.runData.selectedJob=this.runData.jobs.find(obj=>{
                       return obj.id==this.runData.selectedJob.id;
                    });
                    if (this.runData.selectedJob==undefined){
                        this.runData.selectedJob={...bootstrapData.selectedJob};
                        console.log(this.runData.selectedJob);
                    }
                    else{
                        for (let i in that.runData.selectedJob.subscriptions){
                            that.runData.selectedJob.subscriptions[i].current_state=that.runData.selectedJob.subscriptions[i].states[that.runData.selectedJob.subscriptions[i].states.length-1].id;
                        }
                    }
                    that.runData.subscriptions=that.runData.selectedJob.subscriptions;
                }
            },
            updateData:function (){
                let that = this;
                console.log(that.runData);
                let pushData=that.pushData;
                pushData.filters.jobs.direct.like.name="";
              //  pushData.filters.jobs.mustHave.tags.name="";
                if(that.otherData.jobSearch!=""){
                    pushData.filters.jobs.direct.like.name=that.otherData.jobSearch;
                }
                /*if (that.otherData.jobTagSearch!=""){
                    pushData.filters.jobs.mustHave.tags.name=that.otherData.jobTagSearch;
                }*/
                pushData['_token']=$('[name="_token"]').val();
                this.runData.updating=true;
                $.ajax({
                    url:'/adm/recruiting-data',
                    type:'POST',
                    data:pushData,
                    success:function (data){
                        let objData=JSON.parse(data);
                        for (let i in objData){
                            console.log(i);
                            that.runData[i]=objData[i];
                        }
                        that.updateSelectedJob();
                        console.log(that.runData);
                        that.runData.updating=false;
                        if(that.pushData.filters.jobs.direct.lt.created_at=='')
                            that.pushData.filters.jobs.direct.lt.created_at=objData['date_filter_end'];
                        if(that.pushData.filters.jobs.direct.gt.created_at=='')
                            that.pushData.filters.jobs.direct.gt.created_at=objData['date_filter_start'];
                    }
                });
            },
            inJobNameFilter:function (job) {
                let contain=true;
                let activeFilters="";
                if(this.otherData.jobNameSearch.length>0){
                    contain=false;
                    activeFilters = this.otherData.jobNameSearch.split(" ");
                    for (let i in activeFilters){
                        if (activeFilters[i]=="" || typeof activeFilters[i] == undefined || activeFilters[i]==null){
                            contain = false;
                            break;
                        }
                        if (job.name.toLowerCase().includes(activeFilters[i].toLowerCase())){
                            contain=true;
                            break;
                        }
                    }
                }
                return contain;
            },
            candidateNameFilter:function (candidate) {
                let contain=true;
                let activeFilters="";
                if(this.otherData.candidateNameSearch.length>0){
                    contain=false;
                    activeFilters = this.otherData.candidateNameSearch.split(" ");
                    for (let i in activeFilters){
                        if (activeFilters[i]=="" || typeof activeFilters[i] == undefined || activeFilters[i]==null){
                            contain = false;
                            break;
                        }
                        if (candidate.name.toLowerCase().includes(activeFilters[i].toLowerCase())){
                            contain=true;
                            break;
                        }
                    }
                }
                return contain;
            },
            candidateTagFilter:function (candidate) {
                let contain=true;
                let activeFilters="";
                let dudeTags=candidate['interests'];
                if(this.otherData.candidateTagSearch.length>0){
                    contain=false;
                    activeFilters = this.otherData.candidateTagSearch.split(" ");
                    for (let i in activeFilters){
                        if (activeFilters[i]=="" || typeof activeFilters[i] == undefined || activeFilters[i]==null){
                            contain = false;
                            break;
                        }
                        for (let j in dudeTags){
                            if (dudeTags[j].name.toLowerCase().includes(activeFilters[i].toLowerCase())){
                                contain=true;
                                break;
                            }
                        }
                        if (contain)
                            break;
                    }
                }
                return contain;
            },
            candidateExpFilter:function (candidate){
                let contain=true;
                let activeFilters="";
                let dudeExps=candidate['experience'];
                if(this.otherData.candidateExpSearch.length>0){
                    contain=false;
                    activeFilters = this.otherData.candidateExpSearch.split(" ");
                    for (let i in activeFilters){
                        if (activeFilters[i]=="" || typeof activeFilters[i] == undefined || activeFilters[i]==null){
                            contain = false;
                            break;
                        }
                        for (let j in dudeExps){
                            if (dudeExps[j].activities.toLowerCase().includes(activeFilters[i].toLowerCase())){
                                contain=true;
                                break;
                            }
                        }
                        if (contain)
                            break;
                    }
                }
                return contain;
            },
            inFilter:function(job){
                console.log(job);
                let activeFilters ='';
                let tempJob={...job};
                console.log(tempJob);
                let contain = false;
                if (this.otherData.tagFilters.length>0)
                    activeFilters = this.otherData.tagFilters.split(" ");

                if (activeFilters.length>0){
                    for (let i in activeFilters){
                        if(activeFilters[i].length>0){
                            console.log("activefilter="+activeFilters[i]);
                            if (activeFilters[i]=="" || typeof activeFilters[i] == undefined || activeFilters[i]==null){
                                contain = false;
                                break;
                            }
                            if(tempJob['tags'].length==0){
                                contain=false;
                                break;
                            }
                            if (tempJob['tags'] != undefined && tempJob['tags'].length>0){
                                for (let t in tempJob['tags']){
                                    if (tempJob['tags'][t] != undefined)
                                        contain = tempJob['tags'][t]['name'].toLowerCase().includes(activeFilters[i].toLowerCase());
                                    if (contain)
                                        break;
                                }
                                if (contain)
                                    break;
                            }
                        }
                    }
                    return contain;
                }
                return true;
            }
        },
    });
}

function startData(){
    fullData=JSON.parse($('#full-data').val());
    ajaxUrl="";
    form.append('_token',$('[name="_token"]').val());
}


function statesList(){
    startData();
    ajaxUrl=$('#app').attr('action');
    startList([1,2,3,4,5],[1,2,3,4,5]);
    $('#search').focus();
}

function rolesList(){
    startData();
    ajaxUrl=$('#app').attr('action');
    startList([1,2],[1,2]);
    $('#search').focus();
}

function fieldsList(){
    startData();
    ajaxUrl=$('#app').attr('action');
    startList();
    $('#search').focus();
}

function subscribersList(){
    startData();
    ajaxUrl=$('#app').attr('action');
    startList();
    $('#search').focus();
}

function candidatesList(){
    startData();
    ajaxUrl=$('#app').attr('action');
    startList();
    $('#search').focus();
}

function unitsList(){
    startData();
    ajaxUrl=$('#app').attr('action');
    startList();
    $('#search').focus();
}

function tagsList(){
    startData();
    ajaxUrl=$('#app').attr('action');
    startList();
    $('#search').focus();
}

function usersList(){
    startData();
    ajaxUrl=$('#app').attr('action');
    startList();
    $('#search').focus();
}

function jobsList(){
    startData();
    ajaxUrl=$('#app').attr('action');
    startList();
    $('#search').focus();
}

function jobsTemplatesList(){
    startData();
    ajaxUrl=$('#app').attr('action');
    startList();
    $('#search').focus();
}

function startList(blockEditIds=[],blockDeleteIds=[]){
    console.log('lalala');
    let list = null;
    let logged_id=$('#logged-id').val();
    list=new Vue({
        el:'#app',
        data:{
            selectedIds:new Array(),
            blockEditIds:blockEditIds,
            blockDeleteIds:blockDeleteIds,
            logged_id:logged_id,
        },
        computed:{
            canEdit:function(){
                let that = this;
                if (that.blockEditIds.length>0){
                    for (let i=0;i<that.blockEditIds.length;i++){
                        if (that.selectedIds.indexOf(that.blockEditIds[i])!==-1)
                            return true;
                    }
                }
                if (that.selectedIds.length==1)
                    return false;
                return true;
            },
            canDestroy:function(){
                let that = this;
                if (logged_id!=null && that.selectedIds==logged_id)
                    return true;
                if (that.blockDeleteIds.length>0){
                    for (let i=0;i<that.blockDeleteIds.length;i++){
                        if (that.selectedIds.indexOf(that.blockDeleteIds[i])!==-1)
                            return true;
                    }
                }
                if (this.selectedIds.length>0)
                    return false;
                return true;
            }
        },
        methods:{
            addItem:function(id){
                let idx=this.selectedIds.findIndex(el=>el == id);
                if(idx>=0)
                    this.selectedIds.splice(idx,1);
                else
                    this.selectedIds.push(id);
            },
            reverseSelection:function(){
                console.log(fullData);
                for (let i in fullData){
                    let idx=this.selectedIds.findIndex(el=>el == fullData[i].id);
                    if(idx>=0)
                        this.selectedIds.splice(idx,1);
                    else
                        this.selectedIds.push(fullData[i].id);
                }
            },
            edit:function(){
                window.location.href=ajaxUrl+'/edit/'+this.selectedIds[0];
            },
            destroy:function(){
                let that=this;
                form.append('ids',that.selectedIds);
                if(confirm('Tem certeza que deseja excluir?')){
                    $.ajax({
                        url:ajaxUrl+'/destroy',
                        type:'POST',
                        processData: false,
                        contentType: false,			    
                        data:form,
                        success:function(data){
                            window.location.reload();
                        }
                    });
                }
   
            },
            jobFromTemplate:function (){
                window.open('/adm/jobs/create?template='+this.selectedIds[0],'_blank');
            },
            templateFromJob:function (){
                window.open('/adm/jobs-templates/create?job='+this.selectedIds[0],'_blank');
            }
        }
    });
}

function editCandidate(){
    startEdit('editCandidate','candidate-data');
}


function startEdit(screenNameHelper='',firstTab=''){
    edit = new Vue({
        el:'#app',
        data: getCustomData(screenNameHelper,firstTab),
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
        }
    })
}

function getCustomData(screenNameHelper,firstTab){
    let customData = {
        screenName:screenNameHelper,
        currentTab:firstTab,
        alwaysTrue:true,
    };
    if (screenNameHelper=='editCandidate'){
        customData.schoolings=JSON.parse(document.getElementById('schooling-data').value);
        customData.experiences=JSON.parse(document.getElementById('experience-data').value);
        customData.schooling_grades=JSON.parse(document.getElementById('schooling-grades').value);
        customData.schooling_status=JSON.parse(document.getElementById('schooling-status').value);
    }
    return customData;
}

function dropper(it){
    console.log(it);
}

function closeBannerModal(){
    $('#banner-modal').hide();
}

function configurations(){
    let form = new FormData();
    form.append('_token',$('[name="_token"]').val());
    
    let bannerData=null;
    let otherConfStarter={
        about_us:{},
        our_numbers:{},
        our_team:{},
        video:{},
    };

    $.ajax({
        url:'/adm/banners-list',
        type:"post",
        processData: false,
        contentType: false,
        data:form,
        success:function (data){
            bannerData=data['data'];
            admConf.banners=bannerData;
        }
    })

    $.ajax({
        url:'/adm/config-data',
        type:"post",
        processData: false,
        contentType: false,
        data:form,
        success:function (data){
            let otherConf=JSON.parse(data);
            console.log(otherConf);
            admConf.otherConf=otherConf;
            $('#testimonial-author-pic').attr('src','/img/'+otherConf.about_us.testimonial_author_picture);
            $('#video-pic').attr('src','/img/'+otherConf.video.face);
        }
    })

    $('#banner-modal [data-bs-dismiss]').click(function () {
        $('#banner-modal').hide();
    })

    $('#change-banner-background').click(function () {
        console.log("lalal");
    })

    let defaultEditingBanner={
        id:null,
        name:'',
        title_big:'',
        title_big_color:'',
        title_big_outline:'',
        title_small:'',
        title_small_color:'',
        title_small_outline:'',
        cta:'',
        background:'',
        active_from:'1970-01-01',
        active_to:'2030-01-01',
        order:''
    };

    admConf = new Vue({
        el:'#configurations',
        data:{
            otherConf:otherConfStarter,
            banners:null,
            movingBanner:null,
            saving:false,
            selectedBanner:null,
            editingBanner:{...defaultEditingBanner},
            bannerBackground:null,
            currentTab:'banners',
        },
        computed:{
            savingText:function (){
                if (this.saving)
                    return "Salvando...";
                return "Salvar";
            },
            canEdit:function(){
                if (this.selectedBanner!=null)
                    return false;
                return true;
            }
        },
        methods:{
            isItMe:function(id){
                let that = this;
                if (id==that.currentTab)
                    return true;
                return false;
            },
            showNumber:function (what){
                let that = this;
                if (that.otherConf.our_numbers[what].removal!=undefined && that.otherConf.our_numbers[what].removal==1)
                    return false;
                return true;
            },
            removeNumber:function (which){
                let that = this;
                let tmpConf=[...that.otherConf.our_numbers];
                tmpConf[which].removal=1;
                console.log(tmpConf);
                that.otherConf.our_numbers=tmpConf;
                console.log(that.otherConf.our_numbers);
            },
            addNumber:function () {
                let that = this;
                that.otherConf.our_numbers.unshift({id:''});
            },
            showTeam:function (what){
                let that = this;
                if (that.otherConf.our_team[what].removal!=undefined && that.otherConf.our_team[what].removal==1)
                    return false;
                return true;
            },
            removeTeam:function (which){
                let that = this;
                let tmpConf=[...that.otherConf.our_team];
                tmpConf[which].removal=1;
                console.log(tmpConf);
                that.otherConf.our_team=tmpConf;
                console.log(that.otherConf.our_team);
            },
            addTeam:function () {
                let that = this;
                that.otherConf.our_team.unshift({id:''});
            },
            updateTeamPic:function(which){
                let that = this;
                that.otherConf.our_team[which].picture=URL.createObjectURL($('#team-pic-picker-'+which)[0].files[0]);
            },
            saveOtherConf:function(which){
                this.saving=true;
                let that = this;
                form = new FormData();
                form.append('_token',$('[name="_token"]').val());
                form.append('which', which);
                form.append('data', JSON.stringify(that.otherConf[which]));
                if (which=='about_us'){
                    form.append('testimonial_author_picture', document.getElementById('testimonial-author-picture').files[0]);
                }
                else if (which=='our_team'){
                    $('.team-pic-picker').each(function ()  {
                        let it=this;
                        console.log($(it)[0].files[0]);
                        form.append($(it).attr('id').replace(/-/g,"_"),$(it)[0].files[0]);
                    })
                    console.log(form);
                }
                else if (which=='video'){
                    form.append('video_picture',document.getElementById('video-picture').files[0]);
                }
                $.ajax({
                    url:'/adm/save-other-conf',
                    type:'POST',
                    processData: false,
                    contentType: false,
                    data:form,
                    success:function(data){
                        that.saving=false;
                        let bannerIframe=document.getElementById('banner-iframe');
                        bannerIframe.src=bannerIframe.src;
                    }
                })

            },
            updateTestimonialAuthorPicture:function(event){
                $('#testimonial-author-pic').attr('src',URL.createObjectURL(event.target.files[0]));
            },
            updateVideoPicture:function(event){
                $('#video-pic').attr('src',URL.createObjectURL(event.target.files[0]));
            },
            addBanner:function (){
                let nbanner={...defaultEditingBanner};
                nbanner.id=0;
                nbanner.name='Novo Banner';
                nbanner.order=this.banners.length+1;
                this.banners.push(nbanner);
            },
            reloadBanners:function (){
                let that=this;
                form = new FormData();
                form.append('_token',$('[name="_token"]').val());
            
                $.ajax({
                    url:'/adm/banners-list',
                    type:"post",
                    processData: false,
                    contentType: false,
                    data:form,
                    success:function (data){
                        let reloadedBanners=data['data'];
                        that.banners=reloadedBanners;
                    }
                })
            },
            previewImage:function (event){
                form = new FormData();
                form.append('background_file', event.target.files[0]);
                this.editingBanner.background=URL.createObjectURL(event.target.files[0]);
            },
            changeBannerBackground:function (){
                $('#banner-background-picker').click();
            },
            selectBanner:function(id){
                if (this.selectedBanner==null || this.selectedBanner!=id)
                    this.selectedBanner=id;
                else{
                    this.selectedBanner=null;
                    $('.dropzone').blur();
                }
                console.log(this.selectedBanner);
            },
            resetEditingBanner: function (){
                this.editingBanner={...defaultEditingBanner};
                this.selectedBanner=null;
                $('#banner-modal').hide();
            },
            editBanner:function(){
                let that=this;
                this.banners.filter(obj => {
                    if( obj.id === that.selectedBanner){
                        $('#banner-modal').show();
                        console.log(obj);
                        that.editingBanner={...obj};
                    }
                    return false;
                });
            },
            deleteBanner:function(){
                let that=this;
                if (confirm('Tem certeza de que deseja excluir?')){
                    form = new FormData();
                    form.append('_token',$('[name="_token"]').val());
                    form.append('banner_id',that.selectedBanner);
                    $.ajax({
                        url:'/adm/delete-banner',
                        type:'POST',
                        processData: false,
                        contentType: false,
                        data:form,
                        success:function(data){
                            let tempBanners=that.banners;
                            for (let i in tempBanners){
                                if (tempBanners[i].id==that.selectedBanner)
                                    tempBanners.splice(i,1);
                            }
                            that.banners=tempBanners;
                            that.resetEditingBanner();
                        }
                    });
                };
            },
            activeBanner:function(id){
                if (this.selectedBanner==id)
                    return true;
                return false;
            },
            updateBanner:function() {
                this.saving=true;
                let that = this;
                form = new FormData();
                form.append('_token',$('[name="_token"]').val());
                form.append('banner', JSON.stringify(that.editingBanner));
                form.append('background_file', document.getElementById('banner-background-picker').files[0]);
                $.ajax({
                    url:'/adm/update-banner',
                    type:'POST',
                    processData: false,
                    contentType: false,
                    data:form,
                    success:function(data){
                        that.saving=false;
                        let bannerIframe=document.getElementById('banner-iframe');
                        that.reloadBanners();
                        bannerIframe.src=bannerIframe.src;
                        $('#banner-modal').hide();
                        that.resetEditingBanner();
                    }
                })
            },
            saveBanners:function (){
                this.saving=true;
                let that = this;
                form = new FormData();
                form.append('_token',$('[name="_token"]').val());
                form.append('banners', JSON.stringify(that.banners));
                $.ajax({
                    url:'/adm/save-banners',
                    type:'POST',
                    processData: false,
                    contentType: false,
                    data:form,
                    success:function(data){
                        console.log(data);
                        that.saving=false;
                        let bannerIframe=document.getElementById('banner-iframe');
                        bannerIframe.src=bannerIframe.src;
                    }
                })
            },
            dragOver:function (item) {
                item.preventDefault();
                //console.log(item);
            },
            dragMove:function (item) {
                item.dataTransfer.setData("text", item.target.getAttribute('data-key'));
                this.movingBanner=item.target;
            },
            dragEnd:function (item){
                item.preventDefault();
                // console.log(item);
            },
            dragDrop:function (item){
                item.preventDefault();
                let that = this;

                if (item.target.className.indexOf("dropzone")!=-1){
                    let movedKey = item.dataTransfer.getData("text");
                    let tempBanner = this.banners[movedKey-1];
                    if (item.target.getAttribute('data-key')!=movedKey){
                        this.banners.splice(movedKey-1,1);
        
                        let newbanners = Array();
                        for (let i=0;i<that.banners.length;i++){
                            if((i+1)==item.target.getAttribute('data-key'))
                                newbanners.push(tempBanner);
                            newbanners.push(that.banners[i]);
                        }
                        for (let i=0;i<newbanners.length;i++){
                            newbanners[i].order=i+1;
                        }
                        this.banners = null;
                        this.banners = newbanners;
                        //Vue.set(admConf.banners,0,newbanners[0]);

                        console.log(this.banners);
                    }
                }
            }            
        },
        watch:{
            currentTab:function(val){
                if (val=='banners')
                    $('#banner-iframe')[0].contentWindow.scroll(0,0);
                else if (val=='about_us')
                    $('#banner-iframe')[0].contentWindow.scroll(0,$('#banner-iframe')[0].contentWindow.document.getElementById('about-home').offsetTop+150);
                else if (val=='our_numbers')
                    $('#banner-iframe')[0].contentWindow.scroll(0,$('#banner-iframe')[0].contentWindow.document.getElementById('about-home').offsetTop+240);
                else if (val=='our_team')
                    $('#banner-iframe')[0].contentWindow.scroll(0,$('#banner-iframe')[0].contentWindow.document.getElementById('our-team-home').offsetTop+100);
                else if (val=='video')
                    $('#banner-iframe')[0].contentWindow.scroll(0,$('#banner-iframe')[0].contentWindow.document.getElementById('video-home').offsetTop);
            }
        }
    })
    console.log(admConf);
}