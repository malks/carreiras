from oracle_conn import run_select as oc_select, run_insert as oc_insert, run_sql as oc_sql, new_conn as oc_conn
from mysql_connection import run_select as sql_select,run_sql,new_conn as sql_conn
from datetime import datetime
import re

#Get country code from senior based on country  name
def get_country_code_from_name(country_name):
    ret='0'
    if country_name!=None:
        country_conn=oc_conn()
        country_code=oc_select("SELECT CODPAI FROM R074PAI WHERE NOMPAI LIKE '"+str(country_name)+"'",country_conn)
        if len(country_code)>0 and country_code[0]['CODPAI']!=None:
            ret=country_code[0]['CODPAI']
        country_conn.close()
    return ret

#Get city code from senior based on city name
def get_city_code_from_name(city_name):
    ret='0'
    if city_name!=None:
        city_conn=oc_conn()
        city_code=oc_select("SELECT CODCID FROM R074CID WHERE NOMCID LIKE '"+str(city_name)+"'",city_conn)
        if len(city_code)>0 and city_code[0]['CODCID']!=None:
            ret=city_code[0]['CODCID']
        city_conn.close()
    return ret

#Get state code from senior based on state  name
def get_state_code_from_name(state_name):
    ret='0'
    if state_name!=None:
        state_conn=oc_conn()
        state_code=oc_select("SELECT CODEST FROM R074EST WHERE DESEST LIKE '"+str(state_name)+"'",state_conn)
        if len(state_code)>0 and state_code[0]['CODEST']!=None:
            ret=state_code[0]['CODEST']
        state_conn.close()
    return ret

#Get district code from senior based on district name
def get_district_code_from_name(district_name,city_code):
    ret='0'
    if district_name!=None:
        district_conn=oc_conn()
        if city_code!=None and city_code!=0:
            district_code=oc_select("SELECT CODBAI FROM R074BAI WHERE CODCID='"+city_code+"' AND NOMBAI LIKE '"+str(district_name)+"'",district_conn)
        else:
            district_code=oc_select("SELECT CODBAI FROM R074BAI WHERE NOMBAI LIKE '"+str(district_name)+"'",district_conn)
        if len(district_code)>0 and district_code[0]['CODBAI']!=None:
            ret=district_code[0]['CODBAI']
        district_conn.close()
    return ret

#Get deficiency id from senior based on carreiras's code, using desc as value
def get_deficiency_senior_id_from_carreiras_code(deficiency_id):
    ret='0'
    if deficiency_id!=None:
        carreiras_conn=sql_conn()
        senior_conn=oc_conn()

        deficiency_desc=sql_select("SELECT name FROM lunellicarreiras.deficiencies WHERE id='"+deficiency_id+"'",carreiras_conn)
        senior_code=oc_select("SELECT CODDEF FROM R022DEF WHERE DESDEF LIKE '"+deficiency_desc[0]['name']+"'")
        if len(senior_code)>0 and (senior_code[0]['CODDEF']!=None):
            ret=senior_code[0]['CODDEF']

        carreiras_conn.close()
        senior_conn.close()
    return ret

