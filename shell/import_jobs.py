from oracle_conn import run_select as oc_select, run_sql as oc_sql, new_conn as oc_conn
from mysql_connection import run_select as sql_select,run_sql,new_conn as sql_conn
from datetime import datetime
import re

#Retorna nome da cidade com base no codigo
def get_senior_city_from_code(cod_city):
    city_conn=oc_conn()
    ret=""
    city_data=oc_select("SELECT NOMCID FROM R074CID WHERE CODCID='"+str(cod_city)+"'",city_conn)

    if len(city_data)>0:
        ret=city_data[0]['NOMCID']
        
    city_conn.close()
    return ret

#Retorna nome do estado com base no codigo
def get_senior_state_from_code(cod_state):
    state_conn=oc_conn()
    ret=""
    state_data=oc_select("SELECT DESEST FROM R074EST WHERE CODEST='"+str(cod_state)+"'",state_conn)

    if len(state_data)>0:
        ret=state_data[0]['DESEST']
        
    state_conn.close()
    return ret

#Retorna nome do bairro com base no codigo
def get_senior_district_from_code(cod_district):
    district_conn=oc_conn()
    ret=""
    district_data=oc_select("SELECT NOMBAI FROM R074BAI WHERE CODBAI='"+str(cod_district)+"'",district_conn)

    if len(district_data)>0:
        ret=district_data[0]['NOMBAI']
        
    district_conn.close()
    return ret

#Retorna nome do país com base no codigo
def get_senior_country_from_code(cod_country):
    country_conn=oc_conn()
    ret="Brasil"
    country_data=oc_select("SELECT NOMPAI FROM R074PAI WHERE CODPAI='"+str(cod_country)+"'",country_conn)

    if len(country_data)>0:
        ret=country_data[0]['NOMPAI']
        
    country_conn.close()
    return ret

#Retorna descrição do turno com base no codigo do turno da requisição
def get_senior_period_from_code(cod_period):
    escalas={
        '1':'1º Turno',
        '2':'2º Turno',
        '3':'3º Turno',
        '4':'4º Turno',
        '8':'Misto',
        '9':'Geral',
    }
    period_conn=oc_conn()
    ret=""
    period_data=oc_select("SELECT TURESC FROM R006ESC WHERE CODESC='"+str(cod_period)+"'",period_conn)

    if len(period_data)>0:
        ret=escalas[str(period_data[0]['TURESC'])]
        
    period_conn.close()
    return ret

#Retorna código da unidade no carreiras com base no código da filial do senior
def get_carreiras_unit_from_senior_code(cod_unit,cod_emp):
    unit_conn=sql_conn()
    ret=""
    unit_data=sql_select("SELECT id FROM units WHERE cod_senior='"+str(cod_unit)+"' AND cod_emp_senior='"+str(cod_emp)+"'",unit_conn)

    if len(unit_data)>0:
        ret=unit_data[0]['id']
        
    unit_conn.close()
    return ret

#Define dados de candidato do senior para carreiras
def senior_to_carreiras_candidate(data_senior):
    ret=[]
    for data in data_senior:
        helper={}
        helper['name']=data['NOMCAN']
        helper['dob']=data['DATNAS']
        helper['height']=data['ALTCAN']
        helper['weight']=data['PESCAN']
        helper['work_card']=data['NUMCTP']
        helper['work_card_series']=data['SERCTP']
        helper['cpf']=data['CPFCAN']
        helper['pis']=data['PISCAN']
        helper['cep']=data['CODCEP']
        helper['rg_emitter']=data['EMICID']
        helper['rg']=data['IDECAN']
        helper['address_street']=data['ENDCAN']
        helper['father_name']=data['NOMPAI']
        helper['mother_name']=data['NOMMAE']
        helper['father_dob']=data['DATNPA']
        helper['mother_dob']=data['DATNMA']
        helper['address_number']=data['ENDNUM']
        helper['elector_card']=data['NUMELE']
        helper['veteran_card']=data['NUMRES']
        helper['arrival_date']=data['DATCHE']
        helper['visa_expiration']=data['DVLEST']
        helper['foreign_register']=data['VISEST']
        helper['updated_at']=data['ULTATU']
        helper['work_card_digit']=data['DIGCAR']
        helper['ddd_mobile']=data['DDDCO1']
        helper['mobile']=data['TELCO1']
        helper['ddd_phone']=data['DDDCO2']
        helper['phone']=data['TELCO2']
        helper['address_district']=data['NOMBAI']
        helper['e-mail']=data['EMACAN']
        helper['natural_state']=data['ESTNAS']
        helper['state']=data['CODEST']
        ret.append(helper)

    return ret

