let admConf=null;
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
    if ($('#configurations').length>0)
        configurations();
})

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
        data:{
            screenName:screenNameHelper,
            currentTab:firstTab,
            alwaysTrue:true,
        },
        methods:{
            isItMe:function (who) {
                if (this.currentTab==who)
                    return true;
                return false;
            }
        }
    })
}

function dropper(it){
    console.log(it);
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


    admConf = new Vue({
        el:'#configurations',
        data:{
            banners:null,
            movingBanner:null,
            saving:false,
            selectedBanner:null,
        },
        computed:{
            savingText:function (){
                if (this.saving)
                    return "Salvando...";
                return "Salvar";
            },
            canEdit:function(){
                if (this.selectedBanner!=null)
                    return true;
                return false;
            }
        },
        methods:{
            editBanner:function(){
                console.log(this.selectedBanner);
            },
            activeBanner:function(id){
                if (this.selectedBanner==id)
                    return true;
                return false;
            },
            saveBanners:function (){
                this.saving=true;
                let that = this;
                let form = new FormData();
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
}