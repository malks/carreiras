from oracle_conn import run_select as oc_select, run_insert as oc_insert, run_sql as oc_sql, new_conn as oc_conn
from mysql_connection import run_select as sql_select,run_sql,new_conn as sql_conn
from datetime import datetime
import re

if __name__ == "__main__":
    #Instancia Conexões Principais
    main_sql_conn=sql_conn()
    main_oc_conn=oc_conn()

    exported=sql_select("SELECT candidates.*  FROM candidates where candidates.senior_num_can IS NOT NULL",main_sql_conn)
    
    for cnd in exported:
        sql="SELECT * FROM R122CEX WHERE NUMCAN="+cnd["NUMCAN"]
        ret=oc_select(sql,main_oc_conn)
        print(ret)


    #Fecha as conexões principais
    main_oc_conn.close()
    main_sql_conn.close()