#Define dados de candidato do senior para carreiras
def carreiras_to_senior_candidate(data_carreiras):
    ret=[]
    for data in data_carreiras:
        helper={}
        num_can=""

        helper['PAINAS']=get_country_code_from_name(data['natural_country'])
        helper['ESTNAS']=get_state_code_from_name(data['natural_state'])
        helper['CIDNAS']=get_city_code_from_name(data['natural_city'])
  
        helper['CODPAI']=get_country_code_from_name(data['address_country'])
        helper['CODEST']=get_state_code_from_name(data['address_state'])
        helper['CODCID']=get_city_code_from_name(data['address_city'])
        helper['CODBAI']=get_district_code_from_name(data['address_district'],str(helper['CODCID']))
        helper['ENDCAN']=data['address_street']
        helper['ENDNUM']=data['address_number']
        helper['CODCEP']=data['zip']

        helper['NOMCAN']=data['name']
        helper['DATNAS']=data['dob']
        helper['TIPSEX']=data['gender']
        helper['ALTCAN']=data['height']
        helper['PESCAN']=data['weight']
        helper['ESTCIV']=data['civil_state']
        helper['SITCEX']=1

        helper['DDDCO1']=data['ddd_mobile']
        helper['TELCO1']=data['mobile']
        helper['DDDCO2']=data['ddd_phone']
        helper['TELCO2']=data['phone']
        helper['EMACAN']=data['email']

        helper['CPFCAN']=data['cpf']
        helper['PISCAN']=data['pis']
        helper['IDECAN']=data['rg']
        helper['EMICID']=data['rg_emitter']
        helper['NUMCTP']=data['work_card']
        helper['SERCTP']=data['work_card_series']
        helper['DIGCAR']=data['work_card_digit']
        helper['NUMELE']=data['elector_card']
        helper['NUMRES']=data['veteran_card']
        helper['DATCHE']=data['arrival_date']
        helper['DVLEST']=data['visa_expiration']
        helper['VISEST']=data['foreign_register']

        helper['NOMPAI']=data['father_name']
        helper['NOMMAE']=data['mother_name']
        helper['DATNPA']=data['father_dob']
        helper['DATNMA']=data['mother_dob']
        helper['NOMCJG']=data['spouse_name']
        helper['CARCON']=data['spouse_job']

        if (data['deficiency']==1):
            helper['CODDEF']=get_deficiency_senior_id_from_carreiras_code(data['deficiency_id'])

        #if "senior_num_can" in data:
        #    num_can=data['senior_num_can']

        helper['carreiras_id']=data['id']
        #helper['NUMCAN']=num_can

        #helper['ULTATU']=data['updated_at']
        ret.append(helper)

    return ret

#Arruma valor, arrancando caracteres invalidos para inserir no banco
def string_and_strip(what):
    if what==None:
        return ''
    return re.sub("'|\"|-|`","",str(what))

#Monta update do on duplicate keys para o banco
def mount_updates(key,value):
    return string_and_strip(key)+"='"+string_and_strip(value)+"'"

#Atualiza dados do candidato no carreiras
def update_candidate_carreiras(data):
    carreiras_conn=sql_conn()
    run_sql("UPDATE lunellicarreiras.candidates SET last_senior_synced=NOW(),senior_num_can='"+str(data['NUMCAN'])+"' WHERE id='"+str(data['carreiras_id'])+"'",carreiras_conn)
    return

#Adiciona status de sincronizado ao banco do carreiras para a inscrição nessa vaga desse candidato
def add_carreiras_subscribed_state(candidates,conn):
    for candidate in candidates:
        subscriptions=str(candidate['subscriptions']).split(",")
        for subscription in subscriptions:
            run_sql("INSERT INTO subscribed_has_states (subscribed_id,state_id,created_at,updated_at) VALUES('"+subscription+"',5,now(),now())",conn)
    return

#Altera status do exportador para candidatos exportados
def update_exportable(candidates,conn):
    for candidate in candidates:
        run_sql("UPDATE exportables SET status=1 WHERE candidate_id="+candidate["id"]+",updated_at=now()",conn)
    return

#Na senior não tem autoincrement na PK, então eu obtenho o valor maximo dela aqui e somo 1 antes de inserir
def get_senior_candidate_next_key(conn):
    last_id=oc_select("SELECT MAX(NUMCAN) FROM R122CEX",conn)
    if len(last_id)>0 and last_id[0]['MAX(NUMCAN)']!=None:
        return last_id[0]['MAX(NUMCAN)']+1

#Insere/atualiza candidato na senior
def export_candidates_to_senior(candidates,conn):
    for candidate in candidates:

        candidate['NUMCAN']=get_senior_candidate_next_key(conn)

        carreiras_id=candidate.pop('carreiras_id', '0')

        keys = ",".join(map(string_and_strip,list(candidate.keys())))
        values = "','".join(map(string_and_strip,list(candidate.values())))
        #updates = ",".join(map(mount_updates,list(candidate.keys()),list(candidate.values())))
        sql="INSERT  INTO R122CEX ("+keys+") VALUES ('"+values+"') "
        oc_sql(sql,conn)
        
        if carreiras_id!='0':
            candidate['carreiras_id']=carreiras_id
            update_candidate_carreiras(candidate)

        #candidate['NUMCAN']=oc_insert(sql,conn,'NUMCAN')
    return

