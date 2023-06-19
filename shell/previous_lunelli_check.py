from othersql_connection import run_select as sql_select,run_sql,new_conn as sql_conn
from datetime import datetime
import re

if __name__ == "__main__":
    #Instancia Conexões Principais
    main_sql_conn=sql_conn()
    other_sql_conn=other_conn()

    candidates=sql_select("SELECT ca.id,c.nome,c.cpf,c.nomeFilial,c.cadastro,c.cargo,c.createdAt,ca.name,ca.cpf,ca.senior_num_can,ca.previous_lunelli_cad,ca.previous_lunelli_unit,ca.previous_lunelli_job,ca.previous_lunelli_date  FROM b2blunender.Colaborador c JOIN lunellicarreiras.candidates ca ON ca.cpf=c.cpf WHERE ca.previous_lunelli_cad IS NULL AND ca.senior_num_can IS NULL AND ca.cpf IS NOT NULL AND ca.cpf!=''",main_sql_conn)
    
    for cnd in candidates:
        sql="UPDATE candidates SET previous_lunelli_cad='"+str(cnd["cadastro"])+"',previous_lunelli_unit='"+str(cnd["nomeFilial"])+"',previous_lunelli_job='"+str(cnd["cargo"])+"',previous_lunelli_date='"+str(cnd["createdAt"])+"',updated_at=updated_at WHERE id='"+str(cnd["id"])+"'"
        run_sql(sql,main_sql_conn)
        addtagsql="INSERT IGNORE INTO candidates_tagsrh (candidate_id,tag_id,created_at,_updated_at) VALUES('"+str(cnd["id"])+"',5,now(),now())"
        run_sql(addtagsql,main_sql_conn)

    #Fecha as conexões principais
    main_sql_conn.close()