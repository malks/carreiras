from oracle_conn import run_select as oc_select, run_sql as oc_sql, new_conn as oc_conn
from mysql_connection import run_select as sql_select,run_sql,new_conn as sql_conn
from datetime import datetime
import re

if __name__ == "__main__":
    main_sql_conn=sql_conn()
    main_oc_conn=oc_conn()

    employees=oc_select("SELECT * FROM R034FUN",main_oc_conn)
    if len(employees)>0:
        sql_select("TRUNCATE lunellicarreiras.employees",main_sql_conn)
        for emp in employees:
            insert_carreiras="INSERT INTO lunellicarreiras.employees (name,senior_num_cad,senior_num_emp,senior_cod_fil,senior_tip_col) VALUES('"+str(emp["NOMFUN"])+"','"+str(emp["NUMCAD"])+"','"+str(emp["NUMEMP"])+"','"+str(emp["CODFIL"])+"','"+str(emp["TIPCOL"])+"')"
            run_sql(insert_carreiras,main_sql_conn)