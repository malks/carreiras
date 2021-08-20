from typing import Dict
from oracle_conn import run_select as oc_select, new_conn as oc_conn
from mysql_connection import run_select as sql_select,run_sql,new_conn as sql_conn
from datetime import datetime

#Conversor de senior para carreiras dados de Candidato
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

    


if __name__ == "__main__":
    main_sql_conn=sql_conn()
    last_sync=sql_select("SELECT last_sync FROM senior_sync WHERE type='import' AND active=1",main_sql_conn)
    print(last_sync)

    main_oc_conn=oc_conn()
    #candidate_senior=oc_select("SELECT * from R122CEX WHERE DATINC >= '"+last_sync[0]['last_sync'].strftime('%Y-%m-%d')+"' AND ROWNUM<10",main_oc_conn)
    #candidate_carreiras=senior_to_carreiras_candidate(candidate_senior)
    #print(candidate_carreiras)

    #job_senior=oc_select("SELECT * from R126RQU WHERE DATINC >= '"+last_sync[0]['last_sync'].strftime('%Y-%m-%d')+"' AND ROWNUM<10",main_oc_conn)

    #test=oc_select("SELECT * FROM R074PAI WHERE ROWNUM<10",main_oc_conn)
    #print(test)
    main_oc_conn.close()
