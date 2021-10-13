from mysql_connection import run_select as sql_select,run_sql,new_conn as sql_conn
from datetime import datetime
import re



if __name__ == "__main__":
    #Instancia Conexões Principais
    main_sql_conn=sql_conn()

    #Desativa vagas fora de período de recrutamento
    run_sql("UPDATE lunellicarreiras.jobs SET lunellicarreiras.jobs.status=0 WHERE lunellicarreiras.jobs.status=1 AND NOW() NOT BETWEEN lunellicarreiras.jobs.start AND lunellicarreiras.jobs.end",main_sql_conn)
