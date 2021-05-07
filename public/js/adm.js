$(document).ready(function () {
    if ($('[check-fields-list]').length>0)
        fieldsList();
    if ($('[check-candidates-list]').length>0)
        candidatesList();
    if ($('[check-jobs-list]').length>0)
        jobsList();
    if ($('[check-units-list]').length>0)
        unitsList();
})

function startData(){
    fullData=JSON.parse($('#full-data').val());
    selectedIds=Array();
    ajaxUrl="";
    form = new FormData();
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
    list = new Vue({
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