if __name__ == "__main__":
    #Instancia Conexões Principais
    main_sql_conn=sql_conn()
    main_oc_conn=oc_conn()

    #Obtém data do ultimo sync de importação ativo
    last_sync=sql_select("SELECT last_sync FROM senior_sync WHERE type='export' AND active=1",main_sql_conn)
    if last_sync[0]['last_sync']==None:
        last_sync[0]['last_sync']=datetime.strptime('2021-05-01','%Y-%m-%d')
   

    #Candidatos que foram adicionados à lista de exportação
    candidates_carreiras_avulsos=sql_select("SELECT candidates.*  FROM candidates JOIN exportables ON candidates.id=exportables.candidate_id WHERE exportables.status=0 AND candidates.senior_num_can IS NULL",main_sql_conn)
    candidates_senior_avulsos=carreiras_to_senior_candidate(candidates_carreiras_avulsos)
    export_candidates_to_senior(candidates_senior_avulsos,main_oc_conn)
    update_exportable(candidates_senior_avulsos)


    #Candidatos do carreiras que estão inscritos em vagas ativas e última sincronização com senior foi anterior a ultima atualização/inscrição do candidato em
    candidates_carreiras=sql_select("SELECT DISTINCT candidates.*,group_concat(subscribed_has_states.subscribed_id) as subscriptions  FROM candidates JOIN subscribed ON subscribed.candidate_id=candidates.id JOIN subscribed_has_states ON subscribed_has_states.subscribed_id=subscribed.id LEFT JOIN subscribed_has_states AS denied_states ON denied_states.subscribed_id=subscribed.id AND denied_states.state_id IN (5,2) LEFT JOIN states ON states.id=subscribed_has_states.state_id  WHERE  candidates.senior_num_can IS NULL AND states.sync_to_senior=1 AND denied_states.id IS NULL AND (candidates.last_senior_synced<=candidates.updated_at OR candidates.last_senior_synced<=subscribed.updated_at OR candidates.last_senior_synced<=subscribed_has_states.updated_at OR candidates.last_senior_synced IS NULL) GROUP BY candidates.id",main_sql_conn)

    candidates_senior=carreiras_to_senior_candidate(candidates_carreiras)
    export_candidates_to_senior(candidates_senior,main_oc_conn)
    add_carreiras_subscribed_state(candidates_carreiras,main_sql_conn)


    #test=oc_select("SELECT NOMCAN,COUNT(NUMCAN) as CONNTA from R122CEX  GROUP BY NOMCAN ORDER BY CONNTA DESC  FETCH NEXT 3 ROWS ONLY ",main_oc_conn)
    #test=oc_select("select * from R122CEX WHERE NOMCAN LIKE '%KARL%'",main_oc_conn)
    #candidates_senior=oc_select("select * from R122CEX ORDER BY NUMCAN DESC FETCH NEXT 1 ROWS ONLY",main_oc_conn)
    #print(test)

    #Candidatos
    #candidate_senior=oc_select("SELECT * from R122CEX WHERE DATINC >= '"+last_sync[0]['last_sync'].strftime('%Y-%m-%d')+"' ",main_oc_conn)
    #candidates_carreiras=senior_to_carreiras_candidate(candidate_senior)
    #import_candidates(candidates_carreiras,main_sql_conn)

    #Vagas
    #job_senior=oc_select("SELECT * FROM R126RQU WHERE DATRQU>='"+last_sync[0]['last_sync'].strftime('%Y-%m-%d')+"' AND SITRQU IN('0','1')",main_oc_conn)
    #full_job=senior_fill_job_data(job_senior,main_oc_conn)
    #jobs_carreiras=senior_to_carreiras_job(full_job)
    #import_jobs(jobs_carreiras,main_sql_conn)
 
    ##Atualiza controle de sincronizador
    #update_senior_sync(main_sql_conn)

    #Fecha as conexões principais
    main_oc_conn.close()
    main_sql_conn.close()