#Define dados de vagas do senior para carreiras
def senior_to_carreiras_job(data_senior):
    ret=[]
    for data in data_senior:
        helper={}
        print(data)
        helper['name']=data['TITCAR']
        helper['cod_senior']=data['CODCAR']
        helper['cod_rqu_senior']=data['CODRQU']
        helper['cod_est_senior']=data['ESTCAR']
        helper['cod_hie_senior']=data['CODHIE']
        helper['start']=data['DATINI'].strftime('%Y-%m-%d')
        helper['end']=data['DATFIM'].strftime('%Y-%m-%d')
        helper['unit_id']=get_carreiras_unit_from_senior_code(data['CODFIL'],data['NUMEMP'])
        helper['period']=get_senior_period_from_code(data['TURRQU'])
        ret.append(helper)
    
    return ret

#Monta requisição com base na vaga, e seta a vaga como pai
def job_to_requisition(data):
    ret={}
    ret['name']=data['name']
    ret['cod_senior']=data['cod_senior']
    ret['cod_rqu_senior']=data['cod_rqu_senior']
    ret['cod_est_senior']=data['cod_est_senior']
    ret['cod_hie_senior']=data['cod_hie_senior']
    ret['start']=data['start']
    ret['end']=data['end']
    ret['unit_id']=data["unit"]
    
    return ret

#Define dados de unidades para o carreiras a partir das filiais no senior
def senior_to_carreiras_units(data_senior):
    ret=[]
    for data in data_senior:
        helper={}
        helper['name']=data['NOMFIL']
        helper['state']=get_senior_state_from_code(data['CODEST'])
        helper['city']=get_senior_city_from_code(data['CODCID'])
        helper['district']=get_senior_district_from_code(data['CODBAI'])
        helper['country']=get_senior_country_from_code(data['CODPAI'])
        helper['address']=data['ENDFIL']
        helper['zip']=data['CODCEP']
        helper['cod_senior']=data['CODFIL']
        helper['cod_emp_senior']=data['NUMEMP']
        helper['cnpj']=data['NUMCGC']
        ret.append(helper)

    return ret

#Completa vagas com dados da tabela de cargos, por padrão eles são obtidos da de requisições, que são as vagas em aberto
def senior_fill_job_data(jobs,oc_conn):
    all_jobs=[]
    for job in jobs:
        job_details=oc_select("SELECT TITCAR,CODHIE FROM R024CAR WHERE CODCAR='"+str(job["CODCAR"])+"' AND ESTCAR='"+str(job["ESTCAR"])+"'",oc_conn)
        job['TITCAR']=job_details[0]['TITCAR']
        job['CODHIE']=job_details[0]['CODHIE']
        all_jobs.append(job)

    return all_jobs



def string_and_strip(what):
    return re.sub("'|\"|-|`","",str(what))


#def exist_unit(unit_id,conn):
 #   got_unit=run_sql("SELECT id FROM lunellicarreiras.units WHERE cod_senior=")
  #  return 0

def mount_updates(key,value):
    return string_and_strip(key)+"='"+string_and_strip(value)+"'"

def import_units(units,conn):
    for unit in units:
        keys = ",".join(map(string_and_strip,list(unit.keys())))
        values = "','".join(map(string_and_strip,list(unit.values())))
        updates = ",".join(map(mount_updates,list(unit.keys()),list(unit.values())))
        sql="INSERT IGNORE INTO lunellicarreiras.units ("+keys+") VALUES ('"+values+"') ON DUPLICATE KEY UPDATE "+updates
        run_sql(sql,conn)


