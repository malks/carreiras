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
    if ($('[check-candidates-list]').length>0)
        candidatesList();
    if ($('[check-jobs-list]').length>0)
        jobsList();
    if ($('[check-units-list]').length>0)
        unitsList();
    if ($('[check-candidates-edit]').length>0)
        editCandidate();
    if ($('[check-recruiting]').length>0)
        recruiting();
    if ($('#configurations').length>0)
        configurations();
})

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
                            unit_id:""
                        }
                    },
                    deep:{
                        "subscriptions":{
                            mustHave:{
                                states:{
                                    in: {
                                        state_id:[1],
                                    }
                                }
                            }
                        }
                    }
                },
            },
        },
        persistentData:{
            subscriptions:null,
        }
    };

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
                pushData['_token']=$('[name="_token"]').val();
                
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
                    }
                });
            }
        },
    });
}

function startData(){
    fullData=JSON.parse($('#full-data').val());
    ajaxUrl="";
    form.append('_token',$('[name="_token"]').val());
}

function fieldsList(){
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

function jobsList(){
    startData();
    ajaxUrl=$('#app').attr('action');
    startList();
    $('#search').focus();
}

function startList(){
    let list = new Vue({
        el:'#app',
        data:{selectedIds:new Array()},
        computed:{
            canEdit:function(){
                if (this.selectedIds.length==1)
                    return false;
                return true;
            },
            canDestroy:function(){
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
                if(confirm('Você está certo disso?')){
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
        }
    })
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
        active_from:'',
        active_to:'',
        order:''
    };

    admConf = new Vue({
        el:'#configurations',
        data:{
            banners:null,
            movingBanner:null,
            saving:false,
            selectedBanner:null,
            editingBanner:{...defaultEditingBanner},
            bannerBackground:null,
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
                this.selectedBanner=id;
                console.log(this.selectedBanner);
            },
            resetEditingBanner: function (){
                this.editingBanner={...defaultEditingBanner};
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
            activeBanner:function(id){
                if (this.selectedBanner==id)
                    return true;
                return false;
            },
            updateBanner:function() {
                this.saving=true;
                let that = this;
                form.append('_token',$('[name="_token"]').val());
                form.append('banner', JSON.stringify(that.editingBanner));
                console.log(form.get('background_file'));
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
                    contentType: multipart/form-data,            
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
        },
        watch:{
            selectedBanner:function(val){
                console.log(val);
            }
        }
    })
    console.log(admConf);
}