var recruitMachine = null;
let admConf=null;
let edit=null;
let fullData=null;
let selectedIds=Array();
let ajaxUrl="";
let form = new FormData();
let usermail='';


$(document).ready(function () {
    if ($('[check-fields-list]').length>0)
        fieldsList();
    if ($('[check-states-mails-list]').length>0)
        statesMailsList();
    if ($('[check-states-mails-edit]').length>0)
        editStatesMails();
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
    if ($('[check-help-contacts-list]').length>0)
        helpContactsList();
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
    if ($('[check-tagsrh-edit]').length>0)
        editTagsRH();
})

function editStatesMails(){
    let statesMailsEdit=new Vue({
        el:'#app',
        data:{
            id:null,
            header_type:'text',
            body_type:'text',
            footer_type:'text',
            header_value:'',
            body_value:'',
            footer_value:'',
            header_background:'',
            body_background:'',
            footer_background:'',
            states:[],
            all_states:[],
        },
        mounted:function(){
            let that=this;
            let full_data={};
            if($('#full-data').val()!=undefined){
                full_data=JSON.parse(decodeURIComponent($('#full-data').val()).replace(/\+/g," "));
                for ( let i in full_data ){
                    if(i!='states')
                        that[i]=full_data[i];
                }    
            }
            if($('#linked-states').val()!=undefined){
                that.states=JSON.parse(decodeURIComponent($('#linked-states').val()).replace(/\+/g," "));
            }
            if($('#all-states').val()!=undefined){
                that.all_states=JSON.parse(decodeURIComponent($('#all-states').val()).replace(/\+/g," "));
            }
        },
        methods:{
            removeState:function(idx){
                let that = this;
                that.states.splice(idx,1);
            },
            addState:function (){
                let that=this;
                that.states.push(that.all_states[0]);
            },
            changeHeaderImage:function(){
                let that=this;
                that.header_value=URL.createObjectURL($('#header-image-value')[0].files[0]);
            },
            changeBodyImage:function(){
                let that=this;
                that.body_value=URL.createObjectURL($('#body-image-value')[0].files[0]);
            },
            changeFooterImage:function(){
                let that=this;
                that.footer_value=URL.createObjectURL($('#footer-image-value')[0].files[0]);
            },
            getHeaderImage:function(){
                let that = this;
                let thefile='';
                if (that.header_value!='' && that.header_type=='image'){
                    thefile=URL.createObjectURL($('#header-image-value')[0].files[0]);
                }
                return thefile;
            },
            getFooterImage:function(){
                let that = this;
                if (that.footer_value!='' && that.footer_type=='image'){
                    return URL.createObjectURL($('#footer-image-value')[0].files[0]);
                }
                return '';
            },
            getBodyImage:function(){
                let that = this;
                if (that.body_value!='' && that.body_type=='image'){
                    return URL.createObjectURL($('#body-image-value')[0].files[0]);
                }
                return '';
            },
        }
    })
}

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
            curpage:0,
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
                        btw:{
                            created_at:''
                        },
                        lt:{
                            created_at:''
                        }
                    },
                    deep:{
                        subscriptions:{
                            mustHave:{
                                states:{
                                    in: {
                                        state_id: [1],
                                    }
                                },
                            },
                            in: {
                                active: [1]
                            },
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
            candidateLocSearch:'',
            tagFilters:'',
            tagFiltersExcept:"false",
            filterTagRh:JSON.parse($('#filtered-tagsrh').val()),
            tagsRh:JSON.parse($('#tagsrh').val()),
            candidateWorkPeriodSearch:{1:false,2:false,3:false,4:false},
        }
    };

    recruitMachine=new Vue({
        el:'#app',
        data: {...bootstrapData},
        computed:{
            jobSize:function(){
                if (this.runData.selectedJob.id!=null)
                    return "hide";
                return "col-lg-12";
            },
            candidateSize: function(){
                if (this.runData.selectedJob.id!=null)
                    return "col-lg-12";
                return "hide";
            },
            notingObservation:function () {
                let obs = "";
                if (this.runData.notingSubscription.obs!==undefined)
                    obs=this.runData.notingSubscription.obs;
                return obs.split("\n");
            },
        },
        mounted:function () {
            this.updateData();
        },
        methods:{
            tagRhBackground:function(id){
                let idx=that.otherData.filterTagRh.findIndex(el=>el == id);
                return 'background-color:'+this.tagsRh[idx].color;
            },
            addTagRhFilter:function(id){
                let that = this;
                let idx=that.otherData.filterTagRh.findIndex(el=>el == id);
                if (idx==-1)
                    that.otherData.filterTagRh.push(id);
                else
                    that.otherData.filterTagRh.splice(idx,1);
                console.log(that.otherData.filterTagRh);
            },
            isSelectedTagrh:function (tagid){
                let that = this;
                let ret = false;
                let idx=that.otherData.filterTagRh.findIndex(el=>el == tagid);
                if (idx!==-1)
                    ret=true;
                return ret;
            },
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
                let persistentData=that.persistentData;
                persistentData['_token']=$('[name="_token"]').val();
                persistentData['candidate_id']=who;
                persistentData['job_id']=where;
                persistentData['status']=what;
                $.ajax({
                    url:'/adm/add-subscription-state',
                    type:'POST',
                    data:persistentData,
                    success:function (data){
                        that.updateData();
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
                if (id==null || id ==undefined)
                    return {'name':''};
                let ret = this.runData.units.find(obj=>{
                    return obj.id==id; 
                })
                if (ret==null || ret==undefined)
                    return {'name':''};
                return ret;
            },
            getFieldById:function(id){
                if (id!==null || id ==undefined)
                    return {'name':''};
                let ret = this.runData.fields.find(obj=>{
                    return obj.id==id; 
                })
                if(ret==undefined)
                    ret={'name':'Sem área definida'};
                return ret;
            },
            inspectJob:function(job){
                let that = this;
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
            uninspectJob:function (){
                let that = this;
                that.runData.selectedJob={...bootstrapData.selectedJob};
                that.runData.subscriptions={...bootstrapData.subscriptions};
            },
            updateSelectedJobData:function (){
                let that = this;
                let pushData={...that.pushData};
                that.runData.subscriptions=[];
                pushData.filters.jobs.direct.in.id=that.runData.selectedJob.id;
                pushData['_token']=$('[name="_token"]').val();
                that.runData.updating=true;

                $.ajax({
                    url:'/adm/recruiting-data',
                    type:'POST',
                    data:pushData,
                    success:function (data){
                        let objData=JSON.parse(data);
                        let theJobIdx=that.runData.jobs.findIndex(obj=>{
                            return obj.id===objData.jobs[0].id;
                        })
                        that.runData.jobs[theJobIdx]=objData.jobs[0];
                        that.runData.selectedJob=objData.jobs[0];
                        that.runData.subscriptions=objData.jobs[0].subscriptions;
                        for (let i in that.runData.selectedJob.subscriptions){
                            that.runData.selectedJob.subscriptions[i].current_state=that.runData.selectedJob.subscriptions[i].states[that.runData.selectedJob.subscriptions[i].states.length-1].id;
                        }
                        that.runData.updating=false;
                    }
                });
            },
            updateSelectedJob:function (){
                let that = this;
                if (that.runData.selectedJob.id!=null){
                    that.runData.selectedJob=that.runData.jobs.find(obj=>{
                       return obj.id==that.runData.selectedJob.id;
                    });
                    if (that.runData.selectedJob==undefined){
                        that.runData.selectedJob={...bootstrapData.selectedJob};
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
                        let jdata = decodeURIComponent(window.atob(decodeURIComponent(data))).replace(/\+/g," ");
                        let objData=JSON.parse(jdata);
                        console.log(objData);
                        for (let i in objData){
                            that.runData[i]=objData[i];
                        }
                        that.updateSelectedJob();
                        that.runData.updating=false;
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
            candidateWokrPeriodFilter:function (candidate){
                let contain=true;
                let activeFilters="";
                for (let i in this.otherData.candidateWorkPeriodSearch){
                    if(this.otherData.candidateWorkPeriodSearch[i]){
                        contain=false;
                        if (candidate.prefered_work_period.split(",").indexOf(i)!==-1){
                            contain=true;
                            break;
                        }
                    }
                }
                return contain;
            },
            candidateTagrhFilter:function (candidate) {
                let contain = true;
                let activeFilters = [];
                let dudeTags = [];
                if (candidate!=undefined){
                    dudeTags=candidate['tagsrh'];
                    if(this.otherData.filterTagRh.length>0){
                        contain=false;
                        activeFilters = this.otherData.filterTagRh;
                        for (let i in activeFilters){
                            if (activeFilters[i]=="" || typeof activeFilters[i] == undefined || activeFilters[i]==null){
                                contain = false;
                                break;
                            }
                            for (let j in dudeTags){
                                if (dudeTags[j].id==activeFilters[i]){
                                    contain=true;
                                    break;
                                }
                            }
                            if (contain)
                                break;
                        }
                    }
                }
                if (candidate!=undefined && candidate!=null && candidate.id==1091)
                    console.log(this.otherData.tagFiltersExcept,activeFilters.length,contain,dudeTags);
                if (activeFilters.length>0 && this.otherData.tagFiltersExcept=="true")
                    contain=!contain;
                return contain;
            },
            candidateTagFilter:function (candidate) {
                let contain=true;
                let activeFilters="";
                if (candidate!=undefined){
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
                }
                return contain;
            },
            candidateExpFilter:function (candidate){
                let contain=true;
                let activeFilters="";
                if (candidate!=undefined){
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
                }
                return contain;
            },
            candidateLocFilter:function (candidate){
                let contain=true;
                let activeFilters="";
                if (candidate!=undefined){
                    let dude=candidate;
                    if(this.otherData.candidateLocSearch.length>0){
                        contain=false;
                        activeFilters = this.otherData.candidateLocSearch.split(" ");
                        for (let i in activeFilters){
                            if (activeFilters[i]=="" || typeof activeFilters[i] == undefined || activeFilters[i]==null){
                                contain = false;
                                break;
                            }
                            if (dude.address_city!=null && dude.address_state!=null){
                                if (dude.address_city.toLowerCase().includes(activeFilters[i].toLowerCase()) || dude.address_state.toLowerCase().includes(activeFilters[i].toLowerCase())){
                                    contain=true;
                                    break;
                                }
                            }
                            if (contain)
                                break;
                        }
                    }
                }
                return contain;
            },
            inFilter:function(job){
                let activeFilters ='';
                let tempJob={...job};
                let contain = false;
                if (this.otherData.tagFilters.length>0)
                    activeFilters = this.otherData.tagFilters.split(" ");

                if (activeFilters.length>0){
                    for (let i in activeFilters){
                        if(activeFilters[i].length>0){
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
    fullData=JSON.parse(decodeURIComponent($('#full-data').val()).replace(/\+/g," "));
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

function statesMailsList(){
    startData();
    ajaxUrl=$('#app').attr('action');
    startList([],[1]);
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
    usermail = $('#usermail').val();
    startList();
    $('#search').focus();
}

function unitsList(){
    startData();
    ajaxUrl=$('#app').attr('action');
    startList();
    $('#search').focus();
}

function helpContactsList(){
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
    let tempData=JSON.parse(decodeURIComponent($('#full-data').val()).replace(/\+/g," "));
    let locked=[];
    for (let i in tempData){
        if (tempData[i].role_id==2)
            locked.push(tempData[i].id);
    }
    ajaxUrl=$('#app').attr('action');
    startList(locked,locked);
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
    let list = null;
    let logged_id=$('#logged-id').val();
    list=new Vue({
        el:'#app',
        data:{
            selectedIds:new Array(),
            selectedSeniorIds: new Array(),
            duplicateCpfIds: new Array(),
            duplicateCpfData: new Array(),
            previousLunelliCadIds: new Array(),
            previousLunelliCadData: new Array(),
            blockEditIds:blockEditIds,
            blockDeleteIds:blockDeleteIds,
            logged_id:logged_id,
            availableJobs:[],
            availableTagsRh:[],
            availableJobsFilterData:{
                status:[],
                name:"",
                unit:0,
                field:0,
                dateStart:null,
                dateEnd:null,
            },
            allFields:[],
            allUnits:[],
            filterTagRh:[],
            jobChoosing:false,
            tagSetting:false,
            tagCheck:false,
            selectedTagrh:[],
            selectedJob:null,
            selectedCandidateName:'',
            selectedCandidateId:'',
            exporterEmail:'',
            exportChecking:false,
            viewedItem:[],
            saving:false,
        },
        mounted:function (){
            if ($('[check-candidates-list]').length>0){
                this.loadAvailableJobs();
                this.loadAvailableTagsRh();
                this.loadFields();
                this.loadUnits();
                this.loadViewed();
                this.filterTagRh=JSON.parse($('#filtered-tagsrh').val());
                console.log(this.filterTagRh);
            }
        }, 
        computed:{
            currentCandidate: function (){
                if (this.selectedIds.length>0)
                    return this.selectedIds[0];
                return '';
            },
            exportCheckPrevCad: function (){
                let ret = false;
                let that = this;
                if (that.previousLunelliCadIds.length>0)
                    ret=true;
                return ret;
            },
            exportCheckDuplicateCpf: function (){
                let ret = false;
                let that = this;
                if (that.duplicateCpfIds.length>0)
                    ret=true;
                return ret;
            },
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
            canExport:function(){
                let that = this;
                let ret = true;
                if (that.selectedIds.length>0)
                    ret = false;
                if (that.selectedSeniorIds.length>0)
                    ret = true;
                return ret;
            },
            validateExport:function (){
                let that = this;
                let ret = true;
                if (that.exporterEmail!="" && that.exporterEmail==usermail)
                    ret =false;
                return ret;
            },
            canDestroy:function(){
                let that = this;
                if (logged_id!=null && that.selectedIds[0]==logged_id)
                    return true;
                if (that.blockDeleteIds.length>0){
                    for (let i=0;i<that.blockDeleteIds.length;i++){
                        if (that.selectedIds.indexOf(that.blockDeleteIds[i])!==-1)
                            return true;
                    }
                }
                if (that.selectedIds.length>0)
                    return false;
                return true;
            },
            candidatesJobsSelected:function (){
                if (this.selectedJob!=null)
                    return false;
                return true;
            },
            inTagRhFilter: function (id){
                let that = this;
                let idx=that.filterTagRh.findIndex(el=>el == id);
                let ret = false;
                if (idx!==-1)
                    ret = true;
                return ret;
            },
        },
        methods:{
            printDate:function(val){
                let ret = "";
                if (val!=undefined && val!=null && val.indexOf("\ ")>=0)
                    ret = val.split(" ")[0].split("-").reverse().join("/");
                return ret;
            },
            filterAvailableJobs: function (currentJob){
                let ret = true;
                let that = this;
                if(that.availableJobsFilterData.status.length>0 || 
                    that.availableJobsFilterData.name!="" || 
                    that.availableJobsFilterData.unit!=0 || 
                    that.availableJobsFilterData.field!=0 ||
                    that.availableJobsFilterData.dateStart!=null || 
                    that.availableJobsFilterData.dateEnd!=null
                    ){
                    ret=false;   
                    if (that.availableJobsFilterData.status.length>0){
                        if (that.availableJobsFilterData.status[0]==currentJob.status || that.availableJobsFilterData.status[1]==currentJob.status)
                            ret=true;
                    }
                    if (that.availableJobsFilterData.name!=""){
                        if (currentJob.name.toLowerCase().includes(that.availableJobsFilterData.name.toLowerCase()))
                            ret=true;
                    }
                    if (that.availableJobsFilterData.unit!=0){
                        if (currentJob.unit!=undefined && currentJob.unit.id==that.availableJobsFilterData.unit)
                            ret=true;
                    }
                    if (that.availableJobsFilterData.field!=0){
                        if (currentJob.field!=undefined && currentJob.field.id==that.availableJobsFilterData.field)
                            ret=true;
                    }
                    if (that.availableJobsFilterData.dateStart!=null){
                        let tempDateStart=new Date(that.availableJobsFilterData.dateStart);
                        let jobDate=new Date(currentJob.created_at);
                        if (tempDateStart<=jobDate)
                            ret = true;
                    }
                    if (that.availableJobsFilterData.dateEnd!=null){
                        let tempDateEnd=new Date(that.availableJobsFilterData.dateEnd);
                        let jobDate=new Date(currentJob.created_at);
                        if (jobDate<=tempDateEnd)
                            ret = true;
                    }
                }
                return ret;
            },
            toggleTagCheck: function (candidate_id) {
                let that = this;
                that.tagCheck=!that.tagCheck;
                that.selectedTagrh=[];
                if (candidate_id!==false){
                    $.ajax({
                        url:'/adm/candidates/load-tagsrh/'+candidate_id,
                        type:'GET',
                        success: function (data){
                            let temptags=[...JSON.parse(data)];
                            for (let i in temptags){
                                that.selectedTagrh.push(temptags[i].tag_id);                            
                            }
                        }
                    })
                    $.ajax({
                        url:'/adm/candidates/load-data/'+candidate_id,
                        type:'GET',
                        success: function (data){
                            that.selectedCandidateName=JSON.parse(data).name;
                        }
                    });
    
                }
                if (that.tagCheck)
                    $('#tagrh-modal').show();
                else
                    $('#tagrh-modal').hide();
            },
            selectJob:function (id) {
                if(this.selectedJob!=id)
                    this.selectedJob=id;
                else
                    this.selectedJob=null;
            },
            addTagRhFilter: function (id){
                let that = this;
                let idx=that.filterTagRh.findIndex(el=>el == id);
                if (idx==-1)
                    that.filterTagRh.push(id);
                else
                    that.filterTagRh.splice(idx,1);
                console.log(that.filterTagRh);
            },
            loadViewed:function (){
                let that=this;
                let viewed_list=$('#viewed-data').val().split(",");
                for (let i =0;i<viewed_list.length;i++){
                    if (viewed_list[i]!="")
                        that.viewedItem.push(viewed_list[i]);
                }
            },
            isSelectedTagRh:function(tagid){
                let that = this;
                let ret = false;
                console.log(that.selectedTagrh);
                let idx=that.filterTagRh.findIndex(el=>el == tagid);
                if (idx!==-1)
                    ret=true;
                return ret;
            },
            isUserSelectedTagRh:function(tagid){
                let that = this;
                let ret = false;
                let idx=that.selectedTagrh.findIndex(el=>el == tagid);
                if (idx!==-1)
                    ret=true;
                return ret;
            },
            switchTagRh:function(tagid){
                let that = this;
                let tagidx=that.selectedTagrh.findIndex(el=>el == tagid);
                if (tagidx==-1)
                    that.selectedTagrh.push(tagid);
                else
                    that.selectedTagrh.splice(tagidx,1);
            },
            loadAvailableTagsRh:function(){
                let that = this;
                $.ajax({
                    url:ajaxUrl+'/available-tagsrh',
                    type:'GET',
                    processData: false,
                    contentType: false,
                    data:form,
                    success:function(data){
                        that.availableTagsRh=[...JSON.parse(data)];
                    }
                });
            },
            loadAvailableJobs:function(){
                let that = this;
                $.ajax({
                    url:ajaxUrl+'/available-jobs',
                    type:'GET',
                    processData: false,
                    contentType: false,
                    data:form,
                    success:function(data){
                        that.availableJobs=JSON.parse(data);
                    }
                });
            },
            loadFields:function(){
                let that = this;
                $.ajax({
                    url:'/all-fields',
                    type:'GET',
                    success:function(data){
                        that.allFields=JSON.parse(data);
                    }
                });
            },
            loadUnits:function(){
                let that = this;
                $.ajax({
                    url:'/all-units',
                    type:'GET',
                    success:function(data){
                        that.allUnits=JSON.parse(data);
                    }
                });
            },
            subscribeCandidatesToJob:function (){
                let that=this;

                form.append('candidates',that.selectedIds);
                form.append('job',that.selectedJob);
                that.openJobs();
                $.ajax({
                    url:ajaxUrl+'/subscribe-candidates-to-job',
                    type:'POST',
                    processData: false,
                    contentType: false,
                    data:form,
                    success:function(data){
                        alert("Inscritos com sucesso");
                        window.location.reload();
                    }
                })
            },
            tagsRh: function (cdid=false){
                let that=this;

                console.log(cdid);
                if (cdid!==false){
                    that.selectedCandidateId=cdid;
                }
                else {
                    that.selectedCandidateId=that.selectedIds[0];
                }
                that.openTags();
            },
            openCheckExportCandidates:function (){
                this.exporterEmail="";
                if(this.exportCheckPrevCad){
                    this.exportChecking=!this.exportChecking;
                    if(this.exportChecking)
                        $('#check-before-export').show();
                    else
                        $('#check-before-export').hide();
                }
                else {
                    this.exportCandidates();
                }
            },
            exportCandidates:function (){
                let that=this;
                if(confirm('Tem certeza que deseja exportar os candidatos selecionados?')){
                    form.append('candidates',that.selectedIds);
                    $.ajax({
                        url:ajaxUrl+'/export-candidates',
                        type:'POST',
                        processData: false,
                        contentType: false,			    
                        data:form,
                        success:function(data){
                            alert("Candidatos adicionados à fila de exportação, pode levar até 1 minuto para que ocorra a exportação.");
                            window.location.reload();
                        }
                    })
                }
            },
            openJobs:function (){
                this.jobChoosing=!this.jobChoosing;
                this.selectedJob=null;
                if (this.jobChoosing)
                    $('#subscribe-job-modal').show();
                else
                    $('#subscribe-job-modal').hide();
            },
            openTags:function (){
                let that = this;
                that.tagSetting=!that.tagSetting;
                that.selectedTagrh=[];
                that.selectedCandidateName="";
                let candidatesTags=[];
                $.ajax({
                    url:'/adm/candidates/load-tagsrh/'+that.selectedCandidateId,
                    type:'GET',
                    success: function (data){
                        let temptags=JSON.parse(data);
                        for (let i in temptags){
                            that.selectedTagrh.push(temptags[i].tag_id);                            
                        }
                        console.log(that.selectedTagrh);
                    }
                });
                $.ajax({
                    url:'/adm/candidates/load-data/'+that.selectedCandidateId,
                    type:'GET',
                    success: function (data){
                        that.selectedCandidateName=JSON.parse(data).name;
                    }
                });
                if (that.tagSetting)
                    $('#subscribe-tagrh-modal').show();
                else
                    $('#subscribe-tagrh-modal').hide();
            },
            addItem:function(data){
                let id = data.id;
                let seniorId = data.senior_num_can;

                let duplicateCpf = data.duplicate_cpf;
                let duplicateCpfData = {
                    name:data.name,
                    cpf:data.cpf,
                    email:data.email,
                };

                let previousLunelliCad = data.previous_lunelli_cad;
                let prevLunelliData={
                    nome:data.name,
                    cadastro:data.previous_lunelli_cad,
                    unidade:data.previous_lunelli_unit,
                    vaga:data.previous_lunelli_job,
                    data:data.previous_lunelli_date,
                };

                if (seniorId!=null){
                    let seniorIdx=this.selectedSeniorIds.findIndex(el => el == seniorId);
                    if (seniorIdx>=0)
                        this.selectedSeniorIds.splice(seniorIdx,1);
                    else
                        this.selectedSeniorIds.push(seniorId);
                }

                if (duplicateCpf==1){
                    let duplicateCpfIdIdx=this.duplicateCpfIds.findIndex(el => el == id);
                    if (duplicateCpfIdIdx>=0){
                        this.duplicateCpfIds.splice(duplicateCpfIdIdx,1);
                        this.duplicateCpfData.splice(duplicateCpfIdIdx,1);
                    }
                    else{
                        this.duplicateCpfIds.push(id);
                        this.duplicateCpfData.push(duplicateCpfData);
                    }
                }

                if (previousLunelliCad!=null){
                    let previousLunelliCadIdx=this.previousLunelliCadIds.findIndex(el => el == previousLunelliCad);
                    if (previousLunelliCadIdx>=0){
                        this.previousLunelliCadIds.splice(previousLunelliCadIdx,1);
                        this.previousLunelliCadData.splice(previousLunelliCadIdx,1);
                    }
                    else{
                        this.previousLunelliCadIds.push(previousLunelliCad);
                        this.previousLunelliCadData.push(prevLunelliData);
                    }
                }

                let idx=this.selectedIds.findIndex(el=>el == id);
                if(idx>=0)
                    this.selectedIds.splice(idx,1);
                else
                    this.selectedIds.push(id);                
            },
            addViewed:function(id){
                let idx=this.viewedItem.findIndex(el=>el == id);
                let that=this;
                if(idx<0){
                    $.ajax({
                        url:'/adm/candidates/view/'+id,
                        type:'GET',
                        success:function(data){
                            that.viewedItem.push(id);
                        }
                    })
                }
            },
            isViewed:function(id){
                let ret=false;
                let idx=this.viewedItem.findIndex(el=>el == id);
                if (idx>=0)
                    ret=true;
                return ret;
            },
            reverseSelection:function(){
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
            toggle:function(){
                let that=this;
                form.append('ids',that.selectedIds);
                $.ajax({
                    url:ajaxUrl+'/toggle',
                    type:'POST',
                    processData: false,
                    contentType: false,			    
                    data:form,
                    success:function(data){
                        window.location.reload();
                    }
                });
            },
            resetPass:function(){
                let that=this;
                form.append('ids',that.selectedIds);
                if(confirm('Alterar a senha dos usuários selecionados para 12345678?')){
                    $.ajax({
                        url:ajaxUrl+'/reset-pass',
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
        customData.holdingData={};
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
            admConf.otherConf=otherConf;
            $('#testimonial-author-pic').attr('src','/img/'+otherConf.about_us.testimonial_author_picture);
            $('#video-pic').attr('src','/img/'+otherConf.video.face);
        }
    })

    $('#banner-modal [data-bs-dismiss]').click(function () {
        $('#banner-modal').hide();
    })

    $('#change-banner-background').click(function () {
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
                that.otherConf.our_numbers=tmpConf;
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
                that.otherConf.our_team=tmpConf;
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
                        form.append($(it).attr('id').replace(/-/g,"_"),$(it)[0].files[0]);
                    })
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