def import_jobs(jobs,conn):
    requisitions=[]
    for job in jobs:
        requisitions.append(job_to_requisition(job))
        keys = ",".join(map(string_and_strip,list(job.keys())))
        values = "','".join(map(string_and_strip,list(job.values())))
        updates = ",".join(map(mount_updates,list(job.keys()),list(job.values())))
        sql="INSERT IGNORE INTO lunellicarreiras.jobs ("+keys+") VALUES ('"+values+"') ON DUPLICATE KEY UPDATE "+updates
        run_sql(sql,conn)

    import_requisitions(requisitions,conn)

def import_requisitions(jobs,conn):
    for job in jobs:
        keys = ",".join(map(string_and_strip,list(job.keys())))
        values = "','".join(map(string_and_strip,list(job.values())))
        updates = ",".join(map(mount_updates,list(job.keys()),list(job.values())))
        sql="INSERT IGNORE INTO lunellicarreiras.requisitions ("+keys+") VALUES ('"+values+"') ON DUPLICATE KEY UPDATE "+updates
        run_sql(sql,conn)

def import_candidates(candidates,conn):
    for candidate in candidates:
        keys = ",".join(map(string_and_strip,list(candidate.keys())))
        values = "','".join(map(string_and_strip,list(candidate.values())))
        updates = ",".join(map(mount_updates,list(candidate.keys()),list(candidate.values())))
        sql="INSERT IGNORE INTO lunellicarreiras.candidates ("+keys+") VALUES ('"+values+"') ON DUPLICATE KEY UPDATE "+updates
        run_sql(sql,conn)

def update_senior_sync(conn):
    sql="UPDATE lunellicarreiras.senior_sync SET last_sync=DATE_SUB(NOW(), INTERVAL 3 HOUR) WHERE type='import'"
    run_sql(sql,conn)

if __name__ == "__main__":
    #Instancia Conexões Principais
    main_sql_conn=sql_conn()
    main_oc_conn=oc_conn()

    #Obtém data do ultimo sync de importação ativo
    last_sync=sql_select("SELECT last_sync FROM senior_sync WHERE type='import' AND active=1",main_sql_conn)
    if last_sync[0]['last_sync']==None:
        last_sync[0]['last_sync']=datetime.strptime('2021-05-01','%Y-%m-%d')
   
    #Unidades, pego somente as que tem requisição recente.
    units_senior=oc_select("SELECT DISTINCT R030FIL.* FROM R030FIL INNER JOIN R126RQU ON R126RQU.CODFIL=R030FIL.CODFIL AND R126RQU.NUMEMP=R030FIL.NUMEMP WHERE R030FIL.NUMEMP IN (1,2,3,4,5,12,20) AND R126RQU.DATRQU>='"+last_sync[0]['last_sync'].strftime('%Y-%m-%d')+"' AND SITRQU IN ('0','1')",main_oc_conn)
    units_carreiras=senior_to_carreiras_units(units_senior)
    import_units(units_carreiras,main_sql_conn)
    
    #Candidatos
    #candidate_senior=oc_select("SELECT * from R122CEX WHERE DATINC >= '"+last_sync[0]['last_sync'].strftime('%Y-%m-%d')+"' ",main_oc_conn)
    #candidates_carreiras=senior_to_carreiras_candidate(candidate_senior)
    #import_candidates(candidates_carreiras,main_sql_conn)

    #Vagas
    job_senior=oc_select("SELECT * FROM R126RQU WHERE DATRQU>='"+last_sync[0]['last_sync'].strftime('%Y-%m-%d')+"' AND SITRQU IN('0','1')",main_oc_conn)
    full_job=senior_fill_job_data(job_senior,main_oc_conn)
    jobs_carreiras=senior_to_carreiras_job(full_job)
    import_jobs(jobs_carreiras,main_sql_conn)
 
    #Atualiza controle de sincronizador
    update_senior_sync(main_sql_conn)

    #Fecha as conexões principais
    main_oc_conn.close()
    main_sql_conn.close()
