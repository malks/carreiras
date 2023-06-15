from mysql_connection import run_select as sql_select,run_sql,new_conn as sql_conn
from datetime import datetime
import re

if __name__ == "__main__":
    #Instancia Conexões Principais
    main_sql_conn=sql_conn()

    candidates=sql_select("SELECT candidates.*  FROM candidates WHERE candidates.senior_num_can IS NOT NULL",main_sql_conn)
    
    for cnd in candidates:
        sql="UPDATE candidates SET senior_num_can='"+str(cnd["senior_num_can"])+"',updated_at=updated_at WHERE senior_num_can IS NULL AND cpf='"+str(cnd["cpf"])+"'"
        run_sql(sql,main_sql_conn)

    duplicandidates=sql_select("SELECT cpf,COUNT(DISTINCT id) AS amt FROM candidates WHERE cpf IS NOT NULL AND cpf!='' GROUP BY cpf HAVING amt>1")

    for dcnd in duplicandidates:
        sql="UPDATE candidates SET duplicate_cpf=1,updated_at=updated_at WHERE cpf='"+str(dcnd["cpf"])+"'"
        run_sql(sql,main_sql_conn)

    #Fecha as conexões principais
    main_sql_conn.close()